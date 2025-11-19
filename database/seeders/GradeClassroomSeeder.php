<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Grade;
use App\Models\Classroom;

class GradeClassroomSeeder extends Seeder
{
    public function run(): void
    {
        // Eliminar primero las aulas (hijas), luego los grados (padres)
        Classroom::query()->delete();
        Grade::query()->delete();

        // Grados
        $grades = ['1', '2', '3', '4', '5'];

        // Secciones
        $classrooms = ['A', 'B', 'C', 'D'];

        foreach ($grades as $gradeName) {
            // Crear el grado
            $grade = Grade::create([
                'name' => $gradeName
            ]);

            // Crear las secciones para ese grado
            foreach ($classrooms as $classroomName) {
                Classroom::create([
                    'name' => $classroomName,
                    'grade_id' => $grade->id
                ]);
            }
        }
    }
}
