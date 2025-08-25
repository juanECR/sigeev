<?php 
require_once '../library/conexion.php';

class TareaModel{
    private $conexion;
    function __construct()
    {
        $this->conexion = new Conexion;
        $this->conexion = $this->conexion->connect();
    }

    public function registrarTarea($id_evento,$id_empleado,$titulo,$descripcion,$fecha_tarea){
        $sql = $this->conexion->query("INSERT INTO tareas(evento_id,id_responsable,titulo,descripcion,fecha_tarea) VALUES ('$id_evento','$id_empleado','$titulo','$descripcion','$fecha_tarea')");
        if($sql){
          $sql = $this->conexion->insert_id;
        }else{
        $sql = 0;
        }
        return $sql;

    }
}
?>