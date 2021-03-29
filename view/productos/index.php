<?php

session_start();

if(!isset($_SESSION['tipoUsuarix']) || $_SESSION['tipoUsuarix'] != 2){
    header("Location: /restaurant/desconectar.php");
    exit();
}

require_once '../principio.php';
require_once '../menu.php';?>
<div class="content">
	<h3>Productos</h3>
	<div id="acciones">
		<button class="btn btn-secondary" data-bs-toggle='modal' data-bs-target='#modalAgregar' type="button"><i class="bi-plus-circle-fill icono-boton"></i>Agregar</button>
	</div>
	<div id="notificacionesProductos" style="display: none; text-align:center; font-weight:bold;"></div>
	<div class="table-responsive">
		<table class="table table-striped">
        	<thead>
        		<tr class="encabezado-catalogo">
        			<th>Nombre</th>
        			<th>Precio</th>
        			<th>Acciones</th>
        		</tr>
        	</thead>
        	<tbody>
        	</tbody>
        </table>
	</div>
    <!-- Modal agregar -->
    <div class="modal fade" id="modalAgregar" tabindex="-1" role="dialog" aria-labelledby="modalAgregarLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalAgregarLabel">Agregar producto</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
            <div class="modal-body">
            	<div id="mensajeAgregar" class="mb-3 mensaje"></div>
            	<div class="informacion-obligatoria">Información obligatoria*</div>
            	<div id="primera-parte">
                    <div class="mb-3">
              			<label class="form-label obligatoria" for="textAgregarNombre">Nombre*:</label>
              			<input id="textAgregarNombre" class="form-control" type="text" onkeyup="activarBoton('#botonGuardar')" onblur="activarBoton('#botonGuardar')"/>
              		</div>
              		<div class="mb-3">
              			<label class="form-label obligatoria" for="numberAgregarPrecio">Precio*:</label>
              			<input id="numberAgregarPrecio" class="form-control" type="number" min="0" value="0" step="0.1" pattern="^\d+(?:\.\d{1,2})?$" onblur="activarBoton('#botonGuardar')" onchange="activarBoton('#botonGuardar')"/>
              		</div>
                	<div class="mb-3">
              			<label class="form-label obligatoria" for="selectAgregarEstatus">Estatus*:</label>
                		<select id="selectAgregarEstatus" class="form-select" onchange="activarBoton('#botonGuardar')">
                          <option selected="selected" value="">Seleccionar</option>
                          <option value="1">Activo</option>
                          <option value="0">Inactivo</option>
                        </select>
            		</div>
            		<button class="btn btn-secondary" type="button" onclick="siguiente(2)">Siguiente información<i class="bi-arrow-right-circle icono-boton"></i></button>
        		</div>
        		<div id="segunda-parte" style="display: none">
        			<div class="mb-3">
              			<label class="form-label" for="selectInsumosAgregar">Insumos:</label>
                		<select id="selectInsumosAgregar" class="form-select" onchange="agregarInsumo(this)">
                          <option selected="selected" value="">Seleccionar</option>
                        </select>
                        <table id="tablaInsumosAgregar"></table>
            		</div>
            		<div class="mb-3">
              			<label class="form-label" for="selectImpuestosAgregar">Impuestos:</label>
                		<select id="selectImpuestosAgregar" class="form-select" onchange="agregarImpuesto(this)">
                          <option selected="selected" value="">Seleccionar</option>
                        </select>
                        <div id="impuestosAgregar"></div>
            		</div>
            		<div class="mb-3">
              			<label class="form-label" for="selectCategoriasAgregar">Categorías:</label>
                		<select id="selectCategoriasAgregar" class="form-select" onchange="agregarCategoria(this)">
                          <option selected="selected" value="">Seleccionar</option>
                        </select>
                        <div id="categoriasAgregar"></div>
            		</div>
            		<button class="btn btn-secondary" type="button" onclick="siguiente(1)"><i class="bi-arrow-left-circle icono-boton"></i>Información anterior</button>
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
                    <h5 class="modal-title" id="modalActualizarLabel">Editar producto</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    	<span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="idProducto"/>
                    <div id="mensajeActualizar" class="mb-3 mensaje"></div>
                    <div class="informacion-obligatoria">Información obligatoria*</div>
                	<div id="primera-parte-actualizar">
                        <div class="mb-3">
                  			<label class="form-label obligatoria" for="textActualizarNombre">Nombre*:</label>
                  			<input id="textActualizarNombre" class="form-control" type="text" onkeyup="activarBoton('#botonActualizar')" onblur="activarBoton('#botonActualizar')"/>
                  		</div>
                  		<div class="mb-3">
                  			<label class="form-label obligatoria" for="numberActualizarPrecio">Precio*:</label>
                  			<input id="numberActualizarPrecio" class="form-control" type="number" min="0" value="0" step="0.1" pattern="^\d+(?:\.\d{1,2})?$" onblur="activarBoton('#botonActualizar')" onchange="activarBoton('#botonActualizar')"/>
                  		</div>
                    	<div class="mb-3">
                  			<label class="form-label obligatoria" for="selectActualizarEstatus">Estatus*:</label>
                    		<select id="selectActualizarEstatus" class="form-select" onchange="activarBoton('#botonActualizar')">
                              <option selected="selected" value="">Seleccionar</option>
                              <option value="1">Activo</option>
                              <option value="0">Inactivo</option>
                            </select>
                		</div>
                		<button class="btn btn-secondary" type="button" onclick="siguienteActualizar(2)">Siguiente información<i class="bi-arrow-right-circle icono-boton"></i></button>
            		</div>
            		<div id="segunda-parte-actualizar" style="display: none">
            			<div class="mb-3">
                  			<label class="form-label" for="selectInsumosActualizar">Insumos:</label>
                    		<select id="selectInsumosActualizar" class="form-select" onchange="agregarInsumoActualizar(this)">
                              <option selected="selected" value="">Seleccionar</option>
                            </select>
                            <table id="tablaInsumosActualizar"></table>
                		</div>
                		<div class="mb-3">
                  			<label class="form-label" for="selectImpuestosActualizar">Impuestos:</label>
                    		<select id="selectImpuestosActualizar" class="form-select" onchange="agregarImpuestoActualizar(this)">
                              <option selected="selected" value="">Seleccionar</option>
                            </select>
                            <div id="impuestosActualizar"></div>
                		</div>
                		<div class="mb-3">
                  			<label class="form-label" for="selectCategoriasActualizar">Categorías:</label>
                    		<select id="selectCategoriasActualizar" class="form-select" onchange="agregarCategoriaActualizar(this)">
                              <option selected="selected" value="">Seleccionar</option>
                            </select>
                            <div id="categoriasActualizar"></div>
                		</div>
                		<button class="btn btn-secondary" type="button" onclick="siguienteActualizar(1)"><i class="bi-arrow-left-circle icono-boton"></i>Información anterior</button>
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
            <h5 class="modal-title" id="modalEliminarLabel">Eliminar producto</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
            <div class="modal-body">
            	<input type="hidden" id="idProductoEliminar"/>
            	<div id="mensajeEliminar" class="mb-3 mensaje"></div>
                <div class="mb-3">
                	¿Realmente deseas eliminar el producto?
          			<input id="textNombreProductoEliminar" class="form-control" type="text" name="nombre" readonly="readonly"/>
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
		obtenerInsumos();
		obtenerImpuestos();
		obtenerCategorias();
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

