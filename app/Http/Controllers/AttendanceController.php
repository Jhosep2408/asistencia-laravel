<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Student;
use App\Models\Grade;
use App\Models\Classroom;
use App\Models\Holiday;
use App\Models\Schedule;
use Carbon\Carbon;
use PDF;
use App\Exports\AttendanceExport;
use Twilio\Rest\Client;
use App\Exports\StudentAttendanceExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SiagieExport;




class AttendanceController extends Controller
{
public function reports(Request $request)
{
    $query = Attendance::with([
        'student', 
        'student.grade', 
        'student.classroom'
    ]);
    
    // Filtros
    if ($request->filled('grade_id')) {
        $query->whereHas('student', function($q) use ($request) {
            $q->where('grade_id', $request->grade_id);
        });
    }
    
    if ($request->filled('classroom_id')) {
        $query->whereHas('student', function($q) use ($request) {
            $q->where('classroom_id', $request->classroom_id);
        });
    }
    
    if ($request->filled('date_from') && $request->filled('date_to')) {
        $query->whereBetween('date', [ // Cambié created_at por date
            Carbon::parse($request->date_from)->startOfDay(),
            Carbon::parse($request->date_to)->endOfDay()
        ]);
    }
    
    $attendances = $query->orderBy('date', 'desc')
                    ->orderBy('time', 'desc')
                    ->paginate($request->per_page ?? 10);

    $grades = Grade::with('classrooms')->get();
    $classrooms = Classroom::all();

     // OBTENER FERIADOS PARA EL RANGO DE FECHAS
    $holidays = [];
    if ($request->filled('date_from') && $request->filled('date_to')) {
        $holidays = Holiday::whereBetween('date', [
            Carbon::parse($request->date_from)->startOfDay(),
            Carbon::parse($request->date_to)->endOfDay()
        ])->get()->keyBy('date');
    }
    
    return view('admin.attendance.reports', compact('attendances', 'grades', 'classrooms'));
}
/**
 * Exportar reporte en formato SIAGIE usando Laravel Excel
 */
public function exportSiagie(Request $request)
{
    $request->validate([
        'export_month' => 'required|integer|between:1,12',
        'export_year' => 'required|integer|min:2020|max:2030',
        'auxiliar_name' => 'required|string|max:255',
        'siagie_grade' => 'required|string|max:50',
        'siagie_section' => 'required|string|max:10',
        'modal_grade_id' => 'nullable|exists:grades,id', // Cambiar a modal_grade_id
        'modal_classroom_id' => 'nullable|exists:classrooms,id', // Cambiar a modal_classroom_id
    ]);

    $month = $request->export_month;
    $year = $request->export_year;
    $auxiliarName = $request->auxiliar_name;
    $grade = $request->siagie_grade;
    $section = $request->siagie_section;
    
    // Usar los filtros del modal (modal_grade_id y modal_classroom_id)
    $gradeId = $request->modal_grade_id;
    $classroomId = $request->modal_classroom_id;

    // Obtener estudiantes según los filtros del modal
    $query = Student::with(['grade', 'classroom', 'attendances']);

    // Aplicar filtros del modal si están presentes
    if ($gradeId) {
        $query->where('grade_id', $gradeId);
    }

    if ($classroomId) {
        $query->where('classroom_id', $classroomId);
    }

    $students = $query->orderBy('last_name')->orderBy('first_name')->get();

    $filename = "SIAGIE_{$grade}_{$section}_{$month}_{$year}.xlsx";

    // Usar Laravel Excel para generar el archivo
    return Excel::download(new SiagieExport($students, $month, $year, $auxiliarName, $grade, $section), $filename);
}


// Agrega este método para manejar feriados
public function storeHoliday(Request $request)
{
    try {
        $validated = $request->validate([
            'date' => 'required|date|unique:holidays,date',
            'reason' => 'required|string|max:255',
            'description' => 'nullable|string',
            'no_classes' => 'boolean'
        ]);

        $holiday = Holiday::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Feriado guardado correctamente',
            'holiday' => $holiday
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error al guardar el feriado: ' . $e->getMessage()
        ], 500);
    }
}

