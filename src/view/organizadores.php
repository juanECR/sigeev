<!-- ========= INICIA EL CONTENIDO DEL CUERPO DE LA PÁGINA DE EVENTOS ========= -->

<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <!-- Fila de Cabecera y Botónes de Acción -->
        <div class="col-sm-12 col-xl-6">
            <div class="bg-secondary rounded h-100 p-4">
                <h2>Gestión de Organizadores</h2>
                <div class="m-n2">          
                    <p>Registra, Edita o Elimina Organizadores de eventos.</p>
                    <a href="<?php echo BASE_URL;?>"><button type="button" class="btn btn-outline-primary m-2"><i class="fa fa-home me-2"></i>Volver al inicio</button></a>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-xl-6">
            <div class="bg-secondary rounded h-100 p-4">
                <h6 class="mb-4">Acciones</h6>
                <div class="m-n2">
                    <button type="button" class="btn btn-outline-primary m-2" data-bs-toggle="modal" data-bs-target="#modalNuevoOrganizador"><i class="fa fa-plus me-2"></i>Nuevo</button>
                    <button type="button" class="btn btn-outline-success m-2"><i class="fa fa-file-excel me-2"></i>Reporte</button>
                    <button type="button" class="btn btn-outline-primary m-2"><i class="fa fa-file-pdf me-2"></i>Reporte</button>
                </div>
            </div>
        </div>

          <!--modal registrar organizador-->
        <div class="modal fade" id="modalNuevoOrganizador" tabindex="-1" aria-labelledby="modalNuevoOrganizadorLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content bg-secondary">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalNuevoOrganizadorLabel">Nuevo Organizador</h1>
                        <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="frm_nuevo_organizador">
                            <div class="mb-3">
                                <label for="tipo_documento" class="form-label">Tipo de documento</label>
                                <select class="form-select" name="tipo_documento" id="tipo_documento" required>
                                <option value="">Seleccione tipo de documento</option>
                                <option value="dni">DNI</option>
                                <option value="ruc">RUC</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="nro_documento" class="form-label">N° de documento:</label>
                                <input type="number" class="form-control" name="nro_documento" id="nro_documento" placeholder="Ingrese su numero de documento" required>
                            </div>
                            <div class="mb-3">
                                <label for="razon_social" class="form-label">Razon social:</label>
                                <input type="text" class="form-control" name="razon_social" id="razon_social" placeholder="Ingrese su Razon social" required>
                            </div>
                            <div class="mb-3">
                                <label for="tipo" class="form-label">Tipo organizador</label>
                                <select class="form-select" name="tipo" id="tipo" required>
                                <option value="">Seleccione tipo</option>
                                <option value="interno">Interno</option>
                                <option value="externo">Externo</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="correo" class="form-label">Correo electronico:</label>
                                <input type="email" class="form-control" name="correo" id="correo" placeholder="ejemplo@correo.com" required>
                            </div>
                            <div class="mb-3">
                                <label for="telefono" class="form-label">Telefono</label>
                                <input type="number" class="form-control" name="telefono" id="telefono" placeholder="Ingrese su Telefono" required>
                            </div>
                   
                            <div class="text-center g-2">                             
                                <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal" >Cancelar</button>  
                                <button type="button" class="btn btn-outline-primary" onclick="registrarOrganizador();" >Registrar</button> 
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- tabala eventos recientes -->
        <div class="col-12">
            <div class="bg-secondary rounded h-100 p-4">
                <h6 class="mb-4">Todos los Organizadores</h6>
                <div class="table-responsive">
                    <table class="table" id="tbl_organizadores">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">N° de documento</th>
                                <th scope="col">Razon social</th>
                                <th scope="col">Tipo de organizador</th>
                                <th scope="col">Correo electronico</th>
                                <th scope="col">Telefono</th>
                                <th scope="col"> </th>
                            </tr>
                        </thead>
                        <tbody id="tbody_tbl_organizadores">
                           <!-- esto se llena con js-->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

   </div>
</div>
<script src="<?php echo BASE_URL;?>src/view/js/admin_organizadores.js"></script>