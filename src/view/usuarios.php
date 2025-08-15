<!-- ========= INICIA EL CONTENIDO DEL CUERPO DE LA PÁGINA DE EVENTOS ========= -->

<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <!-- Fila de Cabecera y Botón de Acción -->
        <div class="col-sm-12 col-xl-6">
            <div class="bg-secondary rounded h-100 p-4">
                <h2>Gestión de usuarios</h2>
                <div class="m-n2">          
                    <p>Registra, Edita o Elimina usuarios del sistema</p>
                    <a href="<?php echo BASE_URL;?>"><button type="button" class="btn btn-outline-primary m-2"><i class="fa fa-home me-2"></i>Volver al inicio</button></a>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-xl-6">
            <div class="bg-secondary rounded h-100 p-4">
                <h6 class="mb-4">Acciones</h6>
                <div class="m-n2">
                    <button type="button" class="btn btn-outline-primary m-2" data-bs-toggle="modal" data-bs-target="#modalNuevoUsuario"><i class="fa fa-plus me-2"></i>Nuevo</button>
                    <button type="button" class="btn btn-outline-success m-2"><i class="fa fa-file-excel me-2"></i>Reporte</button>
                    <button type="button" class="btn btn-outline-primary m-2"><i class="fa fa-file-pdf me-2"></i>Reporte</button>
                </div>
            </div>
        </div>

         <!--modal registrar usuario-->
        <div class="modal fade" id="modalNuevoUsuario" tabindex="-1" aria-labelledby="modalNuevoUsuarioLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content bg-secondary">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalNuevoUsuarioLabel">Nuevo Usuario</h1>
                        <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="frm_nuevo_usuario">
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
                                <label for="correo" class="form-label">Correo electrónico:</label>
                                <input type="email" class="form-control" name="correo" id="correo" placeholder="ejemplo@correo.com" required>
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
                                <label for="genero" class="form-label">Género:</label>
                                <select class="form-select" name="genero" id="genero" required>
                                <option value="">Seleccione un genero</option>
                                <option value="M">Masculino</option>
                                <option value="F">Femenino</option>
                                <option value="Otro">Otro</option>
                                </select>
                            </div> 
                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña:</label>
                                <input type="text" class="form-control" name="password" id="password" placeholder="Ingrese su Contraseña" required>
                            </div>
                            <div class="mb-3">
                                <label for="rol" class="form-label">Rol:</label>
                                <select class="form-select" name="rol" id="rol" required>
                                <option value="">Seleccione un Rol</option>
                                </select>
                            </div>                 
                            <div class="text-center g-2">                             
                                <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal" >Cancelar</button>  
                                <button type="button" class="btn btn-outline-primary" onclick="registrarUsuario();" >Registrar</button> 
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- tabala eventos recientes -->
        <div class="col-12">
            <div class="bg-secondary rounded h-100 p-4">
                <h6 class="mb-4">Usuarios registrados</h6>
                <div class="table-responsive">
                    <table class="table" id="tbl_usuarios"> 
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Dni</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Apellido</th>
                                <th scope="col">Correo Electronico</th>
                                <th scope="col">Telefono</th>
                                <th scope="col">Estado</th>
                                <th scope="col">     </th>
                            </tr>
                        </thead>
                        <tbody id="tbody_tbl_usuarios">
                                <!--CONTENIDO TABLA CON JS-->
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
<script src="<?php echo BASE_URL;?>src/view/js/admin_usuario.js"></script>