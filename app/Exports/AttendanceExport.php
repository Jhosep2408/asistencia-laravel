<?php

namespace App\Exports;

use App\Models\Attendance;
use App\Models\Holiday;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AttendanceExport implements FromCollection, WithHeadings, WithMapping
{
    protected $filters;
    protected $holidays;

    public function __construct($filters)
    {
        $this->filters = $filters;
        // Obtener feriados para el rango de fechas
        $this->holidays = $this->getHolidays();
    }

    protected function getHolidays()
    {
        if (!empty($this->filters['date_from']) && !empty($this->filters['date_to'])) {
            return Holiday::whereBetween('date', [
                $this->filters['date_from'],
                $this->filters['date_to']
            ])->get()->keyBy('date');
        }
        return collect();
    }

    public function collection()
    {
        $query = Attendance::with(['student', 'student.grade', 'student.classroom']);

        if (!empty($this->filters['search'])) {
            $query->whereHas('student', function($q) {
                $q->where('full_name', 'like', '%' . $this->filters['search'] . '%')
                  ->orWhere('dni', 'like', '%' . $this->filters['search'] . '%');
            });
        }

        if (!empty($this->filters['grade_id'])) {
            $query->whereHas('student', function($q) {
                $q->where('grade_id', $this->filters['grade_id']);
            });
        }

        if (!empty($this->filters['classroom_id'])) {
            $query->whereHas('student', function($q) {
                $q->where('classroom_id', $this->filters['classroom_id']);
            });
        }

        if (!empty($this->filters['date_from'])) {
            $query->whereDate('created_at', '>=', $this->filters['date_from']);
        }

        if (!empty($this->filters['date_to'])) {
            $query->whereDate('created_at', '<=', $this->filters['date_to']);
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'Fecha',
            'Tipo de Día',
            'Motivo Feriado',
            'DNI',
            'Estudiante',
            'Grado',
            'Sección',
            'Hora',
            'Estado'
        ];
    }

    public function map($attendance): array
    {
        // Verificar si es feriado
        $isHoliday = $this->holidays->has($attendance->date);
        $holiday = $isHoliday ? $this->holidays[$attendance->date] : null;
        
        $statusText = '';
        $dayType = 'Clase Normal';
        $holidayReason = '';
        
        if ($isHoliday && $holiday) {
            $dayType = 'Feriado';
            $holidayReason = $holiday->reason;
            if ($holiday->no_classes) {
                $statusText = 'No hubo clase';
            } else {
                // Si es feriado pero hay clases, usar el estado normal
                $statusText = $this->getStatusText($attendance->status);
            }
        } else {
            $statusText = $this->getStatusText($attendance->status);
        }

        return [
            $attendance->created_at->format('d/m/Y'),
            $dayType,
            $holidayReason,
            $attendance->student_dni,
            $attendance->student->full_name,
            $attendance->student->grade->name,
            $attendance->student->classroom->name,
            $isHoliday && $holiday && $holiday->no_classes ? 'No hubo clase' : $attendance->time,
            $statusText
        ];
    }

    protected function getStatusText($status)
    {
        switch ($status) {
            case 'present':
                return 'Presente';
            case 'late':
                return 'Tardanza';
            case 'absent':
                return 'Falta';
            default:
                return 'Justificado';
        }
    }
}