<?php
namespace controller;

use model\Reporte;

/**
 *
 * @author ernesto
 *        
 */
class ReportesController
{
    public static function obtenerCantidadProductosVendidosHoy() : array{
        $reporte = new Reporte();
        
        $datosProductos = $reporte->obtenerCantidadProductosVendidosHoy();
        
        // Ordenamiento por burbuja
        $cantidadProductos = count($datosProductos);
        $contador1 = 0;
        $contador2 = 0;
        $burbujaNombre = "";
        $burbujaCantidad = 0;
        while($contador1 < $cantidadProductos) {
            while ($contador2 < $cantidadProductos-1) {
                if($datosProductos[$contador2]['cantidad'] < $datosProductos[$contador2+1]['cantidad']) {
                    $burbujaNombre = $datosProductos[$contador2+1]['nombre'];
                    $burbujaCantidad = $datosProductos[$contador2+1]['cantidad'];
                    
                    $datosProductos[$contador2+1]['nombre'] = $datosProductos[$contador2]['nombre'];
                    $datosProductos[$contador2+1]['cantidad'] = $datosProductos[$contador2]['cantidad'];
                    
                    $datosProductos[$contador2]['nombre'] = $burbujaNombre;
                    $datosProductos[$contador2]['cantidad'] = $burbujaCantidad;
                }
                $contador2++;
            }
            $contador1++;
            $contador2 = 0;
        }
        
        // Formateo del array según necesidades de Google Charts
        $productos = array();
        foreach ($datosProductos as $producto) {
            array_push($productos,array("c"=>[array("v"=>$producto['nombre'],"f"=>NULL),array("v"=>$producto['cantidad'],"f"=>NULL)]));
        }
        
        $datosGrafica = array(
            "cols" => [array("id"=>"","label"=>"Producto","pattern"=>"","type"=>"string"),array("id"=>"","label"=>"Cantidad","pattern"=>"","type"=>"number")],
            "rows" => $productos
        );
        
        return $datosGrafica;
    }
}

