<?php
require 'conexion.php';
function insertar($nombre_emp, $prod, $tipo){
$conn=obtener_conexion();
$IDP=0;
$id_empresa=0;
if($conn){
$existeemp=mysqli_query($conn,'select Nombre from empresas where Nombre="'.$nombre_emp.'";');

$existeprod=mysqli_query($conn,'select Nombre from productosyserv where Nombre="'.$prod.'";');
if(!$existeemp->num_rows>0){
$topemp = mysqli_query($conn,'Select max(id) as maxi from empresas');
$a=mysqli_fetch_assoc($topemp);
if($a['maxi']==''){$query='Insert into Empresas values(1, "'.$nombre_emp.'");';
$result = mysqli_query($conn,$query) or die('Consulta fallida: ' . mysqli_error($conn));}
else{
	$d=$a['maxi']+1;
	$query='Insert into Empresas values('. $d .', "'.$nombre_emp.'");';
	$result = mysqli_query($conn,$query) or die('Consulta fallida: ' . mysqli_error($conn));}
}else{
	$IDE=mysqli_fetch_assoc(mysqli_query($conn,'Select id from empresas where nombre="'.$nombre_emp.'";'));
	$id_empresa = $IDE['id'];	
	}
if(!$existeprod->num_rows>0){
$topprod = mysqli_query($conn,'Select max(id)as maxi from productosyserv');
$b=mysqli_fetch_assoc($topprod);
if($b['maxi']==''){
	$query2='Insert into productosyserv values(1,"'.$prod.'");';
	$result = mysqli_query($conn,$query2) or die('Consulta fallida: ' . mysqli_error($conn));
}else{
	$d=$b['maxi']+1;
	$id_prod=$d;
	$query2='Insert into productosyserv values('.$d .',"'.$prod.'");';
	$result = mysqli_query($conn,$query2) or die('Consulta fallida: ' . mysqli_error($conn));
}
}
else{
	$IDP=mysqli_fetch_assoc(mysqli_query($conn,'Select id from productosyserv where nombre="'.$prod.'";'));
	$id_prod = $IDP['id'];

}
$query='Insert into relacion values('.$id_empresa.', '.$id_prod.', "'.$tipo.'");';
echo $query;
	$result = mysqli_query($conn,$query) or die('Consulta fallida: ' . mysqli_error($conn));

}
};
function obtener_proveedores(){
	$conn=obtener_conexion();
	$result = mysqli_query($conn,'SELECT empresas.nombre, productosyserv.nombre, tipo FROM empresas, relacion, productosyserv WHERE empresas.id=id_empresa AND productosyserv.id=id_producto AND tipo="Proveedor";') or die('Consulta fallida: ' . mysqli_error($conn));
	echo "<table border='1'><tr><td>Empresa</td><td>Servicio</td><td>Relacion</td>
         </tr><tr>";
//obtenemos los datos resultado de la consulta 
    while ($row = mysqli_fetch_row($result)){
    echo "</tr><tr><td>".$row[0]."</td><td>".$row[1]."</td>
              <td>".$row[2]."</td>";
    }
    echo "</tr></table>";
}
function obtener_clientes(){
		$conn=obtener_conexion();
	$result = mysqli_query($conn,'SELECT empresas.nombre, productosyserv.nombre, tipo FROM empresas, relacion, productosyserv WHERE empresas.id=id_empresa AND productosyserv.id=id_producto AND tipo="Cliente";') or die('Consulta fallida: ' . mysqli_error($conn));
	echo "<table border='1'><tr><td>Empresa</td><td>Servicio</td><td>Relacion</td>
         </tr><tr>";
//obtenemos los datos resultado de la consulta 
    while ($row = mysqli_fetch_row($result)){
    echo "</tr><tr><td>".$row[0]."</td><td>".$row[1]."</td>
              <td>".$row[2]."</td>";
    }
    echo "</tr></table>";
}
//insertar('bimbo','producto','cliente');
obtener_clientes();
?>