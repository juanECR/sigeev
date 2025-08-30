<?php
$data  = $_GET['data']  ?? '';
$data2 = $_GET['data2'] ?? '';

// Validar y sanitizar
$data  = htmlspecialchars($data);
$data2 = htmlspecialchars(urldecode($data2));

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer Contraseña</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --color-primary: #121212; /* Negro más profundo */
            --color-secondary: #E50914; /* Rojo Netflix-like */
            --color-text-light: #F5F5F1; /* Blanco hueso */
            --color-text-dark: #333333; /* Gris oscuro para el formulario */
            --color-accent: #B81D24; /* Rojo más oscuro para acentos */
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background-color: var(--color-primary);
            color: var(--color-text-light);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .split-container {
            display: flex;
            width: 100%;
            max-width: 1000px;
            min-height: 600px;
            background-color: var(--color-text-dark);
            border-radius: 15px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.7);
            overflow: hidden;
        }

        .visual-side {
            flex-basis: 50%;
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('https://images.unsplash.com/photo-1585079542156-2755d9c8a094?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1974&q=80');
            background-size: cover;
            background-position: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 40px;
            text-align: center;
            position: relative;
        }

        .visual-side::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            border: 4px solid var(--color-secondary);
            opacity: 0;
            animation: fadeInBorder 2s ease-out forwards;
            animation-delay: 0.5s;
            clip-path: polygon(0% 0%, 0% 100%, 4% 100%, 4% 4%, 96% 4%, 96% 96%, 4% 96%, 4% 100%, 100% 100%, 100% 0%);
        }

        @keyframes fadeInBorder {
            to {
                opacity: 0.8;
            }
        }

        .visual-side h1 {
            font-size: 3em;
            font-weight: 700;
            color: var(--color-text-light);
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 20px;
            text-shadow: 0 0 15px rgba(0,0,0,0.8);
        }

        .visual-side p {
            font-size: 1.1em;
            line-height: 1.6;
            max-width: 80%;
            text-shadow: 0 0 10px rgba(0,0,0,0.8);
        }

        .form-side {
            flex-basis: 50%;
            padding: 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .form-side h2 {
            color: var(--color-secondary);
            margin-bottom: 15px;
            font-size: 2em;
            font-weight: 700;
            text-align: center;
        }

        .form-side .intro-text {
            text-align: center;
            margin-bottom: 30px;
            color: var(--color-text-light);
            opacity: 0.8;
        }

        .form-group {
            margin-bottom: 25px;
            position: relative;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-size: 0.85em;
            color: var(--color-text-light);
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            opacity: 0.9;
        }

        input[type="password"] {
            width: 100%;
            padding: 14px;
            background-color: #444;
            border: 2px solid transparent;
            border-radius: 8px;
            color: var(--color-text-light);
            font-size: 1em;
            outline: none;
            transition: border-color 0.3s ease, background-color 0.3s ease;
        }

        input[type="password"]:focus {
            border-color: var(--color-secondary);
            background-color: #555;
        }

        button[type="submit"] {
            width: 100%;
            padding: 15px;
            background-color: var(--color-secondary);
            color: var(--color-text-light);
            border: none;
            border-radius: 8px;
            font-size: 1.1em;
            font-weight: 700;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 5px 20px rgba(229, 9, 20, 0.3);
        }

        button[type="submit"]:hover {
            background-color: var(--color-accent);
            transform: translateY(-3px);
        }

        .message {
            margin-top: 20px;
            font-size: 0.9em;
            color: var(--color-secondary);
            min-height: 20px;
            text-align: center;
            font-weight: bold;
        }

        /* Responsividad */
        @media (max-width: 850px) {
            .split-container {
                flex-direction: column;
                min-height: auto;
                max-width: 500px; /* Ancho máximo en móviles */
            }

            .visual-side {
                flex-basis: auto;
                min-height: 250px; /* Altura mínima para la parte visual */
            }

            .form-side {
                flex-basis: auto;
                padding: 40px 30px;
            }

            .visual-side h1 {
                font-size: 2.5em;
            }

            .visual-side p {
                font-size: 1em;
            }
        }

    </style>
    <script>
        base_url = '<?php echo BASE_URL;?>';
        base_url_server = '<?php echo BASE_URL_SERVER;?>';
    </script>
</head>
<body>
    <div class="split-container">
        <div class="visual-side">
            <h1>Seguridad Primero</h1>
            <p>Una contraseña robusta es el primer paso para proteger tu universo digital. Creemos una nueva juntos.</p>
        </div>

        <div class="form-side">
            <h2 class="titulo">Restablecer Contraseña</h2>
            <p class="intro-text">Ingresa y confirma tu nueva contraseña.</p>

            <form id="resetForm">
                <input type="hidden" id="data" name="data" value="<?php echo $data?>" >
                <input type="hidden" id="data2" name="data2" value="<?php echo $data2?>" >
                <div class="form-group">
                    <label for="newPassword">Nueva Contraseña</label>
                    <input type="password" id="newPassword" placeholder="Mínimo 8 caracteres" required>
                </div>

                <div class="form-group">
                    <label for="confirmPassword">Confirmar Contraseña</label>
                    <input type="password" id="confirmPassword" placeholder="Repite tu contraseña" required>
                </div>

                <button type="submit" id="btnLog">Actualizar Contraseña</button>
                
            </form>
            <div id="message" class="message"></div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            
            const form = document.getElementById('resetForm');
            const newPasswordInput = document.getElementById('newPassword');
            const confirmPasswordInput = document.getElementById('confirmPassword');
            const messageDiv = document.getElementById('message');

            form.addEventListener('submit', (e) => {
                e.preventDefault();

                const newPassword = newPasswordInput.value;
                const confirmPassword = confirmPasswordInput.value;

                messageDiv.textContent = '';
                messageDiv.style.color = 'var(--color-secondary)';

                if (!newPassword || !confirmPassword) {
                    messageDiv.textContent = 'Ambos campos son obligatorios.';
                    return;
                }

                if (newPassword.length < 8) {
                    messageDiv.textContent = 'La contraseña debe tener al menos 8 caracteres.';
                    return;
                }

                if (newPassword !== confirmPassword) {
                    messageDiv.textContent = 'Las contraseñas no coinciden.';
                    return;
                }

                // Simulación de éxito
                messageDiv.style.color = '#28a745'; // Un verde para el éxito
                messageDiv.textContent = '¡Contraseña actualizada con éxito!';

                // Aquí iría la lógica para enviar al servidor.
                actualizar_password(newPassword);
            });
        });
    </script>
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="<?php echo BASE_URL;?>src/view/js/main.js"></script>
</body>
</html>