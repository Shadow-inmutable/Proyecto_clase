<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Inventario</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <style>
        :root {
            --primary-color: #0b8793;
            --secondary-color: #360033;
            --accent-color: #00bcd4;
            --success-color: #28a745;
            --glass-bg: rgba(255, 255, 255, 0.08);
            --glass-border: rgba(255, 255, 255, 0.15);
            --glass-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
        }
        
        body {
            background: linear-gradient(-45deg, #141e30, #243b55, #0f3460, #1a1a2e);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
            color: #e9ecef;
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
        }
        
        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        /* Efecto de partículas en el fondo */
        .particles {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
        }
        
        .particle {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: float 15s infinite linear;
        }
        
        @keyframes float {
            0% { transform: translateY(0) rotate(0deg); opacity: 0; }
            10% { opacity: 1; }
            90% { opacity: 1; }
            100% { transform: translateY(-100vh) rotate(360deg); opacity: 0; }
        }
        
        .card {
            margin-top: 60px;
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid var(--glass-border);
            box-shadow: var(--glass-shadow);
            border-radius: 16px;
            overflow: hidden;
        }
        
        .card-header {
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
            border-bottom: none;
            padding: 1.5rem;
            position: relative;
            overflow: hidden;
        }
        
        .card-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
            transform: translateX(-100%);
            animation: shine 3s infinite;
        }
        
        @keyframes shine {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }
        
        .card-header h4 {
            margin: 0;
            font-weight: bold;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        
        .form-control {
            background-color: rgba(44, 62, 80, 0.7);
            border: 1px solid rgba(52, 73, 94, 0.5);
            color: #e9ecef;
            transition: all 0.3s ease;
            border-radius: 8px;
            padding: 12px 15px;
        }
        
        .form-control:focus {
            background-color: rgba(44, 62, 80, 0.9);
            border-color: var(--accent-color);
            color: #fff;
            box-shadow: 0 0 0 0.2rem rgba(0, 188, 212, 0.25);
        }
        
        label {
            color: #cfd8dc;
            font-weight: 500;
            margin-bottom: 8px;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
            border-radius: 8px;
            padding: 10px 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px 0 rgba(11, 135, 147, 0.4);
            position: relative;
            overflow: hidden;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px 0 rgba(11, 135, 147, 0.6);
            background: linear-gradient(135deg, var(--secondary-color), var(--primary-color));
        }
        
        .btn-secondary {
            background: linear-gradient(135deg, #6c757d, #5a6268);
            border: none;
            border-radius: 8px;
            padding: 10px 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px 0 rgba(108, 117, 125, 0.4);
        }
        
        .btn-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px 0 rgba(108, 117, 125, 0.6);
            background: linear-gradient(135deg, #5a6268, #6c757d);
        }
        
        .vector-container {
            text-align: center;
            margin-top: 50px;
        }
        
        .vector-container svg {
            width: 60%;
            max-width: 600px;
            height: auto;
            filter: drop-shadow(0 5px 15px rgba(0, 0, 0, 0.3));
        }
        
        .text-muted {
            color: #adb5bd !important;
        }
        
        /* Animación para el formulario */
        .animate-form {
            animation: fadeInUp 0.8s ease-out;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Mejoras responsivas */
        @media (max-width: 768px) {
            .card {
                margin-top: 30px;
            }
            
            .vector-container svg {
                width: 90%;
            }
        }
    </style>
</head>
<body>
    <!-- Fondo con partículas animadas -->
    <div class="particles" id="particles"></div>
    
    @if ($errors->any())
    <div class="alert alert-danger animate__animated animate__shakeX">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    
    <div class="container">
        <!-- Formulario de Login -->
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card animate-form">
                    <div class="card-header text-center text-white">
                        <h4><i class="fas fa-lock"></i> Login - Gestión de Inventario</h4>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('login') }}" method="POST">
                            @csrf
                            <!-- Correo -->
                            <div class="form-group">
                                <label for="email">Correo Electrónico</label>
                                <input type="email" id="email" name="email" class="form-control" required placeholder="Ejemplo: admin@inventario.com">
                            </div>
                            <!-- Contraseña -->
                            <div class="form-group">
                                <label for="password">Contraseña</label>
                                <input type="password" id="password" name="password" class="form-control" required placeholder="Ingrese su contraseña">
                            </div>
                            <!-- Botones -->
                            <div class="form-group text-center mt-4">
                                <button type="submit" class="btn btn-primary px-4 mr-3">Ingresar</button>
                                <a href="#" class="btn btn-secondary px-4">Cancelar</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Vector alusivo al inventario -->
        <div class="vector-container">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 901.5 700">
                <rect width="901.5" height="700" fill="transparent"/>
                <rect x="180" y="300" width="120" height="300" fill="#00bcd4" opacity="0.9"/>
                <rect x="340" y="220" width="120" height="380" fill="#4caf50" opacity="0.9"/>
                <rect x="500" y="260" width="120" height="340" fill="#ffc107" opacity="0.9"/>
                <rect x="660" y="180" width="120" height="420" fill="#e91e63" opacity="0.9"/>
                <path d="M160 290l690-150v-30L160 260z" fill="#ffffff" opacity="0.1"/>
                <circle cx="200" cy="630" r="15" fill="#adb5bd"/>
                <circle cx="700" cy="630" r="15" fill="#adb5bd"/>
                <text x="250" y="660" font-size="22" fill="#ffffff" font-family="Arial, sans-serif"> Sistema de Gestión de Inventario </text>
            </svg>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    
    <script>
        // Crear partículas animadas para el fondo
        document.addEventListener('DOMContentLoaded', function() {
            const particlesContainer = document.getElementById('particles');
            const particleCount = 30;
            
            for (let i = 0; i < particleCount; i++) {
                const particle = document.createElement('div');
                particle.classList.add('particle');
                
                // Tamaño aleatorio
                const size = Math.random() * 20 + 5;
                particle.style.width = `${size}px`;
                particle.style.height = `${size}px`;
                
                // Posición inicial aleatoria
                particle.style.left = `${Math.random() * 100}%`;
                particle.style.top = `${Math.random() * 100}%`;
                
                // Animación con duración aleatoria
                const duration = Math.random() * 20 + 10;
                particle.style.animationDuration = `${duration}s`;
                
                // Retraso aleatorio para que no todas empiecen a la vez
                particle.style.animationDelay = `${Math.random() * 5}s`;
                
                particlesContainer.appendChild(particle);
            }
        });
    </script>
</body>
</html>