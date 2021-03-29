<?php

session_start();

if(!isset($_SESSION['tipoUsuarix']) || $_SESSION['tipoUsuarix'] != 2){
    header("Location: /restaurant/desconectar.php");
    exit();
}

require_once '../principio.php';
require_once '../menu.php';?>
<div class="content">
	<h3>Impuestos</h3>
	<div id="acciones">
		<button class="btn btn-secondary" data-bs-toggle='modal' data-bs-target='#modalAgregar' type="button" onclick="limpiaControles()"><i class="bi-plus-circle-fill icono-boton"></i>Agregar</button>
	</div>
	<div id="notificacionesImpuestos" style="text-align:center;font-weight:bold;display:none"></div>
    <table class="table table-responsive table-striped">
    	<thead>
    		<tr class="encabezado-catalogo">
    			<th>Nombre</th>
    			<th>Porcentaje</th>
    			<th>Estatus</th>
    			<th>Acciones</th>
    		</tr>
    	</thead>
    	<tbody>
    	</tbody>
    </table>
    <!-- Modal agregar -->
    <div class="modal fade" id="modalAgregar" tabindex="-1" role="dialog" aria-labelledby="modalAgregarLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalAgregarLabel">Agregar impuesto</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
            <div class="modal-body">
            	<div id="mensajeAgregar" class="mb-3 mensaje"></div>
            	<div class="informacion-obligatoria">Información obligatoria*</div>
                <div class="mb-3">
          			<label class="form-label obligatoria" for="textAgregarNombre">Nombre*:</label>
          			<input id="textAgregarNombre" class="form-control" type="text" onblur="activarBoton('#botonGuardar')"/>
          		</div>
          		<div class="mb-3">
          			<label class="form-label obligatoria" for="numberAgregarPorcentaje">Porcentaje*:</label>
          			<input id="numberAgregarPorcentaje" class="form-control" type="number" min="0" onblur="activarBoton('#botonGuardar')"/>
          		</div>
            	<div class="mb-3">
          			<label class="form-label obligatoria" for="selectAgregarEstatus">Estatus*:</label>
            		<select id="selectAgregarEstatus" class="form-select" onchange="activarBoton('#botonGuardar')">
                      <option selected="selected" value="">Seleccionar</option>
                      <option value="1">Activo</option>
                      <option value="0">Inactivo</option>
                    </select>
        		</div>
          	</div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            <button id="botonGuardar" disabled="disabled" type="button" class="btn btn-primary" onclick="guardar()">Guardar</button>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal editar -->
    <div class="modal fade" id="modalActualizar" tabindex="-1" role="dialog" aria-labelledby="modalActualizarLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalActualizarLabel">Editar impuesto</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
            <div class="modal-body">
            	<input type="hidden" id="idImpuesto"/>
            	<div id="mensaje" class="mb-3 mensaje"></div>
            	<div class="informacion-obligatoria">Información obligatoria*</div>
                <div class="mb-3">
          			<label class="form-label obligatoria" for="textEditarNombre">Nombre*:</label>
          			<input id="textEditarNombre" class="form-control" onblur="activarBoton('#botonActualizar')" type="text" name="nombre"/>
          		</div>
          		<div class="mb-3">
          			<label class="form-label obligatoria" for="numberEditarPorcentaje">Porcentaje*:</label>
          			<input id="numberEditarPorcentaje" class="form-control" type="number" min="0" onblur="activarBoton('#botonActualizar')"/>
          		</div>
            	<div class="mb-3">
          			<label class="form-label obligatoria" for="selectEditarEstatus">Estatus*:</label>
            		<select id="selectEditarEstatus" class="form-select" onchange="activarBoton('#botonActualizar')">
                      <option selected="selected" value="">Seleccionar</option>
                      <option value="1">Activo</option>
                      <option value="0">Inactivo</option>
                    </select>
        		</div>
          	</div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            <button id="botonActualizar" type="button" class="btn btn-primary" onclick="actualizar()">Actualizar</button>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal Eliminar -->
    <div class="modal fade" id="modalEliminar" tabindex="-1" role="dialog" aria-labelledby="modalEliminarLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalEliminarLabel">Eliminar impuesto</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
            <div class="modal-body">
            	<input type="hidden" id="idImpuestoEliminar"/>
            	<div id="mensajeEliminar" class="mb-3 mensaje"></div>
                <div class="mb-3">
                	¿Realmente desea eliminar el impuesto?
          			<input id="textNombreImpuestoEliminar" class="form-control" type="text" name="nombre" readonly="readonly"/>
          		</div>
          	</div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="button" class="btn btn-primary" onclick="eliminar()">Eliminar</button>
          </div>
        </div>
      </div>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function (){
		consultar();
	});

function consultar(){
	$.ajax({
		url: 'acciones/consultar.php',
		method: 'GET'
	}).done(function(resultado){
		$('tbody').html(resultado);
	}).fail(function(jqXHR, textStatus) {
		if(jqXHR.status == 403) {
			window.location.href = '/restaurant/view/conexion/';
		} else {
			console.log("Request failed: " + textStatus);
		}
	});
}	

function cargarDatos(id){
	document.getElementById("textEditarNombre").value = document.getElementById("nombre" + id).innerHTML;
	document.getElementById("numberEditarPorcentaje").value = document.getElementById("porcentaje" + id).innerHTML; 
	document.getElementById("selectEditarEstatus").value = document.getElementById("estatus" + id).value;
	document.getElementById("idImpuesto").value = id;
}

