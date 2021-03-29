<?php

session_start();

if(!isset($_SESSION['tipoUsuarix']) || $_SESSION['tipoUsuarix'] != 2){
    // En las acciones que se solicitan por AJAX se envía este código para avisar que se está desconectado
    http_response_code(403);
    exit();
}

require_once '../../../database/DB.php';
require_once '../../../model/Insumo.php';
require_once '../../../controller/InsumosController.php';

use controller\InsumosController;

$insumos = InsumosController::consultar();

while ($insumo = $insumos->fetch_object()) {
    if($insumo->estatus == 0) {
        echo "<tr style='color:red'>";
    } else {
        echo "<tr>";
    }
    echo "<td id='nombre$insumo->id'>$insumo->nombre</td>";
    echo "<td id='existencia$insumo->id'>$insumo->existencias</td>";
    if($insumo->alerta == 1){
        echo "<td><input id='alerta$insumo->id' type='hidden' value='$insumo->alerta'/>Sí</td>";
    } else {
        echo "<td><input id='alerta$insumo->id' type='hidden' value='$insumo->alerta'/>No</td>";
    }
    if($insumo->estatus == 1){
        echo "<td><input id='estatus$insumo->id' type='hidden' value='$insumo->estatus'/>Activo</td>";
    } else {
        echo "<td><input id='estatus$insumo->id' type='hidden' value='$insumo->estatus'/>Inactivo</td>";
    }
    echo "<td>";
    echo "<button class='btn btn-secondary' data-bs-toggle='modal' data-bs-target='#modalActualizar' onclick='cargarDatos($insumo->id)'><i class='bi bi-pencil'></i></button>";
    echo "<button class='btn btn-secondary' data-bs-toggle='modal' data-bs-target='#modalEliminar' onclick='cargarDatosEliminar($insumo->id)'><i class='bi bi-x-circle'></i></button>";
    echo "</td>";
    echo "</tr>";
}