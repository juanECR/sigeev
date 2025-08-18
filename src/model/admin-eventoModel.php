<?php
require_once "../library/conexion.php";

class EventoModel{
   private $conexion;
   function __construct(){
    $this->conexion = new Conexion;
    $this->conexion = $this->conexion->connect();
   }

   public function registrarEvento(){
    $sql = $this->conexion->query("INSERT INTO eventos(titulo,descripcion,categoria_evento_id,fecha_inicio,fecha_fin,ubicacion,organizador_id) VALUES ('$titulo','$descripcion','$categoria','$fecha_inicio','$fecha_fin','$ubicacion','$organizador')");
    if($sql){
       $this->$sql->insert_id;
    }else{
     $sql = 0;
    }
    return $sql;

   }

  public function listarEventosPaginado(int $limit, int $offset) {
        $array = array();
        // Usamos sentencias preparadas para mayor seguridad
        $sql = $this->conexion->prepare("SELECT * FROM eventos LIMIT ? OFFSET ?");
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
    public function contarTotalEventos() {
        $sql = $this->conexion->query("SELECT COUNT(id) as total FROM eventos");
        $resultado = $sql->fetch_object();
        return (int)$resultado->total;
    }
}
?>