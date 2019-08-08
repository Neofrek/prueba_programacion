<?php
function obtener_conexion(){
	$servidor='localhost';
$usuario='root';
$contraseña='ernesto';
$bd='prueba';
$conn=mysqli_connect($servidor, $usuario, $contraseña, $bd)or die ("No se ha podido conectar al servidor de Base de datos");
return $conn;
}
?>