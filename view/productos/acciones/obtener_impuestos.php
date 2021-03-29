<?php

session_start();

if(!isset($_SESSION['tipoUsuarix']) || $_SESSION['tipoUsuarix'] != 2){
    header("Location: /restaurant/desconectar.php");
    exit();
}

require_once '../../../database/DB.php';
require_once '../../../model/Impuesto.php';
require_once '../../../controller/ImpuestosController.php';

use controller\ImpuestosController;

$impuestos = ImpuestosController::consultarActivos();

//Aunque el content-type no sea un problema en la mayoría de casos, es recomendable especificarlo
header('Content-type: application/json; charset=utf-8');
echo json_encode($impuestos->fetch_all());
exit();