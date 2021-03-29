<?php

session_start();

if(!isset($_SESSION['tipoUsuarix']) || $_SESSION['tipoUsuarix'] != 2){
    header("Location: /restaurant/desconectar.php");
    exit();
}

require_once '../principio.php';
require_once '../menu.php';?>
<div class="content">
	<h3>Usuarixs</h3>
	<div id="acciones">
		<button class="btn btn-secondary" data-bs-toggle='modal' data-bs-target='#modalAgregar' type="button"><i class="bi-plus-circle-fill icono-boton"></i>Agregar</button>
	</div>
	<div id="notificacionesUsuarixs" style="text-align: center;font-weight:bold;display:none"></div>
    <table class="table table-responsive table-striped">
    	<thead>
    		<tr class="encabezado-catalogo">
    			<th>Usuarix</th>
    			<th>Perfil</th>
    			<th>Registro</th>
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
            <h5 class="modal-title" id="modalAgregarLabel">Agregar usuarix</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
            <div class="modal-body">
            	<div id="mensajeAgregar" class="mb-3 mensaje"></div>
            	<div class="informacion-obligatoria">Información obligatoria*</div>
                <div class="mb-3">
          			<label class="form-label obligatoria" for="textAgregarNombreUsuario">Nombre de usuarix*:</label>
          			<input id="textAgregarNombreUsuario" class="form-control" type="text" name="nombre" onblur="activarBoton('#botonGuardar')"/>
          		</div>
          		<div class="mb-3">
          			<label class="form-label obligatoria" for="textAgregarContrasenaUsuario">Contraseña*:</label>
          			<input id="textAgregarContrasenaUsuario" class="form-control" type="password" name="contrasena" onblur="activarBoton('#botonGuardar')"/>
          		</div>
            	<div class="mb-3">
          			<label class="form-label obligatoria" for="selectAgregarTipoUsuario">Tipo de usuarix*:</label>
            		<select id="selectAgregarTipoUsuario" class="form-select" aria-label="Default select example" onchange="activarBoton('#botonGuardar')">
                      <option selected>Seleccionar</option>
                      <option value="1">Vendedorx</option>
                      <option value="2">Administradorx</option>
                    </select>
        		</div>
        		<div class="mb-3">
          			<label class="form-label obligatoria" for="selectAgregarEstatus">Estatus*:</label>
            		<select id="selectAgregarEstatus" class="form-select" onchange="activarBoton('#botonGuardar')">
                      <option selected="selected" value="">Seleccionar</option>
                      <option value="1">Activx</option>
                      <option value="0">Inactivx</option>
                    </select>
        		</div>
          	</div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-primary" id="botonGuardar" onclick="guardar()">Guardar</button>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal editar -->
    <div class="modal fade" id="modalActualizar" tabindex="-1" role="dialog" aria-labelledby="modalActualizarLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalActualizarLabel">Editar usuarix</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
            <div class="modal-body">
            	<input type="hidden" id="idUsuario"/>
            	<div id="mensaje" class="mb-3 mensaje"></div>
            	<div class="informacion-obligatoria">Información obligatoria*</div>
                <div class="mb-3">
          			<label class="form-label obligatoria" for="textNombreUsuario">Nombre de usuarix*:</label>
          			<input id="textNombreUsuario" class="form-control" type="text" name="nombre" onblur="activarBoton('#botonActualizar')"/>
          		</div>
          		<div class="mb-3">
          			<label class="form-label" for="textContrasenaUsuario">Contraseña:</label>
          			<input id="textContrasenaUsuario" class="form-control" type="password" name="contrasena"/>
          		</div>
            	<div class="mb-3">
          			<label class="form-label obligatoria" for="selectTipoUsuario">Tipo de usuarix*:</label>
            		<select id="selectTipoUsuario" class="form-select" aria-label="Default select example" onchange="activarBoton('#botonActualizar')">
                      <option selected>Seleccionar</option>
                      <option value="1">Vendedorx</option>
                      <option value="2">Administradorx</option>
                    </select>
        		</div>
        		<div class="mb-3">
          			<label class="form-label obligatoria" for="selectEditarEstatus">Estatus*:</label>
            		<select id="selectEditarEstatus" class="form-select" onchange="activarBoton('#botonActualizar')">
                      <option selected="selected" value="">Seleccionar</option>
                      <option value="1">Activx</option>
                      <option value="0">Inactivx</option>
                    </select>
        		</div>
          	</div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-primary" id="botonActualizar" onclick="actualizar()">Actualizar</button>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal Eliminar -->
    <div class="modal fade" id="modalEliminar" tabindex="-1" role="dialog" aria-labelledby="modalEliminarLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalEliminarLabel">Eliminar usuarix</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
            <div class="modal-body">
            	<input type="hidden" id="idUsuarioEliminar"/>
            	<div id="mensajeEliminar" class="mb-3 mensaje"></div>
                <div class="mb-3">
                	¿Realmente desea eliminar a la (al) usuarix?
          			<input id="textNombreUsuarioEliminar" class="form-control" type="text" name="nombre" readonly="readonly"/>
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
	}).fail( function(jqXHR, textStatus){
		$('.toast-body').html("Request failed: " + textStatus);
		$('.toast').toast('show');
	});
}	

