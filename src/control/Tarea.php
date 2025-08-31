<?php 
session_start();
require_once('../model/admin-sesionModel.php');
require_once('../model/admin-tareaModel.php');
require_once('../model/admin-empleadoModel.php');
require_once('../model/adminModel.php');

$tipo = $_GET['tipo'];

//instanciar la clase categoria model
$objSesion = new SessionModel();
$objTarea =  new TareaModel();
$objEmpleado = new EmpleadoModel();
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

//listra tareas dentro de un evento
if($tipo == "listarTareasPaginado"){
    $arr_Respuesta = array('status' => false, 'contenido' => '', 'mensaje' => 'Error_sesion');

    if ($objSesion->verificar_sesion_si_activa($id_sesion, $token)) {
        // 1. Definir configuración y obtener página actual
        $resultados_por_pagina = 10; // O el número que prefieras
        // Recibimos el número de página desde el fetch de JavaScript
        $pagina_actual = isset($_POST['pagina']) ? (int)$_POST['pagina'] : 1;
        $id_evento = $_POST['id_evento'];
        // 2. Calcular el OFFSET para la consulta SQL
        $offset = ($pagina_actual - 1) * $resultados_por_pagina;
        $totalTreas = $objTarea->contarTotalTareas($id_evento);
        $total_paginas = ceil($totalTreas / $resultados_por_pagina);
        $arr_Tareas = $objTarea->listarTareasPaginado($resultados_por_pagina, $offset,$id_evento); 

        if (!empty($arr_Tareas)) {
            for ($i = 0; $i < count($arr_Tareas); $i++) {

                $arr_empleado = $objEmpleado->buscarEmpleadoById($arr_Tareas[$i]->id_responsable);
                $arr_Tareas[$i]->empleadoName = $arr_empleado->nombres.' '.$arr_empleado->apellidos;

                switch ($arr_Tareas[$i]->estado) {
                    case 'completada':
                          $arr_Tareas[$i]->estado = '<p class="text-ligth"><i class="bi bi-check-circle-fill"></i> Completada</p>';
                        break;
                    case 'en curso':
                          $arr_Tareas[$i]->estado = '<p class="text-success"><i class="bi bi-hourglass-split"></i> En curso</p>';
                        break;
                    default:
                        $arr_Tareas[$i]->estado = '<p class="text-warning"><i class="bi bi-alarm"></i> Pendiente</p>';
                        break;
                }
                $id_tarea = $arr_Tareas[$i]->id; //valor para los botones
                $opciones = '<a href="' . BASE_URL . 'editarProducto/' . $id_tarea . '"><button class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></button></a>
             <button class="btn btn-danger btn-sm" onclick="eliminarTarea('. $id_tarea .')"><i class="fas fa-trash-alt"></i></button>';
                $arr_Tareas[$i]->options = $opciones;
            }

            $arr_Respuesta['status'] = true;
            $arr_Respuesta['contenido'] = $arr_Tareas;
            
            // AÑADIDO: Incluir información de la paginación en la respuesta JSON
            $arr_Respuesta['paginacion'] = [
                'pagina_actual' => $pagina_actual,
                'total_paginas' => $total_paginas
            ];
        } else {
            // Manejar el caso de que no haya resultados para esa página
            $arr_Respuesta['status'] = true; // Es un éxito, pero no hay contenido
            $arr_Respuesta['contenido'] = [];
            $arr_Respuesta['paginacion'] = ['pagina_actual' => 1, 'total_paginas' => 1];
        }
    }
    echo json_encode($arr_Respuesta);
}

if($tipo == "eliminarTarea"){
    $arr_Respuesta = array('status' => false, 'contenido' => '', 'mensaje' => 'Error_sesion');
    if ($objSesion->verificar_sesion_si_activa($id_sesion, $token)) {
        if($_POST){
            $id_tarea = $_POST['id_tarea'];
          if($id_tarea == ""){
             $arr_Respuesta = array('status' => false, 'mensaje' => 'Porfavor selecione tarea');
          }else{
            $id_eliminar = $objTarea->eliminarTarea($id_tarea);
            if($id_eliminar == 1){
             $arr_Respuesta = array('status' => true, 'mensaje' => 'Tarea eliminada');
            }
          }
        }
    }
    echo json_encode($arr_Respuesta);
}

if($tipo == "contarTareas"){
    $arr_Respuesta = array('status'=>false,'mensaje'=>'Error_sesion');
    if($objSesion->verificar_sesion_si_activa($id_sesion,$token)){
        $totalTareas = $objTarea->contarTareas();

        $arr_Respuesta['status'] = true;
        $arr_Respuesta['total'] = $totalTareas;
    }
    echo json_encode($arr_Respuesta);
}

?>