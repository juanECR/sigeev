<?php
date_default_timezone_set('America/Lima');
$meses = array(
    1 => 'enero', 2 => 'febrero', 3 => 'marzo', 4 => 'abril', 5 => 'mayo', 6 => 'junio',
    7 => 'julio', 8 => 'agosto', 9 => 'septiembre', 10 => 'octubre', 11 => 'noviembre', 12 => 'diciembre'
);
$dia = date('d');
$mes_numero = date('n'); 
$anio = date('Y');
$fecha_formateada = $dia . ' de ' . $meses[$mes_numero] . ' del ' . $anio;
$hora_actual = new DateTime();
$hora_formateada = $hora_actual->format('H:i:s');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comunicado Oficial</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Open+Sans&display=swap');
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Open Sans', sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f8f9fa;
        }
        
        .container {
            max-width: 900px;
            margin: 40px auto;
            padding: 20px;
            background: white;
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        
        .header {
            text-align: center;
            padding: 30px 0;
            border-bottom: 3px solid #0056b3;
            margin-bottom: 30px;
            position: relative;
        }
        
        .logo-container {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px;
            margin-bottom: 15px;
        }
        
        .logo {
            width: 80px;
            height: 80px;
            background: #0056b3;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 24px;
        }
        
        .gov-name {
            color: #0056b3;
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            font-size: 24px;
            line-height: 1.2;
        }
        
        .gov-subtitle {
            color: #666;
            font-size: 16px;
            margin-top: 5px;
        }
        
        .document-type {
            background: #0056b3;
            color: white;
            padding: 8px 15px;
            border-radius: 4px;
            font-weight: 600;
            font-size: 14px;
            display: inline-block;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .title {
            font-family: 'Montserrat', sans-serif;
            font-size: 28px;
            font-weight: 600;
            color: #0056b3;
            margin: 20px 0;
            line-height: 1.3;
        }
        
        .metadata {
            background: #f0f4f8;
            padding: 15px;
            border-radius: 6px;
            margin: 25px 0;
            border-left: 4px solid #0056b3;
        }
        
        .metadata-item {
            display: flex;
            margin-bottom: 8px;
        }
        
        .metadata-label {
            font-weight: 600;
            color: #0056b3;
            width: 120px;
            min-width: 120px;
        }
        
        .content {
            margin: 30px 0;
            text-align: justify;
        }
        
        .paragraph {
            margin-bottom: 20px;
            text-align: justify;
        }
        
        
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            color: #666;
            font-size: 14px;
        }
        
        .signature {
            margin: 30px 0;
        }
        
        .signature-name {
            font-weight: 600;
            color: #0056b3;
            margin-top: 5px;
        }
        
        .signature-title {
            font-style: italic;
            color: #666;
            margin: 5px 0;
        }
        
        .contact-info {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 6px;
            margin: 30px 0;
            border: 1px solid #e9ecef;
        }
        
        .contact-title {
            font-weight: 600;
            color: #0056b3;
            margin-bottom: 15px;
            font-size: 18px;
        }
        
        .contact-item {
            display: flex;
            margin-bottom: 8px;
            align-items: center;
        }
        
        .contact-icon {
            width: 20px;
            height: 20px;
            background: #0056b3;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
            font-size: 12px;
        }
        
        .reference {
            font-size: 12px;
            color: #999;
            margin-top: 40px;
            text-align: center;
            font-style: italic;
        }
        
        @media (max-width: 768px) {
            .container {
                margin: 20px;
                padding: 15px;
            }
            
            .title {
                font-size: 24px;
            }
            
            .logo-container {
                flex-direction: column;
            }
            
            .metadata-label {
                width: 100px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo-container">
                <div class="logo">G</div>
                <div>
                    <div class="gov-name">MUNICIPALIDAD PROVINCIAL DE HUANTA</div>
                    <div class="gov-subtitle">Sub Gerencia de Servicios Sociales</div>
                </div>
            </div>
            <div class="document-type">Comunicado Oficial</div>
        </div>
        
        <h1 class="title"><?php echo $asunto?></h1>
        
        <div class="metadata">
            <div class="metadata-item">
                <span class="metadata-label">Fecha:</span>
                <span><?php echo $fecha_formateada;?></span>
            </div>
            <div class="metadata-item">
                <span class="metadata-label">Hora:</span>
                <span><?php echo $hora_formateada;?></span>
            </div>
            <div class="metadata-item">
                <span class="metadata-label">Tema:</span>
                <span><?php echo $asunto;?></span>
            </div>
        </div>
        
        <div class="content">
            <p class="paragraph"><?php echo $mensaje;?></p>
        </div>
        
        <div class="contact-info">
            <div class="contact-title">Información Adicional</div>
            <div class="contact-item">
                <div class="contact-icon">i</div>
                <div><strong>Sub Gerencia de Servicios Sociales</strong></div>
            </div>
            <div class="contact-item">
                <div class="contact-icon">@</div>
                <div>munihuanta@gmail.gob.pe</div>
            </div>
            <div class="contact-item">
                <div class="contact-icon">📞</div>
                <div>(066) 052101</div>
            </div>
            <div class="contact-item">
                <div class="contact-icon">🌐</div>
                <div>www.munihuanta.gop.pe</div>
            </div>
        </div>
        
        <div class="signature">
            <div class="signature-name">Ing. María Fernanda Gómez López</div>
            <div class="signature-title">Sub Gerencia de Servicios Sociales</div>
            <div class="signature-title">Municipalida Provicnial de Huanta</div>
        </div>
        
        <div class="footer">
            <p>Este comunicado se emite en cumplimiento con lo establecido en la Ley de Transparencia y Acceso a la Información Pública del Estado de Peruano.</p>
        </div>
        
        <div class="reference">
             Emitido el <?php echo $fecha_formateada?> | <?php echo $hora_formateada?> horas
        </div>
    </div>
</body>
</html>
```