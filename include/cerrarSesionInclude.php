<?php 
	session_start();
	unset($_SESSION['idUsuario']);
	unset($_SESSION['rol']);
	unset($_SESSION['usuario']);
	unset($_SESSION['carrito']);
	session_destroy();
	echo "1";
 ?>