<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Premium</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#1e3a8a',
                        'primary-dark': '#1e40af',
                        secondary: '#3b82f6',
                        accent: '#60a5fa',
                        success: '#10b981',
                        error: '#ef4444',
                        warning: '#f59e0b',
                        dark: '#0f172a',
                        light: '#f8fafc',
                        gray: '#64748b',
                        'gray-light': '#e2e8f0',
                        'glass': 'rgba(255, 255, 255, 0.1)',
                        'glass-dark': 'rgba(0, 0, 0, 0.1)',
                    },
                    boxShadow: {
                        'glass': '0 8px 32px 0 rgba(31, 38, 135, 0.37)',
                        'soft': '0 10px 30px rgba(0, 0, 0, 0.08)',
                        'soft-hover': '0 15px 40px rgba(0, 0, 0, 0.12)',
                        'glow': '0 0 20px rgba(59, 130, 246, 0.3)',
                    },
                    backdropBlur: {
                        'xs': '2px',
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'pulse-soft': 'pulse-soft 2s ease-in-out infinite',
                        'progress-bar': 'progress-bar 2s ease-in-out infinite',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-10px)' },
                        },
                        'pulse-soft': {
                            '0%, 100%': { opacity: '1' },
                            '50%': { opacity: '0.7' },
                        },
                        'progress-bar': {
                            '0%': { transform: 'translateX(-100%)' },
                            '50%': { transform: 'translateX(0%)' },
                            '100%': { transform: 'translateX(100%)' },
                        }
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow-x: hidden;
        }
        
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 20% 80%, rgba(30, 64, 175, 0.4) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(59, 130, 246, 0.4) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(96, 165, 250, 0.3) 0%, transparent 50%);
            z-index: -1;
        }
        
        .login-card {
            backdrop-filter: blur(10px);
            background: rgba(15, 23, 42, 0.85);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.25);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        
        .login-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 35px 60px rgba(0, 0, 0, 0.3), 0 0 0 1px rgba(255, 255, 255, 0.1);
        }
        
        .header-gradient {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            position: relative;
            overflow: hidden;
        }
        
        .header-gradient::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, rgba(255,255,255,0.1) 0%, transparent 50%);
        }
        
        .input-group {
            transition: all 0.3s ease;
            background: rgba(30, 41, 59, 0.7);
            border: 1px solid rgba(100, 116, 139, 0.3);
        }
        
        .input-group:focus-within {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(59, 130, 246, 0.3);
            border-color: #3b82f6;
        }
        
        .input-error {
            border-color: #ef4444 !important;
            box-shadow: 0 5px 15px rgba(239, 68, 68, 0.2) !important;
        }
        
        .input-success {
            border-color: #10b981 !important;
            box-shadow: 0 5px 15px rgba(16, 185, 129, 0.2) !important;
        }
        
        .btn-login {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .btn-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }
        
        .btn-login:hover::before {
            left: 100%;
        }
        
        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(59, 130, 246, 0.5);
        }
        
        .social-btn {
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .social-btn::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            transition: width 0.3s, height 0.3s, top 0.3s, left 0.3s;
        }
        
        .social-btn:hover::after {
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            border-radius: 0;
        }
        
        .floating-element {
            animation: float 6s ease-in-out infinite;
        }
        
        .password-toggle {
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .password-toggle:hover {
            color: #3b82f6;
            transform: scale(1.1);
        }
        
        .error-shake {
            animation: shake 0.5s ease-in-out;
        }
        
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            20%, 60% { transform: translateX(-5px); }
            40%, 80% { transform: translateX(5px); }
        }
        
        .success-check {
            animation: success-check 0.5s ease-in-out;
        }
        
        @keyframes success-check {
            0% { transform: scale(0); opacity: 0; }
            70% { transform: scale(1.2); opacity: 1; }
            100% { transform: scale(1); opacity: 1; }
        }
        
        .floating-shape-1 {
            position: absolute;
            top: 10%;
            left: 10%;
            width: 100px;
            height: 100px;
            border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
            background: rgba(30, 58, 138, 0.2);
            animation: float 8s ease-in-out infinite;
            z-index: -1;
        }
        
        .floating-shape-2 {
            position: absolute;
            bottom: 10%;
            right: 10%;
            width: 150px;
            height: 150px;
            border-radius: 60% 40% 30% 70% / 60% 30% 70% 40%;
            background: rgba(59, 130, 246, 0.2);
            animation: float 10s ease-in-out infinite;
            z-index: -1;
        }
        
        .floating-shape-3 {
            position: absolute;
            top: 50%;
            right: 20%;
            width: 80px;
            height: 80px;
            border-radius: 50% 50% 50% 50% / 60% 60% 40% 40%;
            background: rgba(96, 165, 250, 0.2);
            animation: float 7s ease-in-out infinite;
            z-index: -1;
        }
        
        .validation-icon {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .validation-icon.show {
            opacity: 1;
        }
        
        .text-light {
            color: #f8fafc;
        }
        
        .text-light-muted {
            color: rgba(248, 250, 252, 0.7);
        }
        
        .bg-dark-input {
            background: rgba(30, 41, 59, 0.7);
        }
        
        .border-light {
            border-color: rgba(255, 255, 255, 0.1);
        }

        /* Animaciones personalizadas para SweetAlert */
        .swal2-progress-steps {
            background: rgba(59, 130, 246, 0.1) !important;
            border: 1px solid rgba(59, 130, 246, 0.3) !important;
        }

        .swal2-progress-bar {
            background: linear-gradient(90deg, #3b82f6, #60a5fa) !important;
            animation: progress-bar 1.5s ease-in-out infinite !important;
        }
    </style>
</head>
<body class="p-4">
    <!-- Elementos de fondo flotantes -->
    <div class="floating-shape-1"></div>
    <div class="floating-shape-2"></div>
    <div class="floating-shape-3"></div>
    
    <!-- Tarjeta de login -->
    <div class="login-card rounded-3xl w-full max-w-md overflow-hidden">
        <!-- Header con gradiente -->
        <div class="header-gradient py-10 px-6 text-center relative">
            <div class="floating-element inline-flex items-center justify-center w-20 h-20 rounded-2xl bg-white bg-opacity-20 mb-4">
                <i class="fas fa-user-lock text-3xl text-white"></i>
            </div>
            <h2 class="text-3xl font-bold text-white mb-2">Bienvenido</h2>
            <p class="text-white text-opacity-90">Inicia sesión en tu cuenta</p>
        </div>
        
        <!-- Cuerpo del formulario -->
        <div class="p-8">
            <!-- Mostrar errores de Laravel -->
            @if($errors->any())
                <div class="mb-4 p-4 bg-red-500 bg-opacity-20 border border-red-400 rounded-lg">
                    <div class="flex items-center text-red-300">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        <span class="font-semibold">Error de autenticación</span>
                    </div>
                    <ul class="mt-2 text-red-300 text-sm">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-500 bg-opacity-20 border border-green-400 rounded-lg">
                    <div class="flex items-center text-green-300">
                        <i class="fas fa-check-circle mr-2"></i>
                        <span class="font-semibold">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            <form id="loginForm" method="POST" action="{{ route('login.post') }}">
                @csrf
                
                <!-- Campo Email -->
                <div class="mb-6">
                    <label for="email" class="block text-light font-semibold mb-3 flex items-center">
                        <i class="fas fa-envelope text-accent mr-2"></i>Correo Electrónico
                    </label>
                    <div class="input-group flex items-center border border-light rounded-xl overflow-hidden transition-all duration-300 relative">
                        <span class="px-4 py-4 bg-dark-input text-light-muted border-r border-light">
                            <i class="fas fa-at"></i>
                        </span>
                        <input 
                            id="email" 
                            type="email" 
                            name="email" 
                            value="{{ old('email') }}" 
                            required 
                            autocomplete="email" 
                            autofocus 
                            placeholder="tu@email.com"
                            class="w-full px-4 py-4 outline-none bg-transparent text-light placeholder-light-muted"
                        >
                        <!-- Icono de validación para email -->
                        <span id="emailValidationIcon" class="validation-icon">
                            <i class="fas fa-check-circle text-success"></i>
                        </span>
                    </div>
                    <div id="emailError" class="text-red-400 text-sm mt-2 ml-1 hidden flex items-center">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        <span></span>
                    </div>
                </div>
                
                <!-- Campo Contraseña -->
                <div class="mb-6">
                    <label for="password" class="block text-light font-semibold mb-3 flex items-center">
                        <i class="fas fa-lock text-accent mr-2"></i>Contraseña
                    </label>
                    <div class="input-group flex items-center border border-light rounded-xl overflow-hidden transition-all duration-300 relative">
                        <span class="px-4 py-4 bg-dark-input text-light-muted border-r border-light">
                            <i class="fas fa-key"></i>
                        </span>
                        <input 
                            id="password" 
                            type="password" 
                            name="password" 
                            required 
                            autocomplete="current-password" 
                            placeholder="Tu contraseña"
                            class="w-full px-4 py-4 outline-none bg-transparent text-light placeholder-light-muted"
                        >
                        <button type="button" id="togglePassword" class="password-toggle px-4 py-4 text-light-muted hover:text-accent">
                            <i class="fas fa-eye"></i>
                        </button>
                        <!-- Icono de validación para contraseña -->
                        <span id="passwordValidationIcon" class="validation-icon">
                            <i class="fas fa-check-circle text-success"></i>
                        </span>
                    </div>
                    <div id="passwordError" class="text-red-400 text-sm mt-2 ml-1 hidden flex items-center">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        <span></span>
                    </div>
                </div>
                
                <!-- Recordar contraseña y olvidé contraseña -->
                <div class="flex justify-between items-center mb-6">
                    <div class="flex items-center">
                        <input type="checkbox" id="remember" name="remember" class="h-4 w-4 text-primary rounded focus:ring-primary border-gray-300">
                        <label for="remember" class="ml-2 text-light-muted text-sm">Recordar sesión</label>
                    </div>
                </div>
                
                <!-- Botón de Login -->
                <button type="submit" class="btn-login w-full text-white py-4 rounded-xl font-semibold mb-6 relative overflow-hidden">
                    <i class="fas fa-sign-in-alt mr-2"></i>Iniciar Sesión
                </button>
            </form>
        </div>
    </div>

    <script>
        // Toggle para mostrar/ocultar contraseña
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const icon = this.querySelector('i');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
                this.classList.add('text-accent');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
                this.classList.remove('text-accent');
            }
        });
        
        // Validación en tiempo real para email
        document.getElementById('email').addEventListener('blur', function() {
            validateEmailField(this);
        });
        
        // Validación en tiempo real para contraseña
        document.getElementById('password').addEventListener('blur', function() {
            validatePasswordField(this);
        });
        
        // Validación del formulario - ENVÍO REAL
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const email = document.getElementById('email');
            const password = document.getElementById('password');
            const emailError = document.getElementById('emailError');
            const passwordError = document.getElementById('passwordError');
            const submitBtn = this.querySelector('button[type="submit"]');
            
            let isValid = true;
            
            // Limpiar errores previos
            email.parentElement.classList.remove('input-error', 'input-success');
            password.parentElement.classList.remove('input-error', 'input-success');
            emailError.classList.add('hidden');
            passwordError.classList.add('hidden');
            
            // Validar email
            const emailValidation = validateEmailField(email);
            if (!emailValidation.isValid) {
                isValid = false;
            }
            
            // Validar contraseña
            const passwordValidation = validatePasswordField(password);
            if (!passwordValidation.isValid) {
                isValid = false;
            }
            
            if (!isValid) {
                e.preventDefault();
                // Mostrar alerta de error con SweetAlert
                Swal.fire({
                    icon: 'error',
                    title: 'Error de validación',
                    text: 'Por favor corrige los errores en el formulario',
                    confirmButtonColor: '#3b82f6',
                    background: '#0f172a',
                    color: '#f8fafc',
                    customClass: {
                        popup: 'login-swal-popup'
                    }
                });
                return;
            }
            
            // Animación de envío
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Iniciando sesión...';
            submitBtn.disabled = true;
            
            // Mostrar animación profesional de SweetAlert
            showLoginAnimation();
            
            // El formulario se enviará normalmente a Laravel
        });
        
        // Función para mostrar animación profesional de login
