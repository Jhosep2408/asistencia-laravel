<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportes de Asistencia</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            500: '#4361ee',
                            600: '#3a56d4',
                            700: '#314bc7',
                            800: '#2a41b3',
                            900: '#1e3a8a'
                        },
                        success: {
                            500: '#06d6a0'
                        },
                        danger: {
                            500: '#ef476f'
                        },
                        info: {
                            500: '#118ab2'
                        }
                    },
                    boxShadow: {
                        'elegant': '0 10px 40px -10px rgba(0, 0, 0, 0.1)',
                        'card': '0 4px 20px rgba(0, 0, 0, 0.08)',
                        'card-hover': '0 10px 30px rgba(0, 0, 0, 0.12)'
                    },
                    borderRadius: {
                        'xl': '12px',
                        '2xl': '16px'
                    }
                }
            }
        }
    </script>
    <style>
        :root {
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

        /* Perfil de Usuario en la parte inferior */
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

        /* Dashboard Header Profesional */
        .dashboard-header {
            background: var(--header-gradient);
            color: white;
            border-radius: var(--border-radius);
            padding: 2rem;
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
            font-size: 2rem;
            letter-spacing: -0.025em;
            margin-bottom: 0.5rem;
            position: relative;
            z-index: 1;
            background: linear-gradient(135deg, #fff 0%, #cbd5e1 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .breadcrumb {
            background: rgba(255, 255, 255, 0.08);
            border-radius: 12px;
            padding: 0.75rem 1.25rem;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            position: relative;
            z-index: 1;
        }

        /* Breadcrumb personalizado tipo "pill" oscuro con separadores */
        .breadcrumb-custom {
            background: rgba(84, 89, 101, 0.52);
            border-radius: 999px;
            padding: 0.375rem 0.75rem;
            display: inline-flex;
            gap: 0.6rem;
            align-items: center;
            color: rgba(255,255,255,0.9);
            backdrop-filter: blur(6px);
            border: 1px solid rgba(255,255,255,0.03);
            box-shadow: inset 0 1px 0 rgba(255,255,255,0.02), 0 6px 18px rgba(2,6,23,0.35);
        }

        .breadcrumb-custom .breadcrumb-item {
            background: transparent;
            padding: 0 0.35rem;
            margin: 0;
            display: inline-flex;
            align-items: center;
            color: rgba(255,255,255,0.8);
            font-size: 0.9rem;
        }

        .breadcrumb-custom .breadcrumb-item + .breadcrumb-item::before {
            content: '/';
            display: inline-block;
            margin: 0 0.5rem;
            color: rgba(36, 35, 35, 0.45);
            font-weight: 600;
        }

        .breadcrumb-custom .breadcrumb-item a {
            color: rgba(255,255,255,0.85);
            text-decoration: none;
            transition: color .15s ease, transform .15s ease;
        }

        .breadcrumb-custom .breadcrumb-item a:hover {
            color: #fff;
            transform: translateY(-1px);
        }

        .breadcrumb-custom .breadcrumb-item.active {
            color: #ffffff;
            font-weight: 700;
        }

        .breadcrumb-item a {
            color: rgba(255, 255, 255, 1);
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

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 2rem;
            transition: var(--transition);
            min-height: 100vh;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
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
                padding: 1rem; 
            }
            .sidebar { 
                transform: translateX(-100%); 
            }
            .sidebar.active { 
                transform: translateX(0); 
            }
            .dashboard-header {
                padding: 1.5rem;
            }
            .dashboard-header h1 {
                font-size: 1.5rem;
            }
        }

        /* Estilos para elementos específicos */
        .card-elegant {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-card);
            transition: var(--transition);
            overflow: hidden;
        }

        .card-elegant:hover {
            box-shadow: var(--shadow-card-hover);
            transform: translateY(-5px);
        }

        .filter-card {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-card);
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .btn-elegant {
            border-radius: 10px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        .btn-elegant:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        }

        .badge-status {
            padding: 0.35rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
        }

        .table-elegant {
            background: white;
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--shadow-card);
        }

        .table-elegant thead {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        }

        .table-elegant th {
            font-weight: 600;
            color: #374151;
            padding: 1rem;
            border-bottom: 1px solid #e5e7eb;
        }

        .table-elegant td {
            padding: 1rem;
            border-bottom: 1px solid #f3f4f6;
        }

        .table-elegant tbody tr {
            transition: var(--transition);
        }

        .table-elegant tbody tr:hover {
            background-color: #f9fafb;
        }

        .pagination-elegant {
            display: flex;
            justify-content: center;
            margin-top: 2rem;
        }

        .pagination-elegant .page-link {
            padding: 0.5rem 1rem;
            margin: 0 0.25rem;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
            color: #6b7280;
            text-decoration: none;
            transition: var(--transition);
        }

        .pagination-elegant .page-link:hover {
            background-color: #f3f4f6;
            color: #374151;
        }

        .pagination-elegant .page-link.active {
            background-color: #4361ee;
            color: white;
            border-color: #4361ee;
        }

        /* Estilos mejorados para los modales */
        .modal-elegant {
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(5px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1050;
            padding: 1rem;
        }

        .modal-content-elegant {
            background: white;
            border-radius: 16px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            overflow: hidden;
            width: 100%;
            max-width: 90vw;
            max-height: 90vh;
            display: flex;
            flex-direction: column;
        }

        .modal-header-elegant {
            padding: 1.5rem 2rem;
            border-bottom: 1px solid #e5e7eb;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            flex-shrink: 0;
        }

        .modal-body-elegant {
            padding: 2rem;
            overflow-y: auto;
            flex: 1;
            max-height: calc(80vh - 180px);
        }

        .modal-footer-elegant {
            padding: 1.5rem 2rem;
            border-top: 1px solid #e5e7eb;
            background: #f9fafb;
            flex-shrink: 0;
        }

        .btn-primary {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        padding: 0.625rem 1.25rem;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.875rem;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        border: none;
        cursor: pointer;
        box-shadow: 0 2px 4px rgba(16, 185, 129, 0.2);
    }

    .btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(16, 185, 129, 0.3);
    }

    .btn-secondary {
        background: #f8fafc;
        color: #64748b;
        padding: 0.625rem 1.25rem;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.875rem;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        border: 1px solid #e2e8f0;
        cursor: pointer;
    }

    .btn-secondary:hover {
        background: #f1f5f9;
        color: #475569;
        border-color: #cbd5e1;
    }

        /* Scrollbar personalizado para modales */
        .modal-body-elegant::-webkit-scrollbar {
            width: 6px;
        }

        .modal-body-elegant::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 3px;
        }

        .modal-body-elegant::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
            transition: all 0.3s ease;
        }

        .modal-body-elegant::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Indicadores de scroll para contenido largo */
        .modal-scroll-indicator {
            position: absolute;
            left: 0;
            right: 0;
            height: 20px;
            background: linear-gradient(to bottom, white, transparent);
            pointer-events: none;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .modal-scroll-indicator.top {
            top: 0;
            border-top-left-radius: 16px;
            border-top-right-radius: 16px;
        }

        .modal-scroll-indicator.bottom {
            bottom: 0;
            border-bottom-left-radius: 16px;
            border-bottom-right-radius: 16px;
            background: linear-gradient(to top, white, transparent);
        }

        .modal-scroll-indicator.visible {
            opacity: 1;
        }

        @media (max-width: 768px) {
            .modal-content-elegant {
                max-width: 95vw;
                max-height: 95vh;
            }
            
            .modal-header-elegant,
            .modal-body-elegant,
            .modal-footer-elegant {
                padding: 1.25rem;
            }
            
            .modal-body-elegant {
                max-height: calc(95vh - 140px);
            }
        }

        /* Estilos para los elementos de formulario */
        .form-control-elegant {
            border-radius: 10px;
            padding: 0.75rem 1rem;
            border: 1px solid #d1d5db;
            transition: var(--transition);
            width: 100%;
        }

        .form-control-elegant:focus {
            outline: none;
            border-color: #4361ee;
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
        }

        .form-label-elegant {
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
            display: block;
        }

        /* Estadísticas */
        .stats-card {
            background: white;
            border-radius: var(--border-radius);
            padding: 1.5rem;
            box-shadow: var(--shadow-card);
            transition: var(--transition);
        }

        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-card-hover);
        }

        .stats-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .stats-value {
            font-size: 1.875rem;
            font-weight: 700;
            color: #1f2937;
        }

        .stats-label {
            font-size: 0.875rem;
            color: #6b7280;
            font-weight: 500;
        }

        /* Buscador sobre la tabla */
        .search-bar {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-card);
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        /* En la sección de estilos de tu vista */
.holiday-row {
    background-color: #fffbeb !important;
    border-left: 4px solid #f59e0b;
}

