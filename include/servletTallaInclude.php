<?php 
	include('conexion.php');
	if(isset($_POST['actividad'])){

		$talla = mysqli_real_escape_string($conexion,$_POST['talla']);

		if($_POST['actividad'] == "nuevo"){

			$sql = "INSERT INTO producto_talla(talla,fecha_alta,activo)
					     VALUES('".$talla."',NOW(),1)";
			if(mysqli_query($conexion,$sql)){
				echo "1";
			}else{
				echo mysqli_error($conexion);
			}

		}else if($_POST['actividad'] == "editar"){
			$activo = mysqli_real_escape_string($conexion,$_POST['activo']);
			$id_talla = mysqli_real_escape_string($conexion,$_POST['id_talla']);
			$sql = "UPDATE producto_talla SET talla = '$talla', activo = $activo 
					WHERE id_talla = $id_talla";
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