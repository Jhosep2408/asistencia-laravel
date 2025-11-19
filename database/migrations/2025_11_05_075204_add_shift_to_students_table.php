<?php
// database/migrations/xxxx_xx_xx_xxxxxx_add_shift_to_students_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddShiftToStudentsTable extends Migration
{
    public function up()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->enum('shift', ['morning', 'afternoon'])->default('morning')->after('classroom_id');
        });
    }

    public function down()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn('shift');
        });
    }
}