<?php

session_start();

if(!isset($_SESSION['tipoUsuarix']) || $_SESSION['tipoUsuarix'] != 2){
    header("Location: /restaurant/desconectar.php");
    exit();
}

require_once '../../../database/DB.php';
require_once '../../../model/Categoria.php';
require_once '../../../controller/CategoriasController.php';

use controller\CategoriasController;

$categorias = CategoriasController::consultarActivas();

//Aunque el content-type no sea un problema en la mayoría de casos, es recomendable especificarlo
header('Content-type: application/json; charset=utf-8');
echo json_encode($categorias->fetch_all());
exit();