function cargarDatos(id){
	document.getElementById("textNombreUsuario").value = document.getElementById("nombre" + id).innerHTML; 
	document.getElementById("selectEditarEstatus").value = document.getElementById("estatus" + id).value; 
	document.getElementById("selectTipoUsuario").value = document.getElementById("tipo" + id).value;
	document.getElementById("idUsuario").value = id;
}

function activarBoton(boton){
	if(boton === "#botonGuardar") {
    	if(document.getElementById("textAgregarNombreUsuario").value === "" || document.getElementById("textAgregarContrasenaUsuario").value === "" 
    		|| document.getElementById("selectAgregarTipoUsuario").value === "" || document.getElementById("selectAgregarEstatus").value === ""){
    		$(boton).attr('disabled', 'disabled');
    	} else {
    		$(boton).removeAttr('disabled');
    	}
	} else {
		if(document.getElementById("textNombreUsuario").value === "" || document.getElementById("selectTipoUsuario").value === "" 
    		|| document.getElementById("selectEditarEstatus").value === ""){
    		$(boton).attr('disabled', 'disabled');
    	} else {
    		$(boton).removeAttr('disabled');
    	}
	}
}

function validar(accion){
	// 0 = Guardar Else = Editar
	if(accion == 0){
		if(document.getElementById("textAgregarNombreUsuario").value === "" || document.getElementById("textAgregarContrasenaUsuario").value === "" 
    		|| document.getElementById("selectAgregarTipoUsuario").value === "" || document.getElementById("selectAgregarEstatus").value === ""){
			return false;
		}
	} else {
		if(document.getElementById("textNombreUsuario").value === "" || document.getElementById("selectTipoUsuario").value === "" 
    		|| document.getElementById("selectEditarEstatus").value === ""){
			return false;
		}
	}
	return true;
}

function guardar(){
	if(!validar(0)){
		return false;
	}

	var nombreUsuario = document.getElementById("textAgregarNombreUsuario").value;
	var contrasenaUsuario = document.getElementById("textAgregarContrasenaUsuario").value;
	var tipoUsuario = document.getElementById("selectAgregarTipoUsuario").value;
	var estatus = document.getElementById("selectAgregarEstatus").value;
	$.ajax({
		url: 'acciones/nuevo.php',
		method: 'POST',
		data: {"nombre": nombreUsuario, "contrasena": contrasenaUsuario, "tipo": tipoUsuario, "estatus": estatus},
		dataType: 'html'
	}).done(function(resultado){
		if(resultado) {
			$('#notificacionesUsuarixs').html('Usuarix guardadx');
			consultar();
			$('#modalAgregar').modal('hide');
			$('#notificacionesUsuarixs').fadeIn(1000);
			$('#notificacionesUsuarixs').fadeOut(5000);
		} else {
			$('#mensajeAgregar').html('No se pudo guardar la/el usuarix');
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

	var idUsuario = document.getElementById("idUsuario").value;
	var nombreUsuario = document.getElementById("textNombreUsuario").value;
	var contrasenaUsuario = document.getElementById("textContrasenaUsuario").value;
	var tipoUsuario = document.getElementById("selectTipoUsuario").value;
	var estatus = document.getElementById("selectEditarEstatus").value;
	
	$.ajax({
		url: 'acciones/actualizar.php',
		method: 'POST',
		data: {"id": idUsuario, "nombre": nombreUsuario, "contrasena": contrasenaUsuario, "tipo": tipoUsuario, "estatus": estatus},
		dataType: 'html'
	}).done(function(resultado){
		if(resultado) {
			$('#notificacionesUsuarixs').html('Usuarix actualizadx');
			consultar();
			$('#modalActualizar').modal('hide');
			$('#notificacionesUsuarixs').fadeIn(1000);
			$('#notificacionesUsuarixs').fadeOut(5000);
		} else {
			$('#mensajeActualizar').html('No se pudo actualizar la/el usuarix');
    		$('#mensajeActualizar').fadeIn(1000);
    		$('#mensajeActualizar').fadeOut(5000);
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
	document.getElementById("textNombreUsuarioEliminar").value = document.getElementById("nombre" + id).innerHTML;
	document.getElementById("idUsuarioEliminar").value = id;
}

function eliminar(){
	var idUsuario = document.getElementById("idUsuarioEliminar").value;
	$.ajax({
		url: 'acciones/eliminar.php',
		method: 'POST',
		data: {id: idUsuario},
		dataType: 'html'
	}).done(function(resultado){		
		if(resultado == 1) {
			$('#notificacionesUsuarixs').html('Usuarix eliminadx');
			consultar();
			$("#modalEliminar").modal("hide");
			$('#notificacionesUsuarixs').fadeIn(1000);
			$('#notificacionesUsuarixs').fadeOut(5000);
		} else if(resultado == 2) {
			$('#notificacionesUsuarixs').html('La/El usuarix se desactivó. No se puede eliminar porque ya está asociado al menos a una comanda o un corte de caja');
			consultar();
			$("#modalEliminar").modal("hide");
			$('#notificacionesUsuarixs').fadeIn(1000);
			$('#notificacionesUsuarixs').fadeOut(5000);
		} else {
			$('#mensajeEliminar').html('No se pudo eliminar la/el usuarix. Por favor intenta de nuevo');
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
</script>
<?php require_once '../fin.php';?>
