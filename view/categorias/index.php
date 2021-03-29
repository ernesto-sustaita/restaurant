<?php

session_start();

if(!isset($_SESSION['tipoUsuarix']) || $_SESSION['tipoUsuarix'] != 2){
    header("Location: /restaurant/desconectar.php");
    exit();
}

require_once '../principio.php';
require_once '../menu.php';?>
<div class="content">
	<h3>Categorías</h3>
	<div id="acciones">
		<button class="btn btn-secondary" data-bs-toggle='modal' data-bs-target='#modalAgregar' type="button" onclick="limpiaControles()"><i class="bi-plus-circle-fill icono-boton"></i>Agregar</button>
	</div>
	<div id="notificacionesCategorias" style="text-align: center;font-weight:bold;display:none"></div>
    <table class="table table-responsive table-striped">
    	<thead>
    		<tr class="encabezado-catalogo">
    			<th>Nombre</th>
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
            <h5 class="modal-title" id="modalAgregarLabel">Agregar categoría</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
            <div class="modal-body">
            	<div id="mensajeAgregar" class="mb-3 mensaje"></div>
            	<div class="informacion-obligatoria">Información obligatoria*</div>
                <div class="mb-3">
          			<label class="form-label obligatoria" for="textAgregarNombre">Nombre*:</label>
          			<input id="textAgregarNombre" class="form-control" type="text" name="nombre" onblur="activarBoton('#botonGuardar')"/>
          		</div>
            	<div class="mb-3">
          			<label class="form-label obligatoria" for="selectAgregarEstatus">Estatus*:</label>
            		<select id="selectAgregarEstatus" class="form-select" onchange="activarBoton('#botonGuardar')">
                      <option selected="selected" value="">Seleccionar</option>
                      <option value="1">Activa</option>
                      <option value="0">Inactiva</option>
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
            <h5 class="modal-title" id="modalActualizarLabel">Editar categoría</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
            <div class="modal-body">
            	<input type="hidden" id="idCategoria"/>
            	<div id="mensaje" class="mb-3 mensaje"></div>
            	<div class="informacion-obligatoria">Información obligatoria*</div>
                <div class="mb-3">
          			<label class="form-label obligatoria" for="textEditarNombre">Nombre*:</label>
          			<input id="textEditarNombre" class="form-control" onblur="activarBoton('#botonActualizar')" type="text" name="nombre"/>
          		</div>
            	<div class="mb-3">
          			<label class="form-label obligatoria" for="selectEditarEstatus">Estatus*:</label>
            		<select id="selectEditarEstatus" class="form-select" onchange="activarBoton('#botonActualizar')">
                      <option selected="selected" value="">Seleccionar</option>
                      <option value="1">Activa</option>
                      <option value="0">Inactiva</option>
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
            <h5 class="modal-title" id="modalEliminarLabel">Eliminar categoría</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
            <div class="modal-body">
            	<input type="hidden" id="idCategoriaEliminar"/>
            	<div id="mensajeEliminar" class="mb-3 mensaje"></div>
                <div class="mb-3">
                	¿Realmente desea eliminar la categoría?
          			<input id="textNombreCategoriaEliminar" class="form-control" type="text" name="nombre" readonly="readonly"/>
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
	document.getElementById("selectEditarEstatus").value = document.getElementById("estatus" + id).value;
	document.getElementById("idCategoria").value = id;
}

function activarBoton(boton){
	if(boton === "#botonGuardar") {
    	if(document.getElementById("textAgregarNombre").value === "" || document.getElementById("selectAgregarEstatus").value === ""){
    		$(boton).attr('disabled', 'disabled');
    	} else {
    		$(boton).removeAttr('disabled');
    	}
	} else {
		if(document.getElementById("textEditarNombre").value === "" || document.getElementById("selectEditarEstatus").value === ""){
    		$(boton).attr('disabled', 'disabled');
    	} else {
    		$(boton).removeAttr('disabled');
    	}
	}
}

function validar(accion){
	// 0 = Guardar Else = Editar
	if(accion == 0){
		if(document.getElementById("textAgregarNombre").value == "" || document.getElementById("selectAgregarEstatus").value == ""){
			return false;
		}
	} else {
		if(document.getElementById("textEditarNombre").value == "" || document.getElementById("selectEditarEstatus").value == ""){
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
	var estatus = document.getElementById("selectAgregarEstatus").value;

	$.ajax({
		url: 'acciones/nuevo.php',
		method: 'POST',
		data: {nombre: nombre, estatus: estatus},
		dataType: 'html'
	}).done(function(resultado){
		if(resultado) {
			$('#notificacionesCategorias').html('Categoría guardada');
			consultar();
			$('#modalAgregar').modal('hide');
			$('#notificacionesCategorias').fadeIn(1000);
			$('#notificacionesCategorias').fadeOut(5000);
		} else {
			$('#mensajeAgregar').html('No se pudo guardar la categoría');
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

	var id = document.getElementById("idCategoria").value;
	var nombre = document.getElementById("textEditarNombre").value;
	var estatus = document.getElementById("selectEditarEstatus").value;
	
	$.ajax({
		url: 'acciones/actualizar.php',
		method: 'POST',
		data: {id: id, nombre: nombre, estatus: estatus},
		dataType: 'html'
	}).done(function(resultado){
		if(resultado) {
			$('#notificacionesCategorias').html('Categoría actualizada');
			consultar();
			$('#modalActualizar').modal('hide');
			$('#notificacionesCategorias').fadeIn(1000);
			$('#notificacionesCategorias').fadeOut(5000);
		} else {
			$('#mensaje').html('No se pudo actualizar la categoría. Por favor intenta de nuevo');
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
	document.getElementById("textNombreCategoriaEliminar").value = document.getElementById("nombre" + id).innerHTML;
	document.getElementById("idCategoriaEliminar").value = id;
}

function eliminar(){
	var id = document.getElementById("idCategoriaEliminar").value;
	$.ajax({
		url: 'acciones/eliminar.php',
		method: 'POST',
		data: {id: id},
		dataType: 'html'
	}).done(function(resultado){
		if(resultado == 1) {
			$('#notificacionesCategorias').html('Categoría eliminada');
			consultar();
			$("#modalEliminar").modal("hide");
			$('#notificacionesCategorias').fadeIn(1000);
			$('#notificacionesCategorias').fadeOut(5000);
		} else if(resultado == 2) {
			$('#notificacionesCategorias').html('La categoría se desactivó. No se puede eliminar porque ya está asociada al menos a un producto');
			consultar();
			$("#modalEliminar").modal("hide");
			$('#notificacionesCategorias').fadeIn(1000);
			$('#notificacionesCategorias').fadeOut(5000);
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
	document.getElementById("selectAgregarEstatus").value = "";
}
</script>
<?php require_once '../fin.php';?>
