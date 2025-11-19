<!DOCTYPE html>
<html lang="{{ session('language', 'es') }}" data-theme="{{ session('theme', 'light') }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asistente IA - Sistema Escolar</title>
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

        /* Asistente IA Container */
        .assistant-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .assistant-card {
            background: var(--card-bg);
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            overflow: hidden;
            margin-bottom: 2rem;
        }

        .assistant-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);
            color: white;
            padding: 2rem;
            text-align: center;
        }

        .assistant-avatar {
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 2rem;
            border: 3px solid rgba(255, 255, 255, 0.3);
        }

        .assistant-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .assistant-subtitle {
            opacity: 0.9;
            font-size: 1rem;
        }

        .chat-container {
            height: 600px;
            display: flex;
            flex-direction: column;
        }

        .chat-messages {
            flex: 1;
            padding: 1.5rem;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 1rem;
            background: var(--light-bg);
        }

        .message {
            max-width: 80%;
            padding: 1rem 1.25rem;
            border-radius: 18px;
            font-size: 0.95rem;
            line-height: 1.5;
            position: relative;
            animation: messageSlide 0.3s ease-out;
        }

        @keyframes messageSlide {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .message.user {
            align-self: flex-end;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);
            color: white;
            border-bottom-right-radius: 6px;
        }

        .message.bot {
            align-self: flex-start;
            background: white;
            color: var(--text-primary);
            border-bottom-left-radius: 6px;
            border: 1px solid var(--border-color);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .message.loading {
            background: white;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-style: italic;
        }

        .message.intelligent {
            background: white;
            border-left: 4px solid var(--primary-color);
        }

        .intelligent-response {
            white-space: pre-line;
        }

        .thinking-process {
            margin-top: 1rem;
            padding: 1rem;
            background: var(--light-bg);
            border-radius: 8px;
            border-left: 3px solid var(--info-color);
        }

        .thinking-process .step {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0.5rem;
            font-size: 0.85rem;
            color: var(--text-muted);
        }

        .thinking-process .step:last-child {
            margin-bottom: 0;
        }

        .step-icon {
            font-size: 0.8rem;
        }

        .student-info {
            background: var(--light-bg);
            border-radius: 8px;
            padding: 1rem;
            margin: 0.75rem 0;
            border-left: 3px solid var(--primary-color);
        }

        .quick-stats {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0.75rem;
            margin: 1rem 0;
        }

        .stat-mini {
            background: white;
            padding: 0.75rem;
            border-radius: 8px;
            text-align: center;
            border: 1px solid var(--border-color);
        }

        .stat-mini .number {
            font-weight: 700;
            font-size: 1.25rem;
            display: block;
            color: var(--primary-color);
        }

        .stat-mini .label {
            font-size: 0.75rem;
            color: var(--text-muted);
            margin-top: 0.25rem;
        }

        .chat-input-container {
            padding: 1.5rem;
            border-top: 1px solid var(--border-color);
            background: white;
        }

        .input-group {
            gap: 0.5rem;
        }

        .chat-input {
            border-radius: 24px;
            padding: 0.75rem 1.25rem;
            border: 1px solid var(--border-color);
            font-size: 0.95rem;
            transition: var(--transition);
        }

        .chat-input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }

        .voice-btn {
            width: 45px;
            height: 45px;
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
            width: 45px;
            height: 45px;
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
            padding: 1rem 1.5rem;
            border-top: 1px solid var(--border-color);
            background: var(--light-bg);
        }

        .suggestion {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 20px;
            padding: 0.5rem 1rem;
            font-size: 0.85rem;
            cursor: pointer;
            transition: var(--transition);
            color: var(--text-secondary);
        }

        .suggestion:hover {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
            transform: translateY(-2px);
        }

        .typing-indicator {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--text-muted);
            font-style: italic;
        }

        .typing-dot {
            width: 8px;
            height: 8px;
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

        @keyframes pulse {
            0% {
                transform: scale(1);
                opacity: 0.8;
            }
            70% {
                transform: scale(1.1);
                opacity: 0;
            }
            100% {
                transform: scale(1.1);
                opacity: 0;
            }
        }

        .cursor {
            animation: blink 1s infinite;
        }

        @keyframes blink {
            0%, 100% { opacity: 1; }
            50% { opacity: 0; }
        }

        /* Responsive */
        @media (max-width: 1200px) {
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
            .message {
                max-width: 90%;
            }
            .assistant-header {
                padding: 1.5rem;
            }
            .chat-container {
                height: 500px;
            }
        }

        @media (max-width: 576px) {
            .suggestions {
                justify-content: center;
            }
            .suggestion {
                font-size: 0.8rem;
                padding: 0.4rem 0.8rem;
            }
            .quick-stats {
                grid-template-columns: 1fr;
            }
        }

        /* Mejoras para el asistente IA */
.intelligent-response {
    line-height: 1.6;
}

.student-info {
    background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
    border-radius: 12px;
    padding: 1.25rem;
    margin: 1rem 0;
    border-left: 4px solid #3b82f6;
    box-shadow: 0 2px 8px rgba(59, 130, 246, 0.1);
}

.quick-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
    gap: 0.75rem;
    margin: 1rem 0;
}

