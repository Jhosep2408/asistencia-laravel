    <?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfessorController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\AsistenteController;
use App\Http\Controllers\HolidayController;



Route::get('/test-db', function() {
    try {
        \DB::connection()->getPdo();
        echo "BD conectada<br>";
        
        $users = \App\Models\User::count();
        echo "Usuarios en BD: " . $users . "<br>";
        
        echo "Todo OK!";
    } catch (\Exception $e) {
        echo "Error: " . $e->getMessage();
    }
});
// Authentication Routes
// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::redirect('/', '/login');

Route::post('/chatbot/query', [ChatbotController::class, 'processQuery'])->name('chatbot.query');
// routes/api.php
Route::post('/chatbot/query', [ChatbotController::class, 'processQuery'])->middleware('auth');
// Admin Routes - SOLO admin
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // Aquí van todas tus otras rutas de admin...
    Route::post('/students/import', [StudentController::class, 'import'])->name('students.import');
    Route::get('/attendance/load', [AttendanceController::class, 'load'])->name('attendance.load');
    // ... el resto de tus rutas admin
});
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth'); // Asegúrate de que tenga middleware auth
Route::get('/debug-auth', function() {
    return [
        'is_authenticated' => auth()->check(),
        'user' => auth()->user(),
        'session_id' => session()->getId(),
        'session_data' => session()->all()
    ];
});
// Rutas para gestión de feriados
// Rutas para gestión de feriados
Route::prefix('holidays')->group(function () {
    Route::get('/', [HolidayController::class, 'index'])->name('holidays.index');
    Route::post('/', [HolidayController::class, 'store'])->name('holidays.store');
    Route::get('/list', [HolidayController::class, 'list'])->name('holidays.list');
    Route::get('/{holiday}', [HolidayController::class, 'show'])->name('holidays.show');
    Route::put('/{holiday}', [HolidayController::class, 'update'])->name('holidays.update');
    Route::delete('/{holiday}', [HolidayController::class, 'destroy'])->name('holidays.destroy');
    
    // CORREGIR: Usar nombre único para esta ruta
    Route::get('/check/date', [HolidayController::class, 'check'])->name('holidays.check.date');
});

// Ruta para verificar feriados en AttendanceController - usar nombre diferente
Route::get('/attendance/check-holiday', [AttendanceController::class, 'checkHoliday'])->name('attendance.check.holiday');
// Agregar esta ruta en routes/web.php
Route::get('/admin/students/photocheck/group', [StudentController::class, 'groupPhotocheck'])
    ->name('students.photocheck.group');

// Ruta para cargar secciones dinámicamente
Route::get('/admin/grades/{grade}/classrooms', [StudentController::class, 'getClassroomsByGrade'])
    ->name('grades.classrooms');
// routes/web.php

Route::post('/holidays/store', [AttendanceController::class, 'storeHoliday'])->name('holidays.store');
Route::get('/holidays/check', [AttendanceController::class, 'checkHoliday'])->name('holidays.check');
// Ruta para obtener detalles completos del estudiante
Route::get('/students/{dni}/details', [StudentController::class, 'getStudentDetails'])->name('students.details');

Route::get('/asistente', [AsistenteController::class, 'index'])->name('admin.asistente');
Route::post('/api/chatbot/query', [AsistenteController::class, 'processQuery'])->name('chatbot.query');

// Rutas del asistente
Route::get('/asistente', [AsistenteController::class, 'index'])->name('admin.asistente');
// Ruta alternativa para compatibilidad
Route::get('/admin/asistente', [AsistenteController::class, 'index'])->name('admin.asistente.alternative');
Route::post('/api/chatbot/query', [AsistenteController::class, 'processQuery'])->name('chatbot.query');

// Ruta para la vista del asistente
Route::get('/admin/asistente', [AsistenteController::class, 'asistente'])->name('admin.asistente');

// Ruta para procesar consultas (IMPORTANTE)
Route::post('/asistente/query', [AsistenteController::class, 'processQuery'])->name('asistente.query');
// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/asistente', [AsistenteController::class, 'asistente'])->name('admin.asistente');
    Route::post('/students/import', [StudentController::class, 'import'])->name('students.import');
    Route::get('/attendance/load', [AttendanceController::class, 'load'])->name('attendance.load');
    Route::post('/attendance/store', [AttendanceController::class, 'store'])->name('attendance.store');

    // NUEVA RUTA PARA GUARDADO INDIVIDUAL
Route::post('/attendance/single', [AttendanceController::class, 'storeSingle'])->name('attendance.store.single');
    
// Obtener estudiantes sin asistencia
Route::get('/attendance/get-unmarked', [AttendanceController::class, 'getUnmarkedStudents'])->name('attendance.get.unmarked');

// Marcar todas las faltas automáticas
Route::post('/attendance/mark-all-absent', [AttendanceController::class, 'markAllAbsent'])->name('attendance.mark.all.absent');
Route::post('/attendance/export/siagie', [AttendanceController::class, 'exportSiagie'])
    ->name('attendance.export.siagie')
    ->middleware(['auth', 'admin']);

// En routes/web.php
Route::get('/attendance/export/siagie', [AttendanceController::class, 'exportSiagie'])
    ->name('attendance.export.siagie')
    ->middleware(['auth', 'admin']);