// Método para verificar si una fecha es feriado
public function checkHoliday(Request $request)
{
    $date = $request->get('date');
    $holiday = Holiday::where('date', $date)->first();

    return response()->json([
        'is_holiday' => !is_null($holiday),
        'holiday' => $holiday
    ]);
}

    // ... el resto de tus métodos permanecen igual ...
    public function load(Request $request)
    {
        $date = $request->query('date');
        $attendances = Attendance::where('date', $date)->with('student')->get();
        return response()->json(['attendances' => $attendances]);
    }

public function store(Request $request)
{
    try {
        $data = $request->all();
        $currentTime = Carbon::now('America/Lima')->format('H:i:s'); // Formato correcto
        $currentDate = $data['date'] ?? Carbon::now('America/Lima')->toDateString();
        // Verificar si es feriado
        $isHoliday = Holiday::where('date', $currentDate)->where('no_classes', true)->exists();

         if ($isHoliday) {
            return response()->json([
                'success' => false,
                'message' => 'No se puede guardar asistencia: Es día feriado y no hay clases'
            ], 422);
        }
        

        \Log::info('Datos recibidos para guardar asistencia:', $data);

        // Validar estados permitidos
        $allowedStatuses = ['present', 'late', 'absent', 'justified'];

        // Solo procesar los estudiantes que vienen en la request
        if (isset($data['attendance']) && is_array($data['attendance'])) {
            foreach ($data['attendance'] as $studentDni => $att) {
                // Validar que el estado sea permitido y no sea 'none'
                if (isset($att['status']) && 
                    $att['status'] !== 'none' && 
                    in_array($att['status'], $allowedStatuses)) {
                    
                    // Asegurar que el DNI sea válido
                    if (!Student::where('dni', $studentDni)->exists()) {
                        \Log::warning("Estudiante con DNI {$studentDni} no encontrado");
                        continue;
                    }

                    Attendance::updateOrCreate(
                        ['student_dni' => $studentDni, 'date' => $currentDate],
                        [
                            'status' => $att['status'],
                            'time' => $currentTime,
                            'notes' => $att['notes'] ?? null
                        ]
                    );
                    
                    \Log::info("Asistencia guardada para: {$studentDni} - Estado: {$att['status']}");
                }
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Asistencia guardada correctamente para los estudiantes marcados',
            'students_processed' => isset($data['attendance']) ? count($data['attendance']) : 0
        ]);

    } catch (\Exception $e) {
        \Log::error('Error al guardar asistencia: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Error al guardar la asistencia: ' . $e->getMessage()
        ], 500);
    }
}



/**
 * Obtener estudiantes sin asistencia para una fecha específica
 */
public function getUnmarkedStudents(Request $request)
{
    try {
        $date = $request->get('date', now()->format('Y-m-d'));
        $gradeId = $request->get('grade_id');
        $sectionId = $request->get('section_id');
        $shift = $request->get('shift'); // ← AGREGAR FILTRO DE TURNO

        // Obtener estudiantes según filtros
        $studentsQuery = Student::with(['grade', 'classroom']);
        
        if ($gradeId) {
            $studentsQuery->where('grade_id', $gradeId);
        }
        if ($sectionId) {
            $studentsQuery->where('classroom_id', $sectionId);
        }
        // AGREGAR FILTRO POR TURNO
        if ($shift) {
            $studentsQuery->where('shift', $shift);
        }

        // Obtener estudiantes que ya tienen asistencia
        $studentsWithAttendance = Attendance::where('date', $date)
            ->pluck('student_dni')
            ->toArray();

        // Filtrar estudiantes sin asistencia
        $unmarkedStudents = $studentsQuery->whereNotIn('dni', $studentsWithAttendance)
            ->get()
            ->map(function($student) {
                return [
                    'dni' => $student->dni,
                    'name' => $student->first_name . ' ' . $student->last_name,
                    'grade' => $student->grade->name ?? 'N/A',
                    'section' => $student->classroom->name ?? 'N/A',
                    'shift' => $student->shift ?? 'morning', // ← INCLUIR TURNO EN LA RESPUESTA
                    'parent_name' => $student->guardian_name ?? 'Apoderado',
                    'parent_phone' => $student->guardian_phone
                ];
            });

        return response()->json([
            'success' => true,
            'students' => $unmarkedStudents,
            'count' => $unmarkedStudents->count()
        ]);

    } catch (\Exception $e) {
        \Log::error('Error al obtener estudiantes sin asistencia: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Error al cargar estudiantes sin asistencia: ' . $e->getMessage()
        ], 500);
    }
}

