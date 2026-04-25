<?php

/**
 * Module
 *
 * @package WP-CoreManager
 */

namespace wp_coremanager;

use WP_Error;

/**
 * Modulo es una clase abstracta que usaran todos los modulos del plugin como plantilla y heredaran sus metodos.
 */
abstract class Module
{
    /**
     * variable uasada para alterar el orden de inicializacion de las clases.
     *
     * Un numero mas bajo en esta variable se incializa primero.
     *
     * @var int La prioridad del modulo.
     */
    public $load_order = 10;

    /**
     * Metodo que define si un modulo se puede reistrar o no, segun el contexto.
     *
     * @return boolean
     */
    abstract public function puede_registrar();

    /**
     * Connecta los modulos con Wordpress usando los Hooks y filtros correspondientes.
     *
     * @return void
     */
    abstract public function registrar();


    //---------------------------------------
    // Method that download images
    //---------------------------------------
    public function set_image_from_wp_media($image_url, $post_id)
    {
        require_once ABSPATH . 'wp-admin' . '/includes/image.php';
        require_once ABSPATH . 'wp-admin' . '/includes/file.php';
        require_once ABSPATH . 'wp-admin' . '/includes/media.php';
        try {
            $media_id = media_sideload_image($image_url, $post_id, null, 'id');
            return $media_id;
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }


    //---------------------------------------
    // Method that donload other media files
    //---------------------------------------
    public function set_file_from_wp_media($image_url, $post_id)
    {
        require_once ABSPATH . 'wp-admin/includes/file.php';
        require_once ABSPATH . 'wp-admin/includes/media.php';
        require_once ABSPATH . 'wp-admin/includes/image.php';
        try {
            $tmp_name = download_url($image_url);
            if (is_wp_error($tmp_name)) {
                return $tmp_name;
            }
            $file_array = [
                'name'     => basename(parse_url($image_url, PHP_URL_PATH)),
                'tmp_name' => $tmp_name,
                'size'     => filesize($tmp_name),
                'error'    => 0,
                'type'     => mime_content_type($tmp_name) ?: 'application/x-rar-compressed',
            ];
            $media_id = media_handle_sideload($file_array, $post_id);
            if (is_wp_error($media_id)) {
                return $media_id;
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
        }

        return $media_id;
    }


    //---------------------------------------
    // Method that relates post languages
    //---------------------------------------
    public function post_languages_relations($post_id, &$post_languages_list): array
    {
        if (pll_get_post_language($post_id) == 'es') {
            $post_languages_list['es'] = $post_id;
        } elseif (pll_get_post_language($post_id) == 'en') {
            $post_languages_list['en'] = $post_id;
        } elseif (pll_get_post_language($post_id) == 'fr') {
            $post_languages_list['fr'] = $post_id;
        }
        return $post_languages_list;
    }


    //---------------------------------------
    // Method that relates term languages
    //---------------------------------------
    public function term_languages_relations($term_id, &$term_languages_list): array
    {
        if (pll_get_term_language($term_id) == 'es') {
            $term_languages_list['es'] = $term_id;
        } elseif (pll_get_term_language($term_id) == 'en') {
            $term_languages_list['en'] = $term_id;
        } elseif (pll_get_term_language($term_id) == 'fr') {
            $term_languages_list['fr'] = $term_id;
        }
        return $term_languages_list;
    }

    //---------------------------------------
    // Method that relates post_types
    //---------------------------------------
    public function post_types_relation($post, $pimcore_field, $post_type, $languaje): array
    {
        $relations_list = [];
        foreach ($post["$pimcore_field"] as $personalizacion) {
            $personalizacion_post = get_posts([
                'post_type' => "$post_type",
                'lang' => "$languaje",
                'meta_key' => 'pimcore_id',
                'meta_value' => $personalizacion['id'],
                'numberposts' => 1,
            ]);
            if (!empty($personalizacion_post)) {
                $relations_list[] = $personalizacion_post[0]->ID;
            }
        }
        return $relations_list;
    }
}
