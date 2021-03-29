<?php require_once '../principio.php';?>
<?php require_once '../menu.php';?>
<div class="content">
    <fieldset>
    	<legend>Agregar Usuario</legend>
    	<div class="mb-3">
  			<label class="form-label" for="textNombreUsuario">Nombre de usuario:</label>
  			<input id="textNombreUsuario" class="form-control" type="text" name="nombre"/>
  		</div>
  		<div class="mb-3">
  			<label class="form-label" for="textContrasenaUsuario">Contraseña:</label>
  			<input id="textContrasenaUsuario" class="form-control" type="password" name="contrasena"/>
  		</div>
    	<div class="mb-3">
  			<label class="form-label" for="selectTipoUsuario">Tipo de usuario:</label>
    		<select id="selectTipoUsuario" class="form-select" aria-label="Default select example">
              <option selected>Seleccionar</option>
              <option value="1">Vendedorx</option>
              <option value="2">Administradorx</option>
            </select>
		</div>
		<div class="d-grid gap-2 mx-auto">
    		<button type="button" class="btn btn-dark btn-lg" onclick="guardarUsuario()">Guardar</button>
    	</div>
    </fieldset>
    <div class="toast-container position-absolute top-50 start-50 translate-middle">
        <div class="toast">
          <div class="toast-header" role="alert">
            Mensaje
          </div>
          <div class="toast-body">      
          </div>
        </div>
    </div>
</div>
<script type="text/javascript">
	function guardarUsuario(){
		var nombreUsuario = document.getElementById("textNombreUsuario").value;
		var contrasenaUsuario = document.getElementById("textContrasenaUsuario").value;
		var tipoUsuario = document.getElementById("selectTipoUsuario").value;
		$.ajax({
			url: 'acciones/nuevo.php',
			method: 'POST',
			data: {nombre: nombreUsuario, contrasena: contrasenaUsuario, tipo: tipoUsuario},
			dataType: 'html'
		}).done(function(resultado){
			$('.toast-body').html(resultado);
			$('.toast').toast('show');
		}).fail( function(jqXHR, textStatus){
			$('.toast-body').html("Request failed: " + textStatus);
			$('.toast').toast('show');
		});
	}
</script>
<?php require_once '../fin.php';?>
