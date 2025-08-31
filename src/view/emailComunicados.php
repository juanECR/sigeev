<!-- ========= INICIA EL CONTENIDO DEL CUERPO DE LA PÁGINA DE EVENTOS ========= -->

<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <!-- Fila de Cabecera y Botón de Acción -->
        <div class="col-sm-12 col-xl-6">
            <div class="bg-secondary rounded h-100 p-4">
                <h2>Gestión de Comunicados</h2>
                <div class="m-n2">          
                    <p>Registra, Edita o Elimina comunicados que se envian a las personas.</p>
                    <button type="button" class="btn btn-outline-primary m-2"><i class="fa fa-home me-2"></i>Volver al inicio</button>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-xl-6">
            <div class="bg-secondary rounded h-100 p-4">
                <h6 class="mb-4">Acciones</h6>
                <div class="m-n2">
                    <button type="button" class="btn btn-outline-primary m-2"><i class="fa fa-plus me-2"></i>Nuevo</button>
                    <button type="button" class="btn btn-outline-success m-2"><i class="fa fa-file-excel me-2"></i>Reporte</button>
                    <button type="button" class="btn btn-outline-primary m-2"><i class="fa fa-file-pdf me-2"></i>Reporte</button>
                </div>
            </div>
        </div>
        <!-- Formulario para enviar correos -->
        <div class="col-12">
            <div class="bg-secondary rounded h-100 p-4">
             <h2 class="text-center mb-4">Envíar un correo</h2>
            <form id="frm_enviar_Correo" >
                
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control border-light" id="nombre" name="nombre" required>
                </div>
                
                <div class="mb-3">
                    <label for="email" class="form-label">Correo electrónico</label>
                    <input type="email" class="form-control border-light" id="email" name="email" required>
                </div>
                
                <div class="mb-3">
                    <label for="asunto" class="form-label">Asunto</label>
                    <input type="text" class="form-control border-light" id="asunto" name="asunto" required>
                </div>
                
                <div class="mb-3">
                    <label for="mensaje" class="form-label">Mensaje</label>
                    <textarea class="form-control border-light" id="mensaje" name="mensaje" rows="5" required></textarea>
                </div>
                
                <div class="d-grid gap-2">
                    <button type="button" class="btn btn-primary" onclick="enviarCorreo()">Enviar Mensaje</button>
                </div>
                
            </form>
            </div>
        </div>


   </div>
</div>
<script src="<?php echo BASE_URL;?>src/view/js/admin-comunicados.js"></script>