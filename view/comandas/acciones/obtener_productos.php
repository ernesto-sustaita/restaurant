<?php

session_start();

if(!isset($_SESSION['conectadx']) || !$_SESSION['conectadx']){
    // En las acciones que se solicitan por AJAX se envía este código para avisar que se está desconectado
    http_response_code(403);
    exit();
}

require_once '../../../database/DB.php';
require_once '../../../model/Producto.php';
require_once '../../../controller/ProductosController.php';

use controller\ProductosController;

$productos = null;

if(isset($_GET['tipoOrden']) && $_GET['tipoOrden'] != "")
{
    $productos = ProductosController::ordenarActivos($_GET['tipoOrden']);
}elseif(isset($_GET['idCategoria']) && $_GET['idCategoria'] != "")
{
    $productos = ProductosController::filtrarActivosPorCategoria($_GET['idCategoria']);
}elseif(isset($_GET['filtro']) && $_GET['filtro'] != "")
{ 
    $productos = ProductosController::filtrarActivos($_GET['filtro']);
} else {
    $productos = ProductosController::consultarActivos();
}

echo '<div class="row">';
while ($producto = $productos->fetch_object()) {
    if(isset($_GET['idsProductosIgnorar'])){
        $bandera = false;
        foreach ($_GET['idsProductosIgnorar'] as $idProducto){
            if($idProducto['idProducto'] == $producto->id){
                $bandera = true;
            }
        }
        if($bandera){
            echo "<div id='producto$producto->id' class='col-sm-3' onclick='agregarProductoComanda($producto->id)' style='display:none'>";
        } else {
            echo "<div id='producto$producto->id' class='col-sm-3' onclick='agregarProductoComanda($producto->id)'>";
        }
    } else {
        echo "<div id='producto$producto->id' class='col-sm-3' onclick='agregarProductoComanda($producto->id)'>";
    }
    echo '<div class="card text-white bg-secondary tarjeta-producto">';
    echo '<div class="card-body">';
    echo "<h5 class='card-title'>$producto->nombre</h5>";
    echo "<p class='card-text'>$producto->precio</p>";
    //echo '<a href="#" class="btn btn-primary">Go somewhere</a>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
}
echo '</div>';