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
public function listarParticipantesPaginado(int $limit, int $offset, int $id_evento) {
    $array = array();
    
    // Consulta con placeholders para evitar SQL Injection
    $sql = $this->conexion->prepare("
        SELECT * 
        FROM participantes_evento 
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
    public function constarTotalParticipantes() {
        $sql = $this->conexion->query("SELECT COUNT(id) as total FROM participantes_evento");
        $resultado = $sql->fetch_object();
        return (int)$resultado->total;
    }

    public function listarAlungunosParticipantes(int $id_evento,int $numeroListar){
       $arrRespuesta = array();

       $stmt = $this->conexion->prepare("SELECT * FROM participantes_evento WHERE evento_id = ? LIMIT ?");
       $stmt->bind_param("ii",$id_evento,$numeroListar);

       $stmt->execute();
       $resultado = $stmt->get_result();
       while ($objeto = $resultado->fetch_object()) {
         array_push($arrRespuesta,$objeto);
       }
       $stmt->close();
       return $arrRespuesta;
    }

   }