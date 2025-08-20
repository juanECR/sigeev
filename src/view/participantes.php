<!-- ========= INICIA EL CONTENIDO DEL CUERPO DE LA PÁGINA DE EVENTOS ========= -->

<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <!-- Fila de Cabecera y Botón de Acción -->
        <div class="col-sm-12 col-xl-6">
            <div class="bg-secondary rounded h-100 p-4">
                <h2>Gestión de Participantes</h2>
                <div class="m-n2">          
                    <p>Registra, edita o elimina Personas del evento seleccionado.</p>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-xl-6">
            <div class="bg-secondary rounded h-100 p-4">
                <h6 class="mb-4">Acciones</h6>
                <div class="m-n2">
                    <button type="button" class="btn btn-outline-primary m-2" data-bs-toggle="modal" data-bs-target="#modalNuevoParticipante"><i class="fa fa-plus me-2"></i> Registrar</button>
                    <button type="button" class="btn btn-outline-success m-2"><i class="fa fa-file-excel me-2"></i>Reporte .xls</button>
                    <button type="button" class="btn btn-outline-primary m-2"><i class="fa fa-file-pdf me-2"></i>Reporte .pdf</button>
                    <button type="button" class="btn btn-outline-primary m-2" data-bs-toggle="modal" data-bs-target="#modalNuevoRolParticipante"><i class="fa fa-plus me-2"></i>Nuevo rol de participante</button>
                </div>
            </div>
        </div>
        <!--modal registrar rol de participante-->
        <div class="modal fade" id="modalNuevoRolParticipante" tabindex="-1" aria-labelledby="modalNuevoRolParticipanteLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content bg-secondary">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalNuevoRolParticipanteLabel"><i class="fas fa-address-book text-primary"></i> Nuevo rol de Evento</h1>
                        <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="frm_nuevo_rol_participante">
                            <div class="mb-3">
                                <label for="NewRolEvento" class="form-label">Nombre del nuevo Rol:</label>
                                <input type="text" class="form-control" name="NewRolEvento" id="NewRolEvento" placeholder="Ingrese Nuevo Rol" required>
                            </div>
                            <div class="text-center g-2">                             
                                <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal" >Cancelar</button>  
                                <button type="button" class="btn btn-outline-primary" onclick="registrarNuevoRolEvento();" >Registrar</button> 
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--modal registrar participante-->
        <div class="modal fade" id="modalNuevoParticipante" tabindex="-1" aria-labelledby="modalNuevoParticipanteLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content bg-secondary">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalNuevoParticipanteLabel"><i class="fa fa-user me-2 text-primary"></i>Nuevo Participante</h1>
                        <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="frm_nuevo_persona">
                            <input type="hidden" value="<?php echo base64_decode($_GET['data'])?>"><!-- data = id evnt-->
                            <div class="mb-3">
                                <label for="dni" class="form-label">Dni:</label>
                                <input type="number" class="form-control" name="dni" id="dni" placeholder="Ingrese su dni" required>
                            </div>
                            <div class="mb-3">
                                <label for="nombres" class="form-label">Nombres</label>
                                <input type="text" class="form-control" name="nombres" id="nombres" placeholder="Ingrese sus nombres" required>
                            </div>
                            <div class="mb-3">
                                <label for="apellidos" class="form-label">Apellidos:</label>
                                <input type="text" class="form-control" name="apellidos" id="apellidos" placeholder="Ingrese sus apellidos" required>
                            </div>
                            <div class="mb-3">
                                <label for="correo" class="form-label">Correo electrónico</label>
                                <input type="email" class="form-control" name="correo" id="correo" placeholder="ejemplo@correo.com" required>
                            </div>
                            <div class="mb-3">
                                <label for="telefono" class="form-label">Teléfono</label>
                                <input type="number" class="form-control" name="telefono" id="telefono" placeholder="Ingerese su telefono" required>
                            </div>
                            <div class="mb-3">
                                <label for="fecha_nacimiento" class="form-label">Fecha de nacimiento</label>
                                <input type="date" class="form-control" name="fecha_nacimiento" id="fecha_nacimiento" placeholder="Ingrese su fecha de nacimiento" required>
                            </div>
                            <div class="mb-3">
                                <label for="genero" class="form-label">Género</label>
                                <select class="form-select" name="genero" id="genero" required>
                                <option value="">Seleccione un genero</option>
                                <option value="M">Masculino</option>
                                <option value="F">Femenino</option>
                                <option value="Otro">Otro</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="rolEvento" class="form-label">Rol</label><!--listar roles con js-->
                                <select class="form-select" name="rolEvento" id="rolEvento" required>
                                <option value="">Seleccione un rol</option>
                                </select>
                            </div>
                            <div class="text-center g-2">                             
                                <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal" >Cancelar</button>  
                                <button type="button" class="btn btn-outline-primary" onclick="funcion();" >Registrar</button> 
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- tabala eventos recientes -->
        <div class="col-12">
            <div class="bg-secondary rounded h-100 p-4">
                <h6 class="mb-4">Eventos pendientes</h6>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">First Name</th>
                                <th scope="col">Last Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Country</th>
                                <th scope="col">ZIP</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                           <!-- esto se llena con js-->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

   </div>
</div>
<script src="<?php echo BASE_URL;?>src/view/js/admin_participantes.js"></script>