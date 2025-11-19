<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAttendancesForeignKeyCascade extends Migration
{
    public function up()
    {
        Schema::table('attendances', function (Blueprint $table) {
            // Eliminar la clave foránea existente
            $table->dropForeign(['student_dni']);
            
            // Volver a crear con onDelete cascade
            $table->foreign('student_dni')
                  ->references('dni')
                  ->on('students')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropForeign(['student_dni']);
            
            // Volver a crear sin cascade
            $table->foreign('student_dni')
                  ->references('dni')
                  ->on('students');
        });
    }
}