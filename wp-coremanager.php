<?php

/**
 * Plugin Name:                         WP CoreManager
 * Description:                         Funciones personalizadas para gestion de contenidos wp
 * Version:                             1.0
 * Requires at least:                   6.5
 * Requires at least:                   8.2.28
 * Author:                              Luis García Capilla
 * Text Domain:                         wp-coremanager
 * Domain Path:                         /languages
 *
 * @package                             WP-CoreManager
 */

/**
 * Seguridad básica para wrodpress:
 * Si no se ha definido la ruta absoluta del plugin, se cierra la ejecucion.
 * Esto evita que se pueda ejecutar el plugin mediante web escribiendo su ruta de directorios dentro de la instalacion de wordpress.
 */

if (! defined('ABSPATH')) {
    exit;
}

//Definición de constantes globales.
define('CM_PLUGIN_VERSION', '1.0');
define('CM_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('CM_PLUGIN_URL', plugin_dir_url(__FILE__));
define('CM_PLUGIN_INC', CM_PLUGIN_PATH . 'includes/');
define('CM_PLUGIN_SLUG', 'wp-coremanager');
define('CM_API_NAMESPACE', 'ac/v1');

/**
 * Variables Globales:
 * Esta variable, es una variable de tipo boleano que devuelve true si el estado de la variable coincide con alguno de los del array y si no devuelve false.
 * Esto nos permite comprobar si nuestro wordpress esta en produccion o no.
 */
$id_dev = in_array(wp_get_environment_type(), array('development', 'staging', 'local'), true);

/**
 * Cargar el autoloader de composer:
 * Este bloque nos permite cargar las dependencias externas que instalemso y administraemos con composer y para usar el autoloading en clases peropias.
 */
if (file_exists(CM_PLUGIN_PATH . 'vendor/autoload.php')) {
    require_once CM_PLUGIN_PATH . 'vendor/autoload.php';
}

/**
 * Carga de archivos principales del plugin:
 * Este bloque nos permite cargar una sola vez lso archivos principales necesarios para que el plugin funcione correctamente.
 */
require_once CM_PLUGIN_INC . '/core.php';

//Activación y desactivación del plugin.
register_activation_hook(__FILE__, 'wp_coremanager\Core\activate');
register_deactivation_hook(__FILE__, 'wp_coremanager\Core\deactivate');

//Cargar la configuracion del plugin
wp_coremanager\Core\setup();
