<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Student;
use App\Models\Classroom;
use Carbon\Carbon;

class ProfessorController extends Controller
{
    public function dashboard()
    {
        // Verificar que el usuario tiene aulas asignadas
        if (!auth()->user()->classrooms || auth()->user()->classrooms->isEmpty()) {
            return redirect()->back()
                ->with('error', 'No tienes aulas asignadas. Contacta al administrador.');
        }

        $classrooms = auth()->user()->classrooms;
        $today = now()->format('Y-m-d');

        $attendances = Attendance::whereIn('student_dni', function($query) {
                $query->select('dni')
                    ->from('students')
                    ->whereIn('classroom_id', auth()->user()->classrooms->pluck('id'));
            })
            ->whereDate('created_at', $today)
            ->with('student')
            ->get();

        $presentCount = $attendances->where('status', 'present')->count();
        $lateCount = $attendances->where('status', 'late')->count();
        $totalStudents = Student::whereIn('classroom_id', auth()->user()->classrooms->pluck('id'))->count();

        return view('professor.dashboard', compact('presentCount', 'lateCount', 'totalStudents', 'classrooms'));
    }

    public function attendance(Request $request)
    {
        $classroomId = $request->classroom_id ?? auth()->user()->classrooms->first()->id;
        $classroom = Classroom::findOrFail($classroomId);
        
        $students = Student::where('classroom_id', $classroomId)
            ->orderBy('last_name')
            ->get();
            
        $todayAttendances = Attendance::whereIn('student_dni', $students->pluck('dni'))
            ->whereDate('created_at', now())
            ->get()
            ->keyBy('student_dni');
            
        return view('professor.attendance', compact('students', 'todayAttendances', 'classroom'));
    }

    public function markAttendance(Request $request)
    {
        $request->validate([
            'student_dni' => 'required|exists:students,dni',
            'status' => 'required|in:present,late,absent,excused'
        ]);
        
        $existing = Attendance::where('student_dni', $request->student_dni)
            ->whereDate('created_at', now())
            ->first();
            
        if ($existing) {
            $existing->update(['status' => $request->status]);
        } else {
            Attendance::create([
                'student_dni' => $request->student_dni,
                'status' => $request->status,
                'time' => now()->format('H:i:s'),
                'date' => now()->toDateString()
            ]);
        }
        
        return back()->with('success', 'Asistencia actualizada correctamente');
    }
}