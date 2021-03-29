<?php

session_start();

if(!isset($_SESSION['conectadx']) || !$_SESSION['conectadx']){
    header("Location: /restaurant/desconectar.php");
    exit();
}

require_once '../principio.php';
require_once '../menu.php';?>
<div class="content">
	<div id="overlay"></div>
	<div id="notificacionesComandas" style="text-align: center;font-weight:bold;display:none"></div>
	<div class="row">
        <div class="col-md-8 col-sm-12">
        	<div id="filtros-comandas" class="row">
        		<div class="col-md-3 col-sm-3" style="margin-bottom: 5px">
        			<button class="btn btn-secondary" onclick="crear()"><i class="bi-plus-circle-fill icono-boton"></i>Nueva comanda</button>
        		</div>
        		<div class="col-md-3 col-sm-3" style="margin-bottom: 5px">
        			<button class="btn btn-secondary" data-bs-toggle='modal' data-bs-target='#modalVerRecientes' type="button" onclick="cargarComandasRecientes()"><i class="bi-card-checklist icono-boton"></i>Ver comandas</button>
        		</div>
        		<div class="col-md-3 col-sm-6 filtros" style="margin-bottom: 5px">
        			<input id="textFiltrar" type="search" placeholder="Filtrar productos" onkeyup="filtrar(this.value)"/>
        		</div>
        		<!--  <div class="col-md-3 col-sm-3 filtros" style="margin-bottom: 5px">
        			<select id="selectCategorias" onchange="filtrarPorCategorias(this.value)">
        				<option value="">Filtrar por categoría</option>
        			</select>
        		</div>
        		<div class="col-md-3 col-sm-3 filtros" style="margin-bottom: 5px">
        			<select id="selectOrdenar" onchange="ordenar(this.value)">
        				<option value="">Ordenar por</option>
        				<option value="1">A - Z</option>
        				<option value="2">Z - A</option>
        				<option value="3">Precio menor</option>
        				<option value="4">Precio mayor</option>
        			</select>
        		</div>-->
        	</div>
        	<div id="productos" class="row">
        	</div>
		</div>
        <div class="col-md-4 col-sm-12">
        	<div id="busqueda-cliente" class="row">
        		<input id="inputBusquedaCliente" type="search" placeholder="Buscar clientx" onkeyup="buscarClientes(this.value)"/>
        		<div id="resultados-clientes" class="list-group"></div>
        	</div>
        	<div class="row" id="comanda">
        		<div id="detalle-comanda" class="row table-responsive"></div>
        		<div id="total-comanda" style="text-align: right;"></div>
        		<div id="contenedor-botones" style="display: none">
        			<button id="botonPagar" class="btn btn-success" data-bs-toggle='modal' data-bs-target='#modalPagar' type="button" onclick="document.getElementById('numberCantidadRecibida').value = 0;"><i class="bi-cash-stack icono-boton"></i>Pagar</button>
        			<?php
        			    // Administradorx
            			if(isset($_SESSION['tipoUsuarix']) && $_SESSION['tipoUsuarix'] == 2){
            			     echo '<button class="btn btn-danger" onclick="cancelarComanda(document.getElementById(\'idComanda\').value)"><i class="bi-x-octagon icono-boton"></i>Cancelar</button>';
            			}
        			?>
        		</div>
        	</div>
        </div>
      </div>
      <!-- Modal ver recientes -->
        <div class="modal fade" id="modalVerRecientes" tabindex="-1" role="dialog" aria-labelledby="modalVerRecientesLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="modalVerRecientesLabel">Ver comandas</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
                <div class="modal-body">
                	<div id="mensajeVerComandas" class="mb-3 mensaje"></div>
                	<div id="comandasRecientes" style="height:25rem;overflow-y:scroll"></div>
              	</div>
              <div class="modal-footer">
              </div>
            </div>
          </div>
        </div>
      <!-- Modal pagar -->
        <div class="modal fade" id="modalPagar" tabindex="-1" role="dialog" aria-labelledby="modalPagarLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="modalAgregarLabel">Pagar</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
                <div class="modal-body">
                	<div id="mensajePagar" class="mb-3 mensaje"></div>
                	<div class="informacion-obligatoria">Información obligatoria*</div>
                    <div class="mb-3">
              			<label class="form-label" for="textAgregarNombre">A pagar:</label>
              			<input id="textAPagar" class="form-control" type="text" readonly="readonly"/>
              		</div>
              		<div class="mb-3">
              			<label class="form-label obligatoria" for="numberAgregarExistencia">Cantidad recibida*:</label>
              			<input id="numberCantidadRecibida" class="form-control" type="number" min="0" value="0" step="0.1" pattern="^\d+(?:\.\d{1,2})?$" onblur="activarBoton('#botonConfirmarPago');calcularCambio()" onchange="activarBoton('#botonConfirmarPago');calcularCambio()" onkeyup="activarBoton('#botonConfirmarPago');calcularCambio()"/>
              		</div>
              		<div class="mb-3">
              			<label class="form-label">Cambio:</label>
              			<input id="textCambio" class="form-control" type="text" readonly="readonly"/>
              		</div>
                	<div class="mb-3">
              			<label class="form-label obligatoria">Forma de pago*:</label>
              			<div class="list-group">
                          <label class="list-group-item">
                            <input class="form-check-input me-1" type="radio" name="formaDePago" onclick="activarBoton('#botonConfirmarPago')" value="1">
                            <i class="bi-cash icono-boton"></i>Efectivo
                          </label>
                          <label class="list-group-item">
                            <input class="form-check-input me-1" type="radio" name="formaDePago" onclick="activarBoton('#botonConfirmarPago')" value="2">
                            <i class="bi-arrow-down-up icono-boton"></i>Transferencia/CoDi
                          </label>
                          <label class="list-group-item">
                            <input class="form-check-input me-1" type="radio" name="formaDePago" onclick="activarBoton('#botonConfirmarPago')" value="3">
                            <i class="bi-credit-card icono-boton"></i>Tarjeta bancaria
                          </label>
                       	</div>
            		</div>
              	</div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button id="botonConfirmarPago" disabled="disabled" type="button" class="btn btn-primary" onclick="confirmarPago()">Confirmar pago</button>
              </div>
            </div>
          </div>
        </div>
