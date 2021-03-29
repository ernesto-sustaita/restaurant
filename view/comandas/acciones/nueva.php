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

$idComanda = ComandasController::crear($_SESSION['idUsuarix']);

if($idComanda != false){
    $resultadoComanda = ComandasController::obtenerPorId($idComanda);
    
    if($resultadoComanda != NULL){
        $comanda = $resultadoComanda->fetch_object();
        
        echo "<input type='hidden' id='idComanda' value='$comanda->id'/>";
        echo '<table class="table table-striped">';
        echo "<tbody>";
        echo "<tr>";
        if($comanda->cliente_id == 0){
            echo "<td>Clientx: </td>";
            echo "<td id='nombre-cliente'>no indicadx</td>";
        } else {
            echo "<td>Cliente: </td>";
            echo "<td id='nombre-cliente'>$comanda->nombre $comanda->apellidos</td>";
        }
        echo "</tr>";
        echo "<tr>";
        echo "<td>Fecha/hora:</td>";
        echo "<td>" . date("d/m/Y h:i", $comanda->fecha_hora) . "</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td>Tipo:</td>";
        echo "<td>";
        echo "<select id='selectTipo' onchange='agregarTipo(this.value)'>";
        echo "<option value=''>Seleccionar</option>";
        echo "<option value='1'>Comer aquí</option>";
        echo "<option value='2'>Entrega a domicilio</option>";
        echo "<option value='3'>Recoger en local</option>";
        echo "</select>";
        echo "</td>";
        echo "</tr>";
        echo "<tr id='filaCostoEnvio' style='display:none'>";
        echo "<td>Costo envío:</td>";
        echo "<td><input type='number' id='numberCostoEnvio' min='0' value='0' step='any' onblur='actualizarCostoEnvio(this.value)'/></td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td>Nota:</td>";
        echo "<td><input type='text' id='notaComanda' onblur='agregarNota(this.value)' maxlength='600'/></td>";
        echo "</tr>";
        echo "</tbody>";
        echo "</table>";
        
        echo '<table id="detalleComanda" class="table table-striped">';
        echo "</table>";
        
        echo "<div id='listaProductosFiltro' style='display:none'></div>";
    }
}