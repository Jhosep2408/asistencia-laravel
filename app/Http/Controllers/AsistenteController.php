<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AsistenteController extends Controller
{
    public function index()
    {
        return view('admin.asistente');
    }

    public function asistente()
    {
        return $this->index();
    }

    public function processQuery(Request $request)
    {
        try {
            $userQuery = $request->input('query', '');
            
            if (empty($userQuery)) {
                return response()->json([
                    'success' => false,
                    'message' => 'La consulta está vacía'
                ]);
            }

            // Procesar la consulta de manera segura
            $response = $this->processQuerySafely($userQuery);

            return response()->json([
                'success' => true,
                'message' => $response['message'],
                'data' => $response['data'] ?? null,
                'thinking' => $response['thinking'] ?? []
            ]);

        } catch (\Exception $e) {
            Log::error('Error in processQuery: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error interno del servidor. Por favor, intenta nuevamente.'
            ]);
        }
    }

private function processQuerySafely($query)
{
    $thinking = [];
    $message = "";
    $queryLower = strtolower(trim($query));

    $thinking[] = "🔍 Analizando: \"$query\"";

    // CONSULTA: Instrucciones para buscar por DNI
    if ($this->containsAny($queryLower, ['cómo buscar por dni', 'como buscar por dni', 'buscar por dni', 'instrucciones dni'])) {
        return $this->handleDNIInstructions($thinking);
    }
    // CONSULTA: Instrucciones para información de grados
    elseif ($this->containsAny($queryLower, ['cómo consultar información de grados', 'como consultar información de grados', 'información de grados', 'instrucciones grados'])) {
        return $this->handleGradeInstructions($thinking);
    }
    // CONSULTA: ¿Quiénes faltaron hoy?
    elseif ($this->containsAny($queryLower, ['quiénes faltaron', 'quienes faltaron', 'faltaron hoy', 'ausentes hoy'])) {
        return $this->handleAbsentToday($thinking);
    }
    // CONSULTA: Asistencia de hoy
    elseif ($this->containsAny($queryLower, ['asistencia hoy', 'asistencia de hoy', 'cómo estuvo la asistencia'])) {
        return $this->handleAttendanceToday($thinking);
    }
    // CONSULTA: Buscar por DNI (número específico)
    elseif (preg_match('/\b\d{8}\b/', $query, $dniMatches)) {
        return $this->handleSearchByDNI($dniMatches[0], $thinking);
    }
    // CONSULTA: Información de grado específico
    elseif ($this->containsAny($queryLower, ['grado', 'curso', 'aula', 'año', 'sección']) || preg_match('/(\d+)(?:ro|to|do)?\s*([a-zA-Z])?/', $queryLower)) {
        return $this->handleGradeInfo($queryLower, $thinking);
    }
    // CONSULTA: Reporte general
    elseif ($this->containsAny($queryLower, ['reporte', 'estadística', 'resumen', 'reporte general'])) {
        return $this->handleGeneralReport($thinking);
    }
    // Agrega esto en el método processQuerySafely, después de las otras condiciones:
    elseif ($this->containsAny($queryLower, ['diagnóstico grados', 'debug grados', 'verificar grados'])) {
        return $this->debugGradeSystem($thinking);
    }
    // CONSULTA GENERAL
    else {
        return $this->handleGeneralHelp($thinking);
    }
}


private function handleDNIInstructions($thinking)
{
    $thinking[] = "📝 Proporcionando instrucciones para búsqueda por DNI";
    
    $message = "🔍 **Cómo buscar estudiantes por DNI**\n\n";
    $message .= "Puedes buscar información de cualquier estudiante usando su número de DNI (8 dígitos).\n\n";
    
    $message .= "**📋 Formas de buscar:**\n";
    $message .= "• **Directo con DNI:** `12345678`\n";
    $message .= "• **Preguntando:** \"Buscar estudiante con DNI 87654321\"\n";
    $message .= "• **Solicitando info:** \"Información del DNI 11223344\"\n\n";
    
    $message .= "**📊 Información que obtendrás:**\n";
    $message .= "✅ Nombre completo del estudiante\n";
    $message .= "✅ Grado y sección\n";
    $message .= "✅ Teléfono del tutor\n";
    $message .= "✅ Estadísticas de asistencia\n";
    $message .= "✅ Historial de asistencias\n\n";
    
    $message .= "**💡 Ejemplos prácticos:**\n";
    $message .= "• `12345678` → Información de María García\n";
    $message .= "• `87654321` → Datos de Juan Pérez\n";
    $message .= "• `11223344` → Estado de Carlos López\n\n";
    
    $message .= "**🚀 ¡Pruébalo ahora!**\n";
    $message .= "Escribe cualquier DNI de 8 dígitos y te mostraré toda la información disponible.";

    return [
        'message' => $message,
        'data' => ['type' => 'dni_instructions'],
        'thinking' => $thinking
    ];
}

