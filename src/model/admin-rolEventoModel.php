<?php
require_once "../library/conexion.php";
class RolEvento
{
    private $conexion;
    function __construct()
    {
        $this->conexion = new Conexion();
        $this->conexion = $this->conexion->connect();
    }
    public function registrarRolEvento($nombre){
        $consulta = $this->conexion->query("INSERT INTO roles_evento (nombre) VALUES ('$nombre')");
        if ($consulta) {
            $consulta = $this->conexion->insert_id;
        } else {
            $consulta = 0;
        }
        return $consulta;
    }
    public function buscarRolEventoByNombre($nombre){
        $sql = $this->conexion->query("SELECT * FROM roles_evento WHERE nombre = '$nombre'");
        $sql = $sql->fetch_object();
        return $sql;
    }
    public function buscarRolEventoById($id){
        $sql = $this->conexion->query("SELECT * FROM roles_evento WHERE id = '$id'");
        $sql = $sql->fetch_object();
        return $sql;
    }
    public function listarTodosRoles(){
        $arrayRespuesta = array();
        $consulta = $this->conexion->query("SELECT * FROM roles_evento");
        while ($objeto = $consulta->fetch_object()) {
            array_push($arrayRespuesta, $objeto);
        }
        return $arrayRespuesta;
    }
}