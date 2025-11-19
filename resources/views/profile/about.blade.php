<!DOCTYPE html>
<html lang="{{ session('language', 'es') }}" data-theme="{{ session('theme', 'light') }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acerca del Sistema - Sistema Escolar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
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

        /* Main Content - MEJORADO */
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 0;
            transition: var(--transition);
            min-height: 100vh;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            position: relative;
        }

        .main-content::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.05) 0%, rgba(99, 102, 241, 0) 70%);
            border-radius: 50%;
            z-index: 0;
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

        /* Contenido Principal - MEJORADO */
        .content-wrapper {
            padding: 2rem;
            position: relative;
            z-index: 1;
        }

        .about-header {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            color: white;
            padding: 3rem 0;
            margin-bottom: 2rem;
            position: relative;
            overflow: hidden;
        }

        .about-header::before {
            content: '';
            position: absolute;
            top: -50px;
            right: -50px;
            width: 200px;
            height: 200px;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.2) 0%, rgba(99, 102, 241, 0) 70%);
            border-radius: 50%;
        }

        .about-header::after {
            content: '';
            position: absolute;
            bottom: -80px;
            left: -80px;
            width: 200px;
            height: 200px;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.15) 0%, rgba(59, 130, 246, 0) 70%);
            border-radius: 50%;
        }

        .about-card {
            background: var(--card-bg);
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            overflow: hidden;
            margin-bottom: 2rem;
            border: 1px solid rgba(255, 255, 255, 0.9);
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .about-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), var(--primary-light));
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.5s ease;
        }

        .about-card:hover::before {
            transform: scaleX(1);
        }

        .about-card:hover {
            box-shadow: var(--card-hover-shadow);
            transform: translateY(-5px);
        }

        .feature-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--primary-color) 0%, #818cf8 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            margin-bottom: 1rem;
            transition: var(--transition);
        }

        .about-card:hover .feature-icon {
            transform: scale(1.1) rotate(5deg);
            box-shadow: 0 8px 20px rgba(99, 102, 241, 0.3);
        }

        .version-badge {
            background: linear-gradient(135deg, var(--primary-color) 0%, #818cf8 100%);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.9rem;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
        }

        /* Estilos mejorados para las tarjetas de información */
        .card-header {
            background: linear-gradient(135deg, rgba(248, 250, 252, 0.8) 0%, rgba(241, 245, 249, 0.8) 100%);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(226, 232, 240, 0.7);
        }

        .card-body {
            padding: 1.5rem;
        }

        .card-body p {
            margin-bottom: 0.75rem;
        }

        .card-body .row {
            margin-bottom: 1rem;
        }

        /* Estilos para badges de información técnica */
        .badge {
            font-size: 0.75rem;
            padding: 0.4rem 0.75rem;
            border-radius: 8px;
            font-weight: 600;
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
            .about-header {
                padding: 2rem 0;
            }
        }
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
                    <a class="nav-link" href="#">
                        <i class="bi bi-person-video3"></i>
                        <span>Profesores</span>
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
                    <a class="user-menu-item active" href="{{ route('about') }}">
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
        <div class="about-header">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h1 class="h2 fw-bold mb-2">Acerca del Sistema</h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-white-50">Inicio</a></li>
                                <li class="breadcrumb-item active text-white" aria-current="page">Acerca del Sistema</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <span class="version-badge">v2.0.1</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <!-- Información del Sistema -->
                    <div class="about-card">
                        <div class="card-header bg-transparent border-bottom-0 py-3">
                            <h6 class="mb-0 fw-bold"><i class="bi bi-info-circle me-2"></i>Información del Sistema</h6>
                        </div>
                        <div class="card-body">
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <p><strong>Nombre:</strong> Sistema Escolar Integral</p>
                                    <p><strong>Versión:</strong> 2.0.1</p>
                                    <p><strong>Licencia:</strong> Propietario</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Desarrollado por:</strong> Equipo de Desarrollo TI</p>
                                    <p><strong>Última actualización:</strong> 15/03/2024</p>
                                    <p><strong>Soporte:</strong> soporte@sistemaescolar.com</p>
                                </div>
                            </div>
                            
                            <p class="mb-0">
                                El Sistema Escolar Integral es una plataforma moderna diseñada para gestionar 
                                eficientemente todos los aspectos administrativos y académicos de instituciones 
                                educativas. Ofrece herramientas completas para la gestión de estudiantes, 
                                profesores, asistencias y reportes.
                            </p>
                        </div>
                    </div>

                    <!-- Características -->
                    <div class="about-card">
                        <div class="card-header bg-transparent border-bottom-0 py-3">
                            <h6 class="mb-0 fw-bold"><i class="bi bi-star me-2"></i>Características Principales</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <div class="feature-icon">
                                        <i class="bi bi-people"></i>
                                    </div>
                                    <h6 class="fw-bold">Gestión de Estudiantes</h6>
                                    <p class="text-muted mb-0">
                                        Registro completo de información estudiantil con historial académico.
                                    </p>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <div class="feature-icon">
                                        <i class="bi bi-clipboard-check"></i>
                                    </div>
                                    <h6 class="fw-bold">Control de Asistencias</h6>
                                    <p class="text-muted mb-0">
                                        Sistema avanzado de registro y seguimiento de asistencias.
                                    </p>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <div class="feature-icon">
                                        <i class="bi bi-graph-up"></i>
                                    </div>
                                    <h6 class="fw-bold">Reportes y Estadísticas</h6>
                                    <p class="text-muted mb-0">
                                        Generación de reportes detallados y análisis estadísticos.
                                    </p>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <div class="feature-icon">
                                        <i class="bi bi-shield-check"></i>
                                    </div>
                                    <h6 class="fw-bold">Seguridad</h6>
                                    <p class="text-muted mb-0">
                                        Protección de datos con roles y permisos de acceso.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <!-- Información Técnica -->
                    <div class="about-card">
                        <div class="card-header bg-transparent border-bottom-0 py-3">
                            <h6 class="mb-0 fw-bold"><i class="bi bi-cpu me-2"></i>Información Técnica</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <strong>Framework:</strong>
                                <span class="badge bg-primary ms-2">Laravel 10.49.1</span>
                            </div>
                            <div class="mb-3">
                                <strong>Base de Datos:</strong>
                                <span class="badge bg-success ms-2">MySQL 8.0</span>
                            </div>
                            <div class="mb-3">
                                <strong>Frontend:</strong>
                                <span class="badge bg-info ms-2">Bootstrap 5.3</span>
                            </div>
                            <div class="mb-3">
                                <strong>Servidor Web:</strong>
                                <span class="badge bg-warning ms-2">Apache/Nginx</span>
                            </div>
                            <div class="mb-3">
                                <strong>PHP Version:</strong>
                                <span class="badge bg-danger ms-2">PHP 8.2+</span>
                            </div>
                        </div>
                    </div>

                    <!-- Soporte -->
                    <div class="about-card">
                        <div class="card-header bg-transparent border-bottom-0 py-3">
                            <h6 class="mb-0 fw-bold"><i class="bi bi-headset me-2"></i>Soporte Técnico</h6>
                        </div>
                        <div class="card-body">
                            <p class="mb-3">
                                Para soporte técnico, contactar al equipo de desarrollo:
                            </p>
                            <div class="mb-2">
                                <i class="bi bi-envelope me-2"></i>
                                <strong>Email:</strong> soporte@sistemaescolar.com
                            </div>
                            <div class="mb-2">
                                <i class="bi bi-telephone me-2"></i>
                                <strong>Teléfono:</strong> +51 1 234-5678
                            </div>
                            <div class="mb-2">
                                <i class="bi bi-clock me-2"></i>
                                <strong>Horario:</strong> Lunes a Viernes 8:00 - 18:00
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
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
    </script>
</body>
</html>