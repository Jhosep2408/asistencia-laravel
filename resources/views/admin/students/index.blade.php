@extends('layouts.admin')

@section('content')

@section('header')
<div class="dashboard-header">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h1 class="h2 fw-bold mb-2">Gestión de Estudiantes</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-white-50">Inicio</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Estudiantes</li>
                </ol>
            </nav>
        </div>
        <div class="col-md-4 text-md-end">
            <div class="d-flex align-items-center justify-content-end gap-2">
               <span class="date-indicator">Hoy: {{ date('d/m/Y') }}</span>
            </div>
        </div>
    </div>
</div>
@endsection
<!-- Header Stats -->
<!-- Header Stats - Agregar estadística de turnos -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="card bg-primary bg-gradient text-white mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title text-white-50 small">TOTAL ESTUDIANTES</h6>
                        <h3 class="mb-0">{{ $students->total() }}</h3>
                    </div>
                    <div class="icon-circle">
                        <i class="bi bi-people-fill fs-2"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="{{ route('students.create') }}">
                    Agregar nuevo
                </a>
                <div class="small text-white">
                    <i class="bi bi-arrow-right-short"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="card bg-info bg-gradient text-white mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title text-white-50 small">TURNO MAÑANA</h6>
                        <h3 class="mb-0">{{ $morningStudents }}</h3>
                    </div>
                    <div class="icon-circle">
                        <i class="bi bi-sun fs-2"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <span class="small text-white">Estudiantes matutinos</span>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="card bg-warning bg-gradient text-white mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title text-white-50 small">TURNO TARDE</h6>
                        <h3 class="mb-0">{{ $afternoonStudents }}</h3>
                    </div>
                    <div class="icon-circle">
                        <i class="bi bi-moon fs-2"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <span class="small text-white">Estudiantes vespertinos</span>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="card bg-success bg-gradient text-white mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title text-white-50 small">FOTOCHECKS</h6>
                        <h3 class="mb-0">{{ $studentsWithPhoto }}</h3>
                    </div>
                    <div class="icon-circle">
                        <i class="bi bi-person-badge-fill fs-2"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <span class="small text-white">Con foto registrada</span>
            </div>
        </div>
    </div>
</div>

