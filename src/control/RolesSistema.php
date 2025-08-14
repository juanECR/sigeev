<?php 
session_start();
require_once('../model/admin-sesionModel.php');
require_once('../model/admin-rolesUsuario.php');
require_once('../model/adminModel.php');

$tipo = $_GET['tipo'];

//instanciar la clase categoria model
$objSesion = new SessionModel();
$objRolesUsuario = new RolesUsuario();
$objAdmin = new AdminModel();

//variables de sesion
$id_sesion = $_REQUEST['sesion'];
$token = $_REQUEST['token'];

//LISTAR TODOS LOS ROLES DEL SISTEMA
if($tipo == "listarRolesSistema"){
    $arr_Respuesta = array('status'=> false, 'contenido'=>'' ,'mensaje'=>'Error sesion');
    if($objSesion->verificar_sesion_si_activa($id_sesion, $token)) {
        $arr_rolesSistema = $objRolesUsuario->listarRolesdelSistema();
        /* $arr_Producto = $objProducto->obtener_productos(); */
        if (!empty($arr_rolesSistema)) {
            //recordemos que el array es para agregar las opciones de las categorias
                        for ($i=0; $i < count($arr_rolesSistema); $i++) {
                        $id_rol     = $arr_rolesSistema[$i]->id;
                        $nombre             = $arr_rolesSistema[$i]->nombre;
              /*           $opciones = '<a href="'.BASE_URL.'editarProducto/'.$id_persona.'"><button class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></button></a>
                        <button class="btn btn-danger btn-sm" onclick="eliminar_producto('.$id_persona.')"><i class="fas fa-trash-alt"></i></button>';
                        $arr_rolesSistema[$i]->options = $opciones; */
            }
            $arr_Respuesta['status'] = true;
            $arr_Respuesta['contenido'] = $arr_rolesSistema;
             $arr_Respuesta['mensaje'] = 'consulta correcta';
        }
    }
    echo json_encode($arr_Respuesta);
}

?>