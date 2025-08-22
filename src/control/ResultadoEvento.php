<?php 
session_start();
require_once('../model/admin-sesionModel.php');
require_once('../model/admin-resultadosModel.php');
require_once('../model/admin-personaModel.php');
require_once('../model/adminModel.php');

$tipo = $_GET['tipo'];

//instanciar la clase categoria model
$objSesion = new SessionModel();
$objResultados = new ResultadoEvento();
$objPersona = new PersonaModel();
$objAdmin = new AdminModel();

//variables de sesion
$id_sesion = $_REQUEST['sesion'];
$token = $_REQUEST['token'];

if($tipo == "asignarPosicion"){
    $arr_Respuesta = array('status'=>false,'mensaje'=>'Error_sesion');
    if($objSesion->verificar_sesion_si_activa($id_sesion, $token)){
        if($_POST){
         $id_evento = $_POST['id_evento'];
         $id_participante =$_POST['id_participante'];
         $puntaje = $_POST['puntaje'];
         $posicion = trim($_POST['posicion']);
         if($id_evento == "" || $id_participante == "" || $puntaje == "" || $posicion == ""){
            $arr_Respuesta = array('status'=>false,'mensaje'=>'Campos vacios');
         }else{
            $validarPuesto = $objResultados->buscarPosicionByEvento($id_evento,$posicion);
            if($validarPuesto){
              $arr_Respuesta = array('status'=>false,'mensaje'=>'esta posicion ya ha sido ocupada');
            }else{
              $id_new_posicion = $objResultados->asignarPosicion($id_evento,$id_participante,$puntaje,$posicion); 
              if($id_new_posicion > 0){
               $arr_Respuesta = array('status'=>true,'mensaje'=>'Posicion asignada');
              }else{
                $arr_Respuesta = array('status'=>false,'mensaje'=>'error al registrar posicion');
              }
            }
         }
        }
    }
    echo json_encode($arr_Respuesta);
}

if($tipo == "listarResultadosEvento"){
    $arr_Respuesta = array('status' => false, 'contenido' => '', 'mensaje' => 'Error_sesion');

    if ($objSesion->verificar_sesion_si_activa($id_sesion, $token)) {
        // 1. Definir configuración y obtener página actual
        $resultados_por_pagina = 10; // O el número que prefieras
        // Recibimos el número de página desde el fetch de JavaScript
        $pagina_actual = isset($_POST['pagina']) ? (int)$_POST['pagina'] : 1;
        $id_evento = $_POST['id_evento'];
        // 2. Calcular el OFFSET para la consulta SQL
        $offset = ($pagina_actual - 1) * $resultados_por_pagina;

        // 3. Obtener el total de registros y calcular el total de páginas
        $totalResultados = $objResultados->contarTotalResultados();
        $total_paginas = ceil($totalResultados / $resultados_por_pagina);

        // 4. Obtener solo las personas para la página actual
        $arr_resultados = $objResultados->listarResultadosPaginado($resultados_por_pagina, $offset,$id_evento); 

        // --- FIN DE CAMBIOS PARA PAGINACIÓN ---

        if (!empty($arr_resultados)) { 
            // El resto de tu lógica para formatear los datos permanece igual
            for ($i = 0; $i < count($arr_resultados); $i++) {
                $arr_persona = $objPersona->buscarPersonaById($arr_resultados[$i]->participante_id);
               
                //dstos de la persona
                $arr_resultados[$i]->dni = $arr_persona->dni;
                $arr_resultados[$i]->nombre = $arr_persona->nombres;
                //puedes obtener datos el evento <<<               

                $id_resultado = $arr_resultados[$i]->id; //valor para los botones
                $opciones = '<a href="' . BASE_URL . 'editarProducto/' . $id_resultado . '"><button class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></button></a>
             <button class="btn btn-danger btn-sm" onclick="eliminar_producto(' . $id_resultado . ')"><i class="fas fa-trash-alt"></i></button>';
                $arr_resultados[$i]->options = $opciones;
            }

            $arr_Respuesta['status'] = true;
            $arr_Respuesta['contenido'] = $arr_resultados;
            
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



?>