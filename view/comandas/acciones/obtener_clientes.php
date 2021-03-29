<?php
session_start();

if(!isset($_SESSION['conectadx']) || !$_SESSION['conectadx']){
    // En las acciones que se solicitan por AJAX se envía este código para avisar que se está desconectado
    http_response_code(403);
    exit();
}

require_once '../../../database/DB.php';
require_once '../../../model/Cliente.php';
require_once '../../../controller/ClientesController.php';

use controller\ClientesController;

$clientes = null;

if(isset($_GET['filtro']) && $_GET['filtro'] != "")
{
    $clientes = ClientesController::buscarActivxs($_GET['filtro']);
} else {
    $clientes = ClientesController::consultarActivxs();
}

while ($cliente = $clientes->fetch_object()) {
    echo "<button type='button' class='list-group-item list-group-item-action' onclick='incluirCliente($cliente->id, \"$cliente->nombre $cliente->apellidos\")'>$cliente->nombre $cliente->apellidos</button>";
}