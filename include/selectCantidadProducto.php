<?php 
	if(isset($_POST['id_producto_detalle'])){
		include('conexion.php');
		$id_producto_detalle = $_POST['id_producto_detalle'];
		$sqlCantidadProducto = " SELECT cantidad FROM producto_detalle WHERE id_producto_detalle = ".$id_producto_detalle;
		$resCantidadProducto = mysqli_query($conexion,$sqlCantidadProducto);
		$cantidad = 0;
		foreach ($resCantidadProducto as $key) {
			$cantidad = $key['cantidad'];
		}
		if($cantidad > 0){
			for ($i=1; $i <= $cantidad ; $i++) { 
				?>
				<option value="<?php echo $i ?>"><?php echo $i ?></option>
				<?php
			}
			?>
			<script type="text/javascript">
				$(".add-to-cart-btn").css("display","block");
				$("#productoInactivo").html("");
			</script>
			<?php
		}else{
			?>
			<option value="">Producto agotado</option>
			<script type="text/javascript">
				$(".add-to-cart-btn").css("display","none");
				$("#productoInactivo").html("<button class='btn btn-primary'>Este producto esta agotado</button>");
			</script>
			<?php
		}
		
	}else{
		echo "No hay id_producto_detalle";
	}
 ?>