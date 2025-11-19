<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Student;
use App\Models\Attendance;
use Twilio\Rest\Client;
use Carbon\Carbon;

class CheckAttendance extends Command
{
    protected $signature = 'attendance:check';
    protected $description = 'Verifica y marca asistencia automática, envía notificaciones por WhatsApp';

    public function handle()
    {
        $now = Carbon::now('America/Lima'); // Hora de Perú
        $currentTime = $now->format('H:i:s');
        $currentDate = $now->format('Y-m-d');

        // Hora límite para tardanza (7:30 AM)
        $tardanzaLimit = Carbon::today('America/Lima')->setTime(7, 30, 0)->format('H:i:s');
        // Hora límite para falta (8:00 AM)
        $faltaLimit = Carbon::today('America/Lima')->setTime(8, 0, 0)->format('H:i:s');

        // Obtener estudiantes sin asistencia registrada hoy
        $studentsSinAsistencia = Student::whereDoesntHave('attendances', function ($query) use ($currentDate) {
            $query->where('date', $currentDate);
        })->get();

        foreach ($studentsSinAsistencia as $student) {
            // Marcar como tardanza si pasó 7:30 AM
            if ($currentTime > $tardanzaLimit && $currentTime <= $faltaLimit) {
                Attendance::create([
                    'student_dni' => $student->dni,
                    'status' => 'late',
                    'time' => $currentTime,
                    'date' => $currentDate,
                    'notes' => 'Marcado automáticamente como tardanza'
                ]);

                $this->info("Estudiante {$student->name} marcado como tardanza.");
            }
            // Marcar como falta si pasó 8:00 AM y enviar WhatsApp
            elseif ($currentTime > $faltaLimit) {
                Attendance::create([
                    'student_dni' => $student->dni,
                    'status' => 'absent',
                    'time' => $currentTime,
                    'date' => $currentDate,
                    'notes' => 'Marcado automáticamente como falta'
                ]);

                $this->sendWhatsAppNotification($student, 'absent');

                $this->info("Estudiante {$student->name} marcado como falta y notificación enviada.");
            }
        }

        $this->info('Verificación de asistencia completada.');
    }

    private function sendWhatsAppNotification($student, $status)
    {
        // Configuración de Twilio (usa .env para SID, TOKEN, NUMBER)
        $sid = config('twilio.sid');
        $token = config('twilio.token');
        $twilioNumber = config('twilio.number');

        $client = new Client($sid, $token);

        $message = "¡Hola! Su hijo/a {$student->name} no asistió a clase hoy ({$student->date}). Por favor, contacte a la institución para más detalles. Sistema Escolar.";

        try {
            $client->messages->create(
                "whatsapp:+51" . $student->guardian_phone, // Número del apoderado (ajusta si es diferente)
                [
                    'from' => $twilioNumber,
                    'body' => $message
                ]
            );

            \Log::info("Notificación WhatsApp enviada a {$student->guardian_phone} para {$student->name}");
        } catch (\Exception $e) {
            \Log::error("Error enviando WhatsApp a {$student->guardian_phone}: " . $e->getMessage());
        }
    }
}