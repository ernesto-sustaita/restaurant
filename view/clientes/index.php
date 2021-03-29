<?php

session_start();

if(!isset($_SESSION['tipoUsuarix']) || $_SESSION['tipoUsuarix'] != 2){
    header("Location: /restaurant/desconectar.php");
    exit();
}

require_once '../principio.php';
require_once '../menu.php';?>
<div class="content">
	<h3>Clientes</h3>
	<div id="acciones">
		<input type="search" placeholder="Ingresar criterio de búsqueda" onkeyup="buscar(this.value)"/><button class="btn btn-secondary" data-bs-toggle='modal' data-bs-target='#modalAgregar'><i class="bi-plus-circle-fill icono-boton"></i>Agregar</button>
	</div>
	<input type="hidden" id="paginaActual" value="1"/>
	<div id="notificacionesClientes" style="text-align: center;font-weight:bold;display:none"></div>
	<div id="tabla-resultados" class="table-responsive"></div>
    <!-- Modal agregar -->
    <div class="modal fade" id="modalAgregar" tabindex="-1" role="dialog" aria-labelledby="modalAgregarLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalAgregarLabel">Agregar cliente</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
            <div class="modal-body">
            	<div id="mensajeAgregar" class="mb-3 mensaje"></div>
            	<div class="informacion-obligatoria">Información obligatoria*</div>
            	<div id="primera-parte">
                    <div class="mb-3">
              			<label class="form-label obligatoria" for="textAgregarNombre">Nombre(s)*:</label>
              			<input id="textAgregarNombre" class="form-control" type="text" onblur="activarBoton('#botonGuardar')"/>
              		</div>
              		<div class="mb-3">
              			<label class="form-label obligatoria" for="textAgregarApellidos">Apellido(s)*:</label>
              			<input id="textAgregarApellidos" class="form-control" type="text" onblur="activarBoton('#botonGuardar')"/>
              		</div>
              		<div class="mb-3">
              			<label class="form-label obligatoria" for="selectAgregarEstatus">Estatus*:</label>
                		<select id="selectAgregarEstatus" class="form-select" onchange="activarBoton('#botonGuardar')">
                          <option selected="selected" value="">Seleccionar</option>
                          <option value="1">Activx</option>
                          <option value="0">Inactivx</option>
                        </select>
            		</div>
              		<div class="mb-3">
              			<label class="form-label">Dato(s) de contacto:</label><br/>
              			<button class="btn btn-secondary" type="button" onclick="agregarTelefono(0)"><i class="bi-plus-circle-fill icono-boton"></i>Agregar otro</button>
              		</div>
              		<div id="telefono" class="mb-3">
              			<div>
              				<select class="form-select" name="selectAgregarTipoDato[]" onchange="cambiarInput(this.nextSibling,this.value)">
              					<option value="1">Teléfono celular</option>
              					<option value="2">Teléfono casa</option>
              					<option value="3">Teléfono negocio</option>
              					<option value="4">Correo electrónico</option>
              					<option value="5">Red social</option>
              				</select><input name="textAgregarDato[]" class="form-control" type="tel"/>
              			</div>
              		</div>
              		<button class="btn btn-secondary" type="button" onclick="siguiente(2)">Siguiente información<i class="bi-arrow-right-circle icono-boton"></i></button>
            	</div>
          		<div id="segunda-parte" style="display: none">
          			<div class="mb-3">
              			<label class="form-label" for="textAgregarCalle">Calle:</label>
              			<input id="textAgregarCalle" class="form-control" type="text"/>
              		</div>
              		<div class="mb-3">
              			<label class="form-label" for="textAgregarNumeroExterior">Número exterior:</label>
              			<input id="textAgregarNumeroExterior" class="form-control" type="text"/>
              		</div>
          			<div class="mb-3">
              			<label class="form-label" for="textAgregarNumeroInterior">Número interior:</label>
              			<input id="textAgregarNumeroInterior" class="form-control" type="text"/>
              		</div>
              		<div class="mb-3">
              			<label class="form-label" for="textAgregarColonia">Colonia:</label>
              			<input id="textAgregarColonia" class="form-control" type="text"/>
              		</div>
              		<div class="mb-3">
              			<label class="form-label" for="textAgregarCiudad">Ciudad:</label>
              			<input id="textAgregarCiudad" class="form-control" type="text"/>
              		</div>
              		<button class="btn btn-secondary" type="button" onclick="siguiente(1)"><i class="bi-arrow-left-circle icono-boton"></i>Información anterior</button>
              		<button class="btn btn-secondary" type="button" onclick="siguiente(3)">Siguiente información<i class="bi-arrow-right-circle icono-boton"></i></button>
          		</div>
          		<div id="tercera-parte" style="display:none">
          			<div class="mb-3">
              			<label class="form-label" for="selectAgregarEstado">Estado:</label>
              			<select class="form-select" id="selectAgregarEstado">
              				<option value="">Seleccionar</option>
              				<option value="1">Aguascalientes</option>
              				<option value="2">Baja California</option>
              				<option value="3">Baja California Sur</option>
              				<option value="4">Campeche</option>
              				<option value="5">Ciudad de México</option>
              				<option value="6">Coahuila</option>
              				<option value="7">Colima</option>
              				<option value="8">Chiapas</option>
              				<option value="9">Chihuahua</option>
              				<option value="10">Durango</option>
              				<option value="11">Guanajuato</option>
              				<option value="12">Guerrero</option>
              				<option value="13">Hidalgo</option>
              				<option value="14">Jalisco</option>
              				<option value="15">México</option>
              				<option value="16">Michoacán</option>
              				<option value="17">Morelos</option>
              				<option value="18">Nayarit</option>
              				<option value="19">Nuevo León</option>
              				<option value="20">Oaxaca</option>
              				<option value="21">Puebla</option>
              				<option value="22">Querétaro</option>
              				<option value="23">Quintana Roo</option>
              				<option value="24">San Luis Potosí</option>
              				<option value="25">Sinaloa</option>
              				<option value="26">Sonora</option>
              				<option value="27">Tabasco</option>
              				<option value="28">Tamaulipas</option>
              				<option value="29">Tlaxcala</option>
              				<option value="30">Veracruz</option>
              				<option value="31">Yucatán</option>
              				<option value="32">Zacatecas</option>
              			</select>
              		</div>
          			<div class="mb-3">
              			<label class="form-label" for="textAgregarCodigoPostal">Código postal:</label>
              			<input id="textAgregarCodigoPostal" class="form-control" type="text"/>
              		</div>
              		<div class="mb-3">
              			<label class="form-label" for="textAgregarURLMapa">URL mapa:</label>
              			<input id="textAgregarURLMapa" class="form-control" type="url"/>
              		</div>
              		<div class="mb-3">
              			<label class="form-label" for="textAgregarRFC">RFC:</label>
              			<input id="textAgregarRFC" class="form-control" type="text" maxlength="13"/>
              		</div>
              		<button class="btn btn-secondary" type="button" onclick="siguiente(2)"><i class="bi-arrow-left-circle icono-boton"></i>Información anterior</button>
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
                    <h5 class="modal-title" id="modalActualizarLabel">Editar cliente</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    	<span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="idCliente"/>
                    <div id="mensaje" class="mb-3 mensaje"></div>
                    <div id="primera-parte-editar">
                		<div class="informacion-obligatoria">Información obligatoria*</div>
                        <div class="mb-3">
                  			<label class="form-label obligatoria" for="textEditarNombre">Nombre(s)*:</label>
                  			<input id="textEditarNombre" class="form-control" type="text" onblur="activarBoton('#botonActualizar')"/>
                  		</div>
                  		<div class="mb-3">
                  			<label class="form-label obligatoria" for="textEditarApellidos">Apellido(s)*:</label>
                  			<input id="textEditarApellidos" class="form-control" type="text" onblur="activarBoton('#botonActualizar')"/>
                  		</div>
                  		<div class="mb-3">
                  			<label class="form-label obligatoria" for="selectEditarEstatus">Estatus*:</label>
                    		<select id="selectEditarEstatus" class="form-select" onchange="activarBoton('#botonActualizar')">
                              <option selected="selected" value="">Seleccionar</option>
                              <option value="1">Activx</option>
                              <option value="0">Inactivx</option>
                            </select>
                		</div>
                  		<div class="mb-3">
                  			<label class="form-label">Dato(s) de contacto:</label><br/>
                  			<button class="btn btn-secondary" type="button" onclick="agregarTelefono(1)"><i class="bi-plus-circle-fill icono-boton"></i>Agregar</button>
                  		</div>
                  		<div id="telefonoEditar" class="mb-3">
                  			
                  		</div>
              			<button class="btn btn-secondary" type="button" onclick="siguienteEditar(2)">Siguiente información<i class="bi-arrow-right-circle icono-boton"></i></button>
            		</div>
              		<div id="segunda-parte-editar" style="display: none">
              			<div class="mb-3">
                  			<label class="form-label" for="textEditarCalle">Calle:</label>
                  			<input id="textEditarCalle" class="form-control" type="text"/>
                  		</div>
                  		<div class="mb-3">
                  			<label class="form-label" for="textEditarNumeroExterior">Número exterior:</label>
                  			<input id="textEditarNumeroExterior" class="form-control" type="text"/>
                  		</div>
              			<div class="mb-3">
                  			<label class="form-label" for="textEditarNumeroInterior">Número interior:</label>
                  			<input id="textEditarNumeroInterior" class="form-control" type="text"/>
                  		</div>
                  		<div class="mb-3">
                  			<label class="form-label" for="textEditarColonia">Colonia:</label>
                  			<input id="textEditarColonia" class="form-control" type="text"/>
                  		</div>
                  		<div class="mb-3">
                  			<label class="form-label" for="textEditarCiudad">Ciudad:</label>
                  			<input id="textEditarCiudad" class="form-control" type="text"/>
                  		</div>
                  		<button class="btn btn-secondary" type="button" onclick="siguienteEditar(1)"><i class="bi-arrow-left-circle icono-boton"></i>Información anterior</button>
                  		<button class="btn btn-secondary" type="button" onclick="siguienteEditar(3)">Siguiente información<i class="bi-arrow-right-circle icono-boton"></i></button>
              		</div>
              		<div id="tercera-parte-editar" style="display:none">
              			<div class="mb-3">
                  			<label class="form-label" for="selectEditarEstado">Estado:</label>
                  			<select class="form-select" id="selectEditarEstado">
                  				<option value="">Seleccionar</option>
                  				<option value="1">Aguascalientes</option>
                  				<option value="2">Baja California</option>
                  				<option value="3">Baja California Sur</option>
                  				<option value="4">Campeche</option>
                  				<option value="5">Ciudad de México</option>
                  				<option value="6">Coahuila</option>
                  				<option value="7">Colima</option>
                  				<option value="8">Chiapas</option>
                  				<option value="9">Chihuahua</option>
                  				<option value="10">Durango</option>
                  				<option value="11">Guanajuato</option>
                  				<option value="12">Guerrero</option>
                  				<option value="13">Hidalgo</option>
                  				<option value="14">Jalisco</option>
                  				<option value="15">México</option>
                  				<option value="16">Michoacán</option>
                  				<option value="17">Morelos</option>
                  				<option value="18">Nayarit</option>
                  				<option value="19">Nuevo León</option>
                  				<option value="20">Oaxaca</option>
                  				<option value="21">Puebla</option>
                  				<option value="22">Querétaro</option>
                  				<option value="23">Quintana Roo</option>
                  				<option value="24">San Luis Potosí</option>
                  				<option value="25">Sinaloa</option>
                  				<option value="26">Sonora</option>
                  				<option value="27">Tabasco</option>
                  				<option value="28">Tamaulipas</option>
                  				<option value="29">Tlaxcala</option>
                  				<option value="30">Veracruz</option>
                  				<option value="31">Yucatán</option>
                  				<option value="32">Zacatecas</option>
                  			</select>
                  		</div>
              			<div class="mb-3">
                  			<label class="form-label" for="textEditarCodigoPostal">Código postal:</label>
                  			<input id="textEditarCodigoPostal" class="form-control" type="text"/>
                  		</div>
                  		<div class="mb-3">
                  			<label class="form-label" for="textEditarURLMapa">URL mapa:</label>
                  			<input id="textEditarURLMapa" class="form-control" type="url"/>
                  		</div>
                  		<div class="mb-3">
                  			<label class="form-label" for="textEditarRFC">RFC:</label>
                  			<input id="textEditarRFC" class="form-control" type="text" maxlength="13"/>
                  		</div>
                  		<button class="btn btn-secondary" type="button" onclick="siguienteEditar(2)"><i class="bi-arrow-left-circle icono-boton"></i>Información anterior</button>
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
            <h5 class="modal-title" id="modalEliminarLabel">Eliminar cliente</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
            <div class="modal-body">
            	<input type="hidden" id="idClienteEliminar"/>
            	<div id="mensajeEliminar" class="mb-3 mensaje"></div>
                <div class="mb-3">
                	¿Realmente desea eliminar la/el cliente?
          			<input id="textNombreClienteEliminar" class="form-control" type="text" readonly="readonly"/>
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
		consultarPaginado(1,10);
		$('input[name="textAgregarDato[]"]').mask("999-999-9999");
		$('input[name="textEditarDato[]"]').mask("999-999-9999");
		$('#textAgregarCodigoPostal').mask("99999");
		$('#textEditarCodigoPostal').mask("99999");
	});

