<?php 
session_start();
require_once('../model/admin-sesionModel.php');
require_once('../model/admin-usuarioModel.php');
require_once('../model/admin-personaModel.php');
require_once('../model/adminModel.php');

$tipo = $_GET['tipo'];

//instanciar la clase categoria model
$objSesion = new SessionModel();
$objUsuario = new UsuarioModel();
$objPersona =  new PersonaModel();
$objAdmin = new AdminModel();

//variables de sesion
$id_sesion = $_REQUEST['sesion'];
$token = $_REQUEST['token'];

if($tipo == "registrarPersona"){
    $arr_Respuesta = array('status' => false, 'msg' => 'Error_Sesion');
    if ($objSesion->verificar_sesion_si_activa($id_sesion, $token)) {
        //print_r($_POST);
        //repuesta
        if ($_POST) {
            $dni = $_POST['dni'];
            $nombres = $_POST['nombres'];
            $apellidos = $_POST['apellidos'];
            $correo = $_POST['correo'];
            $telefono = $_POST['telefono'];
            $fecha_nacimiento = $_POST['fecha_nacimiento'];
            $genero = $_POST['genero'];

            if ($dni =="" ||$nombres == ""||$apellidos== "" || $correo == "" || $telefono == "" || $fecha_nacimiento == ""|| $genero == "") {
                $arr_Respuesta = array('status' => false, 'mensaje' => 'Error, campos vacíos');
            } else {
                $arr_Persona = $objPersona->buscarPersonaByCorreo($correo);
                if ($arr_Persona) {
                    $arr_Respuesta = array('status' => false, 'mensaje' => 'Registro Fallido, Usuario ya se encuentra registrado');
                } else {
                    $id_persona = $objPersona->registrarPersona($dni,$nombres,$apellidos,$correo,$telefono,$fecha_nacimiento,$genero);
                    if ($id_persona > 0) {
                        // array con los id de los sistemas al que tendra el acceso con su rol registrado
                        // caso de administrador y director
                        $arr_Respuesta = array('status' => true, 'mensaje' => 'Registro Exitoso');
                    } else {
                        $arr_Respuesta = array('status' => false, 'mensaje' => 'Error al registrar usuario');
                    }
                }
            }
        }
    }
    echo json_encode($arr_Respuesta);
}



?>