<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Student;
use App\Models\Attendance;
use Carbon\Carbon;

class CheckAttendanceTardiness extends Command
{
    protected $signature = 'attendance:check-tardiness';
    protected $description = 'Marcar tardanza a estudiantes que no llegaron antes de 7:30';

    public function handle()
    {
        $today = Carbon::today()->toDateString();

        $students = Student::all();

        foreach ($students as $student) {
            $record = Attendance::where('student_dni', $student->dni) // clave foránea
                                ->where('date', $today)
                                ->first();

            if (!$record) {
                Attendance::create([
                    'student_dni' => $student->dni, // guardar DNI
                    'date' => $today,
                    'status' => 'Tardanza',
                ]);
            }
        }

        $this->info('✅ Se marcaron tardanzas correctamente.');
    }
}
