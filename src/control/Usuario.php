<?php 
require_once('../model/admin-usuarioModel.php');

$tipo = $_REQUEST['tipo'];

//instanciar la clase periodo model
$objUsuario = new UsuarioModel();

if ($tipo == 'listarUsuarios') {
    $arr_Respuesta = array('status' => false, 'mensaje' => 'fallo consulta');
    $arrUsuarios = $objUsuario->listarUsuarios();
    if (!empty($arrUsuarios)) {
        $arr_Respuesta['contenido'] = $arrUsuarios;
        $arr_Respuesta['status'] = true;
        $arr_Respuesta['mensaje'] = 'listado correctamente';
    }
    echo json_encode($arr_Respuesta);
}
?>