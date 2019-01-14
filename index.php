<?php 
	session_start();
 ?>
<!DOCTYPE html>
<html lang="en">
	<title>Inicio</title>
		<?php include('include/headInclude.php'); ?>
	<body>
		
		<?php include('include/scriptInclude.php'); ?>

		<?php include('include/menuInclude.php'); ?>
		
		<?php include('include/inicioInclude.php'); ?>
	
		<?php include('include/piePaginaInclude.php'); ?>
	
		<script type="text/javascript">
			$(document).ready(function(){
					$(".menu li").removeClass('active');
					$("#menuInicio").addClass('active');
			});
		</script>

	</body>
</html>