<!-- Main Card -->
<div class="card shadow-lg border-0">
    <div class="card-header bg-dark text-white py-3">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="bi bi-people-fill me-2"></i>Gestión de Estudiantes
            </h5>
            <div class="d-flex gap-2">
                <a href="{{ route('students.create') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-circle me-1"></i> Nuevo Estudiante
                </a>
                <button class="btn btn-outline-light btn-sm" id="exportBtn">
                    <i class="bi bi-download me-1"></i> Exportar
                </button>
                <!-- NUEVO BOTÓN PARA IMPRIMIR FOTOHECKS EN GRUPO -->
                <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#groupPhotocheckModal">
                    <i class="bi bi-printer me-1"></i> Imprimir Fotochecks
                </button>
            </div>
        </div>
    </div>
    
    <div class="card-body p-0">
        <!-- Search and Filters -->
        <div class="bg-light p-3 border-bottom">
        <form action="{{ route('students.index') }}" method="GET" class="row g-3">
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="bi bi-search text-muted"></i>
                    </span>
                    <input type="text" name="search" class="form-control border-start-0" 
                        placeholder="Buscar por nombre, DNI o grado..."
                        value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-2">
                <select class="form-select" name="grade" id="gradeFilter">
                    <option value="">Todos los grados</option>
                    @foreach($grades as $grade)
                        <option value="{{ $grade->id }}" 
                            data-sections='@json($grade->classrooms)'
                            {{ request('grade') == $grade->id ? 'selected' : '' }}>
                            {{ $grade->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-select" name="classroom" id="classroomFilter" {{ !request('grade') ? 'disabled' : '' }}>
                    <option value="">Todas las secciones</option>
                    @foreach($classrooms as $classroom)
                        <option value="{{ $classroom->id }}" 
                            {{ request('classroom') == $classroom->id ? 'selected' : '' }}>
                            {{ $classroom->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-select" name="shift" id="shiftFilter">
                    <option value="">Todos los turnos</option>
                    <option value="morning" {{ request('shift') == 'morning' ? 'selected' : '' }}>Turno Mañana</option>
                    <option value="afternoon" {{ request('shift') == 'afternoon' ? 'selected' : '' }}>Turno Tarde</option>
                </select>
            </div>
            <div class="col-md-2">
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary flex-grow-1">
                        <i class="bi bi-filter me-1"></i>Filtrar
                    </button>
                    <a href="{{ route('students.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-clockwise"></i>
                    </a>
                </div>
            </div>
        </form>
    </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($students->count() > 0)
            <div class="table-responsive">
                <!-- En la tabla de estudiantes, agregar columna de turno después de Grado/Sección -->
                <table class="table table-hover align-middle mb-0" id="studentsTable">
                    <thead class="table-dark">
                        <tr>
                            <th class="ps-4">
                                <input type="checkbox" id="selectAll" class="form-check-input">
                            </th>
                            <th>DNI</th>
                            <th>Estudiante</th>
                            <th>Grado/Sección</th>
                            <th>Turno</th> <!-- ← NUEVA COLUMNA -->
                            <th>Contacto</th>
                            <th>Estado</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $student)
                        <tr class="student-row" data-grade="{{ $student->grade_id }}" data-classroom="{{ $student->classroom_id }}">
                            <td class="ps-4">
                                <input type="checkbox" class="form-check-input student-checkbox" value="{{ $student->dni }}">
                            </td>
                            <td>
                                <span class="fw-bold text-primary">{{ $student->dni }}</span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm me-3">
                                        <!-- Reemplaza la foto por un icono -->
                                        <div class="avatar-xs bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-person-fill text-primary"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">{{ $student->full_name }}</h6>
                                        <small class="text-muted">{{ $student->email ?? 'Sin email' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-primary bg-opacity-10 text-primary">
                                    {{ $student->grade->name ?? 'N/A' }}
                                </span>
                                <span class="badge bg-success bg-opacity-10 text-success">
                                    {{ $student->classroom->name ?? 'N/A' }}
                                </span>
                            </td>
                            <td>
                                @if($student->shift == 'morning')
                                    <span class="badge bg-info">
                                        <i class="bi bi-sun me-1"></i>Mañana
                                    </span>
                                @else
                                    <span class="badge bg-warning">
                                        <i class="bi bi-moon me-1"></i>Tarde
                                    </span>
                                @endif
                            </td>
                            <td>
                                <small class="text-muted d-block">Apoderado:</small>
                                <span class="fw-semibold">{{ $student->guardian_phone ?? 'No registrado' }}</span>
                            </td>
                            <td>
                                <span class="badge bg-success">
                                    <i class="bi bi-check-circle me-1"></i> Activo
                                </span>
                            </td>
                            <td>
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('students.photocheck', $student->dni) }}" 
                                    class="btn btn-sm btn-outline-info" 
                                    title="Imprimir Fotocheck"
                                    target="_blank">
                                        <i class="bi bi-printer"></i>
                                    </a>
                                    <a href="{{ route('students.edit', $student->dni) }}" 
                                    class="btn btn-sm btn-outline-warning" 
                                    title="Editar">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button class="btn btn-sm btn-outline-danger delete-btn" 
                                            data-dni="{{ $student->dni }}"
                                            data-name="{{ $student->full_name }}"
                                            title="Eliminar">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center p-3 border-top">
                <div class="text-muted">
                    Mostrando <span class="fw-semibold">{{ $students->firstItem() ?? 0 }}-{{ $students->lastItem() ?? 0 }}</span> de 
                    <span class="fw-semibold">{{ $students->total() }}</span> estudiantes
                </div>
                @if ($students->hasPages())
                <nav>
                    <ul class="pagination pagination-sm mb-0">
                        {{-- Previous Page Link --}}
                        @if ($students->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link">
                                    <i class="bi bi-chevron-left"></i>
                                </span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $students->previousPageUrl() }}" rel="prev">
                                    <i class="bi bi-chevron-left"></i>
                                </a>
                            </li>
                        @endif

                        @php
                            $start = $students->currentPage() - 2; // Mostrar 2 páginas antes
                            $end = $students->currentPage() + 2; // Mostrar 2 páginas después
                            if($start < 1) {
                                $start = 1;
                                $end = min(5, $students->lastPage());
                            }
                            if($end > $students->lastPage()) {
                                $end = $students->lastPage();
                                $start = max(1, $end - 4);
                            }
                        @endphp

                        {{-- Primera página y puntos suspensivos --}}
                        @if($start > 1)
                            <li class="page-item">
                                <a class="page-link" href="{{ $students->url(1) }}">1</a>
                            </li>
                            @if($start > 2)
                                <li class="page-item disabled">
                                    <span class="page-link">...</span>
                                </li>
                            @endif
                        @endif

                        {{-- Páginas numeradas --}}
                        @for ($i = $start; $i <= $end; $i++)
                            <li class="page-item {{ ($students->currentPage() == $i) ? 'active' : '' }}">
                                <a class="page-link" href="{{ $students->url($i) }}">{{ $i }}</a>
                            </li>
                        @endfor

                        {{-- Última página y puntos suspensivos --}}
                        @if($end < $students->lastPage())
                            @if($end < $students->lastPage() - 1)
                                <li class="page-item disabled">
                                    <span class="page-link">...</span>
                                </li>
                            @endif
                            <li class="page-item">
                                <a class="page-link" href="{{ $students->url($students->lastPage()) }}">
                                    {{ $students->lastPage() }}
                                </a>
                            </li>
                        @endif

                        {{-- Next Page Link --}}
                        @if ($students->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $students->nextPageUrl() }}" rel="next">
                                    <i class="bi bi-chevron-right"></i>
                                </a>
                            </li>
                        @else
                            <li class="page-item disabled">
                                <span class="page-link">
                                    <i class="bi bi-chevron-right"></i>
                                </span>
                            </li>
                        @endif
                    </ul>
                </nav>
                @endif
            </div>
        @else
            <div class="text-center py-5">
                <div class="empty-state">
                    <i class="bi bi-people display-1 text-muted"></i>
                    <h4 class="mt-3 text-muted">No hay estudiantes registrados</h4>
                    <p class="text-muted">Comienza agregando el primer estudiante al sistema.</p>
                    <a href="{{ route('students.create') }}" class="btn btn-primary mt-2">
                        <i class="bi bi-plus-circle me-2"></i>Agregar Primer Estudiante
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="bi bi-exclamation-triangle me-2"></i>Confirmar Eliminación
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>¿Está seguro de eliminar al estudiante <strong id="studentName"></strong>?</p>
                <div class="alert alert-warning small">
                    <i class="bi bi-info-circle me-2"></i>
                    <strong>Advertencia:</strong> También se eliminarán todos sus registros de asistencia.
                </div>
                <p class="text-danger small mb-0">Esta acción no se puede deshacer.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form id="deleteForm" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Eliminar Estudiantes y Asistencias</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Después del modal de eliminación, agregar el modal de fotochecks en grupo -->
<div class="modal fade" id="groupPhotocheckModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">
                    <i class="bi bi-printer me-2"></i>Imprimir Fotochecks en Grupo
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="groupPhotocheckForm" action="{{ route('students.photocheck.group') }}" method="GET" target="_blank">
                    <div class="mb-3">
                        <label for="modalGrade" class="form-label">Grado</label>
                        <select class="form-select" name="grade" id="modalGrade" required>
                            <option value="">Seleccionar grado</option>
                            @foreach($grades as $grade)
                                <option value="{{ $grade->id }}">{{ $grade->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="modalClassroom" class="form-label">Sección</label>
                        <select class="form-select" name="classroom" id="modalClassroom" required disabled>
                            <option value="">Seleccionar sección</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="modalShift" class="form-label">Turno (Opcional)</label>
                        <select class="form-select" name="shift" id="modalShift">
                            <option value="">Todos los turnos</option>
                            <option value="morning">Turno Mañana</option>
                            <option value="afternoon">Turno Tarde</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="modalOrder" class="form-label">Ordenar por</label>
                        <select class="form-select" name="order" id="modalOrder">
                            <option value="last_name">Apellidos (A-Z)</option>
                            <option value="first_name">Nombres (A-Z)</option>
                            <option value="dni_asc">DNI (Asc)</option>
                            <option value="dni_desc">DNI (Desc)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="modalMethod" class="form-label">Método de salida</label>
                        <select class="form-select" name="method" id="modalMethod">
                            <option value="download">Descargar PDF</option>
                            <option value="stream">Abrir PDF en pestaña</option>
                            <option value="view">Abrir vista HTML (imprimir desde navegador)</option>
                        </select>
                    </div>
                    <div class="alert alert-info small">
                        <i class="bi bi-info-circle me-2"></i>
                        Se generará un PDF varios fotochecks por página, ordenados alfabéticamente.
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="groupPhotocheckForm" class="btn btn-success">
                    <i class="bi bi-printer me-1"></i> Generar PDF
                </button>
            </div>
        </div>
    </div>
</div>

<style>
.avatar-xs {
    width: 32px;
    height: 32px;
    object-fit: cover;
}

.icon-circle {
    width: 50px;
    height: 50px;
    background: rgba(255,255,255,0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.card {
    border: none;
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
    transition: all 0.3s;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 0.5rem 2rem 0 rgba(58, 59, 69, 0.2);
}

.table th {
    border-top: none;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.8rem;
    letter-spacing: 0.5px;
}

.student-row:hover {
    background-color: #f8f9fa;
    transform: scale(1.01);
    transition: all 0.2s;
}

.badge {
    font-size: 0.75em;
}

.empty-state {
    opacity: 0.7;
}

.btn {
    border-radius: 0.375rem;
    transition: all 0.2s;
}

.btn:hover {
    transform: translateY(-1px);
}

.form-control:focus, .form-select:focus {
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    border-color: #80bdff;
}

/* Estilos mejorados para la paginación */
.pagination {
    margin: 0;
    display: flex;
    gap: 4px;
}

.page-link {
    border: 1px solid #e2e8f0;
    color: #4a5568;
    min-width: 32px;
    height: 32px;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.875rem;
    border-radius: 6px;
    transition: all 0.2s;
    background-color: #fff;
    margin: 0;
}

.page-link:hover {
    background-color: #f7fafc;
    border-color: #cbd5e0;
    color: #2d3748;
    z-index: 2;
}

.page-item.active .page-link {
    background: #3182ce;
    border-color: #2b6cb0;
    color: white;
    font-weight: 500;
}

.page-item.disabled .page-link {
    color: #a0aec0;
    background-color: #f7fafc;
    border-color: #edf2f7;
    cursor: not-allowed;
}

/* Navegación anterior/siguiente */
.page-item:first-child .page-link,
.page-item:last-child .page-link {
    font-size: 1rem;
    padding: 0;
    width: 32px;
}

/* Puntos suspensivos */
.page-item.disabled .page-link:not([aria-label]) {
    background: none;
    border: none;
    color: #718096;
    cursor: default;
    pointer-events: none;
}

/* Estilos responsive */
@media (max-width: 640px) {
    .pagination {
        flex-wrap: nowrap;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        padding-bottom: 1rem;
    }
    
    .page-link {
        min-width: 28px;
        height: 28px;
        font-size: 0.8125rem;
    }

    .d-flex.justify-content-between.align-items-center {
        flex-direction: column;
        gap: 1rem;
    }
    
    .text-muted {
        font-size: 0.875rem;
        text-align: center;
    }
}

/* Responsive */
@media (max-width: 768px) {
    .pagination {
        flex-wrap: wrap;
        justify-content: center;
    }
    
    .page-link {
        padding: 0.375rem 0.5rem;
        font-size: 0.8rem;
        margin: 0.125rem;
    }
    
    .page-item:first-child .page-link,
    .page-item:last-child .page-link {
        min-width: 70px;
    }
    
    .d-flex.justify-content-between.align-items-center {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }
}


/* Estilos para el modal de fotochecks en grupo */
#groupPhotocheckModal .modal-body {
    padding: 1.5rem;
}

#groupPhotocheckModal .form-label {
    font-weight: 600;
    color: #495057;
    margin-bottom: 0.5rem;
}

#groupPhotocheckModal .alert-info {
    background-color: #e7f3ff;
    border-color: #b3d7ff;
    color: #004085;
    font-size: 0.875rem;
}

/* Responsive */
@media (max-width: 576px) {
    .d-flex.gap-2 {
        flex-wrap: wrap;
    }
    
    .btn-sm {
        font-size: 0.775rem;
        padding: 0.25rem 0.5rem;
    }
}

/* Estilos mejorados para el modal de fotochecks en grupo */
#groupPhotocheckModal .modal-body {
    padding: 1.5rem;
}

#groupPhotocheckModal .form-label {
    font-weight: 600;
    color: #495057;
    margin-bottom: 0.5rem;
}

