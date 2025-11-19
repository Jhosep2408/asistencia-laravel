<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Student;
use App\Models\Attendance;
use Carbon\Carbon;

class CheckAttendanceAbsence extends Command
{
    protected $signature = 'attendance:check-absence';
    protected $description = 'Marcar falta a estudiantes que no llegaron antes de las 8:00';

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
                    'status' => 'Falta',
                ]);
            }
        }

        $this->info('❌ Se marcaron faltas correctamente.');
    }
}
