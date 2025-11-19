<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Asistencia - Sistema Escolar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4361ee;
            --success-color: #06d6a0;
            --warning-color: #ffd166;
            --danger-color: #ef476f;
            --info-color: #118ab2;
            --light-bg: #f8f9fa;
            --card-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            --card-hover-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
        }
        
        body {
            background-color: #f5f7fb;
            font-family: 'Segoe UI', system-ui, sans-serif;
        }
        
        .dashboard-header {
            background: linear-gradient(135deg, #4361ee 0%, #3a56d4 100%);
            color: white;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: var(--card-shadow);
        }
        
        .card-dashboard {
            border: none;
            border-radius: 12px;
            box-shadow: var(--card-shadow);
            transition: all 0.3s ease;
            overflow: hidden;
        }
        
        .card-dashboard:hover {
            transform: translateY(-5px);
            box-shadow: var(--card-hover-shadow);
        }
        
        .card-dashboard .card-body {
            padding: 1.5rem;
        }
        
        .stat-card {
            border-left: 4px solid;
            height: 100%;
        }
        
        .stat-card-primary {
            border-left-color: var(--primary-color);
        }
        
        .stat-card-success {
            border-left-color: var(--success-color);
        }
        
        .stat-card-danger {
            border-left-color: var(--danger-color);
        }
        
        .stat-icon {
            font-size: 2.5rem;
            opacity: 0.8;
        }
        
        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            margin: 0.5rem 0;
        }
        
        .stat-label {
            font-size: 0.9rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.5rem;
        }
        
        .card-footer-transparent {
            background: transparent;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
            padding: 1rem 1.5rem;
        }
        
        .btn-action {
            border-radius: 8px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
        }
        
        .btn-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        .table-responsive {
            border-radius: 8px;
            overflow: hidden;
        }
        
        .table-hover tbody tr {
            transition: all 0.2s ease;
        }
        
        .table-hover tbody tr:hover {
            background-color: rgba(67, 97, 238, 0.05);
        }
        
        .breadcrumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            padding: 0.5rem 1rem;
        }
        
        .breadcrumb-item.active {
            color: rgba(255, 255, 255, 0.9);
        }
        
        .section-title {
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid rgba(67, 97, 238, 0.1);
        }
        
        .card-header-custom {
            background: white;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            padding: 1.25rem 1.5rem;
        }
        
        .badge-status {
            padding: 0.35rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        
        /* Estilos específicos para el panel de asistencia */
        .attendance-option {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .attendance-option:hover {
            background-color: rgba(0, 0, 0, 0.03);
        }
        
        .attendance-option.active {
            background-color: rgba(67, 97, 238, 0.1);
            border: 1px solid rgba(67, 97, 238, 0.3);
        }
        
        .attendance-indicator {
            width: 16px;
            height: 16px;
            border-radius: 50%;
            display: inline-block;
        }
        
        .present-indicator {
            background-color: var(--success-color);
        }
        
        .late-indicator {
            background-color: var(--warning-color);
        }
        
        .absent-indicator {
            background-color: var(--danger-color);
        }
        
        .justified-indicator {
            background-color: var(--info-color);
        }
        
        .student-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #e9ecef;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            color: #6c757d;
        }
        
        .student-name {
            font-weight: 600;
            color: #2d3748;
        }
        
        .student-info {
            font-size: 0.85rem;
            color: #6c757d;
        }
        
        .attendance-summary {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 1.5rem;
        }
        
        .attendance-badge {
            font-size: 0.8rem;
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-weight: 600;
        }
        
        .attendance-date-picker {
            max-width: 250px;
        }
        
        .grade-section-card {
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .grade-section-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        }
        
        .grade-section-card.active {
            border: 2px solid var(--primary-color);
            background-color: rgba(67, 97, 238, 0.05);
        }
        
        .attendance-actions {
            position: sticky;
            bottom: 0;
            background: white;
            padding: 1rem;
            border-top: 1px solid #e9ecef;
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.05);
        }
    
/* Global attendance button base styles */
.attendance-btn,
.attendance-actions .attendance-btn,
#attendanceTable .attendance-btn {
    font-weight: 700 !important;
    font-size: 0.92rem !important;
    padding: 0.45rem 0.9rem !important;
    border-radius: 8px !important;
    letter-spacing: 0.3px !important;
}