#groupPhotocheckModal .alert-info {
    background-color: #e7f3ff;
    border-color: #b3d7ff;
    color: #004085;
    font-size: 0.875rem;
    border-left: 4px solid #007bff;
}

#groupPhotocheckModal select:disabled {
    background-color: #f8f9fa;
    cursor: not-allowed;
}

/* Indicador de carga */
.loading-option {
    color: #6c757d;
    font-style: italic;
}

/* Responsive */
@media (max-width: 576px) {
    .d-flex.gap-2 {
        flex-wrap: wrap;
    }
    
    .btn-sm {
        font-size: 0.775rem;
        padding: 0.25rem 0.5rem;
    }
    
    #groupPhotocheckModal .modal-dialog {
        margin: 0.5rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Delete confirmation modal
    const deleteButtons = document.querySelectorAll('.delete-btn');
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    const deleteForm = document.getElementById('deleteForm');
    const studentName = document.getElementById('studentName');
    const shiftFilter = document.getElementById('shiftFilter');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const dni = this.getAttribute('data-dni');
            const name = this.getAttribute('data-name');
            
            studentName.textContent = name;
            deleteForm.action = `/admin/students/${dni}`;
            deleteModal.show();
        });
    });


    // Agregar este código en la sección <script> existente

// Funcionalidad para el modal de fotochecks en grupo
// Agregar este código mejorado en la sección <script> existente