</div>
<script>
$(document).ready(function(){
	$(".filtros").hide();
	$("#productos").hide();
	$("#busqueda-cliente").hide();
	$("#detalle-comanda").hide();
	consultar();
});

function consultar(){
	$.ajax({
		url: 'acciones/obtener_productos.php',
		method: 'GET'
	}).done(function(resultado){
		document.getElementById('productos').innerHTML = resultado;
	}).fail(function(jqXHR, textStatus) {
		if(jqXHR.status == 403) {
			window.location.href = '/restaurant/view/conexion/';
		} else {
			console.log("Request failed: " + textStatus);
		}
	});
}

function filtrar(filtro){
	
	var idsProductosIgnorar = document.getElementsByName("idsProductosIgnorar");
	
	var datosProductosIgnorar = [];
	for(i = 0; i < idsProductosIgnorar.length; i++){
		item = {};
		item["idProducto"] = idsProductosIgnorar[i].value;
		datosProductosIgnorar.push(item);
	}

	$.ajax({
		url: 'acciones/obtener_productos.php',
		data: {filtro: filtro, idsProductosIgnorar: datosProductosIgnorar},
		method: 'GET',
		dataType: 'html'
	}).done(function(resultado){
		document.getElementById('productos').innerHTML = resultado;
	}).fail(function(jqXHR, textStatus) {
		if(jqXHR.status == 403) {
			window.location.href = '/restaurant/view/conexion/';
		} else {
			console.log("Request failed: " + textStatus);
		}
	});
}

function filtrarPorCategorias(idCategoria){
	if(idCategoria == ""){
		return false;
	}
	
	document.getElementById('textFiltrar').value = '';
	document.getElementById('selectOrdenar').selectedIndex = 0;

	$.ajax({
		url: 'acciones/obtener_productos.php',
		data: {idCategoria: idCategoria},
		method: 'GET',
		dataType: 'html'
	}).done(function(resultado){
		document.getElementById('productos').innerHTML = resultado;
	}).fail(function(jqXHR, textStatus) {
		if(jqXHR.status == 403) {
			window.location.href = '/restaurant/view/conexion/';
		} else {
			console.log("Request failed: " + textStatus);
		}
	});
}