.stat-mini {
    background: white;
    padding: 1rem;
    border-radius: 12px;
    text-align: center;
    border: 1px solid #e2e8f0;
    transition: all 0.3s ease;
}

.stat-mini:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.stat-mini .number {
    font-weight: 700;
    font-size: 1.5rem;
    display: block;
    color: #3b82f6;
}

.stat-mini .label {
    font-size: 0.8rem;
    color: #64748b;
    margin-top: 0.25rem;
}

.thinking-process {
    margin-top: 1rem;
    padding: 1rem;
    background: #f8fafc;
    border-radius: 8px;
    border-left: 4px solid #06b6d4;
    font-size: 0.85rem;
}

.step {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
    margin-bottom: 0.75rem;
    padding: 0.5rem;
    background: white;
    border-radius: 6px;
    border: 1px solid #e2e8f0;
}

.step:last-child {
    margin-bottom: 0;
}

.step-icon {
    font-size: 0.8rem;
    color: #06b6d4;
    flex-shrink: 0;
    margin-top: 0.1rem;
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
                    <a class="nav-link" href="{{ route('attendance.reports') }}">
                        <i class="bi bi-journal-text"></i>
                        <span>Reportes</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('admin.asistente') }}">
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

    <!-- Main Content -->
    <div class="main-content">
        <!-- Encabezado -->
        <div class="dashboard-header">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="h2 fw-bold mb-2">Asistente IA Escolar</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Inicio</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Asistente IA</li>
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
            <div class="assistant-container">
                <div class="assistant-card">
                    <div class="assistant-header">
                        <div class="assistant-avatar">
                            <i class="bi bi-robot"></i>
                        </div>
                        <h2 class="assistant-title">EduAssist - Asistente Inteligente</h2>
                        <p class="assistant-subtitle">Pregunta anything sobre estudiantes, asistencias y reportes en lenguaje natural</p>
                    </div>

                    <div class="chat-container">
                        <div class="chat-messages" id="chatMessages">
                            <!-- Mensaje de bienvenida -->
                            <div class="message bot intelligent">
                                <div class="intelligent-response">
                                    <strong>🤖 ¡Hola! Soy EduAssist, tu asistente escolar inteligente</strong>
                                    <br><br>
                                    Estoy aquí para ayudarte con cualquier consulta sobre el sistema escolar. Puedo responder preguntas sobre:
                                    <br><br>
                                    📚 <strong>Estudiantes específicos</strong><br>
                                    • "¿María García asistió hoy?"<br>
                                    • "Información del DNI 12345678"<br>
                                    • "Buscar a Juan Pérez"<br><br>
                                    
                                    📅 <strong>Asistencias y reportes</strong><br>
                                    • "Asistencia de hoy"<br>
                                    • "¿Quiénes faltaron el lunes?"<br>
                                    • "Reporte de 4to A"<br><br>
                                    
                                    🏫 <strong>Información de grados</strong><br>
                                    • "Estudiantes de 3ro B"<br>
                                    • "Cómo está 5to grado"<br><br>
                                    
                                    📊 <strong>Estadísticas generales</strong><br>
                                    • "Resumen del sistema"<br>
                                    • "Métricas de asistencia"<br><br>
                                    
                                    <em>¡Pregúntame de manera natural! Soy bastante inteligente 😊</em>
                                </div>
                            </div>
                        </div>

                        <div class="suggestions">
                            <div class="suggestion" data-question="Asistencia de hoy">📊 Asistencia Hoy</div>
                            <div class="suggestion" data-question="¿Cómo buscar por DNI?">🔍 Buscar por DNI</div>
                            <div class="suggestion" data-question="Reporte del sistema">📈 Reporte General</div>
                            <div class="suggestion" data-question="¿Cómo consultar información de grados?">🏫 Información de Grado</div>
                            <div class="suggestion" data-question="¿Quiénes faltaron hoy?">❌ Faltas de Hoy</div>
                        </div>

                        <div class="chat-input-container">
                            <div class="input-group">
                                <input type="text" class="form-control chat-input" id="chatInput" 
                                       placeholder="Escribe tu pregunta sobre el sistema escolar..." 
                                       autocomplete="off">
                                <button class="voice-btn" id="voiceBtn">
                                    <i class="bi bi-mic"></i>
                                </button>
                                <button class="send-btn" id="sendBtn">
                                    <i class="bi bi-send"></i>
                                </button>
                            </div>
                        </div>
                    </div>
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
      document.addEventListener('DOMContentLoaded', function() {
    const chatMessages = document.getElementById('chatMessages');
    const chatInput = document.getElementById('chatInput');
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
            chatInput.value = transcript;
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
    
    // Enviar mensaje
 async function sendMessage() {
    const message = chatInput.value.trim();
    if (message === '') return;
    
    addMessage('user', message);
    chatInput.value = '';
    
    showTypingIndicator();
    
    try {
        console.log('Enviando consulta:', message);
        
        const response = await fetch('/asistente/query', {
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

        console.log('Respuesta recibida, status:', response.status);

        // Verificar si la respuesta es JSON
        const contentType = response.headers.get('content-type');
        if (!contentType || !contentType.includes('application/json')) {
            const text = await response.text();
            console.error('Respuesta no JSON:', text.substring(0, 200));
            throw new Error('El servidor devolvió una respuesta no válida');
        }

        const data = await response.json();
        console.log('Datos parseados:', data);
        
        removeTypingIndicator();
        
        if (data.success) {
            await typewriterEffect(data.message, 'bot', data.data, data.thinking);
            
            conversationHistory.push({ role: 'user', content: message });
            conversationHistory.push({ role: 'assistant', content: data.message });
            
            if (conversationHistory.length > 8) {
                conversationHistory = conversationHistory.slice(-8);
            }
        } else {
            addMessage('bot', '❌ ' + data.message);
        }
        
    } catch (error) {
        removeTypingIndicator();
        console.error('Error completo:', error);
        
        addMessage('bot', `🤖 **EduAssist**\n\n¡Hola! 👋 \n\nParece que hay un problema de comunicación con el servidor.\n\n**Error técnico:** ${error.message}\n\nPor favor, recarga la página e intenta nuevamente.`);
    }
}
    
    // Efecto de máquina de escribir
    async function typewriterEffect(text, sender, data = null, thinking = null) {
        const messageDiv = document.createElement('div');
        messageDiv.className = `message ${sender} intelligent`;
        
        const contentDiv = document.createElement('div');
        contentDiv.className = 'intelligent-response';
        contentDiv.innerHTML = '<span class="cursor">|</span>';
        
        messageDiv.appendChild(contentDiv);
        chatMessages.appendChild(messageDiv);
        
        let index = 0;
        const speed = 20;
        
        function type() {
            if (index < text.length) {
                contentDiv.innerHTML = text.substring(0, index + 1) + '<span class="cursor">|</span>';
                index++;
                setTimeout(type, speed);
            } else {
                contentDiv.innerHTML = text;
                if (thinking && thinking.length > 0) {
                    addThinkingProcess(thinking, messageDiv);
                }
                if (data) {
                    addDataVisualization(data, messageDiv);
                }
                scrollToBottom();
            }
        }
        
        type();
    }
    
    // Añadir proceso de pensamiento
    function addThinkingProcess(thinkingSteps, messageDiv) {
        const thinkingDiv = document.createElement('div');
        thinkingDiv.className = 'thinking-process';
        
        thinkingDiv.innerHTML = `
            <small class="text-muted"><strong>Proceso de análisis:</strong></small>
            ${thinkingSteps.map(step => `
                <div class="step">
                    <div class="step-icon">🔍</div>
                    <div>${step}</div>
                </div>
            `).join('')}
        `;
        
        messageDiv.appendChild(thinkingDiv);
    }
    
    // Añadir visualización de datos
    function addDataVisualization(data, messageDiv) {
        if (!data) return;
        
        const dataDiv = document.createElement('div');
        dataDiv.className = 'student-info';
        
        switch (data.type) {
            case 'student_info':
                dataDiv.innerHTML = `
                    <strong>📊 Resumen del Estudiante:</strong><br>
                    • Total registros: ${data.attendance_stats.total}<br>
                    • Asistencias: ${data.attendance_stats.present}<br>
                    • Tasa: ${data.attendance_stats.rate}%
                `;
                break;
                
            case 'attendance_today':
                dataDiv.innerHTML = `
                    <strong>📈 Estadísticas de Hoy:</strong><br>
                    • Presentes: ${data.present}<br>
                    • Ausentes: ${data.absent}<br>
                    • Tardíos: ${data.late}<br>
                    • Tasa: ${data.attendance_rate}%
                `;
                break;
                
            case 'grade_info':
                dataDiv.innerHTML = `
                    <strong>🏫 Información del Grado:</strong><br>
                    • Total estudiantes: ${data.students_count}<br>
                    • Asistencia hoy: ${data.attendance_today}<br>
                    • Tasa: ${data.attendance_rate}%
                `;
                break;
        }
        
        messageDiv.appendChild(dataDiv);
    }
    
    sendBtn.addEventListener('click', sendMessage);
    
    chatInput.addEventListener('keypress', function(e) {
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
            chatInput.value = question;
            sendMessage();
        });
    });
    
    // Añadir mensaje al chat
    function addMessage(sender, text) {
        const messageDiv = document.createElement('div');
        messageDiv.className = `message ${sender}`;
        
        // Procesar texto con formato Markdown básico
        const processedText = text.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
                                 .replace(/\n/g, '<br>');
        
        messageDiv.innerHTML = processedText;
        chatMessages.appendChild(messageDiv);
        scrollToBottom();
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
        chatMessages.appendChild(typingDiv);
        scrollToBottom();
    }
    
    // Remover indicador de escritura
    function removeTypingIndicator() {
        const typingIndicator = document.getElementById('typingIndicator');
        if (typingIndicator) {
            chatMessages.removeChild(typingIndicator);
        }
    }
    
    // Desplazar al final del chat
    function scrollToBottom() {
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }
    
    // Auto-focus en el input
    chatInput.focus();
});
    </script>
</body>
</html>