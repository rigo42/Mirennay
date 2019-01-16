<?php 
include('conexion.php');
//Metodo para sacar fecha y sumar dias etc, sirve para sql
$fechaHoy = date("Y-m-d H:i:s");
$fechaMenos7Dias = date( "Y-m-d H:i:s", strtotime( "$fechaHoy -80 days" ) );

$sqlProductoNuevo = "SELECT p.*,c.*,NOW() AS 'hoy',p.fecha_alta AS 'fecha_alta_producto' 
		FROM producto p
		INNER JOIN categoria c ON c.id_categoria = p.id_categoria 
		WHERE 1 AND p.fecha_alta >= '$fechaMenos7Dias' ";
$resProductoNuevo = mysqli_query($conexion, $sqlProductoNuevo);
$rowProductoNuevo = mysqli_num_rows($resProductoNuevo);
if($rowProductoNuevo > 0){

	$sqlCategoria=" SELECT * FROM categoria 
					WHERE activo = 1  
					ORDER BY categoria DESC 
					LiMIT 3";
	$resCategoria = mysqli_query($conexion,$sqlCategoria);

?>
<!-- SECTION -->
<div class="section">
	<!-- container -->
	<div class="container">
		<!-- row -->
		<div class="row">

			<!-- section title -->
			<div class="col-md-12">
				<div class="section-title">
					<h3 class="title">Nuevos Productos</h3>
				</div>
			</div>
			<!-- /section title -->

			<!-- Products tab & slick -->
			<div class="col-md-12">
				<div class="row">
					<div class="products-tabs">
						<!-- tab -->
						<div id="tab1" class="tab-pane active">
							<div class="products-slick" data-nav="#slick-nav-1">
								<?php
									foreach ($resProductoNuevo as $keyProductonuevo) {
										$comprobarFavorito = 0;
										if(isset($_SESSION['idUsuario'])){
											$sqlComprobarFavorito = "SELECT pf.activo AS 'comprobarActivo' 
																 FROM producto_favorito pf
																 INNER JOIN usuario u ON u.id_usuario = pf.id_usuario
																 INNER JOIN producto p ON p.id_producto = pf.id_producto
																 WHERE p.id_producto = ".$keyProductonuevo['id_producto']." AND u.id_usuario = ".$_SESSION['idUsuario']." ";
											$resComprobarFavorito = mysqli_query($conexion,$sqlComprobarFavorito);
											foreach ($resComprobarFavorito as $keyComprobarFavorito) {
												$comprobarFavorito = $keyComprobarFavorito['comprobarActivo'];
											}
										}
								?>
								<!-- product -->
								<div class="product">
									
										<div class="product-img" >
											<img src="imgProducto/<?php echo $keyProductonuevo['imagen_principal'] ?>" alt="" data-id="<?php echo $keyProductonuevo['id_producto'] ?>">
											<div class="product-label">
												<?php 
												if($keyProductonuevo['activo_oferta'] == 1 ){
													$porcentaje = 100 - round(($keyProductonuevo['precio_oferta'] * 100) / $keyProductonuevo['precio'],0);
													?>
													<span class="sale">-<?php echo $porcentaje ?>%</span>
													<?php
												}
												//Metodo para comparar fechas solamente, no sirve en consulta sql
												$fecha = $keyProductonuevo['fecha_alta_producto'];
												$fecha2 = explode(" ",$fecha);
												$fecha3 = $fecha2[0];
												$fecha4 = strtotime("$fecha3 +7 days");
												$fechaHoy = $keyProductonuevo['hoy'];
												$fechaHoy2 = strtotime("$fechaHoy");
												if($fechaHoy2  <= $fecha4){
													?>
													 <span class="new">NEW</span>
													<?php
												}
												 ?>
											</div>
										</div>

										<div class="product-body seleccion">
											<p class="product-category"><?php echo $keyProductonuevo['categoria'] ?></p>
											<h3 class="product-name"><a href="productoDetalle.php"><?php echo $keyProductonuevo['producto'] ?></a></h3>

											<h4 class="product-price">
												<?php 
													if($keyProductonuevo['activo_oferta']==1){
												 ?>
													$<?php echo $keyProductonuevo['precio_oferta'] ?> <del class="product-old-price">$<?php echo $keyProductonuevo['precio'] ?></del>
												 <?php 
												 	}else{
												 		?>
													$<?php echo $keyProductonuevo['precio'] ?>
												 		<?php
												 	}
												  ?>
											</h4>
											<div class="product-rating">
												<?php 
													$sqlEstrella = " SELECT count(id_producto_comentario) as 'cantidadEstrella',sum(cantidad_estrella) as 'sumaEstrella'
						     				 			FROM producto_comentario
						     				 			WHERE id_producto = ".$keyProductonuevo['id_producto'];
													$resEstrella = mysqli_query($conexion,$sqlEstrella);

													foreach ($resEstrella as $key) {
														if($key['cantidadEstrella'] > 0){
															$estrellas = round($key['sumaEstrella'] / $key['cantidadEstrella'],0);
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
														}else{
															for ($i=1; $i <= 5 ; $i++) { 
																?>
																<i class="fa fa-star-o"></i>
																<?php
															}
														}
													}
												 ?>
											</div>
											<div class="product-btns">
											<?php if(isset($_SESSION['idUsuario'])){ ?>
													<?php if($comprobarFavorito == 1){ ?>
													<button class="add-to-wishlist" data-sesion="si" data-idProducto="<?php echo $keyProductonuevo['id_producto'] ?>" data-idUsuario="<?php echo $_SESSION['idUsuario'] ?>"><i class="fa fa-heart"></i><span class="tooltipp favoritoSpan">Quitar</span></button>
													<?php }else{ ?>
													<button class="add-to-wishlist" data-sesion="si" data-idProducto="<?php echo $keyProductonuevo['id_producto'] ?>" data-idUsuario="<?php echo $_SESSION['idUsuario'] ?>"><i class="fa fa-heart-o"></i><span class="tooltipp favoritoSpan">Añadir</span></button>
													<?php } ?>
											<?php 
												}else{
													?>
													<button class="add-to-wishlist" data-sesion="no" data-idProducto="<?php echo $keyProductonuevo['id_producto'] ?>"><i class="fa fa-heart-o"></i><span class="tooltipp favoritoSpan">Añadir</span></button>
													<?php
												}
											 ?>
												<button class="quick-view" data-id="<?php echo $keyProductonuevo['id_producto'] ?>"><i class="fa fa-eye"></i><span class="tooltipp">Ver</span></button>
											</div>
										</div>
									</div>
								 <!-- /product -->
								<?php } ?>
							</div>
							<div id="slick-nav-1" class="products-slick-nav"></div>
						</div>
						<!-- /tab -->
					</div>	
				</div>
			</div>
			
		</div>
		<!-- /row -->
	</div>
	<!-- /container -->
</div>
<!-- /SECTION -->
<?php
}else{
//echo "Actualmente no hay ningun producto";
}
 ?>