// routes/web.php
// Ruta para obtener información del estudiante
// Ruta para obtener información del estudiante
Route::get('/api/student-info/{dni}', function($dni) {
    $student = \App\Models\Student::with(['grade', 'classroom'])
                ->where('dni', $dni)
                ->first();
    
    if (!$student) {
        return response()->json(['error' => 'Estudiante no encontrado'], 404);
    }
    
    return response()->json([
        'dni' => $student->dni,
        'full_name' => $student->full_name,
        'grade' => $student->grade->name ?? 'N/A',
        'classroom' => $student->classroom->name ?? 'N/A'
    ]);
});

Route::post('/attendance/export/siagie', [AttendanceController::class, 'exportSiagie'])
    ->name('attendance.export.siagie')
    ->middleware(['auth', 'admin']);
// Rutas para el perfil y configuración
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/settings', [SettingsController::class, 'show'])->name('settings.show');
    Route::post('/settings', [SettingsController::class, 'update'])->name('settings.update');
    Route::get('/about', [ProfileController::class, 'about'])->name('about');
    Route::get('/privacy', [ProfileController::class, 'privacy'])->name('privacy');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/profile', [ProfileController::class, 'show']);
    Route::get('/profile/edit', [ProfileController::class, 'edit']);
});
// Rutas de perfil
// Rutas de perfil
// Rutas de perfil - usa solo middlewares que existen
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
});
// Agregar estas rutas para exportación
Route::post('/attendance/export', [App\Http\Controllers\AttendanceController::class, 'export'])
    ->name('attendance.export');

Route::post('/attendance/export/student', [App\Http\Controllers\AttendanceController::class, 'exportStudent'])
    ->name('attendance.export.student');

// En routes/web.php
// Reportes de asistencia
// Reportes de asistencia
Route::get('/attendance/reports', [AttendanceController::class, 'reports'])->name('attendance.reports');
Route::post('/attendance/export', [AttendanceController::class, 'export'])->name('attendance.export');
Route::post('/attendance/export/student', [AttendanceController::class, 'exportStudent'])->name('attendance.export.student');
    
// Dentro del grupo admin
Route::post('/attendance/send-automatic-notifications', [AttendanceController::class, 'sendAutomaticAbsenceNotifications'])
    ->name('attendance.send.automatic');

Route::get('/attendance/check-notifications', [AttendanceController::class, 'checkAndSendNotifications'])
    ->name('attendance.check.notifications');

Route::get('/attendance/summary', [AttendanceController::class, 'getSummary'])->name('attendance.summary');

// Obtener estudiantes sin asistencia
Route::get('/attendance/get-unmarked', [AttendanceController::class, 'getUnmarkedStudents'])->name('attendance.get.unmarked');

// Marcar todas las faltas automáticas
Route::post('/attendance/mark-all-absent', [AttendanceController::class, 'markAllAbsent'])->name('attendance.mark.all.absent');
    // Student Management
    Route::resource('students', StudentController::class);
    // Rutas para el sistema de asistencia con código de barras
Route::get('/attendance', [StudentController::class, 'attendance'])->name('attendance.index');
Route::get('/attendance/views', [StudentController::class, 'attendanceViews'])->name('attendance.views');

// API para procesar códigos de barras
Route::post('/attendance/process-scan', [StudentController::class, 'processBarcodeScan'])->name('attendance.process.scan');
Route::post('/attendance/save', [StudentController::class, 'saveAttendance'])->name('attendance.store');
Route::get('/attendance/load', [StudentController::class, 'loadAttendance'])->name('attendance.load');
    // Ruta de asistencia - DENTRO del grupo admin
Route::get('/students/attendance', [StudentController::class, 'attendance'])
    ->name('students.attendance');
    
Route::get('/students/attendance-views', [StudentController::class, 'attendanceViews'])
    ->name('students.attendanceviews');
     
     
        // Dentro del grupo admin en web.php
Route::post('/attendance/send-whatsapp-notification', [AttendanceController::class, 'sendWhatsAppNotification'])
    ->name('attendance.send.whatsapp');


     
        // Dentro del grupo admin
// Dentro del grupo admin
Route::post('/attendance/save', [StudentController::class, 'saveAttendance'])
    ->name('attendance.save');
    
    // Ruta para fotocheck
    Route::get('/students/{dni}/photocheck', [StudentController::class, 'generatePhotocheck'])
         ->name('students.photocheck');
    
    // Attendance Reports
    Route::get('/attendance/reports', [AttendanceController::class, 'reports'])
         ->name('attendance.reports');
    Route::post('/attendance/export', [AttendanceController::class, 'export'])
         ->name('attendance.export');
});


// Professor Routes
Route::middleware(['auth', 'professor'])->prefix('professor')->group(function () {
    Route::get('/dashboard', [ProfessorController::class, 'dashboard'])
         ->name('professor.dashboard');
    Route::get('/attendance', [ProfessorController::class, 'attendance'])
         ->name('professor.attendance');
    Route::post('/attendance/mark', [ProfessorController::class, 'markAttendance'])
         ->name('professor.attendance.mark');
});

// API Routes for Barcode Scanner
Route::middleware('auth')->prefix('api')->group(function () {
    Route::post('/attendance/scan', [AttendanceController::class, 'scanBarcode']);
});

// Ruta de prueba temporal
// Ruta simple de prueba para asistencia
// Ruta CORRECTA para el panel de asistencia - DENTRO del grupo admin
Route::get('/students/attendance', [StudentController::class, 'attendance'])
    ->name('students.attendance');
        
    Route::get('/students/attendance-views', [StudentController::class, 'attendanceViews'])
        ->name('students.attendanceviews');
