<?php

session_start();

if(!isset($_SESSION['tipoUsuarix']) || $_SESSION['tipoUsuarix'] != 2){
    header("Location: /restaurant/desconectar.php");
    exit();
}

require_once '../principio.php';
require_once '../menu.php';?>
<div class="content">
	<h3>Insumos</h3>
	<div id="acciones">
		<button class="btn btn-secondary" data-bs-toggle='modal' data-bs-target='#modalAgregar' type="button" onclick="limpiaControles()"><i class="bi-plus-circle-fill icono-boton"></i>Agregar</button>
	</div>
	<div id="notificacionesInsumos" style="text-align: center;font-weight:bold;display:none"></div>
    <table class="table table-responsive table-striped">
    	<thead>
    		<tr class="encabezado-catalogo">
    			<th>Nombre</th>
    			<th>Existencias</th>
    			<th>Alerta</th>
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
            <h5 class="modal-title" id="modalAgregarLabel">Agregar insumo</h5>
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
          			<label class="form-label" for="numberAgregarExistencia">Existencia:</label>
          			<input id="numberAgregarExistencia" class="form-control" type="number" min="0"/>
          		</div>
          		<div class="mb-3 form-check">
          			<input id="checkboxAgregarAlerta" class="form-check-input" type="checkbox"/>
          			<label class="form-label" for="checkboxAgregarAlerta">Notificación de existencia baja</label>
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
                    <h5 class="modal-title" id="modalActualizarLabel">Editar insumo</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    	<span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="idInsumo"/>
                    <div id="mensaje" class="mb-3 mensaje"></div>
                    <div class="informacion-obligatoria">Información obligatoria*</div>
                    <div class="mb-3">
                        <label class="form-label obligatoria" for="textEditarNombre">Nombre*:</label>
                        <input id="textEditarNombre" class="form-control" type="text" onblur="activarBoton('#botonGuardar')"/>
                    </div>
                    <div class="mb-3">
                        <label class="form-label obligatoria" for="numberEditarExistencia">Existencia:</label>
                        <input id="numberEditarExistencia" class="form-control" type="number"/>
                    </div>
                    <div class="mb-3 form-check">
                        <input id="checkboxEditarAlerta" class="form-check-input" type="checkbox"/>
                        <label class="form-label obligatoria" for="checkboxEditarAlerta">Notificación de existencia baja</label>
                    </div>
                    <div class="mb-3">
                        <label class="form-label obligatoria" for="selectEditarEstatus">Estatus*:</label>
                        <select id="selectEditarEstatus" class="form-select" onchange="activarBoton('#botonGuardar')">
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
            <h5 class="modal-title" id="modalEliminarLabel">Eliminar insumo</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
            <div class="modal-body">
            	<input type="hidden" id="idInsumoEliminar"/>
            	<div id="mensajeEliminar" class="mb-3 mensaje"></div>
                <div class="mb-3">
                	¿Realmente desea eliminar el insumo?
          			<input id="textNombreInsumoEliminar" class="form-control" type="text" name="nombre" readonly="readonly"/>
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
	document.getElementById("numberEditarExistencia").value = document.getElementById("existencia" + id).innerHTML;
	document.getElementById("checkboxEditarAlerta").checked = (document.getElementById("alerta" + id).value == '0') ? false : true;
	document.getElementById("idInsumo").value = id;
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
	var existencia = document.getElementById("numberAgregarExistencia").value;
	var alerta = (document.getElementById("checkboxAgregarAlerta").checked) ? 1 : 0;
	var estatus = document.getElementById("selectAgregarEstatus").value;

	$.ajax({
		url: 'acciones/nuevo.php',
		method: 'POST',
		data: {nombre: nombre, existencia: existencia, alerta: alerta, estatus: estatus},
		dataType: 'html'
	}).done(function(resultado){
		if(resultado) { 
			$('#notificacionesInsumos').html('Insumo guardado');
			consultar();
			$("#modalAgregar").modal("hide");
			$('#notificacionesInsumos').fadeIn(1000);
			$('#notificacionesInsumos').fadeOut(5000);
		} else {
			$('#mensaje').html('No se pudo guardar el insumo. Por favor intenta de nuevo');
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

function actualizar(){

	if(!validar(1)){
		return false;
	}

	var id = document.getElementById("idInsumo").value;
	var nombre = document.getElementById("textEditarNombre").value;
	var existencia = document.getElementById("numberEditarExistencia").value;
	var alerta = (document.getElementById("checkboxEditarAlerta").checked) ? 1 : 0
	var estatus = document.getElementById("selectEditarEstatus").value;
	
	$.ajax({
		url: 'acciones/actualizar.php',
		method: 'POST',
		data: {id: id, nombre: nombre, existencia: existencia, alerta: alerta, estatus: estatus},
		dataType: 'html'
	}).done(function(resultado){
		if(resultado) { 
			$('#notificacionesInsumos').html('Insumo actualizado');
			consultar();
			$("#modalActualizar").modal("hide");
			$('#notificacionesInsumos').fadeIn(1000);
			$('#notificacionesInsumos').fadeOut(5000);
		} else {
			$('#mensaje').html('No se pudo actualizar el insumo. Por favor intenta de nuevo');
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
	document.getElementById("textNombreInsumoEliminar").value = document.getElementById("nombre" + id).innerHTML;
	document.getElementById("idInsumoEliminar").value = id;
}

function eliminar(){
	var id = document.getElementById("idInsumoEliminar").value;
	$.ajax({
		url: 'acciones/eliminar.php',
		method: 'POST',
		data: {id: id},
		dataType: 'html'
	}).done(function(resultado){
		if(resultado == 1) {
			$('#notificacionesInsumos').html('Insumo eliminado');
			consultar();
			$("#modalEliminar").modal("hide");
			$('#notificacionesInsumos').fadeIn(1000);
			$('#notificacionesInsumos').fadeOut(5000);
		} else if(resultado == 2) {
			$('#notificacionesInsumos').html('El insumo se desactivó. No se puede eliminar porque ya está asociadx al menos a un producto');
			consultar();
			$("#modalEliminar").modal("hide");
			$('#notificacionesInsumos').fadeIn(1000);
			$('#notificacionesInsumos').fadeOut(5000);
		} else {
			$('#mensajeEliminar').html('No se pudo eliminar el insumo. Por favor intenta de nuevo');
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
	document.getElementById("numberAgregarExistencia").value = "";
	document.getElementById("checkboxAgregarAlerta").checked = false;
	document.getElementById("selectAgregarEstatus").value = "";
	document.getElementById("textAgregarNombre").focus();
}
</script>
<?php require_once '../fin.php';?>
