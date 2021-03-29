<?php

session_start();

if(!isset($_SESSION['tipoUsuarix']) || $_SESSION['tipoUsuarix'] != 2){
    // En las acciones que se solicitan por AJAX se envía este código para avisar que se está desconectado
    http_response_code(403);
    exit();
}

require_once '../../../database/DB.php';
require_once '../../../model/Impuesto.php';
require_once '../../../controller/ImpuestosController.php';

use controller\ImpuestosController;

$impuestos = ImpuestosController::consultar();

while ($impuesto = $impuestos->fetch_object()) {
    if($impuesto->estatus == 0) {
        echo "<tr style='color:red'>";
    } else {
        echo "<tr>";
    }
    echo "<td id='nombre$impuesto->id'>$impuesto->nombre</td>";
    echo "<td id='porcentaje$impuesto->id'>$impuesto->porcentaje</td>";
    if($impuesto->estatus == 1){
        echo "<td><input id='estatus$impuesto->id' type='hidden' value='$impuesto->estatus'/>Activo</td>";
    } else {
        echo "<td><input id='estatus$impuesto->id' type='hidden' value='$impuesto->estatus'/>Inactivo</td>";
    }
    echo "<td>";
    echo "<button class='btn btn-secondary' data-bs-toggle='modal' data-bs-target='#modalActualizar' onclick='cargarDatos($impuesto->id)'><i class='bi bi-pencil'></i></button>";
    echo "<button class='btn btn-secondary' data-bs-toggle='modal' data-bs-target='#modalEliminar' onclick='cargarDatosEliminar($impuesto->id)'><i class='bi bi-x-circle'></i></button>";
    echo "</td>";
    echo "</tr>";
}