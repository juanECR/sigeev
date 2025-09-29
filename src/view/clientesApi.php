<!-- ========= INICIA EL CONTENIDO DEL CUERPO DE LA PÁGINA DE EVENTOS ========= -->

<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <!-- Fila de Cabecera y Botón de Acción -->
        <div class="col-sm-12 col-xl-6">
            <div class="bg-secondary rounded h-100 p-4">
                <h2>Gestión de Clientes Api</h2>
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
                    <button type="button" class="btn btn-outline-primary m-2" data-bs-toggle="modal" data-bs-target="#modalNuevoCliente"><i class="fa fa-plus me-2"></i>Nuevo</button>
                </div>
            </div>
        </div>

         <!--modal registrar cliente api-->
        <div class="modal fade" id="modalNuevoCliente" tabindex="-1" aria-labelledby="modalNuevoClienteLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content bg-secondary">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalNuevoClienteLabel">Nuevo Cliente</h1>
                        <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="frm_nuevo_cliente">
                            <div class="mb-3">
                                <label for="ruc" class="form-label">RUC:</label>
                                <input type="number" class="form-control" name="ruc" id="ruc" placeholder="Ingrese su ruc" minlength="8" maxlength="8"  required>
                            </div>
                            <div class="mb-3">
                                <label for="razon_social" class="form-label">Razon Social</label>
                                <input type="text" class="form-control" name="razon_social" id="razon_social" placeholder="Ingrese sus Razon social" required>
                            </div>
                            <div class="mb-3">
                                <label for="telefono" class="form-label">Teléfono:</label>
                                <input type="number" class="form-control" name="telefono" id="telefono" placeholder="Ingerese su telefono" required>
                            </div>
                            <div class="mb-3">
                                <label for="correo" class="form-label">Correo electrónico:</label>
                                <input type="email" class="form-control" name="correo" id="correo" placeholder="ejemplo@correo.com" required>
                            </div>                
                            <div class="text-center g-2">                             
                                <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal" >Cancelar</button>  
                                <button type="button" class="btn btn-outline-primary" onclick="registrarCliente();" >Registrar</button> 
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- tabala clientres api -->
        <div class="col-12">
            <div class="bg-secondary rounded h-100 p-4">
                <h6 class="mb-4">Usuarios registrados</h6>
                <div class="table-responsive">
                    <table class="table" id="tbl_clientesApi"> 
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">RUC</th>
                                <th scope="col">RAZON SOCIAL</th>
                                <th scope="col">Telefono</th>                      
                                <th scope="col">Correo Electronico</th>
                                <th scope="col">Estado</th>
                                <th scope="col"> </th>
                            </tr>
                        </thead>
                        <tbody id="tbody_tbl_clientesApi">
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

                 <!--modal editar cliente api-->
        <div class="modal fade" id="modalEditarCliente" tabindex="-1" aria-labelledby="modalEditarClienteLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content bg-secondary">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalEditarClienteLabel">Nuevo Cliente</h1>
                        <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="frm_act_cliente">
                            <input type="hidden" name="data" id="data" value="">
                            <div class="mb-3">
                                <label for="new_ruc" class="form-label">RUC:</label>
                                <input type="number" class="form-control" name="new_ruc" id="new_ruc" placeholder="Ingrese su ruc" minlength="8" maxlength="8"  required>
                            </div>
                            <div class="mb-3">
                                <label for="new_razon_social" class="form-label">Razon Social</label>
                                <input type="text" class="form-control" name="new_razon_social" id="new_razon_social" placeholder="Ingrese sus Razon social" required>
                            </div>
                            <div class="mb-3">
                                <label for="new_telefono" class="form-label">Teléfono:</label>
                                <input type="number" class="form-control" name="new_telefono" id="new_telefono" placeholder="Ingerese su telefono" required>
                            </div>
                            <div class="mb-3">
                                <label for="new_correo" class="form-label">Correo electrónico:</label>
                                <input type="email" class="form-control" name="new_correo" id="new_correo" placeholder="ejemplo@correo.com" required>
                            </div>  
                            <div class="mb-3">
                                    <label for="estado" class="form-label">Estado:</label>
                                    <select class="form-select" name="estado" id="estado" required>
                                    <option value="">Seleccione estado</option>
                                    <option value="0">inactivo</option>
                                    <option value="1">activo</option>
                                    </select>
                            </div>              
                            <div class="text-center g-2">                             
                                <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal" >Cancelar</button>  
                                <button type="button" class="btn btn-outline-primary" onclick="actualizarCliente();" >Actualizar</button> 
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

   </div>
</div>
<script src="<?php echo BASE_URL;?>src/view/js/admin-clientesApi.js"></script>