<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Attendance;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalStudents = Student::count();
        $todayAttendances = Attendance::whereDate('created_at', today())->count();
        $todayAbsences = Attendance::whereDate('created_at', today())
                        ->where('status', 'absent')
                        ->count();
        $recentStudents = Student::with(['grade', 'classroom'])
                        ->orderBy('created_at', 'desc')
                        ->take(5)
                        ->get();
        
        return view('admin.dashboard', compact(
            'totalStudents',
            'todayAttendances',
            'todayAbsences',
            'recentStudents'
        ));
    }
}