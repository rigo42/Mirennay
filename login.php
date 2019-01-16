<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
	<title>Login</title>
		<?php include('include/headInclude.php'); ?>
	<body>
		
		<?php include('include/scriptInclude.php'); ?>

		<?php include('include/menuInclude.php'); ?>
		
		<?php include('include/'.$_GET['cliente'].'Include.php'); ?>
	
		<?php include('include/piePaginaInclude.php'); ?>

	</body>
</html>
