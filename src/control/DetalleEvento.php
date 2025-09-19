<?php

use PhpOffice\PhpSpreadsheet\Calculation\TextData\Trim;

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

if($tipo == "actualizarEvento"){
     $arr_Respuesta = array('status' => false, 'mensaje' => 'Error_Sesion');
    if ($objSesion->verificar_sesion_si_activa($id_sesion, $token)) {
        if ($_POST) {
            $id_evento = trim($_POST['id_evento']);
            $titulo = strtoupper(trim($_POST['titulo']));
            $descripcion = strtolower($_POST['descripcion']);
            $categoria_id = trim($_POST['categoria']);
            $fecha_inicio = $_POST['fecha_inicio'];
            $fecha_fin = $_POST['fecha_fin'];
            $ubicacion = $_POST['ubicacion'];
            $organizador_id = trim($_POST['organizador']);
            $estado = trim($_POST['estado']);
            if(!$id_evento ||$id_evento == null || !is_numeric($id_evento)){
            $arr_Respuesta = array('status' => false, 'mensaje' => 'Error de sistema - Consulta invalida');
            }else
            if ($titulo =="" ||$descripcion == ""||$categoria_id== "" || $fecha_inicio == "" || $fecha_fin == "" || $ubicacion == ""|| $organizador_id == "") {
                $arr_Respuesta = array('status' => false, 'mensaje' => 'Error, campos vacíos');
            } else {
                    $id_evento_updated = $objEvento->actualizarEvento($id_evento,$titulo,$descripcion,$categoria_id,$fecha_inicio,$fecha_fin,$ubicacion,$organizador_id,$estado);
                    if ($id_evento_updated) {
                        $arr_Respuesta = array('status' => true, 'mensaje' => 'Actualizado correctamente');
                    } else {
                        $arr_Respuesta = array('status' => false, 'mensaje' => 'Error al actualizar filas');
                    }
            }
        }
    }
    echo json_encode($arr_Respuesta);
}

if($tipo == "cancelarEvento"){
      $arr_Respuesta = array('status' => false, 'mensaje' => 'Error_Sesion');
    if ($objSesion->verificar_sesion_si_activa($id_sesion, $token)){
         $id_evento = $_POST['id_evento'];
            if(!$id_evento ||$id_evento == null || !is_numeric($id_evento)){
            $arr_Respuesta = array('status' => false, 'mensaje' => 'Error de sistema - Consulta invalida');
            }else{
             $cancelar = $objEvento->cancelarEvento($id_evento);
             if($cancelar){
               $arr_Respuesta = array('status' => true, 'mensaje' => 'Evento cancelado');
             }else{
                $arr_Respuesta = array('status' => false, 'mensaje' => 'Error de sistema');
             }
            }
    }
}


?>