function activarBoton(boton){
	if(boton === "#botonGuardar") {
    	if(document.getElementById("textAgregarNombre").value === "" || document.getElementById("selectAgregarEstatus").value === ""
    		|| document.getElementById("numberAgregarPorcentaje").value === ""){
    		$(boton).attr('disabled', 'disabled');
    	} else {
    		$(boton).removeAttr('disabled');
    	}
	} else {
		if(document.getElementById("textEditarNombre").value === "" || document.getElementById("selectEditarEstatus").value === ""
			|| document.getElementById("numberEditarPorcentaje").value === ""){
    		$(boton).attr('disabled', 'disabled');
    	} else {
    		$(boton).removeAttr('disabled');
    	}
	}
}

function validar(accion){
	// 0 = Guardar Else = Editar
	if(accion == 0){
		if(document.getElementById("textAgregarNombre").value == "" || document.getElementById("selectAgregarEstatus").value == ""
			|| document.getElementById("numberAgregarPorcentaje").value === ""){
			return false;
		}
	} else {
		if(document.getElementById("textEditarNombre").value == "" || document.getElementById("selectEditarEstatus").value == ""
			|| document.getElementById("numberEditarPorcentaje").value === ""){
			return false;
		}
	}
	return true;
}

function guardar(){
	
	if(!validar(0)){
		return false;
	}

	var nombre = document.getElementById("textAgregarNombre").value;
	var porcentaje = document.getElementById("numberAgregarPorcentaje").value;
	var estatus = document.getElementById("selectAgregarEstatus").value;

	$.ajax({
		url: 'acciones/nuevo.php',
		method: 'POST',
		data: {nombre: nombre, porcentaje: porcentaje, estatus: estatus},
		dataType: 'html'
	}).done(function(resultado){
		if(resultado) {
			$('#notificacionesImpuestos').html('Impuesto guardado');
    		consultar();
    		$("#modalAgregar").modal("hide");
    		$('#notificacionesImpuestos').fadeIn(1000);
			$('#notificacionesImpuestos').fadeOut(5000);
		} else {
			$('#mensajeAgregar').html('No se pudo guardar el impuesto. Por favor intenta de nuevo');
			$('#mensajeAgregar').fadeIn(1000);
			$('#mensajeAgregar').fadeOut(5000);
		}
	}).fail(function(jqXHR, textStatus) {
		if(jqXHR.status == 403) {
			window.location.href = '/restaurant/view/conexion/';
		} else {
			console.log("Request failed: " + textStatus);
		}
	});
}

function actualizar(){

	if(!validar(1)){
		return false;
	}

	var id = document.getElementById("idImpuesto").value;
	var nombre = document.getElementById("textEditarNombre").value;
	var porcentaje = document.getElementById("numberEditarPorcentaje").value;
	var estatus = document.getElementById("selectEditarEstatus").value;
	
	$.ajax({
		url: 'acciones/actualizar.php',
		method: 'POST',
		data: {id: id, nombre: nombre, porcentaje: porcentaje, estatus: estatus},
		dataType: 'html'
	}).done(function(resultado){
		if(resultado) {
			$('#notificacionesImpuestos').html('Impuesto actualizado');
			consultar();
			$("#modalActualizar").modal("hide");
			$('#notificacionesImpuestos').fadeIn(1000);
			$('#notificacionesImpuestos').fadeOut(5000);
		} else {
			$('#mensaje').html('No se pudo actualizar el impuesto. Por favor intenta de nuevo');
			$('#mensaje').fadeIn(1000);
			$('#mensaje').fadeOut(5000);
		}
	}).fail(function(jqXHR, textStatus) {
		if(jqXHR.status == 403) {
			window.location.href = '/restaurant/view/conexion/';
		} else {
			console.log("Request failed: " + textStatus);
		}
	});
}

function cargarDatosEliminar(id){
	document.getElementById("textNombreImpuestoEliminar").value = document.getElementById("nombre" + id).innerHTML;
	document.getElementById("idImpuestoEliminar").value = id;
}

function eliminar(){
	var id = document.getElementById("idImpuestoEliminar").value;
	$.ajax({
		url: 'acciones/eliminar.php',
		method: 'POST',
		data: {id: id},
		dataType: 'html'
	}).done(function(resultado){
		if(resultado == 1) {
			$('#notificacionesImpuestos').html('Impuesto eliminado');
			consultar();
			$("#modalEliminar").modal("hide");
			$('#notificacionesImpuestos').fadeIn(1000);
			$('#notificacionesImpuestos').fadeOut(5000);
		} else if(resultado == 2) {
			$('#notificacionesImpuestos').html('El impuesto se desactivó. No se puede eliminar porque ya está asociado al menos a un producto');
			consultar();
			$("#modalEliminar").modal("hide");
			$('#notificacionesImpuestos').fadeIn(1000);
			$('#notificacionesImpuestos').fadeOut(5000);
		} else {
			$('#mensajeEliminar').html('No se pudo eliminar la categoría. Por favor intenta de nuevo');
			$('#mensajeEliminar').fadeIn(1000);
			$('#mensajeEliminar').fadeOut(5000);
		}
	}).fail(function(jqXHR, textStatus) {
		if(jqXHR.status == 403) {
			window.location.href = '/restaurant/view/conexion/';
		} else {
			console.log("Request failed: " + textStatus);
		}
	});
}

function limpiaControles(){
	document.getElementById("textAgregarNombre").value = "";
	document.getElementById("numberAgregarPorcentaje").value = "";
	document.getElementById("selectAgregarEstatus").value = "";
}
</script>
<?php require_once '../fin.php';?>
