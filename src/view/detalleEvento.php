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
                    <h4><i class="fa fa-tasks card-header-icon text-primary"></i> Detalles Logísticos</h4><hr>
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
                    <div class="person-list">
                        <!-- Empleado 1 -->
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <i class="fas fa-user-circle fa-4x text-primary"></i>
                            </div>
                            <div>
                                <h5 class="mb-0">John Doe</h5>
                                <p class="text-muted mb-0">Desarrollador Web</p>
                            </div>
                        </div><hr>
                        <!-- Empleado 2 -->
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <i class="fas fa-user-circle fa-4x text-primary"></i>
                            </div>
                            <div>
                                <h5 class="mb-0">John Doe</h5>
                                <p class="text-muted mb-0">Desarrollador Web</p>
                            </div>
                        </div><hr>
                        <!-- Empleado 3 -->
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <i class="fas fa-user-circle fa-4x text-primary"></i>
                            </div>
                            <div>
                                <h5 class="mb-0">John Doe</h5>
                                <p class="text-muted mb-0">Desarrollador Web</p>
                            </div>
                        </div><hr>
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-4 col-xl-4 p-0 m-0">
            <div class="col-12">
                <div class="bg-secondary rounded h-100 p-4">
                    <h5><i class="fa fa-sitemap text-info mr-2"></i> Organizador</h5><hr>
                    <p class="mb-1 organizador"><strong>Tech Solutions Inc.</strong></p>
                    <a href="#" style="color: var(--primary);">Contactar al organizador</a>
                </div>
            </div>
            <div class="col-12">
                <div class="bg-secondary rounded h-100 p-4">
                    <h4><i class="fa fa-users card-header-icon text-primary"></i> Participantes</h4><hr>
                    <p>Mostrando 3 de 75 registrados.</p>
                    <div class="person-list">
                        <!-- Participante 1 -->
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <i class="fas fa-user-circle fa-4x text-primary"></i>
                            </div>
                            <div>
                                <h5 class="mb-0">John Doe</h5>
                                <p class="text-muted mb-0">Desarrollador Web</p>
                            </div>
                        </div><hr>
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <i class="fas fa-user-circle fa-4x text-primary"></i>
                            </div>
                            <div>
                                <h5 class="mb-0">John Doe</h5>
                                <p class="text-muted mb-0">Desarrollador Web</p>
                            </div>
                        </div><hr>
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <i class="fas fa-user-circle fa-4x text-primary"></i>
                            </div>
                            <div>
                                <h5 class="mb-0">John Doe</h5>
                                <p class="text-muted mb-0">Desarrollador Web</p>
                            </div>
                        </div><hr>
                    </div>
                    <a href="<?php echo BASE_URL;?>participantes?data=<?php echo $_GET['data'];?>"><button class="w-100 btn btn-outline-light">Ver todos los participantes</button></a>
                </div>
            </div>
            <div class="col-12">
                <div class="bg-secondary rounded h-100 p-4">
                    <h4><i class="fa fa-cogs card-header-icon text-primary"></i> Otros</h4><hr>
                    <p>Aquí puedes gestionar el evento como editar o cancelar este evento.</p>
                    <a href="<?php echo BASE_URL;?>resultadosEventos/1"><button class="btn btn-outline-success mt-3 w-100"><i class="bi bi-bar-chart-line-fill"></i> Resultados evento</button></a>
                    <button class="btn btn-outline-light mt-3 w-100"><i class="fa fa-edit mr-2"></i> Editar Evento</button>
                    <button class="btn btn-outline-primary mt-3 w-100"><i class="fa fa-trash-alt mr-2"></i> Cancelar Evento</button>
                </div>
            </div>
        </div>
    </div>

</div>
<script src="<?php echo BASE_URL;?>src/view/js/admin_detalleEvento.js"></script>
<script> listarDetallesEvento(<?php echo base64_decode($_GET['data']);?>);</script>