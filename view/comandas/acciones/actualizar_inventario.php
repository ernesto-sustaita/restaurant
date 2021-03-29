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

if(isset($_POST['idComanda']) && $_POST['idComanda'] != ''){
    if(ComandasController::actualizarInventario($_POST['idComanda'])) {
        echo true;
    } else {
        echo false;
    }
} else {
    echo false;
}