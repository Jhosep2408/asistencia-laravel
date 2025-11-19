@extends('layouts.app')

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <h2 class="fw-bold">Panel del Profesor</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">Inicio</li>
            </ol>
        </nav>
    </div>
</div>

<div class="row">
    <!-- Tarjeta de Total Estudiantes -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card card-dashboard border-left-primary h-100">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Estudiantes</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalStudents }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-people-fill fa-2x text-primary"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tarjeta de Asistencias Hoy -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card card-dashboard border-left-success h-100">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Asistencias Hoy</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $presentCount }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-check-circle-fill fa-2x text-success"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tarjeta de Tardanzas Hoy -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card card-dashboard border-left-warning h-100">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Tardanzas Hoy</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $lateCount }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-clock-fill fa-2x text-warning"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Aulas Asignadas -->
<div class="row">
    <div class="col-md-12">
        <div class="card card-dashboard">
            <div class="card-header bg-white">
                <h5 class="mb-0">Mis Aulas Asignadas</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach($classrooms as $classroom)
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Aula: {{ $classroom->name }}</h5>
                                <p class="card-text">
                                    Grado: {{ $classroom->grade->name }}<br>
                                    Total estudiantes: {{ $classroom->students->count() }}
                                </p>
                                <a href="{{ route('professor.attendance', ['classroom_id' => $classroom->id]) }}" 
                                   class="btn btn-primary btn-sm">
                                    <i class="bi bi-clipboard-check"></i> Tomar Asistencia
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection