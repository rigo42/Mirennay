<?php
$hostDB = "localhost";
$userDB = "root";
$passDB = "";
$dataDB = "mirennay";
$conexion = mysqli_connect($hostDB, $userDB, $passDB, $dataDB) or die("La conexion ha fallado: " . mysqli_error());
// Controlar las tildes y ñ en los resultados desde MySQL
mysqli_set_charset($conexion,"utf8");
?>