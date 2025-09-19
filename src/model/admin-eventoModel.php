<?php
require_once "../library/conexion.php";

class EventoModel{
   private $conexion;
   function __construct(){
    $this->conexion = new Conexion;
    $this->conexion = $this->conexion->connect();
   }

   public function registrarEvento($titulo,$descripcion,$categoria,$fecha_inicio,$fecha_fin,$ubicacion,$organizador){
    $sql = $this->conexion->query("INSERT INTO eventos(titulo,descripcion,categoria_evento_id,fecha_inicio,fecha_fin,ubicacion,organizador_id) VALUES ('$titulo','$descripcion','$categoria','$fecha_inicio','$fecha_fin','$ubicacion','$organizador')");
    if($sql){
       $sql = $this->conexion->insert_id;
    }else{
     $sql = 0;
    }
    return $sql;
   }
   public function listarTodosEventos(){
      $array = array();
      $sql = $this->conexion->query("SELECT * FROM eventos");
      while ($objeto = $sql->fetch_object()) {
         array_push($array, $objeto);
      }
      return $array;
   }

  public function listarEventosPaginado(int $limit, int $offset) {
        $array = array();
        // Usamos sentencias preparadas para mayor seguridad
        $sql = $this->conexion->prepare("SELECT * FROM eventos ORDER BY fecha_inicio ASC LIMIT ? OFFSET ?");
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
   public function buscarEventoById($id){
       $consulta = $this->conexion->query("SELECT * FROM eventos WHERE id='$id'");
       $consulta = $consulta->fetch_object();
       return $consulta;
    }
   public function actualizarEvento($id_evento,$titulo,$descripcion,$categoria_id,$fecha_inicio,$fecha_fin,$ubicacion,$organizador_id,$estado){
      $sql = $this->conexion->prepare("UPDATE eventos SET titulo =?,descripcion =?,categoria_evento_id=?,fecha_inicio=?,fecha_fin=?,ubicacion=?,organizador_id=?,estado=? WHERE id = ?");
      $sql->bind_param('ssisssisi',$titulo,$descripcion,$categoria_id,$fecha_inicio,$fecha_fin,$ubicacion,$organizador_id,$estado,$id_evento);
      if (!$sql->execute()) {
        throw new Exception("Error al ejecutar la consulta: " . $sql->error);
      }
      $filasAfectadas = $sql->affected_rows;
      $sql->close();

      return $filasAfectadas > 0;
   }
   public function cancelarEvento($id_Evento){
     $sql = $this->conexion->prepare("UPDATE eventos SET estado = 'cancelado' WHERE id=?");
     $sql->bind_param('i',$id_Evento);
     if(!$sql->execute()){
      throw new Exception("Error al ejecutar la consulta: " . $sql->error);
     }
     $filasAfectadas = $sql->affected_rows;
     $sql->close();

     return $filasAfectadas > 0;
   }
}
?>