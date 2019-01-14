<?php  
	session_start();

	if(isset($_SESSION['idUsuario'])){	
		if($_SESSION['rol'] != "admin"){
			header("Location: index.php");
		}
	}else{
		header("Location: index.php");
	}
?>
<!DOCTYPE html>
<html lang="en">
	
		<?php include('include/headInclude.php'); ?>
	<body>

		<title><?php echo $_GET['admin']; ?></title>

		<?php include('include/scriptInclude.php'); ?>

		<?php include('include/menuInclude.php'); ?>
		
		<?php include('include/'.$_GET['admin'].'Include.php'); ?>
	
		<?php include('include/piePaginaInclude.php'); ?>
	
		<script type="text/javascript">
			$(document).ready(function(){
					$(".menu li").removeClass('active');
					$("#menuAdministrador").addClass('active');
			});
		</script>

	</body>
</html>
