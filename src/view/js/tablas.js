    $(document).ready(function() {
    $('#tbl_eventos').DataTable({
        // Opciones de configuración (opcional)
        "paging": true, // Habilita la paginación (es true por defecto)
        "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "Todos"] ]
    });
});