function obtenerInsumos(){
	$.ajax({
		url: 'acciones/obtener_insumos.php',
		method: 'GET',
		dataType: 'json'
	}).done(function(resultado){
		var $select = $("#selectInsumosAgregar");
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

function obtenerImpuestos(){
	$.ajax({
		url: 'acciones/obtener_impuestos.php',
		method: 'GET',
		dataType: 'json'
	}).done(function(resultado){
		var $select = $("#selectImpuestosAgregar");
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

function obtenerCategorias(){
	$.ajax({
		url: 'acciones/obtener_categorias.php',
		method: 'GET',
		dataType: 'json'
	}).done(function(resultado){
		var $select = $("#selectCategoriasAgregar");
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

function agregarInsumo(select){
	if(select.value == '') {
		return false;
	}
	$("#tablaInsumosAgregar").append("<tr id='insumo" + select.value + "'><td style='width:250px;overflow-x:hidden'><input type='hidden' name='idsInsumo' value='" + select.value + "'/><span class='badge rounded-pill bg-secondary' style='font-size:large'>" + select.options[select.selectedIndex].text + "</span></td><td style='width:'><button class='btn btn-secondary' type='button' onclick='if(this.nextSibling.value > 1){this.nextSibling.value=parseInt(this.nextSibling.value)-1}'><i class='bi-dash-circle'></i></button><input type='text' class='numero-mini' name='cantidadInsumo' value='1' readonly='readonly'/><button class='btn btn-secondary' type='button' onclick='this.previousSibling.value=parseInt(this.previousSibling.value)+1'><i class='bi-plus-circle'></i></button><button class='btn btn-secondary' type='button' onclick='document.getElementById(\"insumo" + select.value + "\").remove();document.getElementById(\"selectInsumosAgregar\").options[" + select.selectedIndex + "].disabled = false;document.getElementById(\"selectInsumosAgregar\").selectedIndex=0;'><i class='bi-x-circle'></i></button></td></tr>");
	select.options[select.selectedIndex].disabled = true;
}

function agregarImpuesto(select){
	if(select.value == '') {
		return false;
	}
	$("#impuestosAgregar").append("<span id='impuesto" + select.value + "' class='badge rounded-pill bg-secondary' style='font-size:large;margin-top:5px;'><input type='hidden' name='idsImpuesto' value='" + select.value + "'/>" + select.options[select.selectedIndex].text + " <button class='btn btn-secondary' type='button' onclick='document.getElementById(\"impuesto" + select.value + "\").remove();document.getElementById(\"selectImpuestosAgregar\").options[" + select.selectedIndex + "].disabled = false;document.getElementById(\"selectImpuestosAgregar\").selectedIndex=0;'><i class='bi-x-circle'></i></button></span>");
	select.options[select.selectedIndex].disabled = true;
}

function agregarCategoria(select){
	if(select.value == '') {
		return false;
	}
	$("#categoriasAgregar").append("<span id='categoria" + select.value + "' class='badge rounded-pill bg-secondary' style='font-size:large;margin-top:5px;'><input type='hidden' name='idsCategoria' value='" + select.value + "'/>" + select.options[select.selectedIndex].text + " <button class='btn btn-secondary' type='button' onclick='document.getElementById(\"categoria" + select.value + "\").remove();document.getElementById(\"selectCategoriasAgregar\").options[" + select.selectedIndex + "].disabled = false;document.getElementById(\"selectCategoriasAgregar\").selectedIndex=0;'><i class='bi-x-circle'></i></button></span>");
	select.options[select.selectedIndex].disabled = true;
}

function agregarInsumoActualizar(select){
	if(select.value == '') {
		return false;
	}
	$("#tablaInsumosActualizar").append("<tr id='insumoActualizar" + select.value + "'><td style='width:250px;overflow-x:hidden'><input type='hidden' name='idsInsumoActualizar' value='" + select.value + "'/><span class='badge rounded-pill bg-secondary' style='font-size:large'>" + select.options[select.selectedIndex].text + "</span></td><td style='width:'><button class='btn btn-secondary' type='button' onclick='if(this.nextSibling.value > 1){this.nextSibling.value=parseInt(this.nextSibling.value)-1}'><i class='bi-dash-circle'></i></button><input type='text' class='numero-mini' name='cantidadInsumoActualizar' value='1' readonly='readonly'/><button class='btn btn-secondary' type='button' onclick='this.previousSibling.value=parseInt(this.previousSibling.value)+1'><i class='bi-plus-circle'></i></button><button class='btn btn-secondary' type='button' onclick='document.getElementById(\"insumoActualizar" + select.value + "\").remove();document.getElementById(\"selectInsumosActualizar\").options[" + select.selectedIndex + "].disabled = false;document.getElementById(\"selectInsumosActualizar\").selectedIndex=0;'><i class='bi-x-circle'></i></button></td></tr>");
	select.options[select.selectedIndex].disabled = true;
}

function agregarImpuestoActualizar(select){
	if(select.value == '') {
		return false;
	}
	$("#impuestosActualizar").append("<span id='impuestoActualizar" + select.value + "' class='badge rounded-pill bg-secondary' style='font-size:large;margin-top:5px;'><input type='hidden' name='idsImpuestoActualizar' value='" + select.value + "'/>" + select.options[select.selectedIndex].text + " <button class='btn btn-secondary' type='button' onclick='document.getElementById(\"impuestoActualizar" + select.value + "\").remove();document.getElementById(\"selectImpuestosActualizar\").options[" + select.selectedIndex + "].disabled = false;document.getElementById(\"selectImpuestosActualizar\").selectedIndex=0;'><i class='bi-x-circle'></i></button></span>");
	select.options[select.selectedIndex].disabled = true;
}

function agregarCategoriaActualizar(select){
	if(select.value == '') {
		return false;
	}
	$("#categoriasActualizar").append("<span id='categoriaActualizar" + select.value + "' class='badge rounded-pill bg-secondary' style='font-size:large;margin-top:5px;'><input type='hidden' name='idsCategoriaActualizar' value='" + select.value + "'/>" + select.options[select.selectedIndex].text + " <button class='btn btn-secondary' type='button' onclick='document.getElementById(\"categoriaActualizar" + select.value + "\").remove();document.getElementById(\"selectCategoriasActualizar\").options[" + select.selectedIndex + "].disabled = false;document.getElementById(\"selectCategoriasActualizar\").selectedIndex=0;'><i class='bi-x-circle'></i></button></span>");
	select.options[select.selectedIndex].disabled = true;
}

function cargarDatos(id){

	$.ajax({
		url: 'acciones/obtener_producto_por_id.php',
		method: 'GET',
		data: {"id": id},
		dataType: 'json'
	}).done(function(resultado){
		// Mostramos la página 1 del formulario
		siguienteActualizar(1);
	
		// En estas variables se almacenarán las categorías, impuestos e insumos que el producto ya tenga (si es que tiene)
		var categorias = resultado.categorias;
		var impuestos = resultado.impuestos;
		var insumos = resultado.insumos;
		
		// Cargar categorías
		$.ajax({
    		url: 'acciones/obtener_categorias.php',
    		method: 'GET',
    		dataType: 'json'
    	}).done(function(resultado){
    		var $select = $("#selectCategoriasActualizar");
    		$select.empty();
    		$select.append(new Option('Seleccionar',''));
    		for(i = 0; i < resultado.length; i++) {
    			$select.append(new Option(resultado[i][1],resultado[i][0]));
    		}
    		$("#categoriasActualizar").empty();
    		if(categorias.length > 0) {
        		// id - nombre
            	categorias.forEach(function(dato){
            		$("#categoriasActualizar").append("<span id='categoriaActualizar" + dato.id + "' class='badge rounded-pill bg-secondary' style='font-size:large;margin-top:5px;'><input type='hidden' name='idsCategoriaActualizar' value='" + dato.id + "'/>" + dato.nombre + " <button class='btn btn-secondary' type='button' onclick='document.getElementById(\"categoriaActualizar" + dato.id + "\").remove();quitarInactivoCategoria(" + dato.id + ");document.getElementById(\"selectCategoriasActualizar\").selectedIndex=0;'><i class='bi-x-circle'></i></button></span>");
            		$("#selectCategoriasActualizar > option[value='" + dato.id + "']").prop('disabled',true);
            	});
        	}
    	}).fail(function(jqXHR, textStatus) {
    		if(jqXHR.status == 403) {
    			window.location.href = '/restaurant/view/conexion/';
    		} else {
    			console.log("Request failed: " + textStatus);
    		}
    	});
    	
    	// Cargar impuestos
    	$.ajax({
    		url: 'acciones/obtener_impuestos.php',
    		method: 'GET',
    		dataType: 'json'
    	}).done(function(resultado){
    		var $select = $("#selectImpuestosActualizar");
    		$select.empty();
    		$select.append(new Option('Seleccionar',''));
    		for(i = 0; i < resultado.length; i++) {
    			$select.append(new Option(resultado[i][1],resultado[i][0]));
    		}
    		$("#impuestosActualizar").empty();
    		if(impuestos.length > 0) {
        		// id - nombre - porcentaje
            	impuestos.forEach(function(dato){
            		$("#impuestosActualizar").append("<span id='impuestoActualizar" + dato.id + "' class='badge rounded-pill bg-secondary' style='font-size:large;margin-top:5px;'><input type='hidden' name='idsImpuestoActualizar' value='" + dato.id + "'/>" + dato.nombre + " <button class='btn btn-secondary' type='button' onclick='document.getElementById(\"impuestoActualizar" + dato.id + "\").remove();quitarInactivoImpuesto(" + dato.id + ");document.getElementById(\"selectImpuestosActualizar\").selectedIndex=0;'><i class='bi-x-circle'></i></button></span>");
            		$("#selectImpuestosActualizar > option[value='" + dato.id + "']").prop('disabled',true);
            	});
        	}
    	}).fail(function(jqXHR, textStatus) {
    		if(jqXHR.status == 403) {
    			window.location.href = '/restaurant/view/conexion/';
    		} else {
    			console.log("Request failed: " + textStatus);
    		}
    	});
    	
    	// Cargar insumos
    	$.ajax({
    		url: 'acciones/obtener_insumos.php',
    		method: 'GET',
    		dataType: 'json'
    	}).done(function(resultado){
    		var $select = $("#selectInsumosActualizar");
    		$select.empty();
    		$select.append(new Option('Seleccionar',''));
    		for(i = 0; i < resultado.length; i++) {
    			$select.append(new Option(resultado[i][1],resultado[i][0]));
    		}
    		$("#tablaInsumosActualizar").empty();
    		if(insumos.length > 0) {
        		// id - nombre
            	insumos.forEach(function(dato){
            		$("#tablaInsumosActualizar").append("<tr id='insumoActualizar" + dato.id + "'><td style='width:250px;overflow-x:hidden'><input type='hidden' name='idsInsumoActualizar' value='" + dato.id + "'/><span class='badge rounded-pill bg-secondary' style='font-size:large'>" + dato.nombre + "</span></td><td style='width:'><button class='btn btn-secondary' type='button' onclick='if(this.nextSibling.value > 1){this.nextSibling.value=parseInt(this.nextSibling.value)-1}'><i class='bi-dash-circle'></i></button><input type='text' class='numero-mini' name='cantidadInsumoActualizar' value='1' readonly='readonly'/><button class='btn btn-secondary' type='button' onclick='this.previousSibling.value=parseInt(this.previousSibling.value)+1'><i class='bi-plus-circle'></i></button><button class='btn btn-secondary' type='button' onclick='document.getElementById(\"insumoActualizar" + dato.id + "\").remove();quitarInactivoInsumo(" + dato.id + ");document.getElementById(\"selectInsumosActualizar\").selectedIndex=0;'><i class='bi-x-circle'></i></button></td></tr>");
            		$("#selectInsumosActualizar > option[value='" + dato.id + "']").prop('disabled',true);
            	});
        	}
    	}).fail(function(jqXHR, textStatus) {
    		if(jqXHR.status == 403) {
    			window.location.href = '/restaurant/view/conexion/';
    		} else {
    			console.log("Request failed: " + textStatus);
    		}
    	});
    	
		document.getElementById('idProducto').value = resultado.id;
		document.getElementById('textActualizarNombre').value = resultado.nombre;
		document.getElementById('numberActualizarPrecio').value = resultado.precio;
		document.getElementById("selectActualizarEstatus").value = resultado.estatus;
	}).fail(function(jqXHR, textStatus) {
		if(jqXHR.status == 403) {
			window.location.href = '/restaurant/view/conexion/';
		} else {
			console.log("Request failed: " + textStatus);
		}
	});
}

function activarBoton(boton){
	if(boton === "#botonGuardar") {
    	if(document.getElementById("textAgregarNombre").value === "" || document.getElementById("selectAgregarEstatus").value === "" || document.getElementById("numberAgregarPrecio").value === "" || document.getElementById("numberAgregarPrecio").value == "0"){
    		$(boton).attr('disabled', 'disabled');
    	} else {
    		$(boton).removeAttr('disabled');
    	}
	} else {
		if(document.getElementById("textActualizarNombre").value === "" || document.getElementById("selectActualizarEstatus").value === "" || document.getElementById("numberActualizarPrecio").value === "" || document.getElementById("numberActualizarPrecio").value == "0"){
    		$(boton).attr('disabled', 'disabled');
    	} else {
    		$(boton).removeAttr('disabled');
    	}
	}
}

function validar(accion){
	// 0 = Guardar Else = Editar
	if(accion == 0){
		if(document.getElementById("textAgregarNombre").value == "" || document.getElementById("selectAgregarEstatus").value == "" || document.getElementById("numberAgregarPrecio").value === "" || document.getElementById("numberAgregarPrecio").value == "0"){
			return false;
		}
	} else {
		if(document.getElementById("textActualizarNombre").value == "" || document.getElementById("selectActualizarEstatus").value == "" || document.getElementById("numberActualizarPrecio").value === "" || document.getElementById("numberActualizarPrecio").value == "0"){
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
	var precio = document.getElementById("numberAgregarPrecio").value;
	var estatus = document.getElementById("selectAgregarEstatus").value;
	
	var idsInsumos = document.getElementsByName("idsInsumo");
	var cantidadesInsumos = document.getElementsByName("cantidadInsumo");
	
	var datosInsumos = [];
	for(i = 0; i < idsInsumos.length; i++){
		item = {};
		item["idInsumo"] = idsInsumos[i].value;
		item["cantidad"] = cantidadesInsumos[i].value;
		
		datosInsumos.push(item);
	}
	
	var idsImpuestos = document.getElementsByName("idsImpuesto");
	
	var datosImpuestos = [];
	for(i = 0; i < idsImpuestos.length; i++){
		item = {};
		item["idImpuesto"] = idsImpuestos[i].value;
		
		datosImpuestos.push(item);
	}
	
	var idsCategorias = document.getElementsByName("idsCategoria");
	
	var datosCategorias = [];
	for(i = 0; i < idsCategorias.length; i++){
		item = {};
		item["idCategoria"] = idsCategorias[i].value;
		
		datosCategorias.push(item);
	}
	
	var datosProducto = {"nombre": nombre,"precio": precio,"estatus": estatus,
		"datosInsumos": datosInsumos, "datosImpuestos": datosImpuestos, "datosCategorias": datosCategorias}; 

	$.ajax({
		url: 'acciones/nuevo.php',
		method: 'POST',
		data: datosProducto,
		dataType: 'json'
	}).done(function(resultado){
		if(resultado.mensaje) {
			$('#notificacionesProductos').html('Producto guardado');
			consultar();
			$('#modalAgregar').modal('hide');
			$('#notificacionesProductos').fadeIn(1000);
			$('#notificacionesProductos').fadeOut(5000);
		} else {
			$('#mensajeAgregar').html('No se pudo guardar el producto. Por favor intenta de nuevo');
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

	var id = document.getElementById("idProducto").value;
	var nombre = document.getElementById("textActualizarNombre").value;
	var precio = document.getElementById("numberActualizarPrecio").value;
	var estatus = document.getElementById("selectActualizarEstatus").value;
	
	var idsInsumos = document.getElementsByName("idsInsumoActualizar");
	var cantidadesInsumos = document.getElementsByName("cantidadInsumoActualizar");
	
	var datosInsumos = [];
	for(i = 0; i < idsInsumos.length; i++){
		item = {};
		item["idInsumo"] = idsInsumos[i].value;
		item["cantidad"] = cantidadesInsumos[i].value;
		
		datosInsumos.push(item);
	}
	
	var idsImpuestos = document.getElementsByName("idsImpuestoActualizar");
	
	var datosImpuestos = [];
	for(i = 0; i < idsImpuestos.length; i++){
		item = {};
		item["idImpuesto"] = idsImpuestos[i].value;
		
		datosImpuestos.push(item);
	}
	
	var idsCategorias = document.getElementsByName("idsCategoriaActualizar");
	
	var datosCategorias = [];
	for(i = 0; i < idsCategorias.length; i++){
		item = {};
		item["idCategoria"] = idsCategorias[i].value;
		
		datosCategorias.push(item);
	}
	
	var datosProducto = {"id": id, "nombre": nombre,"precio": precio,"estatus": estatus,
		"datosInsumos": datosInsumos, "datosImpuestos": datosImpuestos, "datosCategorias": datosCategorias}; 

	$.ajax({
		url: 'acciones/actualizar.php',
		method: 'POST',
		data: datosProducto,
		dataType: 'json'
	}).done(function(resultado){
		if(resultado.mensaje) {
			$('#notificacionesProductos').html('Producto actualizado');
			consultar();
			$('#modalActualizar').modal('hide');
			$('#notificacionesProductos').fadeIn(1000);
			$('#notificacionesProductos').fadeOut(5000);
		} else {
			$('#mensajeActualizar').html('No se pudo actualizar el producto. Por favor intenta de nuevo');
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
	document.getElementById("textNombreProductoEliminar").value = document.getElementById("nombre" + id).innerHTML;
	document.getElementById("idProductoEliminar").value = id;
}

function eliminar(){
	var id = document.getElementById("idProductoEliminar").value;
	$.ajax({
		url: 'acciones/eliminar.php',
		method: 'POST',
		data: {"id": id},
		dataType: 'html'
	}).done(function(resultado){
		if(resultado == 1) {
			$('#notificacionesProductos').html('Producto eliminado');
			consultar();
			$("#modalEliminar").modal("hide");
			$('#notificacionesProductos').fadeIn(1000);
			$('#notificacionesProductos').fadeOut(5000);
		} else if(resultado == 2) {
			$('#notificacionesProductos').html('El producto se desactivó. No se puede eliminar porque ya está en al menos una comanda');
			consultar();
			$("#modalEliminar").modal("hide");
			$('#notificacionesProductos').fadeIn(1000);
			$('#notificacionesProductos').fadeOut(5000);
		} else {
			$('#mensajeEliminar').html('No se pudo eliminar el producto. Por favor intenta de nuevo');
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

function siguiente(pagina){
	switch(pagina){
		case 1:
			document.getElementById('primera-parte').style.display = 'block';
			document.getElementById('segunda-parte').style.display = 'none';
			break;
		case 2:
			document.getElementById('primera-parte').style.display = 'none';
			document.getElementById('segunda-parte').style.display = 'block';
			break;
	}
}

function siguienteActualizar(pagina){
	switch(pagina){
		case 1:
			document.getElementById('primera-parte-actualizar').style.display = 'block';
			document.getElementById('segunda-parte-actualizar').style.display = 'none';
			break;
		case 2:
			document.getElementById('primera-parte-actualizar').style.display = 'none';
			document.getElementById('segunda-parte-actualizar').style.display = 'block';
			break;
	}
}

function quitarInactivoInsumo(id){
	$("#selectInsumosActualizar > option[value='" + id + "']").prop('disabled',false);
}

function quitarInactivoImpuesto(id){
	$("#selectImpuestosActualizar > option[value='" + id + "']").prop('disabled',false);
}

function quitarInactivoCategoria(id){
	$("#selectCategoriasActualizar > option[value='" + id + "']").prop('disabled',false);
}
</script>
<?php require_once '../fin.php';?>
