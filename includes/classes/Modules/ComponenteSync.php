<?php

namespace wp_coremanager\Modules;

use wp_coremanager\Module;
use wp_coremanager\Services\GraphQLClient;


class ComponenteSync extends Module
{
    public $load_order = 10;

    public function puede_registrar()
    {
        return true;
    }

    public function registrar()
    {
        // Noncompliant - method is empty
    }

    public function sync_componente(bool $force = false)
    {
        require_once CM_PLUGIN_PATH . 'queries/queries.php';
        $client = new GraphQLClient;
        $query = \COMPONENTES_QUERY;
        $data = $client->query($query);
        foreach ($data['getComponenteListing']['edges'] as $edge) {
            $post = $edge['node'];
            $languages = ['es', 'en', 'fr'];
            $post_languages_list = [
                'es' => null,
                'en' => null,
                'fr' => null
            ];
            foreach ($languages as $language) {
                $exist = get_posts([
                    'post_type' => 'componente',
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
                        'post_title' => $post['titulo_' . $language],
                        'post_content' => $post['descripcion_' . $language],
                    ]);
                } else {
                    $post_id = wp_insert_post([
                        'post_type' => 'ventaja',
                        'lang' => $language,
                        'post_title' => $post['titulo_' . $language],
                        'post_content' => $post['descripcion_' . $language],
                        'post_status' => 'publish',
                        'post_autor' => 1,
                    ]);
                    pll_set_post_language($post_id, $language);

                    update_post_meta($post_id, 'pimcore_id', $post['id']);
                }
                $post_idioms_list = $this->post_languages_relations($post_id, $post_languages_list);

                if ($post['modificationDate'] != get_post_meta($post_id, 'modification_date')[0] || $force) {
                    //TODO: Implementación sincronización campos Componente
                }

                //Modification Date Post Meta
                update_post_meta($post_id, 'modification_date', $post['modificationDate']);
            }
            pll_save_post_translations($post_idioms_list);
        }
    }
}
