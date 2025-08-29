<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Restablecer tu Contraseña</title>
    <style>
        /* Estilos generales y para clientes que soportan <style> */
        body {
            margin: 0;
            padding: 0;
            width: 100% !important;
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }
        
        /* Media Query para responsividad */
        @media only screen and (max-width: 600px) {
            .container {
                width: 100% !important;
            }
            .content {
                padding: 20px !important;
            }
            .header, .footer {
                padding: 20px 15px !important;
            }
        }
    </style>
</head>
<body style="margin: 0; padding: 0; background-color: #121212; font-family: 'Montserrat', Arial, sans-serif;">

    <!--[if mso | IE]>
    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="600" align="center" style="width:600px;">
        <tr>
            <td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;">
    <![endif]-->

    <div style="max-width:600px; margin: 0 auto; background-color: #222222; border-radius: 8px;">
        <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%; border-radius: 8px;">
            <tbody>
                <tr>
                    <td style="direction:ltr; font-size:0px; padding:0; text-align:center;">
                        
                        <!-- SECCIÓN DEL LOGO -->
                        <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td class="header" style="padding: 30px 40px; text-align: center; border-bottom: 1px solid #444;">
                                    <!-- REEMPLAZA 'URL_DE_TU_LOGO' CON EL ENLACE A TU LOGO -->
                                    <img src="https://via.placeholder.com/150x40/FFFFFF/E50914?Text=TuLogo" alt="Logo de la Empresa" style="width: 150px; height: auto; display: block; margin: 0 auto;">
                                </td>
                            </tr>
                        </table>

                        <!-- CUERPO DEL MENSAJE -->
                        <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td class="content" style="padding: 40px;">
                                    <h1 style="margin: 0 0 20px 0; font-size: 24px; font-weight: 700; color: #F5F5F1; text-align: center;">
                                        Restablece tu Contraseña
                                    </h1>
                                    <p style="margin: 0 0 30px 0; font-size: 16px; line-height: 1.6; color: #A0A0A0; text-align: center;">
                                        Hemos recibido una solicitud para restablecer la contraseña de tu cuenta. Haz clic en el botón de abajo para continuar.
                                    </p>

                                    <!-- BOTÓN DE ACCIÓN (CTA) -->
                                    <table role="presentation" border="0" cellpadding="0" cellspacing="0" align="center" style="margin: 0 auto;">
                                        <tr>
                                            <td align="center" bgcolor="#E50914" style="border-radius: 5px;">
                                                <a href="<?php echo BASE_URL;?>UpdatePassword" target="_blank" style="font-size: 16px; font-weight: bold; color: #FFFFFF; text-decoration: none; text-transform: uppercase; padding: 15px 30px; border-radius: 5px; display: inline-block;">
                                                    Crear Nueva Contraseña
                                                </a>
                                            </td>
                                        </tr>
                                    </table>

                                    <p style="margin: 30px 0 0 0; font-size: 14px; line-height: 1.5; color: #A0A0A0; text-align: center;">
                                        Este enlace de restablecimiento de contraseña expirará en 60 minutos.
                                    </p>
                                    <p style="margin: 15px 0 0 0; font-size: 14px; line-height: 1.5; color: #A0A0A0; text-align: center;">
                                        Si no solicitaste un restablecimiento de contraseña, puedes ignorar este correo de forma segura.
                                    </p>
                                </td>
                            </tr>
                        </table>

                        <!-- FOOTER -->
                        <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td class="footer" style="padding: 30px 40px; text-align: center; border-top: 1px solid #444;">
                                    <p style="margin: 0; font-size: 12px; color: #777777;">
                                        © 2025 Tu Empresa. Todos los derechos reservados.<br>
                                        123 Calle Falsa, Ciudad, País
                                    </p>
                                </td>
                            </tr>
                        </table>

                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!--[if mso | IE]>
            </td>
        </tr>
    </table>
    <![endif]-->

</body>
</html>