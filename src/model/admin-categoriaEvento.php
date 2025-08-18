<?php
require_once "../library/conexion.php";

class CategoriaEvento
{

    private $conexion;
    function __construct()
    {
        $this->conexion = new Conexion();
        $this->conexion = $this->conexion->connect();
    }
    public function buscarCategoriaByNombre($nombre){
      $sql = $this->conexion->query("SELECT * FROM categoria_evento WHERE nombre = '$nombre'");
      $sql = $sql->fetch_object();
      return $sql;
    }
    public function registrarCategoria($nombre,$descripcion){
        $sql  = $this->conexion->query("INSERT INTO categoria_evento (nombre,descripcion) VALUES ('$nombre','$descripcion')");
        if ($sql) {
            $sql = $this->conexion->insert_id;
        } else {
            $sql = 0;
        }
        return $sql;
    }
    public function listarCategorias(){
      $arrayCategorias = array();
      $consulta = $this->conexion->query("SELECT * FROM categoria_evento");
      while ($objeto = $consulta->fetch_object()) {
           array_push($arrayCategorias, $objeto);
      }
      return $arrayCategorias;
    }

}