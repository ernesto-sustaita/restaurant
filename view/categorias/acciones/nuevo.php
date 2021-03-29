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

if(CategoriasController::crear($_POST['nombre'], $_POST['estatus'])){
    echo true;
}
else {
    echo false;
}