<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Alumno - Sistema Escolar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
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

        /* Botones azules con hover celeste */
        .btn-blue-hover-celeste {
            background: linear-gradient(135deg, var(--primary-light) 0%, var(--primary-color) 100%);
            color: white;
            border: none;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);
        }

        .btn-blue-hover-celeste:hover {
            background: linear-gradient(135deg, #00c6ff 0%, #0072ff 100%);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 198, 255, 0.4);
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

        .file-upload-title {
            color: var(--text-primary);
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .file-upload-subtitle {
            color: var(--text-muted);
            margin-bottom: 0.5rem;
        }

        .file-upload-info {
            color: var(--text-muted);
            font-size: 0.875rem;
        }

        /* Preview de archivo */
        .file-preview {
            animation: slideInUp 0.4s ease-out;
            border-left: 4px solid var(--success-color);
            background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
            border-radius: 12px;
            padding: 1.5rem;
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
            display: flex;
            align-items: center;
        }

        .file-icon {
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(40, 167, 69, 0.1);
            border-radius: 10px;
        }

        .file-details {
            flex: 1;
        }

        .file-name {
            color: var(--text-primary);
            font-size: 1rem;
        }

        .file-size {
            font-size: 0.875rem;
            color: var(--text-muted);
        }

        /* Lista de características */
        .feature-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .feature-item {
            padding: 0.5rem 0;
            display: flex;
            align-items: center;
        }

        /* Quick actions */
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

        /* Pestañas personalizadas */
        .nav-tabs {
            border-bottom: 2px solid rgba(255, 255, 255, 0.2);
        }

        .nav-tabs .nav-link {
            border: none;
            color: rgba(255, 255, 255, 0.8);
            font-weight: 500;
            padding: 1rem 1.5rem;
            transition: var(--transition);
            background: transparent;
        }

        .nav-tabs .nav-link.active {
            background: transparent;
            color: white;
            border-bottom: 3px solid white;
        }

        .nav-tabs .nav-link:hover {
            color: white;
            border-color: transparent;
            transform: translateY(-2px);
        }

        /* Icono de importación */
        .import-icon {
            font-size: 4rem;
            color: var(--primary-color);
        }

        /* Lista de requisitos */
        .requirements-list {
            background: rgba(248, 249, 250, 0.8);
            border-radius: 12px;
            padding: 1.5rem;
        }

        .requirement-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 0.75rem;
        }

        .requirement-item:last-child {
            margin-bottom: 0;
        }

        /* Alertas Mejoradas */
        .alert-glass {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
        }

        /* Breadcrumb Mejorado */
        .breadcrumb-glass {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 12px;
            padding: 1rem 1.5rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: var(--card-shadow);
        }

        .breadcrumb-glass .breadcrumb-item a {
            color: var(--text-secondary);
            text-decoration: none;
            transition: var(--transition);
            font-weight: 500;
        }

        .breadcrumb-glass .breadcrumb-item a:hover {
            color: var(--primary-color);
            transform: translateY(-1px);
        }

        .breadcrumb-glass .breadcrumb-item.active {
            color: var(--primary-color);
            font-weight: 600;
        }

        /* File input mejorado */
        .file-input-glass {
            position: relative;
        }

        .file-input-label {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            border: 2px dashed #cbd5e1;
            border-radius: 12px;
            padding: 0.75rem 1rem;
            text-align: center;
            cursor: pointer;
            transition: var(--transition);
            display: block;
            font-weight: 500;
        }

        .file-input-label:hover {
            border-color: var(--primary-light);
            background: rgba(59, 130, 246, 0.05);
            transform: translateY(-2px);
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
                font-size: 1.75rem;
            }
            .file-upload-area {
                padding: 2rem 1rem;
            }
            .file-upload-icon {
                font-size: 2.5rem;
            }
            .nav-tabs .nav-link {
                padding: 0.75rem 1rem;
                font-size: 0.9rem;
            }
            .quick-action-item {
                padding: 0.75rem;
            }
            .action-icon {
                width: 35px;
                height: 35px;
                margin-right: 0.75rem;
            }
        }
        
        .date-indicator {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            padding: 0.5rem 1rem;
            border: 1px solid rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            font-weight: 500;
        }

        /* Nuevos estilos para la reorganización */
        .form-sidebar {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            height: 100%;
        }

        .import-sidebar {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            height: 100%;
        }

        .requirements-card {
            height: 100%;
        }

        .actions-card {
            height: 100%;
        }

        .tab-content-container {
            display: flex;
            flex-direction: column;
            min-height: 100%;
        }

        .form-container {
            flex: 1;
        }

        .import-container {
            flex: 1;
        }

        @media (max-width: 1199.98px) {
            .form-sidebar, .import-sidebar {
                margin-top: 2rem;
            }
        }

        /* Estilos mejorados para las tarjetas de información */
        .info-card {
            border-left: 4px solid var(--primary-color);
            transition: var(--transition);
        }

        .info-card:hover {
            border-left-color: var(--primary-light);
            transform: translateX(5px);
        }

        .requirement-card {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            border-left: 4px solid var(--success-color);
        }

        .requirement-card .card-header-glass {
            background: linear-gradient(135deg, var(--success-color) 0%, #047857 100%);
        }

        /* Layout mejorado para formulario e información */
        .main-form-container {
            display: flex;
            gap: 2rem;
            align-items: flex-start;
        }

        .form-section {
            flex: 1;
        }

        .info-section {
            width: 400px;
            flex-shrink: 0;
        }

        @media (max-width: 1200px) {
            .main-form-container {
                flex-direction: column;
            }
            
            .info-section {
                width: 100%;
            }
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
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Dashboard Header Profesional - Azul Oscuro Mejorado -->
        <div class="dashboard-header">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="h2 fw-bold mb-2">
                        <i class="bi bi-plus-circle me-3"></i>Nuevo Alumno
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
                                <i class="bi bi-plus-circle me-1"></i>Nuevo
                            </li>
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

        <!-- Contenido existente -->
        <div class="container-fluid py-4">
            <!-- Breadcrumb mejorado -->

            @if($grades->isEmpty())
            <div class="alert alert-danger alert-glass">
                <div class="d-flex align-items-center">
                    <i class="bi bi-exclamation-triangle-fill me-3 fs-4"></i>
                    <div>
                        <h5 class="alert-heading mb-1">Configuración requerida</h5>
                        <p class="mb-0">No hay grados configurados en el sistema. Contacta al administrador para configurar los grados y secciones.</p>
                    </div>
                </div>
            </div>
            @else
            <div class="main-form-container">
                <!-- Sección del formulario -->
                <div class="form-section">
                    <!-- Pestañas para elegir entre agregar individual o importar masivo -->
                    <div class="card card-glass mb-4">
                        <div class="card-header card-header-glass">
                            <ul class="nav nav-tabs card-header-tabs" id="studentTabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="individual-tab" data-bs-toggle="tab" 
                                            data-bs-target="#individual" type="button" role="tab" 
                                            aria-controls="individual" aria-selected="true">
                                        <i class="bi bi-person-plus me-2"></i>Agregar Individual
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="import-tab" data-bs-toggle="tab" 
                                            data-bs-target="#import" type="button" role="tab" 
                                            aria-controls="import" aria-selected="false">
                                        <i class="bi bi-upload me-2"></i>Importar Masivo
                                    </button>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="studentTabsContent">
                                <!-- Pestaña de agregar individual -->
                                <div class="tab-pane fade show active" id="individual" role="tabpanel" aria-labelledby="individual-tab">
                                    <div class="form-container">
                                        <form method="POST" action="{{ route('students.store') }}" enctype="multipart/form-data" id="individualForm">
                                            @csrf

                                            <div class="row mb-4">
                                                <div class="col-md-6">
                                                    <label for="dni" class="form-label label-required">DNI</label>
                                                    <div class="input-group input-group-glass">
                                                        <span class="input-group-text bg-light border-end-0">
                                                            <i class="bi bi-credit-card text-primary"></i>
                                                        </span>
                                                        <input type="text" class="form-control @error('dni') is-invalid @enderror ps-0" 
                                                               id="dni" name="dni" value="{{ old('dni') }}" 
                                                               placeholder="Ingrese el DNI" required>
                                                    </div>
                                                    @error('dni')
                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row mb-4">
                                                <div class="col-md-6">
                                                    <label for="first_name" class="form-label label-required">Nombres</label>
                                                    <div class="input-group input-group-glass">
                                                        <span class="input-group-text bg-light border-end-0">
                                                            <i class="bi bi-person text-primary"></i>
                                                        </span>
                                                        <input type="text" class="form-control @error('first_name') is-invalid @enderror ps-0" 
                                                               id="first_name" name="first_name" value="{{ old('first_name') }}" 
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
                                                               id="last_name" name="last_name" value="{{ old('last_name') }}" 
                                                               placeholder="Ingrese los apellidos" required>
                                                    </div>
                                                    @error('last_name')
                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row mb-4">
                                                <div class="col-md-6">
                                                    <label for="guardian_phone" class="form-label label-required">Teléfono del Apoderado</label>
                                                    <div class="input-group input-group-glass">
                                                        <span class="input-group-text bg-light border-end-0">
                                                            <i class="bi bi-phone text-primary"></i>
                                                        </span>
                                                        <input type="text" class="form-control @error('guardian_phone') is-invalid @enderror ps-0" 
                                                               id="guardian_phone" name="guardian_phone" value="{{ old('guardian_phone') }}" 
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
                                                    <div class="file-input-glass">
                                                        <input type="file" class="form-control @error('photo') is-invalid @enderror d-none" 
                                                               id="photo" name="photo" accept="image/*">
                                                        <div class="file-input-label" id="fileInputLabel">
                                                            <i class="bi bi-cloud-upload me-2"></i>Seleccionar archivo
                                                        </div>
                                                    </div>
                                                    <div id="fileName" class="mt-2 small text-muted" style="display: none;"></div>
                                                    @error('photo')
                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

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
                                                                        {{ old('grade_id') == $grade->id ? 'selected' : '' }}
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
                                                            <option value="">Primero seleccione un grado</option>
                                                            @if(old('grade_id'))
                                                                @php
                                                                    $selectedGrade = $grades->find(old('grade_id'));
                                                                @endphp
                                                                @if($selectedGrade)
                                                                    @foreach($selectedGrade->classrooms as $classroom)
                                                                        <option value="{{ $classroom->id }}" {{ old('classroom_id') == $classroom->id ? 'selected' : '' }}>
                                                                            Sección {{ $classroom->name }}
                                                                        </option>
                                                                    @endforeach
                                                                @endif
                                                            @endif
                                                        </select>
                                                    </div>
                                                    @error('classroom_id')
                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

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
                                                            <option value="morning" {{ old('shift') == 'morning' ? 'selected' : '' }}>Turno Mañana</option>
                                                            <option value="afternoon" {{ old('shift') == 'afternoon' ? 'selected' : '' }}>Turno Tarde</option>
                                                        </select>
                                                    </div>
                                                    @error('shift')
                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="d-flex justify-content-between pt-3 border-top">
                                                <a href="{{ route('students.index') }}" class="btn btn-blue-hover-celeste">
                                                    <i class="bi bi-arrow-left me-2"></i>Cancelar
                                                </a>
                                                <button type="submit" class="btn btn-blue-hover-celeste">
                                                    <i class="bi bi-save me-2"></i>Guardar Alumno
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                               <!-- Pestaña de importar masivo -->
                                <div class="tab-pane fade" id="import" role="tabpanel" aria-labelledby="import-tab">
                                    <div class="import-container">
                                        <div class="import-header text-center mb-4">
                                            <div class="import-icon mb-3">
                                                <i class="bi bi-file-earmark-spreadsheet"></i>
                                            </div>
                                            
                                            <h4 class="text-primary">Importar Estudiantes desde Excel</h4>
                                            <p class="text-muted">Sube un archivo Excel con la información de los estudiantes</p>
                                        </div>

                                        <!-- Formulario corregido con selector de turno -->
                                        <!-- Formulario corregido con selector de turno -->
                                        <form method="POST" action="{{ route('students.store') }}" enctype="multipart/form-data" id="importForm">
                                            @csrf
                                            <input type="hidden" name="import_type" value="excel">
                                            
                                            <!-- Selector de turno para importación masiva -->
                                            <div class="row mb-4">
                                                <div class="col-md-6">
                                                    <label for="import_shift" class="form-label label-required">Turno para todos los estudiantes</label>
                                                    <div class="input-group input-group-glass">
                                                        <span class="input-group-text bg-light border-end-0">
                                                            <i class="bi bi-clock text-primary"></i>
                                                        </span>
                                                        <select class="form-select @error('import_shift') is-invalid @enderror ps-0" 
                                                                id="import_shift" name="import_shift" required>
                                                            <option value="">Seleccione un turno</option>
                                                            <option value="morning" {{ old('import_shift') == 'morning' ? 'selected' : '' }}>Turno Mañana</option>
                                                            <option value="afternoon" {{ old('import_shift') == 'afternoon' ? 'selected' : '' }}>Turno Tarde</option>
                                                        </select>
                                                    </div>
                                                    @error('import_shift')
                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @enderror
                                                    <small class="text-muted mt-1">
                                                        <i class="bi bi-info-circle me-1"></i>Este turno se aplicará a todos los estudiantes importados
                                                    </small>
                                                </div>
                                            </div>
                                            
                                            <div class="file-upload-area mb-4" id="excelUploadArea">
                                                <div class="file-upload-content">
                                                    <i class="bi bi-cloud-arrow-up file-upload-icon"></i>
                                                    <h5 class="file-upload-title">Arrastra tu archivo Excel aquí</h5>
                                                    <p class="file-upload-subtitle">o haz clic para seleccionar</p>
                                                    <small class="file-upload-info">Formatos soportados: .xlsx, .xls, .csv (Máx. 10MB)</small>
                                                </div>
                                                <input type="file" class="d-none" id="excel_file" name="excel_file" accept=".xlsx,.xls,.csv">
                                            </div>

                                            <div class="file-preview" id="filePreview" style="display: none;">
                                                <div class="preview-header d-flex justify-content-between align-items-center mb-3">
                                                    <div>
                                                        <span class="text-success fw-semibold">
                                                            <i class="bi bi-check-circle-fill me-2"></i>Archivo seleccionado
                                                        </span>
                                                    </div>
                                                    <button type="button" class="btn-close" id="clearExcelFile"></button>
                                                </div>
                                                <div class="preview-content">
                                                    <div class="file-info d-flex align-items-center">
                                                        <div class="file-icon me-3">
                                                            <i class="bi bi-file-earmark-excel text-success fs-2"></i>
                                                        </div>
                                                        <div class="file-details">
                                                            <div class="file-name fw-medium" id="excelFileName"></div>
                                                            <div class="file-size text-muted small" id="excelFileSize"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="import-requirements mt-4">
                                                <h6 class="mb-3">
                                                    <i class="bi bi-info-circle me-2 text-primary"></i>Requisitos del archivo
                                                </h6>
                                                <div class="requirements-list">
                                                    <div class="requirement-item">
                                                        <i class="bi bi-check-circle-fill text-success me-2"></i>
                                                        <span>El archivo debe tener las columnas: DNI, Nombres, Apellidos, Teléfono Apoderado</span>
                                                    </div>
                                                    <div class="requirement-item">
                                                        <i class="bi bi-check-circle-fill text-success me-2"></i>
                                                        <span>Los datos deben estar en la primera hoja del archivo</span>
                                                    </div>
                                                    <div class="requirement-item">
                                                        <i class="bi bi-check-circle-fill text-success me-2"></i>
                                                        <span>La primera fila debe contener los encabezados de columna</span>
                                                    </div>
                                                    <div class="requirement-item">
                                                        <i class="bi bi-check-circle-fill text-success me-2"></i>
                                                        <span>El turno se selecciona arriba y aplica a todos los estudiantes</span>
                                                    </div>
                                                </div>
                                                
                                                <div class="mt-3">
                                                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="downloadTemplate()">
                                                        <i class="bi bi-download me-2"></i>Descargar Plantilla
                                                    </button>
                                                </div>
                                            </div>

                                            <div class="d-flex justify-content-between pt-4 border-top">
                                                <a href="{{ route('students.index') }}" class="btn btn-blue-hover-celeste">
                                                    <i class="bi bi-arrow-left me-2"></i>Cancelar
                                                </a>
                                                <button type="submit" class="btn btn-blue-hover-celeste" id="importButton" disabled>
                                                    <i class="bi bi-upload me-2"></i>Importar Estudiantes
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Sección de información al lado derecho -->
                <div class="info-section">
                    <div class="form-sidebar">
                        <!-- Tarjeta de información de generación -->
                        <div class="card card-glass info-card requirements-card mb-4">
                            <div class="card-header card-header-glass text-center">
                                <h5 class="card-title mb-0 text-white">
                                    <i class="bi bi-qr-code me-2"></i>Generación de Fotocheck
                                </h5>
                            </div>
                            <div class="card-body">
                                <p class="text-muted">Al guardar el alumno, se generará automáticamente:</p>
                                <ul class="feature-list">
                                    <li class="feature-item">
                                        <i class="bi bi-check-circle-fill text-success me-2"></i>
                                        Código de barras único
                                    </li>
                                    <li class="feature-item">
                                        <i class="bi bi-check-circle-fill text-success me-2"></i>
                                        Fotocheck imprimible
                                    </li>
                                    <li class="feature-item">
                                        <i class="bi bi-check-circle-fill text-success me-2"></i>
                                        Registro en la base de datos
                                    </li>
                                </ul>
                                <div class="alert alert-info alert-glass mt-3">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-info-circle-fill me-2"></i>
                                        <span>El sistema enviará un mensaje de confirmación al número del apoderado.</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tarjeta de acciones rápidas -->
                        <div class="card card-glass actions-card">
                            <div class="card-header card-header-glass">
                                <h5 class="card-title mb-0 text-white">
                                    <i class="bi bi-lightning-charge me-2"></i>Acciones Rápidas
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="quick-actions">
                                    <a href="{{ route('students.index') }}" class="quick-action-item">
                                        <div class="action-icon bg-primary">
                                            <i class="bi bi-list-ul"></i>
                                        </div>
                                        <div class="action-text">
                                            <span>Ver Lista Completa</span>
                                            <small>Gestionar todos los estudiantes</small>
                                        </div>
                                    </a>
                                    <a href="{{ route('students.create') }}" class="quick-action-item">
                                        <div class="action-icon bg-success">
                                            <i class="bi bi-person-plus"></i>
                                        </div>
                                        <div class="action-text">
                                            <span>Agregar Individual</span>
                                            <small>Nuevo estudiante</small>
                                        </div>
                                    </a>
                                    <a href="#" class="quick-action-item" id="switchToImport">
                                        <div class="action-icon bg-info">
                                            <i class="bi bi-upload"></i>
                                        </div>
                                        <div class="action-text">
                                            <span>Importar Masivo</span>
                                            <small>Desde archivo Excel</small>
                                        </div>
                                    </a>
                                </div>
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
            const fileInputLabel = document.getElementById('fileInputLabel');
            const photoInput = document.getElementById('photo');
            const fileName = document.getElementById('fileName');
            
            // Funcionalidad para el input de archivo individual
            fileInputLabel.addEventListener('click', function() {
                photoInput.click();
            });
            
            photoInput.addEventListener('change', function(e) {
                if (e.target.files.length > 0) {
                    const file = e.target.files[0];
                    fileName.textContent = 'Archivo seleccionado: ' + file.name;
                    fileName.style.display = 'block';
                }
            });
            
            // Funcionalidad para la importación masiva
            const excelUploadArea = document.getElementById('excelUploadArea');
            const excelFileInput = document.getElementById('excel_file');
            const filePreview = document.getElementById('filePreview');
            const excelFileName = document.getElementById('excelFileName');
            const excelFileSize = document.getElementById('excelFileSize');
            const clearExcelFile = document.getElementById('clearExcelFile');
            const importButton = document.getElementById('importButton');
            const switchToImport = document.getElementById('switchToImport');
            
            // Cambiar a pestaña de importación desde el sidebar
            if (switchToImport) {
                switchToImport.addEventListener('click', function(e) {
                    e.preventDefault();
                    const importTab = new bootstrap.Tab(document.getElementById('import-tab'));
                    importTab.show();
                });
            }
            
            // Subida de archivo Excel
            excelUploadArea.addEventListener('click', function() {
                excelFileInput.click();
            });
            
            excelUploadArea.addEventListener('dragover', function(e) {
                e.preventDefault();
                excelUploadArea.classList.add('dragover');
            });
            
            excelUploadArea.addEventListener('dragleave', function() {
                excelUploadArea.classList.remove('dragover');
            });
            
            excelUploadArea.addEventListener('drop', function(e) {
                e.preventDefault();
                excelUploadArea.classList.remove('dragover');
                
                if (e.dataTransfer.files.length) {
                    excelFileInput.files = e.dataTransfer.files;
                    handleExcelFile(e.dataTransfer.files[0]);
                }
            });
            
            excelFileInput.addEventListener('change', function(e) {
                if (e.target.files.length) {
                    handleExcelFile(e.target.files[0]);
                }
            });
            
            clearExcelFile.addEventListener('click', function() {
                excelFileInput.value = '';
                filePreview.style.display = 'none';
                excelUploadArea.style.display = 'block';
                importButton.disabled = true;
            });
            
            function handleExcelFile(file) {
                if (file) {
                    // Validar tipo de archivo
                    const validTypes = [
                        'application/vnd.ms-excel',
                        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                        'text/csv'
                    ];
                    
                    const fileExtension = file.name.split('.').pop().toLowerCase();
                    const isValidType = validTypes.includes(file.type) || 
                                       ['xls', 'xlsx', 'csv'].includes(fileExtension);
                    
                    if (!isValidType) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Tipo de archivo no válido',
                            text: 'Por favor, seleccione un archivo Excel válido (.xlsx, .xls, .csv)',
                            confirmButtonColor: '#dc2626',
                            confirmButtonText: 'Aceptar'
                        });
                        return;
                    }
                    
                    // Validar tamaño (10MB máximo)
                    if (file.size > 10 * 1024 * 1024) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Archivo muy grande',
                            text: 'El archivo no debe exceder los 10MB.',
                            confirmButtonColor: '#dc2626',
                            confirmButtonText: 'Aceptar'
                        });
                        return;
                    }
                    
                    // Mostrar información del archivo
                    excelFileName.textContent = file.name;
                    excelFileSize.textContent = formatFileSize(file.size);
                    
                    // Mostrar preview y habilitar botón
                    filePreview.style.display = 'block';
                    excelUploadArea.style.display = 'none';
                    importButton.disabled = false;
                }
            }
            
            function formatFileSize(bytes) {
                if (bytes === 0) return '0 Bytes';
                const k = 1024;
                const sizes = ['Bytes', 'KB', 'MB'];
                const i = Math.floor(Math.log(bytes) / Math.log(k));
                return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
            }
            
            // Función para actualizar las secciones
            function updateSections() {
                const selectedOption = gradeSelect.options[gradeSelect.selectedIndex];
                
                if (!selectedOption.dataset.sections) {
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
                } catch (error) {
                    sectionSelect.innerHTML = '<option value="">Error al cargar secciones</option>';
                }
            }
            
            // Evento cuando cambia la selección de grado
            if (gradeSelect) {
                gradeSelect.addEventListener('change', updateSections);
                
                // Si ya hay un grado seleccionado (por ejemplo, al recargar por error de validación)
                if (gradeSelect.value) {
                    updateSections();
                    
                    // Seleccionar la sección previamente seleccionada si existe
                    const previousSectionId = "{{ old('classroom_id') }}";
                    if (previousSectionId) {
                        setTimeout(() => {
                            sectionSelect.value = previousSectionId;
                        }, 100);
                    }
                }
            }

            // Validación adicional para el formulario de importación
            // Validación adicional para el formulario de importación
            const importForm = document.getElementById('importForm');
            if (importForm) {
                importForm.addEventListener('submit', function(e) {
                    const excelFile = document.getElementById('excel_file');
                    const importShift = document.getElementById('import_shift');
                    
                    if (!excelFile.files.length) {
                        e.preventDefault();
                        Swal.fire({
                            icon: 'error',
                            title: 'Archivo requerido',
                            text: 'Por favor, selecciona un archivo Excel para importar',
                            confirmButtonColor: '#dc2626',
                            confirmButtonText: 'Aceptar'
                        });
                        return false;
                    }
                    
                    if (!importShift.value) {
                        e.preventDefault();
                        Swal.fire({
                            icon: 'error',
                            title: 'Turno requerido',
                            text: 'Por favor, selecciona un turno para los estudiantes',
                            confirmButtonColor: '#dc2626',
                            confirmButtonText: 'Aceptar'
                        });
                        return false;
                    }

                    // Mostrar loading durante la importación
                    const importButton = document.getElementById('importButton');
                    if (importButton) {
                        importButton.innerHTML = '<i class="bi bi-arrow-repeat spinner-border spinner-border-sm me-2"></i>Importando...';
                        importButton.disabled = true;
                    }
                });
            }

            // Mostrar alertas de éxito/error
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: '{{ session('success') }}',
                    confirmButtonColor: '#1e3a8a',
                    confirmButtonText: 'Aceptar'
                });
            @endif

            @if(session('warning'))
                Swal.fire({
                    icon: 'warning',
                    title: 'Importación completada con observaciones',
                    text: '{{ session('warning') }}',
                    confirmButtonColor: '#d97706',
                    confirmButtonText: 'Entendido'
                });
            @endif

            @if(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: '{{ session('error') }}',
                    confirmButtonColor: '#dc2626',
                    confirmButtonText: 'Aceptar'
                });
            @endif
        });

        // Función para descargar plantilla (actualizada)
 // Función para descargar plantilla (actualizada sin columna de turno)
