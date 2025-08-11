<?php 
require_once "../library/conexion.php";

class personaModel{
   private $conexion;
   function __construct(){
        $this->conexion = new Conexion();
        $this->conexion = $this->conexion->connect();
   }

   public function listarPersonas(){
        $array = array();
        $sql = $this->conexion->query("SELECT * FROM usuarios WHERE correo='$correo'");
        while ($objeto = $sql->fetch_object()) {
           array_push($array, $objeto);
        }
        return $array;
   }
   public function contarEmpleados(){
    $sql = $this->conexion->query("SELECT count(*) FROM personas WHERE tipo = empleado");
    $sql = $sql->fetch_object();
    return $sql;
   }
    public function contarParticipantes(){
    $sql = $this->conexion->query("SELECT count(*) FROM personas WHERE tipo = participante");
    $sql = $sql->fetch_object();
    return $sql;
   }
   

}
?>