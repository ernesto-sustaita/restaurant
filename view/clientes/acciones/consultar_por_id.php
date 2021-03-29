<?php
session_start();

if(!isset($_SESSION['tipoUsuarix']) || $_SESSION['tipoUsuarix'] != 2){
    // En las acciones que se solicitan por AJAX se envía este código para avisar que se está desconectado
    http_response_code(403);
    exit();
}

require_once '../../../database/DB.php';
require_once '../../../model/Cliente.php';
require_once '../../../controller/ClientesController.php';

use controller\ClientesController;

$id = (isset($_POST['id']) && $_POST['id'] != "") ? $_POST['id'] : "";

if($id != ""){
    $clientes = ClientesController::consultarPorId($id);
    
    $cliente = $clientes->fetch_assoc();
    
    $datosContacto = ClientesController::consultarDatosContacto($id);
    
    $cliente["datosContacto"] = $datosContacto->fetch_all();
    
    //Aunque el content-type no sea un problema en la mayoría de casos, es recomendable especificarlo
    header('Content-type: application/json; charset=utf-8');
    echo json_encode($cliente);
    exit();
}