// Funcionalidad para el modal de fotochecks en grupo
// Agregar este código mejorado en la sección <script> existente

// Funcionalidad para el modal de fotochecks en grupo
const modalGrade = document.getElementById('modalGrade');
const modalClassroom = document.getElementById('modalClassroom');

modalGrade.addEventListener('change', function() {
    const gradeId = this.value;
    
    // Limpiar opciones actuales
    modalClassroom.innerHTML = '<option value="">Seleccionar sección</option>';
    modalClassroom.disabled = true;
    
    if (gradeId) {
        // Mostrar loading
        modalClassroom.innerHTML = '<option value="">Cargando secciones...</option>';
        modalClassroom.disabled = false;
        
        // Hacer petición para obtener las secciones del grado seleccionado
        fetch(`/admin/grades/${gradeId}/classrooms`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error en la respuesta del servidor');
                }
                return response.json();
            })
            .then(classrooms => {
                modalClassroom.innerHTML = '<option value="">Todas las secciones</option>';
                
                classrooms.forEach(classroom => {
                    const option = document.createElement('option');
                    option.value = classroom.id;
                    option.textContent = classroom.name;
                    modalClassroom.appendChild(option);
                });
                
                // Habilitar select
                modalClassroom.disabled = false;
            })
            .catch(error => {
                console.error('Error al cargar las secciones:', error);
                modalClassroom.innerHTML = '<option value="">Error al cargar</option>';
                modalClassroom.disabled = true;
                
                // Mostrar alerta de error
                const alertDiv = document.createElement('div');
                alertDiv.className = 'alert alert-warning alert-dismissible fade show mt-2';
                alertDiv.innerHTML = `
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    Error al cargar las secciones. Intente nuevamente.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                `;
                document.querySelector('#groupPhotocheckModal .modal-body').appendChild(alertDiv);
            });
    }
});

