<?php

/**
 * Inicio automatico de todos los modulos basados en clases del plugin.
 *
 * @package WP-CoreManager
 */

namespace wp_coremanager;

use HaydenPierce\ClassFinder\ClassFinder;
use ReflectionClass;

/**
 * Clase de inicialización del modulo;
 *
 * @package WP-CoreManager
 */

class ModuleInitialization
{
    /**
     * Instancia de clase
     *
     * @var null|ModuleInitialization
     */
    private static $instance = null;

    /**
     * Crear una instancia de la clase
     *
     * @return ModuleInitialization
     */
    public static function instance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Declaramos el constructor com privado para que no se puedan crear istancias de la clase desde fuera para manetner el Singleton.
     */
    private function __construct()
    {
        //...
    }

    /**
     * Lista de todas las clases incializadas
     *
     * @var array<\wp_coremanager\<Module>
     */
    protected $classes = array();

    /**
     * Obtener todos las clases del plugin WP-CoreManager a partir de la ruta especificada en setAppRoot.
     *
     * @return array<string>
     */
    protected function get_classes()
    {
        $class_finder = new ClassFinder();
        $class_finder::setAppRoot(CM_PLUGIN_PATH);

        return $class_finder::getClassesInNamespace('wp_coremanager', ClassFinder::RECURSIVE_MODE);
    }

    /**
     * Iniciar todas las clases del plugin WP-CoreManager usando la funcion get_classes.
     *
     * @return void
     */
    public function init_classes()
    {
        //Array en el que se almacenan las clases por orden de carga.
        $load_class_order = array();

        //Creamos un slug identificador a cada clase apartir del nombre de la clase.
        foreach ($this->get_classes() as $class) {
            $slug = $this->slugify_class_name($class);

            //Si ya hay una clase con ese slug la salta y pasa a la siguiente.
            if (isset($this->classes[$slug])) {
                continue;
            }


            $reflection_class = new ReflectionClass($class);

            //Comprueba que la clase reflection_class sea instanciable y si es una subclase de Module.
            if (! $reflection_class->isInstantiable()) {
                continue;
            }

            if (! $reflection_class->isSubclassOf('\wp_coremanager\Module')) {
                continue;
            }

            //Crea una instancia y comprueba que sea una instancia de module, si no es de module la ignora.
            $instantiated_class = new $class();

            if (! $instantiated_class instanceof Module) {
                continue;
            }

            $load_class_order[intval($instantiated_class->load_order)][] = array(
                'slug' => $slug,
                'class' => $instantiated_class,
            );
        }
        //ordenamos todas las clases medainte el load_order.
        ksort($load_class_order);

        //Inicializamos todas las clases mediante un bucle.
        foreach ($load_class_order as $class_objects) {
            foreach ($class_objects as $class_object) {
                $class = $class_object['class'];
                $slug = $class_object['slug'];

                //Si la clase se puede registrar la registramos
                if ($class->puede_registrar()) {
                    $class->registrar();
                    //Almacenamos la clase registrada dentro de la lista de clases inicializadas.
                    $this->classes[$slug] = $class;
                }
            }
        }
    }

    /**
     * Slugify el nombre de clase
     *
     * @param string $class_name El nombre de clase
     *
     * @return string
     */
    protected function slugify_class_name($class_name)
    {
        return sanitize_title(str_replace('\\', '-', $class_name));
    }

    /**
     * Obtener un clase previamente registrada, apartir de su nombre.
     *
     * @param string $class_name El nombre de clase.
     *
     * @return false|\wp_coremanager\Module
     */
    public function get_class($class_name)
    {
        $class_name = $this->slugify_class_name($class_name);

        if (isset($this->classes[$class_name])) {
            return $this->classes[$class_name];
        }
        return false;
    }

    /**
     * Obtener todas las clases incializadas
     *
     * @return array<\wp_coremanager\Module>
     */
    public function get_all_clases()
    {
        return $this->classes;
    }
}
