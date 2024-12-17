<?php

$servidor = "localhost:3307";
$usuario = "root";
$password = "";
$basededatos = "bdfrappe";

$conexion = new mysqli($servidor, $usuario, $password, $basededatos);
//$conexion = mysqli_connect($servidor, $usuario, $password, $basededatos);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

?>

