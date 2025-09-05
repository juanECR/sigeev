<?php
// Habilitar reporte de errores para desarrollo (opcional pero recomendado)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// ==========================================================
// SECCIÓN DEL ENRUTADOR PRINCIPAL
// ==========================================================

// Comprobamos si la petición es para la API
if (isset($_GET['api'])) {
    
    // --- MANEJADOR DE PETICIONES DE LA API ---
    
    // 1. Parsear la ruta de la API. Ej: api=eventos/listarProximos
    $ruta_api = explode('/', $_GET['api']);
    $controlador_api_nombre = $ruta_api[0]; // 'eventos'
    $metodo_api_nombre = $ruta_api[1] ?? 'index'; // 'listarProximos' o 'index' por defecto

    // 2. Construir el nombre de la clase y la ruta del archivo
    $nombreClaseApi = ucfirst($controlador_api_nombre) . 'ApiController';
    $archivoControladorApi = 'src/control/api/' . $nombreClaseApi . '.php';

    // 3. Validar y ejecutar el controlador de la API
    if (file_exists($archivoControladorApi)) {
        require_once $archivoControladorApi;
        
        if (class_exists($nombreClaseApi)) {
            $controlador = new $nombreClaseApi();

            if (method_exists($controlador, $metodo_api_nombre)) {
                // Ejecutar el método del controlador de la API
                $controlador->$metodo_api_nombre();
            } else {
                // Error: Método no encontrado
                header("HTTP/1.1 404 Not Found");
                header('Content-Type: application/json');
                echo json_encode(['status' => 'error', 'message' => 'API method not found']);
            }
        } else {
            // Error: Clase no encontrada en el archivo
            header("HTTP/1.1 500 Internal Server Error");
            header('Content-Type: application/json');
            echo json_encode(['status' => 'error', 'message' => 'API controller class not found']);
        }
    } else {
        // Error: Archivo de controlador no encontrado
        header("HTTP/1.1 404 Not Found");
        header('Content-Type: application/json');
        echo json_encode(['status' => 'error', 'message' => 'API controller not found']);
    }

    // Importante: Detenemos la ejecución aquí para no cargar la plantilla HTML
    exit();

} else {

    // --- MANEJADOR DE PETICIONES WEB (Tu código original) ---
    
    require_once "src/control/vistas_control.php";
    $vista = new vistasControlador();
    $vista->obtenerPlantillaControlador();
}

?>