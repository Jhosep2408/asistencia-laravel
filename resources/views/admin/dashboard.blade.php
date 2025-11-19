<!DOCTYPE html>
<html lang="{{ session('language', 'es') }}" data-theme="{{ session('theme', 'light') }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - Sistema Escolar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
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

        /* Tarjetas de Estadísticas Mejoradas - Más Compactas */
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
            
            /* Ajustes para el perfil en móvil */
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
        /* Estilos para el Chatbot */
        .chatbot-container {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1050;
        }

        .chatbot-btn {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);
            border: none;
            color: white;
            font-size: 1.5rem;
            box-shadow: 0 8px 25px rgba(99, 102, 241, 0.4);
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            position: relative;
        }

        .chatbot-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 12px 30px rgba(99, 102, 241, 0.6);
        }

        .chatbot-btn.pulse::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background: rgba(99, 102, 241, 0.5);
            animation: pulse 2s infinite;
            z-index: -1;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
                opacity: 0.8;
            }
            70% {
                transform: scale(1.4);
                opacity: 0;
            }
            100% {
                transform: scale(1.4);
                opacity: 0;
            }
        }

        .chatbot-window {
            position: absolute;
            bottom: 70px;
            right: 0;
            width: 380px;
            height: 500px;
            background: var(--card-bg);
            border-radius: var(--border-radius);
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            display: none;
            flex-direction: column;
            overflow: hidden;
            border: 1px solid var(--border-color);
        }

        .chatbot-window.active {
            display: flex;
        }

        .chatbot-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);
            color: white;
            padding: 1rem 1.25rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .chatbot-header h6 {
            margin: 0;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .chatbot-close {
            background: transparent;
            border: none;
            color: white;
            font-size: 1.25rem;
            cursor: pointer;
            transition: var(--transition);
        }

        .chatbot-close:hover {
            transform: scale(1.1);
        }

        .chatbot-messages {
            flex: 1;
            padding: 1rem;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .message {
            max-width: 85%;
            padding: 0.75rem 1rem;
            border-radius: 18px;
            font-size: 0.9rem;
            line-height: 1.4;
            position: relative;
        }

        .message.user {
            align-self: flex-end;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);
            color: white;
            border-bottom-right-radius: 6px;
        }

        .message.bot {
            align-self: flex-start;
            background: var(--light-bg);
            color: var(--text-primary);
            border-bottom-left-radius: 6px;
            border: 1px solid var(--border-color);
        }

        .message.loading {
            background: var(--light-bg);
            color: var(--text-muted);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .message.loading .spinner {
            width: 16px;
            height: 16px;
            border: 2px solid transparent;
            border-top: 2px solid var(--primary-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .chatbot-input {
            padding: 1rem;
            border-top: 1px solid var(--border-color);
            display: flex;
            gap: 0.5rem;
            align-items: center;
        }

        .chatbot-input input {
            flex: 1;
            border: 1px solid var(--border-color);
            border-radius: 24px;
            padding: 0.75rem 1rem;
            font-size: 0.9rem;
            outline: none;
            transition: var(--transition);
        }

        .chatbot-input input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }

        .voice-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--light-bg);
            border: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition);
            color: var(--text-secondary);
        }

        .voice-btn:hover {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        .voice-btn.listening {
            background: var(--danger-color);
            color: white;
            border-color: var(--danger-color);
            animation: pulse 1.5s infinite;
        }

        .send-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--primary-color);
            border: none;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition);
        }

        .send-btn:hover {
            background: var(--primary-dark);
            transform: scale(1.05);
        }

        .suggestions {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            padding: 0.75rem 1rem;
            border-top: 1px solid var(--border-color);
            background: var(--light-bg);
        }

        .suggestion {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 0.5rem 0.75rem;
            font-size: 0.8rem;
            cursor: pointer;
            transition: var(--transition);
        }

        .suggestion:hover {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .chatbot-window {
                width: calc(100vw - 40px);
                height: 70vh;
                right: 20px;
            }
            
            .chatbot-container {
                bottom: 10px;
                right: 10px;
            }
        }
        /* Estilos adicionales para el chatbot mejorado */
        .message.bot.with-data {
            background: white;
            border: 1px solid var(--border-color);
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }

        .student-info {
            background: var(--light-bg);
            border-radius: 8px;
            padding: 0.75rem;
            margin: 0.5rem 0;
            border-left: 3px solid var(--primary-color);
        }

        .attendance-record {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.5rem;
            border-bottom: 1px solid var(--border-color);
        }

        .attendance-record:last-child {
            border-bottom: none;
        }

        .attendance-status {
            padding: 0.25rem 0.5rem;
            border-radius: 12px;
            font-size: 0.7rem;
            font-weight: 600;
        }

        .status-present {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success-color);
        }

        .status-absent {
            background: rgba(239, 68, 68, 0.1);
            color: var(--danger-color);
        }

        .status-late {
            background: rgba(245, 158, 11, 0.1);
            color: var(--warning-color);
        }

        .quick-stats {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0.5rem;
            margin: 0.75rem 0;
        }

        .stat-mini {
            background: var(--light-bg);
            padding: 0.5rem;
            border-radius: 8px;
            text-align: center;
        }

        .stat-mini .number {
            font-weight: 700;
            font-size: 1.1rem;
            display: block;
        }

        .stat-mini .label {
            font-size: 0.7rem;
            color: var(--text-muted);
        }

        .suggestion {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 0.5rem 0.75rem;
            font-size: 0.8rem;
            cursor: pointer;
            transition: var(--transition);
            margin: 0.125rem;
        }

        .suggestion:hover {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        .typing-indicator {
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .typing-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--text-muted);
            animation: typing 1.4s infinite ease-in-out;
        }

        .typing-dot:nth-child(1) { animation-delay: -0.32s; }
        .typing-dot:nth-child(2) { animation-delay: -0.16s; }

        @keyframes typing {
            0%, 80%, 100% { transform: scale(0.8); opacity: 0.5; }
            40% { transform: scale(1); opacity: 1; }
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
                    <a class="nav-link active" href="#">
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
                    <a class="nav-link" href="{{ route('admin.asistente') }}">
                        <i class="bi bi-robot"></i>
                        <span>Asistente IA</span>
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
                <!-- En el menú de perfil del dashboard, actualiza los enlaces: -->
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
                    <!-- Botón de cierre de sesión con SweetAlert -->
                    <button type="button" class="user-menu-item text-danger w-100 text-start border-0 bg-transparent" onclick="confirmLogout()">
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
                </div>
            </div>
        </div>
    </div>

     <!-- Chatbot Mejorado -->
    <!-- Chatbot Inteligente Mejorado -->
    <div class="chatbot-container">
        <div class="chatbot-window" id="chatbotWindow">
            <div class="chatbot-header">
                <div>
                    <h6><i class="bi bi-robot"></i> EduAssist</h6>
                    <div class="ai-name">Asistente Escolar IA</div>
                </div>
                <button class="chatbot-close" id="chatbotClose">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
            <div class="chatbot-messages" id="chatbotMessages">
                <div class="message bot intelligent">
                    <div class="intelligent-response">
                        <strong>👋 ¡Hola! Soy EduAssist, tu asistente escolar inteligente</strong>
                        <br><br>
                        Estoy aquí para ayudarte con cualquier consulta sobre:
                        <br>
                        📚 <strong>Estudiantes específicos</strong> - "¿María García asistió hoy?"
                        <br>
                        📅 <strong>Asistencias por fecha</strong> - "¿Cómo estuvo la asistencia el lunes?"
                        <br>
                        📊 <strong>Estadísticas y reportes</strong> - "¿Qué grado tiene mejor asistencia?"
                        <br>
                        🎓 <strong>Información de grados</strong> - "¿Cuántos estudiantes hay en 4to A?"
                        <br><br>
                        <em>Pregúntame lo que necesites en lenguaje natural, ¡soy bastante inteligente! 😊</em>
                    </div>
                </div>
            </div>
            <div class="suggestions">
                <div class="suggestion" data-question="¿Cómo estuvo la asistencia hoy?">Asistencia de hoy</div>
                <div class="suggestion" data-question="12345678">Buscar por DNI</div>
                <div class="suggestion" data-question="¿Qué estudiantes faltaron hoy?">Faltas de hoy</div>
                <div class="suggestion" data-question="4to A">Información de grado</div>
            </div>
            <div class="chatbot-input">
                <input type="text" id="chatbotInput" placeholder="Pregunta anything sobre el sistema escolar...">
                <button class="voice-btn" id="voiceBtn">
                    <i class="bi bi-mic"></i>
                </button>
                <button class="send-btn" id="sendBtn">
                    <i class="bi bi-send"></i>
                </button>
            </div>
        </div>
        <button class="chatbot-btn pulse" id="chatbotBtn">
            <i class="bi bi-robot"></i>
        </button>
    </div>
    <!-- Main Content -->
    <div class="main-content">
        <!-- Encabezado -->
        <div class="dashboard-header">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="h2 fw-bold mb-2">Panel de Administración</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item active" aria-current="page">Inicio</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-md-4 text-md-end">
                    <div class="d-flex align-items-center justify-content-end gap-3">
                        <div class="text-white-50">
                           <span class="date-indicator">Hoy: {{ date('d/m/Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contenido Principal -->
        <div class="content-wrapper">
            <!-- Tarjetas de Estadísticas -->
            <div class="stats-grid">
                <!-- Tarjeta de Total Estudiantes -->
                <div class="stat-card stat-card-primary">
                    <div class="stat-icon text-primary">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <div class="stat-label text-primary">Total Estudiantes</div>
                    <div class="stat-number">{{ $totalStudents }}</div>
                    <div class="stat-description">Registrados en el sistema</div>
                    <div class="stat-footer">
                        <a href="{{ route('students.index') }}" class="text-primary text-decoration-none fw-semibold d-flex align-items-center">
                            Ver todos <i class="bi bi-arrow-right-short ms-1 fs-5"></i>
                        </a>
                    </div>
                </div>

                <!-- Tarjeta de Asistencias Hoy -->
                <div class="stat-card stat-card-success">
                    <div class="stat-icon text-success">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                    <div class="stat-label text-success">Asistencias Hoy</div>
                    <div class="stat-number">{{ $todayAttendances }}</div>
                    <div class="stat-description">Registradas hasta la fecha</div>
                    <div class="stat-footer">
                        <a href="{{ route('attendance.reports') }}" class="text-success text-decoration-none fw-semibold d-flex align-items-center">
                            Ver reporte <i class="bi bi-arrow-right-short ms-1 fs-5"></i>
                        </a>
                    </div>
                </div>

                <!-- Tarjeta de Faltas Hoy -->
                <div class="stat-card stat-card-danger">
                    <div class="stat-icon text-danger">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                    </div>
                    <div class="stat-label text-danger">Faltas Hoy</div>
                    <div class="stat-number">{{ $todayAbsences }}</div>
                    <div class="stat-description">Reportadas en el día</div>
                    <div class="stat-footer">
                        <a href="{{ route('attendance.reports') }}" class="text-danger text-decoration-none fw-semibold d-flex align-items-center">
                            Ver detalles <i class="bi bi-arrow-right-short ms-1 fs-5"></i>
                        </a>
                    </div>
                </div>

                <!-- Tarjeta de Promedio Asistencia -->
                <div class="stat-card stat-card-info">
                    <div class="stat-icon text-info">
                        <i class="bi bi-graph-up"></i>
                    </div>
                    <div class="stat-label text-info">Promedio Asistencia</div>
                    <div class="stat-number">
                        {{ $totalStudents > 0 ? round(($todayAttendances / $totalStudents) * 100, 1) : 0 }}%
                    </div>
                    <div class="stat-description">Tasa de asistencia diaria</div>
                    <div class="stat-footer">
                        <a href="{{ route('attendance.reports') }}" class="text-info text-decoration-none fw-semibold d-flex align-items-center">
                            Ver estadísticas <i class="bi bi-arrow-right-short ms-1 fs-5"></i>
                        </a>
                    </div>
                </div>


                <!-- Tarjeta de Grados -->
                <div class="stat-card stat-card-pink">
                    <div class="stat-icon text-pink">
                        <i class="bi bi-mortarboard"></i>
                    </div>
                    <div class="stat-label text-pink">Grados Activos</div>
                    <div class="stat-number">5</div>
                    <div class="stat-description">Niveles educativos</div>
                    <div class="stat-footer">
                        <a href="#" class="text-pink text-decoration-none fw-semibold d-flex align-items-center">
                            Ver grados <i class="bi bi-arrow-right-short ms-1 fs-5"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Acciones Rápidas -->
            <div class="quick-actions-card">
                <div class="card-header-custom">
                    <h5 class="mb-0 fw-semibold">Acciones Rápidas</h5>
                </div>
                <div class="card-body p-3">
                    <div class="d-flex flex-wrap gap-2">
                        <a href="{{ route('students.create') }}" class="btn btn-primary btn-action">
                            <i class="bi bi-person-plus me-2"></i> Agregar Alumno
                        </a>
                        <a href="{{ route('students.index') }}" class="btn btn-outline-primary btn-action">
                            <i class="bi bi-list-ul me-2"></i> Lista de Alumnos
                        </a>
                        <a href="{{ route('attendance.reports') }}" class="btn btn-info btn-action">
                            <i class="bi bi-clipboard-data me-2"></i> Generar Reporte
                        </a>
                        <a href="{{ route('students.attendance') }}" class="btn btn-success btn-action">
                            <i class="bi bi-calendar-check me-2"></i> Tomar Asistencia
                        </a>
                        <a href="{{ route('students.attendanceviews') }}" class="btn btn-purple btn-action">
                            <i class="bi bi-eye me-2"></i> Ver Asistencia
                        </a>
                    </div>
                </div>
            </div>

            <!-- Últimos Registros -->
            <div class="table-card">
                <div class="card-header-custom d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-semibold">Últimos Alumnos Registrados</h5>
                    <div>
                        <a href="{{ route('students.create') }}" class="btn btn-sm btn-primary">
                            <i class="bi bi-plus-circle me-1"></i> Nuevo Alumno
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">DNI</th>
                                    <th>Nombre Completo</th>
                                    <th>Grado</th>
                                    <th>Sección</th>
                                    <th>Estado</th>
                                    <th class="text-center pe-4">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentStudents as $student)
                                <tr>
                                    <td class="ps-4 fw-semibold">{{ $student->dni }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="student-avatar me-3">
                                                {{ substr($student->full_name, 0, 1) }}
                                            </div>
                                            <div class="fw-semibold">{{ $student->full_name }}</div>
                                        </div>
                                    </td>
                                    <td>{{ $student->grade->name }}</td>
                                    <td>{{ $student->classroom->name }}</td>
                                    <td>
                                        <span class="badge-status bg-success bg-opacity-10 text-success">Activo</span>
                                    </td>
                                    <td class="text-center pe-4">
                                        <div class="d-flex justify-content-center gap-1">
                                            <a href="{{ route('students.photocheck', $student->dni) }}" 
                                               class="btn btn-outline-info btn-sm action-btn" 
                                               title="Generar Fotocheck"
                                               data-bs-toggle="tooltip"
                                               target="_blank">
                                                <i class="bi bi-person-badge"></i>
                                            </a>
                                            <a href="{{ route('students.show', $student->dni) }}" 
                                               class="btn btn-outline-primary btn-sm action-btn" 
                                               title="Ver Detalles"
                                               data-bs-toggle="tooltip">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('students.attendanceviews') }}" 
                                               class="btn btn-outline-success btn-sm action-btn" 
                                               title="Ver Asistencia"
                                               data-bs-toggle="tooltip">
                                                <i class="bi bi-calendar-check"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer-transparent text-center py-3">
                    <a href="{{ route('students.index') }}" class="text-primary text-decoration-none fw-semibold">
                        Ver todos los alumnos <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Formulario oculto para logout -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>

       // Configuración
        const API_BASE_URL = '{{ url("/") }}';
        
        // Funcionalidad del Chatbot Inteligente
        document.addEventListener('DOMContentLoaded', function() {
            const chatbotBtn = document.getElementById('chatbotBtn');
            const chatbotWindow = document.getElementById('chatbotWindow');
            const chatbotClose = document.getElementById('chatbotClose');
            const chatbotMessages = document.getElementById('chatbotMessages');
            const chatbotInput = document.getElementById('chatbotInput');
            const sendBtn = document.getElementById('sendBtn');
            const voiceBtn = document.getElementById('voiceBtn');
            const suggestions = document.querySelectorAll('.suggestion');
            
            let recognition = null;
            let isListening = false;
            let conversationHistory = [];
            
            // Inicializar reconocimiento de voz
            if ('webkitSpeechRecognition' in window || 'SpeechRecognition' in window) {
                const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
                recognition = new SpeechRecognition();
                recognition.continuous = false;
                recognition.interimResults = false;
                recognition.lang = 'es-ES';
                
                recognition.onstart = function() {
                    isListening = true;
                    voiceBtn.classList.add('listening');
                    voiceBtn.innerHTML = '<i class="bi bi-stop-fill"></i>';
                };
                
                recognition.onresult = function(event) {
                    const transcript = event.results[0][0].transcript;
                    chatbotInput.value = transcript;
                    isListening = false;
                    voiceBtn.classList.remove('listening');
                    voiceBtn.innerHTML = '<i class="bi bi-mic"></i>';
                    sendMessage();
                };
                
                recognition.onerror = function(event) {
                    console.error('Error en reconocimiento de voz:', event.error);
                    isListening = false;
                    voiceBtn.classList.remove('listening');
                    voiceBtn.innerHTML = '<i class="bi bi-mic"></i>';
                };
                
                recognition.onend = function() {
                    isListening = false;
                    voiceBtn.classList.remove('listening');
                    voiceBtn.innerHTML = '<i class="bi bi-mic"></i>';
                };
            } else {
                voiceBtn.style.display = 'none';
            }
            
            // Abrir/cerrar chatbot
            chatbotBtn.addEventListener('click', function() {
                chatbotWindow.classList.toggle('active');
                chatbotBtn.classList.remove('pulse');
            });
            
            chatbotClose.addEventListener('click', function() {
                chatbotWindow.classList.remove('active');
            });
            
            // Enviar mensaje
           // Reemplaza la función sendMessage en tu JavaScript con esta versión mejorada:

// En tu archivo JavaScript, actualiza la función sendMessage:

// En tu archivo JavaScript, actualiza la función sendMessage:

async function sendMessage() {
    const message = chatbotInput.value.trim();
    if (message === '') return;
    
    addMessage('user', message);
    chatbotInput.value = '';
    
    showTypingIndicator();
    
    try {
        const response = await fetch(`/api/chatbot/query`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                query: message,
                history: conversationHistory
            })
        });

        if (!response.ok) throw new Error(`Error HTTP: ${response.status}`);

        const data = await response.json();
        removeTypingIndicator();
        
        if (data.success) {
            // Mostrar respuesta con animación tipo escritura
            await typewriterEffect(data.message, 'bot', data.data);
            
            conversationHistory.push({ role: 'user', content: message });
            conversationHistory.push({ role: 'assistant', content: data.message });
            
            if (conversationHistory.length > 8) {
                conversationHistory = conversationHistory.slice(-8);
            }
        } else {
            addMessage('bot', '😔 ' + data.message);
        }
        
    } catch (error) {
        removeTypingIndicator();
        console.error('Error:', error);
        
        addMessage('bot', `🤖 **EduAssist**\n\n¡Hola! 👋 Estoy aquí para ayudarte con información del sistema escolar.\n\nPuedes preguntarme de manera natural como:\n• "¿María asistió hoy?"\n• "Cómo está 4to A"\n• "Quiénes faltaron"\n\n¿En qué te puedo ayudar?`);
    }
}

// Efecto de máquina de escribir para respuestas más naturales
async function typewriterEffect(text, sender, data = null) {
    const messageDiv = document.createElement('div');
    messageDiv.className = `message ${sender} intelligent`;
    
    const contentDiv = document.createElement('div');
    contentDiv.className = 'intelligent-response';
    contentDiv.innerHTML = '<span class="cursor">|</span>';
    
    messageDiv.appendChild(contentDiv);
    chatbotMessages.appendChild(messageDiv);
    
    let index = 0;
    const speed = 20; // Velocidad de escritura
    
    function type() {
        if (index < text.length) {
            contentDiv.innerHTML = text.substring(0, index + 1) + '<span class="cursor">|</span>';
            index++;
            setTimeout(type, speed);
        } else {
            contentDiv.innerHTML = text; // Remover cursor al final
            if (data && data.thinking) {
                addThinkingProcess(data.thinking, messageDiv);
            }
            scrollToBottom();
        }
    }
    
    type();
}
            
            sendBtn.addEventListener('click', sendMessage);
            
            chatbotInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    sendMessage();
                }
            });
            
            // Control de voz
            voiceBtn.addEventListener('click', function() {
                if (!recognition) {
                    addMessage('bot', '🎤 Lo siento, el reconocimiento de voz no está disponible en tu navegador.');
                    return;
                }
                
                if (isListening) {
                    recognition.stop();
                } else {
                    recognition.start();
                }
            });
            
            // Sugerencias rápidas
            suggestions.forEach(suggestion => {
                suggestion.addEventListener('click', function() {
                    const question = this.getAttribute('data-question');
                    chatbotInput.value = question;
                    sendMessage();
                });
            });
            
            // Añadir mensaje al chat
            function addMessage(sender, text, data = null, isIntelligent = false) {
                const messageDiv = document.createElement('div');
                messageDiv.className = `message ${sender}`;
                
                if (sender === 'bot' && isIntelligent) {
                    messageDiv.classList.add('intelligent');
                    messageDiv.innerHTML = formatIntelligentResponse(text, data);
                } else if (sender === 'bot') {
                    messageDiv.innerHTML = `<div class="intelligent-response">${text}</div>`;
                } else {
                    messageDiv.textContent = text;
                }
                
                chatbotMessages.appendChild(messageDiv);
                scrollToBottom();
            }
            
            // Formatear respuesta inteligente
            function formatIntelligentResponse(text, data) {
                let html = `<div class="intelligent-response">${text}</div>`;
                
                if (data && data.thinking) {
                    html += `
                        <div class="thinking-process mt-2">
                            <small class="text-muted">Proceso de análisis:</small>
                            ${data.thinking.map(step => `
                                <div class="step">
                                    <div class="step-icon">🔍</div>
                                    <div>${step}</div>
                                </div>
                            `).join('')}
                        </div>
                    `;
                }
                
                return html;
            }
            
            // Mostrar indicador de escritura
            function showTypingIndicator() {
                const typingDiv = document.createElement('div');
                typingDiv.className = 'message bot loading';
                typingDiv.id = 'typingIndicator';
                typingDiv.innerHTML = `
                    <div class="typing-indicator">
                        <span>EduAssist está pensando...</span>
                        <div class="typing-dot"></div>
                        <div class="typing-dot"></div>
                        <div class="typing-dot"></div>
                    </div>
                `;
                chatbotMessages.appendChild(typingDiv);
                scrollToBottom();
            }
            
            // Remover indicador de escritura
            function removeTypingIndicator() {
                const typingIndicator = document.getElementById('typingIndicator');
                if (typingIndicator) {
                    chatbotMessages.removeChild(typingIndicator);
                }
            }
            
            // Desplazar al final del chat
            function scrollToBottom() {
                chatbotMessages.scrollTop = chatbotMessages.scrollHeight;
            }
        });

        // Funciones existentes del sistema (tooltips, perfil, logout)
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })

        function toggleProfileMenu() {
            const menu = document.getElementById('profileMenu');
            menu.classList.toggle('show');
        }

        function closeProfileMenu() {
            const menu = document.getElementById('profileMenu');
            menu.classList.remove('show');
        }

        document.addEventListener('click', function(e) {
            const profileMenu = document.getElementById('profileMenu');
            const profileBtn = document.querySelector('.user-profile-bottom-btn');
            
            if (!profileBtn.contains(e.target) && !profileMenu.contains(e.target)) {
                closeProfileMenu();
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.stat-card');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                
                setTimeout(() => {
                    card.style.transition = 'all 0.6s cubic-bezier(0.4, 0, 0.2, 1)';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });

        function confirmLogout() {
            Swal.fire({
                title: '¿Cerrar sesión?',
                text: "¿Estás seguro de que deseas salir del sistema?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, cerrar sesión',
                cancelButtonText: 'Cancelar',
                backdrop: 'rgba(0,0,0,0.4)',
                background: '#1e293b',
                color: '#e2e8f0',
                customClass: {
                    confirmButton: 'btn btn-primary',
                    cancelButton: 'btn btn-secondary'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Cerrando sesión...',
                        text: 'Por favor espera un momento',
                        icon: 'info',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showConfirmButton: false,
                        background: '#1e293b',
                        color: '#e2e8f0',
                        didOpen: () => {
                            Swal.showLoading()
                        }
                    });

                    closeProfileMenu();
                    
                    setTimeout(() => {
                        document.getElementById('logout-form').submit();
                    }, 1500);
                }
            });
        }
        // Inicializar tooltips de Bootstrap
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })

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

        // Efectos de animación adicionales
        document.addEventListener('DOMContentLoaded', function() {
            // Animación de entrada para las tarjetas
            const cards = document.querySelectorAll('.stat-card');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                
                setTimeout(() => {
                    card.style.transition = 'all 0.6s cubic-bezier(0.4, 0, 0.2, 1)';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });

        // Función para confirmar cierre de sesión con SweetAlert
        function confirmLogout() {
            Swal.fire({
                title: '¿Cerrar sesión?',
                text: "¿Estás seguro de que deseas salir del sistema?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, cerrar sesión',
                cancelButtonText: 'Cancelar',
                backdrop: 'rgba(0,0,0,0.4)',
                background: '#1e293b',
                color: '#e2e8f0',
                customClass: {
                    confirmButton: 'btn btn-primary',
                    cancelButton: 'btn btn-secondary'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Mostrar alerta de "Cerrando sesión"
                    Swal.fire({
                        title: 'Cerrando sesión...',
                        text: 'Por favor espera un momento',
                        icon: 'info',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showConfirmButton: false,
                        background: '#1e293b',
                        color: '#e2e8f0',
                        didOpen: () => {
                            Swal.showLoading()
                        }
                    });

                    // Cerrar el menú de perfil
                    closeProfileMenu();
                    
                    // Enviar el formulario de logout después de un breve retraso
                    setTimeout(() => {
                        document.getElementById('logout-form').submit();
                    }, 1500);
                }
            });
        }

 
    </script>
</body>
</html>