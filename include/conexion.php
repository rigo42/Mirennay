<?php
//Local

$hostDB = "localhost";
$userDB = "root";
$passDB = "";
$dataDB = "mirennay";

//Linea
/*
$hostDB = "sql106.epizy.com";
$userDB = "epiz_21851627";
$passDB = "PBAErsZmRAkJ";
$dataDB = "epiz_21851627_cbta195";
*/

$conexion = mysqli_connect($hostDB, $userDB, $passDB, $dataDB) or die("La conexion ha fallado: " . mysqli_error());
// Controlar las tildes y ñ en los resultados desde MySQL
mysqli_set_charset($conexion,"utf8");
?>