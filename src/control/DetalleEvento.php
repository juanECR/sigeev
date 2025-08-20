<?php 
session_start();
require_once('../model/admin-sesionModel.php');
require_once('../model/admin-eventoModel.php');
require_once('../model/admin-organizadorModel.php');
require_once('../model/adminModel.php');

$tipo = $_GET['tipo'];

//instanciar la clase categoria model
$objSesion = new SessionModel();
$objEvento = new EventoModel();
$objOrganizador = new OrganizadorModel();
$objAdmin = new AdminModel();

//variables de sesion
$id_sesion = $_REQUEST['sesion'];
$token = $_REQUEST['token'];

if($tipo == "listarDetallesEvento"){
    $arr_Respuesta = array('status'=>false,'mensaje'=>'Error_sesion');
    if($objSesion->verificar_sesion_si_activa($id_sesion,$token)){
        if($_POST){
            $evento_id = $_POST['id_evento'];
        if($evento_id == ""){
        $arr_Respuesta = array('status'=>false,'mensaje'=>'evento no existe');
        }else{
            $arr_Evento = $objEvento->buscarEventoById($evento_id);
            if($arr_Evento){
                $arr_organizador = $objOrganizador->buscarOrganizadorById($arr_Evento->organizador_id);
                $arr_Evento->organizador = $arr_organizador->razon_social;
                $arr_Respuesta['status']=true;
                $arr_Respuesta['contenido']=$arr_Evento;
                $arr_Respuesta['mensaje'] = 'listando..';
            }else{
                $arr_Respuesta = array('status'=>false,'mensaje'=>'Evento no existe');
            }    
        } 
        }
    }
    echo json_encode($arr_Respuesta);
}


?>