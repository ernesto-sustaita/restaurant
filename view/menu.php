<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="../comandas/">HV POS</a>
        <?php if(isset($_SESSION['conectadx'])){?>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        	<span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarsExampleDefault">
            <ul class="navbar-nav me-auto mb-2 mb-md-0">
            	<li class="nav-item dropdown">
            		<a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-bs-toggle="dropdown" aria-expanded="false">Comandas</a>
        			<ul class="dropdown-menu" aria-labelledby="dropdown01">
                        <li><a class="dropdown-item" href="../comandas/">Tomar comanda</a></li>
                        <li><a class="dropdown-item" href="../comandas/pendientes.php">Comandas pendientes</a></li>
        			</ul>
            	</li>
                <!-- <li class="nav-item">
                	<a class="nav-link" href="#">Link</a>
                </li>
                <li class="nav-item">
                	<a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                </li>-->
                <?php if(isset($_SESSION['tipoUsuarix']) && $_SESSION['tipoUsuarix'] == 2) {?>
                <li class="nav-item dropdown">
                	<a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-bs-toggle="dropdown" aria-expanded="false">Administración</a>
                    <ul class="dropdown-menu" aria-labelledby="dropdown01">
                    	<li><a class="dropdown-item" href="../categorias/">Categorías</a></li>
                    	<li><a class="dropdown-item" href="../clientes/">Clientes</a></li>
                    	<li><a class="dropdown-item" href="../comandas/corte.php">Corte de caja</a></li>
                    	<li><a class="dropdown-item" href="../impuestos/">Impuestos</a></li>
                    	<li><a class="dropdown-item" href="../insumos/">Insumos</a></li>
                    	<li><a class="dropdown-item" href="../productos/">Productos</a></li>
                    	<li><a class="dropdown-item" href="../reportes/">Reportes</a></li>
                    	<li><a class="dropdown-item" aria-current="page" href="../usuarios/">Usuarixs</a></li>
                    </ul>
                </li>
                <?php } ?>
            </ul>
            <?php } ?>
            <div class="d-flex">
            	<span id="saludo">Hola<?php echo isset($_SESSION['nombreUsuarix']) ? ", $_SESSION[nombreUsuarix]" : ""; ?> </span>
            	<button type="button" class="btn btn-dark" style="margin-right:5px" onclick="mostrarNotificacionesExistencia()">
                  <i class="bi-cart-x-fill notificacion"></i><span id="cantidadAlertasInventario" class="badge bg-secondary" style="display: none"></span>
                </button>
                <button type="button" class="btn btn-dark" style="margin-right:5px" onclick="mostrarNotificacionesComanda()">
            		<i class="bi-bell-fill notificacion"></i><span id="cantidadAlertasComanda" class="badge bg-secondary" style="display: none"></span>
            	</button>
                <a class="btn btn-secondary" href="/restaurant/desconectar.php" type="button">Salir</a>
            </div>
        </div>
    </div>
</nav>
<input type="hidden" id="notificacionesActivas" value="0"/>
<div id="notificaciones"></div>
<script>
$(document).ready(function() {
	$.ajax({
		url: '../notificaciones_existencias.php',
		method: 'GET',
		dataType: 'html'
	}).done(function (resultado) {
		if(resultado > 0) {
    		document.getElementById('cantidadAlertasInventario').innerHTML = resultado;
    		document.getElementById('cantidadAlertasInventario').style.display = 'inline';
		} else {
			document.getElementById('cantidadAlertasInventario').innerHTML = 0;
    		document.getElementById('cantidadAlertasInventario').style.display = 'none';
		}
	}).fail(function(jqXHR, textStatus) {
		if(jqXHR.status == 403) {
			window.location.href = '/restaurant/view/conexion/';
		} else {
			console.log("Request failed: " + textStatus);
		}
	});
	
	$.ajax({
		url: '../notificaciones_comandas.php',
		method: 'GET',
		dataType: 'html'
	}).done(function (resultado) {
		if(resultado > 0) {
    		document.getElementById('cantidadAlertasComanda').innerHTML = resultado;
    		document.getElementById('cantidadAlertasComanda').style.display = 'inline';
		} else {
			document.getElementById('cantidadAlertasComanda').innerHTML = 0;
    		document.getElementById('cantidadAlertasComanda').style.display = 'none';
		}
	}).fail(function(jqXHR, textStatus) {
		if(jqXHR.status == 403) {
			window.location.href = '/restaurant/view/conexion/';
		} else {
			console.log("Request failed: " + textStatus);
		}
	});
        	
	setInterval(function() {
		$.ajax({
    		url: '../notificaciones_existencias.php',
    		method: 'GET',
    		dataType: 'html'
    	}).done(function (resultado) {
    		if(resultado > 0) {
        		document.getElementById('cantidadAlertasInventario').innerHTML = resultado;
        		document.getElementById('cantidadAlertasInventario').style.display = 'inline';
    		} else {
    			document.getElementById('cantidadAlertasInventario').innerHTML = 0;
        		document.getElementById('cantidadAlertasInventario').style.display = 'none';
    		}
    	}).fail(function(jqXHR, textStatus) {
    		if(jqXHR.status == 403) {
    			window.location.href = '/restaurant/view/conexion/';
    		} else {
    			console.log("Request failed: " + textStatus);
    		}
    	});
	}, (300 * 1000));
	
	setInterval(function() {
		$.ajax({
    		url: '../notificaciones_comandas.php',
    		method: 'GET',
    		dataType: 'html'
    	}).done(function (resultado) {
    		if(resultado > 0) {
        		document.getElementById('cantidadAlertasComanda').innerHTML = resultado;
        		document.getElementById('cantidadAlertasComanda').style.display = 'inline';
    		} else {
    			document.getElementById('cantidadAlertasComanda').innerHTML = 0;
        		document.getElementById('cantidadAlertasComanda').style.display = 'none';
    		}
    	}).fail(function(jqXHR, textStatus) {
    		if(jqXHR.status == 403) {
    			window.location.href = '/restaurant/view/conexion/';
    		} else {
    			console.log("Request failed: " + textStatus);
    		}
    	});
	}, (60 * 1000));
});

