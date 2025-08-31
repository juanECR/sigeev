<?php 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

session_start();
require_once('../model/admin-sesionModel.php');
require_once('../model/adminModel.php');
require  '../../vendor/autoload.php' ;

$tipo = $_GET['tipo'];

//instanciar la clase categoria model
$objSesion = new SessionModel();
$objAdmin = new AdminModel();

//variables de sesion
$id_sesion = $_REQUEST['sesion'];
$token = $_REQUEST['token'];

if($tipo == "enviarCorreo"){
    $arr_Respuesta = array('status' => false, 'mensaje' => 'Error_Sesion');
    if ($objSesion->verificar_sesion_si_activa($id_sesion, $token)) {
        if ($_POST) {
           $nombre = trim($_POST['nombre']);
           $correo = trim($_POST['email']);
           $asunto = $_POST['asunto'];
           $mensaje = $_POST['mensaje'];

           if($nombre == '' ||$correo == ''||$asunto == ''||$mensaje == ''){
               $arr_Respuesta = array('status' => false, 'mensaje' => 'Campos vacios');
           }else{
                        //php 
                        ob_start();
                        include __DIR__ . '../../view/TemplateEmail.php';
                        $emailBody = ob_get_clean();
                        $mail = new PHPMailer(true);

                        try {
                            //Server settings
                            $mail->SMTPDebug = 2;                      //Enable verbose debug output
                            $mail->isSMTP();                                            //Send using SMTP
                            $mail->Host       = 'mail.limon-cito.com';                     //Set the SMTP server to send through
                            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                            $mail->Username   = 'sisve_jota@limon-cito.com';                     //SMTP username
                            $mail->Password   = 'jota123@@JOTA';                               //SMTP password
                            $mail->SMTPSecure = 'ssl';            //Enable implicit TLS encryption
                            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                            //Recipients
                            $mail->setFrom('sisve_jota@limon-cito.com', 'Sigev Comunicado');
                            $mail->addAddress($correo, $nombre);     //Add a recipient
                            //Name is optional

                             $mail->CharSet = 'UTF-8';

                            //Content
                            $mail->isHTML(true);                                  //Set email format to HTML
                            $mail->Subject = $asunto;

                            $mail->Body    = $emailBody;
                            $mail->AltBody = 'Error, Se intento notificar, solicita informacion al respecto';

                            $mail->send();
                            echo 'Correo enviado con éxito.';
                             $arr_Respuesta = array('status' => true, 'mensaje' => 'ENVIADO CON EXITO');
                        } catch (Exception $e) {
                            echo "Error al enviar: {$mail->ErrorInfo}";
                             $arr_Respuesta = array('status' => false, 'mensaje' => 'Erro interno al enviar correo');
                        }
           }
        }
    }
    echo json_encode($arr_Respuesta);
}

?>