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

//Array ( [nombre] => Hola [precio] => 1 [estatus] => 1
//[datosInsumos] => Array ( [0] => Array ( [idInsumo] => 1 [cantidad] => 2 ) )
//[datosImpuestos] => Array ( [0] => Array ( [idImpuesto] => 1 ) )
//[datosCategorias] => Array ( [0] => Array ( [idCategoria] => 2 ) ) )

$datos_insumos = (isset($_POST['datosInsumos'])) ? $_POST['datosInsumos'] : array();
$datos_impuestos = (isset($_POST['datosImpuestos'])) ? $_POST['datosImpuestos'] : array();
$datos_categorias = (isset($_POST['datosCategorias'])) ? $_POST['datosCategorias'] : array();

if(ProductosController::crear($_POST['nombre'], $_POST['precio'], $_POST['estatus'], $datos_insumos,
    $datos_impuestos, $datos_categorias)){
    
    $respuesta_json["mensaje"] = true;
    
    //Aunque el content-type no sea un problema en la mayoría de casos, es recomendable especificarlo
    header('Content-type: application/json; charset=utf-8');
    echo json_encode($respuesta_json);
    exit();
}
else {
    $respuesta_json["mensaje"] = false;
    
    //Aunque el content-type no sea un problema en la mayoría de casos, es recomendable especificarlo
    header('Content-type: application/json; charset=utf-8');
    echo json_encode($respuesta_json);
    exit();
}