// Validación del formulario antes de enviar
document.getElementById('groupPhotocheckForm').addEventListener('submit', function(e) {
    const grade = document.getElementById('modalGrade').value;
    const classroom = document.getElementById('modalClassroom').value;
    
    if (!grade || !classroom) {
        e.preventDefault();
        alert('Por favor, seleccione un grado y una sección.');
        return false;
    }
});
    // Filter functionality for grade and classroom selection
    const gradeFilter = document.getElementById('gradeFilter');
    const classroomFilter = document.getElementById('classroomFilter');

    gradeFilter.addEventListener('change', function () {
        const selectedOption = this.options[this.selectedIndex];
        const sectionsData = selectedOption.getAttribute('data-sections');

        // Limpiar opciones actuales
        classroomFilter.innerHTML = '';

        // Agregar opción por defecto
        const defaultOption = document.createElement('option');
        defaultOption.value = '';
        defaultOption.textContent = 'Todas las secciones';
        classroomFilter.appendChild(defaultOption);

        if (sectionsData && this.value !== '') {
            // Habilitar select
            classroomFilter.disabled = false;

            const sections = JSON.parse(sectionsData);
            sections.forEach(section => {
                const option = document.createElement('option');
                option.value = section.id;
                option.textContent = section.name;
                option.selected = section.id == @json(request('classroom')); // Mantener la sección seleccionada
                classroomFilter.appendChild(option);
            });
        } else {
            // No hay grado seleccionado: deshabilitar select
            classroomFilter.disabled = true;
        }
    });

    // Select all functionality
    const selectAll = document.getElementById('selectAll');
    const studentCheckboxes = document.querySelectorAll('.student-checkbox');

    selectAll.addEventListener('change', function() {
        studentCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });
});
</script>

@endsection