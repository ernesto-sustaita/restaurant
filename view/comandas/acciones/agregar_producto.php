<?php
session_start();

if(!isset($_SESSION['conectadx']) || !$_SESSION['conectadx']){
    // En las acciones que se solicitan por AJAX se envía este código para avisar que se está desconectado
    http_response_code(403);
    exit();
}

require_once '../../../database/DB.php';
require_once '../../../model/Comanda.php';
require_once '../../../controller/ComandasController.php';
require_once '../../../model/Producto.php';
require_once '../../../controller/ProductosController.php';

use controller\ComandasController;
use controller\ProductosController;

if(isset($_POST['idComanda']) && $_POST['idComanda'] != '' && isset($_POST['idProducto']) && $_POST['idProducto'] != ''){
    
    if(ComandasController::agregarProducto($_POST['idComanda'], $_POST['idProducto'])){
        $resultadoProducto = ProductosController::consultarPorId($_POST['idProducto']);
        
        $stringInformacionProducto = "";
        $precioProducto = 0;
        if($resultadoProducto != NULL){
            $producto = $resultadoProducto->fetch_object();
              
            $stringInformacionProducto = "<tr id='productoComanda$producto->id'>
                                            <td colspan='3'><input type='hidden' name='idProducto' value='$producto->id'/>
                                                <span class='badge bg-light' style='font-size:large;color:black'>$producto->nombre</span>
                                            </td>
                                          </tr>";
            $stringInformacionProducto .= "<tr id='controlesProductoComanda$producto->id'>
                                            <td colspan='2'>
                                                <button class='btn btn-secondary' type='button' onclick='if(this.nextSibling.value > 1){this.nextSibling.value=parseInt(this.nextSibling.value)-1;actualizarCantidad($_POST[idComanda],$producto->id,this.nextSibling.value)}'><i class='bi-dash-circle'></i></button><input type='text' class='numero-mini' name='cantidadProducto' value='1' readonly='readonly'/><button class='btn btn-secondary' type='button' onclick='this.previousSibling.value=parseInt(this.previousSibling.value)+1;actualizarCantidad($_POST[idComanda],$producto->id,this.previousSibling.value)'><i class='bi-plus-circle'></i></button>
                                                <button class='btn btn-secondary' type='button' onclick='eliminarProductoComanda($_POST[idComanda],$producto->id)'><i class='bi-x-circle'></i></button>
                                            </td>
                                            <td class='precio'><input type='hidden' id='precio$producto->id' value='$producto->precio'/>$producto->precio</td> 
                                           </tr>";
            $precioProducto = $producto->precio;
        }
        
        $resultadoImpuestos = ProductosController::consultarImpuestosPorProducto($_POST['idProducto']);
        
        if($resultadoImpuestos != NULL){
            while ($impuesto = $resultadoImpuestos->fetch_object()) {
                
                $cargoImpuesto = ($impuesto->porcentaje * $precioProducto) / 100;
                
                $stringInformacionProducto .= "<tr class='impuesto$_POST[idProducto]'>
                                                <td style='text-align:right'>$impuesto->nombre</td>
                                                <td>%$impuesto->porcentaje</td>
                                                <td class='precio'><input type='hidden' class='porcentajeImpuesto$_POST[idProducto]' value='$impuesto->porcentaje'/>$cargoImpuesto</td>
                                              </tr>";
            }
        }
        
        // Enseguida hay que buscar si acaso el producto tiene impuestos asociados, para traerlos y calcularlos
        // Aquí también se tendrían que rebajar los insumos que tenga asociado dicho producto, para que se refleje en su inventario
        // Y calcular (o recalcular) el total de la orden
        
        echo $stringInformacionProducto;
    } else {
        echo false;
    }
}