function consultar(){
	$.ajax({
		url: 'acciones/consultar.php',
		method: 'GET'
	}).done(function(resultado){
		document.getElementById('tabla-resultados').innerHTML = resultado;
	}).fail(function(jqXHR, textStatus) {
		if(jqXHR.status == 403) {
			window.location.href = '/restaurant/view/conexion/';
		} else {
			console.log("Request failed: " + textStatus);
		}
	});
}

function consultarPaginado(pagina,tamanoPagina){
	document.getElementById('paginaActual').value = pagina;
	$.ajax({
		url: 'acciones/consultar_paginado.php',
		method: 'GET',
		data: {pagina: pagina, tamanoPagina: tamanoPagina},
		dataType: 'html'
	}).done(function(resultado){
		document.getElementById('tabla-resultados').innerHTML = resultado;
	}).fail(function(jqXHR, textStatus) {
		if(jqXHR.status == 403) {
			window.location.href = '/restaurant/view/conexion/';
		} else {
			console.log("Request failed: " + textStatus);
		}
	});
}	

function cargarDatos(id){

	$.ajax({
		url: 'acciones/consultar_por_id.php',
		method: 'POST',
		data: {id: id},
		dataType: 'JSON'
	}).done(function(resultado){
		//console.log(resultado);
		document.getElementById("idCliente").value = resultado.id;
    	document.getElementById("textEditarNombre").value = resultado.nombre;
    	document.getElementById("textEditarApellidos").value = resultado.apellidos;
    	document.getElementById("textEditarCalle").value = resultado.calle;
    	document.getElementById("textEditarNumeroExterior").value = resultado.numero_exterior;
    	document.getElementById("textEditarNumeroInterior").value = resultado.numero_interior;
    	document.getElementById("textEditarColonia").value = resultado.colonia;
    	document.getElementById("textEditarCiudad").value = resultado.ciudad;
    	document.getElementById("selectEditarEstado").value = resultado.estado;
    	document.getElementById("textEditarCodigoPostal").value = resultado.codigo_postal;
    	document.getElementById("textEditarURLMapa").value = resultado.url_mapa;
    	document.getElementById("textEditarRFC").value = resultado.rfc;
    	document.getElementById("selectEditarEstatus").value = (resultado.estatus == null) ? "" : resultado.estatus;
    	
    	$('#telefonoEditar').html('');
    	
    	resultado.datosContacto.forEach(function(dato){
    		agregarDatoContactoEditar(dato[1],dato[2]);
    	});
    	
    	activarBoton("#botonActualizar");
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
    	if(document.getElementById("textAgregarNombre").value === "" || document.getElementById("textAgregarApellidos").value === "" || document.getElementById("selectAgregarEstatus").value === ""){
    		$(boton).attr('disabled', 'disabled');
    	} else {
    		$(boton).removeAttr('disabled');
    	}
	} else {
		if(document.getElementById("textEditarNombre").value === "" || document.getElementById("textEditarApellidos").value === "" || document.getElementById("selectEditarEstatus").value === ""){
    		$(boton).attr('disabled', 'disabled');
    	} else {
    		$(boton).removeAttr('disabled');
    	}
	}
}

function validar(accion){
	// 0 = Guardar Else = Editar
	if(accion == 0){
		if(document.getElementById("textAgregarNombre").value == "" || document.getElementById("textAgregarApellidos").value == "" || document.getElementById("selectAgregarEstatus").value === ""){
			return false;
		}
	} else {
		if(document.getElementById("textEditarNombre").value == "" || document.getElementById("textEditarApellidos").value == "" || document.getElementById("selectEditarEstatus").value === ""){
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
	var apellidos = document.getElementById("textAgregarApellidos").value;
	var calle = document.getElementById("textAgregarCalle").value;
	var numeroExterior = document.getElementById("textAgregarNumeroExterior").value;
	var numeroInterior = document.getElementById("textAgregarNumeroInterior").value;
	var colonia = document.getElementById("textAgregarColonia").value;
	var ciudad = document.getElementById("textAgregarCiudad").value;
	var estado = document.getElementById("selectAgregarEstado").value;
	var codigoPostal = document.getElementById("textAgregarCodigoPostal").value;
	var urlMapa = document.getElementById("textAgregarURLMapa").value;
	var rfc = document.getElementById("textAgregarRFC").value;
	var estatus = document.getElementById("selectAgregarEstatus").value;
	
	var datosContacto = document.getElementsByName("textAgregarDato[]");
	var tipoDatosContacto = document.getElementsByName("selectAgregarTipoDato[]");
	
	var datos = [];
	for(i = 0; i < datosContacto.length; i++){
		if(datosContacto[i].value != "") {
    		item = {};
    		item["tipoDato"] = tipoDatosContacto[i].value;
    		if(tipoDatosContacto[i].value == '1' || tipoDatosContacto[i].value == '2' || tipoDatosContacto[i].value == '3'){
    			item["dato"] = datosContacto[i].value.replace('-','');
    		} else {
    			item["dato"] = datosContacto[i].value;
    		}
    		
    		datos.push(item);
		}
	}
	
	var datosCliente = {"nombre": nombre,"apellidos": apellidos,"calle": calle,
		"numeroExterior": numeroExterior,"numeroInterior": numeroInterior,
		"colonia": colonia,"ciudad": ciudad,"estado": estado,"codigoPostal": codigoPostal, 
    	"urlMapa": urlMapa,"rfc": rfc, "estatus": estatus, "datosContacto" :  datos }; 

	$.ajax({
		url: 'acciones/nuevo.php',
		method: 'POST',
		data: datosCliente,
		dataType: 'JSON'
	}).done(function(resultado){
		if(resultado.mensaje) {
			$('#notificacionesClientes').html('Cliente guardadx');
			consultarPaginado(document.getElementById('paginaActual').value, 10);
			$('#modalAgregar').modal('hide');
			$('#notificacionesClientes').fadeIn(1000);
			$('#notificacionesClientes').fadeOut(5000);
		} else {
			$('#mensajeAgregar').html('No se pudo guardar la/el cliente. Por favor intenta de nuevo');
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

	var id = document.getElementById("idCliente").value;
	var nombre = document.getElementById("textEditarNombre").value;
	var apellidos = document.getElementById("textEditarApellidos").value;
	var calle = document.getElementById("textEditarCalle").value;
	var numeroExterior = document.getElementById("textEditarNumeroExterior").value;
	var numeroInterior = document.getElementById("textEditarNumeroInterior").value;
	var colonia = document.getElementById("textEditarColonia").value;
	var ciudad = document.getElementById("textEditarCiudad").value;
	var estado = document.getElementById("selectEditarEstado").value;
	var codigoPostal = document.getElementById("textEditarCodigoPostal").value;
	var urlMapa = document.getElementById("textEditarURLMapa").value;
	var rfc = document.getElementById("textEditarRFC").value;
	var estatus = document.getElementById("selectEditarEstatus").value;
	
	var datosContacto = document.getElementsByName("textEditarDato[]");
	var tipoDatosContacto = document.getElementsByName("selectEditarTipoDato[]");
	
	var datos = [];
	for(i = 0; i < datosContacto.length; i++){
		// No se incluye si el dato de contacto viene vacío
		if(datosContacto[i].value != '') {
    		item = {}
    		item["tipoDato"] = tipoDatosContacto[i].value;
    		if(tipoDatosContacto[i].value == '1' || tipoDatosContacto[i].value == '2' || tipoDatosContacto[i].value == '3'){
    			item["dato"] = datosContacto[i].value.replace('-','');
    		} else {
    			item["dato"] = datosContacto[i].value;
    		}
    		datos.push(item);
		}
	}
	
	var datosCliente = {"id": id, "nombre": nombre,"apellidos": apellidos,"calle": calle,
		"numeroExterior": numeroExterior,"numeroInterior": numeroInterior,
		"colonia": colonia,"ciudad": ciudad,"estado": estado,"codigoPostal": codigoPostal, 
    	"urlMapa": urlMapa,"rfc": rfc, "estatus": estatus, "datosContacto" :  datos };
	
	$.ajax({
		url: 'acciones/actualizar.php',
		method: 'POST',
		data: datosCliente,
		dataType: 'JSON'
	}).done(function(resultado){
		if(resultado.mensaje) {
			$('#notificacionesClientes').html('Cliente actualizadx');
			consultarPaginado(document.getElementById('paginaActual').value, 10);
			$('#modalActualizar').modal('hide');
			$('#notificacionesClientes').fadeIn(1000);
			$('#notificacionesClientes').fadeOut(5000);
		} else {
			$('#mensajeActualizar').html('No se pudo actualizar la/el cliente. Por favor intenta de nuevo');
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
	document.getElementById("textNombreClienteEliminar").value = document.getElementById("nombre" + id).innerHTML + ' ' + document.getElementById("apellidos" + id).innerHTML;
	document.getElementById("idClienteEliminar").value = id;
}

function eliminar(){
	var id = document.getElementById("idClienteEliminar").value;
	$.ajax({
		url: 'acciones/eliminar.php',
		method: 'POST',
		data: {id: id},
		dataType: 'html'
	}).done(function(resultado){
		if(resultado == 1) {
			$('#notificacionesClientes').html('Cliente eliminadx');
			consultarPaginado(document.getElementById('paginaActual').value, 10);
			$("#modalEliminar").modal("hide");
			$('#notificacionesClientes').fadeIn(1000);
			$('#notificacionesClientes').fadeOut(5000);
		} else if(resultado == 2) {
			$('#notificacionesClientes').html('La/El cliente se desactivó. No se puede eliminar porque ya está en al menos una comanda');
			consultarPaginado(document.getElementById('paginaActual').value, 10);
			$("#modalEliminar").modal("hide");
			$('#notificacionesClientes').fadeIn(1000);
			$('#notificacionesClientes').fadeOut(5000);
		} else {
			$('#mensajeEliminar').html('No se pudo eliminar la/el cliente. Por favor intenta de nuevo');
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
			document.getElementById('tercera-parte').style.display = 'none';
			break;
		case 2:
			document.getElementById('primera-parte').style.display = 'none';
			document.getElementById('segunda-parte').style.display = 'block';
			document.getElementById('tercera-parte').style.display = 'none';
			break;
		case 3:
			document.getElementById('primera-parte').style.display = 'none';
			document.getElementById('segunda-parte').style.display = 'none';
			document.getElementById('tercera-parte').style.display = 'block';
			break;
	}
}

function siguienteEditar(pagina){
	switch(pagina){
		case 1:
			document.getElementById('primera-parte-editar').style.display = 'block';
			document.getElementById('segunda-parte-editar').style.display = 'none';
			document.getElementById('tercera-parte-editar').style.display = 'none';
			break;
		case 2:
			document.getElementById('primera-parte-editar').style.display = 'none';
			document.getElementById('segunda-parte-editar').style.display = 'block';
			document.getElementById('tercera-parte-editar').style.display = 'none';
			break;
		case 3:
			document.getElementById('primera-parte-editar').style.display = 'none';
			document.getElementById('segunda-parte-editar').style.display = 'none';
			document.getElementById('tercera-parte-editar').style.display = 'block';
			break;
	}
}

function agregarTelefono(modo){
	var $select = $("<select>");
	var $input = $("<input>");
	$select.append(new Option("Teléfono celular","1"));
	$select.append(new Option("Teléfono casa","2"));
	$select.append(new Option("Teléfono negocio","3"));
	$select.append(new Option("Correo electrónico","4"));
	$select.append(new Option("Red social","5"));
	$select.attr('class','form-select');
	$select.attr('onchange','cambiarInput(this.nextSibling,this.value)');
	$input.attr('class','form-control');
	$input.attr('type','tel');
	$input.mask("999-999-9999");
	
	if(modo == 0) {
    	$select.attr('name','selectAgregarTipoDato[]');
    	$input.attr('name','textAgregarDato[]');
		$('#telefono').append($("<div></div>").append($select,$input));
	} else {
    	$select.attr('name','selectEditarTipoDato[]');
    	$input.attr('name','textEditarDato[]');
		$('#telefonoEditar').append($("<div></div>").append($select,$input));
	}
}

function agregarDatoContactoEditar(tipo,valor){
	var $select = $("<select>");
	var $input = $("<input>");
	
	switch(tipo){
		case '1':
			$select.append(new Option("Teléfono celular","1",true,true));
			$select.append(new Option("Teléfono casa","2"));
        	$select.append(new Option("Teléfono negocio","3"));
        	$select.append(new Option("Correo electrónico","4"));
        	$select.append(new Option("Red social","5"));
			$input.attr('type','tel');
			$input.mask("999-999-9999");
			break;
		case '2':
			$select.append(new Option("Teléfono celular","1"));
        	$select.append(new Option("Teléfono casa","2",true,true));
        	$select.append(new Option("Teléfono negocio","3"));
        	$select.append(new Option("Correo electrónico","4"));
        	$select.append(new Option("Red social","5"));
        	$input.attr('type','tel');
			$input.mask("999-999-9999");
			break;
		case '3':
			$select.append(new Option("Teléfono celular","1"));
        	$select.append(new Option("Teléfono casa","2"));
        	$select.append(new Option("Teléfono negocio","3",true,true));
        	$select.append(new Option("Correo electrónico","4"));
        	$select.append(new Option("Red social","5"));
        	$input.attr('type','tel');
			$input.mask("999-999-9999");
			break;
		case '4':
			$select.append(new Option("Teléfono celular","1"));
        	$select.append(new Option("Teléfono casa","2"));
        	$select.append(new Option("Teléfono negocio","3"));
        	$select.append(new Option("Correo electrónico","4",true,true));
        	$select.append(new Option("Red social","5"));
        	$input.attr('type','email');
			break;
		case '5':
			$select.append(new Option("Teléfono celular","1"));
        	$select.append(new Option("Teléfono casa","2"));
        	$select.append(new Option("Teléfono negocio","3"));
        	$select.append(new Option("Correo electrónico","4"));
        	$select.append(new Option("Red social","5",true,true));
        	$input.attr('type','text');
			break;
	}
	$select.attr('class','form-select');
	$select.attr('onchange','cambiarInput(this.nextSibling,this.value)');
	$input.attr('class','form-control');
	$input.val(valor);
	
	$select.attr('name','selectEditarTipoDato[]');
	$input.attr('name','textEditarDato[]');
	$('#telefonoEditar').append($("<div></div>").append($select,$input));
}

function cambiarInput(input,tipo){
	switch(tipo){
		case '1':
		case '2':
		case '3':
			input.setAttribute('type','tel');
			$(input).mask("999-999-9999");	
			break;
		case '4':
			input.setAttribute('type','email');
			input.value = "";
			$(input).unmask();
			break;
		case '5':
			input.setAttribute('type','text');
			input.value = "";
			$(input).unmask();
			break;
	}
}

function buscar(busqueda){

	if(busqueda.length == 0){
		consultarPaginado(1,10);
		return false;
	}

	if(busqueda.length < 3) {
		return false;
	}
	
	$.ajax({
		url: 'acciones/buscar.php',
		method: 'GET',
		data: {busqueda: busqueda},
		dataType: 'html'
	}).done(function(resultado){
		document.getElementById('tabla-resultados').innerHTML = resultado;
	}).fail(function(jqXHR, textStatus) {
		if(jqXHR.status == 403) {
			window.location.href = '/restaurant/view/conexion/';
		} else {
			console.log("Request failed: " + textStatus);
		}
	});
}

function compartirWhatsapp(datosCliente, datosContacto){
	console.log(datosCliente);
	console.log(datosContacto);
}

function enviarWhatsapp(telefono){
	if(telefono != '') {
		if(telefono.length > 10){
			window.open('https://wa.me/' + telefono);
		} else {
			window.open('https://wa.me/521' + telefono);
		}
	}
}
</script>
<?php require_once '../fin.php';?>