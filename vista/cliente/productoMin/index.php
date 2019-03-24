<?php foreach ($res as $key) { ?>
<!-- product widget -->
<div class="product-widget">
	<div class="product-img" data-idProducto="<?php echo urlencode(openssl_encrypt($key['id_producto'], COD, KEY)) ?>">
		<img src="<?php URL ?>libreria/imgProducto/<?php echo $key['imagen_principal'] ?>" alt="">
	</div>
	<div class="product-body">
		<p class="product-category"><?php echo $key['sub_categoria'] ?></p>
		<h3 class="product-name"><a href="<?php URL ?>ProductoDetalle?idProducto=<?php  echo urlencode(openssl_encrypt($key['id_producto'], COD, KEY)) ?>"><?php echo $key['producto'] ?></a></h3>
		<h4 class="product-price">
			<?php 
				if($key['activo_oferta']==1){
			 ?>
				$<?php echo $key['precio_oferta'] ?> <del class="product-old-price">$<?php echo $key['precio'] ?></del>
			 <?php 
			 	}else{
			 		?>
				$<?php echo $key['precio'] ?>
			 		<?php
			 	}
			  ?>
		</h4>
	</div>
</div>
<!-- product widget -->
<?php } ?>