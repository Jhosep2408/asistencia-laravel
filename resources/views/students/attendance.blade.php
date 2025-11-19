<!DOCTYPE html>
<html lang="{{ session('language', 'es') }}" data-theme="{{ session('theme', 'light') }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Asistencia - Sistema Escolar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    
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
                        --sidebar-bg: #1e293b;
            --sidebar-header-bg: #0f172a;
            --sidebar-hover: #334155;
            --sidebar-active: #3b82f6;
            --header-bg: #0f172a;
            --header-gradient: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            --sidebar-width: 280px;
            --transition: all 0.3s ease;
            --border-radius: 12px;
        }



/* Sidebar Elegante - Tema Azul Oscuro Profesional */
* {
    box-sizing: border-box;
}

body {
    background-color: var(--light-bg);
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
    color: var(--text-primary);
    line-height: 1.5;
    font-weight: 400;
}


/* Sidebar Elegante - Tema Azul Oscuro Profesional */
.sidebar {
    width: var(--sidebar-width);
    background: linear-gradient(180deg, var(--sidebar-header-bg) 0%, var(--sidebar-bg) 100%);
    color: #e2e8f0;
    height: 100vh;
    position: fixed;
    transition: var(--transition);
    z-index: 1000;
    box-shadow: 4px 0 25px rgba(0, 0, 0, 0.25);
    overflow-y: auto;
    border-right: 1px solid rgba(255, 255, 255, 0.08);
}

.sidebar-header {
    padding: 1.75rem 1.5rem;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    background: var(--sidebar-header-bg);
    backdrop-filter: blur(10px);
    position: relative;
    overflow: hidden;
}

.sidebar-header::before {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    width: 120px;
    height: 120px;
    background: radial-gradient(circle, rgba(59, 130, 246, 0.15) 0%, rgba(59, 130, 246, 0) 70%);
    border-radius: 50%;
    transform: translate(30%, -30%);
}

.sidebar-header h3 {
    font-weight: 700;
    font-size: 1.5rem;
    letter-spacing: -0.025em;
    color: white;
    position: relative;
    z-index: 1;
}

.sidebar-header small {
    color: #94a3b8;
    font-size: 0.75rem;
    position: relative;
    z-index: 1;
}

.sidebar-menu {
    padding: 1rem 0;
}

.sidebar-menu .nav-link {
    color: #cbd5e1;
    padding: 0.875rem 1.5rem;
    margin: 0.125rem 0.75rem;
    border-radius: var(--border-radius);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    font-weight: 500;
    display: flex;
    align-items: center;
    position: relative;
    overflow: hidden;
    border: 1px solid transparent;
}

.sidebar-menu .nav-link::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    height: 100%;
    width: 0;
    background: linear-gradient(90deg, var(--sidebar-active) 0%, rgba(59, 130, 246, 0.1) 100%);
    transition: var(--transition);
}

.sidebar-menu .nav-link:hover {
    color: white;
    background-color: var(--sidebar-hover);
    transform: translateX(8px);
    border-color: rgba(255, 255, 255, 0.1);
}

.sidebar-menu .nav-link.active {
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.2) 0%, rgba(59, 130, 246, 0.1) 100%);
    color: #60a5fa;
    font-weight: 600;
    border-color: rgba(59, 130, 246, 0.3);
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.15);
    transform: translateX(8px);
}

.sidebar-menu .nav-link.active::before {
    width: 4px;
}

.sidebar-menu .nav-link i {
    margin-right: 0.75rem;
    font-size: 1.125rem;
    width: 20px;
    text-align: center;
    transition: var(--transition);
}

.sidebar-menu .nav-link.active i {
    color: #60a5fa;
    transform: scale(1.1);
}

.sidebar-menu .nav-link:hover i {
    transform: scale(1.1);
}

/* Separador para Cerrar Sesión */
.sidebar-menu .nav-item:last-child {
    margin-top: auto;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
    padding-top: 1rem;
}


/* Main Content */
.main-content {
    margin-left: var(--sidebar-width);
    padding: 2rem;
    transition: var(--transition);
}

/* Dashboard Header Profesional */
/* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 2rem;
            transition: var(--transition);
        }

        /* Dashboard Header Profesional - MODIFICADO */
        .dashboard-header {
            background: var(--header-gradient);
            color: white;
            border-radius: var(--border-radius);
            padding: 1.5rem 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.3);
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .dashboard-header::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 250px;
            height: 250px;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.2) 0%, rgba(99, 102, 241, 0) 70%);
            border-radius: 50%;
            transform: translate(30%, -30%);
        }

        .dashboard-header::after {
            content: '';
            position: absolute;
            bottom: -50px;
            left: -50px;
            width: 200px;
            height: 200px;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.15) 0%, rgba(59, 130, 246, 0) 70%);
            border-radius: 50%;
        }

        .dashboard-header h1 {
            font-weight: 700;
            font-size: 1.75rem;
            letter-spacing: -0.025em;
            margin-bottom: 0.25rem;
            position: relative;
            z-index: 1;
            background: linear-gradient(135deg, #fff 0%, #cbd5e1 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            display: inline-block;
        }

        .breadcrumb {
            background: rgba(255, 255, 255, 0.08);
            border-radius: 12px;
            padding: 0.5rem 1rem;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            position: relative;
            z-index: 1;
            display: inline-flex;
            margin-left: 1rem;
        }

        .breadcrumb-item a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: var(--transition);
            font-weight: 500;
        }

        .breadcrumb-item a:hover {
            color: white;
            transform: translateY(-1px);
        }

        .breadcrumb-item.active {
            color: #cbd5e1;
            font-weight: 600;
        }

        /* Dropdown de usuario en el header */
        .dashboard-header .dropdown .btn-light {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
            backdrop-filter: blur(10px);
            transition: var(--transition);
        }

        .dashboard-header .dropdown .btn-light:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .dashboard-header .dropdown-menu {
            background: #1e293b;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.3);
            border-radius: 12px;
            overflow: hidden;
        }

        .dashboard-header .dropdown-item {
            color: #cbd5e1;
            padding: 0.75rem 1rem;
            transition: var(--transition);
        }

        .dashboard-header .dropdown-item:hover {
            background: rgba(59, 130, 246, 0.2);
            color: #60a5fa;
            transform: translateX(4px);
        }

        .dashboard-header .dropdown-divider {
            border-color: rgba(255, 255, 255, 0.1);
        }

        /* Responsive */
        @media (max-width: 992px) {
            .sidebar { 
                width: 80px; 
                overflow: hidden; 
            }
            .sidebar .nav-link span { 
                display: none; 
            }
            .sidebar .nav-link i { 
                margin-right: 0; 
                font-size: 1.25rem; 
            }
            .main-content { 
                margin-left: 80px; 
            }
            .sidebar-header h3 { 
                display: none; 
            }
            .sidebar-header { 
                text-align: center; 
                padding: 1rem;
            }
            .sidebar-header::before {
                width: 60px;
                height: 60px;
            }
        }

        @media (max-width: 768px) {
            .main-content { 
                margin-left: 0; 
                padding: 1rem; 
            }
            .sidebar { 
                transform: translateX(-100%); 
            }
            .sidebar.active { 
                transform: translateX(0); 
            }
            .dashboard-header {
                padding: 1.25rem;
            }
            .dashboard-header h1 {
                font-size: 1.5rem;
            }
            .breadcrumb {
                margin-left: 0;
                margin-top: 0.5rem;
            }
            .dashboard-header-content {
                flex-direction: column;
                align-items: flex-start !important;
            }
            .dashboard-header-right {
                margin-top: 0.75rem;
                width: 100%;
                justify-content: space-between;
            }
        }

        /* Estilos adicionales para el header en una fila */
        .dashboard-header-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            position: relative;
            z-index: 2;
        }

        .dashboard-header-left {
            display: flex;
            align-items: center;
        }

        .dashboard-header-right {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .date-indicator {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            padding: 0.5rem 1rem;
            border: 1px solid rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            font-weight: 500;
        }


.card-dashboard {
    border: none;
    border-radius: var(--border-radius);
    box-shadow: var(--card-shadow);
    transition: var(--transition);
    overflow: hidden;
    background-color: var(--card-bg);
}

.card-dashboard:hover {
    transform: translateY(-4px);
    box-shadow: var(--card-hover-shadow);
}

.card-dashboard .card-body {
    padding: 1.75rem;
}

.stat-card {
    border-left: 4px solid;
    height: 100%;
    position: relative;
    overflow: hidden;
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
        
        /* Nuevos estilos para el escáner de código de barras */
        .scanner-section {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: var(--card-shadow);
            margin-bottom: 2rem;
        }
        
.scanner-video {
    width: 100%;
    height: 300px; /* Altura fija para mejor visualización */
    border-radius: 8px;
    border: 2px solid var(--primary-color);
    background-color: #000; /* Fondo negro para mejor contraste */
    object-fit: cover; /* Asegura que el video cubra el contenedor */
}

.scanner-container {
    position: relative;
    width: 100%;
    max-width: 500px;
    margin: 0 auto;
    background: #000;
    border-radius: 8px;
    overflow: hidden;
}

/* Indicador de estado de la cámara */
.camera-status {
    position: absolute;
    top: 10px;
    left: 10px;
    background: rgba(0,0,0,0.7);
    color: white;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 0.8rem;
    z-index: 10;
}
        .scanner-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(0, 0, 0, 0.5);
            border-radius: 8px;
            color: white;
            font-weight: 600;
        }
        
        .scanner-frame {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 70%;
            height: 150px;
            border: 3px solid var(--primary-color);
            border-radius: 8px;
            box-shadow: 0 0 0 1000px rgba(0, 0, 0, 0.3);
        }
        
        .barcode-input {
            font-size: 1.2rem;
            text-align: center;
            letter-spacing: 2px;
        }
        
        .scanner-result {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 1rem;
            margin-top: 1rem;
            border-left: 4px solid var(--primary-color);
        }
        
        .time-indicator {
            font-size: 0.9rem;
            font-weight: 600;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            display: inline-block;
        }
        
        .time-ok {
            background-color: rgba(6, 214, 160, 0.2);
            color: #06a37c;
        }
        
        .time-late {
            background-color: rgba(255, 209, 102, 0.2);
            color: #e6b400;
        }
        
        .time-absent {
            background-color: rgba(239, 71, 111, 0.2);
            color: #d63060;
        }
        
        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: var(--danger-color);
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 0.7rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .auto-save-badge {
            background-color: var(--success-color);
            color: white;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            font-size: 0.7rem;
            font-weight: 600;
        }

        .none-indicator {
    background-color: #6c757d;
}

.time-none {
    background-color: rgba(108, 117, 125, 0.2);
    color: #6c757d;
}

/* Agregar estos estilos al CSS existente */
.none-indicator {
    background-color: #6c757d;
}

.time-none {
    background-color: rgba(108, 117, 125, 0.2);
    color: #6c757d;
}

.btn-none {
    background-color: #6c757d;
    border-color: #6c757d;
    color: white;
}

.btn-outline-none {
    color: #6c757d;
    border-color: #6c757d;
}

.btn-outline-none:hover {
    background-color: #6c757d;
    border-color: #6c757d;
    color: white;
}

/* Estilos para el buscador */
.search-highlight {
    background-color: #fff3cd;
    padding: 2px 4px;
    border-radius: 3px;
    font-weight: 600;
}

.search-container {
    position: relative;
}

.search-loading {
    position: absolute;
    right: 50px;
    top: 50%;
    transform: translateY(-50%);
    color: #6c757d;
}

.no-results {
    text-align: center;
    padding: 2rem;
    color: #6c757d;
}

.no-results i {
    font-size: 3rem;
    margin-bottom: 1rem;
    opacity: 0.5;
}
/* Perfil en la parte inferior del sidebar */
        .sidebar-profile-bottom {
            margin-top: auto;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding: 1rem 0;
            background: rgba(255, 255, 255, 0.05);
            flex-shrink: 0;
        }

        .user-profile-dropdown {
            position: relative;
        }

        .user-profile-bottom-btn {
            background: transparent;
            border: none;
            color: white;
            border-radius: 12px;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
            padding: 1rem;
        }

        .user-profile-bottom-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
            transition: var(--transition);
        }

        .user-profile-bottom-btn:hover::before {
            left: 100%;
        }

        .user-profile-bottom-btn:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .profile-bottom-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            border: 2px solid rgba(255, 255, 255, 0.3);
            transition: var(--transition);
            margin-bottom: 0.5rem;
        }

        .user-profile-bottom-btn:hover .profile-bottom-icon {
            transform: scale(1.1);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }

        .profile-bottom-text {
            font-size: 0.9rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            transition: var(--transition);
        }

        .user-profile-bottom-btn:hover .profile-bottom-text {
            color: #60a5fa;
        }

        /* Dropdown menu mejorado para sidebar */
       .user-profile-menu {
            background: #1e293b !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            border-radius: 12px !important;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.3) !important;
            padding: 0.5rem !important;
            min-width: 250px !important;
            margin-bottom: 1rem !important;
            position: absolute;
            bottom: 100%;
            left: 0;
            right: 0;
            margin-left: auto;
            margin-right: auto;
            display: none;
            z-index: 1001;
        }

        .user-profile-menu.show {
            display: block !important;
        }

        .user-menu-item {
            border-radius: 8px !important;
            padding: 0.75rem 1rem !important;
            margin: 0.125rem 0 !important;
            transition: all 0.2s ease !important;
            border: none !important;
            color: #cbd5e1 !important;
            text-decoration: none;
            display: block;
            width: 100%;
            text-align: left;
            background: transparent;
            cursor: pointer;
        }

        .user-menu-item:hover {
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.1) 0%, rgba(99, 102, 241, 0.05) 100%) !important;
            transform: translateX(4px);
            color: #60a5fa !important;
        }

        .menu-icon {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            flex-shrink: 0;
            margin-right: 0.75rem;
        }

        .user-menu-item .fw-semibold {
            font-size: 0.85rem;
            color: #e2e8f0;
        }

        .user-menu-item .text-muted {
            font-size: 0.75rem;
            color: #94a3b8;
        }

        .user-menu-item.text-danger .fw-semibold {
            color: #f87171 !important;
        }

        .user-menu-item.text-danger:hover {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.1) 0%, rgba(239, 68, 68, 0.05) 100%) !important;
        }

        .dropdown-divider {
            border-color: rgba(255, 255, 255, 0.1) !important;
            margin: 0.5rem 0 !important;
        }

        /* Asegurar que el dropdown se muestre correctamente en el sidebar */
        .sidebar-profile-bottom .dropdown-menu {
            position: absolute !important;
            bottom: 100% !important;
            left: 50% !important;
            right: auto !important;
            top: auto !important;
            transform: translateX(-50%) !important;
        }

/* Responsive */

        /* Responsive */
        @media (max-width: 1200px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 992px) {
            .sidebar { 
                width: 80px; 
                overflow: hidden; 
            }
            .sidebar .nav-link span { 
                display: none; 
            }
            .sidebar .nav-link i { 
                margin-right: 0; 
                font-size: 1.25rem; 
            }
            .main-content { 
                margin-left: 80px; 
            }
            .sidebar-header h3 { 
                display: none; 
            }
            .sidebar-header { 
                text-align: center; 
                padding: 1rem;
            }
            .sidebar-header::before {
                width: 60px;
                height: 60px;
            }
            .stats-grid {
                grid-template-columns: 1fr;
            }
            
            /* Ajustes para el perfil en móvil */
            .profile-bottom-text {
                display: none !important;
            }
            
            .user-profile-bottom-btn {
                padding: 0.75rem !important;
            }
            
            .profile-bottom-icon {
                width: 40px;
                height: 40px;
                font-size: 1.2rem;
            }
        }

        @media (max-width: 768px) {
            .main-content { 
                margin-left: 0; 
            }
            .sidebar { 
                transform: translateX(-100%); 
            }
            .sidebar.active { 
                transform: translateX(0); 
            }
            .content-wrapper {
                padding: 1rem;
            }
            .dashboard-header {
                padding: 1.5rem;
            }
            .dashboard-header h1 {
                font-size: 2rem;
            }
        }

        /* Estilos para el modal de faltas automáticas */
#absentStudentsList tr:hover {
    background-color: rgba(220, 53, 69, 0.05);
}

.modal-lg {
    max-width: 900px;
}

.table-responsive {
    border: 1px solid #dee2e6;
    border-radius: 0.375rem;
}

/* Estilos para la gestión de feriados */
.holiday-item:hover {
    background-color: rgba(255, 193, 7, 0.1);
}

.holiday-actions .btn {
    padding: 0.25rem 0.5rem;
    font-size: 0.75rem;
}

.no-classes-badge {
    font-size: 0.7rem;
}

.empty-holidays {
    text-align: center;
    padding: 2rem;
    color: #6c757d;
}