/**
 * Marcar todas las faltas automáticas
 */
public function markAllAbsent(Request $request)
{
    try {
         $validated = $request->validate([
            'date' => 'required|date',
            'grade_id' => 'nullable|exists:grades,id',
            'section_id' => 'nullable|exists:classrooms,id',
            'shift' => 'nullable|in:morning,afternoon', // ← AGREGAR TURNO
            'send_notifications' => 'boolean'
        ]);

        $date = $validated['date'];
        $gradeId = $validated['grade_id'] ?? null;
        $sectionId = $validated['section_id'] ?? null;
        $shift = $validated['shift'] ?? null; // ← OBTENER TURNO
        $sendNotifications = $validated['send_notifications'] ?? false;

        // Obtener estudiantes según filtros
        $studentsQuery = Student::with(['grade', 'classroom']);
        
        if ($gradeId) {
            $studentsQuery->where('grade_id', $gradeId);
        }
        if ($sectionId) {
            $studentsQuery->where('classroom_id', $sectionId);
        }
        // AGREGAR FILTRO POR TURNO
        if ($shift) {
            $studentsQuery->where('shift', $shift);
        }

        // Obtener estudiantes que ya tienen asistencia
        $studentsWithAttendance = Attendance::where('date', $date)
            ->pluck('student_dni')
            ->toArray();

        // Filtrar estudiantes sin asistencia
        $unmarkedStudents = $studentsQuery->whereNotIn('dni', $studentsWithAttendance)->get();

        $markedCount = 0;
        $notificationCount = 0;
        $errors = [];

        foreach ($unmarkedStudents as $student) {
            try {
                // Crear registro de falta
                Attendance::create([
                    'student_dni' => $student->dni,
                    'status' => 'absent',
                    'time' => now()->format('H:i:s'),
                    'date' => $date,
                    'notes' => 'Falta automática - Sistema'
                ]);

                $markedCount++;

                // Enviar notificación si está habilitado
                if ($sendNotifications && $student->guardian_phone) {
                    $notificationSent = $this->sendAutomaticWhatsAppNotification($student, $date);
                    if ($notificationSent) {
                        $notificationCount++;
                    } else {
                        $errors[] = "Error enviando notificación a {$student->dni}";
                    }
                }

            } catch (\Exception $e) {
                $errors[] = "Error con estudiante {$student->dni}: " . $e->getMessage();
                \Log::error("Error marcando falta para {$student->dni}: " . $e->getMessage());
            }
        }

        $message = "Se marcaron {$markedCount} faltas automáticas";
        if ($sendNotifications) {
            $message .= " y se enviaron {$notificationCount} notificaciones";
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'details' => [
                'marked_count' => $markedCount,
                'notification_count' => $notificationCount,
                'errors' => $errors
            ]
        ]);

    } catch (\Exception $e) {
        \Log::error('Error en markAllAbsent: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Error al marcar faltas automáticas: ' . $e->getMessage()
        ], 500);
    }
}



    /**
     * Exportar reporte general de asistencias
     */
    public function export(Request $request)
    {
        $filters = [
            'search' => $request->search,
            'grade_id' => $request->grade_id,
            'classroom_id' => $request->classroom_id,
            'date_from' => $request->date_from,
            'date_to' => $request->date_to,
        ];

        if ($request->format === 'pdf') {
            // Lógica para PDF (si la necesitas)
            return response()->json(['message' => 'Exportación PDF en desarrollo']);
        }

        // Exportar a Excel
        return Excel::download(new AttendanceExport($filters), 'reporte_asistencias_' . date('Y-m-d') . '.xlsx');
    }

    /**
     * Exportar reporte individual de estudiante
     */
/**
 * Exportar reporte individual de estudiante
 */
/**
 * Exportar reporte individual de estudiante
 */
