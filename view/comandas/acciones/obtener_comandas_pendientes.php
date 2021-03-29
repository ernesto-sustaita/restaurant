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

$resultadoComandasPendientes = ComandasController::obtenerComandasPendientes();

while ($comandaPendiente = $resultadoComandasPendientes->fetch_object()) {
    
    $resultadosDetalleComanda = ComandasController::obtenerDetalleComanda($comandaPendiente->id);
    
    $cantidadDetallesComandaPendientes = ComandasController::obtenerCantidadDetallesComandaPendientes($comandaPendiente->id);
    
    $cantidadDetallesComandaPendientes = $cantidadDetallesComandaPendientes->fetch_object();
    
    if($resultadosDetalleComanda->num_rows > 0 && $cantidadDetallesComandaPendientes->DetallesPendientes > 0) {
    
        echo '<div class="card" id="comanda' . $comandaPendiente->id . '" style="width: 25rem;">';
        echo '<div class="card-body">';
        switch ($comandaPendiente->tipo){
            case 1:
                echo '<h5 class="card-title badge bg-primary">Comanda para: Comer aquí</h5>';
                break;
            case 2:
                echo '<h5 class="card-title badge bg-secondary">Comanda para: Llevar</h5>';
                break;
            case 3:
                echo '<h5 class="card-title badge bg-info text-dark">Comanda para: Recoger</h5>';
                break;
        }
        echo "<p class='card-text'>Comanda # $comandaPendiente->id</p>";
        if($comandaPendiente->cliente_id == 0){
            echo "<p class='card-text'>Clientx: clientx no indicadx </p>";
            
        } else {
            echo "<p class='card-text'>Clientx: $comandaPendiente->nombre $comandaPendiente->apellidos</p>";
        }
        echo "<p class='card-text'>Fecha/hora: " . date("d/m/Y - h:i", $comandaPendiente->fecha_hora) . "</p>";
        echo "</div>";
          
        // Se imprime el detalle de la comanda  
        echo '<ul class="list-group list-group-flush">';
        while ($detalleComanda = $resultadosDetalleComanda->fetch_object()) {
            if($detalleComanda->estatus == 2){
                echo "<li id='detalleComanda$detalleComanda->id' class='list-group-item' style='color:green'>$detalleComanda->nombre x $detalleComanda->cantidad </li>";
            } else {
                echo "<li id='detalleComanda$detalleComanda->id' class='list-group-item'>$detalleComanda->nombre x $detalleComanda->cantidad <button class='btn btn-dark' type='button' onclick='marcaDetalleComandaPreparado($detalleComanda->id,$comandaPendiente->id)'><i class='bi-bag-check icono-boton'></i></button></li>";
            }
        }
        echo "</ul>";
             
        echo '<div class="card-body">
            <button class="btn btn-dark" id="botonMarcarPreparada' . $comandaPendiente->id . '" type="button" onclick="marcarComandaPreparada(' . $comandaPendiente->id . ')"><i class="bi-check-square icono-boton"></i>Marcar como lista</button>
          </div>
        </div>';
    }
}