.empty-holidays i {
    font-size: 3rem;
    margin-bottom: 1rem;
    opacity: 0.5;
}
    
    /* Scoped attendance button styles - affect only .attendance-btn inside attendance table/actions */
    #attendanceTable .attendance-btn,
    .attendance-actions .attendance-btn,
    .attendance-btn[data-status] {
        font-weight: 700 !important;
        font-size: 0.92rem !important;
        padding: 0.45rem 0.9rem !important;
        border-radius: 8px !important;
        letter-spacing: 0.3px !important;
    }

    /* Filled states */
    #attendanceTable button.attendance-btn.btn-success,
    .attendance-actions button.attendance-btn.btn-success,
    .attendance-btn[data-status="present"].btn-success {
        background-color: #06d6a0 !important;
        border-color: #06d6a0 !important;
        color: #ffffff !important;
    }

    /* Outline present */
    #attendanceTable button.attendance-btn.btn-outline-success,
    .attendance-actions button.attendance-btn.btn-outline-success {
        color: #06d6a0 !important;
        border-color: #06d6a0 !important;
        background-color: #ffffff !important;
    }

    /* Warning (late) */
    #attendanceTable button.attendance-btn.btn-warning,
    .attendance-actions button.attendance-btn.btn-warning,
    .attendance-btn[data-status="late"].btn-warning {
        background-color: #ffd166 !important;
        border-color: #ffd166 !important;
        color: #000000 !important;
    }

    /* Outline warning */
    #attendanceTable button.attendance-btn.btn-outline-warning,
    .attendance-actions button.attendance-btn.btn-outline-warning {
        color: #f59e0b !important;
        border-color: #f59e0b !important;
        background-color: #ffffff !important;
    }

    /* Danger (absent) */
    #attendanceTable button.attendance-btn.btn-danger,
    .attendance-actions button.attendance-btn.btn-danger {
        background-color: #ef476f !important;
        border-color: #ef476f !important;
        color: #ffffff !important;
    }

    /* Info (justified) */
    #attendanceTable button.attendance-btn.btn-info,
    .attendance-actions button.attendance-btn.btn-info {
        background-color: #06b6d4 !important;
        border-color: #06b6d4 !important;
        color: #ffffff !important;
    }

    /* None / Sin marcar */
    #attendanceTable button.attendance-btn[data-status="none"],
    .attendance-actions button.attendance-btn[data-status="none"] {
        background-color: #6b7280 !important;
        border-color: #6b7280 !important;
        color: #ffffff !important;
    }

    /* Icon spacing */
    .attendance-btn i { margin-right: 0.4rem !important; color: inherit !important; }

    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h3 class="mb-0 fw-bold">
                <i class="bi bi-mortarboard-fill me-2"></i>
                Sistema Escolar
            </h3>
            <small class="text-white-50">v2.0</small>
        </div>
        <div class="sidebar-menu">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.dashboard') }}">
                        <i class="bi bi-speedometer2"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('students.attendance') }}">
                        <i class="bi bi-clipboard-check"></i>
                        <span>Tomar Asistencia</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('students.attendanceviews') }}">
                        <i class="bi bi-graph-up"></i>
                        <span>Dashboard Asistencia</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('students.index') }}">
                        <i class="bi bi-people"></i>
                        <span>Estudiantes</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('attendance.reports') }}">
                        <i class="bi bi-journal-text"></i>
                        <span>Reportes</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('settings.show') }}">
                        <i class="bi bi-gear"></i>
                        <span>Configuración</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- Perfil de Usuario en la parte inferior -->
        <div class="sidebar-profile-bottom">
            <div class="user-profile-dropdown">
                <button class="user-profile-bottom-btn d-flex flex-column align-items-center w-100 p-3" data-bs-toggle="dropdown">
                    <div class="profile-bottom-icon">
                        <i class="bi bi-person-fill"></i>
                    </div>
                    <div class="profile-bottom-text text-white fw-bold">PERFIL</div>
                </button>
                <ul class="dropdown-menu user-profile-menu">
                    <li>
                        <a class="dropdown-item user-menu-item" href="{{ route('profile.show') }}">
                            <div class="d-flex align-items-center">
                                <div class="menu-icon bg-primary bg-opacity-10 text-primary">
                                    <i class="bi bi-person"></i>
                                </div>
                                <div class="ms-3">
                                    <div class="fw-semibold">Mi Perfil</div>
                                    <small class="text-muted">Ver y editar perfil</small>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item user-menu-item" href="{{ route('settings.show') }}">
                            <div class="d-flex align-items-center">
                                <div class="menu-icon bg-info bg-opacity-10 text-info">
                                    <i class="bi bi-gear"></i>
                                </div>
                                <div class="ms-3">
                                    <div class="fw-semibold">Configuración</div>
                                    <small class="text-muted">Ajustes del sistema</small>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item user-menu-item" href="{{ route('about') }}">
                            <div class="d-flex align-items-center">
                                <div class="menu-icon bg-warning bg-opacity-10 text-warning">
                                    <i class="bi bi-info-circle"></i>
                                </div>
                                <div class="ms-3">
                                    <div class="fw-semibold">Acerca de</div>
                                    <small class="text-muted">Información del sistema</small>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item user-menu-item" href="{{ route('privacy') }}">
                            <div class="d-flex align-items-center">
                                <div class="menu-icon bg-success bg-opacity-10 text-success">
                                    <i class="bi bi-shield-check"></i>
                                </div>
                                <div class="ms-3">
                                    <div class="fw-semibold">Privacidad</div>
                                    <small class="text-muted">Configuración de privacidad</small>
                                </div>
                            </div>
                        </a>
                    </li>
                     <div class="dropdown-divider"></div>
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="user-menu-item text-danger w-100 text-start border-0 bg-transparent">
                            <div class="d-flex align-items-center">
                                <div class="menu-icon bg-danger bg-opacity-10 text-danger">
                                    <i class="bi bi-box-arrow-right"></i>
                                </div>
                                <div class="ms-3">
                                    <div class="fw-semibold">Cerrar Sesión</div>
                                    <small class="text-muted">Salir del sistema</small>
                                </div>
                            </div>
                        </button>
                    </form>
                </div>
                </ul>
            </div>
        </div>
    </div>
    <div class="container-fluid py-4">
        <!-- Encabezado -->

    
    <!-- Main Content -->
    <div class="main-content">
        <!-- Encabezado -->
<!-- Encabezado - MODIFICADO PARA UNA SOLA FILA -->
        <div class="dashboard-header">
            <div class="dashboard-header-content">
                <div class="dashboard-header-left">
                    <h1 class="h2 fw-bold mb-2">Tomar Asistencia</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-white-50">Inicio</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('students.attendance') }}" class="text-white-50">Asistencia</a></li>
                        </ol>
                    </nav>
                </div>
                <div class="dashboard-header-right">
                    <span class="date-indicator">Hoy: {{ date('d/m/Y') }}</span>
                    
                </div>
            </div>
        </div>

        <!-- Filtros y controles -->
<!-- Filtros y controles - MODIFICADO CON TURNO -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card card-dashboard">
            <div class="card-body">
                <div class="row g-3 align-items-center">
                    <div class="col-md-2">
                        <label for="attendanceDate" class="form-label fw-semibold">Fecha de Asistencia</label>
                        <input type="date" class="form-control attendance-date-picker" id="attendanceDate" value="{{ date('Y-m-d') }}">
                    </div>
                    <div class="col-md-2">
                        <label for="gradeFilter" class="form-label fw-semibold">Grado</label>
                        <select class="form-select" id="gradeFilter">
                            <option value="">Todos los grados</option>
                            @foreach($grades as $grade)
                                <option value="{{ $grade['id'] }}">{{ $grade['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="sectionFilter" class="form-label fw-semibold">Sección</label>
                        <select class="form-select" id="sectionFilter" disabled>
                            <option value="">Todas las secciones</option>
                        </select>
                    </div>
                    <!-- NUEVO FILTRO DE TURNO -->
                    <div class="col-md-2">
                        <label for="shiftFilter" class="form-label fw-semibold">Turno</label>
                        <select class="form-select" id="shiftFilter">
                            <option value="">Todos los turnos</option>
                            <option value="morning">Mañana</option>
                            <option value="afternoon">Tarde</option>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button class="btn btn-primary w-100" id="applyFilters">
                            <i class="bi bi-funnel me-2"></i> Aplicar Filtros
                        </button>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button class="btn btn-outline-secondary w-100" id="clearFilters">
                            <i class="bi bi-arrow-clockwise me-2"></i> Limpiar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

        <!-- Resumen de Asistencia -->
<!-- Resumen de Asistencia -->
<div class="row mb-4">
    <div class="col-12">
        <div class="attendance-summary" id="attendanceSummaryDB">
            <div class="row text-center">
                <div class="col-md-2">
                    <div class="fw-bold text-primary fs-4" id="totalStudents">{{ $totalStudents }}</div>
                    <div class="text-muted">Total Estudiantes</div>
                </div>
                <div class="col-md-2">
                    <div class="fw-bold text-success fs-4" id="presentCountSummary">0</div>
                    <div class="text-muted">Presentes</div>
                </div>
                <div class="col-md-2">
                    <div class="fw-bold text-warning fs-4" id="lateCountSummary">0</div>
                    <div class="text-muted">Tardanzas</div>
                </div>
                <div class="col-md-2">
                    <div class="fw-bold text-danger fs-4" id="absentCountSummary">0</div>
                    <div class="text-muted">Faltas</div>
                </div>
                <div class="col-md-2">
                    <div class="fw-bold text-info fs-4" id="justifiedCountSummary">0</div>
                    <div class="text-muted">Justificados</div>
                </div>
                <div class="col-md-2">
                    <div class="fw-bold text-secondary fs-4" id="noneCountSummary">0</div>
                    <div class="text-muted">Sin Marcar</div>
                </div>
            </div>
        </div>
    </div>
</div>

        <!-- Sección de Escáner de Código de Barras -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="scanner-section">
                    <h4 class="section-title d-flex align-items-center">
                        <i class="bi bi-upc-scan me-2"></i> Escáner de Código de Barras
                        <span class="badge bg-primary ms-2">Nuevo</span>
                        <span class="auto-save-badge ms-2">
                            <i class="bi bi-lightning-charge-fill me-1"></i> Guardado Automático
                        </span>
                    </h4>
                    
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <div class="scanner-container">
                                <div class="camera-status" id="cameraStatus">
                                    <i class="bi bi-camera-video me-1"></i> Cámara: Inactiva
                                </div>
                                <video id="scannerVideo" class="scanner-video" playsinline autoplay></video>
                                <div id="scannerOverlay" class="scanner-overlay" style="display: none;">
                                    <div class="text-center">
                                        <i class="bi bi-camera-video-off display-4 mb-2"></i>
                                        <p>Cámara no disponible</p>
                                    </div>
                                </div>
                                <div class="scanner-frame"></div>
                            </div>
                            
                            <div class="mt-3 text-center">
                                <button class="btn btn-primary me-2" id="startScanner">
                                    <i class="bi bi-camera-video me-1"></i> Activar Cámara
                                </button>
                                <button class="btn btn-secondary" id="stopScanner" disabled>
                                    <i class="bi bi-stop-circle me-1"></i> Detener
                                </button>
                            </div>
                        </div>
                        
                        <div class="col-lg-6">
                            <!-- Modificar el input en el HTML -->
                            <div class="mb-3">
                                <label for="barcodeInput" class="form-label fw-semibold">
                                    <i class="bi bi-upc-scan me-1"></i> Escanear con lector físico o ingresar código manualmente:
                                </label>
                                <input type="text" class="form-control barcode-input" id="barcodeInput" 
                                    placeholder="Pase el código de barras por el lector o ingrese manualmente"
                                    autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false">
                                <div class="form-text">
                                    <i class="bi bi-info-circle me-1"></i>
                                    El sistema detecta automáticamente los escaneos desde lectores físicos. 
                                    También puede escribir manualmente y presionar Enter.
                                </div>
                            </div>
                                                        
                            <div id="scannerResult" class="scanner-result" style="display: none;">
                                <h6 class="fw-semibold mb-2">Resultado del Escaneo:</h6>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span id="scannedStudentName" class="fw-bold"></span>
                                    <span id="scannedStatus" class="badge-status"></span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small id="scannedStudentInfo" class="text-muted"></small>
                                    <span id="scannedTime" class="time-indicator"></span>
                                </div>
                                <div class="mt-2">
                                    <small class="text-success">
                                        <i class="bi bi-check-circle-fill me-1"></i> Asistencia guardada automáticamente
                                    </small>
                                </div>
                            </div>
                            
                           <div class="mt-3">
                                <div class="alert alert-info">
                                    <i class="bi bi-info-circle me-2"></i>
                                    <strong>Instrucciones:</strong> 
                                    <ul class="mb-0 mt-2">
                                        <li>Por defecto los estudiantes aparecen como <span class="badge bg-secondary">Sin marcar</span></li>
                                        <li>Solo se guardarán los estudiantes que tengan un estado definido</li>
                                        <li>Use el botón <span class="badge bg-secondary">Sin marcar</span> para quitar la asistencia registrada</li>
                                        <li><strong>Turno Mañana:</strong></li>
                                        <ul>
                                            <li>Antes de 7:30 AM: <span class="badge bg-success">Presente</span></li>
                                            <li>Entre 7:30 AM y 8:00 AM: <span class="badge bg-warning">Tardanza</span></li>
                                            <li>Después de 8:00 AM: <span class="badge bg-danger">Falta</span> + Notificación</li>
                                        </ul>
                                        <li><strong>Turno Tarde:</strong></li>
                                        <ul>
                                            <li>Antes de 1:30 PM: <span class="badge bg-success">Presente</span></li>
                                            <li>Entre 1:30 PM y 2:00 PM: <span class="badge bg-warning">Tardanza</span></li>
                                            <li>Después de 2:00 PM: <span class="badge bg-danger">Falta</span> + Notificación</li>
                                        </ul>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Selección de Grado/Sección -->
        <div class="row mb-4">
            <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                    <h4 class="section-title mb-0">Seleccionar Grado y Sección</h4>
                    <button type="button" class="btn btn-sm btn-outline-secondary" id="toggleGradeSectionBtn" aria-expanded="false"
                        onclick="(function(b){const w=document.getElementById('gradeSectionWrapper'); const isCollapsed = w.classList.toggle('collapsed'); b.setAttribute('aria-expanded', String(!isCollapsed)); b.textContent = isCollapsed ? 'Mostrar secciones' : 'Ocultar secciones';})(this)">
                        Mostrar secciones
                    </button>
                </div>

                <div id="gradeSectionWrapper" class="grade-section-wrapper collapsed">
                    <div class="row g-3" id="gradeSectionGrid">
                        <!-- Las tarjetas de grados y secciones se generarán dinámicamente -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Panel de Asistencia -->
        <style>
        /* Estilos específicos para los botones de acciones de asistencia */
        .card-header-custom .d-flex .btn {
            min-width: 170px;
            border-radius: 10px;
            padding: .375rem .8rem;
            font-weight: 600;
            letter-spacing: .2px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: .4rem;
            transition: background-color .12s ease, color .12s ease, transform .08s ease, box-shadow .12s ease;
        }

        /* Presente */
        #selectAllPresent {
            color: #05635b;
            border-color: #06d6a0;
            background-color: transparent;
        }
        #selectAllPresent:hover, #selectAllPresent:focus {
            background-color: #06d6a0;
            color: #ffffff;
            border-color: #06d6a0;
            box-shadow: 0 6px 18px rgba(6,214,160,0.12);
            transform: translateY(-1px);
        }

        /* Feriado */
        #markHoliday {
            color: #92400e;
            border-color: #ffd166;
            background-color: transparent;
        }
        #markHoliday:hover, #markHoliday:focus {
            background-color: #ffd166;
            color: #000000;
            border-color: #ffd166;
            box-shadow: 0 6px 18px rgba(255,209,102,0.12);
            transform: translateY(-1px);
        }

        /* Faltas automáticas */
        #markAllAbsent {
            color: #7f1d1d;
            border-color: #ef476f;
            background-color: transparent;
        }
        #markAllAbsent:hover, #markAllAbsent:focus {
            background-color: #ef476f;
            color: #ffffff;
            border-color: #ef476f;
            box-shadow: 0 6px 18px rgba(239,71,111,0.12);
            transform: translateY(-1px);
        }

        /* Reiniciar */
        #resetAttendance {
            color: #7f1d1d;
            border-color: #f87171;
            background-color: transparent;
        }
        #resetAttendance:hover, #resetAttendance:focus {
            background-color: #f87171;
            color: #ffffff;
            border-color: #f87171;
            box-shadow: 0 6px 18px rgba(248,113,113,0.12);
            transform: translateY(-1px);
        }

        /* Iconos más definidos */
        .card-header-custom .d-flex .btn i {
            font-size: 1rem;
            opacity: .95;
        }

        /* Ajuste responsive: botones más compactos en pantallas pequeñas */
        @media (max-width: 575px) {
            .card-header-custom .d-flex .btn { min-width: 120px; padding: .3rem .5rem; font-size: .9rem; }
        }
        /* Grade/Section collapse wrapper styles */
        .grade-section-wrapper {
            overflow: hidden;
            transition: max-height .28s ease, opacity .2s ease;
            max-height: 2000px;
            opacity: 1;
        }
        .grade-section-wrapper.collapsed {
            max-height: 0;
            opacity: 0;
        }
        #toggleGradeSectionBtn {
            min-width: 190px;
            padding: .5rem 1rem;
            font-size: 1rem;
            border-radius: 10px;
            font-weight: 600;
            color: #0f172a;
            background-color: #f8fafc;
            border: 1px solid #cbd5e1;
            transition: background-color .12s ease, transform .08s ease, box-shadow .12s ease;
        }
        #toggleGradeSectionBtn:hover, #toggleGradeSectionBtn:focus {
            background-color: #eef2ff;
            color: #0b1220;
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(2,6,23,0.06);
        }
        @media (max-width: 575px) {
            #toggleGradeSectionBtn { min-width: 140px; padding: .4rem .7rem; font-size: .95rem; }
        }
        </style>
        <div class="row">
            <div class="col-12">
                <div class="card card-dashboard">
                    <div class="card-header-custom d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-semibold" id="attendanceTitle">Asistencia - Todos los estudiantes</h5>
                        <div class="d-flex gap-2">
                            <button class="btn btn-sm btn-outline-primary" id="selectAllPresent">
                                <i class="bi bi-check-circle me-1"></i> Marcar Todos Presentes
                            </button>
                                <!-- NUEVO BOTÓN PARA FERIADOS -->
                            <button class="btn btn-sm btn-outline-warning" id="markHoliday">
                                <i class="bi bi-calendar-event me-1"></i> Marcar Feriado
                            </button>
                            <!-- AGREGAR ESTE NUEVO BOTÓN -->
                            <button class="btn btn-sm btn-outline-danger" id="markAllAbsent">
                                <i class="bi bi-x-circle me-1"></i> Marcar Faltas Automáticas
                            </button>
                            <button class="btn btn-sm btn-outline-danger" id="resetAttendance">
                                <i class="bi bi-arrow-clockwise me-1"></i> Reiniciar
                            </button>
                        </div>
                    </div>
                    <!-- AGREGAR BUSCADOR AQUÍ -->
            <div class="card-header-custom border-top-0">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="bi bi-search text-muted"></i>
                            </span>
                            <input type="text" 
                                   class="form-control border-start-0" 
                                   id="studentSearch" 
                                   placeholder="Buscar estudiante por nombre o DNI..."
                                   autocomplete="off">
                            <button class="btn btn-outline-secondary" type="button" id="clearSearch">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <small class="text-muted" id="searchResultsCount">
                            Mostrando <span id="visibleStudentsCount">0</span> de <span id="totalFilteredStudents">0</span> estudiantes
                        </small>
                    </div>
                </div>
            </div>
            <!-- FIN DEL BUSCADOR -->





                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0" id="attendanceTable">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4">Estudiante</th>
                                        <th>Grado/Sección</th>
                                        <th>Turno</th> <!-- NUEVA COLUMNA -->
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
                                <span class="ms-2 text-info">
                                    <i class="bi bi-info-circle me-1"></i> Cambios manuales requieren guardar
                                </span>
                            </div>
                            <div>
                                <button class="btn btn-success" id="saveAttendance">
                                    <i class="bi bi-check-lg me-2"></i> Guardar Asistencia Manual
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para confirmar faltas automáticas -->
<div class="modal fade" id="autoAbsenceModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="bi bi-exclamation-triangle me-2"></i>Confirmar Faltas Automáticas
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning">
                    <i class="bi bi-info-circle me-2"></i>
                    <strong>Advertencia:</strong> Esta acción marcará como <span class="badge bg-danger">FALTA</span> a todos los estudiantes que no tienen asistencia registrada hoy y enviará notificaciones automáticas a sus apoderados.
                </div>
                
                <div class="mb-3">
                    <h6>Estudiantes que recibirán falta automática:</h6>
                    <small class="text-muted">Total: <span id="totalAbsentStudents" class="fw-bold">0</span> estudiantes</small>
                </div>
                
                <div class="table-responsive" style="max-height: 400px;">
                    <table class="table table-sm table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>DNI</th>
                                <th>Nombre</th>
                                <th>Grado/Sección</th>
                                <th>Turno</th> <!-- NUEVA COLUMNA -->
                                <th>Apoderado</th>
                                <th>Teléfono</th>
                            </tr>
                        </thead>
                        <tbody id="absentStudentsList">
                            <!-- Lista de estudiantes se cargará aquí -->
                        </tbody>
                    </table>
                </div>
                
                <div class="form-check mt-3">
                    <input class="form-check-input" type="checkbox" id="sendNotifications" checked>
                    <label class="form-check-label" for="sendNotifications">
                        <i class="bi bi-whatsapp text-success me-1"></i> Enviar notificaciones por WhatsApp a los apoderados
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="confirmAutoAbsence">
                    <i class="bi bi-check-lg me-1"></i> Confirmar y Marcar Faltas
                </button>
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
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="closeModalBtn">Cerrar y Recargar</button>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">Volver al Dashboard</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para notificación de falta -->
    <div class="modal fade" id="absenceNotificationModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title">
                        <i class="bi bi-exclamation-triangle me-2"></i>Notificación de Falta
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-3">
                        <i class="bi bi-whatsapp text-success display-4"></i>
                    </div>
                    <h5 class="text-center">Notificación enviada al apoderado</h5>
                    <p class="text-muted text-center">Se ha enviado un mensaje de WhatsApp informando la falta del estudiante.</p>
                    
                    <div class="alert alert-light mt-3">
                        <strong>Estudiante:</strong> <span id="notifiedStudentName"></span><br>
                        <strong>Apoderado:</strong> <span id="notifiedParentName"></span><br>
                        <strong>Teléfono:</strong> <span id="notifiedParentPhone"></span><br>
                        <strong>Mensaje:</strong> <span id="notificationMessage" class="fst-italic"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <a href="#" id="whatsappLink" class="btn btn-success" target="_blank">
                        <i class="bi bi-whatsapp me-1"></i> Abrir WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para marcar feriado -->
