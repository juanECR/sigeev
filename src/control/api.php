<?php
session_start();

// 1. CABECERAS ESENCIALES DE LA API
// -------------------------------------------------------------------
// Permite que cualquier página web externa consuma esta API (CORS)
header("Access-Control-Allow-Origin: *"); 
// Indica que la respuesta siempre será en formato JSON
header('Content-Type: application/json; charset=utf-8');

// 2. INCLUIR LOS MODELOS NECESARIOS
// -------------------------------------------------------------------
// Usamos rutas relativas como en tu controlador original
require_once('../model/admin-sesionModel.php');
require_once('../model/admin-apiModel.php');
require_once('../model/admin-clientesApiModel.php');
// ... incluye otros modelos que la API pueda necesitar ...

// 3. OBTENER EL TIPO DE ACCIÓN Y PREPARAR LA RESPUESTA
// -------------------------------------------------------------------
$tipo = $_GET['tipo'] ?? null;
$arr_Respuesta = ['status' => 'error', 'message' => 'Tipo de acción no válido.'];

// 4. INSTANCIAR LOS MODELOS (solo cuando se necesiten)
// -------------------------------------------------------------------
$objApi = new ApiModel();
$objSesion = new SessionModel();
$objClient = new ClienteApiModel();


/* $token = $_REQUEST['token']; */

//endpoint para filtrar eventos por organizador
if($tipo == "listarEventosByOrganizador"){
 $tokenn = explode('-',$token);
 $id_client = $tokenn[2];

 $arr_client = $objClient->buscarClientApiById($id_client);
 if($arr_client->estado == 1){
    //data es el valor del parametro de busqueda (organizador)
       $dato = $_POST['data'];
      //obtener eventos por id organizador
       $arr_eventos = $objApi->listarEventosByOrganizadorId($dato);
       if($arr_eventos){
           $arr_Respuesta = array('status' => true,'data'=>$arr_eventos);
       }else{
         $arr_Respuesta = array('status' => false,'data'=>'');
       }
 }else{
    $arr_Respuesta = array('status' => false,'data'=>'','mensaje' => 'Peticion invalida');
 }
}

//endpoint para listar organizadores para los filtros
if($tipo == "ObtenerOrganizadores"){
  $tokenn = explode('-',$token);
  $id_client = $tokenn[2];

 $arr_client = $objClient->buscarClientApiById($id_client);
 if($arr_client->estado == 1){

    $arrOrganizadores = $objApi->listarOrganizadores();
    if($arrOrganizadores){
        $arr_Respuesta = array('status' => true,'data'=>$arrOrganizadores);
    }else{
         $arr_Respuesta = array('status' => false,'data'=>'');
    }
 }else{
     $arr_Respuesta = array('status' => false,'data'=>'','mensaje' => 'Peticion invalida');
 }
}


//endopint listar eventos proximos
if($tipo == "listarProximos"){
    $arrEventos = $objApi->listarEventosOProximos();
    $arr_Respuesta = array('status' => 'success','timestamp' => date('c'),'data'=>$arrEventos);
}




// URL: /src/control/api.php?tipo=listarProximos

/* switch ($tipo) {
    case 'listarProximos':
        $proximosEventos = $objApi->listarTodosEventos();
        
        $arr_Respuesta = [
            'status' => 'success',
            'timestamp' => date('c'),
            'data' => $proximosEventos
        ];
        break;
    case 'listarTodosEventos':
        $id_sesion = $_REQUEST['sesion'] ?? null;
        $token = $_REQUEST['token'] ?? null;

        if ($objSesion->verificar_sesion_si_activa($id_sesion, $token)) {
            $todosLosEventos = $objApi->listarTodosEventos();
            $arr_Respuesta = [
                'status' => 'success',
                'data' => $todosLosEventos
            ];
        } else {
            $arr_Respuesta = [
                'status' => 'error',
                'message' => 'Error de autenticación: la sesión o el token no son válidos.'
            ];
      
            http_response_code(401); 
        }
        break;
} */

// 6. DEVOLVER LA RESPUESTA FINAL EN FORMATO JSON
// -------------------------------------------------------------------
echo json_encode($arr_Respuesta, JSON_PRETTY_PRINT);
exit(); // Finalizamos la ejecución para asegurar que no se imprima nada más

?>