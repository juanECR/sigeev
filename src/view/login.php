<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso al Sistema | SIGEEV</title>
    <!-- Google Fonts: Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome para el icono del ojo -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
    const base_url = '<?php echo BASE_URL; ?>';
    const base_url_server = '<?php echo BASE_URL_SERVER; ?>';
  </script>
</head>
<body>

    <div class="login-container">
        <!-- Columna de Branding -->
        <div class="login-branding">
            <!-- <img src="path/to/your/logo.svg" alt="Logo Municipal" class="logo"> -->
            <h1>SIGEEV</h1>
            <p>Sistema Integral de Gestión de Eventos</p>
        </div>

        <!-- Columna del Formulario -->
        <div class="login-form-wrapper">
            <form id="frm_login" class="login-form"  >
                <h2>Acceso al Sistema</h2>
                <p class="form-description">Introduce tus credenciales para continuar.</p>

                <div class="input-group">
                    <input type="text" id="username" name="username" required>
                    <label for="username">Usuario o Correo Electrónico</label>
                </div>

                <div class="input-group password-group">
                    <input type="password" id="password" name="password" required>
                    <label for="password">Contraseña</label>
                    <i class="fa-solid fa-eye" id="togglePassword"></i>
                </div>

                <div class="form-options">
                    <div class="remember-me">
                        <input type="checkbox" id="remember" name="remember">
                        <label for="remember">Recordarme</label>
                    </div>
                    <a href="#" class="forgot-password">¿Olvidaste tu contraseña?</a>
                </div>

                <button type="submit" class="btn-login">Iniciar Sesión</button>

            </form>
        </div>
    </div>
    
    <script>
       document.addEventListener('DOMContentLoaded', function() {

        // --- Lógica para las Etiquetas Flotantes ---
        const inputs = document.querySelectorAll('.input-group input');

        inputs.forEach(input => {
            // Si el input ya tiene valor al cargar la página (p.ej. autocompletado),
            // mantenemos la etiqueta arriba.
            if (input.value.trim() !== '') {
                input.classList.add('has-content');
                input.nextElementSibling.style.top = '-15px';
                input.nextElementSibling.style.fontSize = '0.8rem';
                input.nextElementSibling.style.color = 'var(--primary-color)';
            }

            input.addEventListener('focus', function() {
                this.nextElementSibling.style.top = '-15px';
                this.nextElementSibling.style.fontSize = '0.8rem';
                this.nextElementSibling.style.color = 'var(--primary-color)';
            });

            input.addEventListener('blur', function() {
                // Solo devolvemos la etiqueta a su posición si el campo está vacío
                if (this.value.trim() === '') {
                    this.nextElementSibling.style.top = '10px';
                    this.nextElementSibling.style.fontSize = '1rem';
                    this.nextElementSibling.style.color = '#999';
                }
            });
        });

        // --- Lógica para el botón de ver/ocultar contraseña ---
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');

        togglePassword.addEventListener('click', function() {
            // Cambiar el tipo del input
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            // Cambiar el icono del ojo
            this.classList.toggle('fa-eye-slash');
        });

        });
    </script>
    <style>
                /* --- Variables y Estilos Globales --- */
        :root {
            --primary-color: red; /* Un azul corporativo */
            --primary-color-dark: #004494;
            --secondary-color: #f4f4f9;
            --text-color: #333;
            --light-gray: #ccc;
            --border-radius: 8px;
            --box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--secondary-color);
            color: var(--text-color);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        /* --- Contenedor Principal --- */
        .login-container {
            display: flex;
            width: 900px;
            max-width: 90%;
            min-height: 550px;
            background-color: #fff;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            overflow: hidden;
            animation: fadeIn 0.8s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }

        /* --- Columna de Branding (Izquierda) --- */
        .login-branding {
            flex: 1;
            background: linear-gradient(rgba(179, 7, 7, 0.7), rgba(92, 20, 3, 0.8)), url('https://images.unsplash.com/photo-1533174072545-7a4b6ad7a6c3?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80') no-repeat center center/cover;
            color: #fff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 40px;
        }

        .login-branding h1 {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 10px;
            letter-spacing: 2px;
        }

        .login-branding p {
            font-size: 1.1rem;
            font-weight: 300;
        }

        /* --- Columna de Formulario (Derecha) --- */
        .login-form-wrapper {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px;
        }

        .login-form {
            width: 100%;
            max-width: 350px;
        }

        .login-form h2 {
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 10px;
            color: var(--primary-color);
        }

        .form-description {
            margin-bottom: 30px;
            color: #777;
        }

        /* --- Grupos de Inputs con Etiquetas Flotantes --- */
        .input-group {
            position: relative;
            margin-bottom: 30px;
        }

        .input-group input {
            width: 100%;
            padding: 10px 0;
            border: none;
            border-bottom: 2px solid var(--light-gray);
            outline: none;
            background-color: transparent;
            font-size: 1rem;
            color: var(--text-color);
        }

        .input-group label {
            position: absolute;
            top: 10px;
            left: 0;
            color: #999;
            pointer-events: none;
            transition: all 0.3s ease;
        }

        /* La magia del label flotante */
        .input-group input:focus + label,
        .input-group input:valid + label {
            top: -15px;
            font-size: 0.8rem;
            color: var(--primary-color);
        }

        .input-group input:focus {
            border-bottom-color: var(--primary-color);
        }

        /* Icono de contraseña */
        .password-group {
            position: relative;
        }

        .password-group .fa-eye {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #999;
            transition: color 0.3s ease;
        }

        .password-group .fa-eye:hover {
            color: var(--primary-color);
        }


        /* --- Opciones y Botón --- */
        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            font-size: 0.9rem;
        }

        .remember-me {
            display: flex;
            align-items: center;
        }

        .remember-me input {
            margin-right: 5px;
        }

        .forgot-password {
            color: var(--primary-color);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .forgot-password:hover {
            color: var(--primary-color-dark);
            text-decoration: underline;
        }

        .btn-login {
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: var(--border-radius);
            background-color: var(--primary-color);
            color: #fff;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            background-color: var(--primary-color-dark);
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 86, 179, 0.3);
        }

        /* --- Diseño Responsivo --- */
        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
                width: 100%;
                max-width: 100%;
                height: 100vh;
                border-radius: 0;
                box-shadow: none;
            }

            .login-branding {
                flex: 0.5;
                min-height: 200px;
                justify-content: flex-end;
                padding-bottom: 30px;
            }
            
            .login-branding h1 {
                font-size: 2.5rem;
            }

            .login-form-wrapper {
                flex: 1;
                width: 90%;
                margin: 0 auto;
                padding: 20px 0;
            }
        }
    </style>
</body>
<script src="<?php echo BASE_URL; ?>src/view/js/sesion.js"></script>

</html>