private function handleGradeInstructions($thinking)
{
    $thinking[] = "🏫 Proporcionando instrucciones para consulta de grados";
    
    $message = "🏫 **Cómo consultar información de grados**\n\n";
    $message .= "Puedes obtener información detallada de cualquier grado o sección del sistema escolar.\n\n";
    
    $message .= "**📋 Formas de consultar:**\n";
    $message .= "• **Por grado específico:** `4to A`\n";
    $message .= "• **Solo el grado:** `3ro` o `5to grado`\n";
    $message .= "• **Preguntando:** \"Información de 2do B\"\n";
    $message .= "• **Por sección:** \"Cómo está la sección C\"\n\n";
    
    $message .= "**📊 Información que obtendrás:**\n";
    $message .= "✅ Total de estudiantes en el grado\n";
    $message .= "✅ Asistencia del día de hoy\n";
    $message .= "✅ Tasa de asistencia actual\n";
    $message .= "✅ Distribución por secciones\n";
    $message .= "✅ Comparativa con otros grados\n\n";
    
    $message .= "**🎯 Grados disponibles:**\n";
    
    // Obtener grados disponibles de la base de datos
    try {
        $grades = DB::table('grades')
            ->select('name')
            ->distinct()
            ->orderBy('name')
            ->get();
            
        if ($grades->count() > 0) {
            $message .= "• " . $grades->pluck('name')->implode("\n• ") . "\n\n";
        } else {
            $message .= "• 1ro Primaria\n• 2do Primaria\n• 3ro Primaria\n• 4to Primaria\n• 5to Primaria\n• 6to Primaria\n\n";
        }
    } catch (\Exception $e) {
        $message .= "• 1ro Primaria\n• 2do Primaria\n• 3ro Primaria\n• 4to Primaria\n• 5to Primaria\n• 6to Primaria\n\n";
    }
    
    $message .= "**💡 Ejemplos prácticos:**\n";
    $message .= "• `4to A` → Información de 4to grado sección A\n";
    $message .= "• `3ro` → Datos generales de 3er grado\n";
    $message .= "• `5to B` → Estado de 5to grado sección B\n";
    $message .= "• `2do C` → Asistencia de 2do grado sección C\n\n";
    
    $message .= "**🏆 Secciones típicas:**\n";
    $message .= "• A, B, C, D (por cada grado)\n";
    $message .= "• Mañana y Tarde (en algunos casos)\n\n";
    
    $message .= "**🚀 ¡Pruébalo ahora!**\n";
    $message .= "Escribe cualquier grado (ej: 4to A) y te mostraré toda la información disponible.";

    return [
        'message' => $message,
        'data' => ['type' => 'grade_instructions'],
        'thinking' => $thinking
    ];
}

    /**
     * Función auxiliar para verificar múltiples palabras en un string
     */
    private function containsAny($haystack, $needles)
    {
        foreach ($needles as $needle) {
            if (str_contains($haystack, $needle)) {
                return true;
            }
        }
        return false;
    }

    private function handleAbsentToday($thinking)
    {
        $thinking[] = "📊 Buscando ausentes de hoy";
        
        try {
            $today = Carbon::today()->format('Y-m-d');
            
            // Usar DB facade directamente para evitar problemas con modelos
            $absentStudents = DB::table('attendances')
                ->join('students', 'attendances.student_dni', '=', 'students.dni')
                ->whereDate('attendances.date', $today) // Cambiado de attendance_date a date
                ->where('attendances.status', 'absent')
                ->select('students.dni', 'students.first_name', 'students.last_name', 'students.grade_id', 'students.classroom_id')
                ->get();

            if ($absentStudents->count() > 0) {
                $message = "❌ **Estudiantes que faltaron hoy** ({$absentStudents->count()})\n\n";
                
                foreach ($absentStudents as $student) {
                    $fullName = $student->first_name . ' ' . $student->last_name;
                    
                    // Obtener información del grado y aula
                    $grade = DB::table('grades')->where('id', $student->grade_id)->first();
                    $classroom = DB::table('classrooms')->where('id', $student->classroom_id)->first();
                    
                    $gradeName = $grade ? $grade->name : 'No asignado';
                    $classroomName = $classroom ? $classroom->name : 'No asignada';
                    
                    $message .= "• **{$fullName}** - {$gradeName} {$classroomName} - DNI: {$student->dni}\n";
                }
            } else {
                $message = "🎉 **¡Excelente noticia!**\n\n";
                $message .= "No hay estudiantes ausentes hoy. Todos asistieron a clases.";
            }

            $message .= "\n📅 Fecha: " . Carbon::today()->format('d/m/Y');

            return [
                'message' => $message,
                'data' => ['type' => 'absent_today', 'count' => $absentStudents->count()],
                'thinking' => $thinking
            ];

        } catch (\Exception $e) {
            Log::error('Error en handleAbsentToday: ' . $e->getMessage());
            
            $message = "❌ Error al buscar la información de ausentes.\n\n";
            $message .= "Detalle técnico: " . $e->getMessage();
            
            return [
                'message' => $message,
                'thinking' => array_merge($thinking, ["❌ Error: " . $e->getMessage()])
            ];
        }
    }

    private function handleAttendanceToday($thinking)
    {
        $thinking[] = "📈 Calculando estadísticas de hoy";
        
        try {
            $today = Carbon::today()->format('Y-m-d');
            
            $totalStudents = DB::table('students')->count();
            $presentes = DB::table('attendances')
                ->whereDate('date', $today) // Cambiado de attendance_date a date
                ->where('status', 'present')
                ->count();
            $ausentes = DB::table('attendances')
                ->whereDate('date', $today) // Cambiado de attendance_date a date
                ->where('status', 'absent')
                ->count();
            $tardios = DB::table('attendances')
                ->whereDate('date', $today) // Cambiado de attendance_date a date
                ->where('status', 'late')
                ->count();
            
            $tasa = $totalStudents > 0 ? round(($presentes / $totalStudents) * 100, 1) : 0;

            $message = "📊 **Asistencia de Hoy**\n\n";
            $message .= "👥 **Total estudiantes:** $totalStudents\n";
            $message .= "✅ **Presentes:** $presentes\n";
            $message .= "❌ **Ausentes:** $ausentes\n";
            $message .= "⏰ **Tardíos:** $tardios\n";
            $message .= "📈 **Tasa de asistencia:** {$tasa}%\n\n";
            
            if ($tasa >= 90) {
                $message .= "🎉 **¡Excelente!** La asistencia hoy es muy buena.";
            } elseif ($tasa < 70) {
                $message .= "⚠️ **Atención:** La asistencia hoy es baja.";
            } else {
                $message .= "📝 **Regular:** La asistencia está dentro de lo esperado.";
            }

            $message .= "\n\n📅 *Fecha: " . Carbon::today()->format('d/m/Y') . "*";

            return [
                'message' => $message,
                'data' => [
                    'type' => 'attendance_today',
                    'present' => $presentes,
                    'absent' => $ausentes,
                    'late' => $tardios,
                    'attendance_rate' => $tasa
                ],
                'thinking' => $thinking
            ];

        } catch (\Exception $e) {
            Log::error('Error en handleAttendanceToday: ' . $e->getMessage());
            
            $message = "❌ Error al calcular las estadísticas de hoy.\n\n";
            $message .= "Detalle técnico: " . $e->getMessage();
            
            return [
                'message' => $message,
                'thinking' => array_merge($thinking, ["❌ Error: " . $e->getMessage()])
            ];
        }
    }

    private function handleSearchByDNI($dni, $thinking)
    {
        $thinking[] = "🔍 Buscando estudiante con DNI: $dni";
        
        try {
            $student = DB::table('students')
                ->where('dni', $dni)
                ->first();

            if ($student) {
                $fullName = $student->first_name . ' ' . $student->last_name;
                
                // Obtener información del grado y aula
                $grade = DB::table('grades')->where('id', $student->grade_id)->first();
                $classroom = DB::table('classrooms')->where('id', $student->classroom_id)->first();
                
                $gradeName = $grade ? $grade->name : 'No asignado';
                $classroomName = $classroom ? $classroom->name : 'No asignada';
                
                // Obtener estadísticas de asistencia del estudiante
                $attendanceStats = DB::table('attendances')
                    ->where('student_dni', $dni)
                    ->selectRaw('COUNT(*) as total, 
                                SUM(CASE WHEN status = "present" THEN 1 ELSE 0 END) as present,
                                SUM(CASE WHEN status = "absent" THEN 1 ELSE 0 END) as absent,
                                SUM(CASE WHEN status = "late" THEN 1 ELSE 0 END) as late')
                    ->first();

                $total = $attendanceStats->total ?? 0;
                $present = $attendanceStats->present ?? 0;
                $rate = $total > 0 ? round(($present / $total) * 100, 1) : 0;

                $message = "🎓 **Información del Estudiante**\n\n";
                $message .= "**Nombre:** {$fullName}\n";
                $message .= "**DNI:** {$student->dni}\n";
                $message .= "**Grado:** {$gradeName} {$classroomName}\n";
                $message .= "**Teléfono del tutor:** {$student->guardian_phone}\n\n";
                
                $message .= "📊 **Estadísticas de Asistencia:**\n";
                $message .= "• Total registros: $total\n";
                $message .= "• Asistencias: $present\n";
                $message .= "• Tasa: {$rate}%\n\n";
                
                $message .= "¿Qué información específica necesitas sobre {$fullName}?";

                return [
                    'message' => $message,
                    'data' => [
                        'type' => 'student_info',
                        'attendance_stats' => [
                            'total' => $total,
                            'present' => $present,
                            'rate' => $rate
                        ]
                    ],
                    'thinking' => $thinking
                ];
            } else {
                return [
                    'message' => "❌ No encontré ningún estudiante con DNI: $dni\n\n¿Podrías verificar que el DNI sea correcto?",
                    'thinking' => $thinking
                ];
            }

        } catch (\Exception $e) {
            Log::error('Error en handleSearchByDNI: ' . $e->getMessage());
            
            $message = "❌ Error al buscar el estudiante.\n\n";
            $message .= "Por favor, verifica que el DNI sea correcto.";
            
            return [
                'message' => $message,
                'thinking' => array_merge($thinking, ["❌ Error: " . $e->getMessage()])
            ];
        }
    }

private function handleGradeInfo($query, $thinking)
{
    $thinking[] = "🏫 Buscando información de grados";
    
    try {
        // Extraer número de grado y sección de la consulta
        preg_match('/(\d+)(?:ro|to|do)?\s*([a-zA-Z])?/', $query, $matches);
        
        $message = "🏫 **Información de Grados**\n\n";
        
        if (!empty($matches)) {
            $gradoNumero = $matches[1];
            $seccion = isset($matches[2]) ? strtoupper($matches[2]) : '';
            
            $thinking[] = "Buscando grado: $gradoNumero, sección: '$seccion'";
            
            // Construir diferentes formatos de búsqueda para el grado
            $formatosBusqueda = [
                $gradoNumero . '° ' . $seccion,
                $gradoNumero . '°' . $seccion,
                $gradoNumero . ' ' . $seccion,
                $gradoNumero . '° Grado ' . $seccion,
                $gradoNumero . 'to ' . $seccion,
                $gradoNumero . 'do ' . $seccion,
                $gradoNumero . 'ro ' . $seccion,
                $gradoNumero . '°', // Solo el grado sin sección
                $gradoNumero . 'to',
                $gradoNumero . 'do',
                $gradoNumero . 'ro'
            ];
            
            $gradoNombreBusqueda = $gradoNumero . '°' . ($seccion ? ' ' . $seccion : '');
            $message .= "**Buscando información para:** $gradoNombreBusqueda\n\n";
            
            // BUSCAR GRADO - Múltiples estrategias
            $grade = null;
            
            // Estrategia 1: Buscar en todos los formatos
            foreach ($formatosBusqueda as $formato) {
                if (trim($formato) === '') continue;
                $grade = DB::table('grades')->where('name', 'like', "%" . trim($formato) . "%")->first();
                if ($grade) {
                    $thinking[] = "✅ Grado encontrado con formato: '$formato'";
                    break;
                }
            }
            
            if ($grade) {
                $thinking[] = "✅ Grado encontrado: {$grade->name} (ID: {$grade->id})";
                
                // BUSCAR AULA si hay sección específica
                $classroom = null;
                $classroomFilterApplied = false;
                
                if ($seccion) {
                    $thinking[] = "🔍 Buscando aula para sección: '$seccion'";
                    
                    // Buscar aula que coincida con la sección
                    $classroom = DB::table('classrooms')
                        ->where('name', 'like', "%$seccion%")
                        ->orWhere('name', 'like', "%" . strtolower($seccion) . "%")
                        ->orWhere('name', 'like', "%" . strtoupper($seccion) . "%")
                        ->first();
                    
                    if ($classroom) {
                        $thinking[] = "✅ Aula encontrada: {$classroom->name} (ID: {$classroom->id})";
                        $classroomFilterApplied = true;
                    } else {
                        $thinking[] = "⚠️ No se encontró aula específica para la sección: '$seccion'";
                        $thinking[] = "ℹ️ Mostrando todos los estudiantes del grado {$grade->name}";
                    }
                }
                
                // BUSCAR ESTUDIANTES
                $studentsQuery = DB::table('students')->where('grade_id', $grade->id);
                
                if ($classroomFilterApplied) {
                    $studentsQuery->where('classroom_id', $classroom->id);
                    $thinking[] = "🎯 Aplicando filtro por aula: {$classroom->name}";
                }
                
                $students = $studentsQuery->get();
                $studentsCount = $students->count();
                
                $thinking[] = "📊 Estudiantes encontrados: $studentsCount";
                
                // Mostrar información básica
                $message .= "• **Estudiantes encontrados:** $studentsCount\n";
                
                // Asistencia de hoy para este grado
                $today = Carbon::today()->format('Y-m-d');
                $attendanceQuery = DB::table('attendances')
                    ->join('students', 'attendances.student_dni', '=', 'students.dni')
                    ->where('students.grade_id', $grade->id);
                
                if ($classroomFilterApplied) {
                    $attendanceQuery->where('students.classroom_id', $classroom->id);
                }
                
                $attendanceToday = $attendanceQuery->whereDate('attendances.date', $today)->get();
                $presentCount = $attendanceToday->where('status', 'present')->count();
                $attendanceRate = $studentsCount > 0 ? round(($presentCount / $studentsCount) * 100, 1) : 0;
                
                $message .= "• **Asistencia hoy:** $presentCount/$studentsCount ({$attendanceRate}%)\n";
                
                // Mostrar estudiantes si hay resultados
                if ($studentsCount > 0) {
                    $message .= "\n**👥 Lista de estudiantes ($studentsCount):**\n";
                    foreach ($students as $student) {
                        $message .= "• {$student->first_name} {$student->last_name}";
                        
                        // Mostrar estado de asistencia de hoy si está disponible
                        $attendanceStatus = $attendanceToday->where('student_dni', $student->dni)->first();
                        if ($attendanceStatus) {
                            $statusIcon = $attendanceStatus->status == 'present' ? '✅' : 
                                         ($attendanceStatus->status == 'absent' ? '❌' : '⏰');
                            $message .= " $statusIcon";
                        }
                        
                        // Mostrar información del aula si está disponible
                        if (!$classroomFilterApplied) {
                            $studentClassroom = DB::table('classrooms')->where('id', $student->classroom_id)->first();
                            if ($studentClassroom) {
                                $message .= " [{$studentClassroom->name}]";
                            }
                        }
                        
                        $message .= "\n";
                    }
                } else {
                    $message .= "\n⚠️ **No se encontraron estudiantes** en este grado/sección.\n";
                    
                    if ($classroomFilterApplied) {
                        $message .= "**Posibles causas:**\n";
                        $message .= "- No hay estudiantes en {$grade->name} {$classroom->name}\n";
                        $message .= "- Los estudiantes no están asignados a esta aula\n";
                        $message .= "- Problema en la asignación de aulas\n";
                    } else {
                        $message .= "**Posibles causas:**\n";
                        $message .= "- No hay estudiantes en {$grade->name}\n";
                        $message .= "- Los estudiantes no están asignados a este grado\n";
                    }
                    
                    $message .= "\n💡 **Sugerencias:**\n";
                    $message .= "- Prueba con 'diagnóstico grados' para ver el estado del sistema\n";
                    $message .= "- Verifica la asignación de grados y aulas\n";
                }
                
                // Información adicional del grado
                $message .= "\n**📋 Información del grado:**\n";
                $message .= "• **Nombre:** {$grade->name}\n";
                if ($classroomFilterApplied) {
                    $message .= "• **Aula filtrada:** {$classroom->name}\n";
                } else {
                    // Mostrar todas las aulas disponibles para este grado
                    $classroomsInGrade = DB::table('classrooms')
                        ->join('students', 'classrooms.id', '=', 'students.classroom_id')
                        ->where('students.grade_id', $grade->id)
                        ->select('classrooms.name')
                        ->distinct()
                        ->get();
                    
                    if ($classroomsInGrade->count() > 0) {
                        $message .= "• **Aulas disponibles:** " . $classroomsInGrade->pluck('name')->implode(', ') . "\n";
                    }
                }
                
            } else {
                $message .= "❌ **No se encontró el grado** $gradoNombreBusqueda\n\n";
                $message .= "**Grados disponibles en el sistema:**\n";
                
                // Mostrar grados disponibles
                $availableGrades = DB::table('grades')->select('name')->get();
                if ($availableGrades->count() > 0) {
                    foreach ($availableGrades as $availableGrade) {
                        $message .= "• {$availableGrade->name}\n";
                    }
                } else {
                    $message .= "• No hay grados registrados en el sistema\n";
                }
                
                $message .= "\n💡 **Sugerencias:**\n";
                $message .= "- Verifica que el grado exista\n";
                $message .= "- Usa 'diagnóstico grados' para ver el estado completo\n";
                $message .= "- Contacta al administrador del sistema\n";
            }
        } else {
            $message .= "❌ **No pude identificar el grado** en tu consulta.\n\n";
            $message .= "**Ejemplos válidos:**\n";
            $message .= "• \"4to A\"\n";
            $message .= "• \"3ro B\"\n"; 
            $message .= "• \"5to grado\"\n";
            $message .= "• \"2do C\"\n";
            $message .= "• \"4° A\"\n";
            $message .= "• \"3° B\"\n\n";
            
            $message .= "**Formatos aceptados:**\n";
            $message .= "- Número + sección: `4A`, `3B`, `5 C`\n";
            $message .= "- Con ordinal: `4to A`, `3ro B`, `5to C`\n";
            $message .= "- Con símbolo de grado: `4° A`, `3° B`\n";
        }
        
        // Información general del sistema
        $totalStudents = DB::table('students')->count();
        $totalGrades = DB::table('grades')->count();
        $totalClassrooms = DB::table('classrooms')->count();
        
        $message .= "\n📊 **Resumen General del Sistema:**\n";
        $message .= "• Total estudiantes: $totalStudents\n";
        $message .= "• Grados registrados: $totalGrades\n";
        $message .= "• Secciones: $totalClassrooms\n\n";
        
        $message .= "💡 **Para mejores resultados:**\n";
        $message .= "• Usa el formato: `[número]° [sección]` (ej: 4° A)\n";
        $message .= "• Verifica que el grado y sección existan\n";
        $message .= "• Prueba con 'diagnóstico grados' para verificar el sistema\n";

        return [
            'message' => $message,
            'thinking' => $thinking
        ];

    } catch (\Exception $e) {
        Log::error('Error en handleGradeInfo: ' . $e->getMessage());
        
        $message = "❌ Error al buscar información de grados.\n\n";
        $message .= "**Detalle técnico:** " . $e->getMessage();
        $message .= "\n\n**Solución:**\n";
        $message .= "1. Verifica la conexión a la base de datos\n";
        $message .= "2. Asegúrate de que las tablas existan\n";
        $message .= "3. Contacta al administrador del sistema\n";
        
        return [
            'message' => $message,
            'thinking' => array_merge($thinking, ["❌ Error: " . $e->getMessage()])
        ];
    }
}


private function debugGradeSystem($thinking)
{
    $thinking[] = "🔧 Ejecutando diagnóstico completo del sistema";
    
    try {
        $message = "🔧 **Diagnóstico Completo del Sistema**\n\n";
        
        // Verificar grados existentes
        $grades = DB::table('grades')->get();
        $message .= "📚 **Grados en el sistema:** {$grades->count()}\n";
        foreach ($grades as $grade) {
            $studentCount = DB::table('students')->where('grade_id', $grade->id)->count();
            
            // Obtener aulas de este grado
            $classroomsInGrade = DB::table('students')
                ->join('classrooms', 'students.classroom_id', '=', 'classrooms.id')
                ->where('students.grade_id', $grade->id)
                ->select('classrooms.name')
                ->distinct()
                ->get();
            
            $classroomList = $classroomsInGrade->count() > 0 ? 
                '[' . $classroomsInGrade->pluck('name')->implode(', ') . ']' : 
                '[Sin aulas asignadas]';
            
            $message .= "• {$grade->name} (ID: {$grade->id}) - {$studentCount} estudiantes {$classroomList}\n";
        }
        
        $message .= "\n";
        
        // Verificar aulas existentes
        $classrooms = DB::table('classrooms')->get();
        $message .= "🏫 **Aulas en el sistema:** {$classrooms->count()}\n";
        foreach ($classrooms as $classroom) {
            $studentCount = DB::table('students')->where('classroom_id', $classroom->id)->count();
            $message .= "• {$classroom->name} (ID: {$classroom->id}) - {$studentCount} estudiantes\n";
        }
        
        $message .= "\n";
        
        // Verificar estudiantes totales
        $totalStudents = DB::table('students')->count();
        $message .= "👥 **Total de estudiantes:** {$totalStudents}\n";
        
        // Verificar estudiantes sin grado
        $studentsWithoutGrade = DB::table('students')->whereNull('grade_id')->count();
        if ($studentsWithoutGrade > 0) {
            $message .= "⚠️ **Estudiantes sin grado asignado:** {$studentsWithoutGrade}\n";
        }
        
        // Verificar estudiantes sin aula
        $studentsWithoutClassroom = DB::table('students')->whereNull('classroom_id')->count();
        if ($studentsWithoutClassroom > 0) {
            $message .= "⚠️ **Estudiantes sin aula asignada:** {$studentsWithoutClassroom}\n";
        }
        
        $message .= "\n";
        
        // Verificar distribución de estudiantes por grado y aula
        $message .= "📊 **Distribución de estudiantes:**\n";
        foreach ($grades as $grade) {
            $classroomDistribution = DB::table('students')
                ->join('classrooms', 'students.classroom_id', '=', 'classrooms.id')
                ->where('students.grade_id', $grade->id)
                ->select('classrooms.name', DB::raw('COUNT(*) as count'))
                ->groupBy('classrooms.name')
                ->get();
            
            if ($classroomDistribution->count() > 0) {
                $message .= "• **{$grade->name}:** ";
                $distribution = [];
                foreach ($classroomDistribution as $dist) {
                    $distribution[] = "{$dist->name}: {$dist->count}";
                }
                $message .= implode(', ', $distribution) . "\n";
            }
        }
        
        $message .= "\n💡 **Recomendaciones:**\n";
        if ($studentsWithoutGrade > 0) {
            $message .= "• Asigna grados a los estudiantes sin grado\n";
        }
        if ($studentsWithoutClassroom > 0) {
            $message .= "• Asigna aulas a los estudiantes sin aula\n";
        }
        if ($grades->count() == 0) {
            $message .= "• Registra grados en el sistema\n";
        }
        if ($classrooms->count() == 0) {
            $message .= "• Registra aulas en el sistema\n";
        }
        
        return [
            'message' => $message,
            'thinking' => $thinking
        ];
        
    } catch (\Exception $e) {
        return [
            'message' => "❌ Error en diagnóstico: " . $e->getMessage() . "\n\nVerifica la configuración de la base de datos.",
            'thinking' => $thinking
        ];
    }
}

    private function handleGeneralReport($thinking)
    {
        $thinking[] = "📈 Generando reporte general";
        
        try {
            $totalStudents = DB::table('students')->count();
            $totalGrades = DB::table('grades')->count();
            $totalClassrooms = DB::table('classrooms')->count();
            $today = Carbon::today()->format('Y-m-d');
            
            $presentes = DB::table('attendances')
                ->whereDate('date', $today) // Cambiado de attendance_date a date
                ->where('status', 'present')
                ->count();
            
            $tasa = $totalStudents > 0 ? round(($presentes / $totalStudents) * 100, 1) : 0;

            $message = "📊 **Reporte General del Sistema**\n\n";
            $message .= "👥 **Total Estudiantes:** $totalStudents\n";
            $message .= "🏫 **Total Grados:** $totalGrades\n";
            $message .= "📚 **Total Secciones:** $totalClassrooms\n";
            $message .= "📅 **Asistencia de Hoy:**\n";
            $message .= "   • ✅ Presentes: $presentes\n";
            $message .= "   • 📈 Tasa: {$tasa}%\n\n";
            
            $message .= "**Estado del sistema:** " . ($tasa >= 80 ? '✅ Óptimo' : '⚠️ Necesita atención');
            $message .= "\n\n📅 *Fecha del reporte: " . Carbon::today()->format('d/m/Y') . "*";

            return [
                'message' => $message,
                'data' => ['type' => 'system_report'],
                'thinking' => $thinking
            ];

        } catch (\Exception $e) {
            Log::error('Error en handleGeneralReport: ' . $e->getMessage());
            
            $message = "❌ Error al generar el reporte general.\n\n";
            $message .= "Por favor, intenta nuevamente más tarde.";
            
            return [
                'message' => $message,
                'thinking' => array_merge($thinking, ["❌ Error: " . $e->getMessage()])
            ];
        }
    }

    private function handleGeneralHelp($thinking)
    {
        $thinking[] = "🤖 Mostrando ayuda general";
        
        $message = "🤖 **¡Hola! Soy EduAssist** 🎓\n\n";
        $message .= "Puedo ayudarte con:\n\n";
        $message .= "📊 **Asistencias:**\n";
        $message .= "• \"Asistencia de hoy\"\n";
        $message .= "• \"¿Quiénes faltaron hoy?\"\n\n";
        
        $message .= "👤 **Estudiantes:**\n";
        $message .= "• \"12345678\" (buscar por DNI)\n";
        $message .= "• \"Información de María García\"\n\n";
        
        $message .= "📈 **Reportes:**\n";
        $message .= "• \"Reporte general\"\n";
        $message .= "• \"Estadísticas del sistema\"\n\n";
        
        $message .= "🏫 **Grados:**\n";
        $message .= "• \"Información de 4to A\"\n";
        $message .= "• \"Estudiantes de 3ro B\"\n";
        $message .= "• \"Cómo está 5to grado\"\n\n";
        
        $message .= "💡 **¡Pregúntame lo que necesites!** 😊\n\n";
        $message .= "*Ejemplos:*\n";
        $message .= "*• \"¿María asistió hoy?\"*\n";
        $message .= "*• \"Cómo está la asistencia de 4to A\"*\n";
        $message .= "*• \"Quiénes faltaron el día de hoy\"*";

        return [
            'message' => $message,
            'thinking' => $thinking
        ];
    }
}