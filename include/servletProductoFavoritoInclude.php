<?php 
	include('conexion.php');
	if(isset($_POST['actividad'])){

		$idProducto = mysqli_real_escape_string($conexion,$_POST['idProducto']);
		$idUsuario = mysqli_real_escape_string($conexion,$_POST['idUsuario']);
		$activo = mysqli_real_escape_string($conexion,$_POST['activo']);

		if($_POST['actividad'] == "nuevo"){

			$sqlValidacion = "SELECT * FROM producto_favorito WHERE id_producto = ".$idProducto." AND id_usuario = ".$idUsuario." ";
			$resValidacion = mysqli_query($conexion,$sqlValidacion);
			$validar = mysqli_num_rows($resValidacion);
			if($validar > 0){
				$sql = "UPDATE producto_favorito SET  activo = $activo, fecha_alta = NOW()
						WHERE id_producto = $idProducto AND id_usuario = ".$idUsuario." ";
				if(mysqli_query($conexion,$sql)){
					echo "1";
				}else{
					echo mysqli_error($conexion);
				}
			}else{
				$sql = "INSERT INTO producto_favorito(id_producto,id_usuario,fecha_alta,activo)
					     VALUES('".$idProducto."','".$idUsuario."',NOW(),1)";
				if(mysqli_query($conexion,$sql)){
					echo "1";
				}else{
					echo mysqli_error($conexion);
				}
			}
		}else if($_POST['actividad'] == "editar"){
			$sql = "UPDATE producto_favorito SET  activo = $activo 
					WHERE id_producto = $idProducto";
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