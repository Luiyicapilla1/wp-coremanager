<?php

/**
 * Funcinalidad Principal
 *
 * @package WP-Delvalle
 */

namespace wp_coremanager\Core;

use wp_coremanager\ModuleInitialization;
use wp_coremanager\Modules\Cron\GpuSyncCron;

/**
 * Rutina de preparación predefinida
 *
 * @return void
 */
function setup()
{
    add_action('init', __NAMESPACE__ . '\init', apply_filters('ac_init_priority', 8));
    add_action('admin_enqueue_scripts', __NAMESPACE__ . '\admin_styles');
}

/**
 * Inicialización del plugin
 *
 * @return void
 */
function init()
{
    //Mostrar aviso si el archivo composer.json no esta.
    if (! file_exists(CM_PLUGIN_PATH . 'composer.json')) {
        add_action(
            'admin-notices',
            function () {
                $class = 'notice notice-error';

                $message = sprintf('El archivo composer.json no se ha encontrado dentro de %s. No se cargará ninguna clase.', CM_PLUGIN_PATH);

                printf('<div class="%1$s"><p>%2$s</p></div>', esc_attr($class), esc_html($message));
            }
        );
        return;
    }
    //Cargar los modulos
    ModuleInitialization::instance()->init_classes();
}

/**
 * Activar el plugin
 *
 * @return void
 */
function activate()
{
    flush_rewrite_rules();
}

/**
 * Desactivar plugin
 *
 * @return void
 */
function deactivate()
{
    flush_rewrite_rules();

    $gpuCron = new GpuSyncCron();
    $gpuCron->desactivar_cron();
}

/**
 * Encolar estilos
 *
 * @return void
 */
function admin_styles()
{
    wp_enqueue_style('del_admin_styles', CM_PLUGIN_URL . 'assets/css/admin/style.css', array(), CM_PLUGIN_VERSION);
}
