<!-- ========= INICIA EL CONTENIDO DEL CUERPO DE LA PÁGINA DE EVENTOS ========= -->

<div class="container-fluid pt-4 px-4">
    <h2 class="page-title"><i class="fa fa-calendar-check text-primary mr-2"></i> Conferencia Anual de Tecnología Web</h2>
    <div class="row m-0">
        <div class="row g-4 col-xl-8 p-0 m-0">
            <!-- Fila de Cabecera y Botón de Acción -->
            <div class="col-12">
                <div class="bg-secondary rounded h-100 p-4">
                    <h4><i class="fa fa-info-circle card-header-icon text-primary"></i> Descripción del Evento</h4><hr>
                    <p id="descripcion_evento">
                        Únete a nosotros en la Conferencia Anual de Tecnología Web, el principal evento para desarrolladores, diseñadores y profesionales de la tecnología. Este año, nos centraremos en las últimas tendencias en desarrollo full-stack, la inteligencia artificial en aplicaciones web y el futuro de las interfaces de usuario.
                    </p>
                </div>
            </div>
            <div class="col-12">
                <div class="bg-secondary rounded h-100 p-4">
                    <h4><i class="fa fa-tasks card-header-icon text-primary"></i>Detalles Logísticos</h4><hr>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <h5><i class="fa fa-calendar-alt text-info mr-2"></i> Fechas</h5><hr>
                            <p class="mb-1 f_inicio"><strong>Inicio:</strong> Lunes, 15 de Noviembre, 2025</p>
                            <p class="f_fin"><strong>Finaliza:</strong> Miércoles, 17 de Noviembre, 2025</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h5><i class="fa fa-map-marker-alt text-info mr-2"></i> Ubicación</h5><hr>
                            <p class="mb-1 ubicacion"><strong>Centro de Convenciones Metropolitano</strong></p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-12">
                <div class="bg-secondary rounded h-100 p-4">
                    <h4><i class="fa fa-user-shield card-header-icon text-primary"></i> Personal Asignado</h4><hr>
                    <div class="person-list-asigned">
                        <!-- Empleados js  listra 3 empleados para diseño-->
                    </div>
                     <a href="<?php echo BASE_URL;?>tareas?data=<?php echo $_GET['data'];?>"><button class="w-100 btn btn-outline-light">Gestionar Asignacion de empleados</button></a>
                </div>
            </div>
        </div>
        <div class="row g-4 col-xl-4 p-0 m-0">
            <div class="col-12">
                <div class="bg-secondary rounded h-100 p-4">
                    <h5><i class="fa fa-sitemap text-info mr-2"></i> Organizador</h5><hr>
                    <p class="mb-1 organizador"><strong>Tech Solutions Inc.</strong></p>
                    <a href="tel:+51999999999" style="color: var(--primary);">Contactar al organizador</a>
                </div>
            </div>
            <div class="col-12">
                <div class="bg-secondary rounded h-100 p-4">
                    <h4><i class="fa fa-users card-header-icon text-primary"></i> Participantes</h4><hr>
                    <p>Mostrando 3 registrados.</p>
                    <div class="person-list">
                        <!-- javascript -->
<!--                         <div class="d-flex align-items-center">
                            <div class="me-3">
                                <i class="fas fa-user-circle fa-4x text-primary"></i>
                            </div>
                            <div>
                                <h5 class="mb-0">John Doe</h5>
                                <p class="text-muted mb-0">Desarrollador Web</p>
                            </div>
                        </div><hr> -->
                    </div>
                    <a href="<?php echo BASE_URL;?>participantes?data=<?php echo $_GET['data'];?>"><button class="w-100 btn btn-outline-light">Ver todos los participantes</button></a>
                </div>
            </div>
            <div class="col-12">
                <div class="bg-secondary rounded h-100 p-4">
                    <h4><i class="fa fa-cogs card-header-icon text-primary"></i> Otros</h4><hr>
                    <p>Aquí puedes gestionar el evento como editar o cancelar este evento.</p>
                    <a href="<?php echo BASE_URL;?>resultadosEventos?data=<?php echo $_GET['data'];?>"><button class="btn btn-outline-success mt-3 w-100"><i class="bi bi-bar-chart-line-fill"></i> Resultados evento</button></a>
                    <button class="btn btn-outline-light mt-3 w-100" data-bs-toggle="modal" data-bs-target="#modalEditarEvento"><i class="fa fa-edit mr-2"></i> Editar Evento</button>
                    <button class="btn btn-outline-primary mt-3 w-100"><i class="fa fa-trash-alt mr-2"></i> Cancelar Evento</button>
                </div>
            </div>
            <!--modal editar evento-->
            <div class="modal fade" id="modalEditarEvento" tabindex="-1" aria-labelledby="modalEditarEventoLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content bg-secondary">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="modalEditarEventoLabel">Actualizar evento</h1>
                            <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="frm_editar_evento">
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
                                <div class="mb-3">
                                    <label for="estado" class="form-label">Estado:</label>
                                    <select class="form-select" name="estado" id="estado" required>
                                    <option value="">Seleccione estado</option>
                                    <option value="programado">programado</option>
                                    <option value="en curso">en curso</option>
                                    <option value="finalizado">finalizado</option>
                                    <option value="cancelado">cancelado</option>
                                    </select>
                                </div>
                                <div class="text-center g-2">                             
                                    <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal" >Cancelar</button>  
                                    <button type="button" class="btn btn-outline-primary" onclick="editarEvento();">Actualizar</button> 
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<script>  var id_evento = <?php echo base64_decode($_GET['data']);?> </script>
<script src="<?php echo BASE_URL;?>src/view/js/admin_detalleEvento.js"></script>