function ordenar(tipoOrden){
	if(tipoOrden == ""){
		return false;
	}
	
	document.getElementById('textFiltrar').value = '';
	document.getElementById('selectCategorias').selectedIndex = 0;

	$.ajax({
		url: 'acciones/obtener_productos.php',
		data: {tipoOrden: tipoOrden},
		method: 'GET',
		dataType: 'html'
	}).done(function(resultado){
		document.getElementById('productos').innerHTML = resultado;
	}).fail( function(jqXHR, textStatus){
		console.log("Request failed: " + textStatus);
	});
}

function obtenerCategorias(){
	$.ajax({
		url: 'acciones/obtener_categorias.php',
		method: 'GET',
		dataType: 'json'
	}).done(function(resultado){
		var $select = $("#selectCategorias");
		for(i = 0; i < resultado.length; i++) {
			$select.append(new Option(resultado[i][1],resultado[i][0]));
		}
	}).fail(function(jqXHR, textStatus) {
		if(jqXHR.status == 403) {
			window.location.href = '/restaurant/view/conexion/';
		} else {
			console.log("Request failed: " + textStatus);
		}
	});
}

function buscarClientes(filtro){

	if(filtro.length < 3){
		$('#resultados-clientes').hide();
		return false;
	}

	$.ajax({
		url: 'acciones/obtener_clientes.php',
		data: {filtro: filtro},
		method: 'GET',
		dataType: 'html'
	}).done(function(resultado){
		$('#resultados-clientes').show();
		document.getElementById('resultados-clientes').innerHTML = resultado;
	}).fail(function(jqXHR, textStatus) {
		if(jqXHR.status == 403) {
			window.location.href = '/restaurant/view/conexion/';
		} else {
			console.log("Request failed: " + textStatus);
		}
	});
}

function crear(){
	$.ajax({
		url: 'acciones/nueva.php',
		method: 'GET',
	}).done(function(resultado){
	
		consultar();
		document.getElementById('detalle-comanda').innerHTML = resultado;
		
		$(".filtros").show();
    	$("#productos").show();
    	$("#busqueda-cliente").show();
    	$("#detalle-comanda").show();
    	
    	// Borramos el total de la comanda anterior
    	document.getElementById('textAPagar').value = "";
    	document.getElementById("total-comanda").innerHTML = "";
    	
    	// Desactivar el botón pagar
    	document.getElementById("botonPagar").disabled = true;
	}).fail(function(jqXHR, textStatus) {
		if(jqXHR.status == 403) {
			window.location.href = '/restaurant/view/conexion/';
		} else {
			console.log("Request failed: " + textStatus);
		}
	});
}

function incluirCliente(idCliente, nombreCliente){
	
	var idComanda = document.getElementById("idComanda").value;
	
	$.ajax({
		url: 'acciones/incluir_cliente.php',
		data: {idComanda: idComanda, idCliente: idCliente},
		method: 'POST',
		dataType: 'html'
	}).done(function(resultado){
		if(resultado == 1) {
			document.getElementById('nombre-cliente').innerHTML = nombreCliente;
			$('#resultados-clientes').hide();
			document.getElementById('inputBusquedaCliente').value = '';
		} else {
    		alert("No se pudo agregar el cliente");
		}
	}).fail(function(jqXHR, textStatus) {
		if(jqXHR.status == 403) {
			window.location.href = '/restaurant/view/conexion/';
		} else {
			console.log("Request failed: " + textStatus);
		}
	});
}

