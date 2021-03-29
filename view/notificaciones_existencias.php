<?php
session_start();

if(!isset($_SESSION['conectadx']) || !$_SESSION['conectadx']){
    // En las acciones que se solicitan por AJAX se envía este código para avisar que se está desconectado
    http_response_code(403);
    exit();
}

require_once '../database/DB.php';
require_once '../model/Notificacion.php';
require_once '../controller/NotificacionesController.php';

use controller\NotificacionesController;

$resultadoCantidadNotificaciones = NotificacionesController::consultarCantidadNotificacionesExistenciaNoVistas();

if($resultadoCantidadNotificaciones->num_rows > 0) {
    $cantidadNotificaciones = $resultadoCantidadNotificaciones->fetch_object()->cantidad;
    
    echo $cantidadNotificaciones;
} else {
    echo 0;
}