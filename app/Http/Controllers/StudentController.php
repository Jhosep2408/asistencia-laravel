<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Grade;
use App\Models\Classroom;
use App\Models\Attendance;
use Picqer\Barcode\BarcodeGeneratorPNG;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Imports\StudentsImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Student::with(['grade', 'classroom']);
            
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('dni', 'like', "%{$search}%")
                      ->orWhere('first_name', 'like', "%{$search}%")
                      ->orWhere('last_name', 'like', "%{$search}%")
                      ->orWhereHas('grade', function($q) use ($search) {
                          $q->where('name', 'like', "%{$search}%");
                      })
                      ->orWhereHas('classroom', function($q) use ($search) {
                          $q->where('name', 'like', "%{$search}%");
                      });
                });
            }

            if ($request->filled('grade')) {
                $query->where('grade_id', $request->grade);
            }

            if ($request->filled('classroom')) {
                $query->where('classroom_id', $request->classroom);
            }

            if ($request->filled('shift')) {
                $query->where('shift', $request->shift);
            }

            $students = $query->paginate(10)->withQueryString();
            $grades = Grade::all();
            $classrooms = Classroom::all();
            
            $morningStudents = Student::where('shift', 'morning')->count();
            $afternoonStudents = Student::where('shift', 'afternoon')->count();
            
            $gradesCount = Grade::count();
            $classroomsCount = Classroom::count();
            $studentsWithPhoto = Student::whereNotNull('photo')->count();
            
            return view('admin.students.index', compact(
                'students', 
                'grades', 
                'classrooms',
                'gradesCount',
                'classroomsCount', 
                'studentsWithPhoto',
                'morningStudents', 
            'afternoonStudents' 
            ));
            
        } catch (\Exception $e) {
            \Log::error('Error en StudentController@index: ' . $e->getMessage());
            
            return view('admin.students.index', [
                'students' => collect([]),
                'grades' => collect([]),
                'classrooms' => collect([]),
                'gradesCount' => 0,
                'classroomsCount' => 0,
                'studentsWithPhoto' => 0,
                 'morningStudents' => 0, // ← AGREGAR VALOR POR DEFECTO
            'afternoonStudents' => 0 // ← AGREGAR VALOR POR DEFECTO
            ]);
        }
    }

    public function create()
    {
        $grades = Grade::with('classrooms')->get();
        return view('admin.students.create', compact('grades'));
    }

 public function store(Request $request)
    {
        try {
            // Verificar si es importación masiva desde Excel
            if ($request->has('import_type') && $request->import_type === 'excel') {
                return $this->importFromExcel($request);
            }

            // Validación para estudiante individual
            $request->validate([
                'dni' => 'required|unique:students|digits:8',
                'first_name' => 'required|string|max:100',
                'last_name' => 'required|string|max:100',
                'guardian_phone' => 'required|string|max:15',
                'grade_id' => 'required|exists:grades,id',
                'classroom_id' => 'required|exists:classrooms,id',
                'shift' => 'required|in:morning,afternoon',
                'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            DB::beginTransaction();

            // Generar código de barras del DNI
            $barcodePath = $this->generateBarcode($request->dni);

            // Guardar foto
            $photoPath = null;
            if ($request->hasFile('photo')) {
                $photo = $request->file('photo');
                $filename = $request->dni . '.' . $photo->getClientOriginalExtension();
                $photo->storeAs('public/students', $filename);
                $photoPath = 'students/' . $filename;
            }

            // Crear estudiante
            $student = Student::create([
                'dni' => $request->dni,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'guardian_phone' => $request->guardian_phone,
                'grade_id' => $request->grade_id,
                'classroom_id' => $request->classroom_id,
                'shift' => $request->shift,
                'photo' => $photoPath,
                'barcode' => $barcodePath,
            ]);

            DB::commit();

            return redirect()->route('students.index')
                ->with('success', 'Alumno registrado correctamente. Puede imprimir su fotocheck.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error al crear estudiante: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Error al crear el estudiante: ' . $e->getMessage())
                ->withInput();
        }
    }


    // En StudentController.php
public function getClassroomsByGrade(Grade $grade)
{
    $classrooms = $grade->classrooms()->select('id', 'name')->get();
    return response()->json($classrooms);
}

// En StudentController.php - método groupPhotocheck
// En StudentController.php - método groupPhotocheck
public function groupPhotocheck(Request $request)
{
    $request->validate([
        'grade' => 'required|exists:grades,id',
        'classroom' => 'required|exists:classrooms,id',
        'shift' => 'nullable|in:morning,afternoon',
        'order' => 'nullable|string',
        'method' => 'nullable|string'
    ]);
    $query = Student::with(['grade', 'classroom'])
        ->where('grade_id', $request->grade)
        ->where('classroom_id', $request->classroom);

    if ($request->shift) {
        $query->where('shift', $request->shift);
    }

    // Ordenamiento según opción
    $order = $request->get('order', 'last_name');
    switch ($order) {
        case 'first_name':
            $query->orderBy('first_name')->orderBy('last_name');
            break;
        case 'dni_asc':
            $query->orderBy('dni', 'asc');
            break;
        case 'dni_desc':
            $query->orderBy('dni', 'desc');
            break;
        case 'last_name':
        default:
            $query->orderBy('last_name')->orderBy('first_name');
            break;
    }

    $students = $query->get();

    if ($students->isEmpty()) {
        return back()->with('error', 'No se encontraron estudiantes con los criterios seleccionados.');
    }

    // Verificar que la imagen de fondo existe (crear si no existe)
    $backgroundPath = storage_path('app/public/Gaston.jpg');
    if (!file_exists($backgroundPath)) {
        $this->createDefaultBackground();
    }

    // Método de salida: view (HTML), stream (abrir PDF), download (descargar PDF)
    $method = $request->get('method', 'download');

    if ($method === 'view') {
        // Mostrar la vista HTML (abre en nueva pestaña y el usuario puede imprimir desde el navegador)
        return view('admin.students.group-photocheck', compact('students'));
    }

    $pdf = PDF::loadView('admin.students.group-photocheck', compact('students'))
        ->setPaper('a4', 'portrait');

    $gradeName = $students->first()->grade->name;
    $classroomName = $students->first()->classroom->name;
    $shiftName = $request->shift ? ($request->shift == 'morning' ? '-Mañana' : '-Tarde') : '';

    $filename = "fotochecks-{$gradeName}-{$classroomName}{$shiftName}.pdf";

    if ($method === 'stream') {
        return $pdf->stream($filename);
    }

    // Default: download
    return $pdf->download($filename);
}

// Método auxiliar para crear fondo por defecto
private function createDefaultBackground()
{
    // Crear una imagen simple como fondo por defecto
    $image = imagecreate(800, 600);
    $backgroundColor = imagecolorallocate($image, 240, 245, 255); // Color azul claro
    $textColor = imagecolorallocate($image, 200, 200, 200);
    
    // Agregar texto sutil
    imagestring($image, 5, 300, 290, 'GASTON VIDAL PORTURAS', $textColor);
    
    // Guardar imagen
    imagejpeg($image, storage_path('app/public/Gaston.jpg'), 80);
    imagedestroy($image);
}
    /**
     * Importar estudiantes desde Excel
     */
    private function importFromExcel(Request $request)
    {
        try {
            $request->validate([
                'excel_file' => 'required|file|mimes:xlsx,xls,csv|max:10240', // 10MB máximo
                'import_shift' => 'required|in:morning,afternoon' // Validar que se seleccione un turno
            ]);

            DB::beginTransaction();

            // Pasar el turno seleccionado al importador
            $importShift = $request->import_shift;
            
            // Importar usando Laravel Excel y pasar el turno
            $import = new StudentsImport($importShift);
            Excel::import($import, $request->file('excel_file'));

            $importedCount = $import->getImportedCount();
            $errors = $import->getErrors();

            DB::commit();

            if (!empty($errors)) {
                $errorMessage = "Se importaron {$importedCount} estudiantes, pero hubo errores: " . implode(', ', array_slice($errors, 0, 5));
                if (count($errors) > 5) {
                    $errorMessage .= " y " . (count($errors) - 5) . " errores más...";
                }
                
                return redirect()->route('students.index')
                    ->with('warning', $errorMessage);
            }

            $shiftLabel = $importShift == 'morning' ? 'mañana' : 'tarde';
            return redirect()->route('students.index')
                ->with('success', "¡Éxito! Se importaron {$importedCount} estudiantes correctamente en el turno de {$shiftLabel}.");

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error en importación masiva: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Error al importar estudiantes: ' . $e->getMessage())
                ->withInput();
        }
    }

    // Función para generar código de barras del DNI
    private function generateBarcode($dni)
    {
        $generator = new BarcodeGeneratorPNG();
        $barcodePath = 'barcodes/' . $dni . '.png';

        try {
            // Generar código de barras con el DNI como contenido
            $barcode = $generator->getBarcode($dni, $generator::TYPE_CODE_128, 3, 100);
            
            // Crear imagen mejorada del código de barras
            $image = Image::make($barcode)
                ->resize(400, 120, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->encode('png', 100);
                
            Storage::put('public/' . $barcodePath, (string) $image);
            
        } catch (\Exception $e) {
            \Log::error('Error generando código de barras: ' . $e->getMessage());
            // Fallback: generar código de barras básico
            $barcode = $generator->getBarcode($dni, $generator::TYPE_CODE_128);
            Storage::put('public/' . $barcodePath, $barcode);
        }

        return $barcodePath;
    }

    public function show($dni)
    {
        $student = Student::with(['grade', 'classroom'])->findOrFail($dni);
        return view('admin.students.show', compact('student'));
    }

    public function edit($dni)
    {
        $student = Student::findOrFail($dni);
        $grades = Grade::with('classrooms')->get();
        return view('admin.students.edit', compact('student', 'grades'));
    }

    public function update(Request $request, $dni)
    {
        $student = Student::findOrFail($dni);
        
        $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'guardian_phone' => 'required|string|max:15',
            'grade_id' => 'required|exists:grades,id',
            'classroom_id' => 'required|exists:classrooms,id',
            'shift' => 'required|in:morning,afternoon', // ← AGREGAR ESTA VALIDACIÓN
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            if ($student->photo) {
                Storage::delete('public/' . $student->photo);
            }
            
            $photo = $request->file('photo');
            $filename = $student->dni . '.' . $photo->getClientOriginalExtension();
            $photo->storeAs('public/students', $filename);
            $student->photo = 'students/' . $filename;
        }

        $student->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'guardian_phone' => $request->guardian_phone,
            'grade_id' => $request->grade_id,
            'classroom_id' => $request->classroom_id,
            'shift' => $request->shift, // ← AGREGAR ESTA LÍNEA
            'photo' => $student->photo,
        ]);

        return redirect()->route('students.index')
            ->with('success', 'Alumno actualizado correctamente.');
    }
    

    public function destroy($dni)
    {
        DB::beginTransaction();
        
        try {
            $student = Student::findOrFail($dni);

            // Eliminar manualmente los registros de asistencia primero
            Attendance::where('student_dni', $dni)->delete();

            // Eliminar archivos
            if ($student->photo) {
                Storage::delete('public/' . $student->photo);
            }
            if ($student->barcode) {
                Storage::delete('public/' . $student->barcode);
            }

            // Eliminar el estudiante
            $student->delete();

            DB::commit();

            return redirect()->route('students.index')
                ->with('success', 'Alumno y sus registros de asistencia eliminados correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error eliminando estudiante: ' . $e->getMessage());
            return redirect()->route('students.index')
                ->with('error', 'No se pudo eliminar el estudiante: ' . $e->getMessage());
        }
    }


    
