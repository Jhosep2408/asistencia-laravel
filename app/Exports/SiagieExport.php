<?php

namespace App\Exports;

use App\Models\Student;
use App\Models\Holiday;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Carbon\Carbon;

class SiagieExport implements FromCollection, WithHeadings, WithTitle, WithStyles, WithColumnWidths, WithEvents
{
    protected $students;
    protected $month;
    protected $year;
    protected $auxiliarName;
    protected $grade;
    protected $section;
    protected $holidays;

    public function __construct($students, $month, $year, $auxiliarName, $grade, $section)
    {
        $this->students = $students;
        $this->month = $month;
        $this->year = $year;
        $this->auxiliarName = $auxiliarName;
        $this->grade = $grade;
        $this->section = $section;
        
        // Obtener feriados para el mes
        $this->holidays = $this->getHolidaysForMonth();
        $this->generateMonthStructure();
    }

    protected function getHolidaysForMonth()
    {
        $startDate = Carbon::create($this->year, $this->month, 1)->startOfMonth();
        $endDate = Carbon::create($this->year, $this->month, 1)->endOfMonth();
        
        return Holiday::whereBetween('date', [$startDate, $endDate])
            ->get()
            ->keyBy(function($holiday) {
                return (int)Carbon::parse($holiday->date)->day;
            });
    }

 public function collection()
    {
        $days = array_keys($this->daysData ?? []);
        $studentDnis = $this->students->pluck('dni')->toArray();

        $attendancesByStudent = [];
        try {
            $from = Carbon::create($this->year, $this->month, 1)->startOfMonth()->toDateString();
            $to = Carbon::create($this->year, $this->month, 1)->endOfMonth()->toDateString();

            $att = \App\Models\Attendance::whereIn('student_dni', $studentDnis)
                    ->whereBetween('date', [$from, $to])
                    ->get();

            foreach ($att as $a) {
                $d = (int)Carbon::parse($a->date)->day;
                $attendancesByStudent[$a->student_dni][$d] = $a->status;
            }
        } catch (\Exception $e) {
            \Log::warning('No se pudieron cargar asistencias para export SIAGIE: ' . $e->getMessage());
        }

        // Mapeo de estados a letras - AGREGAR 'H' PARA FERIADOS
        $statusMap = [
            'present' => 'P',
            'absent' => 'F',
            'justified' => 'J',
            'late' => 'T',
        ];

        return $this->students->map(function($student, $index) use ($days, $attendancesByStudent, $statusMap) {
            $row = [];
            $row[] = $index + 1;
            $row[] = trim(($student->last_name ?? '') . ' ' . ($student->first_name ?? ''));

            foreach ($days as $day) {
                $val = '';
                $dni = $student->dni ?? null;
                
                // VERIFICAR SI ES FERIADO
                if (isset($this->holidays[$day])) {
                    $holiday = $this->holidays[$day];
                    if ($holiday->no_classes) {
                        $val = 'H'; // H para Feriado (Holiday)
                    } else {
                        // Si es feriado pero hay clases, usar la asistencia normal
                        if ($dni && isset($attendancesByStudent[$dni][$day])) {
                            $status = $attendancesByStudent[$dni][$day];
                            $val = $statusMap[$status] ?? '';
                        }
                    }
                } else {
                    // Día normal
                    if ($dni && isset($attendancesByStudent[$dni][$day])) {
                        $status = $attendancesByStudent[$dni][$day];
                        $val = $statusMap[$status] ?? '';
                    }
                }
                
                $row[] = $val;
            }

            return $row;
        });
    }

    public function headings(): array
    {
        // Devolver encabezados generados dinámicamente
        return $this->headingsData ?? [];
    }

    public function title(): string
    {
        return 'SIAGIE';
    }

