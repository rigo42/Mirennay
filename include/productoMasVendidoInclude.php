<?php 
include('conexion.php');

$sqlProductoMasVendido = "SELECT p.*, SUM(pu.cantidad) AS TotalVentas, c.* ,p.fecha_alta AS 'fecha_alta_producto',NOW() AS 'hoy'
							FROM pedido_usuario pu
						    INNER JOIN producto_detalle pd ON pd.id_producto_detalle = pu.id_producto_detalle 
						    INNER JOIN producto p ON p.id_producto = pd.id_producto
                            INNER JOIN categoria c ON c.id_categoria = p.id_categoria
                            WHERE 1 AND p.activo = 1
						    GROUP BY p.id_producto 
						    ORDER BY SUM(pu.cantidad) DESC 
						    LIMIT 0 , 30";
$resProductoMasVendido = mysqli_query($conexion, $sqlProductoMasVendido);
$rowProductoMasVendido = mysqli_num_rows($resProductoMasVendido);
if($rowProductoMasVendido > 0){

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
					<h3 class="title">Mas vendido</h3>
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
									foreach ($resProductoMasVendido as $keyProductoMasVendido) {
										$comprobarFavorito = 0;
										if(isset($_SESSION['idUsuario'])){
											$sqlComprobarFavorito = "SELECT pf.activo AS 'comprobarActivo' 
																 FROM producto_favorito pf
																 INNER JOIN usuario u ON u.id_usuario = pf.id_usuario
																 INNER JOIN producto p ON p.id_producto = pf.id_producto
																 WHERE p.id_producto = ".$keyProductoMasVendido['id_producto']." AND u.id_usuario = ".$_SESSION['idUsuario']." ";
											$resComprobarFavorito = mysqli_query($conexion,$sqlComprobarFavorito);
											foreach ($resComprobarFavorito as $keyComprobarFavorito) {
												$comprobarFavorito = $keyComprobarFavorito['comprobarActivo'];
											}
										}
								?>
								<!-- product -->
								<div class="product">
									
										<div class="product-img" >
											<img src="imgProducto/<?php echo $keyProductoMasVendido['imagen_principal'] ?>" alt="" data-id="<?php echo $keyProductoMasVendido['id_producto'] ?>">
											<div class="product-label">
												<?php 
												if($keyProductoMasVendido['activo_oferta'] == 1 ){
													$porcentaje = 100 - round(($keyProductoMasVendido['precio_oferta'] * 100) / $keyProductoMasVendido['precio'],0);
													?>
													<span class="sale">-<?php echo $porcentaje ?>%</span>
													<?php
												}
												//Metodo para comparar fechas solamente, no sirve en consulta sql
												$fecha = $keyProductoMasVendido['fecha_alta_producto'];
												$fecha2 = explode(" ",$fecha);
												$fecha3 = $fecha2[0];
												$fecha4 = strtotime("$fecha3 +7 days");
												$fechaHoy = $keyProductoMasVendido['hoy'];
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
											<p class="product-category"><?php echo $keyProductoMasVendido['categoria'] ?></p>
											<h3 class="product-name"><a href="productoDetalle.php?id=<?php echo $keyProductoMasVendido['id_producto'] ?>"><?php echo $keyProductoMasVendido['producto'] ?></a></h3>

											<h4 class="product-price">
												<?php 
													if($keyProductoMasVendido['activo_oferta']==1){
												 ?>
													$<?php echo $keyProductoMasVendido['precio_oferta'] ?> <del class="product-old-price">$<?php echo $keyProductoMasVendido['precio'] ?></del>
												 <?php 
												 	}else{
												 		?>
													$<?php echo $keyProductoMasVendido['precio'] ?>
												 		<?php
												 	}
												  ?>
											</h4>
											<div class="product-rating">
												<?php 
													$sqlEstrella = " SELECT count(id_producto_comentario) as 'cantidadEstrella',sum(cantidad_estrella) as 'sumaEstrella'
						     				 			FROM producto_comentario
						     				 			WHERE id_producto = ".$keyProductoMasVendido['id_producto'];
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
													<button class="add-to-wishlist" data-sesion="si" data-idProducto="<?php echo $keyProductoMasVendido['id_producto'] ?>"><i class="fa fa-heart"></i></button>
													<?php }else{ ?>
													<button class="add-to-wishlist" data-sesion="si" data-idProducto="<?php echo $keyProductoMasVendido['id_producto'] ?>"><i class="fa fa-heart-o"></i></button>
													<?php } ?>
											<?php 
												}else{
													?>
													<button class="add-to-wishlist" data-sesion="no" data-idProducto="<?php echo $keyProductoMasVendido['id_producto'] ?>"><i class="fa fa-heart-o"></i></button>
													<?php
												}
											 ?>
												<button class="quick-view" data-id="<?php echo $keyProductoMasVendido['id_producto'] ?>"><i class="fa fa-eye"></i><span class="tooltipp">Ver</span><span class="tooltipp">Ver</span></button>
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


