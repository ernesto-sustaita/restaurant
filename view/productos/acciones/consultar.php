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

$productos = ProductosController::consultar();

while ($producto = $productos->fetch_object()) {
    if($producto->estatus == 0) {
        echo "<tr style='color:red'>";
    } else {
        echo "<tr>";
    }
    echo "<td id='nombre$producto->id'>$producto->nombre</td>";
    echo "<td id='existencia$producto->id'>$producto->precio</td>";
    echo "<td>";
    echo "<button class='btn btn-secondary' data-bs-toggle='modal' data-bs-target='#modalActualizar' onclick='cargarDatos($producto->id)'><i class='bi bi-pencil'></i></button>";
    echo "<button class='btn btn-secondary' data-bs-toggle='modal' data-bs-target='#modalEliminar' onclick='cargarDatosEliminar($producto->id)'><i class='bi bi-x-circle'></i></button>";
    echo "</td>";
    echo "</tr>";
}