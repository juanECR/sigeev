<!-- ========= INICIA EL CONTENIDO DEL CUERPO DE LA PÁGINA DE EVENTOS ========= -->

<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <!-- Fila de Cabecera y Botón de Acción -->
        <div class="col-sm-12 col-xl-6">
            <div class="bg-secondary rounded h-100 p-4">
                <h2>Gestión de eventos</h2>
                <div class="m-n2">          
                    <p>Registra, Edita o Elimina Eventos.</p>
                    <a href="<?php echo BASE_URL;?>"><button type="button" class="btn btn-outline-primary m-2"><i class="fa fa-home me-2"></i>Volver al inicio</button></a>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-xl-6">
            <div class="bg-secondary rounded h-100 p-4">
                <h6 class="mb-4">Acciones</h6>
                <div class="m-n2">
                    <button type="button" class="btn btn-outline-primary m-2" data-bs-toggle="modal" data-bs-target="#modalCrearEvento"><i class="fa fa-plus me-2"></i>Crear Evento</button>
                    <button type="button" class="btn btn-outline-success m-2" onclick="generarReporteExel();"><i class="fa fa-file-excel me-2"></i>Reporte</button>
                    <button type="button" class="btn btn-outline-primary m-2"><i class="fa fa-file-pdf me-2"></i>Reporte</button>
                    <button type="button" class="btn btn-outline-info m-2" data-bs-toggle="modal" data-bs-target="#modalNuevoCategoria"><i class="fa fa-plus me-2"></i>Nuevo Categoria</button>
                </div>
            </div>
        </div>
         <!--modal crear de evento-->
        <div class="modal fade" id="modalCrearEvento" tabindex="-1" aria-labelledby="modalCrearEventoLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content bg-secondary">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalCrearEventoLabel">Crear nuevo evento</h1>
                        <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="frm_nuevo_evento">
                            <div class="mb-3">
                                <label for="titulo" class="form-label">Titulo</label>
                                <input type="text" class="form-control" name="titulo" id="titulo" placeholder="Ingrese El Titulo del evento" required>
                            </div>  
                            <div class="mb-3">
                                <label for="descripcion" class="form-label">Descripción</label>
                                <textarea class="form-control" name="descripcion" id="descripcion" placeholder="Ingrese detalles del evento"></textarea>
                            </div> 
                            <div class="mb-3">
                                <label for="categoria" class="form-label">Categoria:</label>
                                <select class="form-select" name="categoria" id="categoria" required>
                                <option value="">Seleccione una Categoria</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="fecha_inicio" class="form-label">Fecha Inicio:</label>
                                <input type="datetime-local" class="form-control" name="fecha_inicio" id="fecha_inicio" required>
                            </div>     
 
                            <div class="mb-3">
                                <label for="fecha_fin" class="form-label">Fecha Finalización:</label>
                                <input type="datetime-local" class="form-control" name="fecha_fin" id="fecha_fin" required>
                            </div> 
                            <div class="mb-3">
                                <label for="ubicacion" class="form-label">Ubicación:</label>
                                <input type="text" class="form-control" name="ubicacion" id="ubicacion" placeholder="Ingrese la ubicacion del evento" required>
                            </div>
                            <div class="mb-3">
                                <label for="organizador" class="form-label">Organizador:</label>
                                <select class="form-select" name="organizador" id="organizador" required>
                                <option value="">Seleccione Organizador</option>
                                </select>
                            </div>
                            <div class="text-center g-2">                             
                                <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal" >Cancelar</button>  
                                <button type="button" class="btn btn-outline-primary" onclick="CrearEvento();">Registrar</button> 
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
         <!--modal registrar categoria de evento-->
        <div class="modal fade" id="modalNuevoCategoria" tabindex="-1" aria-labelledby="modalNuevoCategoriaLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content bg-secondary">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalNuevoCategoriaLabel">Nueva Categoria de Evento</h1>
                        <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="frm_nuevaCategoriaEvento">
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre de la categoria:</label>
                                <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Ingrese El Nombre de la Categorias" required>
                            </div>  
                            <div class="mb-3">
                                <label for="Descripcion" class="form-label">Descripción:</label>
                                <textarea class="form-control" name="descripcion" id="descripcion" placeholder="Describa el tipo de evento"></textarea>
                            </div>                
                            <div class="text-center g-2">                             
                                <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal" >Cancelar</button>  
                                <button type="button" class="btn btn-outline-primary" onclick="registrarNuevaCategoria();" >Registrar</button> 
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- tabala eventos recientes -->
        <div class="col-12">
            <div class="bg-secondary rounded h-100 p-4">
                <h6 class="mb-4 text-secondary">Eventos pendientes</h6>
                <div class="table-responsive">
                    <table class="table" id="tbl_eventos">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Titulo</th>
                                <th scope="col">Fecha inicio</th>
                                <th scope="col">Fecha fin</th>
                                <th scope="col">Ubicación</th>
                                <th scope="col">Organizador</th>
                                <th scope="col">Estado</th>
                                <th scope="col">accion</th>
                            </tr>
                        </thead>
                        <tbody id="tbody_tbl_eventos">
                        <!-- Esto se llena con js-->
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
<script src="<?php echo BASE_URL;?>src/view/js/admin_evento.js"></script>