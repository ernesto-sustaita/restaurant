<?php
session_start();

if(!isset($_SESSION['tipoUsuarix']) || $_SESSION['tipoUsuarix'] != 2) {
    // En las acciones que se solicitan por AJAX se envía este código para avisar que se está desconectado
    http_response_code(403);
    exit();
}

require_once '../../../database/DB.php';
require_once '../../../model/Corte.php';
require_once '../../../controller/CortesController.php';

use controller\CortesController;

if(isset($_POST['detallesComanda'])){
    
    if(CortesController::crear($_SESSION['idUsuarix'], $_POST['detallesComanda'])){
        echo true;
    } else {
        echo false;
    }
}