<?php

namespace App\Imports;

use App\Models\Student;
use App\Models\Grade;
use App\Models\Classroom;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Picqer\Barcode\BarcodeGeneratorPNG;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class StudentsImport implements ToCollection, WithHeadingRow
{
    private $importedCount = 0;
    private $errors = [];
    private $shift; // ← AGREGAR ESTA PROPIEDAD

    // ← AGREGAR CONSTRUCTOR PARA RECIBIR EL TURNO
    public function __construct($shift = 'morning')
    {
        $this->shift = $shift;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row) {
            try {
                // Normalizar los nombres de las columnas
                $dni = $this->getColumnValue($row, ['dni', 'documento', 'numero_documento']);
                $firstName = $this->getColumnValue($row, ['nombres', 'first_name', 'nombre', 'nombres_estudiante']);
                $lastName = $this->getColumnValue($row, ['apellidos', 'last_name', 'apellido', 'apellidos_estudiante']);
                $guardianPhone = $this->getColumnValue($row, ['telefono_apoderado', 'guardian_phone', 'telefono', 'celular', 'telefono_apoderado']);
                $gradeName = $this->getColumnValue($row, ['grado', 'grade', 'grado_seccion', 'grado_estudiante']);
                $classroomName = $this->getColumnValue($row, ['seccion', 'classroom', 'section', 'aula', 'seccion_estudiante']);

                // Validar campos requeridos
                if (empty($dni)) {
                    $this->errors[] = "Fila " . ($index + 2) . ": DNI es requerido";
                    continue;
                }

                if (empty($firstName)) {
                    $this->errors[] = "Fila " . ($index + 2) . ": Nombres son requeridos";
                    continue;
                }

                if (empty($lastName)) {
                    $this->errors[] = "Fila " . ($index + 2) . ": Apellidos son requeridos";
                    continue;
                }

                if (empty($guardianPhone)) {
                    $this->errors[] = "Fila " . ($index + 2) . ": Teléfono del apoderado es requerido";
                    continue;
                }

                // Validar formato de DNI (8 dígitos)
                if (!preg_match('/^\d{8}$/', $dni)) {
                    $this->errors[] = "Fila " . ($index + 2) . ": El DNI debe tener 8 dígitos";
                    continue;
                }

                // Validar que el DNI no exista
                if (Student::where('dni', $dni)->exists()) {
                    $this->errors[] = "Fila " . ($index + 2) . ": El DNI {$dni} ya existe";
                    continue;
                }

                // Buscar o crear grado
                $grade = $this->findOrCreateGrade($gradeName);
                if (!$grade) {
                    $this->errors[] = "Fila " . ($index + 2) . ": Grado '{$gradeName}' no válido";
                    continue;
                }

                // Buscar o crear sección
                $classroom = $this->findOrCreateClassroom($classroomName, $grade->id);
                if (!$classroom) {
                    $this->errors[] = "Fila " . ($index + 2) . ": Sección '{$classroomName}' no válida";
                    continue;
                }

                // ← ELIMINAR LA DETERMINACIÓN DEL TURNO DESDE EXCEL
                // USAR DIRECTAMENTE EL TURNO DEL FORMULARIO
                $shift = $this->shift;

                // Generar código de barras
                $barcodePath = $this->generateBarcode($dni);

                // Crear estudiante con el turno del formulario
                Student::create([
                    'dni' => $dni,
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'guardian_phone' => $guardianPhone,
                    'grade_id' => $grade->id,
                    'classroom_id' => $classroom->id,
                    'shift' => $shift, // ← USAR EL TURNO DEL FORMULARIO
                    'barcode' => $barcodePath,
                ]);

                $this->importedCount++;
                Log::info("Estudiante importado: {$dni} - {$firstName} {$lastName} - Turno: {$shift}");

            } catch (\Exception $e) {
                $this->errors[] = "Fila " . ($index + 2) . ": " . $e->getMessage();
                Log::error("Error importando estudiante fila " . ($index + 2) . ": " . $e->getMessage());
            }
        }
    }

    // ← ELIMINAR EL MÉTODO determineShift YA QUE NO SE USA
    // private function determineShift($shiftText) { ... }

    /**
     * Obtener valor de columna con nombres alternativos
     */
    private function getColumnValue($row, $possibleNames)
    {
        foreach ($possibleNames as $name) {
            // Probar diferentes formatos de nombre
            $formats = [
                $name,
                strtolower($name),
                strtolower(str_replace('_', ' ', $name)),
                strtolower(str_replace(' ', '_', $name)),
            ];

            foreach ($formats as $format) {
                if (isset($row[$format]) && !empty(trim($row[$format]))) {
                    return trim($row[$format]);
                }
            }
        }
        return null;
    }

    /**
     * Buscar o crear grado
     */
    private function findOrCreateGrade($gradeName)
    {
        if (empty($gradeName)) {
            return Grade::first(); // Grado por defecto
        }

        // Limpiar y normalizar nombre del grado
        $cleanGradeName = preg_replace('/[^0-9]/', '', $gradeName);
        if (empty($cleanGradeName)) {
            $cleanGradeName = '1'; // Por defecto
        }

        // Limitar a un dígito (1-6)
        $cleanGradeName = substr($cleanGradeName, 0, 1);
        if (!in_array($cleanGradeName, ['1', '2', '3', '4', '5', '6'])) {
            $cleanGradeName = '1'; // Por defecto si no es válido
        }

        // Buscar grado existente
        $grade = Grade::where('name', $cleanGradeName)->first();

        if (!$grade) {
            // Crear nuevo grado si no existe
            $grade = Grade::create([
                'name' => $cleanGradeName,
                'description' => "{$cleanGradeName}° Grado"
            ]);
            Log::info("Grado creado: {$cleanGradeName}° Grado");
        }

        return $grade;
    }

    /**
     * Buscar o crear sección
     */
    private function findOrCreateClassroom($classroomName, $gradeId)
    {
        if (empty($classroomName)) {
            return Classroom::where('grade_id', $gradeId)->first(); // Primera sección del grado
        }

        // Limpiar y normalizar nombre de sección
        $cleanClassroomName = strtoupper(preg_replace('/[^A-Za-z]/', '', $classroomName));
        if (empty($cleanClassroomName)) {
            $cleanClassroomName = 'A'; // Por defecto
        }

        // Tomar solo la primera letra
        $cleanClassroomName = substr($cleanClassroomName, 0, 1);

        // Buscar sección existente
        $classroom = Classroom::where('name', $cleanClassroomName)
            ->where('grade_id', $gradeId)
            ->first();

        if (!$classroom) {
            // Crear nueva sección si no existe
            $classroom = Classroom::create([
                'name' => $cleanClassroomName,
                'grade_id' => $gradeId,
                'description' => "Sección {$cleanClassroomName}"
            ]);
            Log::info("Sección creada: {$cleanClassroomName} para grado {$gradeId}");
        }

        return $classroom;
    }

    /**
     * Generar código de barras
     */
    private function generateBarcode($dni)
    {
        try {
            $generator = new BarcodeGeneratorPNG();
            $barcodePath = 'barcodes/' . $dni . '.png';

            // Generar código de barras con el DNI como contenido
            $barcode = $generator->getBarcode($dni, $generator::TYPE_CODE_128, 3, 100);
            
            // Crear imagen mejorada del código de barras
            $image = Image::make($barcode)
                ->resize(400, 120, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->encode('png', 100);
                
            Storage::put('public/' . $barcodePath, (string) $image);
            
            return $barcodePath;
            
        } catch (\Exception $e) {
            Log::error('Error generando código de barras para ' . $dni . ': ' . $e->getMessage());
            // Fallback: generar código de barras básico
            $barcode = $generator->getBarcode($dni, $generator::TYPE_CODE_128);
            Storage::put('public/' . $barcodePath, $barcode);
            return $barcodePath;
        }
    }

    /**
     * Obtener contador de importados
     */
    public function getImportedCount()
    {
        return $this->importedCount;
    }

    /**
     * Obtener errores
     */
    public function getErrors()
    {
        return $this->errors;
    }
}