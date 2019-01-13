<?php 
	include('conexion.php');
	if(isset($_POST['actividad'])){

		$id_producto = mysqli_real_escape_string($conexion,$_POST['id_producto']);
		$id_usuario = mysqli_real_escape_string($conexion,$_POST['id_usuario']);
		$comentario = mysqli_real_escape_string($conexion,$_POST['comentario']);
		$cantidadEstrella = mysqli_real_escape_string($conexion,$_POST['cantidadEstrella']);

		if($_POST['actividad'] == "nuevo"){

			$sql = "INSERT INTO producto_comentario(id_producto,id_usuario,comentario,cantidad_estrella,fecha_alta,activo)
					     VALUES('".$id_producto."','".$id_usuario."','".$comentario."','".$cantidadEstrella."',NOW(),1)";
			if(mysqli_query($conexion,$sql)){
				echo "1";
			}else{
				echo mysqli_error($conexion);
			}

		}else if($_POST['actividad'] == "editar"){
			$activo = mysqli_real_escape_string($conexion,$_POST['activo']);
			$id_id_producto = mysqli_real_escape_string($conexion,$_POST['id_producto_comentario']);
			$sql = "UPDATE producto_comentario SET  activo = $activo 
					WHERE id_producto_comentario = $id_producto_comentario";
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