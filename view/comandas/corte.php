<?php

session_start();

if(!isset($_SESSION['conectadx']) || !$_SESSION['conectadx']){
    header("Location: /restaurant/desconectar.php");
    exit();
}

require_once '../principio.php';
require_once '../menu.php';?>
<div class="content">
	<div id='detalle-corte'></div>
</div>
<script>
$(document).ready(function(){
	consultar();
});

function consultar() {
	$.ajax({
		url: 'acciones/obtener_detalle_corte.php',
		method: 'GET'
	}).done(function(resultado){
		document.getElementById('detalle-corte').innerHTML = resultado;
	}).fail( function(jqXHR, textStatus){
		$('.toas').show();
		$('.toast-body').html("Request failed: " + textStatus);
		$('.toast').toast('show');
	});
}

function actualizarCorte() {	
	var diferenciaCorte = parseFloat(document.getElementById('diferenciaCorte').value);
	var totalEfectivo = isNaN(parseFloat(document.getElementById('totalEfectivo').value)) ? 0 : parseFloat(document.getElementById('totalEfectivo').value);
	var totalTransferencia = isNaN(parseFloat(document.getElementById('totalTransferencia').value)) ? 0 : parseFloat(document.getElementById('totalTransferencia').value);
	var totalTarjeta = isNaN(parseFloat(document.getElementById('totalTarjeta').value)) ? 0 : parseFloat(document.getElementById('totalTarjeta').value);
	var totalNoEspecificado = isNaN(parseFloat(document.getElementById('totalNoEspecificado').value)) ? 0 : parseFloat(document.getElementById('totalNoEspecificado').value);
	
	var granTotal = (totalEfectivo + totalTransferencia + totalTarjeta + totalNoEspecificado) + diferenciaCorte;
	
	document.getElementById('textDiferenciaCorte').value = granTotal.toFixed(2);
}

function guardarCorte(){

	if(isNaN(parseFloat(document.getElementById('totalEfectivo').value)) || isNaN(parseFloat(document.getElementById('totalTransferencia').value)) || isNaN(parseFloat(document.getElementById('totalTarjeta').value))
		|| isNaN(parseFloat(document.getElementById('totalNoEspecificado').value))) {
			return false;
		}

	var diferencia = parseFloat(document.getElementById('textDiferenciaCorte').value);
	var continuar = false;
	if(diferencia != 0) {
		continuar = confirm('Estás a punto de guardar un corte con diferencia ¿Deseas continuar?');
	} else {
		continuar = confirm('El corte quedó perfectamente ¿Deseas guardarlo?');
	}
	
	if(continuar) {
	
		var totalEfectivo = parseFloat(document.getElementById('totalEfectivo').value);
    	var totalTransferencia = parseFloat(document.getElementById('totalTransferencia').value);
    	var totalTarjeta = parseFloat(document.getElementById('totalTarjeta').value);
    	var totalNoEspecificado = parseFloat(document.getElementById('totalNoEspecificado').value);
	
		var detallesComanda = [];
		
		item = {};
		item["tipo"] = 1;
		item["cantidad"] = totalEfectivo; 
		detallesComanda.push(item);
		
		item = {};
		item["tipo"] = 2;
		item["cantidad"] = totalTransferencia; 
		detallesComanda.push(item);
		
		item = {};
		item["tipo"] = 3;
		item["cantidad"] = totalTarjeta; 
		detallesComanda.push(item);
		
		item = {};
		item["tipo"] = 4;
		item["cantidad"] = totalNoEspecificado; 
		detallesComanda.push(item);
	
		$.ajax({
    		url: 'acciones/guardar_corte.php',
    		data: {"detallesComanda": detallesComanda},
    		method: 'POST'
    	}).done(function(resultado){
    		if(resultado) {
    			alert("Corte guardado");
    			document.getElementById('totalEfectivo').disabled = true;
    			document.getElementById('totalTransferencia').disabled = true;
    			document.getElementById('totalTarjeta').disabled = true;
    			document.getElementById('totalNoEspecificado').disabled = true;
    			document.getElementById('botonGuardarCorte').disabled = true;
    			document.getElementById('textDiferenciaCorte').disabled = true;
    		} else {
    			alert("No se pudo guardar el corte. Intenta de nuevo por favor");
    		}
    	}).fail( function(jqXHR, textStatus){
    		$('.toas').show();
    		$('.toast-body').html("Request failed: " + textStatus);
    		$('.toast').toast('show');
    	});
	}
}
</script>
<?php require_once '../fin.php';?>