<?php
session_start();

if(!isset($_SESSION['tipoUsuarix']) || $_SESSION['tipoUsuarix'] != 2){
    // En las acciones que se solicitan por AJAX se envía este código para avisar que se está desconectado
    http_response_code(403);
    exit();
}

require_once '../../../database/DB.php';
require_once '../../../model/Producto.php';
require_once '../../../controller/ProductosController.php';

use controller\ProductosController;

if(isset($_GET['id'])){
    $resultadoProducto = ProductosController::consultarPorId($_GET['id']);
    
    $datosProducto = array();
    if($resultadoProducto->num_rows > 0) {
        $datosProducto = $resultadoProducto->fetch_assoc();
        
        $resultadoCategorias = ProductosController::consultarCategoriasPorProducto($_GET['id']);
        
        $categorias = array();
        if($resultadoCategorias->num_rows > 0) {
            $categorias = $resultadoCategorias->fetch_all(MYSQLI_ASSOC);
        }
        
        $resultadoImpuestos = ProductosController::consultarImpuestosPorProducto($_GET['id']);
        
        $impuestos = array();
        if($resultadoImpuestos->num_rows > 0) {
            $impuestos = $resultadoImpuestos->fetch_all(MYSQLI_ASSOC);
        }
        
        $resultadoInsumos = ProductosController::consultarInsumosPorProducto($_GET['id']);
        
        $insumos = array();
        if($resultadoInsumos->num_rows > 0) {
            $insumos = $resultadoInsumos->fetch_all(MYSQLI_ASSOC);
        }
        
        $datosProducto['categorias'] = $categorias;
        $datosProducto['impuestos'] = $impuestos;
        $datosProducto['insumos'] = $insumos;
    }
    
    //Aunque el content-type no sea un problema en la mayoría de casos, es recomendable especificarlo
    header('Content-type: application/json; charset=utf-8');
    echo json_encode($datosProducto);
    exit();
}

//Aunque el content-type no sea un problema en la mayoría de casos, es recomendable especificarlo
header('Content-type: application/json; charset=utf-8');
echo json_encode(array('mensaje' => false));
exit();