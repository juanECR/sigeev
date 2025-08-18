<?php 
session_start();
require_once('../model/admin-sesionModel.php');
require_once('../model/admin-categoriaEvento.php');
require_once('../model/adminModel.php');

$tipo = $_GET['tipo'];

//instanciar la clase categoria model
$objSesion = new SessionModel();
$objCategoria = new CategoriaEvento();
$objAdmin = new AdminModel();

//variables de sesion
$id_sesion = $_REQUEST['sesion'];
$token = $_REQUEST['token'];

if($tipo == "registrarCategoria"){
    $arr_Respuesta = array('status' => false, 'msg' => 'Error_Sesion');
    if ($objSesion->verificar_sesion_si_activa($id_sesion, $token)) {
        if ($_POST) {
            $nombre = trim(strtoupper($_POST['nombre']));
            $descripcion = $_POST['descripcion'];

            if ($nombre =="" ||$descripcion == "") {
                $arr_Respuesta = array('status' => false, 'mensaje' => 'Error, campos vacíos');
            } else {
                $arrCategoria = $objCategoria->buscarCategoriaByNombre($nombre);
                if ($arrCategoria) {
                    $arr_Respuesta = array('status' => false, 'mensaje' => 'Registro Fallido, Categoria ya existe');
                } else {
                    $id_new_categoria = $objCategoria->registrarCategoria($nombre,$descripcion);
                    if ($id_new_categoria > 0) {
                        $arr_Respuesta = array('status' => true, 'mensaje' => 'Registro Exitoso');
                    } else {
                        $arr_Respuesta = array('status' => false, 'mensaje' => 'Error al registrar categoria');
                    }
                }
            }
        }
    }
    echo json_encode($arr_Respuesta);
}

if($tipo == "listarCategorias"){
    $arr_Respuesta = array('status' => false, 'msg' => 'Error_Sesion');
    if ($objSesion->verificar_sesion_si_activa($id_sesion, $token)) {
            $arr_Categorias = $objCategoria->listarCategorias();
            if(!empty($arr_Categorias)){
            $arr_Respuesta['contenido'] = $arr_Categorias;
            $arr_Respuesta['status'] = true;
            $arr_Respuesta['msg'] = 'consulta correcta';   
            }
            
    }
    echo json_encode($arr_Respuesta);
}

?>