<?php
class vistaModelo
{
    protected static function obtener_vista($vista)
    {

        $palabras_permitidas_n1 = ['inicio', 'usuarios' ];

        if (in_array($vista, $palabras_permitidas_n1)) {

            if (is_file("./src/views/" . $vista . ".php")) {
                $contenido = "./src/views/" . $vista . ".php";
            } else {
                $contenido = "404";
            }
        } elseif ($vista == "inicio" || $vista == "index") {
            $contenido = "inicio.php";
        } elseif ($vista == "login" ) {
            $contenido = "login";
        } elseif($vista == "UpdatePassword"){
              $contenido = "UpdatePassword";
        }else {
            $contenido = "404";
        }

        return $contenido;
    }
}
?>