function mostrarNotificacionesExistencia(){
	var display = document.getElementById('notificaciones').style.display; 
	var panelActivo = document.getElementById('notificacionesActivas').value; 
	if((display == 'none') || (display == 'block' &&  (panelActivo == "2"))) {
		$.ajax({
    		url: '../consultar_notificaciones_existencias.php',
    		method: 'GET',
    		dataType: 'html'
    	}).done(function (resultado) {
    		if(resultado != 0) {
        		document.getElementById('notificaciones').innerHTML = resultado;
        		document.getElementById('notificaciones').style.display = 'block';
        		document.getElementById('notificacionesActivas').value = 1;
    		} else {
    			document.getElementById('notificaciones').innerHTML = '';
        		document.getElementById('notificaciones').style.display = 'none';
    		}
    	}).fail(function(jqXHR, textStatus) {
    		if(jqXHR.status == 403) {
    			window.location.href = '/restaurant/view/conexion/';
    		} else {
    			console.log("Request failed: " + textStatus);
    		}
    	});
	} else {
		document.getElementById('notificaciones').innerHTML = '';
		document.getElementById('notificaciones').style.display = 'none';
	}
}

function mostrarNotificacionesComanda(){
	var display = document.getElementById('notificaciones').style.display; 
	var panelActivo = document.getElementById('notificacionesActivas').value; 
	if((display == 'none') || (display == 'block' &&  (panelActivo == "1"))) {
    	$.ajax({
    		url: '../consultar_notificaciones_comandas.php',
    		method: 'GET',
    		dataType: 'html'
    	}).done(function (resultado) {
    		if(resultado != 0) {
        		document.getElementById('notificaciones').innerHTML = resultado;
        		document.getElementById('notificaciones').style.display = 'block';
        		document.getElementById('notificacionesActivas').value = 2;
    		} else {
    			document.getElementById('notificaciones').innerHTML = '';
        		document.getElementById('notificaciones').style.display = 'none';
    		}
    	}).fail(function(jqXHR, textStatus) {
    		if(jqXHR.status == 403) {
    			window.location.href = '/restaurant/view/conexion/';
    		} else {
    			console.log("Request failed: " + textStatus);
    		}
    	});
    } else {
    	document.getElementById('notificaciones').innerHTML = '';
		document.getElementById('notificaciones').style.display = 'none';
    }
}

function marcarComoLeida(id){
	$.ajax({
		url: '../marcar_notificacion_leida.php',
		data: {"id": id},
		method: 'POST',
		dataType: 'html'
	}).done(function (resultado) {
		if(resultado) {
    		document.getElementById('botonNotificacion' + id).style.display = 'none';
    		document.getElementById('notificacion' + id).style.backgroundColor = 'rgba(255,255,255,0.5)';
    		
    		// Recontamos las notificaciones
    		$.ajax({
        		url: '../notificaciones_existencias.php',
        		method: 'GET',
        		dataType: 'html'
        	}).done(function (resultado) {
        		if(resultado > 0) {
            		document.getElementById('cantidadAlertasInventario').innerHTML = resultado;
            		document.getElementById('cantidadAlertasInventario').style.display = 'inline';
        		} else {
        			document.getElementById('cantidadAlertasInventario').innerHTML = 0;
            		document.getElementById('cantidadAlertasInventario').style.display = 'none';
        		}
        	}).fail(function(jqXHR, textStatus) {
        		if(jqXHR.status == 403) {
        			window.location.href = '/restaurant/view/conexion/';
        		} else {
        			console.log("Request failed: " + textStatus);
        		}
        	});
    		$.ajax({
        		url: '../notificaciones_comandas.php',
        		method: 'GET',
        		dataType: 'html'
        	}).done(function (resultado) {
        		if(resultado > 0) {
            		document.getElementById('cantidadAlertasComanda').innerHTML = resultado;
            		document.getElementById('cantidadAlertasComanda').style.display = 'inline';
        		} else {
        			document.getElementById('cantidadAlertasComanda').innerHTML = 0;
            		document.getElementById('cantidadAlertasComanda').style.display = 'none';
        		}
        	}).fail(function(jqXHR, textStatus) {
        		if(jqXHR.status == 403) {
        			window.location.href = '/restaurant/view/conexion/';
        		} else {
        			console.log("Request failed: " + textStatus);
        		}
        	});
		} else {
			alert("No se pudo marcar la notificación como leída, favor de intentar nuevamente");
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