<?php
namespace controller;

use model\Insumo;

/**
 *
 * @author ernesto
 *
 */
class InsumosController
{
    public static function consultar(){
        $insumo = new Insumo();
        
        return $insumo->consultar();
    }
    
    public static function consultarActivos(){
        $insumo = new Insumo();
        
        return $insumo->consultarActivos();
    }
    
    public static function crear(string $_nombre, int $_existencia = NULL, bool $_alerta = NULL, int $_estatus = NULL ) {
        $insumo = new Insumo();
        
        $insumo->setNombre($_nombre);
        $insumo->setExistencia($_existencia);
        $insumo->setAlerta($_alerta);
        $insumo->setEstatus($_estatus);
        
        return $insumo->crear();
    }
    
    public static function actualizar(int $_id, string $_nombre, int $_existencia = NULL, bool $_alerta = NULL, int $_estatus ) {
        $insumo = new Insumo();
        
        $insumo->setId($_id);
        $insumo->setNombre($_nombre);
        $insumo->setExistencia($_existencia);
        $insumo->setAlerta($_alerta);
        $insumo->setEstatus($_estatus);
        
        return $insumo->actualizar();
    }
    
    public static function eliminar($_id){
        $insumo = new Insumo();
        
        $insumo->setId($_id);
        
        return $insumo->eliminar();
    }
}

