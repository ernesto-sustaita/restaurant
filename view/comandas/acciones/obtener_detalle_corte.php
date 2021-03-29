<?php
session_start();

if(!isset($_SESSION['tipoUsuarix']) || $_SESSION['tipoUsuarix'] != 2) {
    // En las acciones que se solicitan por AJAX se envía este código para avisar que se está desconectado
    http_response_code(403);
    exit();
}

require_once '../../../database/DB.php';
require_once '../../../model/Comanda.php';
require_once '../../../controller/ComandasController.php';
require_once '../../../model/Corte.php';
require_once '../../../controller/CortesController.php';

use controller\ComandasController;
use controller\CortesController;

$resultadoComandas = ComandasController::obtenerComandasCorte();

if($resultadoComandas != NULL){
    
    $totalEfectivo = 0;
    $totalTransferencia = 0;
    $totalTarjeta = 0;
    $totalNoEspecificado = 0;
    $totalDia = 0;
    echo '<button class="btn btn-secondary" onclick="$(\'#detallesComandas\').toggle()"><i class="bi-back icono-boton"></i>Mostrar/Ocultar detalles</button>';
    echo "<div id='detallesComandas' style='display:none'>";
    while ($comandaCorte = $resultadoComandas->fetch_object()) {
        // Almacenaremos aquí todos los subtotales, hay que incluir el costo de envío también
        $totalComanda = 0;
        
        echo "<table class='table table-responsive table-striped'>";
        echo "<thead>";
        echo "<tr class='encabezado-catalogo'>";
        echo "<th>Tipo</th>";
        echo "<th>Fecha / hora</th>";
        echo "<th>Costo envío</th>";
        echo "<th>Tipo pago</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        echo "<tr>";
        switch ($comandaCorte->tipo) {
            case '1':
                echo "<td>Comer aquí</td>";
            break;
            case '2':
                echo "<td>Entrega a domicilio</td>";
                break;
            case '3':
                echo "<td>Recoger en local</td>";
                break;
            default:
                echo "<td>-</td>";;
            break;
        }
        echo "<td>" . date('d/m/Y h:i', $comandaCorte->fecha_hora) . "</td>";
        
        if($comandaCorte->tipo == 2) {
            // Agregamos el costo de envío
            $totalComanda += $comandaCorte->costo_envio;
            echo "<td>$comandaCorte->costo_envio</td>";
        } else {
            echo "<td>N/A</td>";
        }
        
        switch ($comandaCorte->tipo_pago) {
            case '1':
                echo "<td>Efectivo</td>";
                break;
            case '2':
                echo "<td>Transferencia/CoDi</td>";
                break;
            case '3':
                echo "<td>Tarjeta bancaria</td>";
                break;
            default:
                echo "<td>-</td>";
                break;
        }
        echo "</tr>";
        
        $resultadoDetallesComanda = ComandasController::obtenerDetallesComandaCorte($comandaCorte->id);
        
        if($resultadoDetallesComanda != NULL) {
            //echo "<tr><td colspan='4'>Detalle comanda</td></tr>";
            echo "<tr class='encabezado-catalogo'>";
            echo "<th>Producto</th>";
            echo "<th>Cantidad x Precio</th>";
            echo "<th>Impuesto</th>";
            echo "<th>Subtotal</th>";
            echo "</tr>";
            while($detalleComanda = $resultadoDetallesComanda->fetch_object()) {
                echo "<tr>";
                echo "<td>$detalleComanda->nombre</td>";
                echo "<td>$detalleComanda->cantidad x $detalleComanda->precio</td>";
                echo "<td>$detalleComanda->impuesto %</td>";
                $total = $detalleComanda->cantidad * $detalleComanda->precio;
                
                if($detalleComanda->impuesto > 0){
                    $impuesto = ($total * $detalleComanda->impuesto) / 100;
                    $total += $impuesto;
                }
                
                // La variable $totalComanda es el total de (artículos + impuestos) + envío
                $totalComanda += $total;
                echo "<td>$total</td>";
                echo "</tr>";
                
                
            }
        }
        
        switch ($comandaCorte->tipo_pago) {
            case '1':
                $totalEfectivo += $totalComanda;
                break;
            case '2':
                $totalTransferencia += $totalComanda;
                break;
            case '3':
                $totalTarjeta += $totalComanda;
                break;
            default:
                $totalNoEspecificado += $totalComanda;
                break;
        }
        
        $totalDia += $totalComanda;
        echo "<tr><td colspan='4' style='text-align:right'>$totalComanda</td></tr>";
        echo "</tbody>";
        echo "</table>";
    }
    echo "</div>";
    // Separador
    echo "<div style='margin-top:5px'></div>";
    // Tabla del corte
    $resultadoCorteHoy = CortesController::obtenerCortePorFechaActual();
    
    // Si se obtuvo un resultado, quiere decir que ya hay un corte guardado para el día de hoy, así que se cargará en modo "solo lectura" de lo contrario, se prepara el formulario para guardar el corte
    if($resultadoCorteHoy->num_rows > 0) {
        $corteHoy = $resultadoCorteHoy->fetch_object();
        
        $resultadoDetallesCorte = CortesController::obtenerDetallesCorte($corteHoy->id);
        
        $corteEfectivo = 0;
        $corteTransferencia = 0;
        $corteTarjeta = 0;
        $corteNoDefinido = 0;
        
        if($resultadoDetallesCorte->num_rows > 0){
            while ($detalleCorte = $resultadoDetallesCorte->fetch_object()) {
                switch ($detalleCorte->tipo) {
                    case '1':
                        $corteEfectivo = $detalleCorte->cantidad;
                        break;
                    case '2':
                        $corteTransferencia = $detalleCorte->cantidad;
                        break;
                    case '3':
                        $corteTarjeta = $detalleCorte->cantidad;
                        break;
                    default:
                        $corteNoDefinido = $detalleCorte->cantidad;
                        break;
                }
            }
        }
        
        
        echo "<table class='table table-responsive table-striped'>";
        echo "<thead>";
        echo "<tr class='encabezado-catalogo'>";
        echo "<th>Totales</th>";
        echo "<th></th>";
        echo "<th>Corte</th>";
        echo "<th></th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        echo "<tr>";
        echo "<td>Total efectivo = </td>";
        echo "<td>$totalEfectivo</td>";
        echo "<td>Recibido efectivo = </td>";
        echo "<td><input type='number' id='totalEfectivo' style='width:6rem' value='$corteEfectivo' disabled='disabled'/></td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td>Total transferencias = </td>";
        echo "<td>$totalTransferencia</td>";
        echo "<td>Recibido transferencias = </td>";
        echo "<td><input type='number' id='totalTransferencia' style='width:6rem' value='$corteTransferencia' disabled='disabled'/></td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td>Total tarjeta = </td>";
        echo "<td>$totalTarjeta</td>";
        echo "<td>Recibido tarjeta = </td>";
        echo "<td><input type='number' id='totalTarjeta' style='width:6rem' value='$corteTarjeta' disabled='disabled'/></td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td>Total no especificado = </td>";
        echo "<td>$totalNoEspecificado</td>";
        echo "<td>Recibido no especificado = </td>";
        echo "<td><input type='number' id='totalNoEspecificado' style='width:6rem' value='$corteNoDefinido' disabled='disabled'/></td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td>Total día =</td>";
        echo "<td>$totalDia</td>";
        echo "<td>Diferencia =</td>";
        echo "<td><input type='text' id='textDiferenciaCorte' style='width:6rem' value='" . ($totalDia -($corteEfectivo+$corteTransferencia+$corteTarjeta+$corteNoDefinido)) . "' disabled='disabled'/></td>";
        echo "</tr>";
        echo "</tbody>";
        echo "</table>";
    } else {
        echo "<table class='table table-responsive table-striped'>";
        echo "<thead>";
        echo "<tr class='encabezado-catalogo'>";
        echo "<th>Totales</th>";
        echo "<th></th>";
        echo "<th>Corte</th>";
        echo "<th></th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        echo "<tr>";
        echo "<td>Total efectivo = </td>";
        echo "<td>$totalEfectivo</td>";
        echo "<td>Recibido efectivo = </td>";
        echo "<td><input type='number' id='totalEfectivo' style='width:6rem' step='0.1' pattern='^\d+(?:\.\d{1,2})?$' value='0' onblur='actualizarCorte()'/></td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td>Total transferencias = </td>";
        echo "<td>$totalTransferencia</td>";
        echo "<td>Recibido transferencias = </td>";
        echo "<td><input type='number' id='totalTransferencia' style='width:6rem' step='0.1' pattern='^\d+(?:\.\d{1,2})?$' value='0' onblur='actualizarCorte()'/></td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td>Total tarjeta = </td>";
        echo "<td>$totalTarjeta</td>";
        echo "<td>Recibido tarjeta = </td>";
        echo "<td><input type='number' id='totalTarjeta' style='width:6rem' step='0.1' pattern='^\d+(?:\.\d{1,2})?$' value='0' onblur='actualizarCorte()'/></td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td>Total no especificado = </td>";
        echo "<td>$totalNoEspecificado</td>";
        echo "<td>Recibido no especificado = </td>";
        echo "<td><input type='number' id='totalNoEspecificado' style='width:6rem' step='0.1' pattern='^\d+(?:\.\d{1,2})?$' value='0' onblur='actualizarCorte()'/></td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td>Total día =</td>";
        echo "<td>$totalDia</td>";
        echo "<td>Diferencia =</td>";
        echo "<td><input type='hidden' id='diferenciaCorte' value='" . ($totalDia * -1) . "'/><input type='text' id='textDiferenciaCorte' style='width:6rem' value='" . ($totalDia * -1) . "' readonly='readonly'/></td>";
        echo "</tr>";
        echo "</tbody>";
        echo "</table>";
        echo "<div style='text-align:center'><button id='botonGuardarCorte' class='btn btn-secondary' onclick='guardarCorte()'><i class='bi-journal-check icono-boton'></i>Guardar corte</button></div>";
    }
}