.holiday-badge {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    color: white;
    padding: 0.25rem 0.5rem;
    border-radius: 6px;
    font-size: 0.75rem;
    font-weight: 600;
}

.no-classes-badge {
    background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
    color: white;
    padding: 0.25rem 0.5rem;
    border-radius: 6px;
    font-size: 0.75rem;
    font-weight: 600;
}
        
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h3 class="mb-0 fw-bold">
                <i class="fas fa-graduation-cap me-2"></i>
                Sistema Escolar
            </h3>
            <small class="text-white-50">v2.0</small>
        </div>
        <div class="sidebar-menu">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('students.attendance') }}">
                        <i class="fas fa-clipboard-check"></i>
                        <span>Tomar Asistencia</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('students.attendanceviews') }}">
                        <i class="fas fa-chart-line"></i>
                        <span>Dashboard Asistencia</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('students.index') }}">
                        <i class="fas fa-users"></i>
                        <span>Estudiantes</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('attendance.reports') }}">
                        <i class="fas fa-file-alt"></i>
                        <span>Reportes</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('settings.show') }}">
                        <i class="fas fa-cog"></i>
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
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="profile-bottom-text">Mi Perfil</div>
                </button>
                <div class="user-profile-menu" id="profileMenu">
                    <a class="user-menu-item" href="{{ route('profile.show') }}">
                        <div class="d-flex align-items-center">
                            <div class="menu-icon bg-primary-500 bg-opacity-10 text-primary-500">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="ms-3">
                                <div class="fw-semibold">Mi Perfil</div>
                                <small class="text-muted">Ver y editar perfil</small>
                            </div>
                        </div>
                    </a>
                    <a class="user-menu-item" href="{{ route('settings.show') }}">
                        <div class="d-flex align-items-center">
                            <div class="menu-icon bg-info-500 bg-opacity-10 text-info-500">
                                <i class="fas fa-cog"></i>
                            </div>
                            <div class="ms-3">
                                <div class="fw-semibold">Configuración</div>
                                <small class="text-muted">Ajustes del sistema</small>
                            </div>
                        </div>
                    </a>
                    <a class="user-menu-item" href="{{ route('about') }}">
                        <div class="d-flex align-items-center">
                            <div class="menu-icon bg-warning-500 bg-opacity-10 text-warning-500">
                                <i class="fas fa-info-circle"></i>
                            </div>
                            <div class="ms-3">
                                <div class="fw-semibold">Acerca de</div>
                                <small class="text-muted">Información del sistema</small>
                            </div>
                        </div>
                    </a>
                    <a class="user-menu-item" href="{{ route('privacy') }}">
                        <div class="d-flex align-items-center">
                            <div class="menu-icon bg-success-500 bg-opacity-10 text-success-500">
                                <i class="fas fa-shield-alt"></i>
                            </div>
                            <div class="ms-3">
                                <div class="fw-semibold">Privacidad</div>
                                <small class="text-muted">Configuración de privacidad</small>
                            </div>
                        </div>
                    </a>
                    <a class="user-menu-item" href="#">
                        <div class="d-flex align-items-center">
                            <div class="menu-icon bg-purple-500 bg-opacity-10 text-purple-500">
                                <i class="fas fa-bell"></i>
                            </div>
                            <div class="ms-3">
                                <div class="fw-semibold">Notificaciones</div>
                                <small class="text-muted">Gestionar alertas</small>
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
        <!-- Encabezado -->
        <div class="dashboard-header">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                <div>
                    <h1 class="h2 fw-bold mb-2">Reportes</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-custom mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">Inicio</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Reportes</li>
                        </ol>
                    </nav>
                </div>
                <div class="mt-4 md:mt-0 flex items-center space-x-4">
                    <span class="date-indicator">Hoy: {{ date('d/m/Y') }}</span>
                </div>
            </div>
        </div>

        <!-- Tarjeta de estadísticas -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="stats-card">
                <div class="stats-icon bg-blue-100 text-blue-600">
                    <i class="fas fa-user-check"></i>
                </div>
                <div class="stats-value">85%</div>
                <div class="stats-label">Asistencia General</div>
            </div>
            <div class="stats-card">
                <div class="stats-icon bg-green-100 text-green-600">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stats-value">{{ $attendances->total() }}</div>
                <div class="stats-label">Total Registros</div>
            </div>
            <div class="stats-card">
                <div class="stats-icon bg-yellow-100 text-yellow-600">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stats-value">12%</div>
                <div class="stats-label">Tardanzas</div>
            </div>
            <div class="stats-card">
                <div class="stats-icon bg-red-100 text-red-600">
                    <i class="fas fa-user-times"></i>
                </div>
                <div class="stats-value">3%</div>
                <div class="stats-label">Inasistencias</div>
            </div>
        </div>

        <!-- Tarjeta principal -->
        <div class="card-elegant">
            <!-- Encabezado -->
            <div class="bg-gradient-to-r from-primary-500 to-primary-700 px-6 py-5">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-3 md:space-y-0">
                    <div>
                        <h1 class="text-2xl font-bold text-white">Reportes de Asistencia</h1>
                        <p class="text-primary-100 mt-1">Sistema de control y monitoreo de asistencia estudiantil</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="bg-primary-600 text-white text-sm font-medium px-3 py-1 rounded-full">
                            <i class="fas fa-chart-line mr-1"></i> Sistema de Control
                        </span>
                        <span class="bg-white/20 text-white text-sm font-medium px-3 py-1 rounded-full">
                            {{ $attendances->total() }} registros
                        </span>
                    </div>
                </div>
            </div>
            
            <!-- Cuerpo -->
            <div class="p-6">
                <!-- Formulario de filtros -->
                <div class="filter-card">
                    <form method="GET" action="{{ route('attendance.reports') }}" id="filterForm">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                            <!-- Filtro de Grado -->
                            <div>
                                <label for="grade_id" class="form-label-elegant">
                                    <i class="fas fa-graduation-cap mr-1 text-primary-500"></i> Grado
                                </label>
                                <select name="grade_id" id="grade_id" class="form-control-elegant" onchange="updateClassrooms()">
                                    <option value="">Todos los grados</option>
                                    @foreach($grades as $grade)
                                        <option value="{{ $grade->id }}" {{ request('grade_id') == $grade->id ? 'selected' : '' }}>
                                            {{ $grade->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <!-- Filtro de Sección -->
                            <div>
                                <label for="classroom_id" class="form-label-elegant">
                                    <i class="fas fa-door-open mr-1 text-primary-500"></i> Sección
                                </label>
                                <select name="classroom_id" id="classroom_id" class="form-control-elegant" disabled>
                                    <option value="">Primero seleccione un grado</option>
                                </select>
                            </div>
                            
                            <!-- Filtro de Fecha Desde -->
                            <div>
                                <label for="date_from" class="form-label-elegant">
                                    <i class="fas fa-calendar-alt mr-1 text-primary-500"></i> Fecha Desde
                                </label>
                                <input type="date" name="date_from" id="date_from" 
                                       class="form-control-elegant"
                                       value="{{ request('date_from') }}">
                            </div>
                            
                            <!-- Filtro de Fecha Hasta -->
                            <div>
                                <label for="date_to" class="form-label-elegant">
                                    <i class="fas fa-calendar-alt mr-1 text-primary-500"></i> Fecha Hasta
                                </label>
                                <input type="date" name="date_to" id="date_to" 
                                       class="form-control-elegant"
                                       value="{{ request('date_to') }}">
                            </div>
                        </div>
                        
                        <!-- Botones de acción -->
                        <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                            <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                                <button type="submit" class="btn-elegant bg-primary-500 hover:bg-primary-600 text-white">
                                    <i class="fas fa-filter mr-2"></i> Aplicar Filtros
                                </button>
                                <button type="button" class="btn-elegant bg-green-500 hover:bg-green-600 text-white" onclick="openExportModal()">
                                    <i class="fas fa-file-export mr-2"></i> Exportar Reporte SIAGIE
                                </button>
                            </div>
                            <div class="flex items-center space-x-2">
                                <label for="per_page" class="text-sm text-gray-600 font-medium">Mostrar:</label>
                                <select name="per_page" id="per_page" class="form-control-elegant w-20" onchange="this.form.submit()">
                                    <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                                    <option value="25" {{ request('per_page', 10) == 25 ? 'selected' : '' }}>25</option>
                                    <option value="50" {{ request('per_page', 10) == 50 ? 'selected' : '' }}>50</option>
                                    <option value="100" {{ request('per_page', 10) == 100 ? 'selected' : '' }}>100</option>
                                </select>
                            </div>
                            <a href="{{ route('attendance.reports') }}" class="text-sm text-gray-500 hover:text-gray-700 transition-colors">
                                <i class="fas fa-sync-alt mr-1"></i> Restablecer Filtros
                            </a>
                        </div>
                    </form>
                </div>
                
                <!-- Buscador rápido sobre la tabla -->
                <div class="search-bar">
                    <div class="flex-1">
                        <input type="text" id="quickSearch" class="form-control-elegant" placeholder="Buscar por DNI o nombre...">
                    </div>
                    <div class="text-sm text-gray-500">
                        <span id="tableCount">{{ $attendances->count() }}</span> registros encontrados
                    </div>
                </div>
                
                <!-- Tabla de resultados -->
                <!-- En tu archivo de vista de reportes, modifica la tabla: -->
                <div class="table-elegant overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200" id="attendanceTable">
                            <thead>
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo</th> <!-- NUEVA COLUMNA -->
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">DNI</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estudiante</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Grado</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sección</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hora</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @if($attendances->count() > 0)
                                    @foreach($attendances as $attendance)
                                    @php
                                        $isHoliday = isset($holidays[$attendance->date]);
                                        $holiday = $isHoliday ? $holidays[$attendance->date] : null;
                                    @endphp
                                    <tr class="hover:bg-gray-50 transition-colors {{ $isHoliday ? 'bg-yellow-50' : '' }}">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $attendance->created_at->format('d/m/Y') }}
                                            @if($isHoliday)
                                                <br><small class="text-yellow-600 font-semibold">Feriado</small>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            @if($isHoliday)
                                                <span class="badge-status bg-yellow-100 text-yellow-800" title="{{ $holiday->description }}">
                                                    <i class="fas fa-calendar-day mr-1"></i> {{ $holiday->reason }}
                                                </span>
                                            @else
                                                <span class="badge-status bg-blue-100 text-blue-800">
                                                    <i class="fas fa-school mr-1"></i> Clase Normal
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $attendance->student_dni }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $attendance->student->full_name ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $attendance->student->grade->name ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $attendance->student->classroom->name ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            @if($isHoliday && $holiday->no_classes)
                                                <span class="text-yellow-600 font-semibold">No hubo clase</span>
                                            @else
                                                {{ $attendance->time }}
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($isHoliday && $holiday->no_classes)
                                                <span class="badge-status bg-gray-100 text-gray-800">
                                                    <i class="fas fa-calendar-times mr-1"></i> Feriado
                                                </span>
                                            @else
                                                @if($attendance->status == 'present')
                                                    <span class="badge-status bg-green-100 text-green-800">
                                                        <i class="fas fa-check-circle"></i> Presente
                                                    </span>
                                                @elseif($attendance->status == 'late')
                                                    <span class="badge-status bg-yellow-100 text-yellow-800">
                                                        <i class="fas fa-clock"></i> Tardanza
                                                    </span>
                                                @elseif($attendance->status == 'absent')
                                                    <span class="badge-status bg-red-100 text-red-800">
                                                        <i class="fas fa-times-circle"></i> Falta
                                                    </span>
                                                @else
                                                    <span class="badge-status bg-blue-100 text-blue-800">
                                                        <i class="fas fa-file-alt"></i> Justificado
                                                    </span>
                                                @endif
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            @if(!$isHoliday || !$holiday->no_classes)
                                                <button type="button" 
                                                        class="text-indigo-600 hover:text-indigo-900 transition-colors p-2 rounded-lg hover:bg-indigo-50" 
                                                        onclick="openStudentReportModal('{{ $attendance->student_dni }}', '{{ $attendance->student->full_name ?? 'Estudiante' }}')" 
                                                        title="Generar reporte individual">
                                                    <i class="fas fa-file-excel text-green-500 text-lg"></i>
                                                </button>
                                            @else
                                                <span class="text-gray-400 text-sm">No disponible</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="9" class="px-6 py-8 text-center text-gray-500"> <!-- Cambiar colspan a 9 -->
                                            <i class="fas fa-inbox text-4xl mb-3 text-gray-300"></i>
                                            <p class="text-lg">No se encontraron registros de asistencia</p>
                                            <p class="text-sm mt-1">Intenta ajustar los filtros para ver más resultados</p>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- Paginación -->
                @if($attendances->count() > 0)
                <div class="mt-6 flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0">
                    <div class="text-sm text-gray-700">
                        Mostrando {{ $attendances->firstItem() }} a {{ $attendances->lastItem() }} de {{ $attendances->total() }} resultados
                    </div>
                    <div class="pagination-elegant">
                        {{ $attendances->appends(request()->query())->links() }}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal de Exportación SIAGIE -->
