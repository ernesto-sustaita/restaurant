<?php

session_start();

if(!isset($_SESSION['tipoUsuarix']) || $_SESSION['tipoUsuarix'] != 2){
    // En las acciones que se solicitan por AJAX se envía este código para avisar que se está desconectado
    http_response_code(403);
    exit();
}

require_once '../../../database/DB.php';
require_once '../../../model/Usuario.php';
require_once '../../../controller/UsuariosController.php';

use controller\UsuariosController;

$usuarios = UsuariosController::consultarUsuarios();

while ($usuario = $usuarios->fetch_object()) {
    if($usuario->estatus == 0) {
        echo "<tr style='color:red'>";
    } else {
        echo "<tr>";
    }
    echo "<td id='nombre$usuario->id'>$usuario->username</td>";
    if($usuario->profile == 1){
        echo "<td><input id='tipo$usuario->id' type='hidden' value='$usuario->profile'/>Vendedorx</td>";
    } else {
        echo "<td><input id='tipo$usuario->id' type='hidden' value='$usuario->profile'/>Administradorx</td>";
    }
    echo "<td>" . date('d/m/Y',$usuario->reg_date) . "</td>";
    if($usuario->estatus == 1){
        echo "<td><input id='estatus$usuario->id' type='hidden' value='$usuario->estatus'/>Activx</td>";
    } else {
        echo "<td><input id='estatus$usuario->id' type='hidden' value='$usuario->estatus'/>Inactivx</td>";
    }
    echo "<td>";
    echo "<button class='btn btn-secondary' data-bs-toggle='modal' data-bs-target='#modalActualizar' onclick='cargarDatos($usuario->id)'><i class='bi bi-pencil'></i></button>";
    echo "<button class='btn btn-secondary' data-bs-toggle='modal' data-bs-target='#modalEliminar' onclick='cargarDatosEliminar($usuario->id)'><i class='bi bi-x-circle'></i></button>";
    echo "</td>";
    echo "</tr>";
}