public function exportStudent(Request $request)
{
    \Log::info('=== INICIANDO EXPORTACIÓN INDIVIDUAL ===');
    \Log::info('Datos recibidos:', $request->all());

    try {
        // Cambiar la validación para usar dni en lugar de id
        $request->validate([
            'student_dni' => 'required|exists:students,dni',
            'date_from' => 'required|date',
            'date_to' => 'required|date|after_or_equal:date_from',
            'format' => 'required|in:siagie,simple', // Agregar validación de formato
        ]);

        // Buscar estudiante por DNI
        $student = Student::where('dni', $request->student_dni)->firstOrFail();
        
        \Log::info('Estudiante encontrado:', [
            'dni' => $student->dni,
            'nombre' => $student->full_name
        ]);

        $data = [
            'student_dni' => $request->student_dni,
            'date_from' => $request->date_from,
            'date_to' => $request->date_to,
            'format' => $request->format,
        ];

        // Si el formato es SIAGIE, usar SiagieExport
        if ($request->format === 'siagie') {
            $month = date('m', strtotime($request->date_from));
            $year = date('Y', strtotime($request->date_from));
            $auxiliarName = "LUISA SANCHEZ ARISTA"; // Puedes hacer esto configurable
            $grade = $this->convertToSiagieGrade($student->grade->name ?? 'PRIMERO');
            $section = $this->extractSection($student->classroom->name ?? 'A');
            
            // Cargar las asistencias del estudiante para el rango de fechas
            $student->load(['attendances' => function($query) use ($request) {
                $query->whereBetween('date', [$request->date_from, $request->date_to]);
            }]);
            
            // Crear una colección con solo el estudiante
            $students = collect([$student]);

            $filename = 'SIAGIE_INDIVIDUAL_' . str_replace(' ', '_', $student->full_name) . '_' . date('Y-m-d') . '.xlsx';
            
            \Log::info('Generando reporte SIAGIE individual:', [
                'filename' => $filename,
                'month' => $month,
                'year' => $year,
                'asistencias_count' => $student->attendances->count()
            ]);
            
            return Excel::download(new SiagieExport($students, $month, $year, $auxiliarName, $grade, $section), $filename);
        } else {
            // Formato simple (el original)
            $filename = 'reporte_' . str_replace(' ', '_', $student->full_name) . '_' . date('Y-m-d') . '.xlsx';
            \Log::info('Generando archivo simple:', ['filename' => $filename]);
            return Excel::download(new StudentAttendanceExport($data), $filename);
        }
        
    } catch (\Exception $e) {
        \Log::error('Error en exportStudent: ' . $e->getMessage());
        \Log::error('Trace: ' . $e->getTraceAsString());
        throw $e;
    }
}
/**
 * Convertir nombre de grado a formato SIAGIE
 */
private function convertToSiagieGrade($gradeName)
{
    $gradeMapping = [
        'PRIMERO' => 'PRIMERO',
        'PRIMER' => 'PRIMERO',
        '1RO' => 'PRIMERO',
        '1ERO' => 'PRIMERO',
        '1°' => 'PRIMERO',
        'SEGUNDO' => 'SEGUNDO', 
        '2DO' => 'SEGUNDO',
        '2°' => 'SEGUNDO',
        'TERCERO' => 'TERCERO',
        '3RO' => 'TERCERO',
        '3°' => 'TERCERO',
        'CUARTO' => 'CUARTO',
        '4TO' => 'CUARTO',
        '4°' => 'CUARTO',
        'QUINTO' => 'QUINTO',
        '5TO' => 'QUINTO',
        '5°' => 'QUINTO'
    ];
    
    $upperGradeName = strtoupper(trim($gradeName));
    
    foreach ($gradeMapping as $key => $value) {
        if (str_contains($upperGradeName, $key)) {
            return $value;
        }
    }
    
    // Si no se encuentra, intentar extraer número
    preg_match('/\d+/', $upperGradeName, $matches);
    if (isset($matches[0])) {
        $number = (int)$matches[0];
        $numberMapping = [
            1 => 'PRIMERO',
            2 => 'SEGUNDO', 
            3 => 'TERCERO',
            4 => 'CUARTO',
            5 => 'QUINTO'
        ];
        return $numberMapping[$number] ?? 'PRIMERO';
    }
    
    return 'PRIMERO';
}

/**
 * Extraer sección del nombre del aula
 */
