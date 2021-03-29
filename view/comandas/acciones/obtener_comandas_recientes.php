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
require_once '../../../model/Cliente.php';
require_once '../../../controller/ClientesController.php';

use controller\ComandasController;
use controller\ClientesController;

// Esta variable es para paginar los resultados
$pagina = (isset($_GET['pagina']) && $_GET['pagina'] != '') ? $_GET['pagina'] : 0;

$resultadoComandasRecientes = ComandasController::obtenerComandasRecientes($pagina);

// Esta variable ayuda a paginar los resultados
$resultadoCantidadComandasRecientes = ComandasController::obtenerCantidadComandasRecientes();
$cantidadComandasRecientes = $resultadoCantidadComandasRecientes->fetch_object()->ComandasRecientes;

while ($comandaReciente = $resultadoComandasRecientes->fetch_object()) {
    echo '<div class="card" id="comandaReciente' . $comandaReciente->id . '" style="width: 20rem;">';
    echo '<div class="card-body">';
    
    $datosCliente = "";
    $datosComanda = "";
    
    echo "<p class='card-text'>Comanda # $comandaReciente->id";
    echo ($comandaReciente->pagada != NULL && $comandaReciente->pagada == '1') ? " <span class='badge bg-success'><i class='bi-cash-stack'></i></span>" : "";
    echo "</p>";
    if($comandaReciente->cliente_id == 0){
        $datosCliente .= 'clientx no indicadx - ';
        echo "<p class='card-text'>Clientx: $datosCliente </p>";
        
    } else {
        echo "<p class='card-text'>Clientx: $comandaReciente->nombre $comandaReciente->apellidos</p>";
        
        $resultadoDatosCliente = ClientesController::consultarPorId($comandaReciente->cliente_id);
        
        if($resultadoDatosCliente->num_rows > 0) {
            $cliente = $resultadoDatosCliente->fetch_object();
            
            $datosCliente = "Nombre: $cliente->nombre $cliente->apellidos, Domicilio: $cliente->calle #$cliente->numero_exterior";
            $datosCliente .= ($cliente->numero_interior != "") ? " No. Int. $cliente->numero_interior, " : ", ";
            $datosCliente .= "$cliente->colonia, URL Maps: $cliente->url_mapa - ";
            
            $datosContacto = ClientesController::consultarDatosContacto($cliente->id);
            
            $datos = "";
            while ($dato = $datosContacto->fetch_object()) {
                switch ($dato->tipo) {
                    case '1':
                        $datos .= " Celular: $dato->valor,";
                        break;
                    case '2':
                        $datos .= " Tel. casa: $dato->valor,";
                        break;
                    case '3':
                        $datos .= " Tel. negocio: $dato->valor,";
                        break;
                    case '4':
                        $datos .= " Correo electrónico: $dato->valor,";
                        break;
                    case '5':
                        $datos .= " Red social: $dato->valor,";
                        break;
                }
                //$datos .= "{'tipo':'$dato->tipo','valor':'$dato->valor'},";
            }
            $datos = (strlen($datos) > 0) ? substr($datos, 0, -1) : '';
            
            $datosCliente .= $datos;
        }
    }
    echo "<p class='card-text'>Fecha/hora: " . date("d/m/Y - h:i", $comandaReciente->fecha_hora) . "</p>";
    
    $datosComanda .= " --- Datos comanda: Fecha/hora: " . date("d/m/Y - h:i", $comandaReciente->fecha_hora);
    if($comandaReciente->nota != "") {
        $datosComanda .= " Nota: $comandaReciente->nota";
    }
    //$datosComanda .= ($comandaReciente->costo_envio > 0) ? " , Costo envío $comandaReciente->costo_envio" : '';
    $costoEnvio = ($comandaReciente->costo_envio > 0) ? $comandaReciente->costo_envio : 0;
    
    $resultadosDetalleComanda = ComandasController::obtenerDetalleComanda($comandaReciente->id);
    
    $totalComanda = 0;
    // Se imprime el detalle de la comanda
    echo '<ul class="list-group list-group-flush">';
    while ($detalleComanda = $resultadosDetalleComanda->fetch_object()) {
        if($detalleComanda->impuesto > 0) {
            $antesDeImpuesto = $detalleComanda->cantidad * $detalleComanda->precio;
            $impuesto = ($antesDeImpuesto * $detalleComanda->cantidad) / 100;
            $totalComanda += $antesDeImpuesto + $impuesto;
        } else {
            $totalComanda += $detalleComanda->cantidad * $detalleComanda->precio;
        }
         
        $datosComanda .= " $detalleComanda->nombre x $detalleComanda->cantidad ";
        
        if($detalleComanda->estatus == 2){
            echo "<li id='detalleComanda$detalleComanda->id' class='list-group-item' style='color:green'>$detalleComanda->nombre x $detalleComanda->cantidad </li>";
        } else {
            echo "<li id='detalleComanda$detalleComanda->id' class='list-group-item'>$detalleComanda->nombre x $detalleComanda->cantidad <button class='btn btn-dark' type='button' onclick='marcaDetalleComandaPreparado($detalleComanda->id,$comandaReciente->id)'><i class='bi-bag-check icono-boton'></i></button></li>";
        }
    }
    
    if($costoEnvio > 0) {
        $datosComanda .= " Total -> Productos $totalComanda + Envío $costoEnvio ";
        $totalComanda += $costoEnvio;
        $datosComanda .= "= $totalComanda";
    } else {
        $datosComanda .= " Total = $totalComanda";
    }
    
    if($comandaReciente->pagada) {
        $datosComanda .= " *** COMANDA PAGADA ***";
    } else {
        $datosComanda .= " *** COMANDA PENDIENTE DE PAGO ***";
    }
    
    echo "</ul>";
    echo "<p class='card-text'>";
    echo "<button class='btn btn-secondary' style='margin-right:5px' onclick='modificarComanda($comandaReciente->id)'><i class='bi-pencil-square icono-boton'></i></button>";
    // Botón de compartir datos de la comanda
    echo "<a class='btn btn-secondary' style='margin-right:5px;width:3.1rem' href='https://wa.me/?text=" . urlencode($datosCliente . $datosComanda) . "' title='Compartir datos por WhatsApp' target='_blank'><i class='bi bi-share'></i></a>";
    // Administradorx
    if(isset($_SESSION['tipoUsuarix']) && $_SESSION['tipoUsuarix'] == 2){
        echo "<button class='btn btn-danger' onclick='cancelarComanda($comandaReciente->id)'><i class='bi-x-octagon icono-boton'></i></button>";
    }
    echo "</p>";
    echo "</div>";
    echo "</div>";
}

if($cantidadComandasRecientes > (($pagina+1)*10)) {
    echo "<div><button class='btn btn-dark' type='button' onclick='cargarNuevaPaginaComandas(" . ($pagina + 1) .");this.style.display=\"none\"'><i class='bi-download icono-boton'></i>Cargar más</button></div>";
}