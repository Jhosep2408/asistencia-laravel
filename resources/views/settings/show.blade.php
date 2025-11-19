<!DOCTYPE html>
<html lang="es" data-theme="{{ session('theme', 'light') }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuración - Sistema Escolar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #6366f1;
            --sidebar-bg: #1e293b;
            --card-bg: #ffffff;
            --border-radius: 16px;
            --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        /* Estilos para tema oscuro */
        [data-theme="dark"] {
            --card-bg: #1e293b;
            --text-primary: #f1f5f9;
            --text-secondary: #cbd5e1;
            --text-muted: #94a3b8;
            --border-color: #334155;
            --light-bg: #0f172a;
        }

        [data-theme="dark"] body {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            color: #f1f5f9;
        }

        [data-theme="dark"] .settings-card {
            background: var(--card-bg);
            color: #f1f5f9;
            border: 1px solid #334155;
        }

        [data-theme="dark"] .form-control,
        [data-theme="dark"] .form-select {
            background-color: #1e293b;
            border-color: #475569;
            color: #f1f5f9;
        }

        [data-theme="dark"] .form-control:focus,
        [data-theme="dark"] .form-select:focus {
            background-color: #1e293b;
            border-color: #6366f1;
            color: #f1f5f9;
        }

        [data-theme="dark"] .btn-outline-primary {
            border-color: #6366f1;
            color: #6366f1;
        }

        [data-theme="dark"] .btn-outline-primary:hover {
            background-color: #6366f1;
            color: white;
        }

        body {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            transition: all 0.3s ease;
        }

        .settings-header {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            color: white;
            padding: 3rem 0;
            margin-bottom: 2rem;
            position: relative;
            overflow: hidden;
        }

        .settings-header::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.2) 0%, rgba(99, 102, 241, 0) 70%);
            border-radius: 50%;
            transform: translate(30%, -30%);
        }

        .settings-card {
            background: var(--card-bg);
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            overflow: hidden;
            margin-bottom: 2rem;
            transition: all 0.3s ease;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .settings-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-save {
            background: linear-gradient(135deg, var(--primary-color) 0%, #818cf8 100%);
            border: none;
            border-radius: 12px;
            padding: 0.75rem 2rem;
            color: white;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-save:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(99, 102, 241, 0.3);
        }

        .theme-option {
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
        }

        [data-theme="dark"] .theme-option {
            border-color: #475569;
        }

        .theme-option:hover {
            border-color: var(--primary-color);
        }

        .theme-option.active {
            border-color: var(--primary-color);
            background-color: rgba(99, 102, 241, 0.05);
        }

        .theme-preview {
            width: 60px;
            height: 30px;
            border-radius: 6px;
            margin: 0 auto 0.5rem;
        }

        .theme-light { background: linear-gradient(90deg, #f8fafc 50%, #1e293b 50%); }
        .theme-dark { background: linear-gradient(90deg, #1e293b 50%, #f8fafc 50%); }
        .theme-system { background: conic-gradient(#f8fafc, #1e293b, #f8fafc); }

        /* Incluir todos los estilos del dashboard aquí */
        :root {
            --primary-color: #6366f1;
            --primary-light: #818cf8;
            --primary-dark: #4f46e5;
            --sidebar-bg: #1e293b;
            --sidebar-header-bg: #0f172a;
            --sidebar-hover: #334155;
            --sidebar-active: #3b82f6;
            --header-bg: #0f172a;
            --header-gradient: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --info-color: #06b6d4;
            --purple-color: #8b5cf6;
            --pink-color: #ec4899;
            --card-bg: #ffffff;
            --text-primary: #1e293b;
            --text-secondary: #64748b;
            --text-muted: #94a3b8;
            --border-color: #e2e8f0;
            --light-bg: #f8fafc;
            --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --card-hover-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            --sidebar-width: 280px;
            --border-radius: 16px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            font-family: 'Inter', 'Segoe UI', system-ui, sans-serif;
            color: var(--text-primary);
            line-height: 1.6;
            min-height: 100vh;
            overflow-x: hidden;
            transition: all 0.3s ease;
        }

        /* Sidebar Elegante */
        .sidebar {
            width: var(--sidebar-width);
            background: linear-gradient(180deg, var(--sidebar-header-bg) 0%, var(--sidebar-bg) 100%);
            color: #e2e8f0;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            transition: var(--transition);
            z-index: 1000;
            box-shadow: 4px 0 25px rgba(0, 0, 0, 0.25);
            overflow-y: auto;
            border-right: 1px solid rgba(255, 255, 255, 0.08);
            display: flex;
            flex-direction: column;
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
            flex: 1;
        }

        .sidebar-menu .nav-link {
            color: #cbd5e1;
            padding: 0.875rem 1.5rem;
            margin: 0.125rem 0.75rem;
            border-radius: var(--border-radius);
            transition: var(--transition);
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
            align-items: center;
            width: 100%;
            padding: 1rem;
            cursor: pointer;
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
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
            border: 2px solid rgba(255, 255, 255, 0.3);
            transition: var(--transition);
            margin-right: 0.75rem;
        }

        .user-profile-bottom-btn:hover .profile-bottom-icon {
            transform: scale(1.1);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }

        .profile-bottom-text {
            font-size: 0.9rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: var(--transition);
        }

        .user-profile-bottom-btn:hover .profile-bottom-text {
            color: #60a5fa;
        }

        /* Dropdown menu para perfil */
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

        /* Main Content - Estilos Mejorados */
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 0;
            transition: var(--transition);
            min-height: 100vh;
            position: relative;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        }

        [data-theme="dark"] .main-content {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        }

        /* Dashboard Header Profesional */
        .dashboard-header {
            background: var(--header-gradient);
            color: white;
            padding: 1.5rem 2rem;
            margin-bottom: 0;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            position: relative;
            overflow: hidden;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .dashboard-header::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.2) 0%, rgba(99, 102, 241, 0) 70%);
            border-radius: 50%;
            transform: translate(30%, -30%);
        }

        .dashboard-header::after {
            content: '';
            position: absolute;
            bottom: -100px;
            left: -100px;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.15) 0%, rgba(59, 130, 246, 0) 70%);
            border-radius: 50%;
        }

        .dashboard-header h1 {
            font-weight: 800;
            font-size: 2rem;
            letter-spacing: -0.025em;
            margin-bottom: 0.5rem;
            position: relative;
            z-index: 1;
            background: linear-gradient(135deg, #fff 0%, #e2e8f0 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .breadcrumb {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 0.75rem 1.25rem;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            position: relative;
            z-index: 1;
        }

        .breadcrumb-item a {
            color: rgba(255, 255, 255, 0.9);
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

        /* Contenido Principal - Estilos Mejorados */
        .content-wrapper {
            padding: 2rem;
            position: relative;
            max-width: 1400px;
            margin: 0 auto;
        }

        /* Alertas mejoradas */
        .alert {
            border-radius: var(--border-radius);
            border: none;
            box-shadow: var(--card-shadow);
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
        }

        .alert-success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
        }

        .alert-danger {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
        }

        .alert .btn-close {
            filter: invert(1);
        }

        /* Formularios mejorados */
        .form-label {
            font-weight: 600;
            margin-bottom: 0.75rem;
            color: var(--text-primary);
        }

        .form-control, .form-select {
            border-radius: 12px;
            padding: 0.75rem 1rem;
            border: 1px solid var(--border-color);
            transition: var(--transition);
        }

        .form-control:focus, .form-select:focus {
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
            border-color: var(--primary-color);
        }

        /* Cards de configuración mejoradas */
        .settings-card .card-header {
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            padding: 1.5rem 1.5rem 0.5rem;
        }

        [data-theme="dark"] .settings-card .card-header {
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .settings-card .card-body {
            padding: 1.5rem;
        }

        /* Switch mejorado */
        .form-check.form-switch {
            padding-left: 3.5rem;
        }

        .form-check-input {
            width: 3rem;
            height: 1.5rem;
            margin-left: -3.5rem;
        }

        .form-check-label {
            font-weight: 600;
            color: var(--text-primary);
        }

        .form-text {
            color: var(--text-muted);
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        /* Botones de acción mejorados */
        .btn-outline-primary, .btn-outline-info, .btn-outline-secondary {
            border-radius: 12px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: var(--transition);
            border-width: 2px;
        }

        .btn-outline-primary:hover, .btn-outline-info:hover, .btn-outline-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
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
            
            .profile-bottom-text {
                display: none !important;
            }
            
            .user-profile-bottom-btn {
                padding: 0.75rem !important;
                justify-content: center;
            }
            
            .profile-bottom-icon {
                margin-right: 0;
                width: 35px;
                height: 35px;
                font-size: 1.1rem;
            }
            
            .user-profile-menu {
                min-width: 200px !important;
                left: 50%;
                transform: translateX(-50%);
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
                padding: 1.25rem;
            }
            .dashboard-header h1 {
                font-size: 1.75rem;
            }
            
            .settings-card .card-body {
                padding: 1rem;
            }
            
            .theme-option {
                padding: 0.75rem;
            }
            
            .theme-preview {
                width: 50px;
                height: 25px;
            }
        }

        @media (max-width: 576px) {
            .content-wrapper {
                padding: 0.75rem;
            }
            
            .settings-header {
                padding: 2rem 0;
            }
            
            .settings-header h1 {
                font-size: 1.5rem;
            }
            
            .btn-save, .btn-outline-primary, .btn-outline-info, .btn-outline-secondary {
                width: 100%;
                margin-bottom: 0.75rem;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar (copiado del dashboard) -->
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
                    <a class="nav-link" href="{{ route('students.attendance') }}">
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
                    <a class="nav-link active" href="{{ route('settings.show') }}">
                        <i class="bi bi-gear"></i>
                        <span>Configuración</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Perfil de Usuario en la parte inferior -->
        <div class="sidebar-profile-bottom">
            <div class="user-profile-dropdown">
                <button class="user-profile-bottom-btn" onclick="toggleProfileMenu()">
                    <div class="profile-bottom-icon">
                        <i class="bi bi-person-fill"></i>
                    </div>
                    <div class="profile-bottom-text">Mi Perfil</div>
                </button>
                <div class="user-profile-menu" id="profileMenu">
                    <a class="user-menu-item" href="{{ route('profile.show') }}">
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
                    <a class="user-menu-item" href="{{ route('settings.show') }}">
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
                    <a class="user-menu-item" href="{{ route('about') }}">
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
                    <a class="user-menu-item" href="{{ route('privacy') }}">
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
            </div>
        </div>
    </div>

    <div class="main-content">
        <!-- Header -->
        <div class="settings-header">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h1 class="h2 fw-bold mb-2">Configuración</h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-white-50">Inicio</a></li>
                                <li class="breadcrumb-item active text-white" aria-current="page">Configuración</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <div class="content-wrapper">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <strong>Error:</strong> Por favor corrige los errores en el formulario.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form action="{{ route('settings.update') }}" method="POST" id="settingsForm">
                @csrf
                
                <div class="row">
                    <div class="col-lg-8">
                        <!-- Apariencia -->
                        <div class="settings-card">
                            <div class="card-header bg-transparent border-bottom-0 py-3">
                                <h6 class="mb-0 fw-bold"><i class="bi bi-palette me-2"></i>Apariencia</h6>
                            </div>
                            <div class="card-body">
                                <div class="row mb-4">
                                    <label class="form-label fw-semibold">Tema de la interfaz</label>
                                    <div class="col-md-4 mb-3">
                                        <div class="theme-option {{ ($settings->theme ?? 'light') == 'light' ? 'active' : '' }}" onclick="selectTheme('light')">
                                            <div class="theme-preview theme-light"></div>
                                            <span>Claro</span>
                                            <input type="radio" name="theme" value="light" class="d-none" {{ ($settings->theme ?? 'light') == 'light' ? 'checked' : '' }}>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="theme-option {{ ($settings->theme ?? 'light') == 'dark' ? 'active' : '' }}" onclick="selectTheme('dark')">
                                            <div class="theme-preview theme-dark"></div>
                                            <span>Oscuro</span>
                                            <input type="radio" name="theme" value="dark" class="d-none" {{ ($settings->theme ?? 'light') == 'dark' ? 'checked' : '' }}>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="theme-option {{ ($settings->theme ?? 'light') == 'system' ? 'active' : '' }}" onclick="selectTheme('system')">
                                            <div class="theme-preview theme-system"></div>
                                            <span>Sistema</span>
                                            <input type="radio" name="theme" value="system" class="d-none" {{ ($settings->theme ?? 'light') == 'system' ? 'checked' : '' }}>
                                        </div>
                                    </div>
                                    @error('theme')
                                        <div class="text-danger small mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Idioma</label>
                                    <select name="language" class="form-select @error('language') is-invalid @enderror" id="languageSelect">
                                        <option value="es" {{ ($settings->language ?? 'es') == 'es' ? 'selected' : '' }}>Español</option>
                                        <option value="en" {{ ($settings->language ?? 'es') == 'en' ? 'selected' : '' }}>English</option>
                                        <option value="fr" {{ ($settings->language ?? 'es') == 'fr' ? 'selected' : '' }}>Français</option>
                                        <option value="pt" {{ ($settings->language ?? 'es') == 'pt' ? 'selected' : '' }}>Português</option>
                                    </select>
                                    @error('language')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Notificaciones -->
                        <div class="settings-card">
                            <div class="card-header bg-transparent border-bottom-0 py-3">
                                <h6 class="mb-0 fw-bold"><i class="bi bi-bell me-2"></i>Notificaciones</h6>
                            </div>
                            <div class="card-body">
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" name="notifications" value="1" 
                                           {{ ($settings->notifications ?? true) ? 'checked' : '' }}>
                                    <label class="form-check-label fw-semibold">Notificaciones del sistema</label>
                                    <div class="form-text">Recibir notificaciones sobre actividades importantes</div>
                                </div>
                                
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" name="email_notifications" value="1"
                                           {{ ($settings->email_notifications ?? true) ? 'checked' : '' }}>
                                    <label class="form-check-label fw-semibold">Notificaciones por correo</label>
                                    <div class="form-text">Recibir notificaciones por correo electrónico</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <!-- Acciones rápidas -->
                        <div class="settings-card">
                            <div class="card-header bg-transparent border-bottom-0 py-3">
                                <h6 class="mb-0 fw-bold"><i class="bi bi-lightning me-2"></i>Acciones</h6>
                            </div>
                            <div class="card-body">
                                <button type="submit" class="btn btn-save w-100 mb-3">
                                    <i class="bi bi-check-lg me-2"></i>Guardar Cambios
                                </button>
                                
                                <a href="{{ route('profile.show') }}" class="btn btn-outline-primary w-100 mb-3">
                                    <i class="bi bi-person me-2"></i>Ver Perfil
                                </a>
                                
                                <a href="{{ route('privacy') }}" class="btn btn-outline-info w-100 mb-3">
                                    <i class="bi bi-shield-check me-2"></i>Política de Privacidad
                                </a>
                                
                                <a href="{{ route('about') }}" class="btn btn-outline-secondary w-100">
                                    <i class="bi bi-info-circle me-2"></i>Acerca del Sistema
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Función para aplicar el tema
        function applyTheme(theme) {
            document.documentElement.setAttribute('data-theme', theme);
            localStorage.setItem('theme', theme);
        }

        // Función para aplicar el idioma
        function applyLanguage(language) {
            document.documentElement.setAttribute('lang', language);
            localStorage.setItem('language', language);
        }

        function selectTheme(theme) {
            // Remover clase active de todos los temas
            document.querySelectorAll('.theme-option').forEach(option => {
                option.classList.remove('active');
            });
            
            // Agregar clase active al tema seleccionado
            event.currentTarget.classList.add('active');
            
            // Marcar el radio button correspondiente
            document.querySelector(`input[name="theme"][value="${theme}"]`).checked = true;
            
            // Aplicar tema inmediatamente
            applyTheme(theme);
        }

        // Inicializar temas activos
        document.addEventListener('DOMContentLoaded', function() {
            const currentTheme = '{{ $settings->theme ?? 'light' }}';
            const option = document.querySelector(`.theme-option input[value="${currentTheme}"]`);
            if (option) {
                option.parentElement.classList.add('active');
            }
            
            // Aplicar tema guardado
            const savedTheme = localStorage.getItem('theme') || '{{ $settings->theme ?? 'light' }}';
            applyTheme(savedTheme);
            
            // Aplicar idioma guardado
            const savedLanguage = localStorage.getItem('language') || '{{ $settings->language ?? 'es' }}';
            applyLanguage(savedLanguage);
            
            // Configurar el select de idioma
            const languageSelect = document.getElementById('languageSelect');
            if (languageSelect) {
                languageSelect.value = savedLanguage;
            }
        });

        // Cambio de idioma en tiempo real
        document.getElementById('languageSelect')?.addEventListener('change', function(e) {
            applyLanguage(e.target.value);
        });

        // Funciones para el menú de perfil
        function toggleProfileMenu() {
            const menu = document.getElementById('profileMenu');
            menu.classList.toggle('show');
        }

        function closeProfileMenu() {
            const menu = document.getElementById('profileMenu');
            menu.classList.remove('show');
        }

        // Cerrar menú de perfil al hacer clic fuera de él
        document.addEventListener('click', function(e) {
            const profileMenu = document.getElementById('profileMenu');
            const profileBtn = document.querySelector('.user-profile-bottom-btn');
            
            if (!profileBtn.contains(e.target) && !profileMenu.contains(e.target)) {
                closeProfileMenu();
            }
        });

        // Prevenir envío duplicado del formulario
        document.getElementById('settingsForm')?.addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('button[type="submit"]');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Guardando...';
        });
    </script>
</body>
</html>