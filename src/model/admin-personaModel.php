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
      $sql = $this->conexion->prepare("SELECT * FROM personas WHERE correo_electronico=?");
      $sql->bind_param('s',$correo);
      $sql->execute();
      $result = $sql->get_result();
      $result = $result->fetch_object();
      return $result;
   }
   public function buscarPersonaByDni($dni){
      $sql = $this->conexion->prepare("SELECT * FROM personas WHERE dni=?");
      $sql->bind_param('i',$dni);
      $sql->execute();
      $result = $sql->get_result();
      $result = $result->fetch_object();
      return $result;
   }
   public function buscarPersonaById($id){
      $sql = $this->conexion->query("SELECT * FROM personas WHERE id='$id'");
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

    public function listarPersonasPaginado(int $limit, int $offset) {
        $array = array();
        // Usamos sentencias preparadas para mayor seguridad
        $sql = $this->conexion->prepare("SELECT * FROM personas ORDER BY nombres ASC LIMIT ? OFFSET ?");
        // 'ii' significa que ambos parámetros son enteros (integer)
        $sql->bind_param('ii', $limit, $offset);
        $sql->execute();
        $resultado = $sql->get_result();

        while ($objeto = $resultado->fetch_object()) {
           array_push($array, $objeto);
        }
        return $array;
    }

    /**
     * NUEVO: Esta función cuenta el total de registros en la tabla.
     * Es esencial para calcular el número total de páginas.
     */
    public function contarTotalPersonas() {
        $sql = $this->conexion->query("SELECT COUNT(id) as total FROM personas");
        $resultado = $sql->fetch_object();
        return (int)$resultado->total;
    }

    public function eliminarPersonaById($id_persona){
      $sql = $this->conexion->query("DELETE FROM personas WHERE `personas`.`id` = $id_persona");
      // Verificamos si la eliminación fue exitosa
      if ($this->conexion->affected_rows > 0) {
         return true; 
      } else {
         return false;
      }
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