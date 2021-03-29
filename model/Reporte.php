<?php
namespace model;

require_once 'Producto.php';

use database\DB;

/**
 *
 * @author ernesto
 *        
 */
class Reporte
{
    private $db;
    
    public function __construct(){
        $this->db = DB::getInstance();
    }
    
    public function obtenerCantidadProductosVendidosHoy(){
        $producto = new Producto();
        
        return $producto->obtenerCantidadProductosVendidosHoy();
    }
}

