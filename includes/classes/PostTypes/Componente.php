<?php

namespace wp_coremanager\PostTypes;

use wp_coremanager\Module;

class Componente extends Module
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
        register_post_type('componente', array(
            'labels' => array(
                'name' => 'componentes',
                'singular_name' => 'componente',
                'menu_name' => 'componentes',
                'all_items' => 'Todos componentes',
                'edit_item' => 'Editar componente',
                'view_item' => 'Ver componente',
                'view_items' => 'Ver componentes',
                'add_new_item' => 'Añadir nuevo componente',
                'add_new' => 'Añadir nuevo componente',
                'new_item' => 'Nuevo componente',
                'parent_item_colon' => 'componente superior:',
                'search_items' => 'Buscar componentes',
                'not_found' => 'No se han encontrado componentes',
                'not_found_in_trash' => 'No hay componentes en la papelera',
                'archives' => 'Archivo de componente',
                'attributes' => 'Atributos de componente',
                'insert_into_item' => 'Insertar en componente',
                'uploaded_to_this_item' => 'Subido a este componente',
                'filter_items_list' => 'Filtrar lista de componentes',
                'filter_by_date' => 'Filtrar componentes por fecha',
                'items_list_navigation' => 'Navegación por la lista de componentes',
                'items_list' => 'Lista de componentes',
                'item_published' => 'componente publicado.',
                'item_published_privately' => 'componente publicado de forma privada.',
                'item_reverted_to_draft' => 'componente devuelto a borrador.',
                'item_scheduled' => 'componente programados.',
                'item_updated' => 'componente actualizado.',
                'item_link' => 'Enlace a componente',
                'item_link_description' => 'Un enlace a un componente.',
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
