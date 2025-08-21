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
    public function listarParticipantesPaginado(int $limit, int $offset,$id_Evento) {
        $array = array();
        // Usamos sentencias preparadas para mayor seguridad
        $sql = $this->conexion->prepare("SELECT * FROM participantes_evento WHERE evento_id=? LIMIT ? OFFSET ?");
        // 'ii' significa que ambos parámetros son enteros (integer)
        $sql->bind_param('iii',$id_Evento, $limit, $offset);
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
    public function constarTotalParticipantes() {
        $sql = $this->conexion->query("SELECT COUNT(id) as total FROM participantes_evento");
        $resultado = $sql->fetch_object();
        return (int)$resultado->total;
    }

   }