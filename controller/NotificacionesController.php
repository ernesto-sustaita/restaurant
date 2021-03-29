<?php
namespace controller;

use model\Notificacion;

/**
 *
 * @author ernesto
 *        
 */
class NotificacionesController
{
    public static function consultarCantidadNotificacionesExistenciaNoVistas(){
        $notificacion = new Notificacion();
        
        return $notificacion->consultarCantidadNotificacionesExistenciaNoVistas();
    }
    
    public static function consultarCantidadNotificacionesComandaNoVistas(){
        $notificacion = new Notificacion();
        
        return $notificacion->consultarCantidadNotificacionesComandaNoVistas();
    }
    
    public static function consultarNotificacionesExistencias(){
        $notificacion = new Notificacion();
        
        return $notificacion->consultarNotificacionesExistencias();
    }
    
    public static function consultarNotificacionesComandas(){
        $notificacion = new Notificacion();
        
        return $notificacion->consultarNotificacionesComandas();
    }
    
    public static function marcarComoLeida(int $id){
        $notificacion = new Notificacion();
        
        $notificacion->setId($id);
        
        return $notificacion->marcarComoLeida();
    }
}

