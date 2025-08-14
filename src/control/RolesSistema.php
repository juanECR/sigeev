<?php 
session_start();
require_once('../model/admin-sesionModel.php');
require_once('../model/admin-rolSistemaModel.php');
require_once('../model/adminModel.php');

$tipo = $_GET['tipo'];

//instanciar la clase categoria model
$objSesion = new SessionModel();
$objUsuario = new UsuarioModel();
$objAdmin = new AdminModel();

//variables de sesion
$id_sesion = $_REQUEST['sesion'];
$token = $_REQUEST['token'];

//LISTAR TODOS LOS ROLES DEL SISTEMA
if($tipo == "listarRolesSistema"){
    $arr_Respuesta = array('status'=> false, 'contenido'=>'' ,'mensaje'=>'Error sesion');
    if($objSesion->verificar_sesion_si_activa($id_sesion, $token)) {
        $arr_Persona = $objPersona->listarPersonas();
        /* $arr_Producto = $objProducto->obtener_productos(); */
        if (!empty($arr_Persona)) {
            //recordemos que el array es para agregar las opciones de las categorias
                        for ($i=0; $i < count($arr_Persona); $i++) {
                            if($arr_Persona[$i]->genero == "M"){
                                $arr_Persona[$i]->genero = "Masculino";
                            }else if($arr_Persona[$i]->genero == "F"){
                                $arr_Persona[$i]->genero = "Femenino";
                            }
                        $id_persona      = $arr_Persona[$i]->id;
                        $dni             = $arr_Persona[$i]->dni;
                        $nombres          = $arr_Persona[$i]->nombres;
                        $apellidos         = $arr_Persona[$i]->apellidos;
                        $correo_electronico    = $arr_Persona[$i]->correo_electronico;
                        $telefono             = $arr_Persona[$i]->telefono;
                        $fecha_nacimiento     = $arr_Persona[$i]->fecha_nacimiento;
                        $genero             = $arr_Persona[$i]->genero;
                        $opciones = '<a href="'.BASE_URL.'editarProducto/'.$id_persona.'"><button class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></button></a>
                        <button class="btn btn-danger btn-sm" onclick="eliminar_producto('.$id_persona.')"><i class="fas fa-trash-alt"></i></button>';
                        $arr_Persona[$i]->options = $opciones;
            }
            $arr_Respuesta['status'] = true;
            $arr_Respuesta['contenido'] = $arr_Persona;
        }
    }
    echo json_encode($arr_Respuesta);
}

?>