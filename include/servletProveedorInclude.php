<?php 
	include('conexion.php');
	if(isset($_POST['actividad'])){

		$id_empresa = mysqli_real_escape_string($conexion,$_POST['id_empresa']);
		$id_municipio = mysqli_real_escape_string($conexion,$_POST['id_municipio']);
		$proveedor = mysqli_real_escape_string($conexion,$_POST['proveedor']);
		$direccion = mysqli_real_escape_string($conexion,$_POST['direccion']);
		$codigo_postal = mysqli_real_escape_string($conexion,$_POST['codigo_postal']);
		$celular = mysqli_real_escape_string($conexion,$_POST['celular']);
		$observacion = mysqli_real_escape_string($conexion,$_POST['observacion']);

		if($_POST['actividad'] == "nuevo"){

			$sql = "INSERT INTO proveedor(id_empresa,id_municipio,proveedor,direccion,codigo_postal,celular,observacion,fecha_alta,activo)
					     VALUES('".$id_empresa."','".$id_municipio."','".$proveedor."','".$direccion."','".$codigo_postal."','".$celular."','".$observacion."',NOW(),1)";
			if(mysqli_query($conexion,$sql)){
				echo "1";
			}else{
				echo mysqli_error($conexion);
			}

		}else if($_POST['actividad'] == "editar"){
			$activo = mysqli_real_escape_string($conexion,$_POST['activo']);
			$id_proveedor = mysqli_real_escape_string($conexion,$_POST['id_proveedor']);
			$sql = "UPDATE proveedor SET id_empresa = '$id_empresa', id_municipio = '$id_municipio', proveedor = '$proveedor', 
					direccion = '$direccion',codigo_postal = '$codigo_postal', celular = '$celular', observacion = '$observacion', activo = $activo 
					WHERE id_proveedor = $id_proveedor";
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