<?php
require_once '../library/conexion.php';

class ApiModel{
    private $conexion;
    function __construct(){
      $this->conexion = new Conexion();
        $this->conexion = $this->conexion->connect();
 }

 public function listarEventosByOrganizador($organizador){
    $arrResult = array();
    $consult = $this->conexion->query("SELECT * FROM eventos WHERE organizador_id = '$organizador'");
    while ($objeto = $consult->fetch_object()) {
       array_push($arrResult,$objeto);
    }
    return $arrResult;
 }

}