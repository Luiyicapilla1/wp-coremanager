<?php

namespace wp_coremanager\Modules\Cron;

use wp_coremanager\Module;
use wp_coremanager\Modules\PlacaBaseSync;

class PlacaBaseSyncCron extends Module
{
    public $load_order = 10;

    public function puede_registrar()
    {
        return true;
    }

    /**
     * Registra el cron job y el hook de sincronización.
     * Añade un intervalo personalizado y programa el evento si no existe.
     *
     * @return void
     */
    public function registrar()
    {
        // Programa el evento si aún no está programado
        if (! wp_next_scheduled('wp_coremanager_sync_placa_base_event')) {
            wp_schedule_event(time(), 'twicedaily', 'wp_coremanager_sync_placa_base_event');
        }
        // Asocia el evento a la función de sincronización
        add_action('wp_coremanager_sync_placa_base_event', [$this, 'trigger_sync']);
    }

    /**
     * Ejecuta la sincronización.
     *
     * @return void
     */
    public function trigger_sync()
    {
        $sync = new PlacaBaseSync();
        $sync->sync_placa_base(false);
    }

    /**
     * Desactiva el cron job al desactivar el plugin, evitando ejecuciones innecesarias.
     *
     * @return void
     */
    public function desactivar_cron()
    {
        $timestap = wp_next_scheduled('wp_coremanager_sync_placa_base_event');
        if ($timestap) {
            wp_unschedule_event($timestap, 'wp_coremanager_sync_placa_base_event');
        }
    }
}
