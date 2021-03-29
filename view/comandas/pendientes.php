<?php

session_start();

if(!isset($_SESSION['conectadx']) || !$_SESSION['conectadx']){
    header("Location: /restaurant/desconectar.php");
    exit();
}

require_once '../principio.php';
require_once '../menu.php';?>
<div class="content">
	<!-- Toast -->
    <div style="display: none" class="toast-container position-absolute top-50 start-50 translate-middle">
        <div class="toast">
          <div class="toast-header" role="alert">
            Mensaje
          </div>
          <div class="toast-body">      
          </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12">
        	<!-- <div id="filtros-comandas" class="row">
        		<div class="col-md-3 col-sm-6 filtros" style="margin-bottom: 5px">
        			<input id="textFiltrar" type="search" placeholder="Filtrar comandas" onkeyup="filtrar(this.value)"/>
        		</div>
        	</div>-->
        	<div id="comandas" class="row">
        	</div>
		</div>
	</div>
</div>
<script>
$(document).ready(function(){
	consultar();
	
	setInterval(function(){ consultar(); }, 30000);
});

function consultar(){
	$.ajax({
		url: 'acciones/obtener_comandas_pendientes.php',
		method: 'GET'
	}).done(function(resultado){
		document.getElementById('comandas').innerHTML = resultado;
	}).fail( function(jqXHR, textStatus){
		$('.toas').show();
		$('.toast-body').html("Request failed: " + textStatus);
		$('.toast').toast('show');
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
        			document.getElementById('botonMarcarPreparada' + idComanda).disabled = true;
        			$("#comanda" + idComanda).hide();
        		}
        	}).fail( function(jqXHR, textStatus){
        		$('.toas').show();
        		$('.toast-body').html("Request failed: " + textStatus);
        		$('.toast').toast('show');
        	});
		}
	}).fail( function(jqXHR, textStatus){
		$('.toas').show();
		$('.toast-body').html("Request failed: " + textStatus);
		$('.toast').toast('show');
	});
}

function marcarComandaPreparada(id){
	$.ajax({
		url: 'acciones/marcar_comanda_preparada.php',
		data: {id: id},
		method: 'POST'
	}).done(function(resultado){
		if(resultado) {
			$("#comanda" + id).hide();
		}
	}).fail( function(jqXHR, textStatus){
		$('.toas').show();
		$('.toast-body').html("Request failed: " + textStatus);
		$('.toast').toast('show');
	});
}
</script>
<?php require_once '../fin.php';?>