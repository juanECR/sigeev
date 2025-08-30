<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --color-primary: #121212; /* Negro profundo */
            --color-secondary: #E50914; /* Rojo vibrante */
            --color-text-light: #F5F5F1; /* Blanco hueso */
            --color-text-dark: #222222; /* Gris muy oscuro para el contenedor */
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

        .forgot-container {
            width: 100%;
            max-width: 480px;
            background-color: var(--color-text-dark);
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 35px rgba(0, 0, 0, 0.6);
            text-align: center;
            border-top: 5px solid var(--color-secondary);
            animation: slideIn 0.6s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .icon-mail {
            width: 60px;
            height: 60px;
            stroke: var(--color-secondary);
            margin-bottom: 20px;
        }

        h2 {
            color: var(--color-text-light);
            margin-bottom: 15px;
            font-size: 2em;
            font-weight: 700;
        }

        p {
            color: rgba(245, 245, 241, 0.7);
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .form-group {
            margin-bottom: 25px;
            text-align: left;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-size: 0.9em;
            color: var(--color-text-light);
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        input[type="email"] {
            width: 100%;
            padding: 15px;
            background-color: #333;
            border: 2px solid transparent;
            border-radius: 8px;
            color: var(--color-text-light);
            font-size: 1em;
            outline: none;
            transition: border-color 0.3s ease, background-color 0.3s ease;
        }

        input[type="email"]:focus {
            border-color: var(--color-secondary);
            background-color: #444;
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
        }

        button[type="submit"]:hover:not(:disabled) {
            background-color: var(--color-accent);
            transform: translateY(-2px);
        }
        
        button[type="submit"]:disabled {
            background-color: #555;
            cursor: not-allowed;
        }

        .message {
            margin-top: 20px;
            font-size: 0.95em;
            min-height: 22px;
            font-weight: bold;
        }
        
        .back-to-login {
            display: inline-block;
            margin-top: 25px;
            color: rgba(245, 245, 241, 0.6);
            text-decoration: none;
            font-size: 0.9em;
            transition: color 0.3s ease;
        }

        .back-to-login:hover {
            color: var(--color-text-light);
            text-decoration: underline;
        }
        
        /* Responsividad */
        @media (max-width: 500px) {
            .forgot-container {
                padding: 30px 25px;
            }
            h2 {
                font-size: 1.8em;
            }
        }
    </style>
    <script>
    const base_url = '<?php echo BASE_URL; ?>';
    const base_url_server = '<?php echo BASE_URL_SERVER; ?>';
  </script>
</head>
<body>
    <div class="forgot-container">
        <svg class="icon-mail" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
        </svg>

        <h2>¿Olvidaste tu contraseña?</h2>
        <p>No te preocupes. Ingresa tu correo electrónico y te enviaremos un enlace para que puedas crear una nueva.</p>

        <form id="forgotForm">
            <div class="form-group">
                <label for="email">Correo Electrónico</label>
                <input type="email" id="email" name="email" placeholder="tu.correo@ejemplo.com" required>
            </div>
            <button type="submit">Enviar Enlace de Recuperación</button>
            <div id="message" class="message"></div>
        </form>
        
        <a href="<?php echo BASE_URL;?>" class="back-to-login">Volver a Iniciar Sesión</a>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('forgotForm');
            const emailInput = document.getElementById('email');
            const messageDiv = document.getElementById('message');
            const submitButton = form.querySelector('button[type="submit"]');

            form.addEventListener('submit', (e) => {
                e.preventDefault();

                const email = emailInput.value;
                messageDiv.textContent = '';

                // Validación simple de formato de correo
                const emailRegex = /\S+@\S+\.\S+/;
                if (!email) {
                    messageDiv.style.color = 'var(--color-secondary)';
                    messageDiv.textContent = 'Por favor, ingresa tu correo electrónico.';
                    return;
                } else if (!emailRegex.test(email)) {
                    messageDiv.style.color = 'var(--color-secondary)';
                    messageDiv.textContent = 'El formato del correo no es válido.';
                    return;
                }
                
                // Simulación de envío exitoso
                messageDiv.style.color = '#28a745'; // Color verde para éxito
                messageDiv.textContent = 'Si el correo está registrado, recibirás un enlace.';
                restaurarPassword();
                // Deshabilitar el botón para evitar múltiples envíos
                submitButton.disabled = true;
                emailInput.disabled = true;
                

            });
        });
    </script>
    <script src="<?php echo BASE_URL;?>src/view/js/excludesistem.js"></script>
</body>
</html>