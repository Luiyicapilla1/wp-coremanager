<?php

namespace wp_coremanager\Modules\Cron;

use wp_coremanager\Module;
use wp_coremanager\Modules\GpuSync;

class GpuSyncCron extends Module
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
        if (! wp_next_scheduled('wp_delvalle_sync_gpu_event')) {
            wp_schedule_event(time(), 'twicedaily', 'wp_delvalle_sync_gpu_event');
        }
        // Asocia el evento a la función de sincronización
        add_action('wp_delvalle_sync_gpu_event', [$this, 'trigger_sync']);
    }

    /**
     * Ejecuta la sincronización de productos llamando a VentajasSync.
     *
     * @return void
     */
    public function trigger_sync()
    {
        $sync = new GpuSync();
        $sync->sync_gpu(false);
    }

    /**
     * Desactiva el cron job al desactivar el plugin, evitando ejecuciones innecesarias.
     *
     * @return void
     */
    public function desactivar_cron()
    {
        $timestap = wp_next_scheduled('wp_delvalle_sync_gpu_event');
        if ($timestap) {
            wp_unschedule_event($timestap, 'wp_delvalle_sync_gpu_event');
        }
    }
}