<!-- Modal de Exportación SIAGIE - Diseño Mejorado -->
<div id="exportModal" class="fixed inset-0 modal-elegant hidden">
    <div class="modal-content-elegant max-w-2xl">
        <div class="modal-scroll-indicator top" id="exportModalTopIndicator"></div>
        <div class="modal-scroll-indicator bottom" id="exportModalBottomIndicator"></div>
        <form method="GET" action="{{ route('attendance.export.siagie') }}">
            @csrf
            <input type="hidden" name="grade_id" id="modal_grade_id" value="">
            <input type="hidden" name="classroom_id" id="modal_classroom_id" value="">
            
            <!-- Encabezado del modal -->
            <div class="modal-header-elegant">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-r from-green-500 to-green-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-file-excel text-white text-lg"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">Exportar Reporte SIAGIE</h3>
                            <p class="text-sm text-gray-600 mt-1">Configura los parámetros para el formato oficial</p>
                        </div>
                    </div>
                    <button type="button" class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-gray-500 transition-colors rounded-lg hover:bg-gray-100" onclick="closeExportModal()">
                        <i class="fas fa-times text-lg"></i>
                    </button>
                </div>
            </div>
            
            <!-- Cuerpo del modal -->
            <div class="modal-body-elegant" id="exportModalBody" onscroll="updateScrollIndicators('exportModal')">
                <div class="space-y-6">
                    <!-- Filtros principales -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="modal_grade_select" class="form-label-elegant">
                                <i class="fas fa-graduation-cap mr-2 text-primary-500 text-sm"></i> Grado
                            </label>
                            <select name="modal_grade_id" id="modal_grade_select" class="form-control-elegant" onchange="updateModalClassrooms()">
                                <option value="">Todos los grados</option>
                                @foreach($grades as $grade)
                                    <option value="{{ $grade->id }}" {{ request('grade_id') == $grade->id ? 'selected' : '' }}>
                                        {{ $grade->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div>
                            <label for="modal_classroom_select" class="form-label-elegant">
                                <i class="fas fa-door-open mr-2 text-primary-500 text-sm"></i> Sección
                            </label>
                            <select name="modal_classroom_id" id="modal_classroom_select" class="form-control-elegant" disabled>
                                <option value="">Primero seleccione un grado</option>
                            </select>
                        </div>
                    </div>

                    <!-- Periodo del reporte -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="export_month" class="form-label-elegant">
                                <i class="fas fa-calendar-alt mr-2 text-primary-500 text-sm"></i> Mes
                            </label>
                            <select name="export_month" id="export_month" class="form-control-elegant" required>
                                <option value="">Seleccione mes</option>
                                <option value="1">Enero</option>
                                <option value="2">Febrero</option>
                                <option value="3">Marzo</option>
                                <option value="4">Abril</option>
                                <option value="5">Mayo</option>
                                <option value="6">Junio</option>
                                <option value="7">Julio</option>
                                <option value="8">Agosto</option>
                                <option value="9" selected>Septiembre</option>
                                <option value="10">Octubre</option>
                                <option value="11">Noviembre</option>
                                <option value="12">Diciembre</option>
                            </select>
                        </div>
                        
                        <div>
                            <label for="export_year" class="form-label-elegant">
                                <i class="fas fa-calendar mr-2 text-primary-500 text-sm"></i> Año
                            </label>
                            <input type="number" name="export_year" id="export_year" class="form-control-elegant" 
                                   value="{{ date('Y') }}" min="2020" max="2030" required>
                        </div>
                    </div>

                    <!-- Información del auxiliar -->
                    <div>
                        <label for="auxiliar_name" class="form-label-elegant">
                            <i class="fas fa-user-tie mr-2 text-primary-500 text-sm"></i> Auxiliar Responsable
                        </label>
                        <input type="text" name="auxiliar_name" id="auxiliar_name" class="form-control-elegant" 
                               value="LUISA SANCHEZ ARISTA" required>
                    </div>
                    
                    <!-- Campos SIAGIE automáticos -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="siagie_grade" class="form-label-elegant">Grado SIAGIE</label>
                            <div class="relative">
                                <input type="text" name="siagie_grade" id="siagie_grade" 
                                    class="form-control-elegant bg-gray-50 border-gray-200 text-gray-600 pr-10" 
                                    readonly required placeholder="Seleccione grado">
                                <div class="absolute right-3 top-1/2 transform -translate-y-1/2">
                                    <i class="fas fa-lock text-gray-400 text-sm"></i>
                                </div>
                            </div>
                            <small class="text-gray-500 text-xs mt-1 block">Se completa automáticamente</small>
                        </div>
                        <div>
                            <label for="siagie_section" class="form-label-elegant">Sección SIAGIE</label>
                            <div class="relative">
                                <input type="text" name="siagie_section" id="siagie_section" 
                                    class="form-control-elegant bg-gray-50 border-gray-200 text-gray-600 pr-10" 
                                    readonly required placeholder="Seleccione sección">
                                <div class="absolute right-3 top-1/2 transform -translate-y-1/2">
                                    <i class="fas fa-lock text-gray-400 text-sm"></i>
                                </div>
                            </div>
                            <small class="text-gray-500 text-xs mt-1 block">Se completa automáticamente</small>
                        </div>
                    </div>

                    <!-- Información del filtro aplicado -->
                    <div class="p-3 bg-blue-50 rounded-lg border border-blue-200">
                        <div class="flex items-start space-x-2">
                            <i class="fas fa-info-circle text-blue-500 mt-0.5 text-sm"></i>
                            <div class="flex-1">
                                <h4 class="text-sm font-semibold text-blue-800 mb-1">Resumen del Reporte</h4>
                                <p class="text-xs text-gray-600" id="filterInfo">
                                    Seleccione el grado y sección para el reporte
                                </p>
                                <p class="text-xs text-blue-600 font-medium mt-1" id="selectedFilters">
                                    <!-- Aquí se mostrarán los filtros seleccionados -->
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Pie del modal -->
            <div class="modal-footer-elegant">
                <div class="flex flex-col sm:flex-row justify-end space-y-2 sm:space-y-0 sm:space-x-3">
                    <button type="button" class="btn-secondary" onclick="closeExportModal()">
                        <i class="fas fa-times mr-2"></i> Cancelar
                    </button>
                    <button type="submit" class="btn-primary" id="exportSubmitBtn">
                        <i class="fas fa-file-excel mr-2"></i> Generar Reporte
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal de Reporte Individual - Diseño Mejorado -->
<div id="studentReportModal" class="fixed inset-0 modal-elegant hidden">
    <div class="modal-content-elegant max-w-lg">
        <div class="modal-scroll-indicator top" id="studentModalTopIndicator"></div>
        <div class="modal-scroll-indicator bottom" id="studentModalBottomIndicator"></div>
        <form method="POST" action="{{ route('attendance.export.student') }}">
            @csrf
            <input type="hidden" name="student_dni" id="student_dni" value="">
            
            <!-- Encabezado del modal -->
            <div class="modal-header-elegant">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-user-graduate text-white text-lg"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900" id="studentReportTitle">Reporte Individual</h3>
                            <p class="text-sm text-gray-600 mt-1">Generar reporte personalizado del estudiante</p>
                        </div>
                    </div>
                    <button type="button" class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-gray-500 transition-colors rounded-lg hover:bg-gray-100" onclick="closeStudentReportModal()">
                        <i class="fas fa-times text-lg"></i>
                    </button>
                </div>
            </div>
            
            <div class="modal-body-elegant" id="studentModalBody" onscroll="updateScrollIndicators('studentReportModal')">
                <!-- Información del estudiante -->
                <div id="studentInfo" class="mb-4 p-3 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg border border-blue-200">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-blue-600 text-sm"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-semibold text-blue-800" id="studentName"></p>
                            <p class="text-xs text-blue-600 mt-1" id="studentDetails"></p>
                        </div>
                    </div>
                </div>
                
                <div class="space-y-5">
                    <!-- Rango de fechas -->
                    <div>
                        <h4 class="text-sm font-semibold text-gray-700 mb-3 flex items-center">
                            <i class="fas fa-calendar-week mr-2 text-primary-500"></i>
                            Rango de Fechas
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <div>
                                <label for="student_date_from" class="form-label-elegant text-xs">Fecha Desde</label>
                                <input type="date" name="date_from" id="student_date_from" class="form-control-elegant" required>
                            </div>
                            
                            <div>
                                <label for="student_date_to" class="form-label-elegant text-xs">Fecha Hasta</label>
                                <input type="date" name="date_to" id="student_date_to" class="form-control-elegant" required>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Información SIAGIE -->
                    <div class="p-3 bg-green-50 rounded-lg border border-green-200">
                        <h4 class="text-sm font-semibold text-green-800 mb-2 flex items-center">
                            <i class="fas fa-file-contract mr-2 text-green-500"></i>
                            Información SIAGIE
                        </h4>
                        <div class="grid grid-cols-2 gap-4 text-xs">
                            <div>
                                <span class="text-gray-600 block">Grado:</span>
                                <span class="font-semibold text-green-700" id="siagieGradeInfo">-</span>
                            </div>
                            <div>
                                <span class="text-gray-600 block">Sección:</span>
                                <span class="font-semibold text-green-700" id="siagieSectionInfo">-</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Formato del reporte -->
                    <div>
                        <h4 class="text-sm font-semibold text-gray-700 mb-3 flex items-center">
                            <i class="fas fa-cog mr-2 text-primary-500"></i>
                            Formato de Salida
                        </h4>
                        <div class="space-y-2">
                            <label class="format-option">
                                <input type="radio" name="format" value="siagie" class="format-radio" checked>
                                <div class="format-content">
                                    <div class="format-header">
                                        <span class="format-title">Formato SIAGIE Oficial</span>
                                        <span class="format-badge">Recomendado</span>
                                    </div>
                                    <span class="format-description">Compatible con el sistema ministerial</span>
                                </div>
                            </label>
                            
                            <label class="format-option">
                                <input type="radio" name="format" value="simple" class="format-radio">
                                <div class="format-content">
                                    <div class="format-header">
                                        <span class="format-title">Formato Simple</span>
                                    </div>
                                    <span class="format-description">Para uso interno y análisis</span>
                                </div>
                            </label>
                        </div>
                    </div>
                    
                    <!-- Información adicional -->
                    <div class="p-2 bg-amber-50 rounded border border-amber-200">
                        <div class="flex items-start space-x-2">
                            <i class="fas fa-info-circle text-amber-500 mt-0.5 text-sm"></i>
                            <p class="text-xs text-amber-700">
                                El formato SIAGIE genera un reporte oficial compatible con todos los requisitos del sistema ministerial.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Pie del modal -->
            <div class="modal-footer-elegant">
                <div class="flex flex-col sm:flex-row justify-end space-y-2 sm:space-y-0 sm:space-x-3">
                    <button type="button" class="btn-secondary" onclick="closeStudentReportModal()">
                        <i class="fas fa-times mr-2"></i> Cancelar
                    </button>
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-file-excel mr-2"></i> Generar Reporte
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

    <script>
        // Datos de secciones por grado (simulados)
        const classroomsByGrade = {!! $grades->mapWithKeys(function($grade) {
            return [
                $grade->id => $grade->classrooms->map(function($classroom) {
                    return [
                        'id' => $classroom->id,
                        'name' => addslashes($classroom->name)
                    ];
                })->toArray()
            ];
        })->toJson() !!};

        // Funciones para manejar el modal de exportación SIAGIE
        function openExportModal() {
            document.getElementById('exportModal').classList.remove('hidden');
            
            // Limpiar campos SIAGIE al abrir el modal
            document.getElementById('siagie_grade').value = '';
            document.getElementById('siagie_section').value = '';
            
            // Establecer valores por defecto
            const today = new Date();
            document.getElementById('export_month').value = today.getMonth() + 1;
            document.getElementById('export_year').value = today.getFullYear();
            
            // Obtener los filtros actuales del formulario principal
            const currentGradeId = document.getElementById('grade_id').value;
            const currentClassroomId = document.getElementById('classroom_id').value;
            const currentGradeName = document.getElementById('grade_id').options[document.getElementById('grade_id').selectedIndex]?.text || '';
            const currentClassroomName = document.getElementById('classroom_id').options[document.getElementById('classroom_id').selectedIndex]?.text || '';
            
            // Sincronizar con los filtros del modal
            if (currentGradeId) {
                document.getElementById('modal_grade_select').value = currentGradeId;
                updateModalClassrooms();
            } else {
                // Asegurarse de que los campos SIAGIE estén vacíos
                document.getElementById('siagie_grade').value = '';
                document.getElementById('siagie_section').value = '';
            }
            
            if (currentClassroomId) {
                setTimeout(() => {
                    document.getElementById('modal_classroom_select').value = currentClassroomId;
                    // Sincronizar campos SIAGIE después de establecer la sección
                    setTimeout(() => {
                        syncSiagieFields();
                    }, 100);
                }, 100);
            }
            
            // Actualizar la información de filtros aplicados
            updateFilterInfo(currentGradeName, currentClassroomName);
            
            // Validar formulario
            validateSiagieForm();

            // Actualizar indicadores de scroll
            setTimeout(() => {
                updateScrollIndicators('exportModal');
            }, 100);
        }

        // Actualizar secciones en el modal según el grado seleccionado
        function updateModalClassrooms() {
            const gradeSelect = document.getElementById('modal_grade_select');
            const classroomSelect = document.getElementById('modal_classroom_select');
            const selectedGradeId = gradeSelect.value;
            const selectedGradeName = gradeSelect.options[gradeSelect.selectedIndex]?.text || '';
            
            // Limpiar campos SIAGIE cuando cambia el grado
            document.getElementById('siagie_grade').value = '';
            document.getElementById('siagie_section').value = '';
            
            // Limpiar opciones actuales
            classroomSelect.innerHTML = '';
            
            if (selectedGradeId) {
                // Habilitar el select de secciones
                classroomSelect.disabled = false;
                
                // Obtener las secciones del grado seleccionado
                const classrooms = classroomsByGrade[selectedGradeId] || [];
                
                // Agregar opción por defecto
                const defaultOption = document.createElement('option');
                defaultOption.value = '';
                defaultOption.textContent = 'Todas las secciones';
                classroomSelect.appendChild(defaultOption);
                
                // Agregar las secciones del grado
                classrooms.forEach(classroom => {
                    const option = document.createElement('option');
                    option.value = classroom.id;
                    option.textContent = classroom.name;
                    classroomSelect.appendChild(option);
                });
                
                // Actualizar campos ocultos
                document.getElementById('modal_grade_id').value = selectedGradeId;
                
                // Actualizar información de filtros
                updateFilterInfo(selectedGradeName, '');
                
            } else {
                // Deshabilitar el select de secciones
                classroomSelect.disabled = true;
                
                // Agregar opción por defecto
                const defaultOption = document.createElement('option');
                defaultOption.value = '';
                defaultOption.textContent = 'Primero seleccione un grado';
                classroomSelect.appendChild(defaultOption);
                
                // Limpiar campos ocultos
                document.getElementById('modal_grade_id').value = '';
                document.getElementById('modal_classroom_id').value = '';
                
                // Actualizar información de filtros
                updateFilterInfo('', '');
            }
            
            // Validar formulario
            validateSiagieForm();
        }

        // Actualizar el texto del botón según el formato seleccionado
        document.addEventListener('DOMContentLoaded', function() {
            const formatRadios = document.querySelectorAll('input[name="format"]');
            const submitButton = document.querySelector('#studentReportModal button[type="submit"]');
            const submitText = submitButton.querySelector('span');
            
            formatRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    if (this.value === 'siagie') {
                        submitText.textContent = 'Generar Reporte SIAGIE';
                        submitButton.classList.remove('bg-green-500', 'hover:bg-green-600');
                        submitButton.classList.add('bg-green-600', 'hover:bg-green-700');
                    } else {
                        submitText.textContent = 'Generar Reporte Simple';
                        submitButton.classList.remove('bg-green-600', 'hover:bg-green-700');
                        submitButton.classList.add('bg-green-500', 'hover:bg-green-600');
                    }
                });
            });
        });

        // Agregar event listeners para sincronización automática
        document.addEventListener('DOMContentLoaded', function() {
            // Sincronizar cuando cambie el grado en el modal
            document.getElementById('modal_grade_select').addEventListener('change', function() {
                // Limpiar campos SIAGIE cuando cambia el grado
                document.getElementById('siagie_grade').value = '';
                document.getElementById('siagie_section').value = '';
                setTimeout(() => {
                    syncSiagieFields();
                }, 150);
            });
            
            // Sincronizar cuando cambie la sección en el modal
            document.getElementById('modal_classroom_select').addEventListener('change', function() {
                syncSiagieFields();
            });
            
            // Inicializar las secciones según el grado seleccionado en el formulario principal
            updateClassrooms();
            updateModalClassrooms();
            
            // Verificar si hay parámetros de búsqueda y mostrarlos
            const urlParams = new URLSearchParams(window.location.search);
            const searchParam = urlParams.get('search');
            if (searchParam) {
                document.getElementById('quickSearch').value = searchParam;
                document.getElementById('quickSearch').dispatchEvent(new Event('input'));
            }
        });

        // Función para sincronizar los campos de SIAGIE con los filtros del modal
        function syncSiagieFields() {
            const gradeSelect = document.getElementById('modal_grade_select');
            const classroomSelect = document.getElementById('modal_classroom_select');
            const siagieGradeInput = document.getElementById('siagie_grade');
            const siagieSectionInput = document.getElementById('siagie_section');
            
            const selectedGradeName = gradeSelect.options[gradeSelect.selectedIndex]?.text || '';
            const selectedClassroomName = classroomSelect.options[classroomSelect.selectedIndex]?.text || '';
            
            // Solo llenar si ambos campos están seleccionados
            if (selectedGradeName && selectedClassroomName && selectedClassroomName !== 'Todas las secciones') {
                // Sincronizar grado SIAGIE
                const gradeMapping = {
                    'PRIMERO': 'PRIMERO',
                    'PRIMER': 'PRIMERO',
                    '1RO': 'PRIMERO',
                    '1ERO': 'PRIMERO',
                    '1°': 'PRIMERO',
                    'SEGUNDO': 'SEGUNDO', 
                    '2DO': 'SEGUNDO',
                    '2°': 'SEGUNDO',
                    'TERCERO': 'TERCERO',
                    '3RO': 'TERCERO',
                    '3°': 'TERCERO',
                    'CUARTO': 'CUARTO',
                    '4TO': 'CUARTO',
                    '4°': 'CUARTO',
                    'QUINTO': 'QUINTO',
                    '5TO': 'QUINTO',
                    '5°': 'QUINTO'
                };
                
                // Buscar coincidencia en el mapeo
                let siagieGradeValue = '';
                const upperGradeName = selectedGradeName.toUpperCase().trim();
                
                for (const [key, value] of Object.entries(gradeMapping)) {
                    if (upperGradeName.includes(key)) {
                        siagieGradeValue = value;
                        break;
                    }
                }
                
                // Si no se encontró coincidencia, intentar extraer el número
                if (!siagieGradeValue) {
                    const gradeNumber = upperGradeName.match(/\d+/);
                    if (gradeNumber) {
                        const number = parseInt(gradeNumber[0]);
                        const numberMapping = {
                            1: 'PRIMERO',
                            2: 'SEGUNDO', 
                            3: 'TERCERO',
                            4: 'CUARTO',
                            5: 'QUINTO'
                        };
                        siagieGradeValue = numberMapping[number] || '';
                    }
                }
                
                // Establecer el valor en el input SIAGIE
                siagieGradeInput.value = siagieGradeValue || 'PRIMERO';
                
                // Sincronizar sección SIAGIE
                const sectionMatch = selectedClassroomName.match(/[A-E]/i);
                if (sectionMatch) {
                    const sectionLetter = sectionMatch[0].toUpperCase();
                    siagieSectionInput.value = sectionLetter;
                } else {
                    // Si no se encuentra letra, usar la primera letra del nombre
                    siagieSectionInput.value = selectedClassroomName.charAt(0).toUpperCase();
                }
            } else {
                // Limpiar campos si no hay selección completa
                siagieGradeInput.value = '';
                siagieSectionInput.value = '';
            }
            
            // Validar que ambos campos tengan valor antes de permitir enviar
            validateSiagieForm();
        }

        // Función para validar el formulario SIAGIE
        function validateSiagieForm() {
            const siagieGrade = document.getElementById('siagie_grade').value;
            const siagieSection = document.getElementById('siagie_section').value;
            const submitButton = document.querySelector('#exportModal button[type="submit"]');
            
            if (siagieGrade && siagieSection) {
                submitButton.disabled = false;
                submitButton.classList.remove('opacity-50', 'cursor-not-allowed');
            } else {
                submitButton.disabled = true;
                submitButton.classList.add('opacity-50', 'cursor-not-allowed');
            }
        }

        // Actualizar cuando cambie la sección en el modal
        document.getElementById('modal_classroom_select').addEventListener('change', function() {
            const classroomId = this.value;
            const classroomName = this.options[this.selectedIndex]?.text || '';
            document.getElementById('modal_classroom_id').value = classroomId;
            
            const gradeSelect = document.getElementById('modal_grade_select');
            const gradeName = gradeSelect.options[gradeSelect.selectedIndex]?.text || '';
            
            updateFilterInfo(gradeName, classroomName);
        });

        function updateFilterInfo(gradeName, classroomName) {
            const filterInfo = document.getElementById('filterInfo');
            const selectedFilters = document.getElementById('selectedFilters');
            
            if (gradeName || classroomName) {
                let infoText = 'Se generará el reporte para: ';
                let filtersText = '';
                
                if (gradeName) {
                    infoText += `Grado ${gradeName}`;
                    filtersText += `Grado: ${gradeName}`;
                }
                
                if (classroomName && classroomName !== 'Todas las secciones') {
                    infoText += gradeName ? `, Sección ${classroomName}` : `Sección ${classroomName}`;
                    filtersText += filtersText ? `, Sección: ${classroomName}` : `Sección: ${classroomName}`;
                }
                
                filterInfo.textContent = infoText;
                selectedFilters.textContent = filtersText;
            } else {
                filterInfo.textContent = 'Se generará el reporte con todos los estudiantes (sin filtros aplicados).';
                selectedFilters.textContent = '';
            }
        }

        function closeExportModal() {
            document.getElementById('exportModal').classList.add('hidden');
        }

        // Inicializar las secciones del modal al cargar la página
        document.addEventListener('DOMContentLoaded', function() {
            // Actualizar secciones según el grado seleccionado en el formulario principal
            updateClassrooms();
            updateModalClassrooms();
            
            // Verificar si hay parámetros de búsqueda y mostrarlos
            const urlParams = new URLSearchParams(window.location.search);
            const searchParam = urlParams.get('search');
            if (searchParam) {
                document.getElementById('quickSearch').value = searchParam;
                document.getElementById('quickSearch').dispatchEvent(new Event('input'));
            }
        });

        // Actualizar información cuando cambien los filtros
        document.getElementById('grade_id').addEventListener('change', function() {
            setTimeout(() => {
                const gradeName = this.options[this.selectedIndex]?.text || '';
                const classroomSelect = document.getElementById('classroom_id');
                const classroomName = classroomSelect.options[classroomSelect.selectedIndex]?.text || '';
                updateFilterInfo(gradeName, classroomName);
            }, 100);
        });

        document.getElementById('classroom_id').addEventListener('change', function() {
            const gradeSelect = document.getElementById('grade_id');
            const gradeName = gradeSelect.options[gradeSelect.selectedIndex]?.text || '';
            const classroomName = this.options[this.selectedIndex]?.text || '';
            updateFilterInfo(gradeName, classroomName);
        });

        // Funciones para manejar el modal de reporte individual
        function openStudentReportModal(studentDni, studentName) {
            if (!studentDni) {
                alert('Error: No se pudo identificar al estudiante');
                return;
            }
            
            // Buscar información completa del estudiante
            fetch(`/api/student-info/${studentDni}`)
                .then(response => response.json())
                .then(student => {
                    document.getElementById('student_dni').value = studentDni;
                    document.getElementById('studentName').textContent = 'Generando reporte para: ' + studentName;
                    document.getElementById('studentReportTitle').textContent = 'Reporte: ' + studentName;
                    
                    // Mostrar detalles del estudiante
                    document.getElementById('studentDetails').textContent = 
                        `${student.grade || 'N/A'} - ${student.classroom || 'N/A'}`;
                    
                    // Mostrar información SIAGIE
                    document.getElementById('siagieGradeInfo').textContent = convertToSiagieGrade(student.grade || 'PRIMERO');
                    document.getElementById('siagieSectionInfo').textContent = extractSection(student.classroom || 'A');
                    
                    document.getElementById('studentReportModal').classList.remove('hidden');
                    
                    // Establecer fecha por defecto (últimos 30 días)
                    const today = new Date();
                    const thirtyDaysAgo = new Date(today);
                    thirtyDaysAgo.setDate(today.getDate() - 30);
                    
                    document.getElementById('student_date_from').value = thirtyDaysAgo.toISOString().split('T')[0];
                    document.getElementById('student_date_to').value = today.toISOString().split('T')[0];

                    // Actualizar indicadores de scroll
                    setTimeout(() => {
                        updateScrollIndicators('studentReportModal');
                    }, 100);
                })
                .catch(error => {
                    console.error('Error al cargar información del estudiante:', error);
                    // Si hay error, abrir el modal con información básica
                    openBasicStudentModal(studentDni, studentName);
                });
        }

        // Función auxiliar para abrir modal con información básica
        function openBasicStudentModal(studentDni, studentName) {
            document.getElementById('student_dni').value = studentDni;
            document.getElementById('studentName').textContent = 'Generando reporte para: ' + studentName;
            document.getElementById('studentReportTitle').textContent = 'Reporte: ' + studentName;
            document.getElementById('studentDetails').textContent = 'Información completa no disponible';
            document.getElementById('siagieGradeInfo').textContent = 'PRIMERO';
            document.getElementById('siagieSectionInfo').textContent = 'A';
            
            document.getElementById('studentReportModal').classList.remove('hidden');
            
            const today = new Date();
            const thirtyDaysAgo = new Date(today);
            thirtyDaysAgo.setDate(today.getDate() - 30);
            
            document.getElementById('student_date_from').value = thirtyDaysAgo.toISOString().split('T')[0];
            document.getElementById('student_date_to').value = today.toISOString().split('T')[0];

            // Actualizar indicadores de scroll
            setTimeout(() => {
                updateScrollIndicators('studentReportModal');
            }, 100);
        }

        // Función para convertir grado a formato SIAGIE
        function convertToSiagieGrade(gradeName) {
            const gradeMapping = {
                'PRIMERO': 'PRIMERO',
                'PRIMER': 'PRIMERO',
                '1RO': 'PRIMERO',
                '1ERO': 'PRIMERO',
                '1°': 'PRIMERO',
                'SEGUNDO': 'SEGUNDO', 
                '2DO': 'SEGUNDO',
                '2°': 'SEGUNDO',
                'TERCERO': 'TERCERO',
                '3RO': 'TERCERO',
                '3°': 'TERCERO',
                'CUARTO': 'CUARTO',
                '4TO': 'CUARTO',
                '4°': 'CUARTO',
                'QUINTO': 'QUINTO',
                '5TO': 'QUINTO',
                '5°': 'QUINTO'
            };
            
            const upperGradeName = gradeName.toUpperCase().trim();
            
            for (const [key, value] of Object.entries(gradeMapping)) {
                if (upperGradeName.includes(key)) {
                    return value;
                }
            }
            
            // Si no se encuentra, intentar extraer número
            const gradeNumber = upperGradeName.match(/\d+/);
            if (gradeNumber) {
                const number = parseInt(gradeNumber[0]);
                const numberMapping = {
                    1: 'PRIMERO',
                    2: 'SEGUNDO', 
                    3: 'TERCERO',
                    4: 'CUARTO',
                    5: 'QUINTO'
                };
                return numberMapping[number] || 'PRIMERO';
            }
            
            return 'PRIMERO';
        }

        // Función para extraer sección
        function extractSection(classroomName) {
            const sectionMatch = classroomName.match(/[A-E]/i);
            if (sectionMatch) {
                return sectionMatch[0].toUpperCase();
            }
            return classroomName.charAt(0).toUpperCase();
        }

        function closeStudentReportModal() {
            document.getElementById('studentReportModal').classList.add('hidden');
        }

        // Función para actualizar indicadores de scroll
        function updateScrollIndicators(modalId) {
            const modalBody = document.getElementById(modalId === 'exportModal' ? 'exportModalBody' : 'studentModalBody');
            const topIndicator = document.getElementById(modalId === 'exportModal' ? 'exportModalTopIndicator' : 'studentModalTopIndicator');
            const bottomIndicator = document.getElementById(modalId === 'exportModal' ? 'exportModalBottomIndicator' : 'studentModalBottomIndicator');
            
            if (!modalBody) return;
            
            const scrollTop = modalBody.scrollTop;
            const scrollHeight = modalBody.scrollHeight;
            const clientHeight = modalBody.clientHeight;
            
            // Mostrar indicador superior si no está en la parte superior
            if (scrollTop > 10) {
                topIndicator.classList.add('visible');
            } else {
                topIndicator.classList.remove('visible');
            }
            
            // Mostrar indicador inferior si no está en la parte inferior
            if (scrollTop + clientHeight < scrollHeight - 10) {
                bottomIndicator.classList.add('visible');
            } else {
                bottomIndicator.classList.remove('visible');
            }
        }
        
        // Cerrar modales al hacer clic fuera de ellos
        document.getElementById('exportModal').addEventListener('click', function(e) {
            if (e.target.id === 'exportModal') {
                closeExportModal();
            }
        });
        
        document.getElementById('studentReportModal').addEventListener('click', function(e) {
            if (e.target.id === 'studentReportModal') {
                closeStudentReportModal();
            }
        });

        // Cerrar modales con tecla Escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeExportModal();
                closeStudentReportModal();
                closeProfileMenu();
            }
        });

        // Búsqueda rápida en la tabla
        document.getElementById('quickSearch').addEventListener('input', function() {
            const searchText = this.value.toLowerCase();
            const table = document.getElementById('attendanceTable');
            const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
            let count = 0;
            
            for (let i = 0; i < rows.length; i++) {
                const cells = rows[i].getElementsByTagName('td');
                let found = false;
                
                for (let j = 0; j < cells.length; j++) {
                    const cellText = cells[j].textContent || cells[j].innerText;
                    if (cellText.toLowerCase().indexOf(searchText) > -1) {
                        found = true;
                        break;
                    }
                }
                
                if (found) {
                    rows[i].style.display = '';
                    count++;
                } else {
                    rows[i].style.display = 'none';
                }
            }
            
            document.getElementById('tableCount').textContent = count;
        });

        // Actualizar secciones según el grado seleccionado
        function updateClassrooms() {
            const gradeSelect = document.getElementById('grade_id');
            const classroomSelect = document.getElementById('classroom_id');
            const selectedGradeId = gradeSelect.value;
            const selectedGradeName = gradeSelect.options[gradeSelect.selectedIndex]?.text || '';
            
            // Limpiar opciones actuales
            classroomSelect.innerHTML = '';
            
            if (selectedGradeId) {
                // Habilitar el select de secciones
                classroomSelect.disabled = false;
                
                // Obtener las secciones del grado seleccionado
                const classrooms = classroomsByGrade[selectedGradeId] || [];
                
                // Agregar opción por defecto
                const defaultOption = document.createElement('option');
                defaultOption.value = '';
                defaultOption.textContent = 'Todas las secciones';
                classroomSelect.appendChild(defaultOption);
                
                // Agregar las secciones del grado
                classrooms.forEach(classroom => {
                    const option = document.createElement('option');
                    option.value = classroom.id;
                    option.textContent = classroom.name;
                    
                    // Marcar como seleccionada si coincide con el valor actual
                    const currentClassroomId = "{{ request('classroom_id') }}";
                    if (currentClassroomId == classroom.id) {
                        option.selected = true;
                    }
                    
                    classroomSelect.appendChild(option);
                });
            } else {
                // Deshabilitar el select de secciones
                classroomSelect.disabled = true;
                
                // Agregar opción por defecto
                const defaultOption = document.createElement('option');
                defaultOption.value = '';
                defaultOption.textContent = 'Primero seleccione un grado';
                classroomSelect.appendChild(defaultOption);
            }
        }

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

        // Inicializar las secciones al cargar la página
        document.addEventListener('DOMContentLoaded', function() {
            // Actualizar secciones según el grado seleccionado
            updateClassrooms();
            
            // Verificar si hay parámetros de búsqueda y mostrarlos
            const urlParams = new URLSearchParams(window.location.search);
            const searchParam = urlParams.get('search');
            if (searchParam) {
                document.getElementById('quickSearch').value = searchParam;
                document.getElementById('quickSearch').dispatchEvent(new Event('input'));
            }
        });
    </script>
</body>
</html>