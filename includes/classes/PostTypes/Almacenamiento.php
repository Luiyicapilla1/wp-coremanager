<?php

namespace wp_coremanager\PostTypes;

use wp_coremanager\Module;

class Almacenamiento extends Module
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
        register_post_type('almacenamiento', array(
            'labels' => array(
                'name' => 'almacenamientos',
                'singular_name' => 'almacenamiento',
                'menu_name' => 'almacenamientos',
                'all_items' => 'Todos almacenamientos',
                'edit_item' => 'Editar almacenamiento',
                'view_item' => 'Ver almacenamiento',
                'view_items' => 'Ver almacenamientos',
                'add_new_item' => 'Añadir nuevo almacenamiento',
                'add_new' => 'Añadir nuevo almacenamiento',
                'new_item' => 'Nuevo almacenamiento',
                'parent_item_colon' => 'almacenamiento superior:',
                'search_items' => 'Buscar almacenamientos',
                'not_found' => 'No se han encontrado almacenamientos',
                'not_found_in_trash' => 'No hay almacenamientos en la papelera',
                'archives' => 'Archivo de almacenamiento',
                'attributes' => 'Atributos de almacenamiento',
                'insert_into_item' => 'Insertar en almacenamiento',
                'uploaded_to_this_item' => 'Subido a este almacenamiento',
                'filter_items_list' => 'Filtrar lista de almacenamientos',
                'filter_by_date' => 'Filtrar almacenamientos por fecha',
                'items_list_navigation' => 'Navegación por la lista de almacenamientos',
                'items_list' => 'Lista de almacenamientos',
                'item_published' => 'almacenamiento publicado.',
                'item_published_privately' => 'almacenamiento publicado de forma privada.',
                'item_reverted_to_draft' => 'almacenamiento devuelto a borrador.',
                'item_scheduled' => 'almacenamiento programados.',
                'item_updated' => 'almacenamiento actualizado.',
                'item_link' => 'Enlace a almacenamiento',
                'item_link_description' => 'Un enlace a un almacenamiento.',
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
