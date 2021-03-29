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

$busqueda = (isset($_GET['busqueda']) && $_GET['busqueda'] != '') ?  $_GET['busqueda'] : '';

$clientes = ClientesController::buscar($busqueda);

echo '<table class="table table-striped">';
echo '<thead>';
echo '<tr class="encabezado-catalogo">';
echo '<th>Nombre</th>';
echo '<th>Apellidos</th>';
//<!-- <th>Calle</th> -->
echo '<th>Acciones</th>';
echo '</tr>';
echo '</thead>';
echo '<tbody>';

while ($cliente = $clientes->fetch_object()) {
    
    //     $datosCliente = "{'nombre':'$cliente->nombre','apellidos':'$cliente->apellidos','calle':'$cliente->calle','numero_exterior':'$cliente->numero_exterior',
    //                         'numero_interior':'$cliente->numero_interior','colonia':'$cliente->colonia','url_mapa':'$cliente->url_mapa'}";
    
    $datosCliente = "Nombre: $cliente->nombre $cliente->apellidos, Domicilio: $cliente->calle #$cliente->numero_exterior";
    $datosCliente .= ($cliente->numero_interior != "") ? " No. Int. $cliente->numero_interior, " : ", ";
    $datosCliente .= "$cliente->colonia, URL Maps: $cliente->url_mapa - ";
    
    $datosContacto = ClientesController::consultarDatosContacto($cliente->id);
    
    echo "<tr>";
    echo "<td id='nombre$cliente->id'>$cliente->nombre</td>";
    echo "<td id='apellidos$cliente->id'>$cliente->apellidos</td>";
    //echo "<td id='calle$cliente->id'>$cliente->calle</td>";
    echo "<td>";
    $celular = "";
    //$cadenaDatos = "{'datosContacto':[";
    $datos = "";
    while ($dato = $datosContacto->fetch_object()) {
        switch ($dato->tipo) {
            case '1':
                $celular = $dato->valor;
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
    $datos = substr($datos, 0, -1);
    
    //$cadenaDatos .= $datos . "]}";
    
    //     if($cadenaDatos == "{}"){
    //         $cadenaDatos = "null";
    //     }
    
    $datosCliente .= $datos;
    
    //echo "<button class='btn btn-secondary' onclick=\"compartirWhatsapp($datosCliente,$cadenaDatos)\" title='Compartir datos por WhatsApp'><i class='bi bi-share'></i></button>";
    echo "<a class='btn btn-secondary' href='https://wa.me/?text=" . urlencode($datosCliente) . "' title='Compartir datos por WhatsApp' target='_blank'><i class='bi bi-share'></i></a>";
    if($celular == ""){
        echo "<button class='btn btn-secondary' title='Enviar mensaje por WhatsApp' disabled='disabled'><i class='bi bi-whatsapp'></i></button>";
    } else {
        if(strlen($celular) > 10){
            echo "<a class='btn btn-secondary' href='https://wa.me/$celular' target='_blank'><i class='bi bi-whatsapp'></i></a>";
        } else {
            echo "<a class='btn btn-secondary' href='https://wa.me/521$celular' target='_blank'><i class='bi bi-whatsapp'></i></a>";
        }
    }
    echo "<button class='btn btn-secondary' data-bs-toggle='modal' data-bs-target='#modalActualizar' onclick='verDetalles($cliente->id)' title='Ver detalles'><i class='bi bi-eye'></i></button>";
    echo "<button class='btn btn-secondary' data-bs-toggle='modal' data-bs-target='#modalActualizar' onclick='cargarDatos($cliente->id)' title='Editar cliente'><i class='bi bi-pencil'></i></button>";
    echo "<button class='btn btn-secondary' data-bs-toggle='modal' data-bs-target='#modalEliminar' onclick='cargarDatosEliminar($cliente->id)' title='Eliminar cliente'><i class='bi bi-x-circle'></i></button>";
    echo "</td>";
    echo "</tr>";
}

echo '</tbody>';
echo '</table>';
