<?php
session_start();

// Acción reservada solo para administradores
if(!isset($_SESSION['tipoUsuarix']) || $_SESSION['tipoUsuarix'] != 2){
    // En las acciones que se solicitan por AJAX se envía este código para avisar que se está desconectado
    http_response_code(403);
    exit();
}

require_once '../../../database/DB.php';
require_once '../../../model/Comanda.php';
require_once '../../../controller/ComandasController.php';

use controller\ComandasController;

if(isset($_POST['id']) && $_POST['id'] != ''){
    if(ComandasController::cancelarComanda($_POST['id'])){
        echo true;
    } else {
        echo false;
    }
}