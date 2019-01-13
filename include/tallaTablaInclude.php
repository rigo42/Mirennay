<?php 
	include('conexion.php');

	$talla = "";
	if($_GET['talla'] != ""){
		$talla = " AND  (talla like '%" . $_GET['talla'] . "%') ";
	}
	if(isset($_GET['activo'])){
		$activo = $_GET['activo'];
	}

	$sql = "SELECT * FROM producto_talla 
				 WHERE activo = ".$activo ." 
				 	   ".$talla." ";
	$talla = mysqli_query($conexion,$sql);
	
 ?>
<div class="table-responsive-sm">
	<table class="table table-hover">
	  <thead>
	    <tr>
	      <th scope="col">#</th>
	      <th scope="col">TALLA</th>
	      <th scope="col">FECHA ALTA</th>
	    </tr>
	  </thead>
	  <tbody>
	  	<?php
	  		$n = 0;
	  	 	foreach ($talla as $key) { 
	  		++$n;
	  	?>
	    <tr class="seleccion" data-id="<?php echo $key['id_talla'] ?>">
	      <th scope="row"><?php echo $n ?></th>
	      <td><?php echo $key['talla'] ?></td>
	      <td><?php echo $key['fecha_alta'] ?></td>
	    </tr>
		<?php 
		}
		mysqli_free_result($talla);
		 ?>
	  </tbody>
	</table>
</div>

<script type="text/javascript">
	$(".seleccion").click(function(e){
		  	e.preventDefault();
		  	var id_talla = $(this).attr("data-id");
		  	location="administrador.php?admin=tallaEditar&id_talla="+id_talla;
		  });
</script>