function agregarTipo(tipo){

	if(tipo == ''){
		return false;
	}
	
	var idComanda = document.getElementById("idComanda").value;
	
	$.ajax({
		url: 'acciones/agregar_tipo.php',
		data: {idComanda: idComanda, tipo: tipo},
		method: 'POST',
		dataType: 'html'
	}).done(function(resultado){
		if(resultado == 1) {
			document.getElementById('selectTipo').value = tipo;
			if(tipo == 2){
				document.getElementById('filaCostoEnvio').style.display = 'table-row';
			} else {
				document.getElementById('filaCostoEnvio').style.display = 'none';
				
				var total = 0.0;
            	$('.precio').each(
                	function(){
                		total += parseFloat($(this).text().trim());
                	});
    			
            	$('#total-comanda').html("Total = " +total);
            	document.getElementById('textAPagar').value = total;
            	
            	document.getElementById('numberCostoEnvio').value = 0;
            	
            	$.ajax({
            		url: 'acciones/actualizar_costo_envio.php',
            		data: {idComanda: idComanda, costoEnvio: 0},
            		method: 'POST',
            		dataType: 'html'
            	}).done(function(resultado){
            		if(resultado) {
            			document.getElementById('numberCostoEnvio').style.color = 'green';
            			
            			var total = 0.0;
                    	$('.precio').each(
                        	function(){
                        		total += parseFloat($(this).text().trim());
                        	});
            			
                    	$('#total-comanda').html("Total = " +total);
                    	document.getElementById('textAPagar').value = total;
            		}
            	}).fail(function(jqXHR, textStatus) {
            		if(jqXHR.status == 403) {
            			window.location.href = '/restaurant/view/conexion/';
            		} else {
            			console.log("Request failed: " + textStatus);
            		}
            	});
			}
		} else {
    		alert("No se pudo agregar el tipo de comanda");
    		document.getElementById('selectTipo').selectedIndex = 0;
		}
	}).fail(function(jqXHR, textStatus) {
		if(jqXHR.status == 403) {
			window.location.href = '/restaurant/view/conexion/';
		} else {
			console.log("Request failed: " + textStatus);
		}
	});
}

function agregarProductoComanda(idProducto){

	if(idProducto == ''){
		return false;
	}
	
	var idComanda = document.getElementById("idComanda").value;
	
	document.getElementById("overlay").style.display = 'block';
	
	$.ajax({
		url: 'acciones/agregar_producto.php',
		data: {idComanda: idComanda, idProducto: idProducto},
		method: 'POST',
		dataType: 'html'
	}).done(function(resultado){
		if(resultado != "") {
			//$("#detalleComanda").append("<tr id='producto" + idProducto + "'><td style='width:250px;overflow-x:hidden'><input type='hidden' name='idProducto' value='" + idProducto + "'/><span class='badge rounded-pill bg-secondary' style='font-size:large;color:black'>" + nombreProducto + "</span></td><td style='width:'><button class='btn btn-secondary' type='button' onclick='if(this.nextSibling.value > 1){this.nextSibling.value=parseInt(this.nextSibling.value)-1}'><i class='bi-dash-circle'></i></button><input type='text' class='numero-mini' name='cantidadProducto' value='1' readonly='readonly'/><button class='btn btn-secondary' type='button' onclick='this.previousSibling.value=parseInt(this.previousSibling.value)+1'><i class='bi-plus-circle'></i></button><button class='btn btn-secondary' type='button' onclick='document.getElementById(\"producto" + idProducto + "\").remove();'><i class='bi-x-circle'></i></button></td></tr>");
			$('#detalleComanda').append(resultado);
			document.getElementById('producto' + idProducto).style.display = 'none';
			$("#listaProductosFiltro").append("<input type='hidden' name='idsProductosIgnorar' id='productoIgnorar" + idProducto + "' value='" + idProducto + "'/>");
			var total = 0.0;
			$('.precio').each(
				function(){
					total += parseFloat($(this).text().trim());
				});
			
			var costoEnvio = document.getElementById('numberCostoEnvio').value;
			
			if(costoEnvio != '' && costoEnvio > 0){
				total += parseFloat(costoEnvio);
			}
			$('#total-comanda').html("Total = " +total);
			document.getElementById('textAPagar').value = total;
			if(total > 0){
				document.getElementById('contenedor-botones').style.display = 'block';
				// Desactivar el botón pagar
    			document.getElementById("botonPagar").disabled = false;
			} else {
				document.getElementById('contenedor-botones').style.display = 'none';
			}
		} else {
    		alert("No se pudo agregar el producto");
		}
	}).fail(function(jqXHR, textStatus) {
		if(jqXHR.status == 403) {
			window.location.href = '/restaurant/view/conexion/';
		} else {
			console.log("Request failed: " + textStatus);
		}
	}).always(function() {
		document.getElementById("overlay").style.display = 'none';
	});
}

