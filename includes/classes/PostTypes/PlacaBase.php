<?php

namespace wp_coremanager\PostTypes;

use wp_coremanager\Module;

class PlacaBase extends Module
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
        register_post_type('placa-base', array(
            'labels' => array(
                'name' => 'placas_bases',
                'singular_name' => 'placa_base',
                'menu_name' => 'placas_bases',
                'all_items' => 'Todos placas_bases',
                'edit_item' => 'Editar placa_base',
                'view_item' => 'Ver placa_base',
                'view_items' => 'Ver placas_bases',
                'add_new_item' => 'Añadir nuevo placa_base',
                'add_new' => 'Añadir nuevo placa_base',
                'new_item' => 'Nuevo placa_base',
                'parent_item_colon' => 'placa_base superior:',
                'search_items' => 'Buscar placas_bases',
                'not_found' => 'No se han encontrado placas_bases',
                'not_found_in_trash' => 'No hay placas_bases en la papelera',
                'archives' => 'Archivo de placa_base',
                'attributes' => 'Atributos de placa_base',
                'insert_into_item' => 'Insertar en placa_base',
                'uploaded_to_this_item' => 'Subido a este placa_base',
                'filter_items_list' => 'Filtrar lista de placas_bases',
                'filter_by_date' => 'Filtrar placas_bases por fecha',
                'items_list_navigation' => 'Navegación por la lista de placas_bases',
                'items_list' => 'Lista de placas_bases',
                'item_published' => 'placa_base publicado.',
                'item_published_privately' => 'placa_base publicado de forma privada.',
                'item_reverted_to_draft' => 'placa_base devuelto a borrador.',
                'item_scheduled' => 'placa_base programados.',
                'item_updated' => 'placa_base actualizado.',
                'item_link' => 'Enlace a placa_base',
                'item_link_description' => 'Un enlace a un placa_base.',
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
