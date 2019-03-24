<?php 
	if($row > 0){

	foreach ($res as $key) { 
?>
	<div class="product-widget">
		<div class="product-img">
			<img src="<?php echo URL ?>libreria/imgProducto/<?php echo $key['imagen_principal'] ?>" alt="" data-id="<?php echo $key['id_producto'] ?>">
		</div>
		<div class="product-body">
			<h3 class="product-name"><a href="<?php echo URL ?>productoDetalle?idProducto=<?php echo openssl_encrypt($key['id_producto'], COD, KEY) ?>"><?php echo $key['producto'] ?></a></h3>
			<h4 class="product-price"><span class="qty"><?php echo $key['sumaCantidad'] ?> In Stock
			<?php 
			if($key['activo_oferta'] == 1){ ?>
			</span><?php echo $key['precio_oferta'] ?> MXN</h4>
			<?php }else{
			?>
			</span><?php echo $key['precio'] ?> MXN</h4>
			<?php
			} 
			?>
		</div>
		<hr>
		<button class="delete deleteFavorito" data-idProducto="<?php echo openssl_encrypt($key['id_producto'], COD, KEY)  ?>"><i class="fa fa-close"></i></button>
	</div>
<?php
	}
	}else{
		?>
		<p>Actualmente no tiene productos en favorito</p>
		<?php
	}	
?>


<script type="text/javascript">
	$(document).ready(function(){

		$("#cuantosProductosFavoritos").html("<?php echo $row ?>");
		

		$(".deleteFavorito").click(function(e){
			e.preventDefault();
			var idProducto = $(this).attr("data-idProducto");
			productoFavorito(idProducto);
		});

	});
</script>
