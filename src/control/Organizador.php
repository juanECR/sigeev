<?php 
session_start();
require_once('../model/admin-sesionModel.php');
require_once('../model/admin-organizadorModel.php');
require_once('../model/adminModel.php');

$tipo = $_GET['tipo'];

//instanciar la clase categoria model
$objSesion = new SessionModel();
$objOrganizador = new OrganizadorModel();
$objAdmin = new AdminModel();

//variables de sesion
$id_sesion = $_REQUEST['sesion'];
$token = $_REQUEST['token'];

if($tipo == "registrarOrganizador"){
    $arr_Respuesta = array('status' => false, 'msg' => 'Error_Sesion');
    if ($objSesion->verificar_sesion_si_activa($id_sesion, $token)) {
        if ($_POST) {
            $tipo_documento = $_POST['tipo_documento'];
            $nro_documento = $_POST['nro_documento'];
            $razon_social = $_POST['razon_social'];
            $tipo = $_POST['tipo'];
            $correo = $_POST['correo'];
            $telefono = $_POST['telefono'];

            $razon_soci_mayus = strtoupper($razon_social);

            if ($tipo_documento == ""||$nro_documento =="" ||$razon_social == ""||$tipo== "" || $correo == "" || $telefono == "") {
                $arr_Respuesta = array('status' => false, 'mensaje' => 'Error, campos vacíos');
            } else {
                $arr_OrganizadorDoc = $objOrganizador->buscarOrganizadorByNroDocumento($nro_documento);
                $arr_Organizador = $objOrganizador->buscarOrganizadorByCorreo($correo);
                if ($arr_Organizador) { 
                    $arr_Respuesta = array('status' => false, 'mensaje' => 'Este correo ya ha sido registrado');
                } else if($arr_OrganizadorDoc){
                    $arr_Respuesta = array('status' => false, 'mensaje' => 'Registro Fallido, Organizador ya se encuentra registrado');
                }else{
                    $id_organizador = $objOrganizador->registrarOrganizador($tipo_documento,$nro_documento,$razon_soci_mayus,$tipo,$correo,$telefono);
                    if ($id_organizador > 0) {
                        $arr_Respuesta = array('status' => true, 'mensaje' => 'Registro Exitoso');
                    } else {
                        $arr_Respuesta = array('status' => false, 'mensaje' => 'Error al registrar Organizador');
                    }
                }
            }
        }
    }
    echo json_encode($arr_Respuesta);
}

?>