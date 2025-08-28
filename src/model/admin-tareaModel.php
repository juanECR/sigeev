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

    public function listarTareasPaginado(int $limit, int $offset, int $id_evento) {
    $array = array();
    // Consulta con placeholders para evitar SQL Injection
    $sql = $this->conexion->prepare("
        SELECT * 
        FROM tareas 
        WHERE evento_id = ? 
        LIMIT ? OFFSET ?
    ");
    
    // 'iii' → los tres parámetros son enteros
    $sql->bind_param('iii', $id_evento, $limit, $offset);
    
    $sql->execute();
    $resultado = $sql->get_result();

    while ($objeto = $resultado->fetch_object()) {
        $array[] = $objeto; // equivalente a array_push
    }

    return $array;
    }

    public function contarTotalTareas($id_evento) {
        $sql = $this->conexion->query("SELECT COUNT(id) as total FROM tareas WHERE evento_id = '$id_evento'");
        $resultado = $sql->fetch_object();
        return (int)$resultado->total;
    }
public function eliminarTarea($id_tarea){
    $sql = "DELETE FROM tareas WHERE id = ?";
    $stmt = $this->conexion->prepare($sql);
    if ($stmt === false) {
        return 0;
    }

    $stmt->bind_param("i", $id_tarea);
    if ($stmt->execute()) {
        return 1;
    } else {
        return 0;
    }
    $stmt->close();
}
}
?>