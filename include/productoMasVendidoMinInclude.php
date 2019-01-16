<?php 
include('conexion.php');

$sqlProductoMasVendido = "SELECT p.*, SUM(pu.cantidad) AS TotalVentas, c.* ,p.fecha_alta AS 'fecha_alta_producto',NOW() AS 'hoy'
							FROM pedido_usuario pu
						    INNER JOIN producto_detalle pd ON pd.id_producto_detalle = pu.id_producto_detalle 
						    INNER JOIN producto p ON p.id_producto = pd.id_producto
                            INNER JOIN categoria c ON c.id_categoria = p.id_categoria
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

			<div class="col-md-4 col-xs-6">
				<div class="section-title">
					<h4 class="title">Top mas vendido</h4>
					<div class="section-nav">
						<div id="slick-nav-3" class="products-slick-nav"></div>
					</div>
				</div>

				<div class="products-widget-slick" data-nav="#slick-nav-3">
					<div>
						<?php foreach ($resProductoMasVendido as $keyProductoMasVendido) { ?>
						<!-- product widget -->
						<div class="product-widget">
							<div class="product-img">
								<img src="imgProducto/<?php echo $keyProductoMasVendido['imagen_principal'] ?>" alt="">
							</div>
							<div class="product-body">
								<p class="product-category"><?php echo $keyProductoMasVendido['categoria'] ?></p>
								<h3 class="product-name"><a href="#"><?php echo $keyProductoMasVendido['producto'] ?></a></h3>
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
							</div>
						</div>
						<!-- product widget -->
						<?php } ?>

					</div>
				</div>
			</div>

			<div class="col-md-4 col-xs-6">
				<div class="section-title">
					<h4 class="title">Top mas vendido</h4>
					<div class="section-nav">
						<div id="slick-nav-4" class="products-slick-nav"></div>
					</div>
				</div>

				<div class="products-widget-slick" data-nav="#slick-nav-4">
					<div>

						<?php foreach ($resProductoMasVendido as $keyProductoMasVendido) { ?>
						<!-- product widget -->
						<div class="product-widget">
							<div class="product-img">
								<img src="imgProducto/<?php echo $keyProductoMasVendido['imagen_principal'] ?>" alt="">
							</div>
							<div class="product-body">
								<p class="product-category"><?php echo $keyProductoMasVendido['categoria'] ?></p>
								<h3 class="product-name"><a href="#"><?php echo $keyProductoMasVendido['producto'] ?></a></h3>
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
							</div>
						</div>
						<!-- product widget -->
						<?php } ?>

					</div>
				</div>
			</div>

			<div class="clearfix visible-sm visible-xs"></div>

			<div class="col-md-4 col-xs-6">
				<div class="section-title">
					<h4 class="title">Top mas vendido</h4>
					<div class="section-nav">
						<div id="slick-nav-5" class="products-slick-nav"></div>
					</div>
				</div>

				<div class="products-widget-slick" data-nav="#slick-nav-5">
					<div>

						<?php foreach ($resProductoMasVendido as $keyProductoMasVendido) { ?>
						<!-- product widget -->
						<div class="product-widget">
							<div class="product-img">
								<img src="imgProducto/<?php echo $keyProductoMasVendido['imagen_principal'] ?>" alt="">
							</div>
							<div class="product-body">
								<p class="product-category"><?php echo $keyProductoMasVendido['categoria'] ?></p>
								<h3 class="product-name"><a href="#"><?php echo $keyProductoMasVendido['producto'] ?></a></h3>
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
							</div>
						</div>
						<!-- product widget -->
						<?php } ?>

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
