<?php 
	if($rowCount > 0){
	$idProducto = openssl_encrypt($idProducto, COD, KEY);
 ?>
<!-- Reviews -->
<div class="col-md-6">
	<div id="reviews">

		<ul class="reviews">
			<?php 
			foreach ($res as $key) {
			 ?>
			<li>
				<div class="review-heading">
					<h5 class="name"><?php echo $key['usuario'] ?></h5>
					<p class="date"><?php echo $key['fecha_comentario'] ?></p>
					<div class="review-rating">
					<?php 
					for ($i=1; $i <= 5 ; $i++) { 
					if($key['cantidad_estrella'] >= $i){
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
				</div>
				<div class="review-body">
					<p><?php echo $key['comentario'] ?></p>
				</div>
			</li>
			<?php } ?>
		</ul>

		<ul class="reviews-pagination">
		<?php
		 if($paginaNumero > 1){ 
		?>
			<li><a href="#" 
				   id="paginadorAtras"
				   data-idProducto="<?php echo $idProducto ?>"
				   data-paginaNumero="<?php echo $paginaNumero-1; ?>"
				   data-cantidadPagina="<?php echo $cantidadPagina ?>"
				><i class="fa fa-angle-left"></i>
				</a>
			</li>
		<?php
		}
		 
		for($i=$pagInicio; $i<=$pagFin; $i++) {
			if($i == $paginaNumero){
		?>
				<li class="active" style="color: #fff;"><?php echo $i ?></li>
		<?php
			}else{
		?>
				<li><a href="#" 
					   id="paginadorI" 
					   data-idProducto="<?php echo $idProducto ?>"
					   data-paginaNumero="<?php echo $i ?>"
					   data-cantidadPagina="<?php echo $cantidadPagina ?>"
					><?php echo $i ?>
					</a>
				</li>
		<?php
			}
		}

		 if($paginaNumero < $totalPag){
		 ?>
				<li><a href="#" 
					   id="paginadorAdelante" 
					   data-idProducto="<?php echo $idProducto ?>"
					   data-paginaNumero="<?php echo $paginaNumero+1; ?>" 
					   data-cantidadPagina="<?php echo $cantidadPagina ?>"
					><i class="fa fa-angle-right"></i>
					</a>
				</li>
		 <?php } ?>
		</ul>
	</div>
</div>
<!-- /Reviews -->
<?php 
	}else{
		?>
		<div class="col-md-6">
		<div id="reviews">
		<ul class="reviews">
			<?php if(isset($_SESSION['idUsuario'])){ ?>
			<p>Se el primero en dejar un comentario</p>
			<?php } ?>
		</ul>
		</div>
		</div>
		<?php
	}
 ?>

 <script type="text/javascript">
 	$(document).ready(function(){

	 	$(".reviews-pagination li a").click(function(e){
	 		e.preventDefault();
	 		var idProducto = $(this).attr("data-idProducto");
	 		var cantidadPagina = $(this).attr("data-cantidadPagina");
	 		var paginaNumero = $(this).attr("data-paginaNumero");
	 		ventanaEncuestaComentario(idProducto,cantidadPagina,paginaNumero);
	 	});

	});
 </script>

