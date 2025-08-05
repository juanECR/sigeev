<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso al Sistema | SIGEM</title>
    <link rel="stylesheet" href="css/login.css">
    <!-- Google Fonts: Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome para el icono del ojo -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
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
            <form class="login-form">
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

    <script src="js/script_login.js"></script>
</body>
</html>