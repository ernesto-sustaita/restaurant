<?php
session_start();

if(!isset($_SESSION['conectadx']) || !$_SESSION['conectadx']){
    // En las acciones que se solicitan por AJAX se envía este código para avisar que se está desconectado
    http_response_code(403);
    exit();
}

require_once '../../../database/DB.php';
require_once '../../../model/Comanda.php';
require_once '../../../controller/ComandasController.php';

use controller\ComandasController;

if(isset($_GET['id']) && $_GET['id'] != ''){
    
    $cantidadDetallesComandaPendientes = ComandasController::obtenerCantidadDetallesComandaPendientes($_GET['id']);
    
    $cantidadDetallesComandaPendientes = $cantidadDetallesComandaPendientes->fetch_object();
    
    if($cantidadDetallesComandaPendientes->DetallesPendientes > 0){
        echo true;
    } else {
        // Se cambia el estatus de la comanda a preparada si ya no queda ningún detalle sin preparar
        ComandasController::marcarComandaPreparada($_GET['id']);
        
        echo false;
    }
}