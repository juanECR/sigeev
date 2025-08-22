<!-- ========= INICIA EL CONTENIDO DEL CUERPO DE LA PÁGINA DE EVENTOS ========= -->

<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <!-- Fila de Cabecera y Botón de Acción -->
        <div class="col-sm-12 col-xl-6">
            <div class="bg-secondary rounded h-100 p-4">
                <h2>Gestión de Empleados</h2>
                <div class="m-n2">          
                    <p>Registra, Edita o Elimina Empleados.</p>
                    <button type="button" class="btn btn-outline-primary m-2"><i class="fa fa-home me-2"></i>Volver al inicio</button>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-xl-6">
            <div class="bg-secondary rounded h-100 p-4">
                <h6 class="mb-4">Acciones</h6>
                <div class="m-n2">
                    <button type="button" class="btn btn-outline-primary m-2" data-bs-toggle="modal" data-bs-target="#modalNuevoEmpleado"><i class="fa fa-plus me-2"></i>Nuevo</button>
                    <button type="button" class="btn btn-outline-success m-2"><i class="fa fa-file-excel me-2"></i>Reporte</button>
                    <button type="button" class="btn btn-outline-primary m-2"><i class="fa fa-file-pdf me-2"></i>Reporte</button>
                </div>
            </div>
        </div>

        <!--modal registrar empleado-->
        <div class="modal fade" id="modalNuevoEmpleado" tabindex="-1" aria-labelledby="modalNuevoEmpleadoLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content bg-secondary">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalNuevoEmpleadoLabel"><i class="fa fa-user me-2 text-primary"></i>Nuevo empleado</h1>
                        <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="frm_nuevo_empleado">
                            <div class="mb-3">
                                <label for="dni" class="form-label">Dni:<span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="dni" id="dni" placeholder="Ingrese su dni" required>
                            </div>
                            <div class="mb-3">
                                <label for="nombres" class="form-label">Nombres:<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nombres" id="nombres" placeholder="Ingrese sus nombres" required>
                            </div>
                            <div class="mb-3">
                                <label for="apellidos" class="form-label">Apellidos:<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="apellidos" id="apellidos" placeholder="Ingrese sus apellidos" required>
                            </div>
                            <div class="mb-3">
                                <label for="correo" class="form-label">Correo electrónico:</label>
                                <input type="email" class="form-control" name="correo" id="correo" placeholder="ejemplo@correo.com" require>
                            </div>
                            <div class="mb-3">
                                <label for="telefono" class="form-label">Teléfono:</label>
                                <input type="number" class="form-control" name="telefono" id="telefono" placeholder="Ingerese su telefono" required>
                            </div>
                            <div class="mb-3">
                                <label for="fecha_nacimiento" class="form-label">Fecha de nacimiento:</label>
                                <input type="date" class="form-control" name="fecha_nacimiento" id="fecha_nacimiento" placeholder="Ingrese su fecha de nacimiento" required>
                            </div>
                            <div class="mb-3">
                                <label for="genero" class="form-label">Género:<span class="text-danger">*</span></label>
                                <select class="form-select" name="genero" id="genero" required>
                                <option value="">Seleccione un genero</option>
                                <option value="M">Masculino</option>
                                <option value="F">Femenino</option>
                                <option value="Otro">Otro</option>
                                </select>
                            </div>
                            <div class="text-center g-2">                             
                                <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal" >Cancelar</button>  
                                <button type="button" class="btn btn-outline-primary" onclick="registrarEmpleado();">Registrar</button> 
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- tabala empleados -->
        <div class="col-12">
            <div class="bg-secondary rounded h-100 p-4">
                <h6 class="mb-4">Empleados</h6>
                <div class="table-responsive">
                    <table class="table" id="tbl_empleados">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">DNI</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Apellido</th>
                                <th scope="col">Correo</th>
                                <th scope="col">Telefono</th>
                                <th scope="col">Fecha nacimiento</th>
                                <th scope="col">Género</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tbody_tbl_empleados">
                             <!--  js -->
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
<script src="<?php echo BASE_URL;?>src/view/js/admin-Empleado.js"></script>