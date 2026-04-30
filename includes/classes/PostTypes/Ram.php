<?php

namespace wp_coremanager\PostTypes;

use wp_coremanager\Module;

class Ram extends Module
{
    public $load_order = 10;

    public function puede_registrar()
    {
        return true;
    }

    public function registrar()
    {
        $this->post_type_register();
    }

    public function post_type_register()
    {
        register_post_type('ram', array(
            'labels' => array(
                'name' => 'rams',
                'singular_name' => 'ram',
                'menu_name' => 'ram',
                'all_items' => 'Todos ram',
                'edit_item' => 'Editar ram',
                'view_item' => 'Ver ram',
                'view_items' => 'Ver ram',
                'add_new_item' => 'Añadir nuevo ram',
                'add_new' => 'Añadir nuevo ram',
                'new_item' => 'Nuevo ram',
                'parent_item_colon' => 'ram superior:',
                'search_items' => 'Buscar ram',
                'not_found' => 'No se han encontrado ram',
                'not_found_in_trash' => 'No hay ram en la papelera',
                'archives' => 'Archivo de ram',
                'attributes' => 'Atributos de ram',
                'insert_into_item' => 'Insertar en ram',
                'uploaded_to_this_item' => 'Subido a este ram',
                'filter_items_list' => 'Filtrar lista de ram',
                'filter_by_date' => 'Filtrar ram por fecha',
                'items_list_navigation' => 'Navegación por la lista de ram',
                'items_list' => 'Lista de ram',
                'item_published' => 'ram publicado.',
                'item_published_privately' => 'ram publicado de forma privada.',
                'item_reverted_to_draft' => 'ram devuelto a borrador.',
                'item_scheduled' => 'ram programados.',
                'item_updated' => 'ram actualizado.',
                'item_link' => 'Enlace a ram',
                'item_link_description' => 'Un enlace a un ram.',
            ),
            'public' => true,
            'show_in_rest' => true,
            'menu_icon' => 'dashicons-admin-post',
            'supports' => array(
                0 => 'title',
                1 => 'editor',
                2 => 'thumbnail',
                3 => 'custom-fields',
            ),
            'delete_with_user' => false,
        ));
    }
}
