<?php
require_once '../../../database/DB.php';
require_once '../../../model/Usuario.php';
require_once '../../../controller/UsuariosController.php';

use controller\UsuariosController;

$usuario = UsuariosController::conexion($_POST['nombre'], $_POST['contrasena']);

if($usuario->num_rows > 0){
    session_start();
    $datosUsuario = $usuario->fetch_object();
    
    $_SESSION['conectadx'] = true;
    $_SESSION['idUsuarix'] = $datosUsuario->id;
    $_SESSION['nombreUsuarix'] = $datosUsuario->username;
    $_SESSION['tipoUsuarix'] = $datosUsuario->profile;
    
    echo "<script>location.href = '../comandas/index.php'</script>";
} else {
    echo "Usuarix y/o contraseña incorrectos";    
}