private function extractSection($classroomName)
{
    preg_match('/[A-E]/i', $classroomName, $matches);
    if (isset($matches[0])) {
        return strtoupper($matches[0]);
    }
    
    return substr(strtoupper(trim($classroomName)), 0, 1);
}


    public function scanBarcode(Request $request)
    {
        $request->validate(['barcode' => 'required']);
        
        $student = Student::where('dni', $request->barcode)->first();
        
        if (!$student) {
            return response()->json(['success' => false, 'message' => 'Estudiante no encontrado']);
        }
        
        // Verificar horario
        $schedule = Schedule::where('grade_id', $student->grade_id)
                    ->where('classroom_id', $student->classroom_id)
                    ->where('day_of_week', now()->dayOfWeek)
                    ->first();
        
        if (!$schedule) {
            return response()->json(['success' => false, 'message' => 'No hay horario para este estudiante hoy']);
        }
        
        $startTime = Carbon::parse($schedule->start_time);
        $currentTime = now();
        $lateThreshold = $startTime->copy()->addMinutes(15);
        
        $status = 'present';
        if ($currentTime->gt($lateThreshold)) {
            $status = 'late';
        }
        
        // Registrar asistencia
        $attendance = Attendance::create([
            'student_dni' => $student->dni,
            'status' => $status,
            'time' => $currentTime->format('H:i:s'),
            'date' => $currentTime->toDateString()
        ]);
        
        return response()->json([
            'success' => true,
            'student' => $student,
            'attendance' => $attendance
        ]);
    }
 /**
     * Guardar asistencia individual (para escáner)
     */
public function storeSingle(Request $request)
{
    try {
        \Log::info('Datos recibidos para asistencia individual:', $request->all());

        $validated = $request->validate([
            'date' => 'required|date',
            'student_dni' => 'required|exists:students,dni',
            'status' => 'required|in:present,late,absent,justified',
            'notes' => 'nullable|string|max:500'
        ]);

        // Verificar que el estudiante existe
        $student = Student::where('dni', $validated['student_dni'])->first();
        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => 'Estudiante no encontrado'
            ], 404);
        }

        // Usar formato correcto para la hora
        $currentTime = Carbon::now('America/Lima')->format('H:i:s');

        // Buscar si ya existe un registro para esta fecha y estudiante
        $attendance = Attendance::where('date', $validated['date'])
            ->where('student_dni', $validated['student_dni'])
            ->first();

        if ($attendance) {
            // Actualizar registro existente
            $attendance->update([
                'status' => $validated['status'],
                'notes' => $validated['notes'] ?? '',
                'time' => $currentTime
            ]);
        } else {
            // Crear nuevo registro
            Attendance::create([
                'date' => $validated['date'],
                'student_dni' => $validated['student_dni'], // Nombre correcto de columna
                'status' => $validated['status'],
                'notes' => $validated['notes'] ?? '',
                'time' => $currentTime
            ]);
        }

        \Log::info('Asistencia individual guardada correctamente para: ' . $validated['student_dni'] . ' Estado: ' . $validated['status']);

        return response()->json([
            'success' => true,
            'message' => 'Asistencia guardada correctamente'
        ]);

    } catch (\Illuminate\Validation\ValidationException $e) {
        \Log::error('Error de validación: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Error de validación: ' . $e->getMessage(),
            'errors' => $e->errors()
        ], 422);
    } catch (\Exception $e) {
        \Log::error('Error al guardar asistencia individual: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Error al guardar la asistencia: ' . $e->getMessage()
        ], 500);
    }
}


