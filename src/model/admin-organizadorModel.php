<?php
require_once "../library/conexion.php";

class OrganizadorModel
{

    private $conexion;
    function __construct()
    {
        $this->conexion = new Conexion();
        $this->conexion = $this->conexion->connect();
    }
    public function registrarOrganizador($tipo_documento,$nro_documento,$razon_social,$tipo,$correo,$telefono){
        $sql = $this->conexion->query("INSERT INTO organizadores (tipo_documento,nro_documento,razon_social,tipo,correo_contacto,telefono_contacto) VALUES ('$tipo_documento','$nro_documento','$razon_social','$tipo','$correo','$telefono')");
        if ($sql) {
            $sql = $this->conexion->insert_id;
        } else {
            $sql = 0;
        }
        return $sql;
    }
    public function buscarOrganizadorByCorreo($correo){
        $sql = $this->conexion->query("SELECT * FROM organizadores WHERE correo_contacto = '$correo'");
        $sql = $sql->fetch_object();
        return $sql;
    }
    public function buscarOrganizadorByNroDocumento($nro_documento){
        $sql = $this->conexion->query("SELECT * FROM organizadores WHERE nro_documento = '$nro_documento'");
        $sql = $sql->fetch_object();
        return $sql;
    }
    public function buscarOrganizadorById($id){
     $sql = $this->conexion->query("SELECT * FROM organizadores WHERE id='$id'");
     $sql = $sql->fetch_object();
     return $sql;
    }

    public function listarOrganizadoresPaginado(int $limit, int $offset){
        $respuesta = array();
        // Usamos sentencias preparadas para mayor seguridad
        $sql = $this->conexion->prepare("SELECT * FROM organizadores ORDER BY razon_social ASC LIMIT ? OFFSET ?");
        // 'ii' significa que ambos parámetros son enteros (integer)
        $sql->bind_param('ii', $limit, $offset);
        $sql->execute();
        $resultado = $sql->get_result();

        while ($objeto = $resultado->fetch_object()) {
           array_push($respuesta, $objeto);
        }
        return $respuesta;
    }

    public function contarTotalOrganizadores(){
        $sql = $this->conexion->query("SELECT COUNT(id) as total FROM organizadores");
        $resultado = $sql->fetch_object();
        return (int)$resultado->total;
    }

    public function listarTodosOrganizadores(){
        $arrOrganizadores = array();
        $sql = $this->conexion->query("SELECT * FROM organizadores ORDER BY razon_social asc");
        while ($objeto = $sql->fetch_object()) {
            array_push($arrOrganizadores, $objeto);
        }
    return $arrOrganizadores;
    }
}