    public function styles(Worksheet $sheet)
    {
        $lastRow = $this->students->count() + count($this->headingsData);
        $totalDays = count($this->daysData ?? []);
        $totalColumns = 2 + $totalDays; // A,B + days
    $lastCol = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($totalColumns);
    $colGrade = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($totalColumns - 1);
    $colMonth = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($totalColumns);

        // Estilos para el título principal (A1: lastCol)
        try {
            $sheet->mergeCells('A1:' . $lastCol . '1');
        } catch (\Exception $e) {}
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A1')->getAlignment()->setVertical('center');

    // Estilos para la información del auxiliar (B3)
    $sheet->getStyle('B3')->getFont()->setBold(true)->setSize(12);
    $sheet->getStyle($colGrade . '3')->getFont()->setBold(true)->setSize(12);
    $sheet->getStyle($colMonth . '3')->getFont()->setBold(true)->setSize(12);
    $sheet->getStyle('A3:' . $lastCol . '3')->getAlignment()->setHorizontal('left');

    // Estilos para encabezados de semanas: se aplicarán merges dinámicos en registerEvents()
    $sheet->getStyle('C5:' . $lastCol . '5')->getFont()->setBold(true)->setSize(11);
    $sheet->getStyle('C5:' . $lastCol . '5')->getAlignment()->setHorizontal('center');
    $sheet->getStyle('C5:' . $lastCol . '5')->getAlignment()->setVertical('center');

    // Estilos para días de la semana (fila 6)
    $sheet->getStyle('C6:' . $lastCol . '6')->getFont()->setBold(true)->setSize(10);
    $sheet->getStyle('C6:' . $lastCol . '6')->getAlignment()->setHorizontal('center');
    $sheet->getStyle('C6:' . $lastCol . '6')->getAlignment()->setVertical('center');

    // Estilos para encabezados de estudiantes (A8:lastCol)
    $sheet->getStyle('A8:' . $lastCol . '8')->getFont()->setBold(true)->setSize(10);
    $sheet->getStyle('A8:' . $lastCol . '8')->getAlignment()->setHorizontal('center');
    $sheet->getStyle('A8:' . $lastCol . '8')->getAlignment()->setVertical('center');
        
    // Centrar todas las celdas de días (C9: lastCol + lastRow)
    $sheet->getStyle("C9:{$lastCol}{$lastRow}")->getAlignment()->setHorizontal('center');
    $sheet->getStyle("C9:{$lastCol}{$lastRow}")->getAlignment()->setVertical('center');

        // Centrar números de estudiantes
        $sheet->getStyle("A9:A{$lastRow}")->getAlignment()->setHorizontal('center');
        $sheet->getStyle("A9:A{$lastRow}")->getAlignment()->setVertical('center');

        // Alinear nombres a la izquierda
        $sheet->getStyle("B9:B{$lastRow}")->getAlignment()->setHorizontal('left');
        $sheet->getStyle("B9:B{$lastRow}")->getAlignment()->setVertical('center');

        // Aplicar bordes a toda la tabla de estudiantes
        $sheet->getStyle("A8:{$lastCol}{$lastRow}")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ]);

        // Aplicar bordes a los encabezados de semanas
        $sheet->getStyle('C5:' . $lastCol . '6')->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ]);

        // Altura de filas
        $sheet->getRowDimension(1)->setRowHeight(30); // Título
        $sheet->getRowDimension(3)->setRowHeight(25); // Información auxiliar
        $sheet->getRowDimension(5)->setRowHeight(25); // Semanas
        $sheet->getRowDimension(6)->setRowHeight(20); // Días
        $sheet->getRowDimension(8)->setRowHeight(25); // Encabezados estudiantes
        
        // Altura para filas de estudiantes
        for ($i = 9; $i <= $lastRow; $i++) {
            $sheet->getRowDimension($i)->setRowHeight(20);
        }

        return [];
    }

    public function columnWidths(): array
    {
        $widths = [
            'A' => 6,
            'B' => 35,
        ];

        $totalDays = count($this->daysData ?? []);
        $totalColumns = 2 + $totalDays; // A,B + days

        for ($col = 3; $col <= $totalColumns; $col++) {
            $colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col);
            $widths[$colLetter] = 5;
        }

        // Si existe la semana 3, intentamos ampliar la(s) columna(s) donde se coloca el mes
        try {
            if (isset($this->weeks[2])) {
                // calcular inicio de la semana 3 (índice de columna 1-based)
                $startCol = 3; // columna C
                $startCol += count($this->weeks[0] ?? []);
                $startCol += count($this->weeks[1] ?? []);
                $span3 = count($this->weeks[2]);
                $monthColIndex = $startCol + $span3; // columna donde colocamos el mes (1-based)

                // si está dentro del rango, ampliar hasta 3 columnas para mostrar el mes
                $lastColIndex = $totalColumns;
                if ($monthColIndex <= $lastColIndex) {
                    $monthSpan = min(3, $lastColIndex - $monthColIndex + 1);
                    for ($i = 0; $i < $monthSpan; $i++) {
                        $colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($monthColIndex + $i);
                        $widths[$colLetter] = 12;
                    }
                }
            }
        } catch (\Exception $e) {
            // ignore
        }

        return $widths;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                // Obtener la hoja
                $sheet = $event->sheet->getDelegate();
                
                // Aplicar formato adicional si es necesario
                $lastRow = $this->students->count() + 8;
                
                // Calcular lastCol dinámico
                $totalDaysLocal = count($this->daysData ?? []);
                $lastColLocal = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(2 + $totalDaysLocal);

                // Hacer que los encabezados sean más visibles
                $sheet->getStyle('A8:' . $lastColLocal . '8')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
                $sheet->getStyle('A8:' . $lastColLocal . '8')->getFill()->getStartColor()->setARGB('FFE6E6FA'); // Color lavanda claro
                
                // Color para encabezados de semanas (C5:lastCol)
                $sheet->getStyle('C5:' . $lastColLocal . '6')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
                $sheet->getStyle('C5:' . $lastColLocal . '6')->getFill()->getStartColor()->setARGB('FFF0F8FF'); // Color azul claro

                // Insertar logo en A1 (si existe)
                try {
                    $logoPath = base_path('public/images/Logo.png');
                    if (file_exists($logoPath)) {
                        $drawing = new Drawing();
                        $drawing->setName('Logo');
                        $drawing->setPath($logoPath);
                        $drawing->setHeight(48);
                        $drawing->setCoordinates('A1');
                        $drawing->setOffsetX(5);
                        $drawing->setOffsetY(3);
                        $drawing->setWorksheet($sheet);
                    }
                } catch (\Exception $e) {
                    \Log::warning('No se pudo insertar logo en SIAGIE export: ' . $e->getMessage());
                }

                // Merge y estilo del título principal A1:lastCol
                try {
                    $lastCol = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(2 + count($this->daysData));
                    $sheet->mergeCells('A1:' . $lastCol . '1');
                    $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16)->setUnderline(true);
                    $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                } catch (\Exception $e) {}

                // Merge AUXILIAR (B3 to column before C) with fondo salmón y centrado vertical
                try {
                    $sheet->mergeCells('B3:B3');
                    $sheet->getStyle('B3')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                          ->getStartColor()->setARGB('FFFFDAB9');
                    $sheet->getStyle('B3')->getFont()->setBold(true)->setSize(12);
                    $sheet->getStyle('B3')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                } catch (\Exception $e) {}

                // Alternancia gris/blanco por columna a partir de C (C9..)
                try {
                    $startColIndex = 3; // columna C
                    $col = $startColIndex;
                    $isGray = true;
                    foreach ($this->daysData as $d) {
                        $colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col);
                        $range = $colLetter . '9:' . $colLetter . $lastRow;
                        if ($isGray) {
                            $sheet->getStyle($range)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                                  ->getStartColor()->setARGB('FFDCDCDC');
                        }
                        $isGray = !$isGray;
                        $col++;
                    }
                } catch (\Exception $e) {
                    // ignore
                }

                // Merge week label ranges dynamically using $this->weeks
                try {
                    $colStart = 3; // C
                    foreach ($this->weeks as $i => $week) {
                        $span = count($week);
                        $startLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colStart);
                        $endLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colStart + $span - 1);
                        $sheet->mergeCells($startLetter . '5:' . $endLetter . '5');
                        // Center week label
                        $sheet->getStyle($startLetter . '5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                        $colStart += $span;
                    }
                } catch (\Exception $e) {}

                // If week 3 exists, merge and style the grade+section above that week and month to its right
                try {
                    if (isset($this->weeks[2])) {
                        // compute start column index for week 3
                        $colStartWeek3 = 3; // C
                        $colStartWeek3 += count($this->weeks[0] ?? []);
                        $colStartWeek3 += count($this->weeks[1] ?? []);
                        $span3 = count($this->weeks[2]);
                        $startLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colStartWeek3);
                        $endLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colStartWeek3 + $span3 - 1);
                        // merge grade cell across the full week3 span on row 3
                        $sheet->mergeCells($startLetter . '3:' . $endLetter . '3');
                        $sheet->getStyle($startLetter . '3')->getFont()->setBold(true)->setSize(12);
                        $sheet->getStyle($startLetter . '3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                        // place month to the right of week3 span if possible and style (handled earlier)
                        $monthColIndex = $colStartWeek3 + $span3; // 1-based
                        $lastColIndex = 2 + $totalDaysLocal; // last column index (1-based)
                        if ($monthColIndex > $lastColIndex) {
                            $monthColIndex = $lastColIndex;
                        }

                        $monthSpan = max(1, min(3, $lastColIndex - $monthColIndex + 1));
                        $monthStartLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($monthColIndex);
                        $monthEndLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($monthColIndex + $monthSpan - 1);

                        $sheet->mergeCells($monthStartLetter . '3:' . $monthEndLetter . '3');
                        $sheet->getStyle($monthStartLetter . '3:' . $monthEndLetter . '3')->getFont()->setBold(true)->setSize(12)->getColor()->setARGB('FF000000');
                        $sheet->getStyle($monthStartLetter . '3:' . $monthEndLetter . '3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                        // aumentar ancho de las columnas del mes para asegurar que se vea completo
                        for ($ci = $monthColIndex; $ci <= ($monthColIndex + $monthSpan - 1); $ci++) {
                            $colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($ci);
                            try {
                                $sheet->getColumnDimension($colLetter)->setWidth(12);
                            } catch (\Exception $e) {}
                        }
                    } else {
                        // Si no existe la semana 3, fusionar y centrar el texto combinado colocado en C3
                        $totalCols = 2 + $totalDaysLocal;
                        $startIdx = 3; // C
                        $span = min(3, max(1, $totalCols - $startIdx + 1));
                        $startLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($startIdx);
                        $endLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($startIdx + $span - 1);
                        try {
                            $sheet->mergeCells($startLetter . '3:' . $endLetter . '3');
                            $sheet->getStyle($startLetter . '3')->getFont()->setBold(true)->setSize(12);
                            $sheet->getStyle($startLetter . '3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                            // asegurarnos del ancho
                            for ($ci = $startIdx; $ci <= ($startIdx + $span - 1); $ci++) {
                                $colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($ci);
                                try { $sheet->getColumnDimension($colLetter)->setWidth(12); } catch (\Exception $e) {}
                            }
                        } catch (\Exception $e) {}
                    }
                } catch (\Exception $e) {}

                // Centrar y colorear el texto central de grado (columna AE según diseño)
                try {
                    $sheet->getStyle('AE1')->getFont()->getColor()->setARGB('FFFF0000');
                    $sheet->getStyle('AE1')->getFont()->setBold(true)->setSize(14);
                } catch (\Exception $e) {}

                // Colorear celdas de días según la letra: P=verde, F=rojo, J=celeste, T=amarillo
                try {
                    $studentCount = $this->students->count();
                    $startRow = 9; // primera fila de estudiantes
                    $totalDays = count($this->daysData ?? []);

                     $colorMap = [
                    'P' => 'FF00B050', // verde
                    'F' => 'FFFF0000', // rojo
                    'J' => 'FFADD8E6', // celeste (light blue)
                    'T' => 'FFFFFF00', // amarillo
                    'H' => 'FFFFA500', // NARANJA PARA FERIADOS
                ];

                    for ($i = 0; $i < $studentCount; $i++) {
                    $rowNum = $startRow + $i;
                    for ($d = 0; $d < $totalDays; $d++) {
                        $colIndex = 3 + $d;
                        $colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex);
                        $cell = $colLetter . $rowNum;
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
                }
                 // AGREGAR LEYENDA PARA FERIADOS
                $legendRow = $lastRow + 2;
                $sheet->setCellValue('A' . $legendRow, 'LEYENDA:');
                $sheet->getStyle('A' . $legendRow)->getFont()->setBold(true);
                
                $legend = [
                    'P = Presente',
                    'F = Falta', 
                    'T = Tardanza',
                    'J = Justificado',
                    'H = Feriado (No hubo clases)'
                ];
                
                foreach ($legend as $index => $text) {
                    $sheet->setCellValue('A' . ($legendRow + 1 + $index), $text);
                }
                
                } catch (\Exception $e) {
                    \Log::warning('Error aplicando colores en SIAGIE export: ' . $e->getMessage());
                }
            },
        ];
    }

    /**
     * Genera la estructura de semanas y días para el mes especificado
     * Solo incluye días hábiles (lunes-viernes). Construye $this->daysData
     * y $this->headingsData usadas por headings() y collection().
     */
    private function generateMonthStructure()
    {
        $monthNames = [
            1 => 'ENERO', 2 => 'FEBRERO', 3 => 'MARZO', 4 => 'ABRIL',
            5 => 'MAYO', 6 => 'JUNIO', 7 => 'JULIO', 8 => 'AGOSTO',
            9 => 'SETIEMBRE', 10 => 'OCTUBRE', 11 => 'NOVIEMBRE', 12 => 'DICIEMBRE'
        ];

        $monthName = $monthNames[$this->month] ?? '';

        $daysInMonth = Carbon::create($this->year, $this->month, 1)->daysInMonth;

    $weeks = [];
        $currentWeek = [];

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = Carbon::create($this->year, $this->month, $day);
            $dow = $date->dayOfWeek; // 0=Sun,1=Mon..6=Sat
            if ($dow >= 1 && $dow <= 5) {
                $currentWeek[] = $day;
                // If Friday or last weekday, close week
                if ($dow === 5) {
                    $weeks[] = $currentWeek;
                    $currentWeek = [];
                }
            }
        }
        if (!empty($currentWeek)) {
            $weeks[] = $currentWeek;
        }

        // Store weeks and build daysData as flat list of days in order
        $this->weeks = $weeks;
        $this->daysData = [];
        foreach ($weeks as $w) {
            foreach ($w as $d) {
                $this->daysData[$d] = $d;
            }
        }

        // Build headingsData: rows as arrays of length 2 + count(days)
        $totalColumns = 2 + count($this->daysData);
        $emptyRow = array_fill(0, $totalColumns, '');

        // Row 1: title
        $row1 = $emptyRow;
        $row1[0] = 'REGISTRO DE ASISTENCIA';

        // Row2: empty
        $row2 = $emptyRow;

        // Row3: AUXILIAR in B. Grade/section and month will be positioned
        // above the SEMANA 3 span if exists; otherwise centered across days.
        $row3 = $emptyRow;
        $row3[1] = 'AUXILIAR: ' . $this->auxiliarName;

        // Row4: empty
        $row4 = $emptyRow;

        // Row5: weeks labels (start at index 2 -> column C)
        $row5 = $emptyRow;
        $colIndex = 2;
        foreach ($weeks as $i => $week) {
            $row5[$colIndex] = 'SEMANA ' . ($i + 1);
            // leave next (count($week)-1) cells empty for the week span
            $colIndex += count($week);
        }

        // Row6: weekday letters repeated under each week
        $row6 = $emptyRow;
        $colIndex = 2;
        foreach ($weeks as $week) {
            foreach ($week as $d) {
                $dow = Carbon::create($this->year, $this->month, $d)->dayOfWeek;
                $letters = [1 => 'L', 2 => 'M', 3 => 'W', 4 => 'J', 5 => 'V'];
                $row6[$colIndex] = $letters[$dow] ?? '';
                $colIndex++;
            }
        }

        // Row7: empty
        $row7 = $emptyRow;

        // Row8: headers: N°, APELLIDOS Y NOMBRES, then day numbers in order
        $row8 = ['N°', 'APELLIDOS Y NOMBRES'];
        foreach ($this->daysData as $d) {
            $row8[] = $d;
        }

    // Try to position grade+section above week 3 (index 2) if exists
    if (isset($weeks[2])) {
            // compute start index for week 3 (column index in row arrays)
            $start = 2; // C index
            for ($w = 0; $w < 2; $w++) {
                $start += count($weeks[$w]);
            }
            $span = count($weeks[2]);
            // place grade+section at start of the week 3 span
            if ($start < $totalColumns) {
                $row3[$start] = $this->grade . ' "' . $this->section . '"';
            }
            // place month to the right of the week3 span if space, else at last column
            $monthPos = $start + $span;
            if ($monthPos < $totalColumns) {
                $row3[$monthPos] = $monthName;
            } else {
                $row3[$totalColumns - 1] = $monthName;
            }
        }

        // If week 3 does not exist, centre grade+section and month across the days area
        if (!isset($weeks[2])) {
            // place a combined text in the first day column (C) as a marker; registerEvents will merge and center
            $combined = $this->grade . ' "' . $this->section . '" - ' . $monthName;
            if ($totalColumns >= 3) {
                $row3[2] = $combined;
            } else {
                // fallback to last column if no day columns
                $row3[$totalColumns - 1] = $combined;
            }
        }

        $this->headingsData = [
            $row1,
            $row2,
            $row3,
            $row4,
            $row5,
            $row6,
            $row7,
            $row8
        ];
    }
}