<?php 
	include('conexion.php');
	if(isset($_POST['actividad'])){

		$empresa = mysqli_real_escape_string($conexion,$_POST['empresa']);
		$direccion = mysqli_real_escape_string($conexion,$_POST['direccion']);
		$celular = mysqli_real_escape_string($conexion,$_POST['celular']);
		$observacion = mysqli_real_escape_string($conexion,$_POST['observacion']);

		if($_POST['actividad'] == "nuevo"){

			$sql = "INSERT INTO empresa(empresa,direccion,celular,observacion,fecha_alta,activo)
					     VALUES('".$empresa."','".$direccion."','".$celular."','".$observacion."',NOW(),1)";
			if(mysqli_query($conexion,$sql)){
				echo "1";
			}else{
				echo mysqli_error($conexion);
			}

		}else if($_POST['actividad'] == "editar"){
			$activo = mysqli_real_escape_string($conexion,$_POST['activo']);
			$id_empresa = mysqli_real_escape_string($conexion,$_POST['id_empresa']);
			$sql = "UPDATE empresa SET empresa = '$empresa', direccion = '$direccion', celular = '$celular', 
					observacion = '$observacion', activo = $activo 
					WHERE id_empresa = $id_empresa";
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