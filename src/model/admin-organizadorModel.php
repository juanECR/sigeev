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
    public function registrarOrganizador($documento,$razon_social,$tipo,$correo,$telefono){
        $sql = $this->conexion->query("INSERT INTO organizadores (documento,nombre,tipo,correo_contacto,telefono_contacto) VALUES ('$documento','$razon_social','$tipo','$correo','$telefono')");
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
    public function buscarOrganizadorByDocumento($documento){
        $sql = $this->conexion->query("SELECT * FROM organizadores WHERE documento = '$documento'");
        $sql = $sql->fetch_object();
        return $sql;
    }
}