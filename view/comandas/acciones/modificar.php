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
require_once '../../../model/Producto.php';
require_once '../../../controller/ProductosController.php';

use controller\ComandasController;
use controller\ProductosController;

if(isset($_GET['id']) && $_GET['id'] != ''){
    $resultadoComanda = ComandasController::obtenerPorId($_GET['id']);
    
    if($resultadoComanda != NULL){
        $comanda = $resultadoComanda->fetch_object();
        
        // Si ya está pagada, no se puede modificar
        if($comanda->pagada != '' && $comanda->pagada == '1'){
            echo "<input type='hidden' id='idComanda' value='$comanda->id'/>";
            echo "<input type='hidden' id='comandaPagada' value='$comanda->pagada'/>";
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
            if($comanda->tipo == '1'){
                echo "<input type='hidden' id='selectTipo' value='1'/>Comer aquí";
            } elseif ($comanda->tipo == '2') {
                echo "<input type='hidden' id='selectTipo' value='2'/>Entrega a domicilio";
            } elseif ($comanda->tipo == '3') {
                echo "<input type='hidden' id='selectTipo' value='3'/>Recoger en local";
            }
            echo "</td>";
            echo "</tr>";
            if ($comanda->tipo == '2') {
                echo "<tr id='filaCostoEnvio'>";
            } else {
                echo "<tr id='filaCostoEnvio' style='display:none'>";
            }
            echo "<td>Costo envío:</td>";
            echo "<td><input type='text' id='numberCostoEnvio' value='$comanda->costo_envio' readonly='readonly'/></td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td>Nota:</td>";
            echo "<td>$comanda->nota</td>";
            echo "</tr>";
            echo "</tbody>";
            echo "</table>";
            
            echo '<table id="detalleComanda" class="table table-striped">';
            
            $resultadoDetallesComanda = ComandasController::obtenerDetalleComanda($comanda->id);
            
            $stringListaProductosIgnorarFiltro = "";
            
            while ($detalleComanda = $resultadoDetallesComanda->fetch_object()) {
                $stringInformacionProducto = "";
                
                $stringInformacionProducto = "<tr id='productoComanda$detalleComanda->producto_id'>
                                        <td style='width:250px;overflow-x:hidden'><input type='hidden' name='idProducto' value='$detalleComanda->producto_id'/>
                                            <span class='badge bg-light' style='font-size:large;color:black'>$detalleComanda->nombre</span>
                                        </td>
                                        <td>";
                if($detalleComanda->cantidad != '' && $detalleComanda->cantidad > 0){
                    $stringInformacionProducto .= "x $detalleComanda->cantidad
                                        </td>
                                        <td class='precio'>" . ($detalleComanda->precio * $detalleComanda->cantidad) . "</td>
                                      </tr>";
                } else {
                    $stringInformacionProducto .= "0
                                        </td>
                                        <td class='precio'>0</td>
                                      </tr>";
                }
                
                $resultadoImpuestos = ProductosController::consultarImpuestosPorProducto($detalleComanda->producto_id);
                
                if($resultadoImpuestos != NULL){
                    while ($impuesto = $resultadoImpuestos->fetch_object()) {
                        
                        $cargoImpuesto = ($impuesto->porcentaje * $detalleComanda->precio) / 100;
                        
                        $stringInformacionProducto .= "<tr class='impuesto$detalleComanda->producto_id'>
                                                <td style='text-align:right'>$impuesto->nombre</td>
                                                <td>%$impuesto->porcentaje</td>
                                                <td class='precio'><input type='hidden' class='porcentajeImpuesto$detalleComanda->producto_id' value='$impuesto->porcentaje'/>$cargoImpuesto</td>
                                              </tr>";
                    }
                }
                
                echo $stringInformacionProducto;
            }
            
            echo "</table>";
        } else {
            echo "<input type='hidden' id='idComanda' value='$comanda->id'/>";
            echo "<input type='hidden' id='comandaPagada' value='$comanda->pagada'/>";
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
            if($comanda->tipo == '1'){
                echo "<option value='1' selected='selected'>Comer aquí</option>";
                echo "<option value='2'>Entrega a domicilio</option>";
                echo "<option value='3'>Recoger en local</option>";
            } elseif ($comanda->tipo == '2') {
                echo "<option value='1'>Comer aquí</option>";
                echo "<option value='2' selected='selected'>Entrega a domicilio</option>";
                echo "<option value='3'>Recoger en local</option>";
            } elseif ($comanda->tipo == '3') {
                echo "<option value='1'>Comer aquí</option>";
                echo "<option value='2'>Entrega a domicilio</option>";
                echo "<option value='3' selected='selected'>Recoger en local</option>";
            } else {
                echo "<option value='1'>Comer aquí</option>";
                echo "<option value='2'>Entrega a domicilio</option>";
                echo "<option value='3'>Recoger en local</option>";
            }
            echo "</select>";
            echo "</td>";
            echo "</tr>";
            if ($comanda->tipo == '2') {
                echo "<tr id='filaCostoEnvio'>";
            } else {
                echo "<tr id='filaCostoEnvio' style='display:none'>";
            }
            echo "<td>Costo envío:</td>";
            echo "<td><input type='number' id='numberCostoEnvio' min='0' step='any' onblur='actualizarCostoEnvio(this.value)' value='$comanda->costo_envio'/></td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td>Nota:</td>";
            echo "<td><input type='text' id='notaComanda' onblur='agregarNota(this.value)' maxlength='600' value='$comanda->nota'/></td>";
            echo "</tr>";
            echo "</tbody>";
            echo "</table>";
            
            echo '<table id="detalleComanda" class="table table-striped">';
            
            $resultadoDetallesComanda = ComandasController::obtenerDetalleComanda($comanda->id);
            
            $stringListaProductosIgnorarFiltro = "";
            
            while ($detalleComanda = $resultadoDetallesComanda->fetch_object()) {
                $stringInformacionProducto = "";
                
                $stringInformacionProducto = "<tr id='productoComanda$detalleComanda->producto_id'>
                                                <td colspan='3'><input type='hidden' name='idProducto' value='$detalleComanda->producto_id'/>
                                                    <span class='badge bg-light' style='font-size:large;color:black'>$detalleComanda->nombre</span>
                                                </td>
                                            </tr>
                                        <tr id='controlesProductoComanda$detalleComanda->producto_id'>
                                            <td colspan='2'>";
                if($detalleComanda->cantidad != '' && $detalleComanda->cantidad > 0){
                    $stringInformacionProducto .= "<button class='btn btn-secondary' type='button' onclick='if(this.nextSibling.value > 1){this.nextSibling.value=parseInt(this.nextSibling.value)-1;actualizarCantidad($detalleComanda->comanda_id,$detalleComanda->comanda_id,this.nextSibling.value)}'><i class='bi-dash-circle'></i></button><input type='text' class='numero-mini' name='cantidadProducto' value='$detalleComanda->cantidad' readonly='readonly'/><button class='btn btn-secondary' type='button' onclick='this.previousSibling.value=parseInt(this.previousSibling.value)+1;actualizarCantidad($detalleComanda->comanda_id,$detalleComanda->producto_id,this.previousSibling.value)'><i class='bi-plus-circle'></i></button>
                                                <button class='btn btn-secondary' type='button' onclick='eliminarProductoComanda($detalleComanda->comanda_id,$detalleComanda->producto_id)'><i class='bi-x-circle'></i></button>
                                        </td>
                                        <td class='precio'><input type='hidden' id='precio$detalleComanda->producto_id' value='$detalleComanda->precio'/>" . ($detalleComanda->precio * $detalleComanda->cantidad) . "</td>
                                      </tr>";
                } else {
                    $stringInformacionProducto .= "<button class='btn btn-secondary' type='button' onclick='if(this.nextSibling.value > 1){this.nextSibling.value=parseInt(this.nextSibling.value)-1;actualizarCantidad($detalleComanda->comanda_id,$detalleComanda->comanda_id,this.nextSibling.value)}'><i class='bi-dash-circle'></i></button><input type='text' class='numero-mini' name='cantidadProducto' value='0' readonly='readonly'/><button class='btn btn-secondary' type='button' onclick='this.previousSibling.value=parseInt(this.previousSibling.value)+1;actualizarCantidad($detalleComanda->comanda_id,$detalleComanda->producto_id,this.previousSibling.value)'><i class='bi-plus-circle'></i></button>
                                            <button class='btn btn-secondary' type='button' onclick='eliminarProductoComanda($detalleComanda->comanda_id,$detalleComanda->producto_id)'><i class='bi-x-circle'></i></button>
                                        </td>
                                        <td class='precio'><input type='hidden' id='precio$detalleComanda->producto_id' value='$detalleComanda->precio'/>0</td>
                                      </tr>";
                }
                
                $stringListaProductosIgnorarFiltro .= "<input type='hidden' name='idsProductosIgnorar' id='productoIgnorar$detalleComanda->producto_id' value='$detalleComanda->producto_id'/>";
                
                $resultadoImpuestos = ProductosController::consultarImpuestosPorProducto($detalleComanda->producto_id);
                
                if($resultadoImpuestos != NULL){
                    while ($impuesto = $resultadoImpuestos->fetch_object()) {
                        
                        $cargoImpuesto = ($impuesto->porcentaje * $detalleComanda->precio) / 100;
                        
                        $stringInformacionProducto .= "<tr class='impuesto$detalleComanda->producto_id'>
                                                <td style='text-align:right'>$impuesto->nombre</td>
                                                <td>%$impuesto->porcentaje</td>
                                                <td class='precio'><input type='hidden' class='porcentajeImpuesto$detalleComanda->producto_id' value='$impuesto->porcentaje'/>$cargoImpuesto</td>
                                              </tr>";
                    }
                }
                
                echo $stringInformacionProducto;
            }
            
            echo "</table>";
            
            echo "<div id='listaProductosFiltro' style='display:none'>";
            echo $stringListaProductosIgnorarFiltro;
            echo "</div>";
        }
    }
}