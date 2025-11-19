<!DOCTYPE html>
<html lang="{{ session('language', 'es') }}" data-theme="{{ session('theme', 'light') }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', __('Sistema Escolar'))</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    
    <!-- Estilos globales con soporte para tema oscuro -->
    <style>
        /* Variables CSS para temas */
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

        /* Tema Oscuro */
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

        [data-theme="dark"] .card,
        [data-theme="dark"] .settings-card,
        [data-theme="dark"] .table-card,
        [data-theme="dark"] .quick-actions-card,
        [data-theme="dark"] .stat-card,
        [data-theme="dark"] .about-card,
        [data-theme="dark"] .privacy-card {
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

        [data-theme="dark"] .table {
            --bs-table-bg: transparent;
            --bs-table-color: #f1f5f9;
            --bs-table-border-color: #334155;
        }

        [data-theme="dark"] .table th {
            background-color: #1e293b;
            color: #f1f5f9;
        }

        [data-theme="dark"] .table td {
            border-color: #334155;
        }

        [data-theme="dark"] .btn-outline-primary {
            border-color: #6366f1;
            color: #6366f1;
        }

        [data-theme="dark"] .btn-outline-primary:hover {
            background-color: #6366f1;
            color: white;
        }

        [data-theme="dark"] .btn-outline-secondary {
            border-color: #64748b;
            color: #64748b;
        }

        [data-theme="dark"] .btn-outline-secondary:hover {
            background-color: #64748b;
            color: white;
        }

        [data-theme="dark"] .text-muted {
            color: #94a3b8 !important;
        }

        [data-theme="dark"] .breadcrumb-item.active {
            color: #cbd5e1;
        }

        /* Estilos base */
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

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 0;
            transition: var(--transition);
            min-height: 100vh;
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

        /* Contenido Principal */
        .content-wrapper {
            padding: 1.5rem;
        }

        /* Tarjetas de Estadísticas */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.25rem;
            margin-bottom: 1.5rem;
        }

        .stat-card {
            background: var(--card-bg);
            border-radius: var(--border-radius);
            padding: 1.5rem;
            box-shadow: var(--card-shadow);
            transition: var(--transition);
            border-left: 4px solid;
            position: relative;
            overflow: hidden;
            height: 100%;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 80px;
            height: 80px;
            background: radial-gradient(circle, rgba(0,0,0,0.03) 0%, rgba(0,0,0,0) 70%);
            border-radius: 50%;
            transform: translate(30%, -30%);
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--card-hover-shadow);
        }

        .stat-card-primary { border-left-color: var(--primary-color); }
        .stat-card-success { border-left-color: var(--success-color); }
        .stat-card-danger { border-left-color: var(--danger-color); }
        .stat-card-info { border-left-color: var(--info-color); }
        .stat-card-purple { border-left-color: var(--purple-color); }
        .stat-card-pink { border-left-color: var(--pink-color); }

        .stat-icon {
            font-size: 2.5rem;
            opacity: 0.9;
            margin-bottom: 0.75rem;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 800;
            margin: 0.25rem 0;
            background: linear-gradient(135deg, var(--text-primary) 0%, var(--text-secondary) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .stat-label {
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 0.25rem;
            opacity: 0.8;
        }

        .stat-description {
            font-size: 0.8rem;
            color: var(--text-muted);
            margin-bottom: 1rem;
        }

        .stat-footer {
            border-top: 1px solid var(--border-color);
            padding-top: 0.75rem;
            margin-top: auto;
        }

        /* Tarjetas de Acciones Rápidas */
        .quick-actions-card {
            background: var(--card-bg);
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            margin-bottom: 1.5rem;
            overflow: hidden;
        }

        .card-header-custom {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border-bottom: 1px solid var(--border-color);
            padding: 1.25rem 1.5rem;
        }

        [data-theme="dark"] .card-header-custom {
            background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
            border-bottom: 1px solid #475569;
        }

        .card-header-custom h5 {
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 0;
            font-size: 1.1rem;
        }

        .btn-action {
            border-radius: 12px;
            padding: 0.75rem 1.25rem;
            font-weight: 600;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            border: none;
            position: relative;
            overflow: hidden;
            font-size: 0.9rem;
        }

        .btn-action::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
            transition: var(--transition);
        }

        .btn-action:hover::before {
            left: 100%;
        }

        .btn-action:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);
        }

        .btn-success {
            background: linear-gradient(135deg, var(--success-color) 0%, #34d399 100%);
        }

        .btn-info {
            background: linear-gradient(135deg, var(--info-color) 0%, #22d3ee 100%);
        }

        .btn-purple {
            background: linear-gradient(135deg, var(--purple-color) 0%, #a78bfa 100%);
        }

        /* Tabla Mejorada */
        .table-card {
            background: var(--card-bg);
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            overflow: hidden;
        }

        .table {
            margin-bottom: 0;
        }

        .table th {
            font-weight: 700;
            color: var(--text-secondary);
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid var(--border-color);
            padding: 1rem;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        }

        [data-theme="dark"] .table th {
            background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
        }

        .table td {
            padding: 1rem;
            vertical-align: middle;
            border-bottom: 1px solid var(--border-color);
        }

        .table-hover tbody tr {
            transition: var(--transition);
        }

        .table-hover tbody tr:hover {
            background-color: rgba(99, 102, 241, 0.04);
            transform: scale(1.01);
        }

        [data-theme="dark"] .table-hover tbody tr:hover {
            background-color: rgba(99, 102, 241, 0.1);
        }

        .badge-status {
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .student-avatar {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--primary-light) 0%, var(--primary-color) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 0.8rem;
        }

        .action-btn {
            border-radius: 8px;
            padding: 0.5rem 0.75rem;
            font-size: 0.8rem;
            transition: var(--transition);
        }

        .action-btn:hover {
            transform: translateY(-2px);
        }

        .date-indicator {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            padding: 0.5rem 1rem;
            border: 1px solid rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            font-weight: 500;
        }

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
        }
    </style>
    
    @yield('styles')
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h3 class="mb-0 fw-bold">
                <i class="bi bi-mortarboard-fill me-2"></i>
                {{ __('Sistema Escolar') }}
            </h3>
            <small class="text-white-50">v2.0</small>
        </div>
        <div class="sidebar-menu">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                        <i class="bi bi-speedometer2"></i>
                        <span>{{ __('Dashboard') }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('students.attendance') ? 'active' : '' }}" href="{{ route('students.attendance') }}">
                        <i class="bi bi-clipboard-check"></i>
                        <span>{{ __('Tomar Asistencia') }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('students.attendanceviews') ? 'active' : '' }}" href="{{ route('students.attendanceviews') }}">
                        <i class="bi bi-graph-up"></i>
                        <span>{{ __('Dashboard Asistencia') }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('students.index') ? 'active' : '' }}" href="{{ route('students.index') }}">
                        <i class="bi bi-people"></i>
                        <span>{{ __('Estudiantes') }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('teachers.*') ? 'active' : '' }}" href="#">
                        <i class="bi bi-person-video3"></i>
                        <span>{{ __('Profesores') }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('attendance.reports') ? 'active' : '' }}" href="{{ route('attendance.reports') }}">
                        <i class="bi bi-journal-text"></i>
                        <span>{{ __('Reportes') }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('settings.show') ? 'active' : '' }}" href="{{ route('settings.show') }}">
                        <i class="bi bi-gear"></i>
                        <span>{{ __('Configuración') }}</span>
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
                    <div class="profile-bottom-text">{{ __('Mi Perfil') }}</div>
                </button>
                <div class="user-profile-menu" id="profileMenu">
                    <a class="user-menu-item" href="{{ route('profile.show') }}">
                        <div class="d-flex align-items-center">
                            <div class="menu-icon bg-primary bg-opacity-10 text-primary">
                                <i class="bi bi-person"></i>
                            </div>
                            <div class="ms-3">
                                <div class="fw-semibold">{{ __('Mi Perfil') }}</div>
                                <small class="text-muted">{{ __('Ver y editar perfil') }}</small>
                            </div>
                        </div>
                    </a>
                    <a class="user-menu-item" href="{{ route('settings.show') }}">
                        <div class="d-flex align-items-center">
                            <div class="menu-icon bg-info bg-opacity-10 text-info">
                                <i class="bi bi-gear"></i>
                            </div>
                            <div class="ms-3">
                                <div class="fw-semibold">{{ __('Configuración') }}</div>
                                <small class="text-muted">{{ __('Ajustes del sistema') }}</small>
                            </div>
                        </div>
                    </a>
                    <a class="user-menu-item" href="{{ route('about') }}">
                        <div class="d-flex align-items-center">
                            <div class="menu-icon bg-warning bg-opacity-10 text-warning">
                                <i class="bi bi-info-circle"></i>
                            </div>
                            <div class="ms-3">
                                <div class="fw-semibold">{{ __('Acerca de') }}</div>
                                <small class="text-muted">{{ __('Información del sistema') }}</small>
                            </div>
                        </div>
                    </a>
                    <a class="user-menu-item" href="{{ route('privacy') }}">
                        <div class="d-flex align-items-center">
                            <div class="menu-icon bg-success bg-opacity-10 text-success">
                                <i class="bi bi-shield-check"></i>
                            </div>
                            <div class="ms-3">
                                <div class="fw-semibold">{{ __('Privacidad') }}</div>
                                <small class="text-muted">{{ __('Configuración de privacidad') }}</small>
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
                                    <div class="fw-semibold">{{ __('Cerrar Sesión') }}</div>
                                    <small class="text-muted">{{ __('Salir del sistema') }}</small>
                                </div>
                            </div>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        @yield('header')
        
        <!-- Contenido Principal -->
        <div class="content-wrapper">
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Scripts globales para tema e idioma -->
    <script>
        // Función para aplicar el tema
        function applyTheme(theme) {
            document.documentElement.setAttribute('data-theme', theme);
            localStorage.setItem('theme', theme);
            
            // Actualizar todos los elementos de la página
            document.querySelectorAll('[data-theme]').forEach(element => {
                element.setAttribute('data-theme', theme);
            });
        }

        // Función para aplicar el idioma
        function applyLanguage(language) {
            document.documentElement.setAttribute('lang', language);
            localStorage.setItem('language', language);
            
            // Recargar la página para aplicar las traducciones
            window.location.reload();
        }

        // Inicializar al cargar la página
        document.addEventListener('DOMContentLoaded', function() {
            // Aplicar tema guardado
            const savedTheme = localStorage.getItem('theme') || '{{ session('theme', 'light') }}';
            applyTheme(savedTheme);
            
            // Aplicar idioma guardado
            const savedLanguage = localStorage.getItem('language') || '{{ session('language', 'es') }}';
            if (savedLanguage !== '{{ session('language', 'es') }}') {
                applyLanguage(savedLanguage);
            }
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
    </script>
    
    @yield('scripts')
</body>
</html>