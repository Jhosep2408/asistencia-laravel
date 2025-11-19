<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
        public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->string('dni', 8)->primary(); // DNI como clave primaria
            $table->string('first_name');
            $table->string('last_name');
            $table->string('guardian_phone');
            $table->unsignedBigInteger('grade_id');
            $table->unsignedBigInteger('classroom_id');
            $table->string('photo')->nullable();
            $table->string('barcode');
            $table->timestamps();

            $table->foreign('grade_id')->references('id')->on('grades');
            $table->foreign('classroom_id')->references('id')->on('classrooms');
        });
    }

    public function down()
    {
        Schema::dropIfExists('students');
    }
}