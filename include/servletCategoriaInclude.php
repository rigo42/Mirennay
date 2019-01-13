<?php 
	include('conexion.php');
	if(isset($_POST['actividad'])){

		$categoria = mysqli_real_escape_string($conexion,$_POST['categoria']);

		if($_POST['actividad'] == "nuevo"){

			$sql = "INSERT INTO categoria(categoria,fecha_alta,activo)
					     VALUES('".$categoria."',NOW(),1)";
			if(mysqli_query($conexion,$sql)){
				echo "1";
			}else{
				echo mysqli_error($conexion);
			}

		}else if($_POST['actividad'] == "editar"){
			$activo = mysqli_real_escape_string($conexion,$_POST['activo']);
			$id_categoria = mysqli_real_escape_string($conexion,$_POST['id_categoria']);
			$sql = "UPDATE categoria SET categoria = '$categoria', activo = $activo 
					WHERE id_categoria = $id_categoria";
			if(mysqli_query($conexion,$sql)){
				echo "1";
			}else{
				echo mysqli_error($conexion);
			}

		}
	}else{
		echo "No enviaste la actividad";
	} 


 ?>