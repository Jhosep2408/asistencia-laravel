<?php

namespace App\Exports;

use App\Models\Attendance;
use App\Models\Student;
use App\Models\Holiday;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StudentAttendanceExport implements FromCollection, WithHeadings, WithTitle, WithStyles, WithColumnWidths, WithEvents
{
    protected $studentDni;
    protected $dateFrom;
    protected $dateTo;
    protected $holidays;

    protected $days = [];
    protected $weeks = [];

    public function __construct($data)
    {
        $this->studentDni = $data['student_dni'];
        $this->dateFrom = Carbon::parse($data['date_from'])->startOfDay();
        $this->dateTo = Carbon::parse($data['date_to'])->endOfDay();
        
        // OBTENER FERIADOS
        $this->holidays = Holiday::whereBetween('date', [
            $this->dateFrom->toDateString(),
            $this->dateTo->toDateString()
        ])->get()->keyBy(function($holiday) {
            return (int)Carbon::parse($holiday->date)->day;
        });

        $this->generateDays();
    }

    private function generateDays()
    {
        $current = $this->dateFrom->copy();
        $week = [];
        while ($current->lte($this->dateTo)) {
            $dow = $current->dayOfWeek; // 0=Sun .. 6=Sat
            if ($dow >= 1 && $dow <= 5) {
                $week[] = ['date' => $current->toDateString(), 'day' => (int)$current->day, 'dow' => $dow];
            }

            if ($dow === 5) {
                if (!empty($week)) {
                    $this->weeks[] = $week;
                    $week = [];
                }
            }

            $current->addDay();
        }
        if (!empty($week)) {
            $this->weeks[] = $week;
        }

        foreach ($this->weeks as $w) {
            foreach ($w as $d) {
                $this->days[] = $d;
            }
        }
    }

       public function collection()
    {
        $student = Student::where('dni', $this->studentDni)->with(['grade','classroom'])->first();

        $att = Attendance::where('student_dni', $this->studentDni)
            ->whereBetween('date', [$this->dateFrom->toDateString(), $this->dateTo->toDateString()])
            ->get()
            ->keyBy(function($a) { 
                return (int)Carbon::parse($a->date)->day; 
            });

        $row = [];
        $row[] = $student->dni ?? '';
        $row[] = $student->full_name ?? trim(($student->first_name ?? '') . ' ' . ($student->last_name ?? ''));
        $row[] = $student->grade->name ?? '';
        $row[] = $student->classroom->name ?? '';

        $statusMap = [
            'present' => 'P',
            'absent' => 'F',
            'justified' => 'J',
            'late' => 'T',
        ];

        foreach ($this->days as $d) {
            $dayNum = $d['day'];
            $val = '';
            
            // VERIFICAR SI ES FERIADO
            if (isset($this->holidays[$dayNum])) {
                $holiday = $this->holidays[$dayNum];
                if ($holiday->no_classes) {
                    $val = 'H'; // H para Feriado
                } else {
                    // Si es feriado pero hay clases
                    if (isset($att[$dayNum])) {
                        $val = $statusMap[$att[$dayNum]->status] ?? '';
                    }
                }
            } else {
                // Día normal
                if (isset($att[$dayNum])) {
                    $val = $statusMap[$att[$dayNum]->status] ?? '';
                }
            }
            
            $row[] = $val;
        }

        return collect([$row]);
    }


    public function headings(): array
    {
        $head = ['DNI', 'NOMBRE', 'GRADO', 'SECCIÓN'];
        foreach ($this->days as $d) {
            $head[] = Carbon::parse($d['date'])->format('d');
        }
        return $head;
    }

    public function title(): string
    {
        return 'ASISTENCIA_ESTUDIANTE';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }

    public function columnWidths(): array
    {
        $widths = [
            'A' => 12,
            'B' => 30,
            'C' => 12,
            'D' => 10,
        ];

        $col = 5; // E
        foreach ($this->days as $d) {
            $letter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col);
            $widths[$letter] = 5;
            $col++;
        }

        return $widths;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                $startRow = 2;
                $startCol = 5;
                $totalDays = count($this->days);

                // ACTUALIZAR MAPA DE COLORES CON FERIADOS
                $colorMap = [
                    'P' => 'FF00B050',
                    'F' => 'FFFF0000',
                    'J' => 'FFADD8E6',
                    'T' => 'FFFFFF00',
                    'H' => 'FFFFA500', // NARANJA PARA FERIADOS
                ];

                for ($d = 0; $d < $totalDays; $d++) {
                    $colIndex = $startCol + $d;
                    $colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex);
                    $cell = $colLetter . $startRow;
                    try {
                        $val = (string)$sheet->getCell($cell)->getValue();
                    } catch (\Exception $e) {
                        $val = '';
                    }
                    $val = trim($val);
                    if ($val !== '' && isset($colorMap[$val])) {
                        $sheet->getStyle($cell)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                            ->getStartColor()->setARGB($colorMap[$val]);
                    }
                }

                // AGREGAR LEYENDA
                $legendRow = $startRow + 2;
                $sheet->setCellValue('A' . $legendRow, 'LEYENDA:');
                $sheet->getStyle('A' . $legendRow)->getFont()->setBold(true);
                
                $legend = [
                    'P = Presente',
                    'F = Falta', 
                    'T = Tardanza',
                    'J = Justificado',
                    'H = Feriado'
                ];
                
                foreach ($legend as $index => $text) {
                    $sheet->setCellValue('A' . ($legendRow + 1 + $index), $text);
                }
            }
        ];
    }
}