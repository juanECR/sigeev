<!-- ========= INICIA EL CONTENIDO DEL CUERPO DE LA PÁGINA DE EVENTOS ========= -->

<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <!-- Fila de Cabecera y Botón de Acción -->
        <div class="col-sm-12 col-xl-6">
            <div class="bg-secondary rounded h-100 p-4">
                <h2>Gestión de usuarios</h2>
                <div class="m-n2">          
                    <p>Registra, Edita o elimina usuarios del sistema</p>
                    <button type="button" class="btn btn-outline-primary m-2"><i class="fa fa-home me-2"></i>Volver al inicio</button>
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
                     <!--modal registrar usuario-->
                    <div class="modal fade" id="modalNuevoUsuario" tabindex="-1" aria-labelledby="modalNuevoUsuarioLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content bg-secondary">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="modalNuevoUsuarioLabel">Nuevo usuario</h1>
                                <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="frm_nuevo_usuario">
                                    <div class="mb-3">
                                        <label for="nombres" class="form-label">Nombres</label>
                                        <input type="text" class="form-control" name="nombres" id="nombres" placeholder="Ingrese sus nombres" required>
                                    </div>
                                    <!-- Correo -->
                                    <div class="mb-3">
                                        <label for="correo" class="form-label">Correo electrónico</label>
                                        <input type="email" class="form-control" name="correo" id="correo" placeholder="ejemplo@correo.com" required>
                                    </div>
                                    <!-- telefono -->
                                    <div class="mb-3">
                                        <label for="telefono" class="form-label">Teléfono</label>
                                        <input type="number" class="form-control" name="telefono" id="telefono" placeholder="Ingerese su telefono" required>
                                    </div>
                                    <!-- Contraseña -->
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Contraseña</label>
                                        <input type="password" class="form-control" name="password" id="password" placeholder="Ingrese su contraseña" required>
                                    </div>
                                    <!-- Rol -->
                                    <div class="mb-3">
                                        <label for="rol" class="form-label">Rol</label>
                                        <select class="form-select" name="rol" id="rol" required>
                                        <option value="">Seleccione un rol</option>
                                        <option value="admin">Admin</option>
                                        <option value="coordinador">Coordinador</option>
                                        <option value="operador">operador</option>
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
                                <th scope="col">First Name</th>
                                <th scope="col">Last Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Country</th>
                                <th scope="col">ZIP</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody id="tbody_tbl_usuarios">
                            <tr>
                                <th scope="row">1</th>
                                <td>John</td>
                                <td>Doe</td>
                                <td>jhon@email.com</td>
                                <td>USA</td>
                                <td>123</td>
                                <td>Member</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

         <!-- tabala eventos recientes -->
        <div class="col-12">
            <div class="bg-secondary rounded h-100 p-4">
                <h6 class="mb-4">Eventos completados</h6>
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
                            <tr>
                                <th scope="row">1</th>
                                <td>John</td>
                                <td>Doe</td>
                                <td>jhon@email.com</td>
                                <td>USA</td>
                                <td>123</td>
                                <td>Member</td>
                            </tr>
                            <tr>
                                <th scope="row">2</th>
                                <td>Mark</td>
                                <td>Otto</td>
                                <td>mark@email.com</td>
                                <td>UK</td>
                                <td>456</td>
                                <td>Member</td>
                            </tr>
                            <tr>
                                <th scope="row">3</th>
                                <td>Jacob</td>
                                <td>Thornton</td>
                                <td>jacob@email.com</td>
                                <td>AU</td>
                                <td>789</td>
                                <td>Member</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

   </div>
</div>
<script src="<?php echo BASE_URL;?>src/view/js/admin_usuario.js"></script>