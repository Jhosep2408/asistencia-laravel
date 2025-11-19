<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Alumno - Sistema Escolar</title>
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

        /* Input Groups Mejorados */
        .input-group-glass {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            transition: var(--transition);
        }

        .input-group-glass:focus-within {
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
            transform: translateY(-2px);
        }

        .input-group-glass .input-group-text {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            border: 2px solid #e2e8f0;
            border-right: none;
            color: var(--primary-color);
            font-weight: 600;
        }

        .input-group-glass .form-control {
            border: 2px solid #e2e8f0;
            border-left: none;
            background: rgba(255, 255, 255, 0.9);
            font-weight: 500;
            transition: var(--transition);
        }

        .input-group-glass .form-control:focus {
            background: white;
            box-shadow: none;
            border-color: var(--primary-light);
        }

        /* File Upload Mejorado */
        .file-upload-container {
            margin-bottom: 1.5rem;
        }

        .file-upload-area {
            border: 3px dashed #cbd5e1;
            border-radius: 16px;
            padding: 3rem 2rem;
            text-align: center;
            cursor: pointer;
            transition: var(--transition);
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            position: relative;
            overflow: hidden;
        }

        .file-upload-area::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(37, 99, 235, 0.05) 100%);
            opacity: 0;
            transition: var(--transition);
        }

        .file-upload-area:hover {
            border-color: var(--primary-light);
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .file-upload-area:hover::before {
            opacity: 1;
        }

        .file-upload-area.dragover {
            border-color: var(--primary-color);
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.2) 0%, rgba(37, 99, 235, 0.1) 100%);
        }

        .file-upload-icon {
            font-size: 3rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
            transition: var(--transition);
        }

        .file-upload-area:hover .file-upload-icon {
            transform: scale(1.1);
            color: var(--primary-light);
        }

        .file-upload-text span {
            color: var(--text-primary);
            font-weight: 600;
            font-size: 1.1rem;
        }

        .file-upload-text small {
            color: var(--text-muted);
            font-size: 0.9rem;
        }

        .file-preview {
            animation: slideInUp 0.4s ease-out;
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .preview-content {
            border-left: 5px solid var(--success-color);
            background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
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

        /* Stats Grid Mejorado */
        .stats-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
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

        /* Etiquetas requeridas */
        .label-required::after {
            content: " *";
            color: var(--danger-color);
            font-weight: bold;
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

        /* Form Labels Mejorados */
        .form-label {
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.75rem;
            font-size: 0.95rem;
        }

        /* Progress Bars Mejorados */
        .progress {
            height: 10px;
            border-radius: 10px;
            background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .progress-bar {
            border-radius: 10px;
            background: linear-gradient(135deg, var(--primary-light) 0%, var(--primary-color) 100%);
            box-shadow: 0 2px 8px rgba(59, 130, 246, 0.4);
        }
          .date-indicator {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            padding: 0.5rem 1rem;
            border: 1px solid rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            font-weight: 500;
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
                    <a class="nav-link active" href="{{ route('students.index') }}">
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
                <button class="user-profile-bottom-btn" id="profileButton">
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
                        <i class="bi bi-pencil-square me-3"></i>Editar Alumno
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
                                <i class="bi bi-pencil-square me-1"></i>Editar
                            </li>
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

        <!-- Contenido existente -->
        <div class="container-fluid py-4">
            @if($grades->isEmpty())
            <div class="alert alert-danger alert-glass">
                <div class="d-flex align-items-center">
                    <i class="bi bi-exclamation-triangle-fill me-3 fs-4"></i>
                    <div>
                        <h5 class="alert-heading mb-1">Configuración requerida</h5>
                        <p class="mb-0">No hay grados configurados en el sistema. Contacta al administrador.</p>
                    </div>
                </div>
            </div>
            @else
            <div class="row">
                <div class="col-xl-8">
                    <div class="card card-glass">
                        <div class="card-header card-header-glass">
                            <h5 class="card-title mb-0">
                                <i class="bi bi-clipboard-data me-2"></i>Información del Estudiante
                            </h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('students.update', $student->dni) }}" enctype="multipart/form-data" id="studentForm">
                                @csrf
                                @method('PUT')

                                <!-- DNI (no editable) -->
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label for="dni" class="form-label label-required">DNI</label>
                                        <div class="input-group input-group-glass">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="bi bi-credit-card text-primary"></i>
                                            </span>
                                            <input type="text" class="form-control ps-0" 
                                                   id="dni" value="{{ $student->dni }}" readonly>
                                        </div>
                                        <small class="text-muted mt-1">Identificador único - No editable</small>
                                    </div>
                                </div>

                                <!-- Nombres y Apellidos -->
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label for="first_name" class="form-label label-required">Nombres</label>
                                        <div class="input-group input-group-glass">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="bi bi-person text-primary"></i>
                                            </span>
                                            <input type="text" class="form-control @error('first_name') is-invalid @enderror ps-0" 
                                                   id="first_name" name="first_name" 
                                                   value="{{ old('first_name', $student->first_name) }}" 
                                                   placeholder="Ingrese los nombres" required>
                                        </div>
                                        @error('first_name')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="last_name" class="form-label label-required">Apellidos</label>
                                        <div class="input-group input-group-glass">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="bi bi-person text-primary"></i>
                                            </span>
                                            <input type="text" class="form-control @error('last_name') is-invalid @enderror ps-0" 
                                                   id="last_name" name="last_name" 
                                                   value="{{ old('last_name', $student->last_name) }}" 
                                                   placeholder="Ingrese los apellidos" required>
                                        </div>
                                        @error('last_name')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Teléfono y Foto -->
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label for="guardian_phone" class="form-label label-required">Teléfono del Apoderado</label>
                                        <div class="input-group input-group-glass">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="bi bi-phone text-primary"></i>
                                            </span>
                                            <input type="text" class="form-control @error('guardian_phone') is-invalid @enderror ps-0" 
                                                   id="guardian_phone" name="guardian_phone" 
                                                   value="{{ old('guardian_phone', $student->guardian_phone) }}" 
                                                   placeholder="Ej: 987654321" required>
                                        </div>
                                        <small class="text-muted mt-1">
                                            <i class="bi bi-whatsapp text-success me-1"></i>Para alertas por WhatsApp
                                        </small>
                                        @error('guardian_phone')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="photo" class="form-label">Fotografía</label>
                                        
                                        <!-- Input de archivo mejorado -->
                                        <div class="file-upload-container">
                                            <div class="file-upload-area" id="fileUploadArea">
                                                <div class="file-upload-icon">
                                                    <i class="bi bi-cloud-arrow-up"></i>
                                                </div>
                                                <div class="file-upload-text">
                                                    <span class="d-block fw-semibold">Haz clic para subir una foto</span>
                                                    <small class="text-muted">PNG, JPG hasta 2MB</small>
                                                </div>
                                                <input type="file" class="form-control d-none" 
                                                       id="photo" name="photo" accept="image/*">
                                            </div>
                                            <div class="file-preview mt-3" id="filePreview" style="display: none;">
                                                <div class="preview-header d-flex justify-content-between align-items-center mb-2">
                                                    <span class="text-success fw-semibold">
                                                        <i class="bi bi-check-circle-fill me-1"></i>Archivo seleccionado
                                                    </span>
                                                    <button type="button" class="btn-close btn-close-sm" id="clearFile"></button>
                                                </div>
                                                <div class="preview-content d-flex align-items-center bg-light rounded p-3">
                                                    <div class="file-icon me-3">
                                                        <i class="bi bi-file-image text-primary fs-4"></i>
                                                    </div>
                                                    <div class="file-info">
                                                        <span class="file-name d-block fw-medium text-dark" id="fileName"></span>
                                                        <small class="file-size text-muted" id="fileSize"></small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @error('photo')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                        
                                        <!-- Vista previa de foto actual -->
                                        @if($student->photo)
                                            <div class="photo-preview mt-4">
                                                <small class="text-muted d-block mb-2">Foto actual:</small>
                                                <div class="d-flex align-items-center bg-light rounded p-3">
                                                    <div class="avatar-preview me-3">
                                                        <img src="{{ Storage::url('public/' . $student->photo) }}" 
                                                             alt="{{ $student->full_name }}"
                                                             class="rounded">
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <span class="d-block text-dark">{{ basename($student->photo) }}</span>
                                                        <div class="form-check mt-2">
                                                            <input class="form-check-input" type="checkbox" name="remove_photo" id="remove_photo" value="1">
                                                            <label class="form-check-label text-danger small" for="remove_photo">
                                                                <i class="bi bi-trash me-1"></i>Eliminar foto actual
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="mt-3">
                                                <span class="badge bg-light text-muted">
                                                    <i class="bi bi-image me-1"></i>No hay foto registrada
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Grado y Sección -->
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label for="grade_id" class="form-label label-required">Grado</label>
                                        <div class="input-group input-group-glass">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="bi bi-mortarboard text-primary"></i>
                                            </span>
                                            <select class="form-select @error('grade_id') is-invalid @enderror ps-0" 
                                                    id="grade_id" name="grade_id" required>
                                                <option value="">Seleccione un grado</option>
                                                @foreach($grades as $grade)
                                                    <option value="{{ $grade->id }}" 
                                                            {{ old('grade_id', $student->grade_id) == $grade->id ? 'selected' : '' }}
                                                            data-sections='@json($grade->classrooms)'>
                                                        {{ $grade->name }}° Grado
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('grade_id')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="classroom_id" class="form-label label-required">Sección</label>
                                        <div class="input-group input-group-glass">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="bi bi-house-door text-primary"></i>
                                            </span>
                                            <select class="form-select @error('classroom_id') is-invalid @enderror ps-0" 
                                                    id="classroom_id" name="classroom_id" required>
                                                <option value="">Seleccione una sección</option>
                                                @if($student->grade && $student->grade->classrooms)
                                                    @foreach($student->grade->classrooms as $classroom)
                                                        <option value="{{ $classroom->id }}" 
                                                                {{ old('classroom_id', $student->classroom_id) == $classroom->id ? 'selected' : '' }}>
                                                            Sección {{ $classroom->name }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        @error('classroom_id')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <!-- En el formulario de edición, después de la sección de grado/sección -->
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label for="shift" class="form-label label-required">Turno</label>
                                        <div class="input-group input-group-glass">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="bi bi-clock text-primary"></i>
                                            </span>
                                            <select class="form-select @error('shift') is-invalid @enderror ps-0" 
                                                    id="shift" name="shift" required>
                                                <option value="">Seleccione un turno</option>
                                                <option value="morning" {{ old('shift', $student->shift) == 'morning' ? 'selected' : '' }}>Turno Mañana</option>
                                                <option value="afternoon" {{ old('shift', $student->shift) == 'afternoon' ? 'selected' : '' }}>Turno Tarde</option>
                                            </select>
                                        </div>
                                        @error('shift')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Información adicional -->
                                <div class="card info-card-glass mt-4">
                                    <div class="card-body">
                                        <h6 class="card-title text-primary mb-3">
                                            <i class="bi bi-info-circle me-2"></i>Información del Registro
                                        </h6>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="info-item">
                                                    <i class="bi bi-calendar-plus text-success me-2"></i>
                                                    <div>
                                                        <small class="text-muted">Fecha de registro</small>
                                                        <p class="mb-0 fw-semibold">{{ $student->created_at->format('d/m/Y H:i') }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="info-item">
                                                    <i class="bi bi-calendar-check text-warning me-2"></i>
                                                    <div>
                                                        <small class="text-muted">Última actualización</small>
                                                        <p class="mb-0 fw-semibold">{{ $student->updated_at->format('d/m/Y H:i') }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @if($student->barcode)
                                            <div class="info-item mt-3">
                                                <i class="bi bi-upc-scan text-info me-2"></i>
                                                <div>
                                                    <small class="text-muted">Código de barras</small>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <span class="badge bg-info">Generado</span>
                                                        <a href="{{ route('students.photocheck', $student->dni) }}" 
                                                           class="btn btn-sm btn-outline-primary" 
                                                           target="_blank">
                                                            <i class="bi bi-eye me-1"></i>Ver Fotocheck
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Botones de acción -->
                                <div class="d-flex justify-content-between align-items-center mt-5 pt-4 border-top">
                                    <a href="{{ route('students.index') }}" class="btn btn-outline-secondary">
                                        <i class="bi bi-arrow-left me-2"></i>Volver al Listado
                                    </a>
                                    <div class="d-flex gap-3">
                                        <button type="reset" class="btn btn-outline-warning" id="resetForm">
                                            <i class="bi bi-arrow-clockwise me-2"></i>Restablecer
                                        </button>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-check-circle me-2"></i>Actualizar Alumno
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Sidebar de información mejorado -->
                <div class="col-xl-4">
                    <!-- Tarjeta de perfil mejorada -->
                    <div class="card card-glass profile-sidebar">
                        <div class="card-header card-header-glass text-center py-3">
                            <h5 class="card-title mb-0 text-white fs-6">
                                <i class="bi bi-person-badge me-2"></i>Perfil del Estudiante
                            </h5>
                        </div>
                        <div class="card-body text-center px-3 py-4">
                            <div class="avatar-profile-lg mb-3 mx-auto">
                                @if($student->photo)
                                    <img src="{{ Storage::url('public/' . $student->photo) }}" 
                                         alt="{{ $student->full_name }}"
                                         class="rounded-circle">
                                @else
                                    <div class="avatar-placeholder-lg">
                                        <i class="bi bi-person-fill"></i>
                                    </div>
                                @endif
                            </div>
                            <h5 class="text-dark mb-2 fs-6 fw-semibold">{{ $student->full_name }}</h5>
                            <p class="text-muted mb-3 fs-7">DNI: {{ $student->dni }}</p>
                            <div class="badge bg-primary-gradient mb-3 fs-7 px-3 py-2">
                                {{ $student->grade->name ?? 'N/A' }}° Grado - Sección {{ $student->classroom->name ?? 'N/A' }}
                            </div>
                            
                            <div class="stats-grid mt-4">
                                <div class="stat-item">
                                    <i class="bi bi-calendar-check stat-icon"></i>
                                    <span class="stat-number">{{ $student->created_at->format('d/m/Y') }}</span>
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
                                <a href="{{ route('students.show', $student->dni) }}" 
                                   class="btn btn-outline-primary btn-sm py-2">
                                    <i class="bi bi-eye me-2"></i>Ver Detalles
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Tarjeta de acciones rápidas -->
                    <div class="card card-glass mt-4">
                        <div class="card-header card-header-glass py-3">
                            <h5 class="card-title mb-0 fs-6">
                                <i class="bi bi-lightning-charge me-2"></i>Acciones Rápidas
                            </h5>
                        </div>
                        <div class="card-body py-3">
                            <div class="quick-actions">
                                <a href="{{ route('students.create') }}" class="quick-action-item py-2">
                                    <div class="action-icon bg-success">
                                        <i class="bi bi-plus-circle"></i>
                                    </div>
                                    <div class="action-text">
                                        <span class="fs-7">Nuevo Estudiante</span>
                                        <small class="fs-8">Agregar al sistema</small>
                                    </div>
                                </a>
                                <a href="{{ route('students.index') }}" class="quick-action-item py-2">
                                    <div class="action-icon bg-info">
                                        <i class="bi bi-list-ul"></i>
                                    </div>
                                    <div class="action-text">
                                        <span class="fs-7">Lista Completa</span>
                                        <small class="fs-8">Ver todos los estudiantes</small>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const gradeSelect = document.getElementById('grade_id');
            const sectionSelect = document.getElementById('classroom_id');
            const fileUploadArea = document.getElementById('fileUploadArea');
            const fileInput = document.getElementById('photo');
            const filePreview = document.getElementById('filePreview');
            const fileName = document.getElementById('fileName');
            const fileSize = document.getElementById('fileSize');
            const clearFile = document.getElementById('clearFile');
            const resetForm = document.getElementById('resetForm');
            
            // Función para actualizar las secciones
            function updateSections() {
                const selectedOption = gradeSelect.options[gradeSelect.selectedIndex];
                
                if (!selectedOption.dataset.sections) {
                    console.error('No hay datos de secciones para este grado');
                    sectionSelect.innerHTML = '<option value="">No hay secciones disponibles</option>';
                    return;
                }
                
                try {
                    const sections = JSON.parse(selectedOption.dataset.sections);
                    sectionSelect.innerHTML = '<option value="">Seleccione una sección</option>';
                    
                    sections.forEach(section => {
                        const option = document.createElement('option');
                        option.value = section.id;
                        option.textContent = `Sección ${section.name}`;
                        sectionSelect.appendChild(option);
                    });

                    const currentSectionId = "{{ old('classroom_id', $student->classroom_id) }}";
                    if (currentSectionId) {
                        setTimeout(() => {
                            sectionSelect.value = currentSectionId;
                        }, 100);
                    }
                } catch (error) {
                    console.error('Error al analizar las secciones:', error);
                    sectionSelect.innerHTML = '<option value="">Error al cargar secciones</option>';
                }
            }
            
            // Evento cuando cambia la selección de grado
            gradeSelect.addEventListener('change', updateSections);
            
            // Inicializar las secciones al cargar la página
            if (gradeSelect.value) {
                updateSections();
            }

            // Funcionalidad mejorada para subir archivos
            fileUploadArea.addEventListener('click', function() {
                fileInput.click();
            });

            fileUploadArea.addEventListener('dragover', function(e) {
                e.preventDefault();
                fileUploadArea.classList.add('dragover');
            });

            fileUploadArea.addEventListener('dragleave', function() {
                fileUploadArea.classList.remove('dragover');
            });

            fileUploadArea.addEventListener('drop', function(e) {
                e.preventDefault();
                fileUploadArea.classList.remove('dragover');
                
                if (e.dataTransfer.files.length) {
                    fileInput.files = e.dataTransfer.files;
                    handleFileSelection(e.dataTransfer.files[0]);
                }
            });

            fileInput.addEventListener('change', function(e) {
                if (e.target.files.length) {
                    handleFileSelection(e.target.files[0]);
                }
            });

            clearFile.addEventListener('click', function() {
                fileInput.value = '';
                filePreview.style.display = 'none';
                fileUploadArea.style.display = 'block';
            });

            function handleFileSelection(file) {
                if (file) {
                    // Validar tipo de archivo
                    if (!file.type.startsWith('image/')) {
                        alert('Por favor, seleccione un archivo de imagen válido.');
                        return;
                    }

                    // Validar tamaño (2MB máximo)
                    if (file.size > 2 * 1024 * 1024) {
                        alert('El archivo no debe exceder los 2MB.');
                        return;
                    }

                    // Mostrar información del archivo
                    fileName.textContent = file.name;
                    fileSize.textContent = formatFileSize(file.size);
                    
                    // Mostrar preview
                    filePreview.style.display = 'block';
                    fileUploadArea.style.display = 'none';

                    // Opcional: Mostrar vista previa de la imagen
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        // Puedes agregar aquí la vista previa de la imagen si lo deseas
                        console.log('Imagen cargada:', file.name);
                    };
                    reader.readAsDataURL(file);
                }
            }

            function formatFileSize(bytes) {
                if (bytes === 0) return '0 Bytes';
                const k = 1024;
                const sizes = ['Bytes', 'KB', 'MB'];
                const i = Math.floor(Math.log(bytes) / Math.log(k));
                return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
            }

            // Confirmación antes de eliminar foto
            const removePhotoCheckbox = document.getElementById('remove_photo');
            if (removePhotoCheckbox) {
                removePhotoCheckbox.addEventListener('change', function() {
                    if (this.checked) {
                        if (!confirm('¿Está seguro de que desea eliminar la foto actual?')) {
                            this.checked = false;
                        }
                    }
                });
            }

            // Reset del formulario
            resetForm.addEventListener('click', function() {
                filePreview.style.display = 'none';
                fileUploadArea.style.display = 'block';
                fileInput.value = '';
                
                if (removePhotoCheckbox) {
                    removePhotoCheckbox.checked = false;
                }
            });

            // Validación del formulario
            const form = document.getElementById('studentForm');
            form.addEventListener('submit', function(e) {
                const guardianPhone = document.getElementById('guardian_phone').value;
                
                if (guardianPhone && !/^[\d\s\-\+\(\)]{9,15}$/.test(guardianPhone)) {
                    e.preventDefault();
                    alert('Por favor, ingrese un número de teléfono válido (9-15 dígitos)');
                    return false;
                }
            });

            // ========== CÓDIGO CORREGIDO PARA EL PERFIL ==========
            
            // Referencias a los elementos del perfil
            const profileButton = document.getElementById('profileButton');
            const profileMenu = document.getElementById('profileMenu');
            
            // Función para alternar el menú de perfil
            function toggleProfileMenu(event) {
                event.stopPropagation(); // Prevenir que el evento se propague
                profileMenu.classList.toggle('show');
            }
            
            // Función para cerrar el menú de perfil
            function closeProfileMenu() {
                profileMenu.classList.remove('show');
            }
            
            // Evento para abrir/cerrar el menú de perfil
            profileButton.addEventListener('click', toggleProfileMenu);
            
            // Cerrar menú de perfil al hacer clic fuera de él
            document.addEventListener('click', function(e) {
                if (!profileButton.contains(e.target) && !profileMenu.contains(e.target)) {
                    closeProfileMenu();
                }
            });
            
            // Cerrar menú de perfil al hacer clic en cualquier opción del menú
            const menuItems = profileMenu.querySelectorAll('.user-menu-item');
            menuItems.forEach(item => {
                item.addEventListener('click', function() {
                    closeProfileMenu();
                });
            });
            
            // Prevenir que el menú se cierre cuando se hace clic dentro de él
            profileMenu.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        });
    </script>
</body>
</html>