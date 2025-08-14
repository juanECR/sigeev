<?php 
session_start();
require_once('../model/admin-sesionModel.php');
require_once('../model/admin-usuarioModel.php');
require_once('../model/adminModel.php');

$tipo = $_GET['tipo'];

//instanciar la clase categoria model
$objSesion = new SessionModel();
$objUsuario = new UsuarioModel();
$objAdmin = new AdminModel();

//variables de sesion
$id_sesion = $_REQUEST['sesion'];
$token = $_REQUEST['token'];

if ($tipo == 'listarUsuarios') {
    $arr_Respuesta = array('status' => false, 'mensaje' => 'fallo consulta');
    $arrUsuarios = $objUsuario->listarUsuarios();
    if (!empty($arrUsuarios)) {
        $arr_Respuesta['contenido'] = $arrUsuarios;
        $arr_Respuesta['status'] = true;
        $arr_Respuesta['mensaje'] = 'listado correctamente';
    }
    echo json_encode($arr_Respuesta);
}
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
            $rol = $_POST['rol'];
            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            if ( $dni == "" || $nombres == "" || $apellidos == "" || $correo == "" || $telefono == "" ||$fecha_nacimiento ==""|| $password == ""|| $rol == "") {
                $arr_Respuesta = array('status' => false, 'mensaje' => 'Error, campos vacíos');
            } else {
                //primero registrar persona->devielve id - despues registrar usuario->devuelve id - despues registrar usuario_roles(id rol, id usuario).
                //validar dni y correo no existan

/*                 $arr_Usuario = $objUsuario->buscarUsuarioByUsuario($correo);
                if ($arr_Usuario) {
                    $arr_Respuesta = array('status' => false, 'mensaje' => 'Registro Fallido, Usuario ya se encuentra registrado');
                } else {
                    $id_usuario = $objUsuario->registrarUsuario( $nombres, $correo, $telefono,$password_hash,$rol);
                    if ($id_usuario > 0) {
                        // array con los id de los sistemas al que tendra el acceso con su rol registrado
                        // caso de administrador y director
                        $arr_Respuesta = array('status' => true, 'mensaje' => 'Registro Exitoso');
                    } else {
                        $arr_Respuesta = array('status' => false, 'mensaje' => 'Error al registrar usuario');
                    }
                } */
            }
        }
    }
    echo json_encode($arr_Respuesta);
}
?>