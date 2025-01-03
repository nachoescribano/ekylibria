<?php

if (!defined('ABSPATH')) {
    exit;
}

// Force flush rewrite rules
add_action('init', function() {
    if (get_option('ekylibria_flush_rewrite') !== 'done') {
        flush_rewrite_rules();
        update_option('ekylibria_flush_rewrite', 'done');
    }
}, 99);

// Add theme support
function ekylibria_theme_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
    add_theme_support('elementor');
}
add_action('after_setup_theme', 'ekylibria_theme_setup');

// Register Custom Post Type Producto
function ekylibria_register_producto_post_type() {
    $labels = array(
        'name'                  => 'Productos',
        'singular_name'         => 'Producto',
        'menu_name'            => 'Productos',
        'add_new'              => 'Añadir nuevo',
        'add_new_item'         => 'Añadir nuevo Producto',
        'edit_item'            => 'Editar Producto',
        'new_item'             => 'Nuevo Producto',
        'view_item'            => 'Ver Producto',
        'search_items'         => 'Buscar Productos',
        'not_found'            => 'No se encontraron productos',
        'not_found_in_trash'   => 'No se encontraron productos en la papelera'
    );

    $args = array(
        'labels'              => $labels,
        'public'              => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'query_var'           => true,
        'rewrite'             => array('slug' => 'productos'),
        'capability_type'     => 'post',
        'has_archive'         => true,
        'hierarchical'        => false,
        'menu_position'       => 5,
        'menu_icon'           => 'dashicons-products',
        'supports'            => array('title', 'thumbnail')
    );

    register_post_type('ekylibria_producto', $args);
}

// Register Product Categories Taxonomy
function ekylibria_register_categoria_taxonomy() {
    $labels = array(
        'name'              => 'Categorías de Producto',
        'singular_name'     => 'Categoría de Producto',
        'search_items'      => 'Buscar Categorías',
        'all_items'         => 'Todas las Categorías',
        'parent_item'       => 'Categoría Padre',
        'parent_item_colon' => 'Categoría Padre:',
        'edit_item'         => 'Editar Categoría',
        'update_item'       => 'Actualizar Categoría',
        'add_new_item'      => 'Añadir Nueva Categoría',
        'new_item_name'     => 'Nombre de Nueva Categoría',
        'menu_name'         => 'Categorías',
        'not_found'         => 'No se encontraron categorías'
    );

    register_taxonomy(
        'ekylibria_categoria',
        'ekylibria_producto',
        array(
            'hierarchical'      => true,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_in_menu'      => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array('slug' => 'categoria-producto'),
            'show_in_rest'      => true
        )
    );

    // Create default categories immediately after registering taxonomy
    $default_categories = array(
        'avícola',
        'porcino',
        'vacuno',
        'conejo',
        'equino',
        'mascota'
    );

    foreach ($default_categories as $cat_name) {
        if (!term_exists($cat_name, 'ekylibria_categoria')) {
            wp_insert_term($cat_name, 'ekylibria_categoria');
        }
    }
}

// Register post type and taxonomy
add_action('init', 'ekylibria_register_producto_post_type');
add_action('init', 'ekylibria_register_categoria_taxonomy');

// Enqueue styles and scripts
function ekylibria_enqueue_scripts() {
    wp_enqueue_style('ekylibria-style', get_stylesheet_uri());
}
add_action('wp_enqueue_scripts', 'ekylibria_enqueue_scripts');

// Check if ACF is active
if (class_exists('ACF')) {
    // Add ACF fields for Productos
    function ekylibria_register_producto_fields() {
        acf_add_local_field_group(array(
            'key' => 'group_ekylibria_productos',
            'title' => 'Detalles del Producto',
            'fields' => array(
                array(
                    'key' => 'field_ekylibria_descripcion_corta',
                    'label' => 'Descripción Corta',
                    'name' => 'ekylibria_descripcion_corta',
                    'type' => 'textarea',
                    'instructions' => 'Ingrese una descripción breve del producto',
                    'required' => 1,
                    'rows' => 3,
                ),
                array(
                    'key' => 'field_ekylibria_descripcion_larga',
                    'label' => 'Descripción Larga',
                    'name' => 'ekylibria_descripcion_larga',
                    'type' => 'textarea',
                    'instructions' => 'Ingrese la descripción detallada del producto',
                    'required' => 1,
                    'rows' => 6,
                ),
                array(
                    'key' => 'field_ekylibria_presentacion',
                    'label' => 'Presentación',
                    'name' => 'ekylibria_presentacion',
                    'type' => 'text',
                    'instructions' => 'Ingrese la presentación del producto',
                    'required' => 1,
                ),
                array(
                    'key' => 'field_ekylibria_especies_destino',
                    'label' => 'Especies de Destino',
                    'name' => 'ekylibria_especies_destino',
                    'type' => 'text',
                    'instructions' => 'Ingrese las especies de destino',
                    'required' => 1,
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'ekylibria_producto',
                    ),
                ),
            ),
            'menu_order' => 0,
            'position' => 'normal',
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen' => array('the_content'),
        ));
    }
    add_action('acf/init', 'ekylibria_register_producto_fields');
} 