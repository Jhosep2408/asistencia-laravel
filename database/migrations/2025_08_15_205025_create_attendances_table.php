<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendancesTable extends Migration
{
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->string('student_dni'); // Referencia al DNI único del estudiante
            $table->enum('status', ['present', 'late', 'absent', 'justified']); // Estados de asistencia
            $table->time('time'); // Hora de la asistencia (opcional)
            $table->date('date'); // Fecha de la asistencia
            $table->text('notes')->nullable(); // Observaciones opcionales
            $table->timestamps();

            // Clave foránea que referencia a students.dni
            $table->foreign('student_dni')->references('dni')->on('students')->onDelete('cascade');

            // Índice único compuesto para evitar duplicados por estudiante y fecha
            $table->unique(['student_dni', 'date']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('attendances');
    }
}