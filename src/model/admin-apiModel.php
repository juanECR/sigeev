<?php
require_once '../library/conexion.php';

class ApiModel{
    private $conexion;
    function __construct(){
      $this->conexion = new Conexion();
        $this->conexion = $this->conexion->connect();
 }

 public function buscarTokenForClient($idCliente, $token){
   $sql = $this->conexion->query("SELECT * FROM tokens_api WHERE id_cliente_api = '$idCliente' AND token = '$token'");
   $result = $sql->fetch_object();
   return $result;
 }
 public function listarEventosByOrganizadorId($organizador){
    $arrResult = array();
    $consult = $this->conexion->query("SELECT * FROM eventos WHERE organizador_id = '$organizador'");
    while ($objeto = $consult->fetch_object()) {
       array_push($arrResult,$objeto);
    }
    return $arrResult;
 }
 public function listarOrganizadores(){
   $arrResult = array();
    $consult = $this->conexion->query("SELECT * FROM organizadores");
    while ($objeto = $consult->fetch_object()) {
       array_push($arrResult,$objeto);
    }
    return $arrResult;
 }
 public function listarEventosOProximos(){
    $arrResult = array();
    $consult = $this->conexion->query("SELECT * FROM eventos");
    while ($objeto = $consult->fetch_object()) {
       array_push($arrResult,$objeto);
    }
    return $arrResult;
 }

/*  public function obtnerIdOrganizadorByNombre(){

 } */
 public function obtenercategoriasEventos(){
   $res = array();
   $sql = $this->conexion->query("SELECT * FROM categoria_evento");
   while ($objeto = $sql->fetch_object()) {
      array_push($res, $objeto);
   }
   return $res;
 }

}