public function attendance()
{
    try {
        $grades = Grade::with('classrooms')->get()->map(function ($grade) {
            return [
                'id' => $grade->id,
                'name' => $grade->name,
                'sections' => $grade->classrooms->map(function ($classroom) {
                    return [
                        'id' => $classroom->id,
                        'name' => $classroom->name
                    ];
                })->all()
            ];
        })->all();

        $students = Student::with(['grade', 'classroom'])->get()->map(function ($student) {
            return [
                'id' => $student->id,
                'name' => $student->full_name,
                'grade' => $student->grade->name ?? 'N/A',
                'grade_id' => $student->grade_id,
                'section' => $student->classroom->name ?? 'N/A',
                'section_id' => $student->classroom_id,
                'dni' => $student->dni,
                'shift' => $student->shift ?? 'morning', // ← AGREGAR TURNO
                'parent_name' => 'Apoderado',
                'parent_phone' => $student->guardian_phone
            ];
        });

        $totalStudents = $students->count();

        return view('students.attendance', compact('grades', 'students', 'totalStudents'));
        
    } catch (\Exception $e) {
        \Log::error('Error en StudentController@attendance: ' . $e->getMessage());

        $grades = [];
        $students = collect([]);
        $totalStudents = 0;
        return view('students.attendance', compact('grades', 'students', 'totalStudents'));
    }
}



    // Ver asistencias registradas
 public function attendanceViews()
{
    try {
        $grades = Grade::with('classrooms')->get()->map(function ($grade) {
            return [
                'id' => $grade->id,
                'name' => $grade->name,
                'sections' => $grade->classrooms->map(function ($classroom) {
                    return [
                        'id' => $classroom->id,
                        'name' => $classroom->name
                    ];
                })->all()
            ];
        })->all();

        $students = Student::with(['grade', 'classroom'])->get()->map(function ($student) {
            return [
                'id' => $student->id,
                'name' => $student->full_name,
                'grade' => $student->grade->name ?? 'N/A',
                'grade_id' => $student->grade_id,
                'section' => $student->classroom->name ?? 'N/A',
                'section_id' => $student->classroom_id,
                'dni' => $student->dni,
                'shift' => $student->shift ?? 'morning', // ← AGREGAR ESTA LÍNEA
                'parent_name' => 'Apoderado',
                'parent_phone' => $student->guardian_phone
            ];
        });

        $totalStudents = $students->count();
        $attendance = Attendance::with('student')->get();

        return view('students.attendanceviews', compact('grades', 'students', 'totalStudents', 'attendance'));
    } catch (\Exception $e) {
        \Log::error('Error en StudentController@attendanceViews: ' . $e->getMessage());

        $grades = [];
        $students = collect([]);
        $totalStudents = 0;
        $attendance = collect([]);

        return view('students.attendanceviews', compact('grades', 'students', 'totalStudents', 'attendance'));
    }
}

    // Procesar código de barras escaneado (DNI)
    public function processBarcodeScan(Request $request)
    {
        try {
            $request->validate([
                'barcode' => 'required|string|min:8|max:20',
                'date' => 'required|date'
            ]);

            $dni = $request->barcode;
            $date = $request->date;

            $student = Student::with(['grade', 'classroom'])->where('dni', $dni)->first();

            if (!$student) {
                return response()->json([
                    'success' => false,
                    'message' => 'Estudiante no encontrado con DNI: ' . $dni,
                    'data' => null
                ], 404);
            }
            $statusInfo = $this->getAttendanceStatusByTime();
            $attendance = Attendance::updateOrCreate(
                [
                    'student_dni' => $dni,
                    'date' => $date
                ],
                [
                    'status' => $statusInfo['status'],
                    'notes' => 'Registro automático por código de barras',
                    'scan_time' => Carbon::now()
                ]
            );

            $studentData = [
                'name' => $student->full_name,
                'dni' => $student->dni,
                'grade' => $student->grade->name ?? 'N/A',
                'section' => $student->classroom->name ?? 'N/A',
                'status' => $statusInfo['status'],
                'status_label' => $this->getStatusLabel($statusInfo['status']),
                'time_label' => $statusInfo['label'],
                'time_class' => $statusInfo['timeClass'],
                'scan_time' => Carbon::now()->format('H:i:s')
            ];

            return response()->json([
                'success' => true,
                'message' => 'Asistencia registrada correctamente',
                'data' => $studentData
            ]);

        } catch (\Exception $e) {
            \Log::error('Error procesando código de barras: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al procesar el código de barras: ' . $e->getMessage()
            ], 500);
        }
    }

    // Determinar estado de asistencia según la hora
    private function getAttendanceStatusByTime()
    {
        $now = Carbon::now();
        $currentTime = $now->format('H:i');
        $hour = $now->hour;
        $minute = $now->minute;

        // Convertir a minutos para comparación
        $currentMinutes = ($hour * 60) + $minute;

        // Definir límites de tiempo (en minutos desde medianoche)
        $lateLimit = (7 * 60) + 30; // 7:30 AM
        $absentLimit = 8 * 60; // 8:00 AM

        if ($currentMinutes < $lateLimit) {
            return [
                'status' => 'present',
                'timeClass' => 'time-ok',
                'label' => 'A tiempo'
            ];
        } elseif ($currentMinutes < $absentLimit) {
            return [
                'status' => 'late',
                'timeClass' => 'time-late',
                'label' => 'Tardanza'
            ];
        } else {
            return [
                'status' => 'absent',
                'timeClass' => 'time-absent',
                'label' => 'Falta'
            ];
        }
    }

    // Obtener etiqueta del estado
    private function getStatusLabel($status)
    {
        $labels = [
            'present' => 'Presente',
            'late' => 'Tardanza',
            'absent' => 'Falta',
            'justified' => 'Justificado'
        ];

        return $labels[$status] ?? 'Desconocido';
    }

    // Guardar asistencia manual (todos los estudiantes)
    public function saveAttendance(Request $request)
    {
        try {
            $request->validate([
                'date' => 'required|date',
                'attendance' => 'required|array'
            ]);

            $date = $request->input('date');
            $attendanceData = $request->input('attendance');

            foreach ($attendanceData as $studentDni => $data) {
                Attendance::updateOrCreate(
                    [
                        'student_dni' => $studentDni,
                        'date' => $date
                    ],
                    [
                        'status' => $data['status'],
                        'notes' => $data['notes'] ?? ''
                    ]
                );
            }

            return response()->json([
                'success' => true, 
                'message' => 'Asistencia guardada correctamente'
            ]);

        } catch (\Exception $e) {
            \Log::error('Error al guardar asistencia: ' . $e->getMessage());
            return response()->json([
                'success' => false, 
                'message' => 'Error al guardar la asistencia: ' . $e->getMessage()
            ], 500);
        }
    }

    // Cargar asistencia por fecha
    public function loadAttendance(Request $request)
    {
        try {
            $request->validate([
                'date' => 'required|date'
            ]);

            $attendances = Attendance::where('date', $request->date)
                ->get()
                ->mapWithKeys(function ($attendance) {
                    return [
                        $attendance->student_dni => [
                            'status' => $attendance->status,
                            'notes' => $attendance->notes
                        ]
                    ];
                });

            return response()->json([
                'success' => true,
                'attendances' => $attendances
            ]);

        } catch (\Exception $e) {
            \Log::error('Error al cargar asistencia: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar la asistencia'
            ], 500);
        }
    }

    // Enviar notificación por WhatsApp
    

    public function generatePhotocheck($dni)
    {
        $student = Student::with(['grade', 'classroom'])->findOrFail($dni);
        $pdf = PDF::loadView('admin.students.photocheck', compact('student'));
        return $pdf->stream('photocheck-' . $student->dni . '.pdf');
    }

    public function import(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls,csv|max:10240'
        ]);

        try {
            Excel::import(new StudentsImport, $request->file('excel_file'));
            
            return redirect()->route('students.index')
                ->with('success', 'Estudiantes importados exitosamente');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al importar: ' . $e->getMessage());
        }
    }
}