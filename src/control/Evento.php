<?php 
session_start();
require_once('../model/admin-sesionModel.php');
require_once('../model/admin-eventoModel.php');
require_once('../model/admin-organizadorModel.php');
require_once('../model/adminModel.php');
require '../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

$tipo = $_GET['tipo'];

//instanciar la clase categoria model
$objSesion = new SessionModel();
$objEvento = new EventoModel();
$objOrganizador = new OrganizadorModel();
$objAdmin = new AdminModel();

//variables de sesion
$id_sesion = $_REQUEST['sesion'];
$token = $_REQUEST['token'];

if ($tipo == "listarEventosPaginado") {
    $arr_Respuesta = array('status' => false, 'contenido' => '', 'mensaje' => 'Error de sesión');
    if ($objSesion->verificar_sesion_si_activa($id_sesion, $token)) {
        $resultados_por_pagina = 10; 
        $pagina_actual = isset($_POST['pagina']) ? (int)$_POST['pagina'] : 1;
        // 2. Calcular el OFFSET para la consulta SQL
        $offset = ($pagina_actual - 1) * $resultados_por_pagina;
        // 3. Obtener el total de registros y calcular el total de páginas
        $total_eventos = $objEvento->contarTotalEventos(); 
        $total_paginas = ceil($total_eventos / $resultados_por_pagina);
        // 4. Obtener solo las personas para la página actual

        $arr_Evento = $objEvento->listarEventosPaginado($resultados_por_pagina, $offset);
        if (!empty($arr_Evento)) {
            for ($i = 0; $i < count($arr_Evento); $i++) {
                $arr_Organizador = $objOrganizador->buscarOrganizadorById($arr_Evento[$i]->organizador_id);
                $id_evento = $arr_Evento[$i]->id;
                $arr_Evento[$i]->organizador = $arr_Organizador->razon_social;
                $opciones = '<a href="' . BASE_URL . 'detalleEvento?data=' . base64_encode($id_evento) . '"><button class="btn btn-primary btn-sm"><i class="bi bi-card-checklist"></i>Detalles</button></a>';
                $arr_Evento[$i]->options = $opciones;
            }
            $arr_Respuesta['status'] = true;
            $arr_Respuesta['contenido'] = $arr_Evento;
            
            // AÑADIDO: Incluir información de la paginación en la respuesta JSON
            $arr_Respuesta['paginacion'] = [
                'pagina_actual' => $pagina_actual,
                'total_paginas' => $total_paginas
            ];
        } else {
            // Manejar el caso de que no haya resultados para esa página
            $arr_Respuesta['status'] = true; // Es un éxito, pero no hay contenido
            $arr_Respuesta['contenido'] = [];
            $arr_Respuesta['paginacion'] = ['pagina_actual' => 1, 'total_paginas' => 1];
        }
    }
    echo json_encode($arr_Respuesta);
}
if($tipo == "crearEvento"){
     $arr_Respuesta = array('status' => false, 'msg' => 'Error_Sesion');
    if ($objSesion->verificar_sesion_si_activa($id_sesion, $token)) {
        if ($_POST) {
            $titulo = strtoupper(trim($_POST['titulo']));
            $descripcion = strtolower($_POST['descripcion']);
            $categoria_id = trim($_POST['categoria']);
            $fecha_inicio = $_POST['fecha_inicio'];
            $fecha_fin = $_POST['fecha_fin'];
            $ubicacion = $_POST['ubicacion'];
            $organizador_id = trim($_POST['organizador']);

            if ($titulo =="" ||$descripcion == ""||$categoria_id== "" || $fecha_inicio == "" || $fecha_fin == "" || $ubicacion == ""|| $organizador_id == "") {
                $arr_Respuesta = array('status' => false, 'mensaje' => 'Error, campos vacíos');
            } else {
                    $id_evento = $objEvento->registrarEvento($titulo,$descripcion,$categoria_id,$fecha_inicio,$fecha_fin,$ubicacion,$organizador_id);
                    if ($id_evento > 0) {
                        $arr_Respuesta = array('status' => true, 'mensaje' => 'Evento creado');
                    } else {
                        $arr_Respuesta = array('status' => false, 'mensaje' => 'Error al Crear evento');
                    }
            }
        }
    }
    echo json_encode($arr_Respuesta);
}
if($tipo == "contarEventos"){
       $arr_Respuesta = array('status' => false, 'msg' => 'Error_Sesion');
    if ($objSesion->verificar_sesion_si_activa($id_sesion, $token)) {
        $total_eventos = $objEvento->contarTotalEventos();

        $arr_Respuesta['status'] = true;
        $arr_Respuesta['total'] = $total_eventos;
    }
    echo json_encode($arr_Respuesta);
}

if($tipo == "ImprimirReporteExel"){
       $arr_Respuesta = array('status' => false, 'mensaje' => 'Error_Sesion');
    if ($objSesion->verificar_sesion_si_activa($id_sesion, $token)) {
        $arr_Eventos = $objEvento->listarTodosEventos();
        if($arr_Eventos){
            //crear exel
            $spreadsheet = new Spreadsheet();
            $spreadsheet->getProperties()->setCreator("ByJUAN")->setLastModifiedBy("yo")->setTitle("Reporte eventos")->setDescription("Author");
            $activeWorkSheet = $spreadsheet->getActiveSheet();
            $activeWorkSheet->setTitle("Eventos");  

            $styleArray = [
                'font' => [
                    'bold' => true,
                ]
            ];
            // Aplica negrita a la fila 1 (de A1 a R1 si son 18 columnas)
            $activeWorkSheet->getStyle('A1:I1')->applyFromArray($styleArray);
            
            $headers = [
                'TITULO', 'DESCRIPCION', 'CATEGORIA', 'FECHA INICIO', 'FECHA FINALIZACION', 'UBICACION', 'ORGANIZADOR', 'ESTADO'
             ];

            // Asignar cabeceras en la fila 1
            foreach ($headers as $i => $header) {
                $columna = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($i + 1);
                $activeWorkSheet->setCellValue($columna . '1', $header);
            }

           // Llenar los datos
            $row = 2;
            foreach ($arr_Eventos as $evento) {
                $atributos = [
                    $evento->titulo ?? '',
                    $evento->descripcion ?? '',
                    $evento->categoria_evento_id ?? '',
                    $evento->fecha_inicio ?? '',
                    $evento->fecha_fin ?? '',
                    $evento->ubicacion ?? '',
                    $evento->organizador_id ?? '',
                    $evento->estado ?? ''
                ];

                foreach ($atributos as $i => $valor) {
                    $columna = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($i + 1);
                    $activeWorkSheet->setCellValue($columna . $row, $valor);
                }

                $row++;
            }
            ob_clean();
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="reporte_Eventos.xlsx"');
            header('Cache-Control: max-age=0');

            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
            exit;
        
          $arr_Respuesta = array('status' => true, 'mensaje' => 'Reporte generado');
        }else{
        $arr_Respuesta = array('status' => false, 'mensaje' => 'Fallo al obtener eventos');
        }
    }
    echo json_encode($arr_Respuesta);
}
?>