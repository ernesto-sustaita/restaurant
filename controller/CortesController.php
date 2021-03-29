<?php
namespace controller;

use model\Corte;

/**
 *
 * @author ernesto
 *        
 */
class CortesController
{
    public static function crear(int $usuarioId, array $detallesCorte){
        $corte = new Corte();
        
        $corte->setUsuarioId($usuarioId);
        
        return $corte->crear($detallesCorte);
    }
    
    public static function obtenerCortePorFechaActual(){
        $corte = new Corte();
        
        return $corte->obtenerCortePorFechaActual();
    }
    
    public static function obtenerDetallesCorte(int $id){
        $corte = new Corte();
        
        $corte->setId($id);
        
        return $corte->obtenerDetallesCorte();
    }
}

