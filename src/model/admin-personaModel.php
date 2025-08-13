<?php 
require_once "../library/conexion.php";

class PersonaModel{
   private $conexion;
   function __construct(){
        $this->conexion = new Conexion();
        $this->conexion = $this->conexion->connect();
   }
   public function registrarPersona($dni,$nombres,$apellidos,$correo,$telefono,$fecha_nacimiento,$genero){
        $sql = $this->conexion->query("INSERT INTO personas (dni, nombres, apellidos, correo_electronico,telefono,fecha_nacimiento,genero) VALUES ('$dni','$nombres','$apellidos','$correo','$telefono','$fecha_nacimiento','$genero')");
        if ($sql) {
            $sql = $this->conexion->insert_id;
        } else {
            $sql = 0;
        }
        return $sql;
   
   }
   public function buscarPersonaByCorreo($correo){
      $sql = $this->conexion->query("SELECT * FROM personas WHERE correo_electronico='$correo'");
      $sql = $sql->fetch_object();
      return $sql;
   }
   public function listarPersonas(){
        $array = array();
        $sql = $this->conexion->query("SELECT * FROM personas");
        while ($objeto = $sql->fetch_object()) {
           array_push($array, $objeto);
        }
        return $array;
   }
   /* 
   public function contarEmpleados(){
    $sql = $this->conexion->query("SELECT count(*) FROM personas WHERE tipo = empleado");
    $sql = $sql->fetch_object();
    return $sql;
   }
    public function contarParticipantes(){
    $sql = $this->conexion->query("SELECT count(*) FROM personas WHERE tipo = participante");
    $sql = $sql->fetch_object();
    return $sql;
   } */
   

}
?>