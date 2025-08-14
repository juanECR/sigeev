<?php
require_once "../library/conexion.php";
class RolesUsuario
{
    private $conexion;
    function __construct()
    {
        $this->conexion = new Conexion();
        $this->conexion = $this->conexion->connect();
    }
    //FUNCIONES SISTEMA

    public function listarRolesdelSistema(){
        $arrayroles = array();
        $sql = $this->conexion->query("SELECT * FROM roles_sistema");
        while ($objeto = $sql->fetch_object()) {
            array_push($arrayroles, $objeto);
        }
        return $arrayroles;
    }
    
    public function getRolesByUsuarioId($idUsuario)
    {
        $arrRespuesta = array();
        // Se asegura que el ID de usuario sea un entero para mitigar un poco el riesgo.
        $idUsuarioSeguro = (int) $idUsuario;
        // Consulta SQL directa uniendo las tres tablas.
        $sql = "SELECT r.nombre 
                FROM usuario_roles ur
                INNER JOIN roles_sistema r ON ur.rol_id = r.id
                WHERE ur.usuario_id = $idUsuarioSeguro";
        
        $respuesta = $this->conexion->query($sql);
        
        // El bucle while para recopilar los resultados es idéntico al de tu ejemplo.
        while ($objeto = $respuesta->fetch_object()) {
            array_push($arrRespuesta, $objeto);
        }
        
        return $arrRespuesta;
    }

}