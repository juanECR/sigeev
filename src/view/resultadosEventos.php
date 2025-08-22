<!-- ========= INICIA EL CONTENIDO DEL CUERPO DE LA PÁGINA DE EVENTOS ========= -->

<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <!-- Fila de Cabecera y Botón de Acción -->
        <div class="col-sm-12 col-xl-6">
            <div class="bg-secondary rounded h-100 p-4">
                <h2>Resultados de los eventos</h2>
                <div class="m-n2">          
                    <p>Registra, Edita o Elimina resultados de los Eventos.</p>
                    <button type="button" class="btn btn-outline-primary m-2"><i class="fa fa-home me-2"></i>Volver al inicio</button>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-xl-6">
            <div class="bg-secondary rounded h-100 p-4">
                <h6 class="mb-4">Acciones</h6>
                <div class="m-n2">
                    <button type="button" class="btn btn-outline-success m-2"><i class="fa fa-file-excel me-2"></i>Reporte</button>
                    <button type="button" class="btn btn-outline-primary m-2"><i class="fa fa-file-pdf me-2"></i>Reporte</button>
                </div>
            </div>
        </div>

        <!-- tabala eventos recientes -->
        <div class="col-12">
            <div class="bg-secondary rounded h-100 p-4">
                <h6 class="mb-4">resultados de Eventos</h6>
                <div class="table-responsive">
                    <table class="table" id="tbl_resultados">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">DNI</th>
                                <th scope="col">Nombre del participante</th>
                                <th scope="col">Puntaje</th>
                                <th scope="col">Puesto</th>
                                <th scope="col">acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tbody_tbl_resultados">
                         <!-- se llena con js-->
                        </tbody>
                    </table>
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center" id="paginacion-controles">
                            <!-- Se llenará con JS -->
                        </ul>
                    </nav>
                </div>
            </div>
        </div>

   </div>
</div>
<script>  var id_evento = <?php echo base64_decode($_GET['data']);?> </script>
<script src="<?php echo BASE_URL;?>src/view/js/admin-resultadosEvento.js"></script>