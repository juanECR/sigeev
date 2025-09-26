<?php
require_once '../library/conexion.php';

class ClienteApiModel{
    private $conexion;
    function __construct(){
      $this->conexion = new Conexion();
        $this->conexion = $this->conexion->connect();
 }
 public function registrarCliente($ruc,$razon_social,$correo,$telefono){
        $sql = $this->conexion->query("INSERT INTO client_api (ruc,razon_social,telefono,correo) VALUES ('$ruc','$razon_social','$telefono','$correo')");
        if ($sql) {
            $sql = $this->conexion->insert_id;
        } else {
            $sql = 0;
        }
        return $sql;
 }
 public function buscarClienteApiByRuc($ruc){
      $sql = $this->conexion->prepare("SELECT * FROM client_api WHERE ruc=?");
      $sql->bind_param('i',$ruc);
      $sql->execute();
      $result = $sql->get_result();
      $result = $result->fetch_object();
      return $result;
 }
   public function contarTotalClientes() {
        $sql = $this->conexion->query("SELECT COUNT(id) as total FROM client_api");
        $resultado = $sql->fetch_object();
        return (int)$resultado->total;
    }
        public function listarClientesApiPaginado(int $limit, int $offset) {
        $array = array();
        $sql = $this->conexion->prepare("SELECT * FROM client_api LIMIT ? OFFSET ?");
        // 'ii' significa que ambos parámetros son enteros (integer)
        $sql->bind_param('ii', $limit, $offset);
        $sql->execute();
        $resultado = $sql->get_result();

        while ($objeto = $resultado->fetch_object()) {
           array_push($array, $objeto);
        }
        return $array;
    }
}
?>