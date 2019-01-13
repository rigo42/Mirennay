<?php 
	include('conexion.php');

	$categoria = "";
	if($_GET['categoria'] != ""){
		$categoria = " AND  (categoria like '%" . $_GET['categoria'] . "%') ";
	}
	if(isset($_GET['activo'])){
		$activo = $_GET['activo'];
	}

	$sql = "SELECT * FROM categoria 
				 WHERE activo = ".$activo ." 
				 	   ".$categoria." ";
	$categoria = mysqli_query($conexion,$sql);
	
 ?>
<div class="table-responsive">
	<table class="table table-hover">
	  <thead>
	    <tr>
	      <th scope="col">#</th>
	      <th scope="col">CATEGORIA</th>
	      <th scope="col">FECHA ALTA</th>
	    </tr>
	  </thead>
	  <tbody>
	  	<?php
	  		$n = 0;
	  	 	foreach ($categoria as $key) { 
	  		++$n;
	  	?>
	    <tr class="seleccion" data-id="<?php echo $key['id_categoria'] ?>">
	      <th scope="row"><?php echo $n ?></th>
	      <td><?php echo $key['categoria'] ?></td>
	      <td><?php echo $key['fecha_alta'] ?></td>
	    </tr>
		<?php 
		}
		mysqli_free_result($categoria);
		 ?>
	  </tbody>
	</table>
</div>

<script type="text/javascript">
	$(".seleccion").click(function(e){
		  	e.preventDefault();
		  	var id_categoria = $(this).attr("data-id");
		  	location="administrador.php?admin=categoriaEditar&id_categoria="+id_categoria;
		  });
</script>