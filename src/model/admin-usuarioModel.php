<?php
require_once "../library/conexion.php";

class UsuarioModel
{

    private $conexion;
    function __construct()
    {
        $this->conexion = new Conexion();
        $this->conexion = $this->conexion->connect();
    }
    public function buscarUsuarioByPersonaId($idPersona){
        $sql = $this->conexion->query("SELECT * FROM usuarios WHERE persona_id='$idPersona'");
        $sql = $sql->fetch_object();
        return $sql;
    }
    public function registrarUsuario($persona_id, $password)
    {
        $sql = $this->conexion->query("INSERT INTO usuarios (persona_id, password) VALUES ('$persona_id','$password')");
        if ($sql) {
            $sql = $this->conexion->insert_id;
        } else {
            $sql = 0;
        }
        return $sql;
    }

    public function listarUsuariosPaginados(int $limit, int $offset) {
        $array = array();
        $sql = $this->conexion->prepare("SELECT * FROM usuarios LIMIT ? OFFSET ?");
        // 'ii' significa que ambos parámetros son enteros (integer)
        $sql->bind_param('ii', $limit, $offset);
        $sql->execute();
        $resultado = $sql->get_result();

        while ($objeto = $resultado->fetch_object()) {
           array_push($array, $objeto);
        }
        return $array;
    }
    
    public function contarTotalUsuarios() {
        $sql = $this->conexion->query("SELECT COUNT(id) as total FROM usuarios");
        $resultado = $sql->fetch_object();
        return (int)$resultado->total;
    }
    public function buscarUsuarioById($id)
    {
        $sql = $this->conexion->query("SELECT * FROM usuarios WHERE id='$id'");
        $sql = $sql->fetch_object();
        return $sql;
    }
    public function UpdateResetPassword($id, $token,  $estado){
        $sql = $this->conexion->prepare("UPDATE usuarios SET token_password =?, reset_password=? WHERE id =?");
        if(!$sql){return false;}
        $sql->bind_param('sii',$token, $estado, $id);
        $resultado = $sql->execute();
        $sql->close();
        return $resultado;
    }
    public function actualizarPassword($id, $password){
    $stmt = $this->conexion->prepare("UPDATE usuarios SET password = ? WHERE id = ?");
    if (!$stmt) {return false;}
    $stmt->bind_param("si", $password, $id);
    $resultado = $stmt->execute();
    $stmt->close();
    return $resultado;
    }







    //en deshuso
    public function actualizarUsuario($id, $dni, $nombres_apellidos, $correo, $telefono, $estado)
    {
        $sql = $this->conexion->query("UPDATE usuarios SET dni='$dni',nombres_apellidos='$nombres_apellidos',correo='$correo',telefono='$telefono',estado ='$estado' WHERE id='$id'");
        return $sql;
    }
    public function buscarUsuarioByDni($dni)
    {
        $sql = $this->conexion->query("SELECT * FROM usuarios WHERE dni='$dni'");
        $sql = $sql->fetch_object();
        return $sql;
    }
   //buscar usuarios activos ordenadamente
    public function buscarUsuariosOrdenados()
    {
        $arrRespuesta = array();
        $sql = $this->conexion->query("SELECT * FROM usuarios WHERE estado='1' ORDER BY nombres_apellidos ASC ");
        while ($objeto = $sql->fetch_object()) {
            array_push($arrRespuesta, $objeto);
        }
        return $arrRespuesta;
    }

}