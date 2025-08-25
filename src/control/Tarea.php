<?php 
session_start();
require_once('../model/admin-sesionModel.php');
require_once('../model/admin-tareaModel.php');
require_once('../model/adminModel.php');

$tipo = $_GET['tipo'];

//instanciar la clase categoria model
$objSesion = new SessionModel();
$objTarea =  new TareaModel();
$objAdmin = new AdminModel();

//variables de sesion
$id_sesion = $_REQUEST['sesion'];
$token = $_REQUEST['token'];

if($tipo == "registrarTarea"){
    $arr_Respuesta = array('status'=>false,'mensaje'=>'Error_sesion');
    if($objSesion->verificar_sesion_si_activa($id_sesion, $token)){
        if($_POST){
            $evento_id = $_POST['id_evento'];
            $empleado_id = $_POST['id_empleado'];
            $titulo = $_POST['titulo'];
            $descripcion = $_POST['descripcion'];
            $fecha_tarea = $_POST['f_tarea'];

            if($evento_id == "" || $empleado_id == "" || $titulo == ""||$descripcion == ""||$fecha_tarea == ""){
                $arr_Respuesta = array('status'=>false,'mensaje'=>'Campos vacios');
            }else{
             $id_new_tarea = $objTarea->registrarTarea($evento_id,$empleado_id,$titulo,$descripcion,$fecha_tarea);
             if($id_new_tarea > 0){
                 $arr_Respuesta = array('status'=>true,'mensaje'=>'Registrado');
             }else{
                $arr_Respuesta = array('status'=>false,'mensaje'=>'Fallo al registrar');
             }
            }
        }
    }
    echo json_encode($arr_Respuesta);
}

?>