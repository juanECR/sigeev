<?php
require_once '../library/conexion.php';

class ClienteApiModel{
    private $conexion;
    function __construct(){
      $this->conexion = new Conexion();
        $this->conexion = $this->conexion->connect();
 }
 public function registrarCliente(){

 }
}
?>