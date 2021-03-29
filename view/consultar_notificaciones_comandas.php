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

$resultadoNotificaciones = NotificacionesController::consultarNotificacionesComandas();

if($resultadoNotificaciones->num_rows > 0) {
    echo "<ul class='list-group list-group-flush'>";
    while ($notificacion = $resultadoNotificaciones->fetch_object()) {
        if($notificacion->vista) {
            echo "<li class='list-group-item' style='background-color:rgba(255,255,255,0.5)'>$notificacion->mensaje - " . date('d/m/Y h:i', $notificacion->fecha_hora) . "</li>";
        } else {
            echo "<li class='list-group-item' id='notificacion$notificacion->id'>$notificacion->mensaje - " . date('d/m/Y h:i', $notificacion->fecha_hora) . " <button class='btn btn-success' id='botonNotificacion$notificacion->id' style='margin-right:5px' onclick='marcarComoLeida($notificacion->id)'><i class='bi-check-all icono-boton'></i></button></li>";
        }
    }
    echo "</ul>";
} else {
    echo 0;
}