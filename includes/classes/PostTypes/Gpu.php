<?php

namespace wp_coremanager\PostTypes;

use wp_coremanager\Module;

class Gpu extends Module
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
        register_post_type('gpu', array(
            'labels' => array(
                'name' => 'gpus',
                'singular_name' => 'gpu',
                'menu_name' => 'gpu',
                'all_items' => 'Todos gpu',
                'edit_item' => 'Editar gpu',
                'view_item' => 'Ver gpu',
                'view_items' => 'Ver gpu',
                'add_new_item' => 'Añadir nuevo gpu',
                'add_new' => 'Añadir nuevo gpu',
                'new_item' => 'Nuevo gpu',
                'parent_item_colon' => 'gpu superior:',
                'search_items' => 'Buscar gpu',
                'not_found' => 'No se han encontrado gpu',
                'not_found_in_trash' => 'No hay gpu en la papelera',
                'archives' => 'Archivo de gpu',
                'attributes' => 'Atributos de gpu',
                'insert_into_item' => 'Insertar en gpu',
                'uploaded_to_this_item' => 'Subido a este gpu',
                'filter_items_list' => 'Filtrar lista de gpu',
                'filter_by_date' => 'Filtrar gpu por fecha',
                'items_list_navigation' => 'Navegación por la lista de gpu',
                'items_list' => 'Lista de gpu',
                'item_published' => 'gpu publicado.',
                'item_published_privately' => 'gpu publicado de forma privada.',
                'item_reverted_to_draft' => 'gpu devuelto a borrador.',
                'item_scheduled' => 'gpu programados.',
                'item_updated' => 'gpu actualizado.',
                'item_link' => 'Enlace a gpu',
                'item_link_description' => 'Un enlace a un gpu.',
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
