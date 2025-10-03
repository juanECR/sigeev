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
$tipo = $_GET['tipo'] ?? null; // Usamos '??' para evitar errores si 'tipo' no existe
$arr_Respuesta = ['status' => 'error', 'message' => 'Tipo de acción no válido.']; // Respuesta por defecto

// 4. INSTANCIAR LOS MODELOS (solo cuando se necesiten)
// -------------------------------------------------------------------
$objApi = new ApiModel();
$objSesion = new SessionModel();
$objClient = new ClienteApiModel();


$token = $_REQUEST['token'];
// 5. ENRUTADOR DE LA API BASADO EN EL PARÁMETRO 'TIPO'
// -------------------------------------------------------------------

if($tipo == "listarEventosByOrganizador"){
 $tokenn = explode('-',$token);
 $id_client = $tokenn[2];

 $arr_client = $objClient->buscarClientApiById($id_client);
 if($arr_client->estado == 1){
    //data es el valor del parametro de busqueda (organizador)
       $dato = $_POST['data'];
       //obtener id por nombre del organizador
       $arrOrganizador = $objApi->obtnerIdOrganizadorByNombre();
      //obtener eventos por id organizador
       $arr_eventos = $objApi->listarEventosByOrganizador($dato);



 }else{

 }
  
}



//peticion con tipo swith
switch ($tipo) {

    // --- Endpoint Público: Listar Próximos Eventos ---
    // No requiere verificación de sesión. Cualquiera puede consumirlo.
    // URL: /src/control/api.php?tipo=listarProximos
    case 'listarProximos':
        // Llamamos a la función del modelo que creamos anteriormente
        $proximosEventos = $objApi->listarTodosEventos(); // Pedimos 5 eventos
        
        $arr_Respuesta = [
            'status' => 'success',
            'timestamp' => date('c'),
            'data' => $proximosEventos
        ];
        break;

    // --- Endpoint Privado: Listar TODOS los eventos (requiere sesión activa) ---
    // Sigue el mismo patrón de seguridad que tu controlador original.
    // URL: /src/control/api.php?tipo=listarTodosEventos&sesion=...&token=...
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
            // Si la sesión no es válida, devolvemos un error de autenticación
            $arr_Respuesta = [
                'status' => 'error',
                'message' => 'Error de autenticación: la sesión o el token no son válidos.'
            ];
            // Opcional: Enviar un código de estado HTTP de no autorizado
            http_response_code(401); 
        }
        break;

    // --- Agrega aquí más 'case' para otros endpoints de la API ---
    // case 'obtenerDetalleEvento':
    //     // tu lógica aquí...
    //     break;
}

// 6. DEVOLVER LA RESPUESTA FINAL EN FORMATO JSON
// -------------------------------------------------------------------
echo json_encode($arr_Respuesta, JSON_PRETTY_PRINT);
exit(); // Finalizamos la ejecución para asegurar que no se imprima nada más

?>