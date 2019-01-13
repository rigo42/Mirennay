<?php 
	include('conexion.php');

	$producto = "";
	if($_GET['producto'] != ""){
		$producto = " AND  (p.producto like '%" . $_GET['producto'] . "%')";
	}
	if(isset($_GET['activo'])){
		$activo = $_GET['activo'];
	}

	$sql = "SELECT p.*, pdor.*, c.*
			FROM producto p
			INNER JOIN proveedor pdor ON pdor.id_proveedor = p.id_proveedor 
			INNER JOIN categoria c ON c.id_categoria = p.id_categoria
			WHERE p.activo = ".$activo ." AND pdor.activo = 1 AND c.activo = 1 ".$producto." ";

	$producto = mysqli_query($conexion,$sql);
	
 ?>
<div class="table-responsive">
	<table class="table table-hover">
	  <thead>
	    <tr>
	      <th scope="col">#</th>
	      <th scope="col">IMAGEN</th>
	      <th scope="col">PRODUCTO</th>
	      <th scope="col">CATEGORIA</th>
	      <th scope="col">PROVEEDOR</th>
	      <th scope="col">PRECIO</th>
	      <th scope="col">OFERTA</th>
	      <th scope="col">PRECIO OFERTA</th>
	      <th scope="col">FECHA</th>
	    </tr>
	  </thead>
	  <tbody>
	  	<?php
	  		$n = 0;
	  	 	foreach ($producto as $key) { 
	  		++$n;
	  	?>
	    <tr class="seleccion" data-id="<?php echo $key['id_producto'] ?>">
	      <th scope="row"><?php echo $n ?></th>
	      <td><img width="50px" src="imgProducto/<?php echo $key['imagen_principal'] ?>"></td>
	      <td><?php echo $key['producto'] ?></td>
	      <td><?php echo $key['categoria'] ?></td>
	      <td><?php echo $key['proveedor'] ?></td>
	      <td><?php echo $key['precio'] ?></td>
	      <?php 
	      	if($key['activo_oferta'] == 1){
	      		?>
				<td style="color: green;">Si</td>
	      		<?php
	      	}else{
	      		?>
	      		<td>No</td>
	      		<?php
	      	}
	       ?>
	      <td style="color: green;"><?php echo $key['precio_oferta'] ?></td>
	      <td style="color: green;"><?php echo $key['fecha_fin_oferta'] ?></td>
	    </tr>
		<?php 
		}
		mysqli_free_result($producto);
		 ?>
	  </tbody>
	</table>
</div>

<script type="text/javascript">
	$(".seleccion").click(function(e){
		  	e.preventDefault();
		  	var id_producto = $(this).attr("data-id");
		  	location="administrador.php?admin=productoEditar&id_producto="+id_producto;
		  });
</script>