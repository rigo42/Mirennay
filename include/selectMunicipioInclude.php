<?php 
	include 'conexion.php';
	$sql = "SELECT * FROM municipio WHERE id_estado = ".$_POST['id_estado'];
	$res = mysqli_query($conexion,$sql);
	foreach ($res as $key) {
		?>
			<option value="<?php echo $key['id_municipio'] ?>"><?php echo $key['municipio'] ?></option>
		<?php
	}
 ?>