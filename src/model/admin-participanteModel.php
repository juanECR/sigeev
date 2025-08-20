<?php 
require_once "../library/conexion.php";

class ParticipanteModel{
   private $conexion;
   function __construct(){
        $this->conexion = new Conexion();
        $this->conexion = $this->conexion->connect();
   }
   public function registrarParticipanteEvento($evento_id,$persona_id,$rol_id){
        $sql = $this->conexion->query("INSERT INTO participantes_evento (evento_id,persona_id,rol_id) VALUES ('$evento_id','$persona_id','$rol_id')");
        if ($sql) {
            $sql = $this->conexion->insert_id;
        } else {
            $sql = 0;
        }
        return $sql;
   }
   public function listarParticipantesEventoPaginado(){

   }

   }