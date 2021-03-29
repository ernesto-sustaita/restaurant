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

if(ClientesController::actualizar($_POST['id'], $_POST['nombre'], $_POST['apellidos'], $_POST['calle'], $_POST['numeroExterior'],
                                    $_POST['numeroInterior'], $_POST['colonia'], $_POST['ciudad'], $_POST['estado'], $_POST['codigoPostal'],
                                    $_POST['urlMapa'], $_POST['rfc'], $_POST['estatus'], $_POST['datosContacto'])){
    $respuesta_json["mensaje"] = true;
                                        
    //Aunque el content-type no sea un problema en la mayoría de casos, es recomendable especificarlo
    header('Content-type: application/json; charset=utf-8');
    echo json_encode($respuesta_json);
    exit();
}
else {
    $respuesta_json["mensaje"] = false;
    
    //Aunque el content-type no sea un problema en la mayoría de casos, es recomendable especificarlo
    header('Content-type: application/json; charset=utf-8');
    echo json_encode($respuesta_json);
    exit();
}