<!-- Modal para marcar feriado - MODIFICADO -->
<div class="modal fade" id="holidayModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title">
                    <i class="bi bi-calendar-event me-2"></i>Gestión de Días Feriados
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <!-- Pestañas para gestión de feriados -->
                <ul class="nav nav-tabs mb-3" id="holidayTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="new-holiday-tab" data-bs-toggle="tab" 
                                data-bs-target="#new-holiday" type="button" role="tab">
                            <i class="bi bi-plus-circle me-1"></i>Nuevo Feriado
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="view-holidays-tab" data-bs-toggle="tab" 
                                data-bs-target="#view-holidays" type="button" role="tab">
                            <i class="bi bi-list-ul me-1"></i>Ver Feriados
                        </button>
                    </li>
                </ul>

                <!-- Contenido de las pestañas -->
                <div class="tab-content" id="holidayTabsContent">
                    <!-- Pestaña: Nuevo Feriado -->
                    <div class="tab-pane fade show active" id="new-holiday" role="tabpanel">
                        <form id="holidayForm">
                            @csrf
                            <div class="mb-3">
                                <label for="holidayDate" class="form-label">Fecha</label>
                                <input type="date" class="form-control" id="holidayDate" name="date" value="{{ date('Y-m-d') }}">
                            </div>
                            <div class="mb-3">
                                <label for="holidayReason" class="form-label">Motivo del Feriado</label>
                                <input type="text" class="form-control" id="holidayReason" name="reason" placeholder="Ej: Feriado nacional, Día festivo, etc.">
                            </div>
                            <div class="mb-3">
                                <label for="holidayDescription" class="form-label">Descripción (opcional)</label>
                                <textarea class="form-control" id="holidayDescription" name="description" rows="3" placeholder="Descripción adicional del feriado..."></textarea>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="noClasses" name="no_classes" checked>
                                <label class="form-check-label" for="noClasses">
                                    No hay clases este día
                                </label>
                            </div>
                        </form>
                        <div id="holidayAlert" class="alert alert-info mt-3" style="display: none;">
                            <i class="bi bi-info-circle me-2"></i>
                            <span id="holidayAlertText"></span>
                        </div>
                    </div>

                    <!-- Pestaña: Ver Feriados -->
                    <div class="tab-pane fade" id="view-holidays" role="tabpanel">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="mb-0">Lista de Días Feriados</h6>
                            <button class="btn btn-sm btn-outline-primary" id="refreshHolidays">
                                <i class="bi bi-arrow-clockwise"></i> Actualizar
                            </button>
                        </div>
                        
                        <div class="table-responsive" style="max-height: 400px;">
                            <table class="table table-sm table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Motivo</th>
                                        <th>Sin Clases</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="holidaysList">
                                    <!-- Los feriados se cargarán aquí dinámicamente -->
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-muted">
                                            <div class="spinner-border spinner-border-sm" role="status">
                                                <span class="visually-hidden">Cargando...</span>
                                            </div>
                                            <span class="ms-2">Cargando feriados...</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-warning" id="saveHoliday">
                    <i class="bi bi-save me-1"></i> Guardar Feriado
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para editar feriado -->
<div class="modal fade" id="editHolidayModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="bi bi-pencil-square me-2"></i>Editar Feriado
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editHolidayForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="editHolidayId" name="id">
                    <div class="mb-3">
                        <label for="editHolidayDate" class="form-label">Fecha</label>
                        <input type="date" class="form-control" id="editHolidayDate" name="date">
                    </div>
                    <div class="mb-3">
                        <label for="editHolidayReason" class="form-label">Motivo del Feriado</label>
                        <input type="text" class="form-control" id="editHolidayReason" name="reason">
                    </div>
                    <div class="mb-3">
                        <label for="editHolidayDescription" class="form-label">Descripción (opcional)</label>
                        <textarea class="form-control" id="editHolidayDescription" name="description" rows="3"></textarea>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="editNoClasses" name="no_classes">
                        <label class="form-check-label" for="editNoClasses">
                            No hay clases este día
                        </label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="updateHoliday">
                    <i class="bi bi-check-lg me-1"></i> Actualizar
                </button>
            </div>
        </div>
    </div>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Incluir la librería para código de barras -->
    <script src="https://cdn.jsdelivr.net/npm/quagga@0.12.1/dist/quagga.min.js"></script>
    <script>
// Función de debug para verificar turnos y horarios
function debugAttendanceLogic(student, studentShift) {
    const now = new Date();
    const currentTime = now.getHours() * 60 + now.getMinutes();
    
    console.log('=== DEBUG ATTENDANCE LOGIC ===');
    console.log('Estudiante:', student.name);
    console.log('DNI:', student.dni);
    console.log('Turno:', studentShift);
    console.log('Hora actual:', now.getHours() + ':' + now.getMinutes());
    console.log('Minutos desde medianoche:', currentTime);
    
    // Definir límites CORRECTOS
    let startTime, lateLimit, absentLimit;
    
    if (studentShift === 'morning') {
        startTime = 7 * 60; // 7:00 AM
        lateLimit = 7 * 60 + 30; // 7:30 AM
        absentLimit = 8 * 60; // 8:00 AM
    } else {
        startTime = 13 * 60; // 1:00 PM
        lateLimit = 13 * 60 + 30; // 1:30 PM
        absentLimit = 14 * 60; // 2:00 PM
    }
    
    console.log('Límites para turno', studentShift + ':');
    console.log('- Inicio:', Math.floor(startTime/60) + ':' + (startTime%60));
    console.log('- Tardanza:', Math.floor(lateLimit/60) + ':' + (lateLimit%60));
    console.log('- Falta:', Math.floor(absentLimit/60) + ':' + (absentLimit%60));
    
    // Determinar estado
    let status, label;
    if (currentTime < startTime) {
        status = 'present';
        label = 'A tiempo (antes del inicio)';
    } else if (currentTime < lateLimit) {
        status = 'present';
        label = 'A tiempo';
    } else if (currentTime < absentLimit) {
        status = 'late';
        label = 'Tardanza';
    } else {
        status = 'absent';
        label = 'Falta';
    }
    
    console.log('Estado calculado:', status);
    console.log('Etiqueta:', label);
    console.log('================================');
    
    return { status, label };
}

    // Función para verificar y enviar notificaciones automáticas
function checkAndSendAutomaticNotifications() {
    const now = new Date();
    const currentTime = now.getHours() * 60 + now.getMinutes(); // Minutos desde medianoche
    const eightAM = 10 * 60; // 1020 minutos
    
    
    // Solo verificar si es después de las 8:00 AM
    if (currentTime >= eightAM) {
        console.log('Verificando notificaciones automáticas...');
        
        fetch('{{ route("attendance.check.notifications") }}', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log('Notificaciones automáticas:', data.message);
                if (data.details && data.details.notificaciones_enviadas > 0) {
                    showTemporaryMessage(
                        `✅ Se enviaron ${data.details.notificaciones_enviadas} notificaciones automáticas de falta`,
                        'success'
                    );
                }
            } else {
                console.log('Info notificaciones automáticas:', data.message);
            }
        })
        .catch(error => {
            console.error('Error verificando notificaciones automáticas:', error);
        });
    }
}


// Funciones para manejar feriados
function openHolidayModal() {
    const holidayModal = new bootstrap.Modal(document.getElementById('holidayModal'));
    
    // Establecer la fecha actual
    document.getElementById('holidayDate').value = selectedDate;
    
    // Limpiar formulario
    document.getElementById('holidayReason').value = '';
    document.getElementById('holidayDescription').value = '';
    document.getElementById('noClasses').checked = true;
    document.getElementById('holidayAlert').style.display = 'none';
    
    // Cargar lista de feriados
    loadHolidaysList();
    
    // Verificar si ya es feriado
    checkIfHoliday(selectedDate);
    
    holidayModal.show();
}
// Cargar lista de feriados
function loadHolidaysList() {
    const holidaysList = document.getElementById('holidaysList');
    
    // Mostrar loading
    holidaysList.innerHTML = `
        <tr>
            <td colspan="4" class="text-center py-4 text-muted">
                <div class="spinner-border spinner-border-sm" role="status">
                    <span class="visually-hidden">Cargando...</span>
                </div>
                <span class="ms-2">Cargando feriados...</span>
            </td>
        </tr>
    `;

    fetch('/holidays/list')
        .then(response => {
            if (!response.ok) {
                throw new Error('Error al cargar la lista de feriados');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                updateHolidaysList(data.holidays);
            } else {
                throw new Error(data.message || 'Error en los datos');
            }
        })
        .catch(error => {
            console.error('Error cargando feriados:', error);
            holidaysList.innerHTML = `
                <tr>
                    <td colspan="4" class="text-center py-4 text-danger">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        Error al cargar feriados: ${error.message}
                    </td>
                </tr>
            `;
        });
}


// Actualizar la lista de feriados en la tabla
function updateHolidaysList(holidays) {
    const holidaysList = document.getElementById('holidaysList');
    
    if (holidays.length === 0) {
        holidaysList.innerHTML = `
            <tr>
                <td colspan="4" class="text-center py-5 empty-holidays">
                    <i class="bi bi-calendar-x"></i>
                    <p class="mt-2 mb-0">No hay días feriados registrados</p>
                    <small>Use la pestaña "Nuevo Feriado" para agregar uno</small>
                </td>
            </tr>
        `;
        return;
    }

    let html = '';
    holidays.forEach(holiday => {
        const date = new Date(holiday.date);
        const formattedDate = date.toLocaleDateString('es-ES', {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric'
        });
        
        const noClassesBadge = holiday.no_classes ? 
            '<span class="badge bg-danger no-classes-badge">Sin Clases</span>' : 
            '<span class="badge bg-secondary no-classes-badge">Con Clases</span>';
        
        html += `
            <tr class="holiday-item">
                <td class="fw-bold">${formattedDate}</td>
                <td>
                    <div class="fw-semibold">${holiday.reason}</div>
                    ${holiday.description ? `<small class="text-muted">${holiday.description}</small>` : ''}
                </td>
                <td>${noClassesBadge}</td>
                <td class="holiday-actions">
                    <button class="btn btn-sm btn-outline-primary me-1" onclick="editHoliday(${holiday.id})" 
                            data-bs-toggle="tooltip" title="Editar">
                        <i class="bi bi-pencil"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-danger" onclick="deleteHoliday(${holiday.id})" 
                            data-bs-toggle="tooltip" title="Eliminar">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            </tr>
        `;
    });
    
    holidaysList.innerHTML = html;
    
    // Inicializar tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
}