function actualizarCantidad(idComanda,idProducto,cantidad){
	// Bloqueo temporal del sistema hasta que se haya procesado la solicitud
	document.getElementById("overlay").style.display = 'block';
	
	$.ajax({
		url: 'acciones/actualizar_cantidad_producto.php',
		data: {idComanda: idComanda, idProducto: idProducto, cantidad: cantidad},
		method: 'POST',
		//async: false,
		dataType: 'html'
	}).done(function(resultado){
		if(resultado) {
			var precio = document.getElementById('precio' + idProducto).value;
	
        	document.getElementById('precio' + idProducto).nextSibling.textContent = cantidad * precio;
        	
        	var totalImpuesto = 0.0;
        	$('.porcentajeImpuesto' + idProducto).each(
        		function(){
        			var porcentaje = $(this).val();
        			this.nextSibling.textContent = ((porcentaje * precio)/100) * cantidad;
        		});
        		
        	var total = 0.0;
        	$('.precio').each(
        		function(){
        			total += parseFloat($(this).text().trim());
        		});
        		
        	var costoEnvio = document.getElementById('numberCostoEnvio').value;
			
			if(costoEnvio != '' && costoEnvio > 0){
				total += parseFloat(costoEnvio);
			}
        	$('#total-comanda').html("Total = " +total);
        	document.getElementById('textAPagar').value = total;
		} else {
    		alert("No se pudo actualizar la cantidad del producto");
		}
	}).fail(function(jqXHR, textStatus) {
		if(jqXHR.status == 403) {
			window.location.href = '/restaurant/view/conexion/';
		} else {
			console.log("Request failed: " + textStatus);
		}
	}).always(function() {
		document.getElementById("overlay").style.display = 'none';
	});
}

function eliminarProductoComanda(idComanda,idProducto){
	// Bloqueo temporal del sistema hasta que se haya procesado la solicitud
	document.getElementById("overlay").style.display = 'block';
	$.ajax({
		url: 'acciones/eliminar_producto_comanda.php',
		data: {idComanda: idComanda, idProducto: idProducto},
		method: 'POST',
		//async: false,
		dataType: 'html'
	}).done(function(resultado){
		if(resultado) {
			document.getElementById("productoComanda" + idProducto).remove();
			document.getElementById("controlesProductoComanda" + idProducto).remove();
        	if(document.getElementById('producto' + idProducto) != null){
        		document.getElementById('producto' + idProducto).style.display = 'block';
        	}
        	
        	$('.impuesto' + idProducto).remove();
        	
        	$('#productoIgnorar' + idProducto).remove();
        	
        	var total = 0.0;
        	$('.precio').each(
            	function(){
            		total += parseFloat($(this).text().trim());
            	});
            	
            var costoEnvio = document.getElementById('numberCostoEnvio').value;
			
			if(costoEnvio != '' && costoEnvio > 0){
				total += parseFloat(costoEnvio);
			}
        	$('#total-comanda').html("Total = " +total);
        	document.getElementById('textAPagar').value = total;
		} else {
    		alert("No se pudo actualizar la cantidad del producto");
		}
	}).fail(function(jqXHR, textStatus) {
		if(jqXHR.status == 403) {
			window.location.href = '/restaurant/view/conexion/';
		} else {
			console.log("Request failed: " + textStatus);
		}
	}).always(function() {
		document.getElementById("overlay").style.display = 'none';
	});
}

function activarBoton(boton){
	if(boton === "#botonConfirmarPago") {
    	if(document.getElementById("numberCantidadRecibida").value === "" || document.getElementById("numberCantidadRecibida").value == "0" 
    		|| document.getElementById("numberCantidadRecibida").value == "0.0" || !$("input[name=formaDePago]").is(':checked')){
    		$(boton).attr('disabled', 'disabled');
    	} else {
    		$(boton).removeAttr('disabled');
    	}
	}
}

function calcularCambio(){
	var cantidadAPagar = document.getElementById('textAPagar').value;
	var cantidadRecibida = document.getElementById('numberCantidadRecibida').value;
	
	if(cantidadRecibida < cantidadAPagar) {
		$("#botonConfirmarPago").attr('disabled', 'disabled');
	}
	
	document.getElementById('textCambio').value = cantidadRecibida - cantidadAPagar;
}

