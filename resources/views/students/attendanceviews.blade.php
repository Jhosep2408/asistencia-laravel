<!DOCTYPE html>
<html lang="{{ session('language', 'es') }}" data-theme="{{ session('theme', 'light') }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard de Asistencia - Sistema Escolar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4f46e5;
            --primary-light: #6366f1;
            --primary-dark: #4338ca;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --info-color: #06b6d4;
            --light-bg: #f8fafc;
            --card-bg: #ffffff;
            --text-primary: #1e293b;
            --text-secondary: #64748b;
            --text-muted: #94a3b8;
            --border-color: #e2e8f0;
            --card-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            --card-hover-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --sidebar-width: 280px;
            --border-radius: 12px;
            --transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);

                --sidebar-bg: #1e293b;
            --sidebar-header-bg: #0f172a;
            --sidebar-hover: #334155;
            --sidebar-active: #3b82f6;
            --header-bg: #0f172a;
            --header-gradient: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        }

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

        /* Tarjetas mejoradas */
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

        .stat-card-primary { border-left-color: var(--primary-color); }
        .stat-card-success { border-left-color: var(--success-color); }
        .stat-card-warning { border-left-color: var(--warning-color); }
        .stat-card-danger { border-left-color: var(--danger-color); }
        .stat-card-info { border-left-color: var(--info-color); }

        .stat-icon {
            font-size: 2.5rem;
            opacity: 0.8;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            margin: 0.5rem 0;
            letter-spacing: -0.025em;
        }

        .stat-label {
            font-size: 0.875rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.5rem;
        }

        /* Tablas mejoradas */
        .table-responsive {
            border-radius: var(--border-radius);
            overflow: hidden;
            border: 1px solid var(--border-color);
        }

        .table {
            margin-bottom: 0;
        }

        .table th {
            font-weight: 600;
            color: var(--text-secondary);
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 1px solid var(--border-color);
            padding: 1rem 1.25rem;
            background-color: #f8fafc;
        }

        .table td {
            padding: 1rem 1.25rem;
            vertical-align: middle;
            border-bottom: 1px solid var(--border-color);
        }

        .table-hover tbody tr {
            transition: var(--transition);
        }

        .table-hover tbody tr:hover {
            background-color: rgba(79, 70, 229, 0.04);
        }

        /* Elementos de formulario mejorados */
        .form-control, .form-select {
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 0.625rem 1rem;
            font-size: 0.875rem;
            transition: var(--transition);
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-light);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }

        .form-label {
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
        }

        /* Botones mejorados */
        .btn {
            border-radius: 8px;
            font-weight: 500;
            padding: 0.625rem 1.25rem;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);
            border: none;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
        }

        .btn-sm {
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
        }

        .btn-outline-primary, .btn-outline-secondary, .btn-outline-success {
            border-width: 1px;
        }

        /* Badges mejorados */
        .badge {
            font-weight: 600;
            padding: 0.35rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
        }

        .badge-status {
            padding: 0.35rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        /* Indicadores de asistencia */
        .attendance-indicator {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 0.5rem;
        }

        .present-indicator { background-color: var(--success-color); }
        .late-indicator { background-color: var(--warning-color); }
        .absent-indicator { background-color: var(--danger-color); }
        .justified-indicator { background-color: var(--info-color); }

        /* Calendario mejorado */
        /* Estilos para el gráfico compacto */
        .chart-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
            min-height: 250px;
        }

        .pie-chart-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 100%;
        }

        .pie-chart-svg {
            width: 160px;
            height: 160px;
            margin-bottom: 1rem;
        }

        .pie-chart-legend {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.5rem;
            width: 100%;
            max-width: 200px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            font-size: 0.75rem;
            padding: 0.25rem 0;
        }

        .legend-color {
            width: 12px;
            height: 12px;
            border-radius: 2px;
            margin-right: 0.5rem;
            flex-shrink: 0;
        }

        .legend-value {
            margin-left: auto;
            font-weight: 600;
            color: var(--text-primary);
        }

        .chart-empty-state {
            text-align: center;
            color: var(--text-muted);
            padding: 2rem 1rem;
        }

        .chart-empty-state i {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        .chart-empty-state p {
            margin-bottom: 0.5rem;
            font-weight: 500;
        }

        /* Estilos para el calendario compacto */
        .calendar-container {
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .calendar-header {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            text-align: center;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--text-secondary);
            font-size: 0.75rem;
            padding: 0.25rem 0;
        }

        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 0.15rem;
            flex-grow: 1;
        }

        .calendar-day {
            text-align: center;
            padding: 0.35rem 0.25rem;
            border-radius: 6px;
            cursor: pointer;
            transition: var(--transition);
            position: relative;
            font-weight: 500;
            font-size: 0.8rem;
            min-height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .calendar-day:hover {
            background-color: rgba(79, 70, 229, 0.1);
        }

        .calendar-day.present { 
            background-color: rgba(16, 185, 129, 0.15); 
            color: var(--success-color); 
        }

        .calendar-day.absent { 
            background-color: rgba(239, 68, 68, 0.15); 
            color: var(--danger-color); 
        }

        .calendar-day.late { 
            background-color: rgba(245, 158, 11, 0.15); 
            color: var(--warning-color); 
        }

        .calendar-day.justified { 
            background-color: rgba(6, 182, 212, 0.15); 
            color: var(--info-color); 
        }

        .calendar-day.selected {
            box-shadow: 0 0 0 2px var(--primary-color);
            font-weight: bold;
        }

        .calendar-day.today {
            border: 2px solid var(--primary-color);
            font-weight: bold;
        }

        .calendar-legend {
            border-top: 1px solid var(--border-color);
        }

        .calendar-legend-item {
            display: flex;
            align-items: center;
            font-size: 0.75rem;
            color: var(--text-secondary);
        }

        /* Ajustes responsivos para el diseño 50/50 */
        @media (max-width: 992px) {
            .col-lg-6 {
                margin-bottom: 1rem;
            }
            
            .pie-chart-svg {
                width: 140px;
                height: 140px;
            }
            
            .pie-chart-legend {
                grid-template-columns: 1fr;
                max-width: 150px;
            }
        }

        @media (max-width: 768px) {
            .pie-chart-svg {
                width: 120px;
                height: 120px;
            }
            
            .calendar-day {
                padding: 0.25rem 0.15rem;
                font-size: 0.75rem;
                min-height: 28px;
            }
        }

        /* Mejoras visuales para las tarjetas */
        .card-dashboard {
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            transition: var(--transition);
            overflow: hidden;
            background-color: var(--card-bg);
            position: relative;
        }

        .card-dashboard::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--primary-color) 0%, var(--primary-light) 100%);
            opacity: 0;
            transition: var(--transition);
        }

        .card-dashboard:hover::before {
            opacity: 1;
        }

        .card-dashboard:hover {
            transform: translateY(-2px);
            box-shadow: var(--card-hover-shadow);
        }

        .card-header-custom {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border-bottom: 1px solid var(--border-color);
            padding: 1.25rem;
        }

        .card-header-custom h5 {
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0;
            font-size: 1rem;
        }

        /* Títulos de sección */
        .section-title {
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 1.5rem;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid rgba(79, 70, 229, 0.1);
            font-size: 1.125rem;
            letter-spacing: -0.025em;
        }

        .card-header-custom {
            background: white;
            border-bottom: 1px solid var(--border-color);
            padding: 1.5rem;
        }

        .card-header-custom h5 {
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0;
            font-size: 1.125rem;
        }

        /* Avatar de estudiantes */
        .student-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-light) 0%, var(--primary-color) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            color: white;
        }

        .student-name {
            font-weight: 600;
            color: var(--text-primary);
        }

        .student-info {
            font-size: 0.85rem;
            color: var(--text-muted);
        }

        /* Progress bars */
        .progress {
            height: 8px;
            border-radius: 4px;
            background-color: #e2e8f0;
        }

        .progress-bar {
            border-radius: 4px;
        }

        /* Filtros */
        /* Filtros Mejorados */
        .filter-card {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            border: 1px solid rgba(99, 102, 241, 0.1);
            border-radius: 16px;
            padding: 2rem;
            box-shadow: 
                0 4px 6px -1px rgba(0, 0, 0, 0.05),
                0 10px 15px -3px rgba(0, 0, 0, 0.08),
                inset 0 1px 0 rgba(255, 255, 255, 0.8);
            margin-bottom: 2.5rem;
            position: relative;
            overflow: hidden;
            backdrop-filter: blur(10px);
        }

        .filter-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, 
                var(--primary-color) 0%, 
                var(--primary-light) 50%, 
                var(--success-color) 100%);
            border-radius: 16px 16px 0 0;
        }

        .filter-card .section-title {
            font-weight: 700;
            font-size: 1.25rem;
            color: var(--text-primary);
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid rgba(99, 102, 241, 0.1);
            position: relative;
        }

        .filter-card .section-title::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 60px;
            height: 2px;
            background: linear-gradient(90deg, var(--primary-color), var(--primary-light));
            border-radius: 2px;
        }

        /* Form Controls Mejorados */
        .filter-card .form-label {
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.75rem;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .filter-card .form-label::before {
            content: '•';
            color: var(--primary-color);
            font-size: 1.2rem;
        }

        .filter-card .form-control,
        .filter-card .form-select {
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            padding: 0.875rem 1rem;
            font-size: 0.9rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            background: linear-gradient(135deg, #ffffff 0%, #fafbfc 100%);
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.03);
        }

        .filter-card .form-control:focus,
        .filter-card .form-select:focus {
            border-color: var(--primary-light);
            box-shadow: 
                0 0 0 3px rgba(99, 102, 241, 0.1),
                0 4px 12px rgba(99, 102, 241, 0.15);
            background: #ffffff;
            transform: translateY(-1px);
        }

        .filter-card .form-control:hover,
        .filter-card .form-select:hover {
            border-color: #c7d2fe;
            box-shadow: 0 2px 8px rgba(99, 102, 241, 0.08);
        }

        /* Botón de Filtro Mejorado */
        .filter-card #applyFilters {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);
            border: none;
            border-radius: 12px;
            padding: 0.875rem 1.5rem;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 
                0 2px 4px rgba(99, 102, 241, 0.2),
                inset 0 1px 0 rgba(255, 255, 255, 0.2);
            position: relative;
            overflow: hidden;
        }

        .filter-card #applyFilters::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .filter-card #applyFilters:hover::before {
            left: 100%;
        }

        .filter-card #applyFilters:hover {
            transform: translateY(-2px);
            box-shadow: 
                0 8px 20px rgba(99, 102, 241, 0.3),
                inset 0 1px 0 rgba(255, 255, 255, 0.2);
        }

        .filter-card #applyFilters:active {
            transform: translateY(0);
            box-shadow: 
                0 2px 4px rgba(99, 102, 241, 0.2),
                inset 0 1px 0 rgba(255, 255, 255, 0.2);
        }

        /* ===== ESTADÍSTICAS MEJORADAS ===== */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2.5rem;
        }

        .stat-card {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            border: 1px solid rgba(99, 102, 241, 0.08);
            border-radius: 20px;
            padding: 1.75rem;
            position: relative;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 
                0 4px 6px -1px rgba(0, 0, 0, 0.05),
                0 10px 15px -3px rgba(0, 0, 0, 0.08);
            backdrop-filter: blur(10px);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, 
                var(--card-color) 0%, 
                color-mix(in srgb, var(--card-color) 60%, white) 100%);
            opacity: 0.8;
        }

        .stat-card:hover {
            transform: translateY(-8px);
            box-shadow: 
                0 20px 25px -5px rgba(0, 0, 0, 0.1),
                0 10px 10px -5px rgba(0, 0, 0, 0.04);
            border-color: rgba(99, 102, 241, 0.2);
        }

        .stat-card-primary { --card-color: var(--primary-color); }
        .stat-card-success { --card-color: var(--success-color); }
        .stat-card-warning { --card-color: var(--warning-color); }
        .stat-card-danger { --card-color: var(--danger-color); }
        .stat-card-info { --card-color: var(--info-color); }

        .stat-card .card-body {
            padding: 0;
            position: relative;
            z-index: 2;
        }

        .stat-icon {
            font-size: 2.75rem;
            opacity: 0.9;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, var(--card-color), color-mix(in srgb, var(--card-color) 70%, white));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.1));
        }

        .stat-number {
            font-size: 2.25rem;
            font-weight: 800;
            margin: 0.5rem 0;
            letter-spacing: -0.025em;
            color: var(--text-primary);
            line-height: 1;
        }

        .stat-label {
            font-size: 0.875rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.5rem;
            color: var(--card-color);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .stat-label::before {
            content: '';
            width: 8px;
            height: 8px;
            background: var(--card-color);
            border-radius: 50%;
            display: inline-block;
        }

        .stat-card .text-muted {
            font-size: 0.8rem;
            color: var(--text-muted);
            font-weight: 500;
        }

        /* Modal mejorado */
        .modal-content {
            border: none;
            border-radius: var(--border-radius);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        .modal-header {
            border-bottom: 1px solid var(--border-color);
            padding: 1.5rem;
        }

        .modal-body {
            padding: 1.5rem;
        }

        .modal-footer {
            border-top: 1px solid var(--border-color);
            padding: 1.25rem 1.5rem;
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

            .date-indicator {
                background: rgba(255, 255, 255, 0.1);
                border-radius: 8px;
                padding: 0.5rem 1rem;
                border: 1px solid rgba(255, 255, 255, 0.15);
                backdrop-filter: blur(10px);
                font-weight: 500;
            }
                /* Estilos adicionales para los filtros en el modal de detalles */
            .detail-filters {
                background: #f8f9fa;
                border-radius: 8px;
                padding: 1rem;
                margin-bottom: 1.5rem;
                border: 1px solid #e9ecef;
            }
            
            .detail-filters .form-label {
                font-weight: 600;
                font-size: 0.875rem;
                margin-bottom: 0.25rem;
            }
            
            .detail-filters .form-control,
            .detail-filters .form-select {
                font-size: 0.875rem;
                padding: 0.5rem 0.75rem;
            }
            
            .stats-summary {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
                gap: 1rem;
                margin-bottom: 1.5rem;
            }
            
            .stat-item {
                text-align: center;
                padding: 0.75rem;
                background: white;
                border-radius: 8px;
                border: 1px solid #e9ecef;
            }
            
            .stat-value {
                font-size: 1.5rem;
                font-weight: 700;
                margin-bottom: 0.25rem;
            }
            
            .stat-label {
                font-size: 0.75rem;
                color: #6c757d;
                text-transform: uppercase;
                font-weight: 600;
            }
            
            .stat-present { color: #10b981; }
            .stat-late { color: #f59e0b; }
            .stat-absent { color: #ef4444; }
            .stat-justified { color: #06b6d4; }

            /* Estilos para la tabla con scrollbar */
        .table-responsive.table-scrollable {
            max-height: 300px; /* Altura máxima antes de mostrar scroll */
            overflow-y: auto; /* Scroll vertical */
            border: 1px solid var(--border-color);
            border-radius: 8px;
        }

        .table-responsive.table-scrollable table {
            margin-bottom: 0; /* Eliminar margen inferior para mejor apariencia */
        }

        .table-responsive.table-scrollable thead th {
            position: sticky;
            top: 0;
            background-color: #f8f9fa; /* Color de fondo del encabezado */
            z-index: 10;
            border-bottom: 2px solid var(--border-color);
        }

        /* Estilos para el scrollbar personalizado (opcional) */
        .table-responsive.table-scrollable::-webkit-scrollbar {
            width: 8px;
        }

        .table-responsive.table-scrollable::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }

        .table-responsive.table-scrollable::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 4px;
        }

        .table-responsive.table-scrollable::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }

  /* Estilos adicionales para la paginación */
        .pagination .page-link {
            border-radius: 6px;
            margin: 0 2px;
            font-weight: 500;
        }
        
        .pagination .page-item.active .page-link {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);
            border-color: var(--primary-color);
        }
        
        .pagination .page-item.disabled .page-link {
            color: var(--text-muted);
            background-color: var(--light-bg);
        }

        /* AGREGAR ESTOS NUEVOS ESTILOS PARA LA TABLA RESPONSIVA */
        .table-responsive-container {
            position: relative;
            width: 100%;
            overflow-x: auto;
            border-radius: var(--border-radius);
            border: 1px solid var(--border-color);
        }

        .table-responsive-container table {
            min-width: 800px; /* Ancho mínimo para mantener la legibilidad */
            margin-bottom: 0;
        }

        .table-responsive-container thead th {
            position: sticky;
            top: 0;
            background-color: #f8f9fa;
            z-index: 10;
            border-bottom: 2px solid var(--border-color);
            white-space: nowrap;
        }

        .table-responsive-container tbody td {
            vertical-align: middle;
            white-space: nowrap;
        }

        /* Estilos para el scrollbar personalizado */
        .table-responsive-container::-webkit-scrollbar {
            height: 8px;
        }

        .table-responsive-container::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 0 0 4px 4px;
        }

        .table-responsive-container::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 4px;
        }

        .table-responsive-container::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }

        /* Indicador visual de que hay más contenido */
        .table-responsive-container::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            width: 20px;
            background: linear-gradient(to right, transparent, rgba(0,0,0,0.05));
            pointer-events: none;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .table-responsive-container.scrollable::after {
            opacity: 1;
        }

        /* Ajustes para pantallas muy pequeñas */
        @media (max-width: 576px) {
            .table-responsive-container {
                font-size: 0.875rem;
            }
            
            .table-responsive-container table {
                min-width: 700px;
            }
            
            .btn-sm {
                padding: 0.25rem 0.5rem;
                font-size: 0.75rem;
            }
            
            .student-avatar {
                width: 32px;
                height: 32px;
                font-size: 1rem;
            }
            
            .badge {
                font-size: 0.7rem;
                padding: 0.25rem 0.5rem;
            }
        }

        /* MEJORAS PARA EL MODAL DE DETALLES */
        /* MEJORAS PARA EL MODAL DE DETALLES */
        .modal-backdrop.show {
            backdrop-filter: blur(5px);
            background-color: rgba(0, 0, 0, 0.5);
        }

        /* Modal más compacto y profesional */
        #attendanceDetailModal .modal-dialog {
            max-width: 900px;
            margin: 1.75rem auto;
        }

        #attendanceDetailModal .modal-content {
            border-radius: 16px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.4);
            border: none;
            overflow: hidden;
        }

        #attendanceDetailModal .modal-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);
            border-bottom: none;
            padding: 1.25rem 1.5rem;
            position: relative;
            overflow: hidden;
        }

        #attendanceDetailModal .modal-header::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 120px;
            height: 120px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.2) 0%, rgba(255, 255, 255, 0) 70%);
            border-radius: 50%;
            transform: translate(30%, -30%);
        }

        #attendanceDetailModal .modal-title {
            font-weight: 700;
            font-size: 1.25rem;
            color: white;
            display: flex;
            align-items: center;
        }

        #attendanceDetailModal .modal-body {
            padding: 1.5rem;
            max-height: 70vh;
            overflow-y: auto;
        }

        /* Información del estudiante mejorada */
        .student-detail-header {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border-radius: 12px;
            padding: 1.25rem;
            margin-bottom: 1.5rem;
            border: 1px solid var(--border-color);
            position: relative;
            overflow: hidden;
        }

        .student-detail-header::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 80px;
            height: 80px;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.1) 0%, rgba(99, 102, 241, 0) 70%);
            border-radius: 50%;
        }

        .student-detail-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-light) 0%, var(--primary-color) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
            margin-right: 1rem;
            flex-shrink: 0;
        }

        .student-detail-info h5 {
            font-weight: 700;
            margin-bottom: 0.25rem;
            color: var(--text-primary);
        }

        .student-detail-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            margin-top: 0.5rem;
        }

        .student-detail-meta-item {
            display: flex;
            align-items: center;
            font-size: 0.875rem;
            color: var(--text-secondary);
        }

        .student-detail-meta-item i {
            margin-right: 0.5rem;
            color: var(--primary-color);
        }

        .student-detail-percentage {
            text-align: center;
            padding: 0.75rem;
            background: white;
            border-radius: 12px;
            border: 1px solid var(--border-color);
            box-shadow: var(--card-shadow);
        }

        .percentage-value {
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 0.25rem;
        }

        .percentage-label {
            font-size: 0.75rem;
            color: var(--text-muted);
            text-transform: uppercase;
            font-weight: 600;
        }

        /* Estilos para los badges de turno */
        .badge-turno {
            font-size: 0.75rem;
            font-weight: 600;
            padding: 0.35rem 0.75rem;
            border-radius: 20px;
        }

        .badge-turno-mañana {
            background-color: #0dcaf0;
            color: white;
        }

        .badge-turno-tarde {
            background-color: #fd7e14;
            color: white;
        }

        /* Filtros compactos */
        .detail-filters-compact {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 1.25rem;
            border: 1px solid #e9ecef;
        }

        .detail-filters-compact .row {
            align-items: end;
        }

        .detail-filters-compact .form-label {
            font-weight: 600;
            font-size: 0.8rem;
            margin-bottom: 0.25rem;
            color: var(--text-secondary);
        }

        .detail-filters-compact .form-control,
        .detail-filters-compact .form-select {
            font-size: 0.85rem;
            padding: 0.5rem 0.75rem;
            border-radius: 8px;
        }

        /* Estadísticas compactas */
        .stats-summary-compact {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
            gap: 0.75rem;
            margin-bottom: 1.25rem;
        }

        .stat-item-compact {
            text-align: center;
            padding: 0.75rem 0.5rem;
            background: white;
            border-radius: 10px;
            border: 1px solid #e9ecef;
            transition: var(--transition);
        }

        .stat-item-compact:hover {
            transform: translateY(-2px);
            box-shadow: var(--card-shadow);
        }

        .stat-value-compact {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
        }

        .stat-label-compact {
            font-size: 0.7rem;
            color: #6c757d;
            text-transform: uppercase;
            font-weight: 600;
        }

        /* Tabla de detalles mejorada */
        .detail-table-container {
            max-height: 250px;
            overflow-y: auto;
            border: 1px solid var(--border-color);
            border-radius: 10px;
        }

        .detail-table-container table {
            margin-bottom: 0;
            font-size: 0.85rem;
        }

        .detail-table-container thead th {
            position: sticky;
            top: 0;
            background-color: #f8f9fa;
            z-index: 10;
            border-bottom: 2px solid var(--border-color);
            font-size: 0.8rem;
            padding: 0.75rem 1rem;
        }

        .detail-table-container tbody td {
            padding: 0.75rem 1rem;
            vertical-align: middle;
        }

        /* Footer del modal mejorado */
        #attendanceDetailModal .modal-footer {
            border-top: 1px solid var(--border-color);
            padding: 1rem 1.5rem;
            background: #f8fafc;
        }

        /* Responsive para el modal */
        @media (max-width: 768px) {
            #attendanceDetailModal .modal-dialog {
                margin: 0.5rem;
                max-width: calc(100% - 1rem);
            }
            
            #attendanceDetailModal .modal-body {
                padding: 1rem;
                max-height: 60vh;
            }
            
            .student-detail-header {
                padding: 1rem;
            }
            
            .student-detail-meta {
                flex-direction: column;
                gap: 0.5rem;
            }
            
            .detail-filters-compact .row > div {
                margin-bottom: 0.75rem;
            }
            
            .stats-summary-compact {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 576px) {
            .student-detail-header {
                flex-direction: column;
                text-align: center;
            }
            
            .student-detail-avatar {
                margin-right: 0;
                margin-bottom: 0.75rem;
            }
            
            .stats-summary-compact {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .detail-filters-compact .row > div {
                margin-bottom: 0.5rem;
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
                    <a class="nav-link active" href="{{ route('students.attendanceviews') }}">
                        <i class="bi bi-graph-up"></i>
                        <span>Dashboard Asistencia</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('students.*') && !request()->routeIs('students.attendance*') ? 'active' : '' }}" href="{{ route('students.index') }}">
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
    <!-- Main Content -->
    <div class="main-content">
        <!-- Encabezado -->
        <div class="dashboard-header">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="h2 fw-bold mb-2">Dashboard de Asistencia</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-white-50">Inicio</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('students.attendance') }}" class="text-white-50">Asistencia</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
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
        <!-- Filtros -->
        <div class="filter-card">
            <h5 class="section-title">Filtros de Búsqueda</h5>
            <div class="row g-3">
                <div class="col-md-3">
                    <label for="dateRange" class="form-label fw-semibold">Rango de Fechas</label>
                    <select class="form-select" id="dateRange">
                        <option value="today">Hoy</option>
                        <option value="week" selected>Esta Semana</option>
                        <option value="month">Este Mes</option>
                        <option value="custom">Personalizado</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="startDate" class="form-label fw-semibold">Fecha Inicio</label>
                    <input type="date" class="form-control" id="startDate" value="{{ date('Y-m-d', strtotime('-7 days')) }}">
                </div>
                <div class="col-md-2">
                    <label for="endDate" class="form-label fw-semibold">Fecha Fin</label>
                    <input type="date" class="form-control" id="endDate" value="{{ date('Y-m-d') }}">
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
                <div class="col-md-1 d-flex align-items-end">
                    <button class="btn btn-primary w-100" id="applyFilters">
                        <i class="bi bi-funnel me-1"></i> Filtrar
                    </button>
                </div>
            </div>
        </div>
        <!-- Estadísticas -->
        <div class="stats-grid">
            <div class="card card-dashboard stat-card stat-card-primary">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="stat-label text-primary">Total Estudiantes</div>
                            <div class="stat-number text-primary" id="totalStudents">{{ $totalStudents }}</div>
                            <div class="text-muted">Registrados en el sistema</div>
                        </div>
                        <div class="stat-icon text-primary">
                            <i class="bi bi-people-fill"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card card-dashboard stat-card stat-card-success">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="stat-label text-success">Asistencia Promedio</div>
                            <div class="stat-number text-success" id="attendanceRate">0%</div>
                            <div class="text-muted">En el período seleccionado</div>
                        </div>
                        <div class="stat-icon text-success">
                            <i class="bi bi-check-circle-fill"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card card-dashboard stat-card stat-card-warning">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="stat-label text-warning">Tardanzas</div>
                            <div class="stat-number text-warning" id="lateCount">0</div>
                            <div class="text-muted">En el período seleccionado</div>
                        </div>
                        <div class="stat-icon text-warning">
                            <i class="bi bi-clock-fill"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card card-dashboard stat-card stat-card-danger">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="stat-label text-danger">Inasistencias</div>
                            <div class="stat-number text-danger" id="absentCount">0</div>
                            <div class="text-muted">En el período seleccionado</div>
                        </div>
                        <div class="stat-icon text-danger">
                            <i class="bi bi-x-circle-fill"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card card-dashboard stat-card stat-card-info">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="stat-label text-info">Justificados</div>
                            <div class="stat-number text-info" id="justifiedCount">0</div>
                            <div class="text-muted">En el período seleccionado</div>
                        </div>
                        <div class="stat-icon text-info">
                            <i class="bi bi-file-earmark-check-fill"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Gráficos y Tabla -->
        <!-- Reemplazar la sección de Gráficos y Tabla con este código: -->
        <div class="row">
            <!-- Gráfico Circular de Asistencia - COMPACTO -->
            <div class="col-lg-6">
                <div class="card card-dashboard mb-4 h-100">
                    <div class="card-header-custom d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-0 fw-semibold">Distribución de Asistencia</h5>
                            <div class="mt-2">
                                <select class="form-select form-select-sm w-auto" id="chartPeriod">
                                    <option value="today">Diario</option>
                                    <option value="week" selected>Semanal</option>
                                    <option value="month">Mensual</option>
                                    <option value="year">Anual</option>
                                </select>
                            </div>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <i class="bi bi-download me-1"></i> Exportar
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#"><i class="bi bi-filetype-pdf me-2"></i>PDF</a></li>
                                <li><a class="dropdown-item" href="#"><i class="bi bi-filetype-xlsx me-2"></i>Excel</a></li>
                                <li><a class="dropdown-item" href="#"><i class="bi bi-filetype-csv me-2"></i>CSV</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body d-flex flex-column justify-content-center">
                        <div class="chart-container" id="attendanceChart">
                            <!-- Se generará dinámicamente -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Calendario de Asistencia - COMPACTO -->
            <div class="col-lg-6">
                <div class="card card-dashboard mb-4 h-100">
                    <div class="card-header-custom">
                        <h5 class="mb-0 fw-semibold">Calendario de Asistencia</h5>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <button class="btn btn-sm btn-outline-primary" id="prevMonth">
                                <i class="bi bi-chevron-left"></i>
                            </button>
                            <h6 class="mb-0 fw-bold" id="currentMonth">Noviembre 2023</h6>
                            <button class="btn btn-sm btn-outline-primary" id="nextMonth">
                                <i class="bi bi-chevron-right"></i>
                            </button>
                        </div>
                        <div class="calendar-header">
                            <div>L</div><div>M</div><div>M</div><div>J</div><div>V</div><div>S</div><div>D</div>
                        </div>
                        <div class="calendar-grid" id="calendarGrid">
                            <!-- Se generará dinámicamente -->
                        </div>
                        <div class="calendar-legend mt-auto pt-3">
                            <div class="d-flex flex-wrap gap-3">
                                <div class="calendar-legend-item">
                                    <span class="attendance-indicator present-indicator me-1"></span>
                                    <small>Presente</small>
                                </div>
                                <div class="calendar-legend-item">
                                    <span class="attendance-indicator late-indicator me-1"></span>
                                    <small>Tardanza</small>
                                </div>
                                <div class="calendar-legend-item">
                                    <span class="attendance-indicator absent-indicator me-1"></span>
                                    <small>Falta</small>
                                </div>
                                <div class="calendar-legend-item">
                                    <span class="attendance-indicator justified-indicator me-1"></span>
                                    <small>Justificado</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Buscador -->
        <div class="search-box">
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-search"></i></span>
                <input type="text" class="form-control" id="studentSearch" placeholder="Buscar por DNI o nombre...">
            </div>
        </div>
        <!-- Tabla de Asistencia -->
         <div class="row">
        <div class="col-12">
            <div class="card card-dashboard">
                <div class="card-header-custom d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-semibold" id="attendanceTitle">Registro de Asistencia</h5>
                    <div class="d-flex gap-2">
                        <button class="btn btn-sm btn-outline-primary" id="printTable">
                            <i class="bi bi-printer me-1"></i> Imprimir
                        </button>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-success dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <i class="bi bi-download me-1"></i> Exportar
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#"><i class="bi bi-filetype-pdf me-2"></i>PDF</a></li>
                                <li><a class="dropdown-item" href="#"><i class="bi bi-filetype-xlsx me-2"></i>Excel</a></li>
                                <li><a class="dropdown-item" href="#"><i class="bi bi-filetype-csv me-2"></i>CSV</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <!-- CONTENEDOR RESPONSIVO AGREGADO -->
                    <div class="table-responsive-container" id="attendanceTableContainer">
                        <table class="table table-hover mb-0" id="attendanceTable">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Estudiante</th>
                                    <th>Grado/Sección</th>
                                    <th class="text-center">Asistencia</th>
                                    <th class="text-center">Tardanzas</th>
                                    <th class="text-center">Faltas</th>
                                    <th class="text-center">Justificadas</th>
                                    <th class="text-center">% Asistencia</th>
                                    <th class="pe-4">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="attendanceTableBody">
                                <!-- Se llenará dinámicamente -->
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Footer de la tabla permanece igual -->
                <div class="card-footer-transparent">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted">
                            Mostrando <span id="showingCount">0</span> de <span id="totalCount">0</span> estudiantes
                        </div>
                        <nav>
                            <ul class="pagination mb-0" id="paginationContainer">
                                <!-- La paginación se generará dinámicamente aquí -->
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- Modal para Detalles de Asistencia -->

    <!-- Modal para Detalles de Asistencia (MODIFICADO) -->
<!-- Modal para Detalles de Asistencia - MEJORADO -->
    <div class="modal fade" id="attendanceDetailModal" tabindex="-1" data-bs-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-clipboard-data me-2"></i>Detalles de Asistencia</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <!-- Información del estudiante - MEJORADA -->
                    <div class="student-detail-header d-flex align-items-center">
                        <div class="student-detail-avatar">
                            <i class="bi bi-person-fill"></i>
                        </div>
                        <div class="student-detail-info flex-grow-1">
                            <h5 id="studentDetailName">Juan Pérez García</h5>
                            <div class="student-detail-meta">
                                <div class="student-detail-meta-item">
                                    <i class="bi bi-person-badge"></i>
                                    <span>DNI: <strong id="studentDetailDni">12345678</strong></span>
                                </div>
                                <div class="student-detail-meta-item">
                                    <i class="bi bi-mortarboard"></i>
                                    <span>Grado: <strong id="studentDetailGrade">5to Primaria</strong></span>
                                </div>
                                <div class="student-detail-meta-item">
                                    <i class="bi bi-collection"></i>
                                    <span>Sección: <strong id="studentDetailSection">A</strong></span>
                                </div>
                                <div class="student-detail-meta-item">
                                    <i class="bi bi-clock"></i>
                                    <span>Turno: <span id="studentDetailShift" class="badge badge-turno badge-turno-mañana ms-1">
                                        <i class="bi bi-sun me-1"></i>Mañana
                                    </span></span>
                                </div>
                            </div>
                        </div>
                        <div class="student-detail-percentage">
                            <div class="percentage-value text-success" id="studentDetailPercentage">92%</div>
                            <div class="percentage-label">Asistencia</div>
                        </div>
                    </div>

                    <!-- Filtros compactos - MEJORADOS -->
                    <div class="detail-filters-compact">
                        <div class="row g-2 align-items-end">
                            <div class="col-md-3">
                                <label class="form-label">Rango de Fechas</label>
                                <select class="form-select" id="detailDateRange">
                                    <option value="today">Hoy</option>
                                    <option value="week">Última Semana</option>
                                    <option value="month" selected>Último Mes</option>
                                    <option value="quarter">Último Trimestre</option>
                                    <option value="year">Último Año</option>
                                    <option value="custom">Personalizado</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Fecha Inicio</label>
                                <input type="date" class="form-control" id="detailStartDate">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Fecha Fin</label>
                                <input type="date" class="form-control" id="detailEndDate">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Estado</label>
                                <select class="form-select" id="detailStatusFilter">
                                    <option value="">Todos</option>
                                    <option value="present">Presente</option>
                                    <option value="late">Tardanza</option>
                                    <option value="absent">Falta</option>
                                    <option value="justified">Justificado</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-primary w-100" id="applyDetailFilters">
                                    <i class="bi bi-funnel me-1"></i> Aplicar
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Resumen estadístico compacto - MEJORADO -->
                    <div class="stats-summary-compact" id="detailStatsSummary">
                        <!-- Se llenará dinámicamente -->
                    </div>

                    <h6 class="section-title mb-2">Historial de Asistencia</h6>
                    <div class="detail-table-container">
                        <table class="table table-sm table-hover" id="detailAttendanceTable">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Estado</th>
                                    <th>Hora</th>
                                    <th>Observaciones</th>
                                </tr>
                            </thead>
                            <tbody id="attendanceDetailBody"></tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="bi bi-download me-1"></i> Descargar
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#" id="downloadExcelDetail">
                                <i class="bi bi-file-earmark-excel text-success me-2"></i> Excel
                            </a></li>
                            <li><a class="dropdown-item" href="#" id="downloadPDFDetail">
                                <i class="bi bi-file-earmark-pdf text-danger me-2"></i> PDF
                            </a></li>
                            <li><a class="dropdown-item" href="#" id="downloadCSVDetail">
                                <i class="bi bi-file-earmark-text text-primary me-2"></i> CSV
                            </a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Agregar en el head -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <script>
        // AGREGAR ESTO AL INICIO DEL SCRIPT - Event listener global para la paginación
document.addEventListener('click', function(e) {
    // Verificar si el clic fue en un enlace de paginación
    if (e.target.classList.contains('page-link') && e.target.hasAttribute('data-page')) {
        e.preventDefault();
        
        const page = parseInt(e.target.getAttribute('data-page'));
        if (page !== currentPage) {
            currentPage = page;
            updateAttendanceTable();
            
            // Scroll suave hacia la parte superior de la tabla
            const tableElement = document.getElementById('attendanceTable');
            if (tableElement) {
                tableElement.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }
    }
});
        // Variables globales
        const studentsData = @json($students);
        const gradesData = @json($grades);
        const attendanceData = @json($attendance);
        let currentGrade = "";
        let currentSection = "";
        let currentStartDate = new Date(new Date().setDate(new Date().getDate() - 7)).toISOString().split('T')[0];
        let currentEndDate = new Date().toISOString().split('T')[0];
        let currentMonth = new Date().getMonth();
        let currentYear = new Date().getFullYear();
        let currentSelectedDate = null;
        let currentStudentDni = '';
        let currentStudentName = '';
        let currentDetailRecords = [];
        // Variables de paginación
        let currentPage = 1;
        const itemsPerPage = 10;
        let currentFilteredStudents = [];

document.addEventListener('DOMContentLoaded', function() {
    initializeFilters();
    setupEventListeners();
    loadAttendanceData();
    
    // Inicializar con el mes y año actuales
    const today = new Date();
    currentMonth = today.getMonth();
    currentYear = today.getFullYear();
    
    generateCalendar();
    updateAttendanceTable();
    setupDetailModalFilters();
    
    // DEBUG: Verificar la fecha actual
    console.log('Fecha actual:', {
        hoy: today.toDateString(),
        dia: today.getDate(),
        mes: today.getMonth(),
        año: today.getFullYear()
    });
});

        // Configurar filtros del modal de detalles
        function setupDetailModalFilters() {
            const detailDateRange = document.getElementById('detailDateRange');
            const detailStartDate = document.getElementById('detailStartDate');
            const detailEndDate = document.getElementById('detailEndDate');
            const applyDetailFilters = document.getElementById('applyDetailFilters');
            const downloadExcelDetail = document.getElementById('downloadExcelDetail');
            const downloadPDFDetail = document.getElementById('downloadPDFDetail');
            const downloadCSVDetail = document.getElementById('downloadCSVDetail');

            // Configurar fechas por defecto (último mes)
            const today = new Date();
            const lastMonth = new Date(today.getFullYear(), today.getMonth() - 1, today.getDate());
            
            detailStartDate.value = lastMonth.toISOString().split('T')[0];
            detailEndDate.value = today.toISOString().split('T')[0];

            // Evento para presets de fecha
            detailDateRange.addEventListener('change', function() {
                const today = new Date();
                let startDate, endDate = today.toISOString().split('T')[0];

                switch(this.value) {
                    case 'today':
                        startDate = endDate;
                        break;
                    case 'week':
                        startDate = new Date(today.setDate(today.getDate() - 7)).toISOString().split('T')[0];
                        break;
                    case 'month':
                        startDate = new Date(today.getFullYear(), today.getMonth() - 1, today.getDate()).toISOString().split('T')[0];
                        break;
                    case 'quarter':
                        startDate = new Date(today.getFullYear(), today.getMonth() - 3, today.getDate()).toISOString().split('T')[0];
                        break;
                    case 'year':
                        startDate = new Date(today.getFullYear() - 1, today.getMonth(), today.getDate()).toISOString().split('T')[0];
                        break;
                    default:
                        return; // Para custom no hacemos nada
                }

                if (this.value !== 'custom') {
                    detailStartDate.value = startDate;
                    detailEndDate.value = endDate;
                }
            });

            // Aplicar filtros
            applyDetailFilters.addEventListener('click', function() {
                updateDetailModalContent();
            });

            // Descargas desde el modal de detalles
            downloadExcelDetail.addEventListener('click', function(e) {
                e.preventDefault();
                downloadDetailReport('excel');
            });

            downloadPDFDetail.addEventListener('click', function(e) {
                e.preventDefault();
                downloadDetailReport('pdf');
            });

            downloadCSVDetail.addEventListener('click', function(e) {
                e.preventDefault();
                downloadDetailReport('csv');
            });
        }

        // AGREGAR ESTE CÓDIGO PARA DETECTAR CUÁNDO HAY SCROLL HORIZONTAL
        document.addEventListener('DOMContentLoaded', function() {
            // Inicializar el indicador de scroll
            const tableContainer = document.getElementById('attendanceTableContainer');
            
            function checkScroll() {
                if (tableContainer.scrollWidth > tableContainer.clientWidth) {
                    tableContainer.classList.add('scrollable');
                } else {
                    tableContainer.classList.remove('scrollable');
                }
            }
            
            // Verificar al cargar y al cambiar el tamaño de la ventana
            checkScroll();
            window.addEventListener('resize', checkScroll);
            
            // También verificar después de actualizar la tabla
            const originalUpdateTable = updateAttendanceTable;
            updateAttendanceTable = function(searchTerm = '') {
                originalUpdateTable(searchTerm);
                // Pequeño retraso para permitir que el DOM se actualice
                setTimeout(checkScroll, 100);
            };
        });

        // Actualizar contenido del modal de detalles con filtros
        function updateDetailModalContent() {
            const startDate = document.getElementById('detailStartDate').value;
            const endDate = document.getElementById('detailEndDate').value;
            const statusFilter = document.getElementById('detailStatusFilter').value;

            if (!startDate || !endDate) {
                alert('Por favor, selecciona un rango de fechas válido.');
                return;
            }

            // Filtrar registros
            let filteredRecords = attendanceData.filter(record => 
                record.student_dni === currentStudentDni && 
                new Date(record.date) >= new Date(startDate) && 
                new Date(record.date) <= new Date(endDate)
            );

            // Aplicar filtro de estado si está seleccionado
            if (statusFilter) {
                filteredRecords = filteredRecords.filter(record => record.status === statusFilter);
            }

            // Ordenar por fecha
            filteredRecords.sort((a, b) => new Date(b.date) - new Date(a.date));

            // Guardar registros actuales
            currentDetailRecords = filteredRecords;

            // Actualizar tabla
            updateDetailTable(filteredRecords);

            // Actualizar estadísticas
            updateDetailStatistics(filteredRecords);

            // Actualizar porcentaje de asistencia
            updateDetailAttendancePercentage(filteredRecords);
        }

        // Actualizar tabla de detalles
        function updateDetailTable(records) {
            const tbody = document.getElementById('attendanceDetailBody');
            tbody.innerHTML = '';

            if (records.length === 0) {
                tbody.innerHTML = `<tr><td colspan="4" class="text-center py-3 text-muted">No hay registros para el período seleccionado</td></tr>`;
                return;
            }

            const labels = {
                'present': '<span class="badge bg-success">Presente</span>',
                'late': '<span class="badge bg-warning">Tardanza</span>',
                'absent': '<span class="badge bg-danger">Falta</span>',
                'justified': '<span class="badge bg-info">Justificado</span>'
            };

            records.forEach(r => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${formatDateForDisplay(r.date)}</td>
                    <td>${labels[r.status]}</td>
                    <td>${r.time || '--:--'}</td>
                    <td>${r.notes || ''}</td>
                `;
                tbody.appendChild(tr);
            });
        }

        // Actualizar estadísticas del modal de detalles
        // ACTUALIZAR LA FUNCIÓN DE ESTADÍSTICAS PARA USAR EL DISEÑO COMPACTO
        // ACTUALIZAR LA FUNCIÓN DE ESTADÍSTICAS PARA USAR EL DISEÑO COMPACTO
        function updateDetailStatistics(records) {
            const statsContainer = document.getElementById('detailStatsSummary');
            
            const total = records.length;
            const present = records.filter(r => r.status === 'present').length;
            const late = records.filter(r => r.status === 'late').length;
            const absent = records.filter(r => r.status === 'absent').length;
            const justified = records.filter(r => r.status === 'justified').length;

            statsContainer.innerHTML = `
                <div class="stat-item-compact">
                    <div class="stat-value-compact">${total}</div>
                    <div class="stat-label-compact">Total</div>
                </div>
                <div class="stat-item-compact">
                    <div class="stat-value-compact stat-present">${present}</div>
                    <div class="stat-label-compact">Presentes</div>
                </div>
                <div class="stat-item-compact">
                    <div class="stat-value-compact stat-late">${late}</div>
                    <div class="stat-label-compact">Tardanzas</div>
                </div>
                <div class="stat-item-compact">
                    <div class="stat-value-compact stat-absent">${absent}</div>
                    <div class="stat-label-compact">Faltas</div>
                </div>
                <div class="stat-item-compact">
                    <div class="stat-value-compact stat-justified">${justified}</div>
                    <div class="stat-label-compact">Justificados</div>
                </div>
            `;
        }

        // Actualizar porcentaje de asistencia en el modal de detalles
        function updateDetailAttendancePercentage(records) {
            let weighted = 0;
            records.forEach(r => {
                if (r.status === 'present') weighted += 100;
                else if (r.status === 'late') weighted += 50;
                else if (r.status === 'justified') weighted += 80;
            });
            const pct = records.length > 0 ? Math.round(weighted / records.length) : 0;
            document.getElementById('studentDetailPercentage').textContent = `${pct}%`;
        }

        // Descargar reporte desde el modal de detalles
        function downloadDetailReport(format) {
            if (currentDetailRecords.length === 0) {
                alert('No hay datos para generar el reporte.');
                return;
            }

            const startDate = document.getElementById('detailStartDate').value;
            const endDate = document.getElementById('detailEndDate').value;
            const statusFilter = document.getElementById('detailStatusFilter').value;

            // Preparar datos para el reporte
            const reportData = prepareDetailReportData(currentDetailRecords, startDate, endDate, statusFilter);

            switch(format) {
                case 'excel':
                    downloadDetailExcel(reportData);
                    break;
                case 'pdf':
                    downloadDetailPDF(reportData);
                    break;
                case 'csv':
                    downloadDetailCSV(reportData);
                    break;
            }
        }

        // Preparar datos para el reporte de detalles
        function prepareDetailReportData(records, startDate, endDate, statusFilter) {
            const studentName = document.getElementById('studentDetailName').textContent;
            const studentDni = document.getElementById('studentDetailDni').textContent;
            const studentGrade = document.getElementById('studentDetailGrade').textContent;
            const studentSection = document.getElementById('studentDetailSection').textContent;

            // Calcular estadísticas
            const total = records.length;
            const present = records.filter(r => r.status === 'present').length;
            const late = records.filter(r => r.status === 'late').length;
            const absent = records.filter(r => r.status === 'absent').length;
            const justified = records.filter(r => r.status === 'justified').length;
            const porcentajeAsistencia = total > 0 ? ((present + late * 0.5 + justified * 0.8) / total * 100).toFixed(1) : 0;

            return {
                studentInfo: {
                    name: studentName,
                    dni: studentDni,
                    grade: studentGrade,
                    section: studentSection
                },
                period: {
                    start: startDate,
                    end: endDate,
                    statusFilter: statusFilter
                },
                records: records,
                statistics: {
                    total: total,
                    present: present,
                    late: late,
                    absent: absent,
                    justified: justified,
                    percentage: porcentajeAsistencia
                }
            };
        }

        // Descargar Excel desde modal de detalles
        function downloadDetailExcel(reportData) {
            const excelData = [
                ['REPORTE DETALLADO DE ASISTENCIA'],
                ['Estudiante:', reportData.studentInfo.name],
                ['DNI:', reportData.studentInfo.dni],
                ['Grado:', reportData.studentInfo.grade],
                ['Sección:', reportData.studentInfo.section],
                ['Período:', `${formatDateForDisplay(reportData.period.start)} al ${formatDateForDisplay(reportData.period.end)}`],
                reportData.period.statusFilter ? ['Filtro de estado:', reportData.period.statusFilter.toUpperCase()] : [],
                ['Fecha de generación:', new Date().toLocaleDateString('es-ES')],
                [],
                ['RESUMEN ESTADÍSTICO'],
                ['Total de días:', reportData.statistics.total],
                ['Días presentes:', reportData.statistics.present],
                ['Tardanzas:', reportData.statistics.late],
                ['Faltas:', reportData.statistics.absent],
                ['Justificados:', reportData.statistics.justified],
                ['Porcentaje de asistencia:', `${reportData.statistics.percentage}%`],
                [],
                ['DETALLE DE ASISTENCIA'],
                ['Fecha', 'Estado', 'Hora', 'Observaciones']
            ];

            // Agregar registros
            reportData.records.forEach(record => {
                let estado = '';
                switch(record.status) {
                    case 'present': estado = 'PRESENTE'; break;
                    case 'late': estado = 'TARDANZA'; break;
                    case 'absent': estado = 'FALTA'; break;
                    case 'justified': estado = 'JUSTIFICADO'; break;
                    default: estado = record.status.toUpperCase();
                }
                
                excelData.push([
                    formatDateForDisplay(record.date),
                    estado,
                    record.time || '--:--',
                    record.notes || ''
                ]);
            });

            // Crear y descargar Excel
            const wb = XLSX.utils.book_new();
            const ws = XLSX.utils.aoa_to_sheet(excelData);
            
            // Establecer anchos de columna
            const colWidths = [
                { wch: 15 }, // Fecha
                { wch: 12 }, // Estado
                { wch: 10 }, // Hora
                { wch: 30 }  // Observaciones
            ];
            ws['!cols'] = colWidths;
            
            XLSX.utils.book_append_sheet(wb, ws, "Detalle Asistencia");
            
            const fileName = `detalle_asistencia_${reportData.studentInfo.name.replace(/\s+/g, '_')}.xlsx`;
            XLSX.writeFile(wb, fileName);
        }

        // Descargar PDF desde modal de detalles
        function downloadDetailPDF(reportData) {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();

            // Configuración inicial
            doc.setFontSize(16);
            doc.setTextColor(40);
            doc.text('REPORTE DETALLADO DE ASISTENCIA', 105, 15, { align: 'center' });

            // Información del estudiante
            doc.setFontSize(10);
            doc.text(`Estudiante: ${reportData.studentInfo.name}`, 20, 25);
            doc.text(`DNI: ${reportData.studentInfo.dni}`, 20, 30);
            doc.text(`Grado: ${reportData.studentInfo.grade} - Sección: ${reportData.studentInfo.section}`, 20, 35);
            doc.text(`Período: ${formatDateForDisplay(reportData.period.start)} al ${formatDateForDisplay(reportData.period.end)}`, 20, 40);
            if (reportData.period.statusFilter) {
                doc.text(`Filtro: ${reportData.period.statusFilter.toUpperCase()}`, 20, 45);
            }
            doc.text(`Generado: ${new Date().toLocaleDateString('es-ES')}`, 20, 50);

            // Estadísticas
            doc.setFontSize(12);
            doc.text('RESUMEN ESTADÍSTICO', 20, 65);
            doc.setFontSize(10);
            doc.text(`Total de días: ${reportData.statistics.total}`, 20, 72);
            doc.text(`Presentes: ${reportData.statistics.present}`, 20, 77);
            doc.text(`Tardanzas: ${reportData.statistics.late}`, 20, 82);
            doc.text(`Faltas: ${reportData.statistics.absent}`, 20, 87);
            doc.text(`Justificados: ${reportData.statistics.justified}`, 20, 92);
            doc.text(`Porcentaje de asistencia: ${reportData.statistics.percentage}%`, 20, 97);

            // Tabla de detalles
            const tableData = reportData.records.map(record => {
                let estado = '';
                switch(record.status) {
                    case 'present': estado = 'PRESENTE'; break;
                    case 'late': estado = 'TARDANZA'; break;
                    case 'absent': estado = 'FALTA'; break;
                    case 'justified': estado = 'JUSTIFICADO'; break;
                    default: estado = record.status.toUpperCase();
                }
                
                return [
                    formatDateForDisplay(record.date),
                    estado,
                    record.time || '--:--',
                    record.notes || ''
                ];
            });

            doc.autoTable({
                startY: 105,
                head: [['Fecha', 'Estado', 'Hora', 'Observaciones']],
                body: tableData,
                styles: { fontSize: 8 },
                headStyles: { fillColor: [66, 97, 238] }
            });

            // Guardar PDF
            const fileName = `detalle_asistencia_${reportData.studentInfo.name.replace(/\s+/g, '_')}.pdf`;
            doc.save(fileName);
        }

        // Descargar CSV desde modal de detalles
        function downloadDetailCSV(reportData) {
            let csvContent = "data:text/csv;charset=utf-8,";
            
            // Encabezados
            csvContent += "REPORTE DETALLADO DE ASISTENCIA\r\n";
            csvContent += `Estudiante:,${reportData.studentInfo.name}\r\n`;
            csvContent += `DNI:,${reportData.studentInfo.dni}\r\n`;
            csvContent += `Grado:,${reportData.studentInfo.grade}\r\n`;
            csvContent += `Sección:,${reportData.studentInfo.section}\r\n`;
            csvContent += `Período:,${formatDateForDisplay(reportData.period.start)} al ${formatDateForDisplay(reportData.period.end)}\r\n`;
            if (reportData.period.statusFilter) {
                csvContent += `Filtro:,${reportData.period.statusFilter.toUpperCase()}\r\n`;
            }
            csvContent += `Generado:,${new Date().toLocaleDateString('es-ES')}\r\n\r\n`;
            
            // Estadísticas
            csvContent += "RESUMEN ESTADÍSTICO\r\n";
            csvContent += `Total de días:,${reportData.statistics.total}\r\n`;
            csvContent += `Presentes:,${reportData.statistics.present}\r\n`;
            csvContent += `Tardanzas:,${reportData.statistics.late}\r\n`;
            csvContent += `Faltas:,${reportData.statistics.absent}\r\n`;
            csvContent += `Justificados:,${reportData.statistics.justified}\r\n`;
            csvContent += `Porcentaje de asistencia:,${reportData.statistics.percentage}%\r\n\r\n`;
            
            // Detalles
            csvContent += "DETALLE DE ASISTENCIA\r\n";
            csvContent += "Fecha,Estado,Hora,Observaciones\r\n";
            
            reportData.records.forEach(record => {
                let estado = '';
                switch(record.status) {
                    case 'present': estado = 'PRESENTE'; break;
                    case 'late': estado = 'TARDANZA'; break;
                    case 'absent': estado = 'FALTA'; break;
                    case 'justified': estado = 'JUSTIFICADO'; break;
                    default: estado = record.status.toUpperCase();
                }
                
                csvContent += `"${formatDateForDisplay(record.date)}","${estado}","${record.time || '--:--'}","${record.notes || ''}"\r\n`;
            });
            
            const encodedUri = encodeURI(csvContent);
            const link = document.createElement("a");
            link.setAttribute("href", encodedUri);
            link.setAttribute("download", `detalle_asistencia_${reportData.studentInfo.name.replace(/\s+/g, '_')}.csv`);
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }

        // Modificar la función showStudentDetails para usar los filtros
         // AGREGAR ESTE CÓDIGO PARA ACTUALIZAR LA INFORMACIÓN DEL TURNO
        // Función SIMPLIFICADA para mostrar detalles del estudiante
// Función SIMPLIFICADA para mostrar detalles del estudiante
function showStudentDetails(dni) {
    const student = studentsData.find(s => s.dni === dni);
    if (!student) return;
    
    // Guardar datos del estudiante
    currentStudentDni = dni;
    currentStudentName = student.name;
    
    // Actualizar información del estudiante en el modal
    document.getElementById('studentDetailName').textContent = student.name;
    document.getElementById('studentDetailDni').textContent = student.dni;
    document.getElementById('studentDetailGrade').textContent = student.grade;
    document.getElementById('studentDetailSection').textContent = student.section;
    
    // OBTENER TURNO DESDE LOS DATOS EXISTENTES
    const shiftElement = document.getElementById('studentDetailShift');
    const shift = student.shift || 'morning'; // Valor por defecto si no existe
    
    // Actualizar el badge del turno según los datos
    if (shift === 'morning' || shift === 'mañana') {
        shiftElement.innerHTML = '<i class="bi bi-sun me-1"></i>Mañana';
        shiftElement.className = 'badge badge-turno badge-turno-mañana ms-1';
    } else if (shift === 'afternoon' || shift === 'tarde') {
        shiftElement.innerHTML = '<i class="bi bi-moon me-1"></i>Tarde';
        shiftElement.className = 'badge badge-turno badge-turno-tarde ms-1';
    } else {
        // Para cualquier otro valor
        shiftElement.innerHTML = `<i class="bi bi-clock me-1"></i>${shift}`;
        shiftElement.className = 'badge badge-turno badge-turno-mañana ms-1';
    }

    // Aplicar filtros por defecto (último mes)
    updateDetailModalContent();

    // Mostrar modal
    const modal = new bootstrap.Modal(document.getElementById('attendanceDetailModal'));
    modal.show();
}

        // Función auxiliar para formatear fechas
        function formatDateForDisplay(dateString) {
            const date = new Date(dateString);
            const adjustedDate = new Date(date.getTime() + date.getTimezoneOffset() * 60000);
            return adjustedDate.toLocaleDateString('es-ES', {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit'
            });
        }

        // Funciones existentes del dashboard
        function initializeFilters() {
            const gradeFilter = document.getElementById('gradeFilter');
            gradeFilter.addEventListener('change', function() {
                const selectedGradeId = this.value;
                const sectionFilter = document.getElementById('sectionFilter');
                sectionFilter.innerHTML = '<option value="">Todas las secciones</option>';
                if (selectedGradeId === "") {
                    sectionFilter.disabled = true;
                } else {
                    sectionFilter.disabled = false;
                    const selectedGrade = gradesData.find(g => g.id == selectedGradeId);
                    if (selectedGrade && selectedGrade.sections) {
                        selectedGrade.sections.forEach(section => {
                            sectionFilter.innerHTML += `<option value="${section.id}">${section.name}</option>`;
                        });
                    }
                }
            });

            const dateRange = document.getElementById('dateRange');
            dateRange.addEventListener('change', function() {
                const today = new Date();
                const startDateInput = document.getElementById('startDate');
                const endDateInput = document.getElementById('endDate');
                switch(this.value) {
                    case 'today':
                        startDateInput.value = today.toISOString().split('T')[0];
                        endDateInput.value = today.toISOString().split('T')[0];
                        break;
                    case 'week':
                        const weekAgo = new Date(today);
                        weekAgo.setDate(today.getDate() - 7);
                        startDateInput.value = weekAgo.toISOString().split('T')[0];
                        endDateInput.value = today.toISOString().split('T')[0];
                        break;
                    case 'month':
                        const monthAgo = new Date(today);
                        monthAgo.setMonth(today.getMonth() - 1);
                        startDateInput.value = monthAgo.toISOString().split('T')[0];
                        endDateInput.value = today.toISOString().split('T')[0];
                        break;
                }
                currentStartDate = startDateInput.value;
                currentEndDate = endDateInput.value;
                currentSelectedDate = null;
                loadAttendanceData();
                updateAttendanceTable();
            });
        }

        function setupEventListeners() {
            document.getElementById('applyFilters').addEventListener('click', function() {
                currentGrade = document.getElementById('gradeFilter').value;
                currentSection = document.getElementById('sectionFilter').value;
                currentStartDate = document.getElementById('startDate').value;
                currentEndDate = document.getElementById('endDate').value;
                currentSelectedDate = null;
                currentPage = 1; // Resetear a primera página
                loadAttendanceData();
                updateAttendanceTable();
            });

            document.getElementById('prevMonth').addEventListener('click', function() {
                currentMonth--;
                if (currentMonth < 0) { currentMonth = 11; currentYear--; }
                generateCalendar();
            });

            document.getElementById('nextMonth').addEventListener('click', function() {
                currentMonth++;
                if (currentMonth > 11) { currentMonth = 0; currentYear++; }
                generateCalendar();
            });

            document.getElementById('printTable').addEventListener('click', function() {
                window.print();
            });

            document.getElementById('studentSearch').addEventListener('input', function(e) {
                const term = e.target.value.toLowerCase();
                currentPage = 1; // Resetear a primera página al buscar
                updateAttendanceTable(term);
            });

            // Selector de periodicidad para el gráfico circular
            // Selector de periodicidad para el gráfico circular
            document.getElementById('chartPeriod').addEventListener('change', function() {
                const today = new Date();
                const startDateInput = document.getElementById('startDate');
                const endDateInput = document.getElementById('endDate');
                let start, end;

                switch(this.value) {
                    case 'today':
                        start = today.toISOString().split('T')[0];
                        end = start;
                        break;
                    case 'week':
                        const weekAgo = new Date(today);
                        weekAgo.setDate(today.getDate() - 7);
                        start = weekAgo.toISOString().split('T')[0];
                        end = today.toISOString().split('T')[0];
                        break;
                    case 'month':
                        const firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
                        const lastDay = new Date(today.getFullYear(), today.getMonth() + 1, 0);
                        start = firstDay.toISOString().split('T')[0];
                        end = lastDay.toISOString().split('T')[0];
                        break;
                    case 'year':
                        start = new Date(today.getFullYear(), 0, 1).toISOString().split('T')[0];
                        end = new Date(today.getFullYear(), 11, 31).toISOString().split('T')[0];
                        break;
                    default:
                        start = new Date(today.setDate(today.getDate() - 7)).toISOString().split('T')[0];
                        end = new Date().toISOString().split('T')[0];
                }

                currentStartDate = start;
                currentEndDate = end;
                currentSelectedDate = null;
                currentPage = 1; // Resetear a primera página
                startDateInput.value = start;
                endDateInput.value = end;
                document.getElementById('dateRange').value = 'custom';

                loadAttendanceData();
                updateAttendanceTable();
            });
        }
        

        function loadAttendanceData() {
            updateStatistics();
            renderPieChart();
        }

        function updateStatistics() {
            let filteredStudents = studentsData;
            if (currentGrade !== "") {
                filteredStudents = filteredStudents.filter(s => s.grade_id == currentGrade);
                if (currentSection !== "") {
                    filteredStudents = filteredStudents.filter(s => s.section_id == currentSection);
                }
            }

            const start = currentSelectedDate ? new Date(currentSelectedDate) : new Date(currentStartDate);
            const end = currentSelectedDate ? new Date(currentSelectedDate) : new Date(currentEndDate);
            const filtered = attendanceData.filter(r => {
                const d = new Date(r.date);
                return d >= start && d <= end;
            });

            let present = 0, late = 0, absent = 0, justified = 0;
            filtered.forEach(r => {
                switch(r.status) {
                    case 'present': present++; break;
                    case 'late': late++; break;
                    case 'absent': absent++; break;
                    case 'justified': justified++; break;
                }
            });

            const total = filtered.length;
            const rate = total > 0 ? ((present + late + justified * 0.8) / total * 100).toFixed(1) : 0;
            document.getElementById('attendanceRate').textContent = `${rate}%`;
            document.getElementById('lateCount').textContent = late;
            document.getElementById('absentCount').textContent = absent;
            document.getElementById('justifiedCount').textContent = justified;
        }

// Modificar la función renderPieChart para hacerla más compacta
function renderPieChart() {
    const container = document.getElementById('attendanceChart');
    container.innerHTML = '';

    const start = currentSelectedDate ? new Date(currentSelectedDate) : new Date(currentStartDate);
    const end = currentSelectedDate ? new Date(currentSelectedDate) : new Date(currentEndDate);
    const filtered = attendanceData.filter(r => {
        const d = new Date(r.date);
        return d >= start && d <= end;
    });

    const total = filtered.length;
    if (total === 0) {
        container.innerHTML = `
            <div class="chart-empty-state">
                <i class="bi bi-pie-chart"></i>
                <p>Sin datos para mostrar</p>
                <small class="text-muted">No hay registros de asistencia en el período seleccionado</small>
            </div>
        `;
        return;
    }

    const present = filtered.filter(r => r.status === 'present').length;
    const late = filtered.filter(r => r.status === 'late').length;
    const absent = filtered.filter(r => r.status === 'absent').length;
    const justified = filtered.filter(r => r.status === 'justified').length;

    const data = [
        { label: 'Presente', value: present, pct: ((present / total) * 100), color: '#10b981' },
        { label: 'Tardanza', value: late, pct: ((late / total) * 100), color: '#f59e0b' },
        { label: 'Falta', value: absent, pct: ((absent / total) * 100), color: '#ef4444' },
        { label: 'Justificado', value: justified, pct: ((justified / total) * 100), color: '#06b6d4' }
    ];

    data.sort((a, b) => b.value - a.value);

    // Tamaño más compacto para el gráfico
    const svgSize = 140;
    const radius = 55;
    const centerX = svgSize / 2;
    const centerY = svgSize / 2;
    let startAngle = 0;

    const svg = document.createElementNS("http://www.w3.org/2000/svg", "svg");
    svg.setAttribute("class", "pie-chart-svg");
    svg.setAttribute("viewBox", `0 0 ${svgSize} ${svgSize}`);

    data.forEach(item => {
        if (item.value === 0) return;

        const endAngle = startAngle + (item.pct / 100) * 360;
        const largeArcFlag = item.pct > 50 ? 1 : 0;

        const startX = centerX + radius * Math.cos((startAngle - 90) * Math.PI / 180);
        const startY = centerY + radius * Math.sin((startAngle - 90) * Math.PI / 180);
        const endX = centerX + radius * Math.cos((endAngle - 90) * Math.PI / 180);
        const endY = centerY + radius * Math.sin((endAngle - 90) * Math.PI / 180);

        const pathData = [
            `M ${centerX} ${centerY}`,
            `L ${startX} ${startY}`,
            `A ${radius} ${radius} 0 ${largeArcFlag} 1 ${endX} ${endY}`,
            `Z`
        ].join(' ');

        const path = document.createElementNS("http://www.w3.org/2000/svg", "path");
        path.setAttribute("d", pathData);
        path.setAttribute("fill", item.color);
        svg.appendChild(path);

        startAngle = endAngle;
    });

    const wrapper = document.createElement('div');
    wrapper.className = 'pie-chart-wrapper';

    const legend = document.createElement('div');
    legend.className = 'pie-chart-legend';

    data.forEach(item => {
        if (item.value === 0) return;
        const legendItem = document.createElement('div');
        legendItem.className = 'legend-item';
        legendItem.innerHTML = `
            <div class="legend-color" style="background-color:${item.color}"></div>
            <span>${item.label}</span>
            <span class="legend-value">${item.pct.toFixed(1)}%</span>
        `;
        legend.appendChild(legendItem);
    });

    wrapper.appendChild(svg);
    wrapper.appendChild(legend);
    container.appendChild(wrapper);
}


// CORREGIR LA FUNCIÓN generateCalendar
// CORREGIR LA FUNCIÓN generateCalendar - VERSIÓN CORREGIDA
function generateCalendar() {
    const monthNames = ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"];
    document.getElementById('currentMonth').textContent = `${monthNames[currentMonth]} ${currentYear}`;
    const grid = document.getElementById('calendarGrid');
    grid.innerHTML = '';
    
    const firstDay = new Date(currentYear, currentMonth, 1);
    const lastDay = new Date(currentYear, currentMonth + 1, 0);
    
    // CORRECCIÓN: Usar getDay() correctamente (0=Domingo, 1=Lunes, etc.)
    let firstWeekday = firstDay.getDay();
    
    // Ajustar para que la semana empiece en Lunes (0=Lunes, 6=Domingo)
    // Si getDay() devuelve 0 (Domingo), lo convertimos a 6
    // Si devuelve 1 (Lunes), queda como 0, etc.
    firstWeekday = firstWeekday === 0 ? 6 : firstWeekday - 1;
    
    // Agregar días vacíos para alinear el primer día
    for (let i = 0; i < firstWeekday; i++) {
        const emptyDay = document.createElement('div');
        emptyDay.className = 'calendar-day empty';
        grid.appendChild(emptyDay);
    }
    
    const today = new Date();
    const todayStr = today.toISOString().split('T')[0];
    
    // DEBUG: Mostrar información útil en consola
    console.log('DEBUG - Fecha actual:', {
        hoy: today.toDateString(),
        diaActual: today.getDate(),
        mesActual: today.getMonth(),
        añoActual: today.getFullYear(),
        fechaCompleta: todayStr
    });
    
    console.log('DEBUG - Calendario actual:', {
        mesMostrado: currentMonth,
        añoMostrado: currentYear,
        primerDia: firstDay.toDateString(),
        primerDiaSemana: firstWeekday
    });

    // Generar los días del mes
    for (let day = 1; day <= lastDay.getDate(); day++) {
        const dayEl = document.createElement('div');
        dayEl.className = 'calendar-day';
        dayEl.textContent = day;
        
        // CORRECCIÓN: Crear la fecha en formato YYYY-MM-DD correctamente
        // Usar el mes actual del calendario (currentMonth) y año actual del calendario (currentYear)
        const dateStr = `${currentYear}-${String(currentMonth + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
        
        // DEBUG para el día actual
        if (day === today.getDate() && currentMonth === today.getMonth() && currentYear === today.getFullYear()) {
            console.log('DEBUG - Día de hoy detectado:', {
                día: day,
                fechaGenerada: dateStr,
                fechaHoy: todayStr,
                coincide: dateStr === todayStr
            });
        }
        
        // Verificar si es hoy - COMPARACIÓN CORREGIDA
        // Solo marcar como "hoy" si estamos en el mes y año actual
        if (currentMonth === today.getMonth() && 
            currentYear === today.getFullYear() && 
            day === today.getDate()) {
            dayEl.classList.add('today');
            console.log('DEBUG - Marcando como HOY:', day);
        }
        
        // Verificar si está seleccionado
        if (dateStr === currentSelectedDate) {
            dayEl.classList.add('selected');
        }
        
        // Verificar registros de asistencia para este día
        const dayRecords = attendanceData.filter(r => r.date === dateStr);
        if (dayRecords.length > 0) {
            const counts = {present:0, late:0, absent:0, justified:0};
            dayRecords.forEach(r => counts[r.status]++);
            
            let maxStatus = 'present';
            let max = 0;
            for (const s in counts) {
                if (counts[s] > max) { 
                    max = counts[s]; 
                    maxStatus = s; 
                }
            }
            dayEl.classList.add(maxStatus);
        }
        
        // Event listener para seleccionar día
        dayEl.addEventListener('click', () => {
            document.querySelectorAll('.calendar-day.selected').forEach(el => el.classList.remove('selected'));
            dayEl.classList.add('selected');
            currentSelectedDate = dateStr;
            document.getElementById('dateRange').value = 'custom';
            document.getElementById('startDate').value = dateStr;
            document.getElementById('endDate').value = dateStr;
            loadAttendanceData();
            updateAttendanceTable();
        });
        
        grid.appendChild(dayEl);
    }
}
        // Función para generar la paginación
        // Función para generar la paginación - VERSIÓN CORREGIDA
// Función para generar la paginación - VERSIÓN COMPLETAMENTE CORREGIDA
function generatePagination(totalItems, currentPage, itemsPerPage) {
    const totalPages = Math.ceil(totalItems / itemsPerPage);
    const paginationContainer = document.getElementById('paginationContainer');
    
    if (totalPages <= 1) {
        paginationContainer.innerHTML = '';
        return;
    }

    let paginationHTML = '';
    
    // Botón Anterior
    if (currentPage > 1) {
        paginationHTML += `<li class="page-item">
            <a class="page-link" href="#" data-page="${currentPage - 1}">Anterior</a>
        </li>`;
    } else {
        paginationHTML += `<li class="page-item disabled">
            <span class="page-link">Anterior</span>
        </li>`;
    }

    // Números de página
    const maxVisiblePages = 5;
    let startPage = Math.max(1, currentPage - Math.floor(maxVisiblePages / 2));
    let endPage = Math.min(totalPages, startPage + maxVisiblePages - 1);
    
    // Ajustar si estamos cerca del final
    if (endPage - startPage + 1 < maxVisiblePages) {
        startPage = Math.max(1, endPage - maxVisiblePages + 1);
    }

    // Primera página y puntos suspensivos si es necesario
    if (startPage > 1) {
        paginationHTML += `<li class="page-item">
            <a class="page-link" href="#" data-page="1">1</a>
        </li>`;
        if (startPage > 2) {
            paginationHTML += `<li class="page-item disabled">
                <span class="page-link">...</span>
            </li>`;
        }
    }

    // Páginas visibles
    for (let i = startPage; i <= endPage; i++) {
        if (i === currentPage) {
            paginationHTML += `<li class="page-item active">
                <span class="page-link">${i}</span>
            </li>`;
        } else {
            paginationHTML += `<li class="page-item">
                <a class="page-link" href="#" data-page="${i}">${i}</a>
            </li>`;
        }
    }

    // Última página y puntos suspensivos si es necesario
    if (endPage < totalPages) {
        if (endPage < totalPages - 1) {
            paginationHTML += `<li class="page-item disabled">
                <span class="page-link">...</span>
            </li>`;
        }
        paginationHTML += `<li class="page-item">
            <a class="page-link" href="#" data-page="${totalPages}">${totalPages}</a>
        </li>`;
    }

    // Botón Siguiente
    if (currentPage < totalPages) {
        paginationHTML += `<li class="page-item">
            <a class="page-link" href="#" data-page="${currentPage + 1}">Siguiente</a>
        </li>`;
    } else {
        paginationHTML += `<li class="page-item disabled">
            <span class="page-link">Siguiente</span>
        </li>`;
    }

    paginationContainer.innerHTML = paginationHTML;
}

// Función para debuggear la paginación (opcional)
function debugPagination() {
    console.log('Current Page:', currentPage);
    console.log('Total Students:', currentFilteredStudents.length);
    console.log('Total Pages:', Math.ceil(currentFilteredStudents.length / itemsPerPage));
}

         // Modificar la función updateAttendanceTable para incluir paginación
       // Modificar la función updateAttendanceTable para incluir paginación - VERSIÓN CORREGIDA
function updateAttendanceTable(searchTerm = '') {
    const body = document.getElementById('attendanceTableBody');
    let students = studentsData;
    
    // Aplicar filtros
    if (currentGrade !== "") {
        students = students.filter(s => s.grade_id == currentGrade);
        if (currentSection !== "") {
            students = students.filter(s => s.section_id == currentSection);
        }
    }
    
    if (searchTerm.trim() !== '') {
        students = students.filter(s =>
            s.dni.toLowerCase().includes(searchTerm) ||
            s.name.toLowerCase().includes(searchTerm)
        );
    }

    // Guardar estudiantes filtrados para la paginación
    currentFilteredStudents = students;

    const start = currentSelectedDate ? new Date(currentSelectedDate) : new Date(currentStartDate);
    const end = currentSelectedDate ? new Date(currentSelectedDate) : new Date(currentEndDate);
    const filtered = attendanceData.filter(r => {
        const d = new Date(r.date);
        return d >= start && d <= end;
    });

    // Calcular paginación
    const totalItems = students.length;
    const totalPages = Math.ceil(totalItems / itemsPerPage);
    
    // Ajustar página actual si es necesario
    if (currentPage > totalPages && totalPages > 0) {
        currentPage = totalPages;
    } else if (currentPage < 1 && totalPages > 0) {
        currentPage = 1;
    }

    // Obtener estudiantes para la página actual
    const startIndex = (currentPage - 1) * itemsPerPage;
    const endIndex = Math.min(startIndex + itemsPerPage, totalItems);
    const studentsToShow = students.slice(startIndex, endIndex);

    body.innerHTML = '';
    
    if (studentsToShow.length === 0) {
        body.innerHTML = `<tr><td colspan="8" class="text-center py-4 text-muted"><i class="bi bi-people display-4"></i><br>No hay estudiantes</td></tr>`;
        document.getElementById('showingCount').textContent = '0';
        document.getElementById('totalCount').textContent = '0';
        generatePagination(0, 1, itemsPerPage);
        return;
    }

    // Actualizar contadores
    document.getElementById('showingCount').textContent = `${startIndex + 1}-${endIndex}`;
    document.getElementById('totalCount').textContent = totalItems;

    // Generar filas de la tabla
    studentsToShow.forEach(student => {
        const records = filtered.filter(r => r.student_dni === student.dni);
        const present = records.filter(r => r.status === 'present').length;
        const late = records.filter(r => r.status === 'late').length;
        const absent = records.filter(r => r.status === 'absent').length;
        const justified = records.filter(r => r.status === 'justified').length;
        let weighted = 0;
        records.forEach(r => {
            if (r.status === 'present') weighted += 100;
            else if (r.status === 'late') weighted += 50;
            else if (r.status === 'justified') weighted += 80;
        });
        const pct = records.length > 0 ? Math.round(weighted / records.length) : 0;
        const row = document.createElement('tr');
        row.innerHTML = `
            <td class="ps-4">
                <div class="d-flex align-items-center">
                    <div class="student-avatar me-3"><i class="bi bi-person"></i></div>
                    <div><div class="student-name">${student.name}</div><div class="student-info">DNI: ${student.dni}</div></div>
                </div>
            </td>
            <td><span class="badge bg-primary">${student.grade}</span> <span class="badge bg-success">${student.section}</span></td>
            <td class="text-center"><span class="badge bg-success">${present}</span></td>
            <td class="text-center"><span class="badge bg-warning">${late}</span></td>
            <td class="text-center"><span class="badge bg-danger">${absent}</span></td>
            <td class="text-center"><span class="badge bg-info">${justified}</span></td>
            <td class="text-center">
                <div class="progress" style="height:8px;"><div class="progress-bar ${pct>=90?'bg-success':pct>=70?'bg-warning':'bg-danger'}" style="width:${pct}%"></div></div>
                <small class="fw-semibold">${pct}%</small>
            </td>
            <td class="pe-4">
                <button class="btn btn-sm btn-outline-primary view-details" data-student-dni="${student.dni}"><i class="bi bi-eye"></i> Detalles</button>
            </td>
        `;
        body.appendChild(row);
    });

    // Generar paginación
    generatePagination(totalItems, currentPage, itemsPerPage);

    // Agregar event listeners a los botones de detalles
    document.querySelectorAll('.view-details').forEach(btn => {
        btn.addEventListener('click', () => {
            showStudentDetails(btn.dataset.studentDni);
        });
    });
    
    // Debug (opcional - puedes remover esto después)
    debugPagination();
}
    </script>
</body>
</html>