<?php

namespace wp_coremanager\PostTypes;

use wp_coremanager\Module;

class Cpu extends Module
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
        register_post_type('cpu', array(
            'labels' => array(
                'name' => 'cpus',
                'singular_name' => 'cpu',
                'menu_name' => 'cpu',
                'all_items' => 'Todos cpu',
                'edit_item' => 'Editar cpus',
                'view_item' => 'Ver cpus',
                'view_items' => 'Ver cpu',
                'add_new_item' => 'Añadir nuevo cpus',
                'add_new' => 'Añadir nuevo cpus',
                'new_item' => 'Nuevo cpus',
                'parent_item_colon' => 'cpus superior:',
                'search_items' => 'Buscar cpu',
                'not_found' => 'No se han encontrado cpu',
                'not_found_in_trash' => 'No hay cpu en la papelera',
                'archives' => 'Archivo de cpus',
                'attributes' => 'Atributos de cpus',
                'insert_into_item' => 'Insertar en cpus',
                'uploaded_to_this_item' => 'Subido a este cpus',
                'filter_items_list' => 'Filtrar lista de cpu',
                'filter_by_date' => 'Filtrar cpu por fecha',
                'items_list_navigation' => 'Navegación por la lista de cpu',
                'items_list' => 'Lista de cpu',
                'item_published' => 'cpus publicado.',
                'item_published_privately' => 'cpus publicado de forma privada.',
                'item_reverted_to_draft' => 'cpus devuelto a borrador.',
                'item_scheduled' => 'cpus programados.',
                'item_updated' => 'cpus actualizado.',
                'item_link' => 'Enlace a cpus',
                'item_link_description' => 'Un enlace a un cpus.',
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
