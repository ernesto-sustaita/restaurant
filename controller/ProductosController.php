<?php
namespace controller;

use model\Producto;

/**
 *
 * @author ernesto
 *        
 */
class ProductosController
{
    public static function consultar(){
        $producto = new Producto();
        
        return $producto->consultar();
    }
    
    public static function consultarActivos(){
        $producto = new Producto();
        
        return $producto->consultarActivos();
    }
    
    public static function filtrar($filtro){
        $producto = new Producto();
        
        return $producto->filtrar($filtro);
    }
    
    public static function filtrarActivos($filtro){
        $producto = new Producto();
        
        return $producto->filtrarActivos($filtro);
    }
    
    public static function filtrarPorCategoria($idCategoria){
        $producto = new Producto();
        
        return $producto->filtrarPorCategoria($idCategoria);
    }
    
    public static function filtrarActivosPorCategoria($idCategoria){
        $producto = new Producto();
        
        return $producto->filtrarActivosPorCategoria($idCategoria);
    }
    
    public static function ordenar($tipoFiltro){
        $producto = new Producto();
        
        return $producto->ordenar($tipoFiltro);
    }
    
    public static function ordenarActivos($tipoFiltro){
        $producto = new Producto();
        
        return $producto->ordenarActivos($tipoFiltro);
    }
    
    public static function consultarPorId($id) {
        $producto = new Producto();
        
        $producto->setId($id);
        
        return $producto->consultarPorId();
    }
    
    public static function consultarImpuestosPorProducto($id){
        $producto = new Producto();
        
        $producto->setId($id);
        
        return $producto->consultarImpuestosPorProducto();
    }
    
    public static function consultarCategoriasPorProducto($id){
        $producto = new Producto();
        
        $producto->setId($id);
        
        return $producto->consultarCategoriasPorProducto();
    }
    
    public static function consultarInsumosPorProducto($id){
        $producto = new Producto();
        
        $producto->setId($id);
        
        return $producto->consultarInsumosPorProducto();
    }
    
    public static function crear(string $nombre, float $precio, int $estatus, array $datosInsumos, array $datosImpuestos, array $datosCategorias) {
        $producto = new Producto();
        
        $producto->setNombre($nombre);
        $producto->setPrecio($precio);
        $producto->setEstatus($estatus);
        $producto->setDatosInsumos($datosInsumos);
        $producto->setDatosImpuestos($datosImpuestos);
        $producto->setDatosCategorias($datosCategorias);
        
        return $producto->crear();
    }
    
    public static function actualizar(int $_id, string $_nombre, float $_precio, int $_estatus, array $datosInsumos, array $datosImpuestos, array $datosCategorias) {
        $producto = new Producto();
        
        $producto->setId($_id);
        $producto->setNombre($_nombre);
        $producto->setPrecio($_precio);
        $producto->setEstatus($_estatus);
        $producto->setDatosInsumos($datosInsumos);
        $producto->setDatosImpuestos($datosImpuestos);
        $producto->setDatosCategorias($datosCategorias);
        
        return $producto->actualizar();
    }
    
    /**
     * 
     * @param int $_id
     * @return int 0 si falló la consulta, 1 si se eliminó el producto y los registros asociados (categorías, insumos, impuestos) y 2 si solo se desactivó porque ya está en comandas
     */
    public static function eliminar(int $_id) : int{
        $producto = new Producto();
        
        $producto->setId($_id);
        
        return $producto->eliminar();
    }
}

