<?php
session_start();

if(isset($_SESSION['conectadx'])){
    /** 
     * @todo Poner la página de inicio (esta no es) 
     */ 
    header('Location: ../comandas/index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
     <head>
      <meta charset="utf-8" >
      <title>Holy Vegan POS</title>
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="../css/estilos.css"/>
      <link rel="stylesheet" href="../css/bootstrap/bootstrap.min.css"/>
      <link rel="stylesheet" href="../css/bootstrap/bootstrap-icons.css"/>
      <script type="text/javascript" src="../js/jquery/jquery.min.js"></script>
      <script type="text/javascript" src="../js/bootstrap/bootstrap.bundle.min.js"></script>
    </head>
    <body>
    	<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
        	<div class="container-fluid">
            	<a class="navbar-brand" href="#">HV POS</a>
          	</div>
        </nav>
    	<div class="content">
    		<div class="d-flex align-items-center justify-content-md-center">
				<fieldset>
                	<legend>Iniciar sesión</legend>
                	<div class="mb-3">
              			<label class="form-label" for="textNombreUsuario">Nombre de usuario:</label>
              			<input id="textNombreUsuario" class="form-control" type="text" name="nombre"/>
              		</div>
              		<div class="mb-3">
              			<label class="form-label" for="textContrasenaUsuario">Contraseña:</label>
              			<input id="textContrasenaUsuario" class="form-control" type="password" name="contrasena" onkeyup="enviar(event)"/>
              		</div>
              		<button type="button" class="btn btn-dark btn-lg" onclick="conexion()"><i class="bi-door-open"></i>&nbsp;Iniciar</button>
              	</fieldset>
              	<div id="mensaje"></div>
    		</div>
    	</div>
    	<script type="text/javascript">
    	
    		function validar(){
    			if(document.getElementById("textNombreUsuario").value == "" && document.getElementById("textContrasenaUsuario").value == ""){
    				return false;
    			}
    			
    			return true;
    		}
    	
    		function enviar(){
    			var keycode = event.keyCode || event.which;
                if(keycode == '13'){
                  conexion(); 
                }
    		}
    	
        	function conexion(){
        		
        		if(!validar()){
        			return false;
        		}
        	
        		var nombreUsuario = document.getElementById("textNombreUsuario").value;
        		var contrasenaUsuario = document.getElementById("textContrasenaUsuario").value;
        		$.ajax({
        			url: 'acciones/login.php',
        			method: 'POST',
        			data: {nombre: nombreUsuario, contrasena: contrasenaUsuario},
        			dataType: 'html'
        		}).done(function(resultado){
        			$('#mensaje').html(resultado);
        		}).fail( function(jqXHR, textStatus){
        			alert("Request failed: " + textStatus);
        		});
        	}
        </script>
    </body>
</html>
