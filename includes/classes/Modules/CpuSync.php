<?php

namespace wp_coremanager\Modules;

use wp_coremanager\Module;
use wp_coremanager\Services\GraphQLClient;

set_time_limit(0);

class CpuSync extends Module
{
    public $load_order = 15;
    private const PIM_URL = 'http://127.0.0.1:8080';

    public function puede_registrar()
    {
        return true;
    }

    public function registrar()
    {
        // Noncompliant - method is empty
    }

    public function sync_cpu(bool $force = false)
    {
        require_once CM_PLUGIN_PATH . 'queries/queries.php';
        $client = new GraphQLClient;
        $query = \CPU_QUERY;
        $data = $client->query($query);
        foreach ($data['getProductoListing']['edges'] as $edge) {
            $post = $edge['node'];
            $languages = ['es', 'en', 'fr'];
            $post_languages_list = [
                'es' => null,
                'en' => null,
                'fr' => null
            ];
            foreach ($languages as $language) {
                $exist = get_posts([
                    'post_type' => 'cpu',
                    'lang' => $language,
                    'meta_key' => 'pimcore_id',
                    'meta_value' => $post['id'],
                    'numberposts' => 1,
                ]);

                if (!empty($exist)) {
                    $post_id = $exist[0]->ID;
                    wp_update_post([
                        'ID' => $post_id,
                        'lang' => $language,
                        'post_title' => $post['nombre_' . $language],
                        'post_content' => $post['descripcion_' . $language],
                    ]);
                } else {
                    $post_id = wp_insert_post([
                        'post_type' => 'cpu',
                        'lang' => $language,
                        'post_title' => $post['nombre_' . $language],
                        'post_content' => $post['descripcion_' . $language],
                        'post_status' => 'publish',
                        'post_autor' => 1,
                    ]);
                    pll_set_post_language($post_id, $language);

                    update_post_meta($post_id, 'pimcore_id', $post['id']);
                }
                $post_idioms_list = $this->post_languages_relations($post_id, $post_languages_list);

                if ($post['modificationDate'] != get_post_meta($post_id, 'modification_date')[0] || $force) {


                    //---------------------------------------
                    // Logic Images
                    //---------------------------------------
                    $image_id = get_field('imagen', $post_id);
                    if ($image_id != 121471) {
                        wp_delete_attachment($image_id, true);
                    } else {
                        update_field('imagen', null, $post_id);
                    }
                    if ($language == 'es') {
                        $image_post = $this->set_image_from_wp_media(self::PIM_URL . $post['imagen']['fullpath'], $post_id);
                        update_field('imagen', $image_post, $post_id);
                        FolderModel::setFoldersForPosts($image_post, $folder);
                    } else {
                        if ($image_post != null) {
                            update_field('imagen', $image_post, $post_id);
                            FolderModel::setFoldersForPosts($image_post, $folder);
                        }
                    }
                    //PLACEHOLDER
                    if (get_field('imagen', $post_id) == null) {
                        update_field('imagen', 121471, $post_id);
                    }

                    //---------------------------------------
                    // ACF Fields Relations
                    //---------------------------------------
                    update_field('sku', $post['sku_' . $language], $post_id);
                    update_field('ean', $post['ean_' . $language], $post_id);
                    update_field('nombre', $post['nombre_' . $language], $post_id);
                    update_field('slug', $post['slug_' . $language], $post_id);
                    update_field('ivan', $post['iva'], $post_id);
                    update_field('stock', $post['stock'], $post_id);
                    update_field('descripcion', $post['descripcion_' . $language], $post_id);
                    update_field('titulo_seo', $post['titulo_seo_' . $language], $post_id);
                    update_field('descripcion_seo', $post['descripcion_seo_' . $language], $post_id);
                    update_field('socket', $post['socket'], $post_id);
                    update_field('cores', $post['cores'], $post_id);
                    update_field('threads', $post['threads'], $post_id);
                    update_field('baselock', $post['baseclock'], $post_id);
                    update_field('boostlock', $post['boostclock'], $post_id);
                    update_field('tdp', $post['tdp'], $post_id);
                    update_field('architecture', $post['architecture'], $post_id);
                }

                //Modification Date Post Meta
                update_post_meta($post_id, 'modification_date', $post['modificationDate']);
            }
            pll_save_post_translations($post_idioms_list);
        }
    }
}
