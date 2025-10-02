<?php 
session_start();
require_once('../model/admin-sesionModel.php');
require_once('../model/admin-tokensApiModel.php');
require_once('../model/adminModel.php');

$tipo = $_GET['tipo'];

//instanciar la clase categoria model
$objSesion = new SessionModel();
$objToken = new TokenApiModel();
$objAdmin = new AdminModel();

//variables de sesion
$id_sesion = $_REQUEST['sesion'];
$token = $_REQUEST['token'];

if($tipo == "generarTokenClient"){
    $arr_Respuesta = array('status' => false, 'mensaje' => 'Error_Sesion');
    if ($objSesion->verificar_sesion_si_activa($id_sesion, $token)) {
        if ($_POST) {
            $id_client = $_POST['data'];
            if (!empty($id_client)) {
                $resultado = $objToken->generarTokenParaCliente($id_client);
                if ($resultado) {
                    $arr_Respuesta = array('status' => true, 'mensaje' => 'Token generado correctamente');
                } else {
                    $arr_Respuesta = array('status' => false, 'mensaje' => 'Error al generar el token en la base de datos');
                }
            } else {
                $arr_Respuesta = array('status' => false, 'mensaje' => 'ID de cliente no proporcionado');
            }
        } else {
            $arr_Respuesta = array('status' => false, 'mensaje' => 'Método no permitido');
        }
    }
    echo json_encode($arr_Respuesta);
    exit;
}
if($tipo == "listarTokensCliente"){
   $arr_Respuesta = array('status' => false, 'mensaje' => 'Error_Sesion');
   if ($objSesion->verificar_sesion_si_activa($id_sesion, $token)) {
    $id_client = $_POST['data'];
    if(empty($id_client)||!is_numeric($id_client)){
      $arr_Respuesta = array('status' => false, 'mensaje' => 'Cliente invalido');
    }else{
       $arr_tokens = $objToken->listarTokensCliente($id_client);
       if($arr_tokens){
        for ($i=0; $i < count($arr_tokens); $i++) {
            if($arr_tokens[$i]->estado == 1){
              $arr_tokens[$i]->estado = '<span class="badge text-bg-warning">Activo</span>';
              $opciones = '<button class="btn btn-sm btn-outline-light" title="Copiar Token"><i class="bi bi-clipboard"></i></button>
                       <button class="btn btn-sm btn-outline-success ms-2" title="Revocar/Desactivar"><i class="bi bi-toggle-on"></i></button>';
            }else if($arr_tokens[$i]->estado == 0){
              $arr_tokens[$i]->estado = '<span class="badge text-bg-danger">Inactivo</span>';
               $opciones = '<button class="btn btn-sm btn-outline-light" title="Copiar Token"><i class="bi bi-clipboard"></i></button>
                       <button class="btn btn-sm btn-outline-danger ms-2" title="Revocar/Desactivar"><i class="bi bi-toggle-on"></i></button>';
            }
            $id_token = $arr_tokens[$i]->id;
    
            $arr_tokens[$i]->options = $opciones;
        }
         $arr_Respuesta['contenido'] = $arr_tokens;
         $arr_Respuesta['status'] = true;
         $arr_Respuesta['mensaje'] = "correcto";
       }else{
        $arr_Respuesta = array('status' => false, 'mensaje' => 'Error base de datos');
       }
    }
   }
   echo json_encode($arr_Respuesta);
}


?>