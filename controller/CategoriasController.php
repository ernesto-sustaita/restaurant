<?php
namespace controller;

use model\Categoria;

/**
 *
 * @author ernesto
 *
 */
class CategoriasController
{
    public static function consultar(){
        $categoria = new Categoria();
        
        return $categoria->consultar();
    }
    
    public static function consultarActivas(){
        $categoria = new Categoria();
        
        return $categoria->consultarActivas();
    }
    
    public static function crear(string $_nombre, int $_estatus) {
        $categoria = new Categoria();
        
        $categoria->setNombre($_nombre);
        $categoria->setEstatus($_estatus);
        
        return $categoria->crear();
    }
    
    public static function actualizar(int $_id, string $_nombre, int $_estatus) {
        $categoria = new Categoria();
        
        $categoria->setId($_id);
        $categoria->setNombre($_nombre);
        $categoria->setEstatus($_estatus);
        
        return $categoria->actualizar();
    }
    
    public static function eliminar($_id){
        $categoria = new Categoria();
        
        $categoria->setId($_id);
        
        return $categoria->eliminar();
    }
}

