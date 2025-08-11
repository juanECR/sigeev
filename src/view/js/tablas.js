    $(document).ready(function() {
    $('#tbl_eventos').DataTable({
        // Opciones de configuración (opcional)
        "paging": true, // Habilita la paginación (es true por defecto)
        "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "Todos"] ], // Opciones para mostrar X filas
        "language": { // Configuración del idioma
            "url": "//cdn.datatables.net/plug-ins/1.11.3/i18n/es_es.json"
        }
    });
});