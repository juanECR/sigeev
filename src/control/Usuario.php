<?php 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

session_start();
require_once('../model/admin-sesionModel.php');
require_once('../model/admin-usuarioModel.php');
require_once('../model/admin-personaModel.php');
require_once('../model/admin-rolesUsuario.php');
require_once('../model/adminModel.php');
require  '../../vendor/autoload.php' ;

$tipo = $_GET['tipo'];

//instanciar la clase categoria model
$objSesion = new SessionModel();
$objUsuario = new UsuarioModel();
$objPersona = new PersonaModel();
$objRolesUsu = new RolesUsuario();
$objAdmin = new AdminModel();

//variables de sesion
$id_sesion = $_REQUEST['sesion'];
$token = $_REQUEST['token'];

/* if ($tipo == 'listarUsuarios') {
    $arr_Respuesta = array('status' => false, 'mensaje' => 'fallo consulta');
    $arrUsuarios = $objUsuario->listarUsuarios();
    if (!empty($arrUsuarios)) {
        $arr_Respuesta['contenido'] = $arrUsuarios;
        $arr_Respuesta['status'] = true;
        $arr_Respuesta['mensaje'] = 'listado correctamente';
    }
    echo json_encode($arr_Respuesta);
} */
if ($tipo == "registrar") {
    $arr_Respuesta = array('status' => false, 'msg' => 'Error_Sesion');
    if ($objSesion->verificar_sesion_si_activa($id_sesion, $token)) {

        if ($_POST) {
            $dni = $_POST['dni'];
            $nombres = $_POST['nombres'];
            $apellidos = $_POST['apellidos'];
            $correo = $_POST['correo'];
            $telefono = $_POST['telefono'];
            $fecha_nacimiento = $_POST['fecha_nacimiento'];
            $genero = $_POST['genero'];
            $password = $_POST['password'];
            $id_rol = $_POST['rol'];
            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            if ( $dni == "" || $nombres == "" || $apellidos == "" || $correo == "" || $telefono == "" ||$fecha_nacimiento ==""|| $password == ""|| $id_rol == "") {
                $arr_Respuesta = array('status' => false, 'mensaje' => 'Error, campos vacíos');
            } else {
                $arrPersona = $objPersona->buscarPersonaByCorreo($correo);
                $arrPersonaDni = $objPersona->buscarPersonaByDni($dni);
                if($arrPersona || $arrPersonaDni){
                   $arr_Respuesta = array('status' => false, 'mensaje' => 'Error, Persona ya existe');
                }else{
                      $id_new_persona = $objPersona->registrarPersona($dni, $nombres,$apellidos, $correo, $telefono,$fecha_nacimiento,$genero);
                     if ($id_new_persona > 0) {
                          $id_new_usuario = $objUsuario->registrarUsuario($id_new_persona,$password_hash);
                            if($id_new_usuario > 0){
                               $id_rol_sistema = $objRolesUsu->registrarRolUsuario($id_new_usuario,$id_rol);
                                if($id_rol_sistema = 1){
                                    $arr_Respuesta = array('status' => true, 'mensaje' => 'Registro exitoso');
                                }else{
                                    $arr_Respuesta = array('status' => false, 'mensaje' => 'Error al registrar rol del usuario');
                                }
                            }else{
                                //eliminar la persona por que no se registro usuario
                                $elimarPersona = $objPersona->eliminarPersonaById($id_new_persona);
                                if($elimarPersona){
                                   $arr_Respuesta = array('status' => false, 'mensaje' => 'Error al registrar usuario, persona eliminada');  
                                }
                                 $arr_Respuesta = array('status' => false, 'mensaje' => 'Error al registrar usuario');  
                            }
                        } else {
                            $arr_Respuesta = array('status' => false, 'mensaje' => 'Error al registrar persona');
                        }
                }
                //primero registrar persona->devielve id - despues registrar usuario->devuelve id - despues registrar usuario_roles(id rol, id usuario).
                //validar dni y correo no existan
            }
        }
    }
    echo json_encode($arr_Respuesta);
}

