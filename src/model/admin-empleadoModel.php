<?php
require_once "../library/conexion.php";
class EmpleadoModel{
   private $conexion;
   function __construct(){
    $this->conexion = new Conexion;
    $this->conexion = $this->conexion->connect();
   }
 public function registrarEmpleado($dni,$nombre,$apellido,$correo,$telefono,$fecha_nacimiento,$genero){
      $sql = $this->conexion->query("INSERT INTO empleados (dni,nombres,apellidos,correo_electronico,telefono,fecha_nacimiento,genero) VALUES ('$dni','$nombre','$apellido','$correo','$telefono','$fecha_nacimiento','$genero')");
        if ($sql) {
            $sql = $this->conexion->insert_id;
        } else {
            $sql = 0;
        }
        return $sql;
 }
    public function buscarEmpleadoByCorreo($correo){
      $sql = $this->conexion->query("SELECT * FROM empleados WHERE correo_electronico='$correo'");
      $sql = $sql->fetch_object();
      return $sql;
   }
   public function buscarEmpleadoByDni($dni){
      $sql = $this->conexion->query("SELECT * FROM empleados WHERE dni='$dni'");
      $sql = $sql->fetch_object();
      return $sql;
   }
   public function buscarEmpleadoById($id){
      $sql = $this->conexion->query("SELECT * FROM empleados WHERE id='$id'");
      $sql = $sql->fetch_object();
      return $sql;
   }
  public function listarEmpleadosPaginado(int $limit, int $offset) {
        $array = array();
        // Usamos sentencias preparadas para mayor seguridad
        $sql = $this->conexion->prepare("SELECT * FROM empleados ORDER BY nombres ASC LIMIT ? OFFSET ?");
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
    public function contarTotalEmpleados() {
        $sql = $this->conexion->query("SELECT COUNT(id) as total FROM empleados");
        $resultado = $sql->fetch_object();
        return (int)$resultado->total;
    }
}