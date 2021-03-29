<?php

session_start();

if(!isset($_SESSION['tipoUsuarix']) || $_SESSION['tipoUsuarix'] != 2){
    // En las acciones que se solicitan por AJAX se envía este código para avisar que se está desconectado
    http_response_code(403);
    exit();
}

require_once '../../../database/DB.php';
require_once '../../../model/Categoria.php';
require_once '../../../controller/CategoriasController.php';

use controller\CategoriasController;

$categorias = CategoriasController::consultar();

while ($categoria = $categorias->fetch_object()) {
    if($categoria->estatus == 0) {
        echo "<tr style='color:red'>";
    } else {
        echo "<tr>";
    }
    echo "<td id='nombre$categoria->id'>$categoria->nombre</td>";
    if($categoria->estatus == 1){
        echo "<td><input id='estatus$categoria->id' type='hidden' value='$categoria->estatus'/>Activa</td>";
    } else {
        echo "<td><input id='estatus$categoria->id' type='hidden' value='$categoria->estatus'/>Inactiva</td>";
    }
    echo "<td>";
    echo "<button class='btn btn-secondary' data-bs-toggle='modal' data-bs-target='#modalActualizar' onclick='cargarDatos($categoria->id)'><i class='bi bi-pencil'></i></button>";
    echo "<button class='btn btn-secondary' data-bs-toggle='modal' data-bs-target='#modalEliminar' onclick='cargarDatosEliminar($categoria->id)'><i class='bi bi-x-circle'></i></button>";
    echo "</td>";
    echo "</tr>";
}