function downloadTemplate() {
    try {
        // Crear datos de ejemplo para la plantilla (sin columna de turno)
        const templateData = [
            ['dni', 'nombres', 'apellidos', 'telefono_apoderado', 'grado', 'seccion'],
            ['12345678', 'Juan', 'Pérez García', '987654321', '1', 'A'],
            ['87654321', 'María', 'López Silva', '987654322', '2', 'B'],
            ['45678912', 'Carlos', 'Gonzales Ruiz', '987654323', '3', 'A']
        ];

        // Crear libro de trabajo
        const wb = XLSX.utils.book_new();
        const ws = XLSX.utils.aoa_to_sheet(templateData);
        
        // Ajustar anchos de columna
        if (!ws['!cols']) ws['!cols'] = [];
        ws['!cols'] = [
            { wch: 15 }, // DNI
            { wch: 20 }, // Nombres
            { wch: 20 }, // Apellidos
            { wch: 20 }, // Teléfono
            { wch: 10 }, // Grado
            { wch: 10 }  // Sección
        ];

        XLSX.utils.book_append_sheet(wb, ws, 'Estudiantes');
        
        // Descargar archivo
        XLSX.writeFile(wb, 'plantilla_importacion_estudiantes.xlsx');
        
        Swal.fire({
            icon: 'success',
            title: 'Plantilla descargada',
            text: 'La plantilla se ha descargado correctamente. Completa los datos y súbela para importar los estudiantes. Recuerda seleccionar el turno en el formulario.',
            confirmButtonColor: '#1e3a8a',
            confirmButtonText: 'Entendido'
        });
    } catch (error) {
        console.error('Error al descargar plantilla:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No se pudo descargar la plantilla. Inténtalo de nuevo.',
            confirmButtonColor: '#dc2626',
            confirmButtonText: 'Aceptar'
        });
    }
}
    </script>
</body>
</html>