function actualizarCostoEnvio(costo){
	if(costo == "") {
		return false;
	}
	
	var idComanda = document.getElementById("idComanda").value;
	
	$.ajax({
		url: 'acciones/actualizar_costo_envio.php',
		data: {idComanda: idComanda, costoEnvio: costo},
		method: 'POST',
		dataType: 'html'
	}).done(function(resultado){
		if(resultado) {
			document.getElementById('numberCostoEnvio').style.color = 'green';
			
			var total = 0.0;
        	$('.precio').each(
            	function(){
            		total += parseFloat($(this).text().trim());
            	});
			
			total += parseFloat(costo);
        	$('#total-comanda').html("Total = " + total);
        	document.getElementById('textAPagar').value = total;
		}
	}).fail(function(jqXHR, textStatus) {
		if(jqXHR.status == 403) {
			window.location.href = '/restaurant/view/conexion/';
		} else {
			console.log("Request failed: " + textStatus);
		}
	});
}

function agregarNota(nota){
	if(nota == "") {
		return false;
	}
	
	var idComanda = document.getElementById("idComanda").value;
	
	$.ajax({
		url: 'acciones/agregar_nota.php',
		data: {idComanda: idComanda, nota: nota},
		method: 'POST',
		dataType: 'html'
	}).done(function(resultado){
		if(resultado) {
			document.getElementById('notaComanda').style.color = 'green';
		}
	}).fail(function(jqXHR, textStatus) {
		if(jqXHR.status == 403) {
			window.location.href = '/restaurant/view/conexion/';
		} else {
			console.log("Request failed: " + textStatus);
		}
	});
}

function cargarComandasRecientes(){
	$.ajax({
		url: 'acciones/obtener_comandas_recientes.php',
		method: 'GET'
	}).done(function(resultado){
		document.getElementById('comandasRecientes').innerHTML = resultado;
	}).fail(function(jqXHR, textStatus) {
		if(jqXHR.status == 403) {
			window.location.href = '/restaurant/view/conexion/';
		} else {
			console.log("Request failed: " + textStatus);
		}
	});
}

function cargarNuevaPaginaComandas(pagina){
	$.ajax({
		url: 'acciones/obtener_comandas_recientes.php',
		data: {pagina: pagina},
		method: 'GET'
	}).done(function(resultado){
		$('#comandasRecientes').append(resultado);
	}).fail(function(jqXHR, textStatus) {
		if(jqXHR.status == 403) {
			window.location.href = '/restaurant/view/conexion/';
		} else {
			console.log("Request failed: " + textStatus);
		}
	});
}

function marcaDetalleComandaPreparado(idDetalleComanda,idComanda){
	$.ajax({
		url: 'acciones/marcar_detalle_comanda_preparado.php',
		data: {id: idDetalleComanda},
		method: 'POST'
	}).done(function(resultado){
		if(resultado) {
			document.getElementById('detalleComanda' + idDetalleComanda).style.color = 'green';
			$('#detalleComanda' + idDetalleComanda + ' > button').attr('disabled','disabled');
			
			$.ajax({
        		url: 'acciones/consultar_cantidad_detalles_comanda_pendientes.php',
        		data: {id: idComanda},
        		method: 'GET'
        	}).done(function(resultado){
        		// Si devuelve falso, quiere decir que no tiene más detalles pendientes, por lo tanto desactivamos el botón de "Marcar como preparada" 
        		if(!resultado) {
        			//document.getElementById('botonMarcarPreparada' + idComanda).disabled = true;
        			//$("#comanda" + idComanda).hide();
        		}
        	}).fail(function(jqXHR, textStatus) {
        		if(jqXHR.status == 403) {
        			window.location.href = '/restaurant/view/conexion/';
        		} else {
        			console.log("Request failed: " + textStatus);
        		}
        	});
		}
	}).fail(function(jqXHR, textStatus) {
		if(jqXHR.status == 403) {
			window.location.href = '/restaurant/view/conexion/';
		} else {
			console.log("Request failed: " + textStatus);
		}
	});
}

function cancelarComanda(id){
	if(confirm("¿Estás segurx de cancelar la comanda?")) {
    	$.ajax({
    		url: 'acciones/cancelar.php',
    		data: {id: id},
    		method: 'POST'
    	}).done(function(resultado){
    		if(resultado) {
    			document.getElementById('comandaReciente' + id).style.display = 'none';
    		}
    	}).fail(function(jqXHR, textStatus) {
    		if(jqXHR.status == 403) {
    			window.location.href = '/restaurant/view/conexion/';
    		} else {
    			console.log("Request failed: " + textStatus);
    		}
    	});
	}
}

