<?php 
session_start();
require_once('../model/admin-sesionModel.php');
require_once('../model/admin-personaModel.php');
require_once('../model/admin-participanteModel.php');
require_once('../model/adminModel.php');

$tipo = $_GET['tipo'];

//instanciar la clase categoria model
$objSesion = new SessionModel();
$objPersona =  new PersonaModel();
$objParticipante = new ParticipanteModel();
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

}

?>