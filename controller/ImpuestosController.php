<?php
namespace controller;

use model\Impuesto;

/**
 *
 * @author ernesto
 *
 */
class ImpuestosController
{
    public static function consultar(){
        $impuesto = new Impuesto();
        
        return $impuesto->consultar();
    }
    
    public static function consultarActivos(){
        $impuesto = new Impuesto();
        
        return $impuesto->consultarActivos();
    }
    
    public static function crear(string $_nombre, float $_porcentaje, int $_estatus) {
        $impuesto = new Impuesto();
        
        $impuesto->setNombre($_nombre);
        $impuesto->setPorcentaje($_porcentaje);
        $impuesto->setEstatus($_estatus);
        
        return $impuesto->crear();
    }
    
    public static function actualizar(int $_id, string $_nombre, float $_porcentaje, int $_estatus) {
        $impuesto = new Impuesto();
        
        $impuesto->setId($_id);
        $impuesto->setNombre($_nombre);
        $impuesto->setPorcentaje($_porcentaje);
        $impuesto->setEstatus($_estatus);
        
        return $impuesto->actualizar();
    }
    
    public static function eliminar($_id){
        $impuesto = new Impuesto();
        
        $impuesto->setId($_id);
        
        return $impuesto->eliminar();
    }
}