function modificarComanda(id){
	$.ajax({
		url: 'acciones/modificar.php',
		data: {id: id},
		method: 'GET',
	}).done(function(resultado){
	
		$('#modalVerRecientes').modal('toggle');
	
		document.getElementById('detalle-comanda').innerHTML = resultado;
		
		$(".filtros").show();
    	$("#productos").show();
    	$("#busqueda-cliente").show();
    	$("#detalle-comanda").show();
    	
    	// Borramos el total de la comanda anterior
    	//document.getElementById('textAPagar').value = "";
    	//document.getElementById("total-comanda").innerHTML = "";
    	
    	// Desactivar el botón pagar
    	//document.getElementById("botonPagar").disabled = true;
    	
    	var total = 0.0;
    	$('.precio').each(
        	function(){
        		total += parseFloat($(this).text().trim());
        	});
		
		// Si es una comanda de entrega a domicilio, hay que agregar el envío al total
		var tipoComanda = (document.getElementById('selectTipo') != null) ? document.getElementById('selectTipo').value : 0; 
		if(tipoComanda == '2') {
			total += parseFloat(document.getElementById('numberCostoEnvio').value);
		}
		
    	$('#total-comanda').html("Total = " +total);
    	document.getElementById('textAPagar').value = total;
    	
    	var comandaPagada = document.getElementById("comandaPagada").value;
    	if(comandaPagada != '' && comandaPagada == '1') {
    		document.getElementById('productos').style.display = 'none';
    		// Ocultar los botones de pagar y cancelar
    		document.getElementById('contenedor-botones').style.display = 'none';
    	} else { 
    		// Traer los productos filtrados
    		filtrar('');
    		document.getElementById('productos').style.display = 'flex';
    		// Si ya hay una cantidad a pagar, se muestra el botón de pago
        	if(total > 0){
        		document.getElementById('contenedor-botones').style.display = 'block';
        	} else {
        		document.getElementById('contenedor-botones').style.display = 'none';
        	}
    	}
	}).fail(function(jqXHR, textStatus) {
		if(jqXHR.status == 403) {
			window.location.href = '/restaurant/view/conexion/';
		} else {
			console.log("Request failed: " + textStatus);
		}
	});
}

function confirmarPago(){
	var idComanda = document.getElementById("idComanda").value;
	var formaPago = $("input[name='formaDePago']:checked").val();
	var cantidadRecibida = document.getElementById("numberCantidadRecibida").value;
	
	$.ajax({
		url: 'acciones/pagar.php',
		data: {idComanda: idComanda, formaPago: formaPago, cantidadRecibida: cantidadRecibida},
		method: 'POST',
		dataType: 'html'
	}).done(function(resultado){
		if(resultado) {
			$('#notificacionesComandas').html('Pago registrado');
			$('#notificacionesComandas').fadeIn(1000);
			$('#notificacionesComandas').fadeOut(5000);
			$('#modalPagar').modal('toggle');
			
			// Reiniciar y ocultar lo que se requiere
			document.getElementById('detalle-comanda').innerHTML = '';
		
    		$(".filtros").hide();
        	$("#productos").hide();
        	$("#busqueda-cliente").hide();
        	$("#detalle-comanda").hide();
        	
        	// Borramos el total de la comanda anterior
        	document.getElementById('textAPagar').value = "";
        	document.getElementById("total-comanda").innerHTML = "";
        	
        	// Desactivar el botón pagar
        	document.getElementById("contenedor-botones").style.display = 'none';
        	
        	$.ajax({
        		url: 'acciones/actualizar_inventario.php',
        		data: {idComanda: idComanda},
        		method: 'POST',
        		dataType: 'html'
        	}).done(function (resultado) {
        		if(!resultado) {
        			alert("Hubo un problema al actualizar el inventario, favor de revisar");
        		}
        	}).fail(function(jqXHR, textStatus) {
        		if(jqXHR.status == 403) {
        			window.location.href = '/restaurant/view/conexion/';
        		} else {
        			console.log("Request failed: " + textStatus);
        		}
        	});
        	
		} else {
			alert('No se pudo guardar el pago, por favor intenta de nuevo');
		}
	}).fail(function(jqXHR, textStatus) {
		if(jqXHR.status == 403) {
			window.location.href = '/restaurant/view/conexion/';
		} else {
			console.log("Request failed: " + textStatus);
		}
	});
}
</script>
<?php require_once '../fin.php';?>