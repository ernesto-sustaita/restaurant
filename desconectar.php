<?php
session_start();

unset($_SESSION['conectadx']);
unset($_SESSION['nombreUsuarix']);
unset($_SESSION['tipoUsuarix']);
unset($_SESSION['idUsuarix']);

session_destroy();

header("Location: view/conexion/");
exit();