if($tipo == "listarUsuariosPaginado"){
    $arr_Respuesta = array('status' => false, 'contenido' => '', 'mensaje' => 'Error de sesión');
    if ($objSesion->verificar_sesion_si_activa($id_sesion, $token)) {
        // --- INICIO DE CAMBIOS PARA PAGINACIÓN ---

        // 1. Definir configuración y obtener página actual
        $resultados_por_pagina = 10; // O el número que prefieras
        // Recibimos el número de página desde el fetch de JavaScript
        $pagina_actual = isset($_POST['pagina']) ? (int)$_POST['pagina'] : 1;
        
        // 2. Calcular el OFFSET para la consulta SQL
        $offset = ($pagina_actual - 1) * $resultados_por_pagina;

        // 3. Obtener el total de registros y calcular el total de páginas
        $total_usuarios = $objUsuario->contarTotalUsuarios(); 
        $total_paginas = ceil($total_usuarios / $resultados_por_pagina);

        // 4. Obtener solo las personas para la página actual
        $arr_Usuario = $objUsuario->listarUsuariosPaginados($resultados_por_pagina, $offset);
        // --- FIN DE CAMBIOS PARA PAGINACIÓN ---
        if (!empty($arr_Usuario)) {
            // El resto de tu lógica para formatear los datos permanece igual
            for ($i = 0; $i < count($arr_Usuario); $i++) {

                $arr_Usuario[$i]->estado = 1? $arr_Usuario[$i]->estado = '<p class="text-success">activo</p>' : $arr_Usuario[$i]->estado = '<p class="text-success">de baja</p>';
                $arrPersona = $objPersona->buscarPersonaById($arr_Usuario[$i]->persona_id);
                $arrRolUsu = $objRolesUsu->getRolUsuarioByIdUsuario($arr_Usuario[$i]->id);
                $id_usuario = $arr_Usuario[$i]->id;

                $arr_Usuario[$i]->dni = $arrPersona->dni;
                $arr_Usuario[$i]->nombre = $arrPersona->nombres;
                $arr_Usuario[$i]->apellido = $arrPersona->apellidos;
                $arr_Usuario[$i]->correo = $arrPersona->correo_electronico;
                $arr_Usuario[$i]->telefono = $arrPersona->telefono;
                $arr_Usuario[$i]->rol = $arrRolUsu->nombre;

                $opciones = '<a href="' . BASE_URL . 'editarProducto/' . $id_usuario . '"><button class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></button></a>
                             <button class="btn btn-danger btn-sm" onclick="eliminar_producto(' . $id_usuario . ')"><i class="fas fa-trash-alt"></i></button>';
                $arr_Usuario[$i]->options = $opciones;
            }
            $arr_Respuesta['status'] = true;
            $arr_Respuesta['contenido'] = $arr_Usuario;
            
            // AÑADIDO: Incluir información de la paginación en la respuesta JSON
            $arr_Respuesta['paginacion'] = [
                'pagina_actual' => $pagina_actual,
                'total_paginas' => $total_paginas
            ];
        } else {
            // Manejar el caso de que no haya resultados para esa página
            $arr_Respuesta['status'] = true; // Es un éxito, pero no hay contenido
            $arr_Respuesta['contenido'] = [];
            $arr_Respuesta['paginacion'] = ['pagina_actual' => 1, 'total_paginas' => 1];
        }
    }
    echo json_encode($arr_Respuesta);
}

if($tipo == "sent_email_password"){
     $arr_Respuesta = array('status' => false, 'msg' => 'Error_Sesion');
    if ($objSesion->verificar_sesion_si_activa($id_sesion, $token)) {
            $datos_secion = $objSesion->buscarSesionLoginById($id_sesion);

              //obtenemos los datos del usuario mediante el id de la sesion
               $id_usuario = $datos_secion->usuario_id;
               $datos_usuario = $objUsuario->buscarUsuarioById($id_usuario);
               $datos_persona = $objPersona->buscarPersonaById($datos_usuario->persona_id);
               $correo_usuario = $datos_persona->correo_electronico;
               $nombre_usuario = $datos_persona->nombres;
                
                $llave = $objAdmin->generar_llave(30);
                $token = password_hash($llave, PASSWORD_DEFAULT);
                $update = $objUsuario->UpdateResetPassword($id_usuario,$llave,1);
                if ($update) {
                    /////////////////////////////////////////////////////////////////////////falta///////////////////////
                            //Create an instance; passing `true` enables exceptions
                        //incluimos la plantilla de correo para el body email
                        ob_start();
                        include __DIR__ . '../../view/BodyEmail.php';
                        $emailBody = ob_get_clean();
                        
                        //php mailer
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
                            $mail->setFrom('sisve_jota@limon-cito.com', 'Support Sisve app');
                            $mail->addAddress($correo_usuario, $nombre_usuario);     //Add a recipient
                            //Name is optional



                            //Content
                            $mail->isHTML(true);                                  //Set email format to HTML
                            $mail->Subject = 'password reset request';

        /*                   $file = fopen("../view/BodyEmail.php","r");
                            $str = fread($file, filesize("../view/BodyEmail.php"));
                            $str = trim($str);
                            fclose($file); */

                            $mail->Body    = $emailBody;
                            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                            $mail->send();
                            echo 'Correo enviado con éxito.';
                        } catch (Exception $e) {
                            echo "Error al enviar: {$mail->ErrorInfo}";
                        }
                }else{
                    echo "fallo";
                }
    }
}
?>