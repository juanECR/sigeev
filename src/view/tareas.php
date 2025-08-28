<!-- ========= INICIA EL CONTENIDO DEL CUERPO DE LA PÁGINA DE EVENTOS ========= -->

<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <!-- Fila de Cabecera y Botón de Acción -->
        <div class="col-sm-12 col-xl-6">
            <div class="bg-secondary rounded h-100 p-4">
                <h2>Gestión de Tareas</h2>
                <div class="m-n2">          
                    <p>Registra, Edita o Elimina Tareas asignadas a un empleado.</p>
                    <button type="button" class="btn btn-outline-primary m-2"><i class="fa fa-home me-2"></i>Volver al inicio</button>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-xl-6">
            <div class="bg-secondary rounded h-100 p-4">
                <h6 class="mb-4">Acciones</h6>
                <div class="m-n2">
                    <button type="button" class="btn btn-outline-primary m-2" data-bs-toggle="modal" data-bs-target="#modalVerEmpleados"><i class="fa fa-plus me-2"></i>Nueva tarea</button>
                    <button type="button" class="btn btn-outline-success m-2"><i class="fa fa-file-excel me-2"></i>Reporte</button>
                    <button type="button" class="btn btn-outline-primary m-2"><i class="fa fa-file-pdf me-2"></i>Reporte</button>
                </div>
            </div>
        </div>

        <!-- tabala eventos recientes -->
        <div class="col-12">
            <div class="bg-secondary rounded h-100 p-4">
                <h4 class="mb-4">Empleados / Tareas</h4>
                <div class="table-responsive">
                    <table class="table" id="tbl_verTareas">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Empleado</th>
                                <th scope="col">Titulo Tarea</th>
                                <th scope="col">Descripción</th>
                                <th scope="col">Fecha</th>
                                <th scope="col">Status</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="tbody_tbl_verTareas">
                        <!-- javascript -->
                        </tbody>
                    </table>
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center" id="pageees-control">
                          
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Modal VER EMPLEADOS-->
        <div class="modal fade" id="modalVerEmpleados" tabindex="-1" aria-labelledby="modalVerEmpleadosLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content bg-secondary">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalVerEmpleadosLabel">Empleados</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-5">
                    <div class="table-responsive">
                        <table class="table" id="tbl_empleados">
                            <thead>
                                <tr class="text-white">
                                    <th scope="col">#</th>
                                    <th scope="col">DNI</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Apellido</th>
                                    <th scope="col">Correo</th>
                                    <th scope="col">Telefono</th>
                                    <th scope="col">Fecha nacimiento</th>
                                    <th scope="col">Género</th>
                                    <th scope="col">Tarea</th>
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
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                </div>
                </div>
            </div>
        </div>
        <!--modal registrar tarea-->
        <div class="modal fade" id="modalNuevaTarea" tabindex="-1" aria-labelledby="modalNuevaTareaLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content bg-secondary">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalNuevaTareaLabel"><i class="fa fa-user me-2 text-primary"></i>Tarea</h1>
                        <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="frm_nueva_tarea">
                            <div class="mb-3">
                                <label for="titulo" class="form-label">Titulo:<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="titulo" id="titulo" placeholder="Ingrese titulo de la tarea" required>
                            </div>
                            <div class="mb-3">
                                <label for="descripcion" class="form-label">Descripción:<span class="text-danger">*</span></label>
                                <textarea type="text" class="form-control" name="descripcion" id="descripcion" placeholder="Detalle de la tarea" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="f_tarea" class="form-label">Fecha de tarea:</label>
                                <input type="date" class="form-control" name="f_tarea" id="f_tarea" placeholder="Ingrese su fecha de atrea" required>
                            </div>
                            <div class="text-center g-2">                             
                                <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal" >Cancelar</button>  
                                <button type="button" class="btn btn-outline-primary" onclick="registrarTarea();">Registrar</button> 
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

   </div>
</div>
<script>  var id_evento = <?php echo base64_decode($_GET['data']);?> </script>
<script src="<?php echo BASE_URL;?>src/view/js/admin-tareas.js"></script>