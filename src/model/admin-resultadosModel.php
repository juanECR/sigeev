<?php 
require_once "../library/conexion.php";

class ResultadoEvento{
   private $conexion;
   function __construct(){
        $this->conexion = new Conexion();
        $this->conexion = $this->conexion->connect();
   }
   public function asignarPosicion($evento_id,$participante_id,$puntaje,$posicion){
        $consulta = $this->conexion->query("INSERT INTO resultados_evento (evento_id,participante_id,puntaje,puesto) VALUES ('$evento_id','$participante_id','$puntaje','$posicion')");
        if ($consulta) {
            $consulta = $this->conexion->insert_id;
        } else {
            $consulta = 0;
        }
        return $consulta;
   }
   public function buscarPosicionByEvento($id_evento,$posicion){
     $sql = $this->conexion->query("SELECT * FROM resultados_evento WHERE evento_id = '$id_evento' AND puesto = '$posicion'");
     $sql = $sql->fetch_object();
     return $sql;
   }
   public function listarResultadosPaginado(int $limit, int $offset, int $id_evento) {
    $array = array();
    
    // Consulta con placeholders para evitar SQL Injection
    $sql = $this->conexion->prepare("
        SELECT * 
        FROM resultados_evento 
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


    /**
     * NUEVO: Esta función cuenta el total de registros en la tabla.
     * Es esencial para calcular el número total de páginas.
     */
    public function contarTotalResultados() {
        $sql = $this->conexion->query("SELECT COUNT(id) as total FROM resultados_Evento");
        $resultado = $sql->fetch_object();
        return (int)$resultado->total;
    }
}