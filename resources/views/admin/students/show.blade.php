<!DOCTYPE html>
<html lang="{{ session('language', 'es') }}" data-theme="{{ session('theme', 'light') }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Alumno - Sistema Escolar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #1e3a8a;
            --primary-light: #3b82f6;
            --primary-dark: #1e40af;
            --secondary-color: #64748b;
            --success-color: #059669;
            --warning-color: #d97706;
            --danger-color: #dc2626;
            --info-color: #0891b2;
            --light-bg: #f1f5f9;
            --card-bg: #ffffff;
            --text-primary: #0f172a;
            --text-secondary: #475569;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
            --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --card-hover-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            --sidebar-width: 280px;
            --border-radius: 16px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
            color: var(--text-primary);
            line-height: 1.6;
            font-weight: 400;
            overflow-x: hidden;
            min-height: 100vh;
        }

        /* Sidebar Profesional - Azul Oscuro Mejorado */
        .sidebar {
            width: var(--sidebar-width);
            background: linear-gradient(180deg, var(--primary-color) 0%, #1e1b4b 100%);
            color: white;
            height: 100vh;
            position: fixed;
            transition: var(--transition);
            z-index: 1000;
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.1);
            overflow-y: auto;
            border-right: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            flex-direction: column;
        }

        .sidebar-header {
            padding: 2rem 1.5rem 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.15);
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.05) 100%);
            backdrop-filter: blur(10px);
        }

        .sidebar-header h3 {
            font-weight: 700;
            font-size: 1.5rem;
            letter-spacing: -0.025em;
            margin-bottom: 0.25rem;
        }

        .sidebar-header small {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.8rem;
        }

        .sidebar-menu {
            padding: 1.5rem 0;
            flex: 1;
        }

        .sidebar-menu .nav-link {
            color: rgba(255, 255, 255, 0.85);
            padding: 1rem 1.5rem;
            margin: 0.25rem 1rem;
            border-radius: 12px;
            transition: var(--transition);
            font-weight: 500;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        .sidebar-menu .nav-link::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 4px;
            background: linear-gradient(180deg, #60a5fa 0%, #3b82f6 100%);
            transform: translateX(-100%);
            transition: var(--transition);
        }

        .sidebar-menu .nav-link:hover, 
        .sidebar-menu .nav-link.active {
            color: white;
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.2) 0%, rgba(37, 99, 235, 0.1) 100%);
            transform: translateX(8px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .sidebar-menu .nav-link:hover::before,
        .sidebar-menu .nav-link.active::before {
            transform: translateX(0);
        }

        .sidebar-menu .nav-link i {
            margin-right: 0.75rem;
            font-size: 1.25rem;
            width: 24px;
            text-align: center;
            transition: var(--transition);
        }

        .sidebar-menu .nav-link:hover i,
        .sidebar-menu .nav-link.active i {
            transform: scale(1.1);
            color: #60a5fa;
        }

        /* Perfil de Usuario en la parte inferior del sidebar */
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
            padding: 2rem;
            transition: var(--transition);
            min-height: 100vh;
        }

        /* Dashboard Header Profesional - Azul Oscuro Mejorado */
        .dashboard-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, #1e40af 100%);
            color: white;
            border-radius: var(--border-radius);
            padding: 2.5rem 2rem;
            margin-bottom: 2.5rem;
            box-shadow: var(--card-hover-shadow);
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .dashboard-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, rgba(255,255,255,0) 70%);
            border-radius: 50%;
        }

        .dashboard-header::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -10%;
            width: 200px;
            height: 200px;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 70%);
            border-radius: 50%;
        }

        .dashboard-header h1 {
            font-weight: 700;
            font-size: 2.25rem;
            letter-spacing: -0.025em;
            margin-bottom: 0.75rem;
            position: relative;
            z-index: 2;
        }

        .dashboard-header .breadcrumb {
            background: rgba(255, 255, 255, 0.15);
            border-radius: 20px;
            padding: 0.75rem 1.25rem;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            position: relative;
            z-index: 2;
        }

        .dashboard-header .breadcrumb-item a {
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            transition: var(--transition);
            font-weight: 500;
        }

        .dashboard-header .breadcrumb-item a:hover {
            color: white;
            transform: translateY(-1px);
        }

        /* Botones Mejorados */
        .btn {
            border-radius: 12px;
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            border: none;
            position: relative;
            overflow: hidden;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: var(--transition);
        }

        .btn:hover::before {
            left: 100%;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-light) 0%, var(--primary-color) 100%);
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.6);
        }

        .btn-success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.6);
        }

        .btn-warning {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            box-shadow: 0 4px 15px rgba(245, 158, 11, 0.4);
        }

        .btn-warning:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(245, 158, 11, 0.6);
        }

        .btn-danger {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.4);
        }

        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(239, 68, 68, 0.6);
        }

        .btn-info {
            background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
            box-shadow: 0 4px 15px rgba(6, 182, 212, 0.4);
        }

        .btn-info:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(6, 182, 212, 0.6);
        }

        .btn-outline-primary {
            background: transparent;
            border: 2px solid var(--primary-light);
            color: var(--primary-light);
            box-shadow: 0 2px 8px rgba(59, 130, 246, 0.2);
        }

        .btn-outline-primary:hover {
            background: var(--primary-light);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4);
        }

        .btn-outline-secondary {
            background: transparent;
            border: 2px solid var(--secondary-color);
            color: var(--secondary-color);
            box-shadow: 0 2px 8px rgba(100, 116, 139, 0.2);
        }

        .btn-outline-secondary:hover {
            background: var(--secondary-color);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(100, 116, 139, 0.4);
        }

        /* Tarjetas Mejoradas */
        .card-glass {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            transition: var(--transition);
            overflow: hidden;
        }

        .card-glass:hover {
            transform: translateY(-5px);
            box-shadow: var(--card-hover-shadow);
            border-color: rgba(59, 130, 246, 0.2);
        }

        .card-header-glass {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            border-radius: var(--border-radius) var(--border-radius) 0 0 !important;
            color: white;
            padding: 1.5rem 2rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        .card-header-glass h5 {
            font-weight: 600;
            margin-bottom: 0;
            font-size: 1.25rem;
        }

        .card-body {
            padding: 2rem;
        }

        /* Stats Grid Mejorado */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 1rem;
            margin-top: 2rem;
        }

        .stat-item {
            text-align: center;
            padding: 1.25rem;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            border-radius: 12px;
            border: 2px solid rgba(255, 255, 255, 0.5);
            transition: var(--transition);
        }

        .stat-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .stat-icon {
            font-size: 1.5rem;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }

        .stat-number {
            display: block;
            font-weight: 700;
            color: var(--text-primary);
            font-size: 1rem;
        }

        .stat-label {
            color: var(--text-muted);
            font-size: 0.8rem;
            font-weight: 500;
        }

        /* Quick Actions Mejorado */
        .quick-actions {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .quick-action-item {
            display: flex;
            align-items: center;
            padding: 1rem;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            border-radius: 12px;
            text-decoration: none;
            color: inherit;
            transition: var(--transition);
            border: 2px solid rgba(255, 255, 255, 0.5);
            position: relative;
            overflow: hidden;
        }

        .quick-action-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(59, 130, 246, 0.1), transparent);
            transition: var(--transition);
        }

        .quick-action-item:hover {
            transform: translateX(8px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
            text-decoration: none;
            color: inherit;
        }

        .quick-action-item:hover::before {
            left: 100%;
        }

        .action-icon {
            width: 45px;
            height: 45px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            margin-right: 1rem;
            font-size: 1.1rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .action-text span {
            display: block;
            font-weight: 600;
            color: var(--text-primary);
            font-size: 0.95rem;
        }

        .action-text small {
            color: var(--text-muted);
            font-size: 0.8rem;
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
                font-size: 1.5rem; 
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
                padding: 1rem; 
            }
            .sidebar { 
                transform: translateX(-100%); 
            }
            .sidebar.active { 
                transform: translateX(0); 
            }
            .stats-grid { 
                grid-template-columns: 1fr; 
            }
            .dashboard-header {
                padding: 1.5rem;
            }
            .dashboard-header h1 {
                font-size: 1.75rem;
            }
        }

        /* Animaciones */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card-glass {
            animation: fadeInUp 0.6s ease-out;
        }

        /* Mejoras para el sidebar del perfil */
        .profile-sidebar .card-body {
            padding: 2rem;
        }

        .profile-sidebar .avatar-profile-lg {
            width: 100px;
            height: 100px;
            margin-bottom: 1.5rem;
            border: 4px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .profile-sidebar .btn-sm {
            font-size: 0.85rem;
            padding: 0.6rem 1rem;
            border-radius: 10px;
        }

        .bg-primary-gradient {
            background: linear-gradient(135deg, var(--primary-light) 0%, var(--primary-color) 100%) !important;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);
        }

        .fs-7 {
            font-size: 0.9rem !important;
        }

        .fs-8 {
            font-size: 0.8rem !important;
        }

        /* Alertas Mejoradas */
        .alert-glass {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            border-left: 5px solid var(--danger-color);
        }

        /* Badges Mejorados */
        .badge {
            font-weight: 600;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.8rem;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .bg-primary {
            background: linear-gradient(135deg, var(--primary-light) 0%, var(--primary-color) 100%) !important;
        }

        .bg-success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
        }

        .bg-warning {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%) !important;
        }

        .bg-danger {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important;
        }

        .bg-info {
            background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%) !important;
        }

        .avatar-placeholder-lg {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-light) 0%, var(--primary-color) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2.5rem;
        }

        .date-indicator {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            padding: 0.5rem 1rem;
            border: 1px solid rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            font-weight: 500;
        }

        .table-responsive {
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--card-shadow);
        }

        .table th {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: white;
            font-weight: 600;
            border: none;
            padding: 1rem;
        }

        .table td {
            padding: 1rem;
            border-color: var(--border-color);
            vertical-align: middle;
        }

        .info-item {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }

        .info-item:last-child {
            margin-bottom: 0;
        }

        /* Nuevos estilos para información detallada */
        .info-card {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            border-radius: 12px;
            padding: 1.5rem;
            border: 2px solid rgba(255, 255, 255, 0.5);
            transition: var(--transition);
        }

        .info-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .info-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            margin-bottom: 1rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .info-content h6 {
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
        }

        .info-content p {
            color: var(--text-secondary);
            margin-bottom: 0;
            font-size: 0.9rem;
        }

        .attendance-status {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 25px;
            font-weight: 600;
            font-size: 0.85rem;
        }

        .progress-container {
            background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
            border-radius: 10px;
            padding: 1.5rem;
            border: 2px solid rgba(255, 255, 255, 0.5);
        }

        .progress-label {
            display: flex;
            justify-content: between;
            align-items: center;
            margin-bottom: 0.5rem;
        }

        .progress-label span {
            font-weight: 600;
            color: var(--text-primary);
        }

        .progress-label small {
            color: var(--text-muted);
            font-weight: 500;
        }

        .attendance-chart {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            border-radius: 12px;
            padding: 1.5rem;
            border: 2px solid rgba(255, 255, 255, 0.5);
        }

        .chart-bar {
            height: 8px;
            border-radius: 4px;
            margin: 0.5rem 0;
            position: relative;
            overflow: hidden;
        }

        .chart-bar-fill {
            height: 100%;
            border-radius: 4px;
            transition: all 0.8s ease-in-out;
        }

        .chart-label {
            display: flex;
            justify-content: between;
            align-items: center;
            font-size: 0.85rem;
            margin-bottom: 0.25rem;
        }

        .chart-label span {
            font-weight: 600;
        }

        .chart-label small {
            color: var(--text-muted);
        }

        /* Estilos para la tabla mejorada */
        .attendance-table tbody tr {
            transition: var(--transition);
        }

        .attendance-table tbody tr:hover {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            transform: translateX(5px);
        }

        .status-indicator {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 0.5rem;
        }

        .status-present { background: var(--success-color); }
        .status-absent { background: var(--danger-color); }
        .status-late { background: var(--warning-color); }
        .status-justified { background: var(--info-color); }
        .status-unknown { background: var(--secondary-color); }

        .day-indicator {
            font-size: 0.75rem;
            color: var(--text-muted);
            margin-left: 0.5rem;
        }

        .observations-cell {
            max-width: 200px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
    </style>
</head>
<body>
    <!-- Sidebar Profesional - Azul Oscuro Mejorado -->
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

    <!-- Main Content -->
    <div class="main-content">
        <!-- Dashboard Header Profesional - Azul Oscuro Mejorado -->
        <div class="dashboard-header">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="h2 fw-bold mb-2">
                        <i class="bi bi-person-badge me-3"></i>Detalles del Alumno
                    </h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}" class="text-white-50">
                                    <i class="bi bi-house-door me-1"></i>Inicio
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('students.index') }}" class="text-white-50">
                                    <i class="bi bi-people me-1"></i>Estudiantes
                                </a>
                            </li>
                            <li class="breadcrumb-item active text-white" aria-current="page">
                                <i class="bi bi-person-badge me-1"></i>Detalles
                            </li>
                        </ol>
                    </nav>
                </div>
                <div class="col-md-4 text-md-end">
                    <div class="d-flex align-items-center justify-content-end gap-2">
                        <span class="date-indicator">
                            <i class="bi bi-calendar3 me-2"></i>
                            Hoy: {{ date('d/m/Y') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-xl-8">
                    <!-- Información Principal del Estudiante -->
                    <div class="card card-glass mb-4">
                        <div class="card-header card-header-glass">
                            <h5 class="card-title mb-0">
                                <i class="bi bi-info-circle me-2"></i>Información Personal del Estudiante
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!-- Información Básica -->
                                <div class="col-md-6 mb-4">
                                    <div class="info-card h-100">
                                        <div class="info-icon bg-primary text-white">
                                            <i class="bi bi-person-vcard"></i>
                                        </div>
                                        <div class="info-content">
                                            <h6>Información Básica</h6>
                                            <div class="mb-2">
                                                <small class="text-muted">DNI:</small>
                                                <p class="fw-bold mb-1">{{ $student->dni }}</p>
                                            </div>
                                            <div class="mb-2">
                                                <small class="text-muted">Nombre Completo:</small>
                                                <p class="fw-bold mb-1">{{ $student->first_name }} {{ $student->last_name }}</p>
                                            </div>
                                            <div>
                                                <small class="text-muted">Estado:</small>
                                                <span class="badge bg-success">Activo</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Información de Contacto -->
                                <div class="col-md-6 mb-4">
                                    <div class="info-card h-100">
                                        <div class="info-icon bg-success text-white">
                                            <i class="bi bi-telephone"></i>
                                        </div>
                                        <div class="info-content">
                                            <h6>Contacto</h6>
                                            <div class="mb-2">
                                                <small class="text-muted">Teléfono del Apoderado:</small>
                                                <p class="fw-bold mb-1">
                                                    <i class="bi bi-whatsapp text-success me-1"></i>
                                                    {{ $student->guardian_phone }}
                                                </p>
                                            </div>
                                            <div>
                                                <small class="text-muted">Última Actualización:</small>
                                                @php
                                                    $updatedAt = is_string($student->updated_at) 
                                                        ? \Carbon\Carbon::parse($student->updated_at)
                                                        : $student->updated_at;
                                                @endphp
                                                <p class="fw-bold mb-0">{{ $updatedAt->format('d/m/Y H:i') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Información Académica -->
                                <!-- En la sección de Información Académica, agregar el turno -->
                                <div class="col-md-6 mb-4">
                                    <div class="info-card h-100">
                                        <div class="info-icon bg-info text-white">
                                            <i class="bi bi-mortarboard"></i>
                                        </div>
                                        <div class="info-content">
                                            <h6>Información Académica</h6>
                                            <div class="mb-2">
                                                <small class="text-muted">Grado:</small>
                                                <p class="fw-bold mb-1">{{ $student->grade->name ?? 'N/A' }}° Grado</p>
                                            </div>
                                            <div class="mb-2">
                                                <small class="text-muted">Sección:</small>
                                                <p class="fw-bold mb-1">Sección {{ $student->classroom->name ?? 'N/A' }}</p>
                                            </div>
                                            <div class="mb-2">
                                                <small class="text-muted">Turno:</small>
                                                <p class="fw-bold mb-1">
                                                    @if($student->shift == 'morning')
                                                        <span class="badge bg-info">
                                                            <i class="bi bi-sun me-1"></i>Turno Mañana
                                                        </span>
                                                    @else
                                                        <span class="badge bg-warning">
                                                            <i class="bi bi-moon me-1"></i>Turno Tarde
                                                        </span>
                                                    @endif
                                                </p>
                                            </div>
                                            <div>
                                                <small class="text-muted">Aula:</small>
                                                <p class="fw-bold mb-0">Aula {{ $student->classroom->room_number ?? 'N/A' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Información del Sistema -->
                                <div class="col-md-6 mb-4">
                                    <div class="info-card h-100">
                                        <div class="info-icon bg-warning text-white">
                                            <i class="bi bi-calendar-check"></i>
                                        </div>
                                        <div class="info-content">
                                            <h6>Información del Sistema</h6>
                                            <div class="mb-2">
                                                <small class="text-muted">Fecha de Registro:</small>
                                                @php
                                                    $createdAt = is_string($student->created_at) 
                                                        ? \Carbon\Carbon::parse($student->created_at)
                                                        : $student->created_at;
                                                @endphp
                                                <p class="fw-bold mb-1">{{ $createdAt->format('d/m/Y H:i') }}</p>
                                            </div>
                                            <div>
                                                <small class="text-muted">Código de Barras:</small>
                                                <div class="d-flex align-items-center gap-2 mt-1">
                                                    @if($student->barcode)
                                                        <span class="badge bg-success">Generado</span>
                                                        <a href="{{ route('students.photocheck', $student->dni) }}" 
                                                           class="btn btn-sm btn-outline-primary py-1">
                                                            <i class="bi bi-eye me-1"></i>Ver
                                                        </a>
                                                    @else
                                                        <span class="badge bg-secondary">No generado</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Historial de Asistencia Simplificado -->
                    <div class="card card-glass">
                        <div class="card-header card-header-glass d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">
                                <i class="bi bi-calendar-check me-2"></i>Historial de Asistencia
                            </h5>
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge bg-light text-dark">
                                    <i class="bi bi-clock me-1"></i>
                                    Últimos 30 días
                                </span>
                            </div>
                        </div>
                        <div class="card-body">
                            @if($student->attendances && $student->attendances->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover attendance-table">
                                        <thead>
                                            <tr>
                                                <th>Fecha</th>
                                                <th>Día</th>
                                                <th>Estado</th>
                                                <th>Observaciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($student->attendances->take(15) as $attendance)
                                                @php
                                                    // Convertir fechas a objetos Carbon si son strings
                                                    $date = is_string($attendance->date) 
                                                        ? \Carbon\Carbon::parse($attendance->date)
                                                        : $attendance->date;
                                                    
                                                    // Determinar el día de la semana en español
                                                    $days = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
                                                    $dayName = $days[$date->dayOfWeek];
                                                @endphp
                                                <tr>
                                                    <td>
                                                        <span class="fw-bold">{{ $date->format('d/m/Y') }}</span>
                                                    </td>
                                                    <td>
                                                        <span class="text-muted">{{ $dayName }}</span>
                                                    </td>
                                                    <td>
                                                        @if($attendance->status == 'present')
                                                            <span class="attendance-status bg-success bg-opacity-10 text-success">
                                                                <span class="status-indicator status-present"></span>
                                                                Presente
                                                            </span>
                                                        @elseif($attendance->status == 'absent')
                                                            <span class="attendance-status bg-danger bg-opacity-10 text-danger">
                                                                <span class="status-indicator status-absent"></span>
                                                                Falta
                                                            </span>
                                                        @elseif($attendance->status == 'late')
                                                            <span class="attendance-status bg-warning bg-opacity-10 text-warning">
                                                                <span class="status-indicator status-late"></span>
                                                                Tardanza
                                                            </span>
                                                        @elseif($attendance->status == 'justified')
                                                            <span class="attendance-status bg-info bg-opacity-10 text-info">
                                                                <span class="status-indicator status-justified"></span>
                                                                Justificación
                                                            </span>
                                                        @else
                                                            <span class="attendance-status bg-secondary bg-opacity-10 text-secondary">
                                                                <span class="status-indicator status-unknown"></span>
                                                                Sin registro
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td class="observations-cell">
                                                        <small class="text-muted">
                                                            @if($attendance->notes)
                                                                {{ Str::limit($attendance->notes, 40) }}
                                                            @else
                                                                -
                                                            @endif
                                                        </small>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                
                                @if($student->attendances->count() > 15)
                                    <div class="text-center mt-4">
                                        <a href="#" class="btn btn-outline-primary">
                                            <i class="bi bi-eye me-1"></i>Ver historial completo
                                        </a>
                                    </div>
                                @endif
                            @else
                                <div class="text-center py-5">
                                    <i class="bi bi-calendar-x text-muted fs-1"></i>
                                    <h5 class="text-muted mt-3">No hay registros de asistencia</h5>
                                    <p class="text-muted mb-4">Este estudiante no tiene registros de asistencia en el sistema.</p>
                                    <a href="{{ route('students.attendance') }}" class="btn btn-primary">
                                        <i class="bi bi-clipboard-check me-1"></i>Tomar Asistencia
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Sidebar de información mejorado -->
                <div class="col-xl-4">
                    <!-- Tarjeta de perfil mejorada -->
                    <div class="card card-glass profile-sidebar mb-4">
                        <div class="card-header card-header-glass text-center py-3">
                            <h5 class="card-title mb-0 text-white fs-6">
                                <i class="bi bi-person-badge me-2"></i>Perfil del Estudiante
                            </h5>
                        </div>
                        <div class="card-body text-center px-3 py-4">
                            <div class="avatar-profile-lg mb-3 mx-auto">
                                @if($student->photo)
                                    <img src="{{ Storage::url('public/' . $student->photo) }}" 
                                         alt="{{ $student->first_name }} {{ $student->last_name }}"
                                         class="rounded-circle w-100 h-100 object-fit-cover">
                                @else
                                    <div class="avatar-placeholder-lg">
                                        <i class="bi bi-person-fill"></i>
                                    </div>
                                @endif
                            </div>
                            <h5 class="text-dark mb-2 fs-6 fw-semibold">{{ $student->first_name }} {{ $student->last_name }}</h5>
                            <p class="text-muted mb-3 fs-7">DNI: {{ $student->dni }}</p>
                            <div class="badge bg-primary-gradient mb-3 fs-7 px-3 py-2">
                                {{ $student->grade->name ?? 'N/A' }}° Grado - Sección {{ $student->classroom->name ?? 'N/A' }}
                            </div>
                            
                            <div class="stats-grid mt-4">
                                <div class="stat-item">
                                    <i class="bi bi-calendar-check stat-icon"></i>
                                    <span class="stat-number">{{ $createdAt->format('d/m/Y') }}</span>
                                    <small class="stat-label">Registrado</small>
                                </div>
                                <div class="stat-item">
                                    <i class="bi bi-telephone stat-icon"></i>
                                    <span class="stat-number">{{ substr($student->guardian_phone, 0, 6) }}...</span>
                                    <small class="stat-label">Contacto</small>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer card-footer-glass pt-3">
                            <div class="d-grid gap-2">
                                <a href="{{ route('students.photocheck', $student->dni) }}" 
                                   class="btn btn-outline-info btn-sm py-2" target="_blank">
                                    <i class="bi bi-printer me-2"></i>Imprimir Fotocheck
                                </a>
                                <a href="{{ route('students.edit', $student->dni) }}" 
                                   class="btn btn-outline-primary btn-sm py-2">
                                    <i class="bi bi-pencil me-2"></i>Editar Información
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Estadísticas de Asistencia Mejoradas -->
                    <div class="card card-glass mb-4">
                        <div class="card-header card-header-glass py-3">
                            <h5 class="card-title mb-0 fs-6">
                                <i class="bi bi-graph-up me-2"></i>Estadísticas de Asistencia
                            </h5>
                        </div>
                        <div class="card-body">
                            @if($student->attendances && $student->attendances->count() > 0)
                                @php
                                    $total = $student->attendances->count();
                                    $present = $student->attendances->where('status', 'present')->count();
                                    $absent = $student->attendances->where('status', 'absent')->count();
                                    $late = $student->attendances->where('status', 'late')->count();
                                    $justified = $student->attendances->where('status', 'justified')->count();
                                    
                                    $presentPercentage = $total > 0 ? round(($present / $total) * 100) : 0;
                                    $absentPercentage = $total > 0 ? round(($absent / $total) * 100) : 0;
                                    $latePercentage = $total > 0 ? round(($late / $total) * 100) : 0;
                                    $justifiedPercentage = $total > 0 ? round(($justified / $total) * 100) : 0;
                                @endphp
                                
                                <div class="progress-container mb-4">
                                    <div class="progress-label">
                                        <span>Asistencia General</span>
                                        <small>{{ $presentPercentage }}%</small>
                                    </div>
                                    <div class="progress" style="height: 12px;">
                                        <div class="progress-bar bg-success" style="width: {{ $presentPercentage }}%"></div>
                                    </div>
                                    <small class="text-muted">{{ $present }} de {{ $total }} días</small>
                                </div>

                                <div class="attendance-chart">
                                    <div class="chart-label">
                                        <span>Presente</span>
                                        <small>{{ $present }} días ({{ $presentPercentage }}%)</small>
                                    </div>
                                    <div class="chart-bar bg-light">
                                        <div class="chart-bar-fill bg-success" style="width: {{ $presentPercentage }}%"></div>
                                    </div>

                                    <div class="chart-label mt-3">
                                        <span>Tardanza</span>
                                        <small>{{ $late }} días ({{ $latePercentage }}%)</small>
                                    </div>
                                    <div class="chart-bar bg-light">
                                        <div class="chart-bar-fill bg-warning" style="width: {{ $latePercentage }}%"></div>
                                    </div>

                                    <div class="chart-label mt-3">
                                        <span>Falta</span>
                                        <small>{{ $absent }} días ({{ $absentPercentage }}%)</small>
                                    </div>
                                    <div class="chart-bar bg-light">
                                        <div class="chart-bar-fill bg-danger" style="width: {{ $absentPercentage }}%"></div>
                                    </div>

                                    <div class="chart-label mt-3">
                                        <span>Justificación</span>
                                        <small>{{ $justified }} días ({{ $justifiedPercentage }}%)</small>
                                    </div>
                                    <div class="chart-bar bg-light">
                                        <div class="chart-bar-fill bg-info" style="width: {{ $justifiedPercentage }}%"></div>
                                    </div>
                                </div>

                                <div class="row text-center mt-4">
                                    <div class="col-3">
                                        <div class="text-success">
                                            <div class="fs-4 fw-bold">{{ $present }}</div>
                                            <small class="text-muted">Presente</small>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="text-warning">
                                            <div class="fs-4 fw-bold">{{ $late }}</div>
                                            <small class="text-muted">Tardanza</small>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="text-danger">
                                            <div class="fs-4 fw-bold">{{ $absent }}</div>
                                            <small class="text-muted">Falta</small>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="text-info">
                                            <div class="fs-4 fw-bold">{{ $justified }}</div>
                                            <small class="text-muted">Justificación</small>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="text-center py-3">
                                    <i class="bi bi-bar-chart text-muted fs-1"></i>
                                    <p class="text-muted mt-2 mb-0">No hay datos de asistencia</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Acciones Rápidas Mejoradas -->
                    <div class="card card-glass">
                        <div class="card-header card-header-glass py-3">
                            <h5 class="card-title mb-0 fs-6">
                                <i class="bi bi-lightning-charge me-2"></i>Acciones Rápidas
                            </h5>
                        </div>
                        <div class="card-body py-3">
                            <div class="quick-actions">
                                <a href="{{ route('students.edit', $student->dni) }}" class="quick-action-item py-2">
                                    <div class="action-icon bg-primary">
                                        <i class="bi bi-pencil"></i>
                                    </div>
                                    <div class="action-text">
                                        <span class="fs-7">Editar Estudiante</span>
                                        <small class="fs-8">Modificar información personal</small>
                                    </div>
                                </a>
                                <a href="{{ route('students.photocheck', $student->dni) }}" class="quick-action-item py-2" target="_blank">
                                    <div class="action-icon bg-info">
                                        <i class="bi bi-printer"></i>
                                    </div>
                                    <div class="action-text">
                                        <span class="fs-7">Imprimir Fotocheck</span>
                                        <small class="fs-8">Generar credencial estudiantil</small>
                                    </div>
                                </a>
                                <a href="{{ route('students.attendance') }}" class="quick-action-item py-2">
                                    <div class="action-icon bg-success">
                                        <i class="bi bi-clipboard-check"></i>
                                    </div>
                                    <div class="action-text">
                                        <span class="fs-7">Tomar Asistencia</span>
                                        <small class="fs-8">Registrar asistencia hoy</small>
                                    </div>
                                </a>
                                <a href="{{ route('students.index') }}" class="quick-action-item py-2">
                                    <div class="action-icon bg-secondary">
                                        <i class="bi bi-arrow-left"></i>
                                    </div>
                                    <div class="action-text">
                                        <span class="fs-7">Volver al Listado</span>
                                        <small class="fs-8">Ver todos los estudiantes</small>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Animación para las barras de progreso
        const progressBars = document.querySelectorAll('.chart-bar-fill');
        progressBars.forEach(bar => {
            const width = bar.style.width;
            bar.style.width = '0%';
            setTimeout(() => {
                bar.style.width = width;
            }, 300);
        });

        // Tooltips para elementos interactivos
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Confirmación antes de acciones importantes
        const deleteButtons = document.querySelectorAll('.btn-danger');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                if (!confirm('¿Está seguro de que desea realizar esta acción? Esta acción no se puede deshacer.')) {
                    e.preventDefault();
                }
            });
        });

        // Efecto hover mejorado para las tarjetas de información
        const infoCards = document.querySelectorAll('.info-card');
        infoCards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px) scale(1.02)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });

        // Resaltar filas de la tabla al pasar el mouse
        const tableRows = document.querySelectorAll('.attendance-table tbody tr');
        tableRows.forEach(row => {
            row.addEventListener('mouseenter', function() {
                this.style.backgroundColor = 'rgba(59, 130, 246, 0.05)';
            });
            
            row.addEventListener('mouseleave', function() {
                this.style.backgroundColor = '';
            });
        });

        console.log('Sistema de detalles del estudiante cargado correctamente');
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
</body>
</html>