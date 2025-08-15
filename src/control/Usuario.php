<?php 
session_start();
require_once('../model/admin-sesionModel.php');
require_once('../model/admin-usuarioModel.php');
require_once('../model/admin-personaModel.php');
require_once('../model/admin-rolesUsuario.php');
require_once('../model/adminModel.php');

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
?>