<!-- SECTION -->
<div class="section">
	<!-- container -->
	<div class="container">
		<!-- row -->
		<div class="row">
			<?php 
			$res = $this->adminCategoriaControlador->coleccion();
			foreach ($res as $key) {
			 ?>
			 <!-- shop -->
			<div class="col-md-4 col-xs-6">
				<div class="shop" data-idCategoria="<?php echo openssl_encrypt($key['id_categoria'], COD, KEY)?>">
					<div class="shop-img">
						<img src="<?php echo URL ?>libreria/imgCategoria/<?php echo $key['imagen_principal'] ?>" alt="">
					</div>
					<div class="shop-body">
						<h3><?php echo $key['categoria'] ?><br>Collección</h3>
						<a href="#" class="cta-btn">Ver ahora <i class="fa fa-arrow-circle-right"></i></a>
					</div>
				</div>
			</div>
			<!-- /shop -->
			<?php } ?>
		</div>
		<!-- /row -->
	</div>
	<!-- /container -->
</div>
<!-- /SECTION -->
<script type="text/javascript">
	$(document).ready(function(){

		tittlePage("#menuInicio","Inicio");
		
		$(".shop").click(function(e){
			e.preventDefault();
			var idCategoria = $(this).attr("data-idCategoria");
			location="tienda?idCategoria="+idCategoria;
		});
	});
	
</script>