<?php 
if($pagina == "tienda"){ ?>
<div class="row">
<?php 
}elseif($pagina == "productoNuevo"){
?>
<div id="tab1" class="tab-pane active">
<div class="products-slick" data-nav="#slick-nav-1">
<?php
}
foreach ($res as $key) {
	if($pagina == "tienda"){
?>
<!-- productTienda -->
<div class="col-md-4 col-xs-6">
<?php
	}
 ?>
	<div class="product"> 
		<div class="product-img" data-idProducto="<?php  echo urlencode(openssl_encrypt($key['id_producto'], COD, KEY)) ?>">
			<img src="<?php echo URL ?>libreria/imgProducto/<?php echo $key['imagen_principal'] ?>" alt="">
			<div class="product-label">
				<?php 
				if($key['activo_oferta'] == 1 ){
				$descuento = 100 - round(($key['precio_oferta'] * 100) / $key['precio'],0);
				?>
				<span class="sale">-<?php echo $descuento ?>%</span>
				<?php
				}
				//Metodo para comparar fechas solamente, no sirve en consulta sql
				$fecha = $key['fechaAltaProducto'];
				$fecha2 = explode(" ",$fecha);
				$fecha3 = $fecha2[0];
				$fecha4 = strtotime("$fecha3 +7 days");
				$fechaHoy = $key['hoy'];
				$fechaHoy2 = strtotime("$fechaHoy");
				if($fechaHoy2  <= $fecha4){
				?>
				 <span class="new">NEW</span>
				<?php
				}
				 ?>
			</div>
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
			<!-- Cantidad de estrellas -->
			<div class="product-rating">
			<?php 
			$estrellas = $this->productoEstrellaControlador->productoEstrella($key['id_producto']);
			for ($i=1; $i <= 5 ; $i++) { 
			if($estrellas >= $i){
			?>
			<i class="fa fa-star"></i>
			<?php
			}else{
			?>
			<i class="fa fa-star-o"></i>
			<?php
			}
			}
			?>
			</div>
			<!-- /Cantidad de estrellas -->
			<div class="product-btns">
				<?php 
				$validarProductoFavorito = $this->productoFavoritoControlador->productoFavoritoComprobar($key['id_producto']);
				$idProducto = openssl_encrypt($key['id_producto'], COD, KEY);
				if($validarProductoFavorito == 0){
					$claseFavorito = "fa fa-heart-o";
				}else if($validarProductoFavorito == 1){
					$claseFavorito = "fa fa-heart";
				}else if($validarProductoFavorito == 2){
					$idProducto = urlencode($idProducto);
					$claseFavorito = "fa fa-heart-o";
				}
				?>
				<button class="addWishlist" data-idProducto="<?php echo $idProducto ?>"><i class="<?php echo $claseFavorito ?>"></i><span class="tooltipp">Favorito</span></button>

				<button class="view" data-idProducto="<?php  echo urlencode(openssl_encrypt($key['id_producto'], COD, KEY)) ?>"><i class="fa fa-eye"></i><span class="tooltipp">quick view</span></button>
			</div>
		</div>
	</div>
<?php 
	if($pagina == "tienda"){ ?>
</div>
<?php } ?>
<!-- /productTienda -->
<?php } ?>

<?php if($pagina == "tienda"){ ?>
</div>
<?php }elseif ($pagina == "productoNuevo") {
?>
</div>
</div>
<div id="slick-nav-1" class="products-slick-nav"></div>
<?php
} 
?>




<script type="text/javascript">
	$(document).ready(function(){

		$(".product-img").click(function(e){
			e.preventDefault();
			var idProducto = $(this).attr("data-idProducto");
			location="<?php echo URL ?>productoDetalle?idProducto="+idProducto;
		});

		$(".view").click(function(e){
			e.preventDefault();
			var idProducto = $(this).attr("data-idProducto");
			location="<?php echo URL ?>productoDetalle?idProducto="+idProducto;
		});

		<?php 
		if($pagina == "tienda"){
		?>
		//Para añadir o quitar de favorito (Solo en la pantalla de tienda)
		$(".addWishlist").click(function(e){
			e.preventDefault();
			if($(this).children("i").hasClass("fa fa-heart")){
				$(this).children("i").removeClass("fa fa-heart");
				$(this).children("i").addClass("fa fa-heart-o");
			}else{
				$(this).children("i").removeClass("fa fa-heart-o");
				$(this).children("i").addClass("fa fa-heart");
			}
			var idProducto = $(this).attr("data-idProducto");
			productoFavorito(idProducto);
		});

		<?php
		}
		 ?>

	});

</script>