/* --- STATUS COLORS --- */

/* Present */
.attendance-btn.btn-success,
.attendance-btn[data-status="present"] {
    background-color: #06d6a0 !important;
    border-color: #06d6a0 !important;
    color: #ffffff !important;
}

/* Present (outline) */
.attendance-btn.btn-outline-success {
    color: #06d6a0 !important;
    border-color: #06d6a0 !important;
    background-color: #ffffff !important;
}

/* Warning */
.attendance-btn.btn-warning {
    background-color: #ffd166 !important;
    border-color: #ffd166 !important;
    color: #000000 !important;
}

/* Absent / Danger */
.attendance-btn.btn-danger {
    background-color: #ef476f !important;
    border-color: #ef476f !important;
    color: #ffffff !important;
}

/* Info */
.attendance-btn.btn-info {
    background-color: #06b6d4 !important;
    border-color: #06b6d4 !important;
    color: #ffffff !important;
}

/* None */
.attendance-btn[data-status="none"] {
    background-color: #6b7280 !important;
    border-color: #6b7280 !important;
    color: #ffffff !important;
}

    </style>
</head>
<body>
    <div class="container-fluid py-4">
        <!-- Encabezado -->
        <div class="dashboard-header">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="h2 fw-bold mb-2">Panel de Asistencia</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="#" class="text-white-50">Inicio</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Asistencia</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-md-4 text-md-end">
                    <span class="badge bg-light text-primary fs-6 p-2">Sistema Escolar v2.0</span>
                </div>
            </div>
        </div>

        <!-- Filtros y controles -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card card-dashboard">
                    <div class="card-body">
                        <div class="row g-3 align-items-center">
                            <div class="col-md-3">
                                <label for="attendanceDate" class="form-label fw-semibold">Fecha de Asistencia</label>
                                <input type="date" class="form-control attendance-date-picker" id="attendanceDate" value="{{ date('Y-m-d') }}">
                            </div>
                            <div class="col-md-3">
                                <label for="gradeFilter" class="form-label fw-semibold">Grado</label>
                                <select class="form-select" id="gradeFilter">
                                    <option value="">Todos los grados</option>
                                    <option value="1">Primer Grado</option>
                                    <option value="2">Segundo Grado</option>
                                    <option value="3">Tercer Grado</option>
                                    <option value="4">Cuarto Grado</option>
                                    <option value="5">Quinto Grado</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="sectionFilter" class="form-label fw-semibold">Sección</label>
                                <select class="form-select" id="sectionFilter">
                                    <option value="">Todas las secciones</option>
                                    <option value="A">Sección A</option>
                                    <option value="B">Sección B</option>
                                    <option value="C">Sección C</option>
                                </select>
                            </div>
                            <div class="col-md-3 d-flex align-items-end">
                                <button class="btn btn-primary w-100" id="applyFilters">
                                    <i class="bi bi-funnel me-2"></i> Aplicar Filtros
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Resumen de Asistencia -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="attendance-summary">
                    <div class="row text-center">
                        <div class="col-md-3">
                            <div class="fw-bold text-primary fs-4">156</div>
                            <div class="text-muted">Total Estudiantes</div>
                        </div>
                        <div class="col-md-3">
                            <div class="fw-bold text-success fs-4">142</div>
                            <div class="text-muted">Presentes</div>
                        </div>
                        <div class="col-md-3">
                            <div class="fw-bold text-warning fs-4">8</div>
                            <div class="text-muted">Tardanzas</div>
                        </div>
                        <div class="col-md-3">
                            <div class="fw-bold text-danger fs-4">6</div>
                            <div class="text-muted">Faltas</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Selección de Grado/Sección -->
        <div class="row mb-4">
            <div class="col-12">
                <h4 class="section-title">Seleccionar Grado y Sección</h4>
                <div class="row g-3" id="gradeSectionGrid">
                    <!-- Las tarjetas de grados y secciones se generarán dinámicamente -->
                </div>
            </div>
        </div>

        <!-- Panel de Asistencia -->
        <div class="row">
            <div class="col-12">
                <div class="card card-dashboard">
                    <div class="card-header-custom d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-semibold" id="attendanceTitle">Asistencia - Todos los estudiantes</h5>
                        <div class="d-flex gap-2">
                            <button class="btn btn-sm btn-outline-primary" id="selectAllPresent">
                                <i class="bi bi-check-circle me-1"></i> Marcar Todos Presentes
                            </button>
                            <button class="btn btn-sm btn-outline-danger" id="resetAttendance">
                                <i class="bi bi-arrow-clockwise me-1"></i> Reiniciar
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0" id="attendanceTable">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4">Estudiante</th>
                                        <th>Grado/Sección</th>
                                        <th class="text-center">Asistencia</th>
                                        <th class="pe-4">Observaciones</th>
                                    </tr>
                                </thead>
                                <tbody id="attendanceTableBody">
                                    <!-- Los estudiantes se cargarán dinámicamente -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="attendance-actions">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-muted" id="attendanceStats">
                                <span id="presentCount">0</span> presentes, 
                                <span id="lateCount">0</span> tardanzas, 
                                <span id="absentCount">0</span> faltas
                            </div>
                            <div>
                                <button class="btn btn-success" id="saveAttendance">
                                    <i class="bi bi-check-lg me-2"></i> Guardar Asistencia
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para confirmación -->
    <div class="modal fade" id="confirmationModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">
                        <i class="bi bi-check-circle me-2"></i>Asistencia Guardada
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center py-4">
                    <i class="bi bi-check-circle-fill text-success display-4"></i>
                    <h4 class="mt-3">¡Asistencia registrada exitosamente!</h4>
                    <p class="text-muted">La asistencia de los estudiantes ha sido guardada en el sistema.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Datos de ejemplo para estudiantes
        const studentsData = [
            { id: 1, name: "Ana García López", grade: "1", section: "A", dni: "12345678" },
            { id: 2, name: "Carlos Rodríguez Pérez", grade: "1", section: "A", dni: "23456789" },
            { id: 3, name: "María Fernández García", grade: "1", section: "A", dni: "34567890" },
            { id: 4, name: "Javier López Martínez", grade: "1", section: "B", dni: "45678901" },
            { id: 5, name: "Laura Martínez Sánchez", grade: "1", section: "B", dni: "56789012" },
            { id: 6, name: "Diego Sánchez Ruiz", grade: "2", section: "A", dni: "67890123" },
            { id: 7, name: "Sofía Hernández Díaz", grade: "2", section: "A", dni: "78901234" },
            { id: 8, name: "Pablo Díaz Gómez", grade: "2", section: "B", dni: "89012345" },
            { id: 9, name: "Elena Gómez Álvarez", grade: "2", section: "B", dni: "90123456" },
            { id: 10, name: "Miguel Álvarez Romero", grade: "3", section: "A", dni: "01234567" },
            { id: 11, name: "Carmen Romero Navarro", grade: "3", section: "A", dni: "11223344" },
            { id: 12, name: "José Navarro Torres", grade: "3", section: "B", dni: "22334455" },
            { id: 13, name: "Isabel Torres Jiménez", grade: "3", section: "B", dni: "33445566" },
            { id: 14, name: "Francisco Jiménez Ruiz", grade: "4", section: "A", dni: "44556677" },
            { id: 15, name: "Rosa Ruiz Moreno", grade: "4", section: "A", dni: "55667788" },
            { id: 16, name: "Antonio Moreno Vargas", grade: "4", section: "B", dni: "66778899" },
            { id: 17, name: "Teresa Vargas Castro", grade: "4", section: "B", dni: "77889900" },
            { id: 18, name: "Manuel Castro Ortega", grade: "5", section: "A", dni: "88990011" },
            { id: 19, name: "Patricia Ortega Medina", grade: "5", section: "A", dni: "99001122" },
            { id: 20, name: "Sergio Medina Reyes", grade: "5", section: "B", dni: "00112233" }
        ];

        // Datos de grados y secciones
        const gradesData = [
            { id: "1", name: "Primer Grado", sections: ["A", "B"] },
            { id: "2", name: "Segundo Grado", sections: ["A", "B"] },
            { id: "3", name: "Tercer Grado", sections: ["A", "B"] },
            { id: "4", name: "Cuarto Grado", sections: ["A", "B"] },
            { id: "5", name: "Quinto Grado", sections: ["A", "B"] }
        ];

        // Estado de la aplicación
        let currentAttendance = {};
        let selectedGrade = "";
        let selectedSection = "";

        // Inicializar la aplicación
        document.addEventListener('DOMContentLoaded', function() {
            initializeGradeSections();
            loadAllStudents();
            setupEventListeners();
        });

        // Inicializar la cuadrícula de grados y secciones
        function initializeGradeSections() {
            const gridContainer = document.getElementById('gradeSectionGrid');
            
            // Agregar opción para "Todos"
            gridContainer.innerHTML = `
                <div class="col-xl-2 col-md-3 col-sm-4 col-6">
                    <div class="card grade-section-card active" data-grade="" data-section="">
                        <div class="card-body text-center py-4">
                            <i class="bi bi-people-fill display-4 text-primary mb-3"></i>
                            <h5 class="card-title">Todos</h5>
                            <p class="text-muted mb-0">Todos los estudiantes</p>
                        </div>
                    </div>
                </div>
            `;
            
            // Agregar grados y secciones
            gradesData.forEach(grade => {
                grade.sections.forEach(section => {
                    gridContainer.innerHTML += `
                        <div class="col-xl-2 col-md-3 col-sm-4 col-6">
                            <div class="card grade-section-card" data-grade="${grade.id}" data-section="${section}">
                                <div class="card-body text-center py-4">
                                    <i class="bi bi-mortarboard-fill display-4 text-primary mb-3"></i>
                                    <h5 class="card-title">${grade.name}</h5>
                                    <p class="text-muted mb-0">Sección ${section}</p>
                                </div>
                            </div>
                        </div>
                    `;
                });
            });
            
            // Agregar event listeners a las tarjetas
            document.querySelectorAll('.grade-section-card').forEach(card => {
                card.addEventListener('click', function() {
                    // Remover clase active de todas las tarjetas
                    document.querySelectorAll('.grade-section-card').forEach(c => {
                        c.classList.remove('active');
                    });
                    
                    // Agregar clase active a la tarjeta clickeada
                    this.classList.add('active');
                    
                    // Obtener grado y sección seleccionados
                    selectedGrade = this.getAttribute('data-grade');
                    selectedSection = this.getAttribute('data-section');
                    
                    // Actualizar la tabla de asistencia
                    updateAttendanceTable();
                    
                    // Actualizar el título
                    updateAttendanceTitle();
                });
            });
        }

        // Cargar todos los estudiantes inicialmente
        function loadAllStudents() {
            studentsData.forEach(student => {
                currentAttendance[student.id] = {
                    status: 'present', // Por defecto, todos presentes
                    notes: ''
                };
            });
            
            updateAttendanceTable();
            updateAttendanceStats();
        }

        // Configurar event listeners
        function setupEventListeners() {
            // Botón para aplicar filtros
            document.getElementById('applyFilters').addEventListener('click', function() {
                const gradeFilter = document.getElementById('gradeFilter').value;
                const sectionFilter = document.getElementById('sectionFilter').value;
                
                // Encontrar y activar la tarjeta correspondiente
                let targetCard = null;
                
                if (gradeFilter === "" && sectionFilter === "") {
                    targetCard = document.querySelector('.grade-section-card[data-grade=""][data-section=""]');
                } else {
                    targetCard = document.querySelector(`.grade-section-card[data-grade="${gradeFilter}"][data-section="${sectionFilter}"]`);
                }
                
                if (targetCard) {
                    // Simular clic en la tarjeta
                    targetCard.click();
                }
            });
            
            // Botón para marcar todos como presentes
            document.getElementById('selectAllPresent').addEventListener('click', function() {
                const filteredStudents = getFilteredStudents();
                
                filteredStudents.forEach(student => {
                    currentAttendance[student.id].status = 'present';
                });
                
                updateAttendanceTable();
                updateAttendanceStats();
            });
            
            // Botón para reiniciar asistencia
            document.getElementById('resetAttendance').addEventListener('click', function() {
                if (confirm('¿Está seguro de que desea reiniciar la asistencia? Se perderán todos los cambios no guardados.')) {
                    const filteredStudents = getFilteredStudents();
                    
                    filteredStudents.forEach(student => {
                        currentAttendance[student.id].status = 'present';
                        currentAttendance[student.id].notes = '';
                    });
                    
                    updateAttendanceTable();
                    updateAttendanceStats();
                }
            });
            
            // Botón para guardar asistencia
            document.getElementById('saveAttendance').addEventListener('click', function() {
                // Simular guardado de datos
                const confirmationModal = new bootstrap.Modal(document.getElementById('confirmationModal'));
                confirmationModal.show();
            });
        }

        // Obtener estudiantes filtrados según selección actual
        function getFilteredStudents() {
            if (selectedGrade === "" && selectedSection === "") {
                return studentsData;
            }
            
            return studentsData.filter(student => {
                const gradeMatch = selectedGrade === "" || student.grade === selectedGrade;
                const sectionMatch = selectedSection === "" || student.section === selectedSection;
                return gradeMatch && sectionMatch;
            });
        }

        // Actualizar la tabla de asistencia
        function updateAttendanceTable() {
            const tableBody = document.getElementById('attendanceTableBody');
            const filteredStudents = getFilteredStudents();
            
            tableBody.innerHTML = '';
            
            filteredStudents.forEach(student => {
                const attendance = currentAttendance[student.id];
                
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td class="ps-4">
                        <div class="d-flex align-items-center">
                            <div class="student-avatar me-3">
                                <i class="bi bi-person"></i>
                            </div>
                            <div>
                                <div class="student-name">${student.name}</div>
                                <div class="student-info">DNI: ${student.dni}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="badge bg-primary bg-opacity-10 text-primary">${student.grade}° Grado</span>
                        <span class="badge bg-success bg-opacity-10 text-success">Sección ${student.section}</span>
                    </td>
                    <td class="text-center">
                        <div class="btn-group btn-group-sm" role="group">
                            <button type="button" class="btn ${attendance.status === 'present' ? 'btn-success' : 'btn-outline-success'} attendance-btn" data-student="${student.id}" data-status="present" style="${attendance.status === 'present' ? 'background-color:#06d6a0;border-color:#06d6a0;color:#ffffff;' : ''}">
                                <i class="bi bi-check-lg me-1"></i> Presente
                            </button>
                            <button type="button" class="btn ${attendance.status === 'late' ? 'btn-warning' : 'btn-outline-warning'} attendance-btn" data-student="${student.id}" data-status="late" style="${attendance.status === 'late' ? 'background-color:#ffd166;border-color:#ffd166;color:#000000;' : ''}">
                                <i class="bi bi-clock me-1"></i> Tardanza
                            </button>
                            <button type="button" class="btn ${attendance.status === 'absent' ? 'btn-danger' : 'btn-outline-danger'} attendance-btn" data-student="${student.id}" data-status="absent" style="${attendance.status === 'absent' ? 'background-color:#ef476f;border-color:#ef476f;color:#ffffff;' : ''}">
                                <i class="bi bi-x-lg me-1"></i> Falta
                            </button>
                            <button type="button" class="btn ${attendance.status === 'justified' ? 'btn-info' : 'btn-outline-info'} attendance-btn" data-student="${student.id}" data-status="justified" style="${attendance.status === 'justified' ? 'background-color:#06b6d4;border-color:#06b6d4;color:#ffffff;' : ''}">
                                <i class="bi bi-file-text me-1"></i> Justificado
                            </button>
                        </div>
                    </td>
                    <td class="pe-4">
                        <input type="text" class="form-control form-control-sm notes-input" placeholder="Observaciones..." data-student="${student.id}" value="${attendance.notes}">
                    </td>
                `;
                
                tableBody.appendChild(row);
            });
            
            // Agregar event listeners a los botones de asistencia
            document.querySelectorAll('.attendance-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const studentId = parseInt(this.getAttribute('data-student'));
                    const status = this.getAttribute('data-status');

                    currentAttendance[studentId].status = status;

                    // Immediate DOM update for responsiveness
                    const row = this.closest('tr');
                    if (row) {
                        const btns = row.querySelectorAll('.attendance-btn');
                        btns.forEach(b => {
                            if (!b) return;
                            b.classList.remove('btn-success','btn-warning','btn-danger','btn-info','btn-secondary');
                            b.classList.remove('btn-outline-success','btn-outline-warning','btn-outline-danger','btn-outline-info','btn-outline-secondary');
                            const s = b.getAttribute('data-status');
                            const outlineMap = {
                                'present': 'btn-outline-success',
                                'late': 'btn-outline-warning',
                                'absent': 'btn-outline-danger',
                                'justified': 'btn-outline-info',
                                'none': 'btn-outline-secondary'
                            };
                            b.classList.add(outlineMap[s] || 'btn-outline-secondary');
                            b.style.removeProperty('background-color');
                            b.style.removeProperty('border-color');
                            b.style.removeProperty('color');
                        });

                        const applyInline = (el, s) => {
                            if (!el) return;
                            if (s === 'none') {
                                el.classList.remove(`btn-${getStatusColor(s)}`);
                                el.classList.add(`btn-outline-${getStatusColor(s)}`);
                                el.style.removeProperty('background-color');
                                el.style.removeProperty('border-color');
                                el.style.removeProperty('color');
                                return;
                            }
                            el.classList.remove(`btn-outline-${getStatusColor(s)}`);
                            el.classList.add(`btn-${getStatusColor(s)}`);
                            switch (s) {
                                case 'present': el.style.setProperty('background-color', '#06d6a0', 'important'); el.style.setProperty('border-color', '#06d6a0', 'important'); el.style.setProperty('color', '#ffffff', 'important'); break;
                                case 'late': el.style.setProperty('background-color', '#ffd166', 'important'); el.style.setProperty('border-color', '#ffd166', 'important'); el.style.setProperty('color', '#000000', 'important'); break;
                                case 'absent': el.style.setProperty('background-color', '#ef476f', 'important'); el.style.setProperty('border-color', '#ef476f', 'important'); el.style.setProperty('color', '#ffffff', 'important'); break;
                                case 'justified': el.style.setProperty('background-color', '#06b6d4', 'important'); el.style.setProperty('border-color', '#06b6d4', 'important'); el.style.setProperty('color', '#ffffff', 'important'); break;
                            }
                        };

                        applyInline(this, status);
                    }

                    // Actualizar la fila y estadísticas
                    updateStudentRow(studentId);
                    updateAttendanceStats();
                });
            });
            
            // Agregar event listeners a los campos de observaciones
            document.querySelectorAll('.notes-input').forEach(input => {
                input.addEventListener('input', function() {
                    const studentId = parseInt(this.getAttribute('data-student'));
                    currentAttendance[studentId].notes = this.value;
                });
            });
        }

        // Actualizar la fila de un estudiante específico
        function updateStudentRow(studentId) {
            const student = studentsData.find(s => s.id === studentId);
            const attendance = currentAttendance[studentId];
            
            // Encontrar la fila del estudiante
            const rows = document.querySelectorAll('#attendanceTableBody tr');
            
            rows.forEach(row => {
                const nameCell = row.querySelector('.student-name');
                if (nameCell && nameCell.textContent === student.name) {
                    // Actualizar botones de asistencia
                    const presentBtn = row.querySelector('.attendance-btn[data-status="present"]');
                    const lateBtn = row.querySelector('.attendance-btn[data-status="late"]');
                    const absentBtn = row.querySelector('.attendance-btn[data-status="absent"]');
                    const justifiedBtn = row.querySelector('.attendance-btn[data-status="justified"]');
                    
                    // Remover todas las clases activas y limpiar estilos, asignando outline correcto por botón
                    [presentBtn, lateBtn, absentBtn, justifiedBtn].forEach(btn => {
                        if (!btn) return;
                        btn.classList.remove('btn-success', 'btn-warning', 'btn-danger', 'btn-info', 'btn-secondary');
                        btn.classList.remove('btn-outline-success', 'btn-outline-warning', 'btn-outline-danger', 'btn-outline-info', 'btn-outline-secondary');
                        const s = btn.getAttribute('data-status');
                        const outlineMap = {
                            'present': 'btn-outline-success',
                            'late': 'btn-outline-warning',
                            'absent': 'btn-outline-danger',
                            'justified': 'btn-outline-info',
                            'none': 'btn-outline-secondary'
                        };
                        btn.classList.add(outlineMap[s] || 'btn-outline-secondary');
                        btn.style.removeProperty('background-color');
                        btn.style.removeProperty('border-color');
                        btn.style.removeProperty('color');
                    });

                    // Agregar clase activa al botón correspondiente y asegurar estilo inline
                    switch(attendance.status) {
                        case 'present':
                            if (presentBtn) {
                                presentBtn.classList.remove('btn-outline-success');
                                presentBtn.classList.add('btn-success');
                                presentBtn.style.setProperty('background-color', '#06d6a0', 'important');
                                presentBtn.style.setProperty('border-color', '#06d6a0', 'important');
                                presentBtn.style.setProperty('color', '#ffffff', 'important');
                            }
                            break;
                        case 'late':
                            if (lateBtn) {
                                lateBtn.classList.remove('btn-outline-warning');
                                lateBtn.classList.add('btn-warning');
                                lateBtn.style.setProperty('background-color', '#ffd166', 'important');
                                lateBtn.style.setProperty('border-color', '#ffd166', 'important');
                                lateBtn.style.setProperty('color', '#000000', 'important');
                            }
                            break;
                        case 'absent':
                            if (absentBtn) {
                                absentBtn.classList.remove('btn-outline-danger');
                                absentBtn.classList.add('btn-danger');
                                absentBtn.style.setProperty('background-color', '#ef476f', 'important');
                                absentBtn.style.setProperty('border-color', '#ef476f', 'important');
                                absentBtn.style.setProperty('color', '#ffffff', 'important');
                            }
                            break;
                        case 'justified':
                            if (justifiedBtn) {
                                justifiedBtn.classList.remove('btn-outline-info');
                                justifiedBtn.classList.add('btn-info');
                                justifiedBtn.style.setProperty('background-color', '#06b6d4', 'important');
                                justifiedBtn.style.setProperty('border-color', '#06b6d4', 'important');
                                justifiedBtn.style.setProperty('color', '#ffffff', 'important');
                            }
                            break;
                        case 'none':
                        default:
                            // If 'none', ensure all buttons are in outline state and remove any inline styles
                            [presentBtn, lateBtn, absentBtn, justifiedBtn].forEach(btn => {
                                if (!btn) return;
                                btn.classList.remove('btn-success','btn-warning','btn-danger','btn-info','btn-secondary');
                                btn.classList.add(btn.getAttribute('data-status') ? 'btn-outline-'+getStatusColor(btn.getAttribute('data-status')) : 'btn-outline-secondary');
                                btn.style.removeProperty('background-color');
                                btn.style.removeProperty('border-color');
                                btn.style.removeProperty('color');
                            });
                            break;
                    }
                }
            });
        }

        // Actualizar estadísticas de asistencia
        function updateAttendanceStats() {
            const filteredStudents = getFilteredStudents();
            
            let presentCount = 0;
            let lateCount = 0;
            let absentCount = 0;
            let justifiedCount = 0;
            
            filteredStudents.forEach(student => {
                const status = currentAttendance[student.id].status;
                
                switch(status) {
                    case 'present':
                        presentCount++;
                        break;
                    case 'late':
                        lateCount++;
                        break;
                    case 'absent':
                        absentCount++;
                        break;
                    case 'justified':
                        justifiedCount++;
                        break;
                }
            });
            
            document.getElementById('presentCount').textContent = presentCount;
            document.getElementById('lateCount').textContent = lateCount;
            document.getElementById('absentCount').textContent = absentCount + justifiedCount;
            
            // Actualizar el resumen general
            document.querySelector('.attendance-summary .col-md-3:nth-child(1) .fs-4').textContent = filteredStudents.length;
            document.querySelector('.attendance-summary .col-md-3:nth-child(2) .fs-4').textContent = presentCount;
            document.querySelector('.attendance-summary .col-md-3:nth-child(3) .fs-4').textContent = lateCount;
            document.querySelector('.attendance-summary .col-md-3:nth-child(4) .fs-4').textContent = absentCount + justifiedCount;
        }

        // Actualizar el título de la tabla de asistencia
        function updateAttendanceTitle() {
            const titleElement = document.getElementById('attendanceTitle');
            
            if (selectedGrade === "" && selectedSection === "") {
                titleElement.textContent = "Asistencia - Todos los estudiantes";
            } else {
                const grade = gradesData.find(g => g.id === selectedGrade);
                titleElement.textContent = `Asistencia - ${grade.name}, Sección ${selectedSection}`;
            }
        }
    </script>
</body>
</html>