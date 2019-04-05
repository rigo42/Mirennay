<?php 
//Obtener id del producto y desincriptarla
$idProducto = urldecode(openssl_decrypt($_GET['idProducto'],COD,KEY));
//Validar si es numerico el valor (ID)
if(is_numeric($idProducto)){
//Resultados de la base de datos de este producto
$resProducto = $this->producto($idProducto);
//Cuantos resultados trajo la variable $resProducto
$rowProducto = $resProducto->rowCount();
//Validar si mostramos los datos si llegase estar la id correcta y no modificada por el usuario
if($rowProducto > 0){
	//Comprobar si este producto esta en favorito 
	$comprovarFavorito = $this->productoFavoritoControlador->productoFavoritoComprobar($idProducto);
	//Cantidad de estrellas que tiene en general este producto en la descripción del producto
	$estrellas = $this->productoEstrellaControlador->productoEstrella($idProducto);
	//Asignar valores de los atributos de la base de datos
	foreach ($resProducto as $keyProducto) {
		$id_categoria = $keyProducto['id_categoria'];
		$idSubCategoria = $keyProducto['id_sub_categoria'];
		$producto = $keyProducto['producto'];
		$imagenPrincipal = $keyProducto['imagenPrincipalProducto'];
		$subCategoria = $keyProducto['sub_categoria'];
		$categoria = $keyProducto['categoria'];
		$descripcion = $keyProducto['descripcion'];
		$observacion = $keyProducto['observacion'];
		$precio = $keyProducto['precio'];
		$activoOferta = $keyProducto['activo_oferta'];
		$precioOferta = $keyProducto['precio_oferta'];
	}
?>
<!-- BREADCRUMB -->
<div id="breadcrumb" class="section">
	<!-- container -->
	<div class="container">
		<!-- row -->
		<div class="row">
			<div class="col-md-12">
				<ul class="breadcrumb-tree">
					<li><a href="#"><?php echo $categoria ?></a></li>
					<li class="active"><?php echo $subCategoria ?></li>
				</ul>
			</div>
		</div>
		<!-- /row -->
	</div>
	<!-- /container -->
</div>
<!-- /BREADCRUMB -->

<!-- SECTION -->
<div class="section">
	<!-- container -->
	<div class="container">
		<!-- row -->
		<div class="row">
			<!-- Product main img -->
				<div class="col-md-5 col-md-push-2">
					<div id="product-main-img">
					<div class="product-preview">
						<img src="<?php echo URL ?>libreria/imgProducto/<?php echo $imagenPrincipal ?>" alt="">
					</div>
					<?php
					//Resultados de la base de datos de los detalles de este producto
					$resProductoDetalle = $this->productoDetalle($idProducto);
					foreach ($resProductoDetalle as $keyProductoDetalle) {
						for ($i=1; $i <= 6; $i++) { 
						if($keyProductoDetalle['imagen'.$i] != null){
					?>
						<div class="product-preview">
							<img src="<?php echo URL ?>libreria/imgProducto/<?php echo $keyProductoDetalle['imagen'.$i] ?>" alt="">
						</div>
					<?php } } } ?>
					</div>
				</div>
				<!-- /Product main img -->

				<!-- Product thumb imgs -->
				<div class="col-md-2  col-md-pull-5">
					<div id="product-imgs">
					<div class="product-preview">
						<img src="<?php echo URL ?>libreria/imgProducto/<?php echo $imagenPrincipal ?>" alt="">
					</div>
					<?php
						//Resultados de la base de datos de los detalles de este producto
						$resProductoDetalle = $this->productoDetalle($idProducto);
						foreach ($resProductoDetalle as $keyProductoDetalle) {
							for ($i=1; $i <= 6; $i++) { 
							if($keyProductoDetalle['imagen'.$i] != null){
					?>
						<div class="product-preview">
							<img src="<?php echo URL ?>libreria/imgProducto/<?php echo $keyProductoDetalle['imagen'.$i] ?>" alt="">
						</div>
					<?php } } } ?>
					</div>
				</div>
				<!-- /Product thumb imgs -->

			<!-- Product details -->
			<div class="col-md-5">
				<div class="product-details">
					<h2 class="product-name"><?php echo $producto ?></h2>
					<div>
						<div class="product-rating">
							<?php 
							$estrellas = $this->productoEstrellaControlador->productoEstrella($idProducto);
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

						<a class="review-link" href="#">
							<?php 
							echo $comentarioRow = $this->comentarioRow($idProducto);
							echo " Comentario(s) "; 
							if(isset($_SESSION['idUsuario'])){
								echo "| Add your review";
							} 
							?>
						</a>
					</div>
					<div>
						<h3 class="product-price">
						<?php 
						if($activoOferta==1){
						 ?>
						 $<?php echo $precioOferta ?> MXN <del class="product-old-price">$<?php echo $precio ?> MXN</del>
						 <?php 
						 }else{
						 ?>
						 $<?php echo $precio ?> MXN
						 <?php
						 }
						 ?>
						</h3>
						<span class="product-available">In Stock</span>
					</div>
					<p><?php echo $descripcion ?></p>

					<div class="product-options">
						<?php 
						//Resultados de la base de datos de los detalles de este producto
						$resProductoDetalle = $this->productoDetalle($idProducto);
						 ?>
						<label>
							TALLA - COLOR
							<select class="input-select" name="idProductoDetalle">
							<?php foreach ($resProductoDetalle as $keyProductoDetalle) { ?>
							<option 
								value="<?php echo openssl_encrypt($keyProductoDetalle['id_producto_detalle'], COD, KEY) ?>" 
								data-talla="<?php echo $keyProductoDetalle['talla'] ?>" 
								data-color="<?php echo $keyProductoDetalle['color'] ?>">
								Talla (<?php echo $keyProductoDetalle['talla'] .") 
								Color (". $keyProductoDetalle['color'] ?>)
							</option>
							<?php } ?>
							</select>
						</label>
					</div>

					<div class="add-to-cart">
						<div class="qty-label">
							Cant.
							<div class="input-number">
								<select class="input-select" name="idProductoDetalleCantidad">
									
								</select>
							</div>
						</div>
						<?php 
						$validarProductoCarrito = $this->productoCarritoControlador->productoCarritoComprobar($idProducto);
						$idProductoEncode = openssl_encrypt($idProducto,COD,KEY);
						if($validarProductoCarrito == 1){
							$mensaje = "Añadido";
						}else if($validarProductoCarrito == 2){
							$mensaje = "Añadir";
						}else if($validarProductoCarrito == 3){
							$mensaje = "Añadir";
							$idProductoEncode = urlencode($idProductoEncode);
						}
						?>
						<button 
							class="add-to-cart-btn"
							data-idProducto="<?php echo $idProductoEncode ?>"
							data-productoImagenPrincipal="<?php echo $imagenPrincipal ?>"
							data-producto="<?php echo $producto ?>"
							<?php if ($activoOferta == 1) {  ?>
							data-precio="<?php echo $precioOferta ?>"
							<?php }else{ ?>
							data-precio="<?php echo $precio ?>"
							<?php } ?>
						><i class="fa fa-shopping-cart"></i>
						<span>
							<?php echo $mensaje; ?>
						</span>
						</button>
					</div>
					<?php 
					$validarProductoFavorito = $this->productoFavoritoControlador->productoFavoritoComprobar($idProducto);
					if($validarProductoFavorito == 1){
						$claseFavorito = "fa fa-heart";
					}else{
						$claseFavorito = "fa fa-heart-o";
					}
					?>
					<ul class="product-btns">
						<li>
							<a href="#" class="addWishlist" data-idProducto="<?php echo openssl_encrypt($idProducto, COD, KEY) ?>" >
								<i class="<?php echo $claseFavorito ?>" ></i>
								<span>Favorito</span>
							</a>
						</li>
						<!-- <li><a href="#"><i class="fa fa-exchange"></i> add to compare</a></li> -->
					</ul>

					<ul class="product-links">
						<li>Categoria:</li>
						<li><a href="#"><?php echo $categoria ?></a></li>
						<li><a href="#"><?php echo $subCategoria ?></a></li>
					</ul>

					<ul class="product-links">
						<li>Compartir:</li>
						<li><a href="#"><i class="fa fa-facebook"></i></a></li>
						<li><a href="#"><i class="fa fa-twitter"></i></a></li>
						<li><a href="#"><i class="fa fa-google-plus"></i></a></li>
						<li><a href="#"><i class="fa fa-envelope"></i></a></li>
					</ul>

				</div>
			</div>
			<!-- /Product details -->

			<!-- Product tab -->
			<div class="col-md-12">
				<div id="product-tab">
					<!-- product tab nav -->
					<ul class="tab-nav">
						<li class="active"><a data-toggle="tab" href="#tab1">Descripción</a></li>
						<li><a data-toggle="tab" href="#tab2">Detalles</a></li>
						<li><a data-toggle="tab" href="#tab3">Comentarios (<?php echo $comentarioRow ?>)</a></li>
					</ul>
					<!-- /product tab nav -->

					<!-- product tab content -->
					<div class="tab-content">
						<!-- tab1  -->
						<div id="tab1" class="tab-pane fade in active">
							<div class="row">
								<div class="col-md-12">
									<p><?php echo $descripcion ?>.</p>
								</div>
							</div>
						</div>
						<!-- /tab1  -->

						<!-- tab2  -->
						<div id="tab2" class="tab-pane fade in">
							<div class="row">
								<div class="col-md-12">
									<p><?php echo $observacion ?>.</p>
								</div>
							</div>
						</div>
						<!-- /tab2  -->

						<!-- tab3  -->
						<div id="tab3" class="tab-pane fade in">
							<div class="row">
								<!-- Rating -->
								<div id="ventanaEncuestaEstrella" data-idProducto="<?php echo openssl_encrypt($idProducto, COD, KEY) ?>"></div>
								<!-- /Rating -->

								<!-- Comentarios -->
								<div id="ventanaEncuestaComentario" data-idProducto="<?php echo openssl_encrypt($idProducto, COD, KEY) ?>"></div>
								<!-- /Comentarios -->
									
								<!-- Review Form -->
								<div id="ventanaEncuestaFormulario" data-idProducto="<?php echo openssl_encrypt($idProducto, COD, KEY) ?>"></div>
								<!-- /Review Form -->
							</div>
						</div>
						<!-- /tab3  -->
					</div>
					<!-- /product tab content  -->
				</div>
			</div>
			<!-- /product tab -->
		</div>
		<!-- /row -->
	</div>
	<!-- /container -->
</div>
<!-- /SECTION -->
<input type="hidden" value="<?php echo $producto ?>" name="producto">

<?php
}else{
	echo "No se encontro ningun resultado";
} }else{
	echo "No se encontro ningun resultado";
}
 ?>

 <script type="text/javascript">
 	$(document).ready(function(){
 		tittlePage("#menuTienda",$("input[name='producto']").val());
 		var idProducto = $("#ventanaEncuestaEstrella").attr("data-idProducto");
 		ventanaEncuestaEstrella(idProducto);
		ventanaEncuestaComentario(idProducto,3,1);
		ventanaEncuestaFormulario(idProducto);
	});
	
 </script>