<?php

if (!defined('ABSPATH')) {
    exit;
}


add_action('elementor/query/mi_loop_categoria_producto', function ($query) {
    // Obtén el parámetro de la URL para la taxonomía personalizada
    $categoria_producto = isset($_GET['categoria-de-producto']) ? sanitize_text_field($_GET['categoria-de-producto']) : '';

    // Si hay un parámetro en la URL, aplica el filtro
    if (!empty($categoria_producto)) {
        $query->set('tax_query', [
            [
                'taxonomy' => 'categoria-de-producto', // Nombre de la taxonomía
                'field' => 'slug',                   // Campo a comparar (slug)
                'terms' => $categoria_producto,      // Valor del slug de la URL
            ],
        ]);
    }
});

function agregar_script_categoria_activa() {
    // Verifica si estamos en la página donde necesitamos el script
    //if (is_page() || is_single()) {
        // Enlaza el archivo JavaScript personalizado
        wp_enqueue_script(
            'categoria-activa', // Handle único para el script
            get_template_directory_uri() . '/category-filter.js', // Ruta al archivo JS
            array('jquery'), // Dependencias (si las hay)
            null, // Número de versión
            true // Cargar al final de la página (antes de </body>)
        );
    //}
}
add_action('wp_enqueue_scripts', 'agregar_script_categoria_activa');
