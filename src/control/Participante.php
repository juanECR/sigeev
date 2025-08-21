<?php 
session_start();
require_once('../model/admin-sesionModel.php');
require_once('../model/admin-personaModel.php');
require_once('../model/admin-participanteModel.php');
require_once('../model/admin-rolEventoModel.php');
require_once('../model/adminModel.php');

$tipo = $_GET['tipo'];

//instanciar la clase categoria model
$objSesion = new SessionModel();
$objPersona =  new PersonaModel();
$objParticipante = new ParticipanteModel();
$objRolEvento = new RolEvento();
$objAdmin = new AdminModel();

//variables de sesion
$id_sesion = $_REQUEST['sesion'];
$token = $_REQUEST['token'];

if ($tipo == "registrarParticipanteEvento") {
    $arr_Respuesta = array('status'=>false,'mensaje'=>'Error_sesion');
    if($objSesion->verificar_sesion_si_activa($id_sesion, $token)){
        if($_POST){
          $evento_id = $_POST['data'];
          $dni = trim($_POST['dni']);
          $nombres = trim($_POST['nombres']);
          $apellidos = $_POST['apellidos'];
          $correo = trim($_POST['correo']);
          $telefono = trim($_POST['telefono']);
          $f_nacimiento = $_POST['fecha_nacimiento'];
          $genero = trim($_POST['genero']);
          $rol_id = trim($_POST['rolEvento']);
          if($correo == ""){
             $correo = $dni.'@event.to';
          }
          if($evento_id == ""||$dni==""||$nombres==""||$apellidos==""||$genero==""||$rol_id==""){
             $arr_Respuesta = array('status'=>false,'mensaje'=>'Error_Campos vacios');
          }else{
            $validar_dni = $objPersona->buscarPersonaByDni($dni);
            if($validar_dni){
               $arr_Respuesta = array('status'=>false,'mensaje'=>'esta persona ya existe');
            }else{
                $id_new_persona = $objPersona->registrarPersona($dni,$nombres,$apellidos,$correo,$telefono,$f_nacimiento,$genero);
                if($id_new_persona > 0){
                    //registrar tabla participantes
                    $id_new_participante = $objParticipante->registrarParticipanteEvento($evento_id,$id_new_persona,$rol_id);
                    if($id_new_participante > 0){
                        $arr_Respuesta = array('status'=>true,'mensaje'=>'participante registrado');
                    }else{
                       $arr_Respuesta = array('status'=>false,'mensaje'=>'fallo al registrar participante');
                    }
                }else{
                   $arr_Respuesta = array('status'=>false,'mensaje'=>'arror al registrar persona');
                }
            }
          }
        }
    }
    echo json_encode($arr_Respuesta);
}

if($tipo == "listarParticipantesEvento"){
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
        $total_participantes = $objParticipante->constarTotalParticipantes();
        $total_paginas = ceil($total_participantes / $resultados_por_pagina);

        // 4. Obtener solo las personas para la página actual
        $arr_participante = $objParticipante->listarParticipantesPaginado($resultados_por_pagina, $offset,$id_evento); 

        // --- FIN DE CAMBIOS PARA PAGINACIÓN ---

        if (!empty($arr_participante)) { /////////////////////////////////////////////////////////////////////////////////////
            // El resto de tu lógica para formatear los datos permanece igual
            for ($i = 0; $i < count($arr_participante); $i++) {
                $arr_persona = $objPersona->buscarPersonaById($arr_participante[$i]->persona_id);
                $arr_rolParticipante = $objRolEvento->buscarRolEventoById($arr_participante[$i]->rol_id);
                //dstos de la persona
                $arr_participante[$i]->dni = $arr_persona->dni;
                $arr_participante[$i]->nombre = $arr_persona->nombres;
                $arr_participante[$i]->apellidos = $arr_persona->apellidos;
                $arr_participante[$i]->telefono = $arr_persona->telefono ?? 'no tiene';
                $arr_participante[$i]->fecha_nacimiento = $arr_persona->fecha_nacimiento ?? 'no tiene';
                $arr_participante[$i]->rolNombre = $arr_rolParticipante->nombre;

                $id_participante = $arr_participante[$i]->id; //valor para los botones
                $opciones = '<a href="' . BASE_URL . 'editarProducto/' . $id_participante . '"><button class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></button></a>
                             <button class="btn btn-danger btn-sm" onclick="eliminar_producto(' . $id_participante . ')"><i class="fas fa-trash-alt"></i></button>';
                $arr_participante[$i]->options = $opciones;
            }

            $arr_Respuesta['status'] = true;
            $arr_Respuesta['contenido'] = $arr_participante;
            
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


if($tipo == "listarAlgunosParticipantes"){
    $arr_Respuesta = array('status'=>false,'mensaje'=>'Error_sesion');
    if($objSesion->verificar_sesion_si_activa($id_sesion,$token)){
        if($_POST){
          $id_evento = $_POST['id_evento'];
          $numeroListar = 3;
          if($id_evento == ""){
              $arr_Respuesta = array('status'=>false,'mensaje'=>'no menciona evento');
          }else{
            $arr_participantes = $objParticipante->listarAlungunosParticipantes($id_evento,$numeroListar);
            if(!empty($arr_participantes)){
               for ($i = 0; $i < count($arr_participantes); $i++) {
                $arr_persona = $objPersona->buscarPersonaById($arr_participantes[$i]->persona_id);
                $arr_rolParticipante = $objRolEvento->buscarRolEventoById($arr_participantes[$i]->rol_id);
                
                $arr_participantes[$i]->nombre = $arr_persona->nombres;
                $arr_participantes[$i]->apellido = $arr_persona->apellidos;
                $arr_participantes[$i]->rol = $arr_rolParticipante->nombre;

                $arr_Respuesta['status']=true;
                $arr_Respuesta['contenido']=$arr_participantes;
                $arr_Respuesta['mensaje'] = 'listando..';
                }
            }else{
            // Manejar el caso de que no haya resultados para esa página
            $arr_Respuesta['status'] = true; // Es un éxito, pero no hay contenido
            $arr_Respuesta['contenido'] = [];
            }
        }
      }
    }
    echo json_encode($arr_Respuesta); 
}
if($tipo == "contarParticipantes"){
        $arr_Respuesta = array('status'=>false,'mensaje'=>'Error_sesion');
    if($objSesion->verificar_sesion_si_activa($id_sesion,$token)){
        $totalParticipantes = $objParticipante->constarTotalParticipantes();

        $arr_Respuesta['status'] = true;
        $arr_Respuesta['total'] = $totalParticipantes;
    }
}
?>