// Función para mostrar animación profesional de login - Versión simple y efectiva
function showLoginAnimation() {
    Swal.fire({
        title: 'Iniciando Sesión',
        html: `
            <div class="text-center">
                <div class="mb-4">
                    <i class="fas fa-lock text-4xl text-blue-400 mb-3"></i>
                </div>
                <div class="text-sm text-gray-300 mb-4" id="status-text">Procesando solicitud de acceso...</div>
                <div class="w-full bg-gray-700 rounded-full h-2.5 mb-4 overflow-hidden">
                    <div id="login-progress" class="bg-gradient-to-r from-blue-500 to-blue-400 h-2.5 rounded-full transition-all duration-700 ease-out" style="width: 0%"></div>
                </div>
                <div class="flex justify-between text-xs text-gray-400">
                    <span>Procesando</span>
                    <span id="progress-text">0%</span>
                </div>
            </div>
        `,
        showConfirmButton: false,
        allowOutsideClick: false,
        allowEscapeKey: false,
        background: '#0f172a',
        color: '#f8fafc',
        customClass: {
            popup: 'login-swal-popup',
            title: 'text-white text-xl font-semibold'
        },
        didOpen: () => {
            const progressBar = document.getElementById('login-progress');
            const progressText = document.getElementById('progress-text');
            const statusText = document.getElementById('status-text');

            let progress = 0;
            const targetProgress = 100;
            const duration = 6800; // 3.8 segundos en total
            const startTime = Date.now();

            function animateProgress() {
                const currentTime = Date.now();
                const elapsed = currentTime - startTime;
                
                // Cálculo suave del progreso (siempre llega al 100%)
                progress = Math.min((elapsed / duration) * targetProgress, targetProgress);
                
                // Aplicar easing para un movimiento más natural
                const easedProgress = easeOutCubic(progress / targetProgress) * targetProgress;
                
                progressBar.style.width = easedProgress + '%';
                progressText.textContent = Math.round(easedProgress) + '%';

                // Cambiar mensajes según el progreso
                if (easedProgress < 25) {
                    statusText.textContent = 'Verificando credenciales...';
                } else if (easedProgress < 50) {
                    statusText.textContent = 'Autenticando usuario...';
                } else if (easedProgress < 75) {
                    statusText.textContent = 'Cargando configuración...';
                } else if (easedProgress < 95) {
                    statusText.textContent = 'Preparando interfaz...';
                } else {
                    statusText.textContent = '¡Acceso concedido!';
                }

                if (easedProgress < targetProgress) {
                    requestAnimationFrame(animateProgress);
                } else {
                    // Cuando llegue al 100%, mostrar éxito
                    setTimeout(() => {
                        showSuccessMessage();
                    }, 500);
                }
            }

            // Función de easing para movimiento suave
            function easeOutCubic(t) {
                return 1 - Math.pow(1 - t, 3);
            }

            // Mostrar mensaje de éxito
            function showSuccessMessage() {
                Swal.update({
                    title: '¡Éxito! ✅',
                    html: `
                        <div class="text-center">
                            <div class="text-lg text-green-300 font-semibold mb-2">
                                Autenticación completada
                            </div>
                            <div class="text-sm text-gray-300 animate-pulse">
                                Redirigiendo al sistema...
                            </div>
                        </div>
                    `,
                    customClass: {
                        title: 'text-green-400 text-xl font-semibold'
                    }
                });

                // Redirigir después de 1.5 segundos
                setTimeout(() => {
                    document.getElementById('loginForm').submit();
                }, 1500);
            }

            // Iniciar la animación
            animateProgress();
        }
    });
}
        
        // Función para validar el campo de email
        function validateEmailField(emailField) {
            const emailValue = emailField.value.trim();
            const emailError = document.getElementById('emailError');
            const emailValidationIcon = document.getElementById('emailValidationIcon');
            
            // Limpiar estado previo
            emailField.parentElement.classList.remove('input-error', 'input-success');
            emailError.classList.add('hidden');
            emailValidationIcon.classList.remove('show');
            
            // Validar campo vacío
            if (!emailValue) {
                emailField.parentElement.classList.add('input-error');
                emailError.querySelector('span').textContent = 'El correo electrónico es requerido.';
                emailError.classList.remove('hidden');
                return { isValid: false, message: 'El correo electrónico es requerido.' };
            }
            
            // Validar formato de email
            if (!isValidEmail(emailValue)) {
                emailField.parentElement.classList.add('input-error');
                emailError.querySelector('span').textContent = 'Por favor ingresa un correo electrónico válido.';
                emailError.classList.remove('hidden');
                return { isValid: false, message: 'Por favor ingresa un correo electrónico válido.' };
            }
            
            // Si pasa todas las validaciones
            emailField.parentElement.classList.add('input-success');
            emailValidationIcon.classList.add('show');
            return { isValid: true, message: '' };
        }
        
        // Función para validar el campo de contraseña
        function validatePasswordField(passwordField) {
            const passwordValue = passwordField.value;
            const passwordError = document.getElementById('passwordError');
            const passwordValidationIcon = document.getElementById('passwordValidationIcon');
            
            // Limpiar estado previo
            passwordField.parentElement.classList.remove('input-error', 'input-success');
            passwordError.classList.add('hidden');
            passwordValidationIcon.classList.remove('show');
            
            // Validar campo vacío
            if (!passwordValue) {
                passwordField.parentElement.classList.add('input-error');
                passwordError.querySelector('span').textContent = 'La contraseña es requerida.';
                passwordError.classList.remove('hidden');
                return { isValid: false, message: 'La contraseña es requerida.' };
            }
            
            // Validar longitud mínima
            if (passwordValue.length < 6) {
                passwordField.parentElement.classList.add('input-error');
                passwordError.querySelector('span').textContent = 'La contraseña debe tener al menos 6 caracteres.';
                passwordError.classList.remove('hidden');
                return { isValid: false, message: 'La contraseña debe tener al menos 6 caracteres.' };
            }
            
            // Si pasa todas las validaciones
            passwordField.parentElement.classList.add('input-success');
            passwordValidationIcon.classList.add('show');
            return { isValid: true, message: '' };
        }
        
        function isValidEmail(email) {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(email);
        }
        
        // Efectos de focus en los inputs
        document.querySelectorAll('input').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('shadow-soft', 'border-secondary');
                this.parentElement.classList.remove('input-error', 'input-success');
                const validationIcon = this.parentElement.querySelector('.validation-icon');
                if (validationIcon) {
                    validationIcon.classList.remove('show');
                }
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.classList.remove('shadow-soft', 'border-secondary');
            });
        });
        
        // Efecto de partículas en el fondo (simplificado)
        document.addEventListener('mousemove', function(e) {
            const shapes = document.querySelectorAll('.floating-shape-1, .floating-shape-2, .floating-shape-3');
            shapes.forEach(shape => {
                const speed = shape.classList.contains('floating-shape-1') ? 0.02 : 
                             shape.classList.contains('floating-shape-2') ? 0.01 : 0.015;
                
                const x = (window.innerWidth - e.pageX) * speed;
                const y = (window.innerHeight - e.pageY) * speed;
                
                shape.style.transform = `translate(${x}px, ${y}px)`;
            });
        });
    </script>
</body>
</html>