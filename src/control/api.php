<?php
session_start();

// Permite que cualquier página web externa consuma esta API (CORS)
header("Access-Control-Allow-Origin: *"); 
// Indica que la respuesta siempre será en formato JSON
header('Content-Type: application/json; charset=utf-8');

require_once('../model/admin-sesionModel.php');
require_once('../model/admin-apiModel.php');
require_once('../model/admin-clientesApiModel.php');

$tipo = $_GET['tipo'] ?? null;
$arr_Respuesta = ['status' => 'error', 'message' => 'Tipo de acción no válido.'];

$objApi = new ApiModel();
$objSesion = new SessionModel();
$objClient = new ClienteApiModel();

// Función para enviar respuestas de error y salir
function responderError(string $mensaje): void {
    echo json_encode([
        'status' => 'error',
        'mensaje' => $mensaje,
        'timestamp' => date('c')
    ], JSON_PRETTY_PRINT);
    exit();
}

$token = $_POST['token'] ?? null;
$datas = explode('-',$token);
//validar token y formato
if (empty($token) || count($datas) < 3) {
    responderError('Token no proporcionado o formato inválido.');
}

$id_cliente = $datas[2];
if (!is_numeric($id_cliente) || (int)$id_cliente <= 0) {
    responderError('ID de cliente inválido.');
}

// Validar existencia y estado del cliente
$arrCliente = $objClient->buscarClientApiById($id_cliente);
if (!$arrCliente || $arrCliente->estado == 0) {
    responderError('Cliente no encontrado o inactivo.');
}

// Validar estado del token asociado al cliente
$arrTokenForClient = $objApi->buscarTokenForClient($id_cliente, $token);
if (!$arrTokenForClient || $arrTokenForClient->estado == 0) {
    responderError('Token no encontrado o inactivo.');
}



//endpoint para filtrar eventos por organizador // falta terminar
if($tipo == "listarEventosByOrganizador"){
    //data es el valor del parametro de busqueda (organizador)
       $dato = $_POST['data'];
      //obtener eventos por id organizador
       $arr_eventos = $objApi->listarEventosByOrganizadorId($dato);
       if($arr_eventos){
           $arr_Respuesta = array('status' => true,'data'=>$arr_eventos);
       }else{
         $arr_Respuesta = array('status' => false,'data'=>'');
       }
}

//endpoint para listar organizadores para los filtros
if($tipo == "ObtenerOrganizadores"){
    $arrOrganizadores = $objApi->listarOrganizadores();
    if($arrOrganizadores){
        $arr_Respuesta = array('status' => true,'timestamp' => date('c'),'data'=>$arrOrganizadores,'mensaje' => 'exito');
    }else{
         $arr_Respuesta = array('status' => false,'timestamp' => date('c'),'mensaje' => 'Organizadores no encontrados');
    }
}

//endopint listar eventos proximos
if($tipo === "listarProximos"){
            $arrEventos = $objApi->listarEventosOProximos();
            $arr_Respuesta = array('status' => true,'timestamp' => date('c'),'data'=>$arrEventos, 'mensaje' => 'exito');
}
if($tipo === "obtenerCategoriasEventos"){
            $arrCategoriasEvento = $objApi->obtenercategoriasEventos();
            if($arrCategoriasEvento){
            $arr_Respuesta = array('status' => true,'timestamp' => date('c'),'data'=>$arrCategoriasEvento, 'mensaje' => 'exito');
            }else{
                $arr_Respuesta = array('status' => false,'timestamp' => date('c'), 'mensaje' => 'error database');
            }
          
}

//DEVOLVER LA RESPUESTA FINAL EN FORMATO JSON
echo json_encode($arr_Respuesta, JSON_PRETTY_PRINT);
exit(); 

?>