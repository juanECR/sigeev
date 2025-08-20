<?php 
session_start();
require_once('../model/admin-sesionModel.php');
require_once('../model/admin-rolEventoModel.php');
require_once('../model/adminModel.php');

$tipo = $_GET['tipo'];

//instanciar la clase categoria model
$objSesion = new SessionModel();
$objRolEvento = new RolEvento();
$objAdmin = new AdminModel();

//variables de sesion
$id_sesion = $_REQUEST['sesion'];
$token = $_REQUEST['token'];

if($tipo == "registrarNuevoRol"){
    $arr_Respuesta = array('status'=>false, 'msg'=>'Error_Sesion');
    if ($objSesion->verificar_sesion_si_activa($id_sesion,$token)) {
      if($_POST){
      $nombre = strtolower(trim($_POST['NewRolEvento']));
        if($nombre == ""){
            $arr_Respuesta = array('status'=>false, 'mensaje'=>'campos vacios');
        }else{
        $verificarExistencia = $objRolEvento->buscarRolEventoByNombre($nombre);
        if ($verificarExistencia) {
            $arr_Respuesta = array('status'=>false, 'mensaje'=>'Este rol ya existe');
        } else {
            $id_rolEvento = $objRolEvento->registrarRolEvento($nombre);
            if($id_rolEvento > 0){
                $arr_Respuesta = array('status'=>true, 'mensaje'=>'Rol Registrado');
            }else{
                $arr_Respuesta = array('status'=>false, 'mensaje'=>'Fallo al registrar');
            }
            
        }  
        }
      }
    }
    echo json_encode($arr_Respuesta);
}
if($tipo == "listar"){
    $arr_Respuesta = array('status'=>false, 'mensaje'=>'Error_Sesion');
    if ($objSesion->verificar_sesion_si_activa($id_sesion,$token)) {
        $arr_Roles = $objRolEvento->listarTodosRoles();
        if($arr_Roles){
        $arr_Respuesta['status'] = true;
        $arr_Respuesta['mensaje'] = 'consulta correcta';
        $arr_Respuesta['contenido'] = $arr_Roles;      
        }else{
           $arr_Respuesta = array('status'=>false, 'mensaje'=>'Consulta fallida', 'contenido'=>''); 
        }
        
    }
    echo json_encode($arr_Respuesta);
}

?>