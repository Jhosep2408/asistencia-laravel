<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Student;
use App\Models\Attendance;
use App\Models\Grade;
use App\Models\Classroom;
use Carbon\Carbon;

class ChatbotController extends Controller
{
    public function processQuery(Request $request)
    {
        try {
            $query = $request->input('query');
            $history = $request->input('history', []);
            
            if (empty($query)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Por favor, escribe una pregunta.'
                ], 400);
            }

            // Obtener datos actualizados del sistema
            $systemData = $this->getRealTimeSystemData();
            
            // Intentar con Groq API primero
            $aiResponse = $this->getAIResponse($query, $systemData, $history);
            
            if ($aiResponse['success']) {
                return response()->json([
                    'success' => true,
                    'message' => $aiResponse['message'],
                    'data' => [
                        'thinking' => $aiResponse['thinking'],
                        'timestamp' => now()->toDateTimeString(),
                        'ai_generated' => true
                    ]
                ]);
            }

            // Fallback a procesamiento local inteligente
            $localResponse = $this->processLocalIntelligentQuery($query, $systemData);
            return response()->json([
                'success' => true,
                'message' => $localResponse['message'],
                'data' => [
                    'thinking' => $localResponse['thinking'],
                    'timestamp' => now()->toDateTimeString(),
                    'ai_generated' => false
                ]
            ]);

        } catch (\Exception $e) {
            \Log::error('Error en ChatbotController: ' . $e->getMessage());
            
            // Respuesta de error amigable
            return response()->json([
                'success' => false,
                'message' => '😔 Lo siento, estoy teniendo problemas técnicos. ¿Podrías intentarlo de nuevo? Mientras tanto, puedo ayudarte con consultas básicas del sistema.',
                'error' => 'Error del servidor'
            ], 500);
        }
    }

    private function getAIResponse($query, $systemData, $history)
    {
        $apiKey = env('GROQ_API_KEY');
        
        if (!$apiKey) {
            return [
                'success' => false,
                'message' => 'Configuración de IA no disponible',
                'thinking' => []
            ];
        }

        try {
            $messages = $this->buildAIConversation($query, $systemData, $history);
            
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type' => 'application/json',
            ])->timeout(30)->post('https://api.groq.com/openai/v1/chat/completions', [
                'model' => 'llama3-8b-8192',
                'messages' => $messages,
                'temperature' => 0.7,
                'max_tokens' => 1024,
                'stream' => false
            ]);

            if ($response->successful()) {
                $aiResponse = $response->json()['choices'][0]['message']['content'];
                
                return [
                    'success' => true,
                    'message' => $this->cleanAIResponse($aiResponse),
                    'thinking' => [
                        "🧠 Procesando con IA...",
                        "🔍 Analizando contexto del sistema",
                        "💭 Generando respuesta conversacional"
                    ]
                ];
            }

            throw new \Exception('API error: ' . $response->status());

        } catch (\Exception $e) {
            \Log::warning('Error en Groq API: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => '',
                'thinking' => []
            ];
        }
    }

    private function buildAIConversation($query, $systemData, $history)
    {
        $systemPrompt = "Eres 'EduAssist', un asistente escolar inteligente y amigable. Tu personalidad es:

- **Empático y natural**: Hablas como un compañero de trabajo comprensivo
- **Detallado pero conciso**: Das información completa sin ser redundante  
- **Proactivo**: Ofreces información adicional útil
- **Conversacional**: Usas lenguaje natural, emojis apropiados y un tono cálido
- **Preciso**: Basas tus respuestas ÚNICAMENTE en los datos proporcionados

**CONTEXTO DEL SISTEMA ESCOLAR:**
Fecha actual: " . now()->format('d/m/Y') . "
Total estudiantes: " . $systemData['total_estudiantes'] . "
Asistencias hoy: " . $systemData['asistencias_hoy'] . "
Faltas hoy: " . $systemData['faltas_hoy'] . "

**ESTUDIANTES DESTACADOS:**
" . $this->formatStudentsForAI($systemData['estudiantes_destacados']) . "

**INSTRUCCIONES CRÍTICAS:**
1. Si preguntan por un estudiante específico, BUSCA en la lista proporcionada
2. Si no encuentras el estudiante, sé honesto pero amable
3. Para grados, usa la información de distribución por grados
4. Mantén tus respuestas entre 2-4 párrafos máximo
5. Usa emojis relevantes pero no exageres
6. Sé natural como si estuvieras conversando

**EJEMPLOS DE RESPUESTA:**
✅ '¡Hola! Veo que María García del 4°A asistió hoy. Llegó puntual a las 8:05 am. ¡Buen rendimiento! 📚'
✅ 'En cuanto a 3°B, tienen 18 estudiantes y hoy hubo 15 asistencias. Falta revisar 3 registros. 📊'
✅ 'No encuentro un estudiante llamado Roberto en el sistema. ¿Podrías confirmarme el nombre completo o DNI? 🤔'

Responde de manera natural y útil:";

        $messages = [
            [
                'role' => 'system',
                'content' => $systemPrompt
            ]
        ];

        // Agregar historial de conversación
        foreach ($history as $msg) {
            $messages[] = $msg;
        }

        // Agregar consulta actual
        $messages[] = [
            'role' => 'user', 
            'content' => "Consulta: " . $query . "\n\nResponde de manera natural y conversacional:"
        ];

        return $messages;
    }

    private function processLocalIntelligentQuery($query, $systemData)
    {
        $thinking = [];
        $lowerQuery = strtolower($query);
        
        $thinking[] = "🔍 Analizando: '" . $query . "'";

        // Búsqueda inteligente de estudiantes
        $studentMatch = $this->findStudentIntelligently($query, $systemData['estudiantes_destacados']);
        
        if ($studentMatch) {
            $thinking[] = "👤 Encontrado: " . $studentMatch['full_name'];
            return $this->formatStudentResponse($studentMatch, $thinking);
        }

        // Detección de intención conversacional
        $intent = $this->detectIntent($lowerQuery);
        
        switch ($intent) {
            case 'attendance_today':
                $thinking[] = "📊 Procesando asistencia del día";
                return $this->getConversationalTodayAttendance($systemData, $thinking);
                
            case 'student_absence':
                $thinking[] = "❌ Buscando ausentes hoy";
                return $this->getConversationalAbsentStudents($systemData, $thinking);
                
            case 'grade_info':
                $grade = $this->extractGradeFromQuery($query);
                if ($grade) {
                    $thinking[] = "🎓 Consulta para: " . $grade['name'];
                    return $this->getConversationalGradeInfo($grade, $systemData, $thinking);
                }
                break;
                
            case 'student_search':
                $thinking[] = "🔍 Búsqueda general de estudiantes";
                return $this->getStudentSearchResponse($query, $systemData, $thinking);
        }

        // Respuesta conversacional por defecto
        return $this->getConversationalDefaultResponse($query, $systemData, $thinking);
    }

    private function findStudentIntelligently($query, $students)
    {
        $queryLower = strtolower(trim($query));
        
        foreach ($students as $student) {
            $studentName = strtolower($student['full_name']);
            $studentDNI = $student['dni'];
            
            // Búsqueda por DNI
            if (str_contains($query, $studentDNI)) {
                return $student;
            }
            
            // Búsqueda por nombre (coincidencias parciales)
            $nameParts = explode(' ', $studentName);
            foreach ($nameParts as $part) {
                if (strlen($part) > 2 && str_contains($queryLower, $part)) {
                    return $student;
                }
            }
            
            // Búsqueda por apodo o variaciones comunes
            if ($this->checkNameVariations($queryLower, $studentName)) {
                return $student;
            }
        }
        
        return null;
    }

    private function checkNameVariations($query, $studentName)
    {
        $variations = [
            'marcos' => ['marco'],
            'maria' => ['maría', 'mari'],
            'jose' => ['josé', 'pepe'],
            'francisco' => ['fran', 'paco'],
            'antonio' => ['toni', 'anton'],
            'carlos' => ['carlitos'],
            'manuel' => ['manolo'],
            'rafael' => ['rafa'],
            'enrique' => ['quique'],
            'guadalupe' => ['lupe'],
        ];
        
        foreach ($variations as $formal => $informals) {
            if (str_contains($studentName, $formal) && array_reduce($informals, fn($carry, $informal) => $carry || str_contains($query, $informal), false)) {
                return true;
            }
        }
        
        return false;
    }

    private function detectIntent($query)
    {
        $patterns = [
            'attendance_today' => [
                'hoy', 'asistencia', 'presentes', 'asistieron', 'vinieron',
                'quién vino', 'quien vino', 'asistio', 'asistió'
            ],
            'student_absence' => [
                'faltaron', 'ausentes', 'no vinieron', 'quién faltó', 'quien falto',
                'falto', 'faltó', 'no vino'
            ],
            'grade_info' => [
                'grado', 'curso', 'año', 'sección', 'salón', 'aula',
                '1ro', '2do', '3ro', '4to', '5to', '6to', 'primero', 'segundo'
            ],
            'student_search' => [
                'estudiante', 'alumno', 'buscar', 'información de',
                'dónde está', 'donde esta', 'qué pasó con', 'que paso con'
            ]
        ];
        
        foreach ($patterns as $intent => $keywords) {
            foreach ($keywords as $keyword) {
                if (str_contains($query, $keyword)) {
                    return $intent;
                }
            }
        }
        
        return 'general';
    }

    private function formatStudentResponse($student, $thinking)
    {
        $today = Carbon::today();
        $todayFormatted = $today->format('d/m/Y');
        
        $attendanceToday = $student['asistencia_hoy'] ?? null;
        
        $message = "👤 **" . $student['full_name'] . "**\n\n";
        $message .= "📋 **" . $student['grado'] . " " . $student['seccion'] . "**\n";
        $message .= "🆔 **DNI:** " . $student['dni'] . "\n\n";
        
        if ($attendanceToday) {
            $status = $attendanceToday['status'];
            $emoji = $status == 'present' ? '✅' : ($status == 'absent' ? '❌' : '⏰');
            $statusText = $status == 'present' ? 'PRESENTE' : ($status == 'absent' ? 'AUSENTE' : 'TARDANZA');
            
            $message .= "📊 **Asistencia hoy ($todayFormatted):** $emoji **$statusText**\n";
            
            if ($attendanceToday['time']) {
                $message .= "⏰ **Hora:** " . $attendanceToday['time'] . "\n";
            }
            
            if ($status == 'absent') {
                $message .= "\n💡 *El estudiante no asistió hoy. ¿Necesitas generar un reporte de ausencia?*";
            } else {
                $message .= "\n🎉 *¡Buen rendimiento!*";
            }
        } else {
            $message .= "📊 **Asistencia hoy:** ⏳ *Sin registro aún*\n";
            $message .= "\n💡 *Aún no se ha registrado la asistencia para hoy.*";
        }
        
        // Agregar estadísticas si están disponibles
        if (isset($student['estadisticas'])) {
            $stats = $student['estadisticas'];
            $message .= "\n\n📈 **Últimos 15 días:** ";
            $message .= "✅ {$stats['asistencias']} • ❌ {$stats['faltas']} • ⏰ {$stats['tardanzas']}";
            
            if ($stats['total'] > 0) {
                $rate = round(($stats['asistencias'] / $stats['total']) * 100);
                $message .= " • 📊 {$rate}% de asistencia";
            }
        }

        return [
            'message' => $message,
            'thinking' => $thinking
        ];
    }

    private function getConversationalTodayAttendance($systemData, $thinking)
    {
        $today = Carbon::today();
        $todayFormatted = $today->format('d/m/Y');
        
        $message = "📊 **Asistencia de hoy ($todayFormatted)**\n\n";
        
        $total = $systemData['total_estudiantes'];
        $present = $systemData['asistencias_hoy'];
        $absent = $systemData['faltas_hoy'];
        $late = $systemData['tardanzas_hoy'];
        $recorded = $present + $absent + $late;
        $pending = $total - $recorded;
        
        $message .= "👥 **Total estudiantes:** $total\n";
        $message .= "✅ **Presentes:** $present\n";
        $message .= "❌ **Ausentes:** $absent\n";
        $message .= "⏰ **Tardanzas:** $late\n\n";
        
        if ($recorded > 0) {
            $attendanceRate = round(($present / $recorded) * 100);
            $message .= "📈 **Tasa de asistencia:** $attendanceRate%\n";
        }
        
        if ($pending > 0) {
            $message .= "⏳ **Pendientes por registrar:** $pending estudiantes\n";
            $message .= "\n💡 *¿Quieres que revise algún estudiante en específico?*";
        } else {
            $message .= "\n🎉 *¡Todos los registros están completos!*";
        }

        return [
            'message' => $message,
            'thinking' => $thinking
        ];
    }

    private function getRealTimeSystemData()
    {
        $today = Carbon::today();
        
        // Datos principales
        $totalStudents = Student::count();
        $presentToday = Attendance::whereDate('date', $today)->where('status', 'present')->count();
        $absentToday = Attendance::whereDate('date', $today)->where('status', 'absent')->count();
        $lateToday = Attendance::whereDate('date', $today)->where('status', 'late')->count();
        
        // Estudiantes destacados (los más relevantes para búsquedas)
        $featuredStudents = Student::with(['grade', 'classroom', 'attendances' => function($query) use ($today) {
            $query->whereDate('date', $today);
        }])->orderBy('created_at', 'desc')->limit(20)->get()->map(function($student) use ($today) {
            $todayAttendance = $student->attendances->first();
            
            return [
                'dni' => $student->dni,
                'full_name' => $student->full_name,
                'grado' => $student->grade->name ?? 'No asignado',
                'seccion' => $student->classroom->name ?? 'No asignada',
                'asistencia_hoy' => $todayAttendance ? [
                    'status' => $todayAttendance->status,
                    'time' => $todayAttendance->time
                ] : null
            ];
        })->toArray();

        return [
            'total_estudiantes' => $totalStudents,
            'asistencias_hoy' => $presentToday,
            'faltas_hoy' => $absentToday,
            'tardanzas_hoy' => $lateToday,
            'estudiantes_destacados' => $featuredStudents,
            'fecha_actual' => $today->format('d/m/Y')
        ];
    }

    private function formatStudentsForAI($students)
    {
        $formatted = "";
        foreach (array_slice($students, 0, 10) as $student) {
            $status = $student['asistencia_hoy']['status'] ?? 'no registrado';
            $formatted .= "- {$student['full_name']} ({$student['dni']}) - {$student['grado']} {$student['seccion']} - Hoy: {$status}\n";
        }
        return $formatted;
    }

    private function cleanAIResponse($response)
    {
        // Limpiar posibles artefactos de la IA
        $response = preg_replace('/^(Asistente|AI|Bot):\s*/i', '', $response);
        $response = trim($response);
        
        // Asegurar que tenga un formato conversacional agradable
        if (!preg_match('/[.!?]$/', $response)) {
            $response .= '.';
        }
        
        return $response;
    }

    private function getConversationalDefaultResponse($query, $systemData, $thinking)
    {
        $thinking[] = "💭 Generando respuesta conversacional";
        
        $message = "🤔 **EduAssist**\n\n";
        $message .= "Entiendo que preguntas sobre: \"$query\"\n\n";
        $message .= "Puedo ayudarte con:\n";    
        $message .= "• 👤 **Estudiantes específicos** (por nombre o DNI)\n";
        $message .= "• 📊 **Asistencia del día**\n"; 
        $message .= "• ❌ **Quiénes faltaron hoy**\n";
        $message .= "• 🎓 **Información por grados**\n\n";
        $message .= "💡 *Pregúntame de manera natural, por ejemplo:*\n";
        $message .= "*\"¿María asistió hoy?\"*\n";
        $message .= "*\"Cómo está la asistencia de 4to A\"*\n";
        $message .= "*\"Quiénes faltaron el día de hoy\"*";

        return [
            'message' => $message,
            'thinking' => $thinking
        ];
    }
}