// Editar feriado
// Reemplazar la función editHoliday
function editHoliday(holidayId) {
    console.log('🔄 EDITANDO FERIADO - ID:', holidayId);
    console.log('📞 URL que se llamará:', `/holidays/${holidayId}`);
    
    fetch(`/holidays/${holidayId}`)
        .then(response => {
            console.log('📥 Respuesta del servidor (status):', response.status);
            if (!response.ok) {
                throw new Error(`Error HTTP: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('✅ Datos recibidos del servidor:', data);
            if (data.success) {
                const holiday = data.holiday;
                
                // Llenar el formulario de edición
                document.getElementById('editHolidayId').value = holiday.id;
                document.getElementById('editHolidayDate').value = holiday.date;
                document.getElementById('editHolidayReason').value = holiday.reason;
                document.getElementById('editHolidayDescription').value = holiday.description || '';
                document.getElementById('editNoClasses').checked = holiday.no_classes;
                
                // Mostrar modal de edición
                const editModal = new bootstrap.Modal(document.getElementById('editHolidayModal'));
                editModal.show();
                
                console.log('✅ Formulario de edición llenado correctamente');
            } else {
                throw new Error(data.message || 'Error en los datos del servidor');
            }
        })
        .catch(error => {
            console.error('❌ Error cargando feriado:', error);
            showTemporaryMessage('Error al cargar el feriado: ' + error.message, 'error');
        });
}


// Reemplazar la función updateHoliday
function updateHoliday() {
    const holidayId = document.getElementById('editHolidayId').value;
    
    if (!holidayId) {
        showTemporaryMessage('Error: ID de feriado no válido', 'error');
        return;
    }

    const formData = {
        date: document.getElementById('editHolidayDate').value,
        reason: document.getElementById('editHolidayReason').value,
        description: document.getElementById('editHolidayDescription').value,
        no_classes: document.getElementById('editNoClasses').checked,
        _token: '{{ csrf_token() }}'
    };
    
    console.log('🔄 ACTUALIZANDO FERIADO - ID:', holidayId);
    console.log('📤 Datos a enviar:', formData);
    console.log('📞 URL que se llamará:', `/holidays/${holidayId}`);
    console.log('🔧 Método: PUT');

    // Mostrar loading
    const updateButton = document.getElementById('updateHoliday');
    const originalText = updateButton.innerHTML;
    updateButton.innerHTML = '<i class="bi bi-arrow-repeat spinner-border spinner-border-sm me-1"></i> Actualizando...';
    updateButton.disabled = true;

    fetch(`/holidays/${holidayId}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify(formData)
    })
    .then(response => {
        console.log('📥 Respuesta del servidor (status):', response.status);
        console.log('📥 Respuesta del servidor (headers):', response.headers);
        
        if (!response.ok) {
            return response.text().then(text => {
                console.error('❌ Respuesta del servidor (texto):', text);
                throw new Error(`Error HTTP: ${response.status} - ${text}`);
            });
        }
        return response.json();
    })
    .then(data => {
        console.log('✅ Respuesta JSON del servidor:', data);
        if (data.success) {
            showTemporaryMessage('✅ Feriado actualizado correctamente', 'success');
            
            // Cerrar modal de edición
            const editModal = bootstrap.Modal.getInstance(document.getElementById('editHolidayModal'));
            editModal.hide();
            
            // Recargar lista de feriados
            loadHolidaysList();
            
            // Si se editó la fecha actual, actualizar la interfaz
            if (data.holiday.date === selectedDate) {
                updateHolidayIndicator(data.holiday);
            }
        } else {
            throw new Error(data.message || 'Error al actualizar');
        }
    })
    .catch(error => {
        console.error('❌ Error en updateHoliday:', error);
        showTemporaryMessage('Error al actualizar el feriado: ' + error.message, 'error');
    })
    .finally(() => {
        // Restaurar botón
        updateButton.innerHTML = originalText;
        updateButton.disabled = false;
    });
}

// Reemplazar la función deleteHoliday
// Reemplazar la función deleteHoliday - VERSIÓN MEJORADA CON SWEETALERT
function deleteHoliday(holidayId) {
    // Obtener información del feriado para mostrar en la confirmación
    fetch(`/holidays/${holidayId}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Error al cargar información del feriado');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                const holiday = data.holiday;
                const date = new Date(holiday.date);
                const formattedDate = date.toLocaleDateString('es-ES', {
                    day: '2-digit',
                    month: '2-digit',
                    year: 'numeric'
                });
                
                // Mostrar SweetAlert de confirmación
                Swal.fire({
                    title: '¿Eliminar Feriado?',
                    html: `
                        <div class="text-start">
                            <p><strong>Fecha:</strong> ${formattedDate}</p>
                            <p><strong>Motivo:</strong> ${holiday.reason}</p>
                            ${holiday.description ? `<p><strong>Descripción:</strong> ${holiday.description}</p>` : ''}
                            <p><strong>Sin clases:</strong> ${holiday.no_classes ? 'Sí' : 'No'}</p>
                        </div>
                        <div class="alert alert-warning mt-3">
                            <i class="bi bi-exclamation-triangle"></i>
                            <strong>Advertencia:</strong> Esta acción no se puede deshacer.
                        </div>
                    `,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: '<i class="bi bi-trash me-2"></i>Sí, eliminar',
                    cancelButtonText: '<i class="bi bi-x-circle me-2"></i>Cancelar',
                    reverseButtons: true,
                    customClass: {
                        confirmButton: 'btn btn-danger',
                        cancelButton: 'btn btn-secondary'
                    },
                    buttonsStyling: false,
                    showLoaderOnConfirm: true,
                    preConfirm: () => {
                        return fetch(`/holidays/${holidayId}`, {
                            method: 'DELETE',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(response => {
                            if (!response.ok) {
                                return response.json().then(err => {
                                    throw new Error(err.message || 'Error en la respuesta del servidor');
                                });
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (!data.success) {
                                throw new Error(data.message || 'Error al eliminar');
                            }
                            return data;
                        })
                        .catch(error => {
                            Swal.showValidationMessage(`Error: ${error.message}`);
                        });
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        const deletedHoliday = result.value.holiday;
                        
                        // Mostrar mensaje de éxito
                        Swal.fire({
                            title: '¡Eliminado!',
                            html: `
                                <div class="text-center">
                                    <i class="bi bi-check-circle text-success display-4 mb-3"></i>
                                    <p>El feriado ha sido eliminado correctamente</p>
                                    <div class="alert alert-info mt-3">
                                        <i class="bi bi-info-circle"></i>
                                        <strong>Fecha eliminada:</strong> ${formattedDate}<br>
                                        <strong>Motivo:</strong> ${deletedHoliday.reason}
                                    </div>
                                </div>
                            `,
                            icon: 'success',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: '<i class="bi bi-check-lg me-2"></i>Aceptar',
                            customClass: {
                                confirmButton: 'btn btn-success'
                            },
                            buttonsStyling: false
                        });
                        
                        // Recargar lista de feriados
                        loadHolidaysList();
                        
                        // Si se eliminó la fecha actual, quitar el indicador
                        if (deletedHoliday.date === selectedDate) {
                            removeHolidayIndicator();
                        }
                    }
                });
            } else {
                throw new Error(data.message || 'Error al cargar el feriado');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            
            // Mostrar SweetAlert de error
            Swal.fire({
                title: 'Error',
                text: 'Error al cargar la información del feriado: ' + error.message,
                icon: 'error',
                confirmButtonText: 'Aceptar',
                confirmButtonColor: '#d33'
            });
        });
}

// Quitar indicador de feriado
function removeHolidayIndicator() {
    const attendanceTitle = document.getElementById('attendanceTitle');
    const existingIndicator = attendanceTitle.querySelector('.badge.bg-warning');
    if (existingIndicator) {
        existingIndicator.remove();
    }
    
    // Habilitar funcionalidades
    document.getElementById('saveAttendance').disabled = false;
    document.getElementById('barcodeInput').disabled = false;
    document.getElementById('startScanner').disabled = false;
}

// En la función checkIfHoliday - CORREGIR
function checkIfHoliday(date) {
    fetch(`/holidays/check/date?date=${date}`)  // ← Cambiar a la ruta correcta
        .then(response => response.json())
        .then(data => {
            const alertDiv = document.getElementById('holidayAlert');
            const alertText = document.getElementById('holidayAlertText');
            
            if (data.is_holiday) {
                alertText.textContent = `Esta fecha ya está marcada como feriado: "${data.holiday.reason}"`;
                alertDiv.className = 'alert alert-warning mt-3';
                alertDiv.style.display = 'block';
            } else {
                alertDiv.style.display = 'none';
            }
        })
        .catch(error => {
            console.error('Error verificando feriado:', error);
        });
}

// Reemplazar la función saveHoliday
function saveHoliday() {
    const date = document.getElementById('holidayDate').value;
    const reason = document.getElementById('holidayReason').value;
    const description = document.getElementById('holidayDescription').value;
    const noClasses = document.getElementById('noClasses').checked;

    if (!date || !reason) {
        showTemporaryMessage('Por favor, complete la fecha y el motivo del feriado.', 'error');
        return;
    }

    const holidayData = {
        date: date,
        reason: reason,
        description: description,
        no_classes: noClasses,
        _token: '{{ csrf_token() }}'
    };

    console.log('Guardando nuevo feriado:', holidayData);

    // Mostrar loading
    const saveButton = document.getElementById('saveHoliday');
    const originalText = saveButton.innerHTML;
    saveButton.innerHTML = '<i class="bi bi-arrow-repeat spinner-border spinner-border-sm me-2"></i> Guardando...';
    saveButton.disabled = true;

    fetch('/holidays', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify(holidayData)
    })
    .then(response => {
        if (!response.ok) {
            return response.json().then(err => {
                throw new Error(err.message || 'Error en la respuesta del servidor');
            });
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            showTemporaryMessage('✅ Feriado guardado correctamente', 'success');
            const holidayModal = bootstrap.Modal.getInstance(document.getElementById('holidayModal'));
            holidayModal.hide();
            
            // Si es la fecha actual, actualizar la interfaz
            if (date === selectedDate) {
                updateHolidayIndicator(data.holiday);
            }
            
            // Recargar lista de feriados
            loadHolidaysList();
        } else {
            throw new Error(data.message || 'Error al guardar');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showTemporaryMessage('Error al guardar el feriado: ' + error.message, 'error');
    })
    .finally(() => {
        // Restaurar botón
        saveButton.innerHTML = originalText;
        saveButton.disabled = false;
    });
}

function updateHolidayIndicator(holiday) {
    // Agregar indicador visual en la interfaz
    const attendanceTitle = document.getElementById('attendanceTitle');
    const holidayIndicator = document.createElement('span');
    holidayIndicator.className = 'badge bg-warning ms-2';
    holidayIndicator.innerHTML = `<i class="bi bi-calendar-event me-1"></i> Feriado: ${holiday.reason}`;
    
    // Remover indicador anterior si existe
    const existingIndicator = attendanceTitle.querySelector('.badge.bg-warning');
    if (existingIndicator) {
        existingIndicator.remove();
    }
    
    attendanceTitle.appendChild(holidayIndicator);
    
    // Deshabilitar funcionalidades de asistencia si no hay clases
    if (holiday.no_classes) {
        document.getElementById('saveAttendance').disabled = true;
        document.getElementById('barcodeInput').disabled = true;
        document.getElementById('startScanner').disabled = true;
        
        showTemporaryMessage(`⚠️ Hoy es feriado: ${holiday.reason}. No hay clases.`, 'warning');
    }
}

// Verificar feriado al cargar la página
function checkCurrentDateHoliday() {
    fetch(`/holidays/check/date?date=${selectedDate}`)  // ← Cambiar a la ruta correcta
        .then(response => response.json())
        .then(data => {
            if (data.is_holiday) {
                updateHolidayIndicator(data.holiday);
            }
        })
        .catch(error => {
            console.error('Error verificando feriado actual:', error);
        });
}

// Función de debugging para verificar las rutas
function debugHolidayRoutes() {
    console.log('=== DEBUG HOLIDAY ROUTES ===');
    console.log('Ruta para listar feriados:', '/holidays/list');
    console.log('Ruta para crear feriado:', '/holidays');
    console.log('Ruta para mostrar feriado:', '/holidays/{id}');
    console.log('Ruta para actualizar feriado:', '/holidays/{id}');
    console.log('Ruta para eliminar feriado:', '/holidays/{id}');
    console.log('Ruta para verificar feriado:', '/holidays/check/date');
}

// Llamar al debugging al cargar la página
document.addEventListener('DOMContentLoaded', function() {
    debugHolidayRoutes();
});

// Agregar event listeners para la gestión de feriados
document.addEventListener('DOMContentLoaded', function() {
    // Botón para abrir modal de feriados
    document.getElementById('markHoliday').addEventListener('click', openHolidayModal);
    
    // Botón para guardar feriado
    document.getElementById('saveHoliday').addEventListener('click', saveHoliday);
    
    // Botón para actualizar feriado
    document.getElementById('updateHoliday').addEventListener('click', updateHoliday);
    
    // Botón para actualizar lista de feriados
    document.getElementById('refreshHolidays').addEventListener('click', loadHolidaysList);
    
    // Verificar feriado cuando cambia la fecha
    document.getElementById('attendanceDate').addEventListener('change', function() {
        setTimeout(checkCurrentDateHoliday, 100);
    });
    
    // Verificar si la fecha actual es feriado
    checkCurrentDateHoliday();
    
    // Verificar feriado cuando se cambia la fecha en el modal
    document.getElementById('holidayDate').addEventListener('change', function() {
        checkIfHoliday(this.value);
    });
});



// Función mejorada para procesar código de barras después de las 8:00 AM
// Función mejorada para procesar código de barras después del horario límite
function processBarcodeAfter8AM(barcode) {
    const cleanBarcode = barcode.replace(/[^0-9a-zA-Z]/g, '');
    const student = studentsData.find(s => s.dni === cleanBarcode);
    
    if (!student) {
        showTemporaryMessage('Estudiante no encontrado. Verifique el código de barras.', 'error');
        return;
    }
    
    // Obtener el turno del estudiante
    const studentShift = student.shift || 'morning';
    
    // Después del horario límite, siempre es falta
    const statusInfo = {
        status: 'absent',
        timeClass: 'time-absent',
        label: studentShift === 'morning' ? 'Falta (Después de 8:00 AM)' : 'Falta (Después de 2:00 PM)',
        shift: studentShift
    };
    
    // Actualizar la asistencia
    if (!currentAttendance[student.dni]) {
        currentAttendance[student.dni] = { status: 'absent', notes: '' };
    }
    currentAttendance[student.dni].status = statusInfo.status;
    
    // Mostrar resultado del escaneo
    showScannerResult(student, statusInfo);
    
    // Actualizar la tabla y estadísticas
    updateAttendanceTable();
    updateAttendanceStats();
    
    // Guardar automáticamente la asistencia de este estudiante
    saveSingleAttendance(student.dni);
    
    // Enviar notificación de falta
    sendAbsenceNotification(student, 'absent', studentShift);
    
    // Enfocar el input de código de barras para el próximo escaneo
    document.getElementById('barcodeInput').focus();
}


// Función para mostrar estado del lector físico
function showBarcodeReaderStatus() {
    const statusDiv = document.createElement('div');
    statusDiv.id = 'barcodeReaderStatus';
    statusDiv.className = 'alert alert-success alert-dismissible fade show';
    statusDiv.innerHTML = `
        <i class="bi bi-check-circle-fill me-2"></i>
        <strong>Lector de código de barras activo</strong> - El sistema está listo para recibir escaneos
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    const barcodeInput = document.getElementById('barcodeInput');
    barcodeInput.parentNode.insertBefore(statusDiv, barcodeInput.nextSibling);
    
    // Ocultar después de 5 segundos
    setTimeout(() => {
        if (statusDiv.parentElement) {
            statusDiv.remove();
        }
    }, 5000);
}

// Llamar esta función en la inicialización
// Inicializar la aplicación - MODIFICADA
document.addEventListener('DOMContentLoaded', function() {
    initializeGradeSections();
    setupEventListeners();
    loadAttendanceForDate(); // Esta función ahora inicializa todo
    setupBarcodeReaderListener();
    document.getElementById('barcodeInput').focus();
    showBarcodeReaderStatus();
});

// Agregar esta función al inicio del script (después de las variables globales)
// También asegúrate de que el listener del lector físico NO interfiera
function setupBarcodeReaderListener() {
    let barcode = '';
    let lastScanTime = 0;
    let readingFromScanner = false;
    
    document.addEventListener('keydown', function(e) {
        // Si el foco está en el input de barcode, NO procesar con el lector físico
        if (document.activeElement === document.getElementById('barcodeInput')) {
            return;
        }
        
        // Ignorar teclas especiales como Shift, Ctrl, etc.
        if (e.key.length === 1 && !e.ctrlKey && !e.altKey && !e.metaKey) {
            const currentTime = new Date().getTime();
            
            // Si pasó más de 100ms desde la última tecla, reiniciar el código
            if (currentTime - lastScanTime > 100) {
                barcode = '';
                readingFromScanner = true;
            }
            
            barcode += e.key;
            lastScanTime = currentTime;
            
            // Si el código tiene una longitud típica de DNI (8 dígitos) o más
            if (barcode.length >= 8) {
                // Pequeña pausa para asegurar que se completó el escaneo
                setTimeout(() => {
                    if (readingFromScanner) {
                        processBarcodeFromScanner(barcode.trim());
                        barcode = ''; // Reiniciar para el próximo escaneo
                        readingFromScanner = false;
                    }
                }, 50);
            }
        }
    });
}


// Función de debug EXTENDIDA para encontrar el problema
function debugCompleteAttendance(studentDni, horaPrueba = null) {
    const student = studentsData.find(s => s.dni === studentDni);
    if (!student) {
        console.log('❌ Estudiante no encontrado');
        return;
    }
    
    console.log('🔍 DEBUG COMPLETO - INICIO ======================');
    console.log('Estudiante:', student.name);
    console.log('DNI:', student.dni);
    console.log('Turno en datos:', student.shift);
    
    // Probar la función getAttendanceStatusByTime directamente
    console.log('🧪 Probando getAttendanceStatusByTime directamente...');
    const result = getAttendanceStatusByTime(student.shift);
    console.log('Resultado directo:', result);
    
    // Verificar si hay alguna variable global interfiriendo
    console.log('📊 Variables globales:');
    console.log('- selectedShift:', selectedShift);
    console.log('- selectedDate:', selectedDate);
    console.log('- scannerActive:', scannerActive);
    
    // Verificar currentAttendance para este estudiante
    console.log('📋 CurrentAttendance para este estudiante:');
    console.log('- currentAttendance[' + studentDni + ']:', currentAttendance[studentDni]);
    
    console.log('🔍 DEBUG COMPLETO - FIN ========================');
    
    return result;
}

// Buscar en todo el código dónde se podría estar forzando "absent"
function findAbsentForcingCode() {
    console.log('🔎 BUSCANDO CÓDIGO QUE FUERCE "absent"...');
    
    // Revisar event listeners
    const buttons = document.querySelectorAll('button, input, select');
    buttons.forEach(btn => {
        const onclick = btn.getAttribute('onclick');
        const onchange = btn.getAttribute('onchange');
        if (onclick && onclick.includes('absent')) {
            console.log('🚨 Botón con onclick que menciona "absent":', btn);
        }
        if (onchange && onchange.includes('absent')) {
            console.log('🚨 Elemento con onchange que menciona "absent":', btn);
        }
    });
    
    // Revisar funciones globales
    console.log('🔍 Funciones globales que contienen "absent":');
    Object.keys(window).forEach(key => {
        if (typeof window[key] === 'function') {
            const funcStr = window[key].toString();
            if (funcStr.includes('absent') && funcStr.includes('status')) {
                console.log('📝 Función:', key);
                console.log('   Contenido relevante:', funcStr.match(/absent.*status|status.*absent/g));
            }
        }
    });
}

// FUNCIÓN COMPLETAMENTE NUEVA - SIN POSIBLES INTERFERENCIAS
function getAttendanceStatusByTimeFixed(studentShift = null) {
    const now = new Date();
    const currentTime = now.getHours() * 60 + now.getMinutes();
    
    // SOLO usar el turno del estudiante, ignorar cualquier filtro
    const shift = studentShift || 'morning';
    
    console.log('🆕 FUNCIÓN FIXED - Calculando estado para:', {
        turnoEstudiante: studentShift,
        turnoUsado: shift,
        horaActual: now.getHours() + ':' + now.getMinutes().toString().padStart(2, '0'),
        minutos: currentTime
    });
    
    // LÍMITES MUY CLAROS
    const limits = {
        morning: { start: 420, late: 450, absent: 480 },    // 7:00, 7:30, 8:00
        afternoon: { start: 780, late: 810, absent: 840 }   // 13:00, 13:30, 14:00
    };
    
    const limit = limits[shift];
    
    console.log('📏 Límites aplicados:', limit);
    
    // LÓGICA MUY SIMPLE Y DIRECTA
    let status, label;
    
    if (currentTime < limit.start) {
        status = 'present';
        label = 'A tiempo (antes del inicio)';
    } else if (currentTime < limit.late) {
        status = 'present';
        label = 'A tiempo';
    } else if (currentTime < limit.absent) {
        status = 'late';
        label = shift === 'morning' ? 'Tardanza (después de 7:30 AM)' : 'Tardanza (después de 1:30 PM)';
    } else {
        status = 'absent';
        label = shift === 'morning' ? 'Falta (después de 8:00 AM)' : 'Falta (después de 2:00 PM)';
    }
    
    console.log('🎯 RESULTADO FIXED:', { status, label });
    
    return {
        status: status,
        timeClass: status === 'present' ? 'time-ok' : status === 'late' ? 'time-late' : 'time-absent',
        label: label,
        shift: shift
    };
}

// Prueba con la función nueva y limpia
function testFixedFunction(dni, horaPrueba = null) {
    const student = studentsData.find(s => s.dni === dni);
    if (!student) {
        console.log('❌ Estudiante no encontrado');
        return;
    }
    
    console.log('🧪 TEST FUNCIÓN FIXED =================');
    const result = getAttendanceStatusByTimeFixed(student.shift);
    console.log('✅ RESULTADO:', result);
    console.log('====================================');
    
    return result;
}

// TEMPORAL: Reemplazar la función problemática
const originalGetAttendanceStatusByTime = getAttendanceStatusByTime;
getAttendanceStatusByTime = getAttendanceStatusByTimeFixed;

console.log('🔄 Función getAttendanceStatusByTime reemplazada temporalmente');
// Ejecuta en consola:
// testFixedFunction('61623749')
// Ejecuta esto en la consola:
// debugCompleteAttendance('61623749')
// Función específica para procesar códigos de lectores físicos
// Función específica para procesar códigos de lectores físicos
// Función específica para procesar códigos de lectores físicos - CORREGIDA
// Función específica para procesar códigos de lectores físicos - COMPLETAMENTE CORREGIDA
// Función específica para procesar códigos de lectores físicos - VERSIÓN CORREGIDA
function processBarcodeFromScanner(scannedBarcode) {
    console.log('📷 Código escaneado desde lector físico:', scannedBarcode);
    
    // Limpiar el código (remover caracteres no deseados)
    const cleanBarcode = scannedBarcode.replace(/[^0-9a-zA-Z]/g, '');
    
    // Buscar estudiante por DNI
    const student = studentsData.find(s => s.dni === cleanBarcode);
    
    if (!student) {
        console.log('❌ Estudiante no encontrado con DNI:', cleanBarcode);
        showTemporaryMessage('Estudiante no encontrado. Verifique el código de barras.', 'error');
        
        // LIMPIAR EL INPUT DESPUÉS DE ESCANEAR
        document.getElementById('barcodeInput').value = '';
        return;
    }
    
    // Obtener el turno REAL del estudiante desde los datos
    const studentShift = student.shift || 'morning';
    console.log('🎯 INFORMACIÓN ESTUDIANTE:', {
        nombre: student.name,
        dni: student.dni,
        turno: studentShift
    });
    
    // EJECUTAR DEBUG PRIMERO
    debugAttendanceLogic(student, studentShift);
    
    // Determinar estado según la hora actual y el turno REAL del estudiante
    const statusInfo = getAttendanceStatusByTime(studentShift);
    
    console.log('🎯 ESTADO FINAL A APLICAR:', statusInfo);
    
    // Actualizar la asistencia
    if (!currentAttendance[student.dni]) {
        currentAttendance[student.dni] = { status: 'present', notes: '' };
    }
    currentAttendance[student.dni].status = statusInfo.status;
    
    // Mostrar resultado del escaneo
    showScannerResult(student, statusInfo);
    
    // Actualizar la tabla y estadísticas
    updateAttendanceTable();
    updateAttendanceStats();
    
    // Guardar automáticamente la asistencia de este estudiante
    saveSingleAttendance(student.dni);
    
    // Si es falta, enviar notificación
    if (statusInfo.status === 'absent') {
        console.log('📤 Enviando notificación de falta para:', student.name);
        sendAbsenceNotification(student, 'absent', studentShift);
    }
    
    // LIMPIAR EL INPUT DESPUÉS DE ESCANEAR
    document.getElementById('barcodeInput').value = '';
    
    // Enfocar el input de código de barras para el próximo escaneo
    document.getElementById('barcodeInput').focus();
}
// Función para procesar código de barras manual (Enter)
function processBarcodeManual(barcode) {
    console.log('⌨️ Código ingresado manualmente:', barcode);
    
    // Limpiar el código (remover caracteres no deseados)
    const cleanBarcode = barcode.replace(/[^0-9a-zA-Z]/g, '');
    
    // Buscar estudiante por DNI
    const student = studentsData.find(s => s.dni === cleanBarcode);
    
    if (!student) {
        console.log('❌ Estudiante no encontrado con DNI:', cleanBarcode);
        showTemporaryMessage('Estudiante no encontrado. Verifique el DNI ingresado.', 'error');
        
        // LIMPIAR EL INPUT
        document.getElementById('barcodeInput').value = '';
        return;
    }
    
    // Obtener el turno REAL del estudiante desde los datos
    const studentShift = student.shift || 'morning';
    console.log('🎯 INFORMACIÓN ESTUDIANTE:', {
        nombre: student.name,
        dni: student.dni,
        turno: studentShift
    });
    
    // Determinar estado según la hora actual y el turno REAL del estudiante
    const statusInfo = getAttendanceStatusByTime(studentShift);
    
    console.log('🎯 ESTADO FINAL A APLICAR:', statusInfo);
    
    // Actualizar la asistencia
    if (!currentAttendance[student.dni]) {
        currentAttendance[student.dni] = { status: 'present', notes: '' };
    }
    currentAttendance[student.dni].status = statusInfo.status;
    
    // Mostrar resultado del escaneo
    showScannerResult(student, statusInfo);
    
    // Actualizar la tabla y estadísticas
    updateAttendanceTable();
    updateAttendanceStats();
    
    // Guardar automáticamente la asistencia de este estudiante
    saveSingleAttendance(student.dni);
    
    // Si es falta, enviar notificación
    if (statusInfo.status === 'absent') {
        console.log('📤 Enviando notificación de falta para:', student.name);
        sendAbsenceNotification(student, 'absent', studentShift);
    }
    
    // LIMPIAR EL INPUT DESPUÉS DE PROCESAR
    document.getElementById('barcodeInput').value = '';
    
    // Enfocar el input para el próximo escaneo/ingreso
    document.getElementById('barcodeInput').focus();
}
// Función para mostrar mensajes temporales
function showTemporaryMessage(message, type = 'info') {
    const messageDiv = document.createElement('div');
    messageDiv.className = `alert alert-${type === 'error' ? 'danger' : 'info'} alert-dismissible fade show`;
    messageDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    const scannerSection = document.querySelector('.scanner-section');
    scannerSection.appendChild(messageDiv);
    
    // Remover automáticamente después de 3 segundos
    setTimeout(() => {
        if (messageDiv.parentElement) {
            messageDiv.remove();
        }
    }, 3000);
}



//nuevo
// Función para mostrar el modal de faltas automáticas - MODIFICADA
function showAutoAbsenceModal() {
    // Mostrar loading en el modal
    const tableBody = document.getElementById('absentStudentsList');
    tableBody.innerHTML = `
        <tr>
            <td colspan="6" class="text-center py-4"> <!-- Cambiar colspan a 6 -->
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Cargando...</span>
                </div>
                <p class="mt-2 text-muted">Cargando estudiantes sin asistencia...</p>
            </td>
        </tr>
    `;

    // Mostrar el modal inmediatamente
    const autoAbsenceModal = new bootstrap.Modal(document.getElementById('autoAbsenceModal'));
    autoAbsenceModal.show();

    // Construir parámetros de filtro incluyendo el turno
    const params = new URLSearchParams({
        date: selectedDate,
        grade_id: selectedGrade || '',
        section_id: selectedSection || '',
        shift: selectedShift || '' // ← AGREGAR FILTRO DE TURNO
    });

    // Obtener estudiantes sin asistencia desde la base de datos CON FILTRO DE TURNO
    fetch(`{{ route('attendance.get.unmarked') }}?${params}`, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            updateAbsentStudentsList(data.students);
        } else {
            throw new Error(data.message || 'Error al cargar estudiantes');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        tableBody.innerHTML = `
            <tr>
                <td colspan="6" class="text-center py-4 text-danger"> <!-- Cambiar colspan a 6 -->
                    <i class="bi bi-exclamation-triangle display-6"></i>
                    <p class="mt-2">Error al cargar estudiantes: ${error.message}</p>
                </td>
            </tr>
        `;
    });
}

// Función para confirmar y procesar las faltas automáticas
document.getElementById('confirmAutoAbsence').addEventListener('click', function() {
    processAutoAbsence();
});



// Función para actualizar la lista de estudiantes en el modal
function updateAbsentStudentsList(students) {
    const tableBody = document.getElementById('absentStudentsList');
    const totalCount = document.getElementById('totalAbsentStudents');

    if (students.length === 0) {
        tableBody.innerHTML = `
            <tr>
                <td colspan="6" class="text-center py-4 text-muted"> <!-- Cambiar colspan a 6 -->
                    <i class="bi bi-check-circle display-6 text-success"></i>
                    <p class="mt-2">¡Todos los estudiantes ya tienen asistencia registrada!</p>
                </td>
            </tr>
        `;
        totalCount.textContent = '0';
        
        // Deshabilitar el botón de confirmar si no hay estudiantes
        document.getElementById('confirmAutoAbsence').disabled = true;
        return;
    }

    // Habilitar el botón de confirmar
    document.getElementById('confirmAutoAbsence').disabled = false;

    // Actualizar contador
    totalCount.textContent = students.length;

    // Limpiar tabla
    tableBody.innerHTML = '';

    // Llenar tabla con estudiantes y mostrar el turno correcto
    students.forEach(student => {
        const shiftText = student.shift === 'morning' ? 'Mañana' : 'Tarde';
        const shiftClass = student.shift === 'morning' ? 'bg-info' : 'bg-warning';
        
        const row = document.createElement('tr');
        row.innerHTML = `
            <td class="fw-bold">${student.dni}</td>
            <td>${student.name}</td>
            <td>
                <span class="badge bg-primary">${student.grade}</span>
                <span class="badge bg-success">${student.section}</span>
            </td>
            <td>
                <span class="badge ${shiftClass}">${shiftText}</span>
            </td>
            <td>${student.parent_name || 'Apoderado'}</td>
            <td>
                ${student.parent_phone ? 
                    `<span class="text-success"><i class="bi bi-whatsapp me-1"></i>${student.parent_phone}</span>` : 
                    '<span class="text-muted">No registrado</span>'
                }
            </td>
        `;
        
        // Almacenar datos completos del estudiante
        row.dataset.studentDni = student.dni;
        row.dataset.studentName = student.name;
        row.dataset.parentPhone = student.parent_phone || '';
        
        tableBody.appendChild(row);
    });
}
// Función para procesar las faltas automáticas
// Función para procesar las faltas automáticas - CORREGIDA
function processAutoAbsence() {
    // Obtener los estudiantes del modal (no usar getFilteredStudents)
    const absentStudents = getStudentsFromModal();
    
    if (absentStudents.length === 0) {
        showTemporaryMessage('No hay estudiantes para marcar como faltas', 'warning');
        return;
    }

    const sendNotifications = document.getElementById('sendNotifications').checked;
    
    // Mostrar loading en el botón
    const confirmBtn = document.getElementById('confirmAutoAbsence');
    const originalText = confirmBtn.innerHTML;
    confirmBtn.innerHTML = '<i class="bi bi-arrow-repeat spinner-border spinner-border-sm me-1"></i> Procesando...';
    confirmBtn.disabled = true;

    let processedCount = 0;
    let notificationCount = 0;
    let errors = [];

    // Procesar CADA ESTUDIANTE DEL MODAL específicamente
    absentStudents.forEach(student => {
        // Marcar como falta en currentAttendance
        currentAttendance[student.dni] = {
            status: 'absent',
            notes: 'Falta automática - Sistema'
        };

        // Guardar en la base de datos
        saveSingleAttendance(student.dni)
            .then(() => {
                processedCount++;
                
                // Enviar notificación si está habilitado y tiene teléfono
                if (sendNotifications && student.parent_phone) {
                    sendAbsenceNotification(student, 'absent')
                        .then(() => {
                            notificationCount++;
                        })
                        .catch(error => {
                            errors.push(`Error notificación ${student.dni}: ${error.message}`);
                        });
                }

                // Si es el último estudiante, actualizar la interfaz
                if (processedCount === absentStudents.length) {
                    updateFinalInterface();
                }
            })
            .catch(error => {
                errors.push(`Error guardando ${student.dni}: ${error.message}`);
                processedCount++;
                
                if (processedCount === absentStudents.length) {
                    updateFinalInterface();
                }
            });
    });

    function updateFinalInterface() {
        // Actualizar tabla y estadísticas
        updateAttendanceTable();
        updateAttendanceStats();
        
        // Cerrar modal
        const autoAbsenceModal = bootstrap.Modal.getInstance(document.getElementById('autoAbsenceModal'));
        autoAbsenceModal.hide();
        
        // Restaurar botón
        confirmBtn.innerHTML = originalText;
        confirmBtn.disabled = false;

        // Mostrar resumen
        let message = `✅ Se marcaron ${processedCount} faltas automáticas`;
        if (sendNotifications) {
            message += ` y se enviaron ${notificationCount} notificaciones`;
        }
        if (errors.length > 0) {
            message += `. Errores: ${errors.length}`;
            console.error('Errores en faltas automáticas:', errors);
        }
        
        showTemporaryMessage(message, 'success');
        
        // Recargar el resumen desde la base de datos
        loadAttendanceSummaryFromDB();
    }
}

// Función para obtener los estudiantes del modal - NUEVA FUNCIÓN
function getStudentsFromModal() {
    const students = [];
    const tableRows = document.querySelectorAll('#absentStudentsList tr');
    
    tableRows.forEach(row => {
        // Obtener datos de cada fila de la tabla del modal
        const dni = row.querySelector('td:nth-child(1)')?.textContent.trim();
        const name = row.querySelector('td:nth-child(2)')?.textContent.trim();
        const parentPhone = row.querySelector('td:nth-child(5)')?.textContent.trim();
        
        if (dni && name) {
            // Buscar el estudiante completo en studentsData
            const fullStudent = studentsData.find(s => s.dni === dni);
            if (fullStudent) {
                students.push({
                    ...fullStudent,
                    parent_phone: parentPhone === 'No registrado' ? null : parentPhone
                });
            }
        }
    });
    
    return students;
}

// Función mejorada para mostrar resultado del escaneo
// Función mejorada para mostrar resultado del escaneo
function showScannerResult(student, statusInfo) {
    const resultDiv = document.getElementById('scannerResult');
    const studentName = document.getElementById('scannedStudentName');
    const studentInfo = document.getElementById('scannedStudentInfo');
    const statusBadge = document.getElementById('scannedStatus');
    const timeIndicator = document.getElementById('scannedTime');
    
    // Obtener el turno directamente del objeto estudiante
    const shift = student.shift || 'morning'; // Si no hay turno, por defecto será mañana
    const shiftText = shift === 'morning' ? 'Mañana' : 'Tarde';
    
    studentName.textContent = student.name;
    studentInfo.textContent = `DNI: ${student.dni} - ${student.grade} ${student.section} - Turno: ${shiftText}`;
    statusBadge.textContent = statusInfo.status === 'present' ? 'Presente' : 
                             statusInfo.status === 'late' ? 'Tardanza' : 'Falta';
    statusBadge.className = `badge-status bg-${getStatusColor(statusInfo.status)}`;
    timeIndicator.textContent = statusInfo.label;
    timeIndicator.className = `time-indicator ${statusInfo.timeClass}`;
    
    resultDiv.style.display = 'block';
    
    // Scroll suave al resultado
    resultDiv.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
}

// Modificar la función de inicialización para incluir el listener del lector físico
document.addEventListener('DOMContentLoaded', function() {
    initializeGradeSections();
    setupEventListeners();
    loadAttendanceForDate();
    loadAllStudents();
    setupBarcodeReaderListener(); // ← Agregar esta línea
    document.getElementById('barcodeInput').focus(); // Enfocar el input al cargar



    // Agregar event listener para recargar la página cuando se cierre el modal
    const confirmationModal = document.getElementById('confirmationModal');
    confirmationModal.addEventListener('hidden.bs.modal', function () {
        location.reload();
    });
    
    // También para el botón de cerrar
    const closeButton = confirmationModal.querySelector('.btn-secondary');
    closeButton.addEventListener('click', function() {
        setTimeout(() => {
            location.reload();
        }, 300);
    });
});


        // Datos reales de estudiantes desde Laravel
        const studentsData = @json($students);

        // Datos reales de grados y secciones desde Laravel
        const gradesData = @json($grades);

        // Estado de la aplicación
        let currentAttendance = {};
        let selectedGrade = "";
        let selectedSection = "";
        let selectedShift = ""; // ← NUEVA VARIABLE PARA TURNO
        let selectedDate = document.getElementById('attendanceDate')?.value || new Date().toISOString().split('T')[0];
        let scannerActive = false;
        let quaggaInitialized = false;

        // Inicializar la aplicación
        document.addEventListener('DOMContentLoaded', function() {
            initializeGradeSections();
            setupEventListeners();
            loadAttendanceForDate();
            loadAllStudents(); // Inicializar currentAttendance con todos los estudiantes
        });

        // Inicializar la cuadrícula de grados y secciones con datos reales
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
                            <div class="mt-2">
                                <span class="badge bg-primary">${studentsData.length} estudiantes</span>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            // Agregar grados y secciones reales, incluso si no hay estudiantes
            gradesData.forEach(grade => {
                grade.sections.forEach(section => {
                    const studentCount = studentsData.filter(student => 
                        student.grade_id == grade.id && student.section_id == section.id
                    ).length;
                    
                    gridContainer.innerHTML += `
                        <div class="col-xl-2 col-md-3 col-sm-4 col-6">
                            <div class="card grade-section-card" data-grade="${grade.id}" data-section="${section.id}">
                                <div class="card-body text-center py-4">
                                    <i class="bi bi-mortarboard-fill display-4 text-primary mb-3"></i>
                                    <h5 class="card-title">${grade.name}</h5>
                                    <p class="text-muted mb-0">Sección ${section.name}</p>
                                    <div class="mt-2">
                                        <span class="badge bg-primary">${studentCount} estudiantes</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                });
            });
            
            // Agregar event listeners a las tarjetas
            document.querySelectorAll('.grade-section-card').forEach(card => {
                // En initializeGradeSections(), modifica el event listener de las tarjetas:
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
                    
                    // ACTUALIZAR EL RESUMEN FILTRADO
                    loadFilteredAttendanceSummaryFromDB();
                    
                    // Desplazar a la tabla
                    document.getElementById('attendanceTable').scrollIntoView({behavior: 'smooth'});
                });
            });

             // Inicializar el buscador
            setTimeout(() => {
                performSearch();
            }, 100);
        }

        // Configurar event listeners
        function setupEventListeners() {
            // Listener para cambio de fecha
            document.getElementById('attendanceDate').addEventListener('change', function() {
                selectedDate = this.value;
                loadAttendanceForDate();
            });
            document.getElementById('markAllAbsent').addEventListener('click', function() {
                showAutoAbsenceModal();
            });
                // LISTENER PARA CAMBIO DE TURNO
            document.getElementById('shiftFilter').addEventListener('change', function() {
                selectedShift = this.value;
            });

            // Event listener para cuando se cierra el modal (con el botón Cancelar o la X)
    document.getElementById('autoAbsenceModal').addEventListener('hidden.bs.modal', function () {
        // Pequeño delay para que se cierre completamente el modal antes de recargar
        setTimeout(() => {
            location.reload();
        }, 300);
    });
    
    // También para el botón Cancelar específicamente
    document.querySelector('#autoAbsenceModal .btn-secondary').addEventListener('click', function() {
        setTimeout(() => {
            location.reload();
        }, 300);
    });

            // Listener para cambiar el grado y actualizar secciones
            document.getElementById('gradeFilter').addEventListener('change', function() {
                const selectedGradeId = this.value;
                const sectionFilter = document.getElementById('sectionFilter');
                
                // Limpiar opciones de sección
                sectionFilter.innerHTML = '<option value="">Todas las secciones</option>';
                
                if (selectedGradeId === "") {
                    sectionFilter.disabled = true;
                } else {
                    sectionFilter.disabled = false;
                    const selectedGrade = gradesData.find(g => g.id == selectedGradeId);
                    if (selectedGrade) {
                        selectedGrade.sections.forEach(section => {
                            sectionFilter.innerHTML += `<option value="${section.id}">${section.name}</option>`;
                        });
                    }
                }
            });
            setupSearchListeners();
            
            // Botón para aplicar filtros
// En la función setupEventListeners(), modifica el listener del botón aplicar filtros:
    document.getElementById('applyFilters').addEventListener('click', function() {
        const gradeFilter = document.getElementById('gradeFilter').value;
        const sectionFilter = document.getElementById('sectionFilter').value;
        const shiftFilter = document.getElementById('shiftFilter').value;
    
    // Actualizar selección global
    selectedGrade = gradeFilter;
    selectedSection = sectionFilter;
    selectedShift = shiftFilter; // ← AGREGAR TURNO
    
    // Encontrar y activar la tarjeta correspondiente
    let targetCard = null;
    
     if (gradeFilter === "" && sectionFilter === "" && shiftFilter === "") {
            targetCard = document.querySelector('.grade-section-card[data-grade=""][data-section=""]');
        } else if (shiftFilter === "") {
            // Solo activar tarjeta si no hay filtro de turno
            targetCard = document.querySelector(`.grade-section-card[data-grade="${gradeFilter}"][data-section="${sectionFilter}"]`);
        }
    
    if (targetCard) {
        // Simular clic en la tarjeta
        targetCard.click();
    } else {
        // Si no hay tarjeta, actualizar directamente la tabla
        updateAttendanceTable();
        updateAttendanceTitle();
    }

    // ACTUALIZAR EL RESUMEN FILTRADO
    loadFilteredAttendanceSummaryFromDB();
    
    // Desplazar a la tabla
    document.getElementById('attendanceTable').scrollIntoView({behavior: 'smooth'});
});

// Agregar event listener para limpiar filtros
document.getElementById('clearFilters').addEventListener('click', function() {
    // Limpiar filtros
    document.getElementById('gradeFilter').value = '';
    document.getElementById('sectionFilter').value = '';
    document.getElementById('sectionFilter').disabled = true;
    document.getElementById('shiftFilter').value = '';
    
    // Resetear variables
    selectedGrade = "";
    selectedSection = "";
    selectedShift = "";
    
    // Activar la tarjeta "Todos"
    document.querySelectorAll('.grade-section-card').forEach(c => {
        c.classList.remove('active');
    });
    document.querySelector('.grade-section-card[data-grade=""][data-section=""]').classList.add('active');
    
    // Actualizar la tabla
    updateAttendanceTable();
    updateAttendanceTitle();
    loadAttendanceSummaryFromDB();
});
            
            // Botón para marcar todos como presentes
// Botón para marcar todos como presentes - MODIFICADO
document.getElementById('selectAllPresent').addEventListener('click', function() {
    const filteredStudents = getFilteredStudents();
    
    filteredStudents.forEach(student => {
        // Solo marcar como presente si actualmente está "sin marcar"
        // o si el usuario quiere sobrescribir todos los estados
        currentAttendance[student.dni] = { 
            status: 'present', 
            notes: currentAttendance[student.dni]?.notes || '' 
        };
    });
    
    updateAttendanceTable();
    updateAttendanceStats();
});
            
            // Botón para reiniciar asistencia
// Botón para reiniciar asistencia - MODIFICADO
document.getElementById('resetAttendance').addEventListener('click', function() {
    if (confirm('¿Está seguro de que desea reiniciar la asistencia? Se perderán todos los cambios no guardados.')) {
        const filteredStudents = getFilteredStudents();
        
        filteredStudents.forEach(student => {
            // Reiniciar a "sin marcar" en lugar de "presente"
            currentAttendance[student.dni] = { status: 'none', notes: '' };
        });
        
        updateAttendanceTable();
        updateAttendanceStats();
    }
});
            
            // Botón para guardar asistencia manual
            document.getElementById('saveAttendance').addEventListener('click', function() {
                saveAttendanceData();
            });
            
            // Escáner de código de barras
            document.getElementById('startScanner').addEventListener('click', function() {
                startBarcodeScanner();
            });
            
            document.getElementById('stopScanner').addEventListener('click', function() {
                stopBarcodeScanner();
            });
            
            // Entrada manual de código de barras
document.getElementById('barcodeInput').addEventListener('keydown', function(e) {
    // Solo procesar si es la tecla Enter
    if (e.key === 'Enter') {
        e.preventDefault(); // Prevenir comportamiento por defecto
        
        const barcode = this.value.trim();
        if (barcode) {
            console.log('⌨️ Enter presionado con código:', barcode);
            processBarcodeManual(barcode);
            this.value = ''; // Limpiar el input
        }
    }
});
        }

        // Función para determinar el estado según la hora
        // Función para determinar el estado según la hora y el turno
// Función para determinar el estado según la hora y el turno - CORREGIDA
// Función para determinar el estado según la hora y el turno - COMPLETAMENTE CORREGIDA
function getAttendanceStatusByTime(studentShift = null) {
    const now = new Date();
    const currentTime = now.getHours() * 60 + now.getMinutes();
    
    // Usar el turno del estudiante si se proporciona, de lo contrario usar el filtro seleccionado
    const shift = studentShift || selectedShift || 'morning';
    
    console.log('🔍 Calculando estado para:', {
        estudiante: studentShift || 'No especificado',
        filtro: selectedShift || 'No especificado',
        turnoUsado: shift,
        horaActual: now.getHours() + ':' + now.getMinutes().toString().padStart(2, '0'),
        minutos: currentTime
    });
    
    // DEFINIR LÍMITES CLARAMENTE - CORREGIDOS
    let startTime, lateLimit, absentLimit;
    
    if (shift === 'morning') {
        // Turno mañana: 7:00 AM - 8:00 AM
        startTime = 7 * 60;        // 7:00 AM (420 minutos)
        lateLimit = 7 * 60 + 30;   // 7:30 AM (450 minutos)  
        absentLimit = 8 * 60;      // 8:00 AM (480 minutos)
    } else {
        // Turno tarde: 1:00 PM - 2:00 PM  
        startTime = 13 * 60;       // 1:00 PM (780 minutos)
        lateLimit = 13 * 60 + 30;  // 1:30 PM (810 minutos)
        absentLimit = 14 * 60;     // 2:00 PM (840 minutos)
    }
    
    console.log('📊 Límites para turno', shift + ':');
    console.log('  - Inicio:', Math.floor(startTime/60) + ':' + (startTime%60).toString().padStart(2, '0'));
    console.log('  - Tardanza:', Math.floor(lateLimit/60) + ':' + (lateLimit%60).toString().padStart(2, '0'));
    console.log('  - Falta:', Math.floor(absentLimit/60) + ':' + (absentLimit%60).toString().padStart(2, '0'));
    
    // Determinar estado según la hora actual
    let status, timeClass, label;
    
    if (currentTime < startTime) {
        status = 'present';
        timeClass = 'time-ok';
        label = 'A tiempo (antes del inicio)';
    } else if (currentTime < lateLimit) {
        status = 'present';
        timeClass = 'time-ok';
        label = 'A tiempo';
    } else if (currentTime < absentLimit) {
        status = 'late';
        timeClass = 'time-late';
        label = shift === 'morning' ? 'Tardanza (después de 7:30 AM)' : 'Tardanza (después de 1:30 PM)';
    } else {
        status = 'absent';
        timeClass = 'time-absent';
        label = shift === 'morning' ? 'Falta (después de 8:00 AM)' : 'Falta (después de 2:00 PM)';
    }
    
    console.log('✅ Estado final:', { status, label });
    
    return { 
        status, 
        timeClass, 
        label,
        shift: shift
    };
}
        // Función para procesar código de barras y guardar automáticamente
// Función para procesar código de barras y guardar automáticamente
// Función para procesar código de barras y guardar automáticamente - CORREGIDA
// Función para procesar código de barras y guardar automáticamente - COMPLETAMENTE CORREGIDA
function getAttendanceStatusByTime(studentShift = null) {
    const now = new Date();
    const currentTime = now.getHours() * 60 + now.getMinutes();
    
    // SOLO usar el turno del estudiante, ignorar cualquier filtro
    const shift = studentShift || 'morning';
    
    console.log('✅ FUNCIÓN CORREGIDA - Calculando estado para turno:', shift);
    
    // LÍMITES CLAROS Y SIMPLES
    const limits = {
        morning: { start: 420, late: 450, absent: 480 },    // 7:00, 7:30, 8:00
        afternoon: { start: 780, late: 810, absent: 840 }   // 13:00, 13:30, 14:00
    };
    
    const limit = limits[shift];
    
    // LÓGICA SIMPLE Y DIRECTA - SIN VERIFICACIONES EXTRA
    let status, label;
    
    if (currentTime < limit.start) {
        status = 'present';
        label = 'A tiempo (antes del inicio)';
    } else if (currentTime < limit.late) {
        status = 'present';
        label = 'A tiempo';
    } else if (currentTime < limit.absent) {
        status = 'late';
        label = shift === 'morning' ? 'Tardanza (después de 7:30 AM)' : 'Tardanza (después de 1:30 PM)';
    } else {
        status = 'absent';
        label = shift === 'morning' ? 'Falta (después de 8:00 AM)' : 'Falta (después de 2:00 PM)';
    }
    
    console.log('🎯 Estado calculado:', { status, label, hora: now.getHours() + ':' + now.getMinutes() });
    
    return {
        status: status,
        timeClass: status === 'present' ? 'time-ok' : status === 'late' ? 'time-late' : 'time-absent',
        label: label,
        shift: shift
    };
}

// FUNCIÓN TEST CORREGIDA - que SI usa la hora de prueba
function testShiftLogicCorrected(dni, horaPrueba = null) {
    const student = studentsData.find(s => s.dni === dni);
    if (!student) {
        console.log('❌ Estudiante no encontrado');
        return;
    }
    
    console.log('🧪 TEST CORREGIDO - Hora de prueba:', horaPrueba || 'Hora actual');
    
    if (horaPrueba) {
        // Crear una fecha con la hora de prueba
        const [horas, minutos] = horaPrueba.split(':').map(Number);
        const fechaPrueba = new Date();
        fechaPrueba.setHours(horas, minutos, 0, 0);
        
        console.log('⏰ Usando hora de prueba:', fechaPrueba.getHours() + ':' + fechaPrueba.getMinutes());
        
        // Guardar la función original
        const originalDate = Date;
        
        // Sobrescribir temporalmente Date para usar la hora de prueba
        globalThis.Date = class extends Date {
            constructor() {
                super();
                return fechaPrueba;
            }
            
            static now() {
                return fechaPrueba.getTime();
            }
        };
        
        // Ejecutar la función con la hora de prueba
        const result = getAttendanceStatusByTime(student.shift);
        
        // Restaurar Date original
        globalThis.Date = originalDate;
        
        console.log('✅ RESULTADO CON HORA DE PRUEBA:', result);
        return result;
    } else {
        // Usar hora actual
        const result = getAttendanceStatusByTime(student.shift);
        console.log('✅ RESULTADO CON HORA ACTUAL:', result);
        return result;
    }
}
// Ejemplo de uso en consola:
// testShiftLogic('12345678', '13:25') // Probar a las 1:25 PM
// testShiftLogic('12345678', '13:35') // Probar a las 1:35 PM  
// testShiftLogic('12345678', '14:05') // Probar a las 2:05 PM

// Función para obtener estado de asistencia (modificada)
// Función para determinar el estado según la hora y el turno - VERSIÓN DEFINITIVAMENTE CORREGIDA
function getAttendanceStatusByTime(studentShift = null) {
    const now = new Date();
    const currentTime = now.getHours() * 60 + now.getMinutes();
    
    // SOLO usar el turno del estudiante, ignorar cualquier filtro
    const shift = studentShift || 'morning';
    
    // LÍMITES CLAROS Y SIMPLES
    const limits = {
        morning: { start: 420, late: 450, absent: 480 },    // 7:00, 7:30, 8:00
        afternoon: { start: 780, late: 810, absent: 840 }   // 13:00, 13:30, 14:00
    };
    
    const limit = limits[shift];
    
    // LÓGICA SIMPLE Y DIRECTA
    let status, label;
    
    if (currentTime < limit.start) {
        status = 'present';
        label = 'A tiempo (antes del inicio)';
    } else if (currentTime < limit.late) {
        status = 'present';
        label = 'A tiempo';
    } else if (currentTime < limit.absent) {
        status = 'late';
        label = shift === 'morning' ? 'Tardanza (después de 7:30 AM)' : 'Tardanza (después de 1:30 PM)';
    } else {
        status = 'absent';
        label = shift === 'morning' ? 'Falta (después de 8:00 AM)' : 'Falta (después de 2:00 PM)';
    }
    
    return {
        status: status,
        timeClass: status === 'present' ? 'time-ok' : status === 'late' ? 'time-late' : 'time-absent',
        label: label,
        shift: shift
    };
}

// Ejecutar verificación al cargar la página
document.addEventListener('DOMContentLoaded', function() {
    initializeGradeSections();
    setupEventListeners();
    loadAttendanceForDate();
    loadAllStudents();
    setupBarcodeReaderListener();
    document.getElementById('barcodeInput').focus();
    showBarcodeReaderStatus();
    
    // Verificar notificaciones automáticas
    setTimeout(checkAndSendAutomaticNotifications, 2000);
});

// También verificar cada 5 minutos por si la página permanece abierta
setInterval(checkAndSendAutomaticNotifications, 5 * 60 * 1000);





        // Agregar CSS para los mensajes temporales (añadir al estilo existente)
const additionalStyles = `
.alert-temporary {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 1050;
    min-width: 300px;
}
`;

// Inyectar los estilos adicionales
const styleSheet = document.createElement("style");
styleSheet.type = "text/css";
styleSheet.innerText = additionalStyles;
document.head.appendChild(styleSheet);

        // Función para guardar la asistencia de un solo estudiante (automático para escáner)
       // Función para guardar la asistencia de un solo estudiante (automático para escáner)
function saveSingleAttendance(studentDni) {
    return new Promise((resolve, reject) => {
        const student = studentsData.find(s => s.dni === studentDni);
        if (!student) {
            reject(new Error('Estudiante no encontrado'));
            return;
        }

        const attendance = currentAttendance[studentDni];
        if (!attendance) {
            reject(new Error('No hay datos de asistencia'));
            return;
        }

        const attendanceData = {
            date: selectedDate,
            student_dni: studentDni,
            status: attendance.status,
            notes: attendance.notes || '',
            _token: '{{ csrf_token() }}'
        };

        fetch('{{ route("attendance.store.single") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify(attendanceData)
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => {
                    throw new Error(err.message || 'Error en la respuesta del servidor');
                });
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                resolve(data);
            } else {
                throw new Error(data.message || 'Error desconocido del servidor');
            }
        })
        .catch(error => {
            reject(error);
        });
    });
}

// Función auxiliar para mostrar éxito en el escáner
function showScannerSuccess(studentName) {
    const resultDiv = document.getElementById('scannerResult');
    if (resultDiv) {
        const successIndicator = document.createElement('div');
        successIndicator.className = 'mt-2';
        successIndicator.innerHTML = `
            <small class="text-success">
                <i class="bi bi-check-circle-fill me-1"></i> Asistencia de ${studentName} guardada automáticamente
            </small>
        `;
        // Si ya existe un indicador, reemplazarlo
        const existingIndicator = resultDiv.querySelector('.text-success, .text-danger');
        if (existingIndicator) {
            existingIndicator.parentElement.remove();
        }
        resultDiv.appendChild(successIndicator);
    }
}

        // Función para enviar notificación de falta por WhatsApp
// Modificar sendAbsenceNotification para que incluya el turno
function sendAbsenceNotification(student, status = 'absent', shift = null) {
    return new Promise((resolve, reject) => {
        const currentTime = new Date().toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit' });
        const studentShift = shift || student.shift || 'morning';
        
        const notificationData = {
            student_dni: student.dni,
            date: selectedDate,
            time: currentTime,
            status: status,
            shift: studentShift, // ← AGREGAR TURNO
            _token: '{{ csrf_token() }}'
        };

        fetch('{{ route("attendance.send.whatsapp") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify(notificationData)
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => {
                    throw new Error(err.message || 'Error en la respuesta del servidor');
                });
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                resolve(data);
            } else {
                throw new Error(data.message || 'Error desconocido al enviar notificación');
            }
        })
        .catch(error => {
            reject(error);
        });
    });
}

// Función mejorada para mostrar el modal de notificación
function showNotificationModal(student, status, currentTime, apiData = null, error = null) {
    const parentName = student.parent_name || 'Apoderado';
    const parentPhone = student.parent_phone || 'No registrado';
    
    // Crear mensaje según el estado
    let message = '';
    if (status === 'absent') {
        message = `Hola ${parentName}, le informamos que ${student.name} no ha registrado asistencia hoy ${selectedDate} a las ${currentTime}. Se ha marcado como FALTA. Por favor, contacte con la institución si hay alguna justificación.`;
    } else {
        message = `Hola ${parentName}, le informamos que ${student.name} ha registrado una tardanza hoy ${selectedDate} a las ${currentTime}. Le recordamos la importancia de la puntualidad.`;
    }
    
    // Actualizar el modal
    document.getElementById('notifiedStudentName').textContent = student.name;
    document.getElementById('notifiedParentName').textContent = parentName;
    document.getElementById('notifiedParentPhone').textContent = parentPhone;
    document.getElementById('notificationMessage').textContent = message;
    
    // Crear enlace de WhatsApp directo
    const whatsappLink = document.getElementById('whatsappLink');
    if (parentPhone && parentPhone !== 'No registrado') {
        const encodedMessage = encodeURIComponent(message);
        whatsappLink.href = `https://wa.me/${parentPhone}?text=${encodedMessage}`;
        whatsappLink.classList.remove('disabled');
    } else {
        whatsappLink.href = '#';
        whatsappLink.classList.add('disabled');
    }
    
    // Mostrar estado del envío automático
    const modalBody = document.querySelector('#absenceNotificationModal .modal-body');
    const statusAlert = document.createElement('div');
    
    if (error) {
        statusAlert.className = 'alert alert-warning';
        statusAlert.innerHTML = `
            <i class="bi bi-exclamation-triangle me-2"></i>
            <strong>Error en envío automático:</strong> ${error}
            <br><small>Puede enviar el mensaje manualmente usando el botón de WhatsApp.</small>
        `;
    } else if (apiData) {
        statusAlert.className = 'alert alert-success';
        statusAlert.innerHTML = `
            <i class="bi bi-check-circle me-2"></i>
            <strong>Notificación enviada exitosamente</strong>
            <br><small>El mensaje se ha enviado automáticamente al apoderado.</small>
        `;
    } else {
        statusAlert.className = 'alert alert-info';
        statusAlert.innerHTML = `
            <i class="bi bi-info-circle me-2"></i>
            <strong>Notificación lista para enviar</strong>
            <br><small>Use el botón de WhatsApp para enviar manualmente.</small>
        `;
    }
    
    // Insertar el alert al principio del modal body
    const existingAlert = modalBody.querySelector('.alert');
    if (existingAlert) {
        existingAlert.remove();
    }
    modalBody.insertBefore(statusAlert, modalBody.firstChild);
    
    // Mostrar el modal
    const notificationModal = new bootstrap.Modal(document.getElementById('absenceNotificationModal'));
    notificationModal.show();
}

// Función para actualizar el indicador de estado de la cámara
function updateCameraStatus(status) {
    const statusElement = document.getElementById('cameraStatus');
    if (statusElement) {
        if (status === 'active') {
            statusElement.innerHTML = '<i class="bi bi-camera-video-fill me-1"></i> Cámara: Activa';
            statusElement.style.background = 'rgba(34, 197, 94, 0.8)';
        } else {
            statusElement.innerHTML = '<i class="bi bi-camera-video-off me-1"></i> Cámara: Inactiva';
            statusElement.style.background = 'rgba(239, 68, 68, 0.8)';
        }
    }
}
        // Inicializar y activar el escáner de código de barras
function startBarcodeScanner() {
    const video = document.getElementById('scannerVideo');
    const overlay = document.getElementById('scannerOverlay');
    
    // Verificar si el navegador soporta getUserMedia
    if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
        console.error('getUserMedia no es soportado por este navegador');
        overlay.style.display = 'flex';
        return;
    }
    
    // Primero probar con la cámara trasera (environment)
    const constraints = {
        video: {
            width: { ideal: 640 },
            height: { ideal: 480 },
            facingMode: 'environment' // Cámara trasera
        }
    };
    
    // Intentar acceder a la cámara directamente primero para verificar permisos
    navigator.mediaDevices.getUserMedia(constraints)
        .then(function(stream) {
            // Si tenemos acceso a la cámara, inicializar Quagga
            video.srcObject = stream;
            video.play();
            
            // Configurar Quagga.js para escanear códigos de barras
            Quagga.init({
                inputStream: {
                    name: "Live",
                    type: "LiveStream",
                    target: video,
                    constraints: constraints
                },
                decoder: {
                    readers: ["code_128_reader", "ean_reader", "upc_reader", "code_39_reader"]
                },
                locator: {
                    patchSize: "medium",
                    halfSample: true
                },
                locate: true,
                numOfWorkers: 2
            }, function(err) {
                if (err) {
                    console.error("Error al inicializar Quagga:", err);
                    // Intentar con configuración alternativa
                    initializeQuaggaWithFallback();
                    return;
                }
                
                console.log("Quagga inicializado correctamente");
                Quagga.start();
                quaggaInitialized = true;
                scannerActive = true;
                
                // Actualizar botones
                document.getElementById('startScanner').disabled = true;
                document.getElementById('stopScanner').disabled = false;
                
                // Escuchar resultados del escáner
                Quagga.onDetected(function(result) {
                    if (scannerActive && result.codeResult && result.codeResult.code) {
                        const barcode = result.codeResult.code;
                        console.log("Código detectado:", barcode);
                        processBarcode(barcode);
                        
                        // Detener temporalmente el escáner para evitar múltiples lecturas
                        Quagga.stop();
                        setTimeout(() => {
                            if (scannerActive) {
                                Quagga.start();
                            }
                        }, 2000);
                    }
                });
            });
        })
        .catch(function(error) {
            console.error('Error al acceder a la cámara:', error);
            
            // Intentar con cámara frontal si la trasera falla
            const frontCameraConstraints = {
                video: {
                    width: { ideal: 640 },
                    height: { ideal: 480 },
                    facingMode: 'user' // Cámara frontal
                }
            };
            updateCameraStatus('active');
            navigator.mediaDevices.getUserMedia(frontCameraConstraints)
                .then(function(stream) {
                    video.srcObject = stream;
                    video.play();
                    initializeQuaggaWithFallback(frontCameraConstraints);
                })
                .catch(function(fallbackError) {
                    console.error('Error con cámara frontal:', fallbackError);
                    overlay.style.display = 'flex';
                    overlay.innerHTML = `
                        <div class="text-center">
                            <i class="bi bi-camera-video-off display-4 mb-2"></i>
                            <p>No se pudo acceder a la cámara</p>
                            <small class="d-block">Error: ${fallbackError.message}</small>
                            <button class="btn btn-sm btn-primary mt-2" onclick="startBarcodeScanner()">
                                Reintentar
                            </button>
                        </div>
                    `;
                });
        });
         // Función auxiliar para inicializar Quagga con configuración de respaldo
    function initializeQuaggaWithFallback(constraints = null) {
        const quaggaConfig = {
            inputStream: {
                name: "Live",
                type: "LiveStream",
                target: video
            },
            decoder: {
                readers: ["code_128_reader", "ean_reader", "upc_reader", "code_39_reader"]
            },
            locator: {
                patchSize: "medium",
                halfSample: true
            },
            locate: true,
            numOfWorkers: 1
        };

        // Agregar constraints si se proporcionan
        if (constraints) {
            quaggaConfig.inputStream.constraints = constraints;
        }

        Quagga.init(quaggaConfig, function(err) {
            if (err) {
                console.error("Error al inicializar Quagga (fallback):", err);
                overlay.style.display = 'flex';
                overlay.innerHTML = `
                    <div class="text-center">
                        <i class="bi bi-exclamation-triangle display-4 mb-2"></i>
                        <p>Error al inicializar el escáner</p>
                        <small class="d-block">${err.message}</small>
                    </div>
                `;
                return;
            }
            
            console.log("Quagga inicializado con configuración de respaldo");
            Quagga.start();
            quaggaInitialized = true;
            scannerActive = true;
            
            document.getElementById('startScanner').disabled = true;
            document.getElementById('stopScanner').disabled = false;
            
            Quagga.onDetected(function(result) {
                if (scannerActive && result.codeResult && result.codeResult.code) {
                    const barcode = result.codeResult.code;
                    console.log("Código detectado (fallback):", barcode);
                    processBarcode(barcode);
                    
                    Quagga.stop();
                    setTimeout(() => {
                        if (scannerActive) {
                            Quagga.start();
                        }
                    }, 2000);
                }
            });
        });
    }
}
        // Detener el escáner de código de barras
// Función mejorada para detener el escáner
function stopBarcodeScanner() {
    if (quaggaInitialized) {
        Quagga.stop();
        scannerActive = false;
        quaggaInitialized = false;
    }
    
    // Detener la transmisión de video
    const video = document.getElementById('scannerVideo');
    if (video.srcObject) {
        const tracks = video.srcObject.getTracks();
        tracks.forEach(track => track.stop());
        video.srcObject = null;
    }
    updateCameraStatus('inactive');
    // Actualizar botones
    document.getElementById('startScanner').disabled = false;
    document.getElementById('stopScanner').disabled = true;
    
    // Ocultar overlay si estaba visible
    document.getElementById('scannerOverlay').style.display = 'none';
}

        // Función para cargar asistencia por fecha
       // Función para cargar asistencia por fecha - MODIFICADA
// Función para cargar asistencia por fecha - MODIFICADA
function loadAttendanceForDate() {
    fetch(`{{ route('attendance.load') }}?date=${selectedDate}`, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        // Inicializar currentAttendance como objeto vacío
        currentAttendance = {};
        
        // Primero, establecer TODOS los estudiantes como "none" (sin marcar)
        studentsData.forEach(student => {
            currentAttendance[student.dni] = {
                status: 'none',
                notes: ''
            };
        });
        
        // Luego, actualizar con los datos de la base de datos
        if (data.attendances) {
            data.attendances.forEach(att => {
                if (currentAttendance[att.student_dni]) {
                    currentAttendance[att.student_dni] = {
                        status: att.status,
                        notes: att.notes || ''
                    };
                }
            });
        }
        
        updateAttendanceTable();
        updateAttendanceStats();
        updateAttendanceTitle();
        
        // CARGAR EL RESUMEN DESDE LA BASE DE DATOS
        loadAttendanceSummaryFromDB();
    })
    .catch(error => {
        console.error('Error al cargar asistencia:', error);
        // En caso de error, inicializar todos como "sin marcar"
        currentAttendance = {};
        studentsData.forEach(student => {
            currentAttendance[student.dni] = { status: 'none', notes: '' };
        });
        updateAttendanceTable();
        updateAttendanceStats();
        
        // También cargar resumen en caso de error
        loadAttendanceSummaryFromDB();
    });
}

   // Reemplazar la función saveAttendanceData
// Función para guardar la asistencia manual - MEJORADA
// Función para guardar la asistencia manual - ACTUALIZADA
function saveAttendanceData() {
    // Filtrar solo los estudiantes que han sido modificados (que tienen estado diferente a 'none')
    const attendanceToSave = {};
    let hasChanges = false;
    
    // Verificar si hay cambios reales (excluyendo 'none')
    studentsData.forEach(student => {
        const currentStatus = currentAttendance[student.dni];
        if (currentStatus && currentStatus.status && currentStatus.status !== 'none') {
            attendanceToSave[student.dni] = currentStatus;
            hasChanges = true;
        }
    });

    if (!hasChanges) {
        alert('No hay cambios para guardar. Modifique la asistencia de al menos un estudiante.');
        return;
    }

    const attendanceData = {
        date: selectedDate,
        attendance: attendanceToSave,
        _token: '{{ csrf_token() }}'
    };
    
    console.log('Enviando datos a guardar:', attendanceData);
    
    // Mostrar indicador de carga
    const saveButton = document.getElementById('saveAttendance');
    const originalText = saveButton.innerHTML;
    saveButton.innerHTML = '<i class="bi bi-arrow-repeat spinner-border spinner-border-sm me-2"></i> Guardando...';
    saveButton.disabled = true;
    
    fetch('{{ route("attendance.store") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify(attendanceData)
    })
    .then(response => {
        if (!response.ok) {
            return response.json().then(err => {
                throw new Error(err.message || 'Error en la respuesta del servidor');
            });
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            const confirmationModal = new bootstrap.Modal(document.getElementById('confirmationModal'));
            confirmationModal.show();
            
            // ACTUALIZAR EL RESUMEN DESPUÉS DE GUARDAR - NUEVA LÍNEA AGREGADA
            loadAttendanceSummaryFromDB();
            
            // Mostrar mensaje de éxito específico para justificaciones
            const justifiedCount = Object.values(attendanceToSave).filter(att => att.status === 'justified').length;
            if (justifiedCount > 0) {
                console.log(`Justificaciones guardadas: ${justifiedCount}`);
            }
            
            // Recargar la asistencia después de guardar
            setTimeout(() => {
                loadAttendanceForDate();
            }, 1000);
        } else {
            throw new Error(data.message || 'Error desconocido del servidor');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al guardar la asistencia: ' + error.message);
    })
    .finally(() => {
        // Restaurar el botón
        saveButton.innerHTML = originalText;
        saveButton.disabled = false;
    });
}


// Función específica para manejar justificaciones
function processJustification(studentDni, notes = '') {
    if (!currentAttendance[studentDni]) {
        currentAttendance[studentDni] = { status: 'justified', notes: notes };
    } else {
        currentAttendance[studentDni].status = 'justified';
        currentAttendance[studentDni].notes = notes;
    }
    
    updateStudentRow(studentDni);
    updateAttendanceStats();
    
    // Guardar automáticamente la justificación
    saveSingleAttendance(studentDni);
    
    // Mostrar confirmación
    const student = studentsData.find(s => s.dni === studentDni);
    if (student) {
        showTemporaryMessage(`Justificación registrada para ${student.name}`, 'success');
    }
}

        // Función para inicializar currentAttendance
// Modificar la función loadAllStudents para usar estado "none" por defecto
function loadAllStudents() {
    studentsData.forEach(student => {
        if (!currentAttendance[student.dni]) {
            currentAttendance[student.dni] = {
                status: 'none', // Cambiado de 'present' a 'none'
                notes: ''
            };
        }
    });
    updateAttendanceTable();
    updateAttendanceStats();
}   

        // Obtener estudiantes filtrados según selección actual
// Obtener estudiantes filtrados según selección actual - MODIFICADA CON TURNO
function getFilteredStudents() {
    let filtered = studentsData;
    
    if (selectedGrade !== "") {
        filtered = filtered.filter(student => student.grade_id == selectedGrade);
    }
    
    if (selectedSection !== "") {
        filtered = filtered.filter(student => student.section_id == selectedSection);
    }
    
    // FILTRAR POR TURNO SI ESTÁ SELECCIONADO
    if (selectedShift !== "") {
        filtered = filtered.filter(student => student.shift === selectedShift);
    }
    
    return filtered;
}

        // Actualizar la tabla de asistencia
// Modificar la función updateAttendanceTable para mostrar estado "Sin marcar"
// Actualizar la tabla de asistencia - CORREGIDA CON COLUMNA DE TURNO
function updateAttendanceTable() {
    const tableBody = document.getElementById('attendanceTableBody');
    const filteredStudents = getFilteredStudents();
    
    tableBody.innerHTML = '';
    
    if (filteredStudents.length === 0) {
        tableBody.innerHTML = `
            <tr>
                <td colspan="5" class="text-center py-4 text-muted">
                    <i class="bi bi-people display-4 d-block mb-2"></i>
                    No hay estudiantes para mostrar
                </td>
            </tr>
        `;
        return;
    }
    
    filteredStudents.forEach(student => {
        const attendance = currentAttendance[student.dni] || { status: 'none', notes: '' };
        
        // Determinar el texto y clase para el turno
        const shiftText = student.shift === 'morning' ? 'Mañana' : 'Tarde';
        const shiftClass = student.shift === 'morning' ? 'bg-info' : 'bg-warning';
        
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
                <span class="badge bg-primary bg-opacity-10 text-primary">${student.grade}</span>
                <span class="badge bg-success bg-opacity-10 text-success">${student.section}</span>
            </td>
            <td>
                <span class="badge ${shiftClass}">${shiftText}</span>
            </td>
            <td class="text-center">
                <div class="btn-group btn-group-sm" role="group">
                    <button type="button" class="btn ${attendance.status === 'present' ? 'btn-success' : 'btn-outline-success'} attendance-btn" data-student="${student.dni}" data-status="present" style="${attendance.status === 'present' ? 'background-color:#06d6a0;border-color:#06d6a0;color:#ffffff;' : ''}">
                        <i class="bi bi-check-lg me-1"></i> Presente
                    </button>
                    <button type="button" class="btn ${attendance.status === 'late' ? 'btn-warning' : 'btn-outline-warning'} attendance-btn" data-student="${student.dni}" data-status="late" style="${attendance.status === 'late' ? 'background-color:#ffd166;border-color:#ffd166;color:#000000;' : ''}">
                        <i class="bi bi-clock me-1"></i> Tardanza
                    </button>
                    <button type="button" class="btn ${attendance.status === 'absent' ? 'btn-danger' : 'btn-outline-danger'} attendance-btn" data-student="${student.dni}" data-status="absent" style="${attendance.status === 'absent' ? 'background-color:#ef476f;border-color:#ef476f;color:#ffffff;' : ''}">
                        <i class="bi bi-x-lg me-1"></i> Falta
                    </button>
                    <button type="button" class="btn ${attendance.status === 'justified' ? 'btn-info' : 'btn-outline-info'} attendance-btn" data-student="${student.dni}" data-status="justified" style="${attendance.status === 'justified' ? 'background-color:#06b6d4;border-color:#06b6d4;color:#ffffff;' : ''}">
                        <i class="bi bi-file-text me-1"></i> Justificado
                    </button>
                    <button type="button" class="btn ${attendance.status === 'none' ? 'btn-secondary' : 'btn-outline-secondary'} attendance-btn" data-student="${student.dni}" data-status="none" style="${attendance.status === 'none' ? 'background-color:#6b7280;border-color:#6b7280;color:#ffffff;' : ''}">
                        <i class="bi bi-dash-lg me-1"></i> Sin marcar
                    </button>
                </div>
            </td>
            <td class="pe-4">
                <input type="text" class="form-control form-control-sm notes-input" placeholder="Observaciones..." data-student="${student.dni}" value="${attendance.notes}">
            </td>
        `;
        
        tableBody.appendChild(row);
    });
    
    // Agregar event listeners a los botones de asistencia
    document.querySelectorAll('.attendance-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const studentDni = this.getAttribute('data-student');
            const status = this.getAttribute('data-status');

            if (!currentAttendance[studentDni]) {
                currentAttendance[studentDni] = { status: 'none', notes: '' };
            }

            // Update model
            currentAttendance[studentDni].status = status;

            // Immediately update the row DOM for snappy feedback
            const row = this.closest('tr');
            if (row) {
                const btns = row.querySelectorAll('.attendance-btn');
                btns.forEach(b => {
                    // reset classes and inline styles, then set the correct outline per button
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

                // Apply active styles to the clicked button
                const applyInline = (el, s) => {
                    if (!el) return;
                    // If 'none' (Sin marcar), keep outline and do not apply filled inline styles
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
                        case 'present':
                            el.style.setProperty('background-color', '#06d6a0', 'important'); el.style.setProperty('border-color', '#06d6a0', 'important'); el.style.setProperty('color', '#ffffff', 'important'); break;
                        case 'late':
                            el.style.setProperty('background-color', '#ffd166', 'important'); el.style.setProperty('border-color', '#ffd166', 'important'); el.style.setProperty('color', '#000000', 'important'); break;
                        case 'absent':
                            el.style.setProperty('background-color', '#ef476f', 'important'); el.style.setProperty('border-color', '#ef476f', 'important'); el.style.setProperty('color', '#ffffff', 'important'); break;
                        case 'justified':
                            el.style.setProperty('background-color', '#06b6d4', 'important'); el.style.setProperty('border-color', '#06b6d4', 'important'); el.style.setProperty('color', '#ffffff', 'important'); break;
                    }
                };

                applyInline(this, status);
            }

            // Also call updateStudentRow to keep logic centralized (it will clear/ensure classes)
            updateStudentRow(studentDni);
            updateAttendanceStats();
        });
    });
    
    // Agregar event listeners a los campos de observaciones
    document.querySelectorAll('.notes-input').forEach(input => {
        input.addEventListener('input', function() {
            const studentDni = this.getAttribute('data-student');
            
            if (!currentAttendance[studentDni]) {
                currentAttendance[studentDni] = { status: 'none', notes: '' };
            }
            
            currentAttendance[studentDni].notes = this.value;
        });
    });
    
    // Actualizar también la tabla con búsqueda para mantener consistencia
    updateAttendanceTableWithSearch();
}

        // Actualizar la fila de un estudiante específico
 // Modificar updateStudentRow para manejar el estado "none"
// Actualizar la fila de un estudiante específico - CORREGIDA
function updateStudentRow(studentDni) {
    const student = studentsData.find(s => s.dni === studentDni);
    const attendance = currentAttendance[studentDni];
    
    if (!student || !attendance) return;
    
    const rows = document.querySelectorAll('#attendanceTableBody tr');
    
    rows.forEach(row => {
        const nameCell = row.querySelector('.student-name');
        if (nameCell && nameCell.textContent === student.name) {
            const presentBtn = row.querySelector('.attendance-btn[data-status="present"]');
            const lateBtn = row.querySelector('.attendance-btn[data-status="late"]');
            const absentBtn = row.querySelector('.attendance-btn[data-status="absent"]');
            const justifiedBtn = row.querySelector('.attendance-btn[data-status="justified"]');
            const noneBtn = row.querySelector('.attendance-btn[data-status="none"]');
            
            [presentBtn, lateBtn, absentBtn, justifiedBtn, noneBtn].forEach(btn => {
                if (btn) {
                    btn.classList.remove('btn-success', 'btn-warning', 'btn-danger', 'btn-info', 'btn-secondary');
                    const s = btn.getAttribute('data-status');
                    const outlineMap = {
                        'present': 'btn-outline-success',
                        'late': 'btn-outline-warning',
                        'absent': 'btn-outline-danger',
                        'justified': 'btn-outline-info',
                        'none': 'btn-outline-secondary'
                    };
                    btn.classList.add(outlineMap[s] || 'btn-outline-secondary');
                    // clear any inline styles set previously
                    btn.style.removeProperty('background-color');
                    btn.style.removeProperty('color');
                    btn.style.removeProperty('border-color');
                }
            });

            const activeBtn = row.querySelector(`.attendance-btn[data-status="${attendance.status}"]`);
            if (activeBtn) {
                activeBtn.classList.remove(`btn-outline-${getStatusColor(attendance.status)}`);
                activeBtn.classList.add(`btn-${getStatusColor(attendance.status)}`);

                // Ensure visual override in case external CSS is still stronger: apply inline styles
                switch (attendance.status) {
                    case 'present':
                        activeBtn.style.setProperty('background-color', '#06d6a0', 'important');
                        activeBtn.style.setProperty('border-color', '#06d6a0', 'important');
                        activeBtn.style.setProperty('color', '#ffffff', 'important');
                        break;
                    case 'late':
                        activeBtn.style.setProperty('background-color', '#ffd166', 'important');
                        activeBtn.style.setProperty('border-color', '#ffd166', 'important');
                        activeBtn.style.setProperty('color', '#000000', 'important');
                        break;
                    case 'absent':
                        activeBtn.style.setProperty('background-color', '#ef476f', 'important');
                        activeBtn.style.setProperty('border-color', '#ef476f', 'important');
                        activeBtn.style.setProperty('color', '#ffffff', 'important');
                        break;
                    case 'justified':
                        activeBtn.style.setProperty('background-color', '#06b6d4', 'important');
                        activeBtn.style.setProperty('border-color', '#06b6d4', 'important');
                        activeBtn.style.setProperty('color', '#ffffff', 'important');
                        break;
                    case 'none':
                    default:
                        activeBtn.style.setProperty('background-color', '#6b7280', 'important');
                        activeBtn.style.setProperty('border-color', '#6b7280', 'important');
                        activeBtn.style.setProperty('color', '#ffffff', 'important');
                        break;
                }
            }
        }
    });
}
// Actualizar getStatusColor para manejar "none"
function getStatusColor(status) {
    switch(status) {
        case 'present': return 'success';
        case 'late': return 'warning';
        case 'absent': return 'danger';
        case 'justified': return 'info';
        case 'none': return 'secondary';
        default: return 'secondary';
    }
}

// Modificar updateAttendanceStats para contar correctamente
// Modificar updateAttendanceStats para contar correctamente - MEJORADA
function updateAttendanceStats() {
    const filteredStudents = getFilteredStudents();
    
    let presentCount = 0;
    let lateCount = 0;
    let absentCount = 0;
    let justifiedCount = 0;
    let noneCount = 0;
    
    filteredStudents.forEach(student => {
        const attendance = currentAttendance[student.dni];
        const status = attendance?.status || 'none';
        
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
            case 'none':
                noneCount++;
                break;
        }
    });
    
    // Actualizar los contadores del resumen
    document.getElementById('presentCountSummary').textContent = presentCount;
    document.getElementById('lateCountSummary').textContent = lateCount;
    document.getElementById('absentCountSummary').textContent = absentCount + justifiedCount;
    
    // Actualizar el texto de estadísticas
    document.getElementById('attendanceStats').innerHTML = `
        <span id="presentCount">${presentCount}</span> presentes, 
        <span id="lateCount">${lateCount}</span> tardanzas, 
        <span id="absentCount">${absentCount + justifiedCount}</span> faltas,
        <span id="noneCount">${noneCount}</span> sin marcar
        <span class="ms-2 text-info">
            <i class="bi bi-info-circle me-1"></i> Solo se guardarán los estudiantes marcados
        </span>
    `;
}

        // Actualizar el título de la tabla de asistencia
// Actualizar el título de la tabla de asistencia - MODIFICADA CON TURNO
function updateAttendanceTitle() {
    const titleElement = document.getElementById('attendanceTitle');
    const filteredStudents = getFilteredStudents();
    
    let title = `Asistencia - `;
    
    if (selectedGrade === "" && selectedSection === "" && selectedShift === "") {
        title += `Todos los estudiantes (${filteredStudents.length})`;
    } else {
        const parts = [];
        
        if (selectedGrade !== "") {
            const grade = gradesData.find(g => g.id == selectedGrade);
            if (grade) parts.push(grade.name);
        }
        
        if (selectedSection !== "") {
            const grade = gradesData.find(g => g.id == selectedGrade);
            const section = grade ? grade.sections.find(s => s.id == selectedSection) : null;
            if (section) parts.push(`Sección ${section.name}`);
        }
        
        // AGREGAR TURNO AL TÍTULO
        if (selectedShift !== "") {
            const shiftText = selectedShift === 'morning' ? 'Mañana' : 'Tarde';
            parts.push(`Turno ${shiftText}`);
        }
        
        if (parts.length === 0) {
            title += `${filteredStudents.length} estudiantes`;
        } else {
            title += `${parts.join(', ')} (${filteredStudents.length} estudiantes)`;
        }
    }
    
    titleElement.textContent = title;
    
    // Actualizar la búsqueda cuando cambia el filtro
    performSearch();
}


// Variables para el buscador
let searchTerm = '';
let filteredStudentsBySearch = [];

// Configurar event listeners del buscador
function setupSearchListeners() {
    const searchInput = document.getElementById('studentSearch');
    const clearSearchBtn = document.getElementById('clearSearch');
    
    // Event listener para búsqueda en tiempo real
    searchInput.addEventListener('input', function(e) {
        searchTerm = e.target.value.trim().toLowerCase();
        performSearch();
    });
    
    // Event listener para limpiar búsqueda
    clearSearchBtn.addEventListener('click', function() {
        searchInput.value = '';
        searchTerm = '';
        performSearch();
        searchInput.focus();
    });
    
    // Event listener para tecla Escape
    searchInput.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            searchInput.value = '';
            searchTerm = '';
            performSearch();
        }
    });
}

// Función para realizar la búsqueda
// Función para realizar la búsqueda - MODIFICADA CON TURNO
function performSearch() {
    if (searchTerm === '') {
        filteredStudentsBySearch = getFilteredStudents();
    } else {
        const allFilteredStudents = getFilteredStudents();
        filteredStudentsBySearch = allFilteredStudents.filter(student => {
            const nameMatch = student.name.toLowerCase().includes(searchTerm);
            const dniMatch = student.dni.includes(searchTerm);
            const gradeMatch = student.grade.toLowerCase().includes(searchTerm);
            const sectionMatch = student.section.toLowerCase().includes(searchTerm);
            const shiftMatch = student.shift.toLowerCase().includes(searchTerm);
            
            return nameMatch || dniMatch || gradeMatch || sectionMatch || shiftMatch;
        });
    }
    
    updateSearchResultsCount();
    updateAttendanceTableWithSearch();
}

// Función para actualizar el contador de resultados
function updateSearchResultsCount() {
    const totalFiltered = getFilteredStudents().length;
    const visibleCount = filteredStudentsBySearch.length;
    const searchResultsElement = document.getElementById('searchResultsCount');
    
    if (searchResultsElement) {
        const visibleSpan = document.getElementById('visibleStudentsCount');
        const totalSpan = document.getElementById('totalFilteredStudents');
        
        if (visibleSpan) visibleSpan.textContent = visibleCount;
        if (totalSpan) totalSpan.textContent = totalFiltered;
        
        if (searchTerm !== '') {
            searchResultsElement.innerHTML = `
                Mostrando <span id="visibleStudentsCount">${visibleCount}</span> de 
                <span id="totalFilteredStudents">${totalFiltered}</span> estudiantes
                <span class="badge bg-info ms-2">Búsqueda: "${searchTerm}"</span>
            `;
        } else {
            searchResultsElement.innerHTML = `
                Mostrando <span id="visibleStudentsCount">${visibleCount}</span> de 
                <span id="totalFilteredStudents">${totalFiltered}</span> estudiantes
            `;
        }
    }
}

// Función para resaltar texto en los resultados
function highlightText(text, searchTerm) {
    if (!searchTerm) return text;
    
    const regex = new RegExp(`(${searchTerm.replace(/[.*+?^${}()|[\]\\]/g, '\\$&')})`, 'gi');
    return text.replace(regex, '<mark class="search-highlight">$1</mark>');
}

// Función actualizada para mostrar la tabla con búsqueda
function updateAttendanceTableWithSearch() {
    const tableBody = document.getElementById('attendanceTableBody');
    const studentsToShow = searchTerm ? filteredStudentsBySearch : getFilteredStudents();
    
    tableBody.innerHTML = '';
    
    if (studentsToShow.length === 0) {
        if (searchTerm) {
            tableBody.innerHTML = `
                <tr>
                    <td colspan="4" class="text-center py-5 text-muted no-results">
                        <i class="bi bi-search display-4 d-block mb-3"></i>
                        <h5>No se encontraron estudiantes</h5>
                        <p class="mb-0">No hay resultados para "<strong>${searchTerm}</strong>"</p>
                        <small>Intente con otro nombre, DNI, grado o sección</small>
                    </td>
                </tr>
            `;
        } else {
            tableBody.innerHTML = `
                <tr>
                    <td colspan="4" class="text-center py-4 text-muted">
                        <i class="bi bi-people display-4 d-block mb-2"></i>
                        No hay estudiantes para mostrar
                    </td>
                </tr>
            `;
        }
        return;
    }
    
    studentsToShow.forEach(student => {
    const attendance = currentAttendance[student.dni] || { status: 'none', notes: '' };

    // Determinar el texto y clase para el turno
    const shiftText = student.shift === 'morning' ? 'Mañana' : 'Tarde';
    const shiftClass = student.shift === 'morning' ? 'bg-info' : 'bg-warning';
    
    // Aplicar resaltado si hay búsqueda
    const displayName = searchTerm ? 
        highlightText(student.name, searchTerm) : 
        student.name;
    const displayDni = searchTerm ? 
        highlightText(student.dni, searchTerm) : 
        student.dni;
    const displayGrade = searchTerm ? 
        highlightText(student.grade, searchTerm) : 
        student.grade;
    const displaySection = searchTerm ? 
        highlightText(student.section, searchTerm) : 
        student.section;
    
    const row = document.createElement('tr');
    row.innerHTML = `
        <td class="ps-4">
            <div class="d-flex align-items-center">
                <div class="student-avatar me-3">
                    <i class="bi bi-person"></i>
                </div>
                <div>
                    <div class="student-name">${displayName}</div>
                    <div class="student-info">DNI: ${displayDni}</div>
                </div>
            </div>
        </td>
        <td>
            <span class="badge bg-primary bg-opacity-10 text-primary">${displayGrade}</span>
            <span class="badge bg-success bg-opacity-10 text-success">${displaySection}</span>
        </td>
        <td>
            <span class="badge ${shiftClass}">${shiftText}</span>
        </td>
        <td class="text-center">
            <div class="btn-group btn-group-sm" role="group">
                <button type="button" class="btn ${attendance.status === 'present' ? 'btn-success' : 'btn-outline-success'} attendance-btn" data-student="${student.dni}" data-status="present">
                    <i class="bi bi-check-lg me-1"></i> Presente
                </button>
                <button type="button" class="btn ${attendance.status === 'late' ? 'btn-warning' : 'btn-outline-warning'} attendance-btn" data-student="${student.dni}" data-status="late">
                    <i class="bi bi-clock me-1"></i> Tardanza
                </button>
                <button type="button" class="btn ${attendance.status === 'absent' ? 'btn-danger' : 'btn-outline-danger'} attendance-btn" data-student="${student.dni}" data-status="absent">
                    <i class="bi bi-x-lg me-1"></i> Falta
                </button>
                <button type="button" class="btn ${attendance.status === 'justified' ? 'btn-info' : 'btn-outline-info'} attendance-btn" data-student="${student.dni}" data-status="justified">
                    <i class="bi bi-file-text me-1"></i> Justificado
                </button>
                <button type="button" class="btn ${attendance.status === 'none' ? 'btn-secondary' : 'btn-outline-secondary'} attendance-btn" data-student="${student.dni}" data-status="none">
                    <i class="bi bi-dash-lg me-1"></i> Sin marcar
                </button>
            </div>
        </td>
        <td class="pe-4">
            <input type="text" class="form-control form-control-sm notes-input" placeholder="Observaciones..." data-student="${student.dni}" value="${attendance.notes}">
        </td>
    `;
        
        tableBody.appendChild(row);
    });
    
    // Agregar event listeners a los botones de asistencia
    document.querySelectorAll('.attendance-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const studentDni = this.getAttribute('data-student');
            const status = this.getAttribute('data-status');
            
            if (!currentAttendance[studentDni]) {
                currentAttendance[studentDni] = { status: 'none', notes: '' };
            }
            
            currentAttendance[studentDni].status = status;
            
            updateStudentRow(studentDni);
            updateAttendanceStats();
        });
    });
    
    // Agregar event listeners a los campos de observaciones
    document.querySelectorAll('.notes-input').forEach(input => {
        input.addEventListener('input', function() {
            const studentDni = this.getAttribute('data-student');
            
            if (!currentAttendance[studentDni]) {
                currentAttendance[studentDni] = { status: 'none', notes: '' };
            }
            
            currentAttendance[studentDni].notes = this.value;
        });
    });
}

// Función para cargar el resumen desde la base de datos
function loadAttendanceSummaryFromDB() {
    fetch(`{{ route('attendance.summary') }}?date=${selectedDate}`, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            updateAttendanceSummaryDisplay(data.summary);
        } else {
            console.error('Error al cargar resumen:', data.message);
            // Mostrar ceros en caso de error
            updateAttendanceSummaryDisplay({
                present: 0,
                late: 0,
                absent: 0,
                justified: 0,
                total: {{ $totalStudents }}
            });
        }
    })
    .catch(error => {
        console.error('Error al cargar resumen:', error);
        // Mostrar ceros en caso de error
        updateAttendanceSummaryDisplay({
            present: 0,
            late: 0,
            absent: 0,
            justified: 0,
            total: {{ $totalStudents }}
        });
    });
}

// Función para actualizar la visualización del resumen
// Función para actualizar la visualización del resumen
function updateAttendanceSummaryDisplay(summary) {
    document.getElementById('presentCountSummary').textContent = summary.present;
    document.getElementById('lateCountSummary').textContent = summary.late;
    document.getElementById('absentCountSummary').textContent = summary.absent;
    document.getElementById('justifiedCountSummary').textContent = summary.justified;
    document.getElementById('noneCountSummary').textContent = summary.none || (summary.total - (summary.present + summary.late + summary.absent + summary.justified));
    document.getElementById('totalStudents').textContent = summary.total;
}

// Función para cargar el resumen filtrado por grado/sección
// Función para cargar el resumen filtrado por grado/sección/turno
function loadFilteredAttendanceSummaryFromDB() {
    const params = new URLSearchParams({
        date: selectedDate,
        grade_id: selectedGrade || '',
        section_id: selectedSection || '',
        shift: selectedShift || '' // ← AGREGAR TURNO
    });

    fetch(`{{ route('attendance.summary') }}?${params}`, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            updateAttendanceSummaryDisplay(data.summary);
        }
    })
    .catch(error => {
        console.error('Error al cargar resumen filtrado:', error);
    });
}

// Función auxiliar para búsqueda rápida (desarrollo)
function quickSearch(term) {
    const searchInput = document.getElementById('studentSearch');
    searchInput.value = term;
    searchTerm = term.toLowerCase();
    performSearch();
    searchInput.focus();
}

// Hacerla disponible globalmente para debugging
window.quickSearch = quickSearch;
    </script>
</body>
</html>