public function getSummary(Request $request)
{
    try {
        $date = $request->get('date', now()->format('Y-m-d'));
        $gradeId = $request->get('grade_id');
        $sectionId = $request->get('section_id');
        
        // Obtener estudiantes según filtros
        $studentsQuery = Student::query();
        if ($gradeId) {
            $studentsQuery->where('grade_id', $gradeId);
        }
        if ($sectionId) {
            $studentsQuery->where('section_id', $sectionId);
        }
        $totalStudents = $studentsQuery->count();
        
        // Obtener asistencias registradas
        $attendanceQuery = Attendance::where('date', $date);
        if ($gradeId) {
            $attendanceQuery->whereHas('student', function($q) use ($gradeId) {
                $q->where('grade_id', $gradeId);
            });
        }
        if ($sectionId) {
            $attendanceQuery->whereHas('student', function($q) use ($sectionId) {
                $q->where('section_id', $sectionId);
            });
        }
        
        $attendances = $attendanceQuery->get();
        
        $summary = [
            'present' => $attendances->where('status', 'present')->count(),
            'late' => $attendances->where('status', 'late')->count(),
            'absent' => $attendances->where('status', 'absent')->count(),
            'justified' => $attendances->where('status', 'justified')->count(),
            'total' => $totalStudents,
            'none' => $totalStudents - $attendances->count() // Estudiantes sin marcar
        ];
        
        return response()->json([
            'success' => true,
            'summary' => $summary
        ]);
        
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error al cargar el resumen: ' . $e->getMessage()
        ], 500);
    }
}

    /**
     * Enviar notificación de falta por WhatsApp
     */
    public function sendWhatsAppNotification(Request $request)
    {
        try {
            \Log::info('Datos recibidos para notificación WhatsApp:', $request->all());

            $validated = $request->validate([
            'student_dni' => 'required|exists:students,dni',
            'date' => 'required|date',
            'time' => 'required|string',
            'status' => 'required|in:absent,late',
            'shift' => 'required|in:morning,afternoon'
        ]);

            $student = Student::where('dni', $validated['student_dni'])->first();
            $shiftText = $validated['shift'] === 'morning' ? 'mañana' : 'tarde';
            if (!$student) {
                return response()->json([
                    'success' => false,
                    'message' => 'Estudiante no encontrado'
                ], 404);
            }

            $parentName = $student->guardian_name ?: 'Apoderado';
            $parentPhone = $student->guardian_phone;

            if (!$parentPhone) {
                return response()->json([
                    'success' => false,
                    'message' => 'No hay número de teléfono registrado para el apoderado'
                ], 400);
            }

            if ($validated['status'] === 'absent') {
            $message = "🚨 *Notificación de Falta - Turno {$shiftText}* 🚨\n\n";
            $message .= "Hola {$student->guardian_name},\n\n";
            $message .= "Le informamos que *{$student->first_name} {$student->last_name}* ";
            $message .= "no ha registrado asistencia el día *{$validated['date']}* ";
            $message .= "en el turno de la *{$shiftText}*.\n\n";
            $message .= "📝 *Estado:* FALTA\n";
            $message .= "🏫 *Grado/Sección:* {$student->grade->name} {$student->classroom->name}\n";
            $message .= "🕒 *Turno:* {$shiftText}\n\n";
            $message .= "Por favor, contacte con la institución educativa si existe alguna justificación.\n\n";
            $message .= "📞 *Contacto Colegio:* +51 123 456 789\n";
            $message .= "ℹ️  Este es un mensaje automático, por favor no responda.";
        } else {
            $message = "⚠️ *Notificación de Tardanza - Turno {$shiftText}* ⚠️\n\n";
            $message .= "Hola {$student->guardian_name},\n\n";
            $message .= "Le informamos que *{$student->first_name} {$student->last_name}* ";
            $message .= "ha registrado una tardanza el día *{$validated['date']}* ";
            $message .= "en el turno de la *{$shiftText}*.\n\n";
            $message .= "📝 *Estado:* TARDANZA\n";
            $message .= "🏫 *Grado/Sección:* {$student->grade->name} {$student->classroom->name}\n";
            $message .= "🕒 *Turno:* {$shiftText}\n\n";
            $message .= "Le recordamos la importancia de la puntualidad.\n\n";
            $message .= "📞 *Contacto Colegio:* +51 123 456 789\n";
            $message .= "ℹ️  Este es un mensaje automático, por favor no responda.";
        }

            $sent = $this->sendTwilioWhatsApp($parentPhone, $message);

            if ($sent) {
                \Log::info('Notificación WhatsApp enviada exitosamente a: ' . $parentPhone);
                
                return response()->json([
                    'success' => true,
                    'message' => 'Notificación enviada correctamente',
                    'data' => [
                        'student' => $student->first_name . ' ' . $student->last_name,
                        'parent' => $parentName,
                        'phone' => $parentPhone,
                        'status' => $validated['status']
                    ]
                ]);
            } else {
                \Log::error('Error al enviar notificación WhatsApp a: ' . $parentPhone);
                return response()->json([
                    'success' => false,
                    'message' => 'Error al enviar la notificación por WhatsApp'
                ], 500);
            }

        } catch (\Exception $e) {
            \Log::error('Error en sendWhatsAppNotification: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error interno del servidor: ' . $e->getMessage()
            ], 500);
        }
    }

     private function sendTwilioWhatsApp($to, $message)
    {
        try {
            // Verificar que las credenciales de Twilio estén configuradas
            if (!env('TWILIO_SID') || !env('TWILIO_TOKEN') || !env('TWILIO_WHATSAPP_FROM')) {
                \Log::error('Credenciales de Twilio no configuradas');
                return false;
            }

            $twilio = new Client(env('TWILIO_SID'), env('TWILIO_TOKEN'));
            
            // Formatear el número de teléfono (asegurarse de que tenga el formato correcto)
            $formattedNumber = $this->formatPhoneNumber($to);
            
            if (!$formattedNumber) {
                \Log::error('Número de teléfono inválido: ' . $to);
                return false;
            }

            $twilio->messages->create(
                "whatsapp:{$formattedNumber}",
                [
                    'from' => env('TWILIO_WHATSAPP_FROM'),
                    'body' => $message
                ]
            );
            
            return true;
            
        } catch (\Exception $e) {
            \Log::error("Error enviando WhatsApp con Twilio: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Formatear número de teléfono para Twilio
     */
    private function formatPhoneNumber($phone)
    {
        // Limpiar el número (remover espacios, guiones, etc.)
        $cleanPhone = preg_replace('/[^0-9]/', '', $phone);
        
        // Si el número empieza con 9 (número peruano móvil) y tiene 9 dígitos, agregar código de país
        if (preg_match('/^9[0-9]{8}$/', $cleanPhone)) {
            return '51' . $cleanPhone;
        }
        
        // Si ya tiene código de país, devolver como está
        if (preg_match('/^51[0-9]{9}$/', $cleanPhone)) {
            return $cleanPhone;
        }
        
        // Si no coincide con ningún formato esperado, devolver false
        return false;
    }


    
    /**
     * Enviar notificaciones automáticas de falta a las 8:00 AM
     */
    public function sendAutomaticAbsenceNotifications()
    {
        try {
            $today = Carbon::now('America/Lima')->toDateString();
            $currentTime = Carbon::now('America/Lima');
            
            // Solo ejecutar entre 8:00 AM y 8:10 AM para evitar múltiples ejecuciones
            if ($currentTime->format('H:i') < '08:00' || $currentTime->format('H:i') > '08:10') {
                return response()->json([
                    'success' => false,
                    'message' => 'Las notificaciones automáticas solo se envían entre 8:00 AM y 8:10 AM'
                ]);
            }

            // Obtener todos los estudiantes
            $students = Student::with(['grade', 'classroom'])->get();
            
            // Obtener estudiantes que ya tienen asistencia registrada hoy
            $studentsWithAttendance = Attendance::where('date', $today)
                ->pluck('student_dni')
                ->toArray();

            // Filtrar estudiantes sin asistencia
            $absentStudents = $students->whereNotIn('dni', $studentsWithAttendance);

            $notificationCount = 0;
            $errors = [];

            foreach ($absentStudents as $student) {
                try {
                    // Crear registro de falta automática
                    $attendance = Attendance::create([
                        'student_dni' => $student->dni,
                        'status' => 'absent',
                        'time' => '08:00:00',
                        'date' => $today,
                        'notes' => 'Falta automática - Sistema'
                    ]);

                    // Enviar notificación por WhatsApp
                    $notificationSent = $this->sendAutomaticWhatsAppNotification($student, $today);

                    if ($notificationSent) {
                        $notificationCount++;
                        \Log::info("Notificación automática enviada a: {$student->dni} - {$student->first_name}");
                    } else {
                        $errors[] = "Error enviando notificación a {$student->dni}";
                    }

                    // Pequeña pausa para evitar sobrecarga de API
                    usleep(500000); // 0.5 segundos

                } catch (\Exception $e) {
                    \Log::error("Error procesando estudiante {$student->dni}: " . $e->getMessage());
                    $errors[] = "Error con estudiante {$student->dni}: " . $e->getMessage();
                }
            }

            \Log::info("Notificaciones automáticas enviadas: {$notificationCount} de " . $absentStudents->count() . " estudiantes sin asistencia");

            return response()->json([
                'success' => true,
                'message' => "Notificaciones enviadas: {$notificationCount} estudiantes",
                'details' => [
                    'total_estudiantes' => $students->count(),
                    'estudiantes_con_asistencia' => count($studentsWithAttendance),
                    'estudiantes_sin_asistencia' => $absentStudents->count(),
                    'notificaciones_enviadas' => $notificationCount,
                    'errores' => $errors
                ]
            ]);

        } catch (\Exception $e) {
            \Log::error('Error en notificaciones automáticas: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error en notificaciones automáticas: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Enviar notificación automática por WhatsApp
     */
    private function sendAutomaticWhatsAppNotification($student, $date)
    {
        try {
            $parentName = $student->guardian_name ?: 'Apoderado';
            $parentPhone = $student->guardian_phone;

            if (!$parentPhone) {
                \Log::warning("No hay teléfono registrado para el apoderado de: {$student->dni}");
                return false;
            }

            // Verificar si ya se envió notificación hoy
            $notificationKey = "auto_whatsapp_notification_{$student->dni}_{$date}";
            if (cache()->has($notificationKey)) {
                \Log::info("Notificación ya enviada hoy para: {$student->dni}");
                return true; // Considerar como éxito para no reintentar
            }

            $message = "🚨 *Notificación Automática de Falta* 🚨\n\n";
            $message .= "Hola {$parentName},\n\n";
            $message .= "Le informamos que *{$student->first_name} {$student->last_name}* ";
            $message .= "no ha registrado asistencia el día *{$date}*.\n\n";
            $message .= "📝 *Estado:* FALTA AUTOMÁTICA\n";
            $message .= "🏫 *Grado/Sección:* {$student->grade->name} {$student->classroom->name}\n";
            $message .= "⏰ *Hora de corte:* 8:00 AM\n\n";
            $message .= "Por favor, contacte con la institución educativa para justificar la falta.\n\n";
            $message .= "📞 *Contacto Colegio:* +51 123 456 789\n";
            $message .= "ℹ️  Este es un mensaje automático, por favor no responda.";

            // Enviar mensaje usando Twilio
            $sent = $this->sendTwilioWhatsApp($parentPhone, $message);

            if ($sent) {
                // Marcar como notificado por hoy (expira en 24 horas)
                cache()->put($notificationKey, true, now()->addHours(24));
                \Log::info("Notificación automática WhatsApp enviada a: {$parentPhone}");
                return true;
            } else {
                \Log::error("Error al enviar notificación automática a: {$parentPhone}");
                return false;
            }

        } catch (\Exception $e) {
            \Log::error("Error en sendAutomaticWhatsAppNotification: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Verificar y enviar notificaciones pendientes
     */
    public function checkAndSendNotifications(Request $request)
    {
        try {
            $today = Carbon::now('America/Lima')->toDateString();
            $currentTime = Carbon::now('America/Lima');
            
            // Verificar si es después de las 8:00 AM
            if ($currentTime->format('H:i') < '08:00') {
                return response()->json([
                    'success' => false,
                    'message' => 'Las notificaciones automáticas se envían después de las 8:00 AM'
                ]);
            }

            // Verificar si ya se ejecutó hoy
            $executionKey = "auto_notifications_executed_{$today}";
            if (cache()->has($executionKey)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Las notificaciones automáticas ya se ejecutaron hoy'
                ]);
            }

            // Ejecutar notificaciones automáticas
            $result = $this->sendAutomaticAbsenceNotifications();

            // Marcar como ejecutado hoy (expira en 26 horas para cubrir todo el día)
            cache()->put($executionKey, true, now()->addHours(26));

            return $result;

        } catch (\Exception $e) {
            \Log::error('Error en checkAndSendNotifications: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al verificar notificaciones: ' . $e->getMessage()
            ], 500);
        }
    }

    private function getExportData($request)
    {
        $query = Attendance::with(['student.grade', 'student.classroom']);
        
        if ($request->filled('grade_id')) {
            $query->whereHas('student', function($q) use ($request) {
                $q->where('grade_id', $request->grade_id);
            });
        }
        
        if ($request->filled('classroom_id')) {
            $query->whereHas('student', function($q) use ($request) {
                $q->where('classroom_id', $request->classroom_id);
            });
        }
        
        if ($request->filled('date_from') && $request->filled('date_to')) {
            $query->whereBetween('created_at', [
                Carbon::parse($request->date_from)->startOfDay(),
                Carbon::parse($request->date_to)->endOfDay()
            ]);
        }
        
        return $query->orderBy('created_at', 'desc')->get();
    }
}