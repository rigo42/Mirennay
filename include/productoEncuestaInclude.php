<?php 
	include('conexion.php');
	$id_producto = $_POST['id_producto'];
	$sqlEstrella = " SELECT count(id_producto_comentario) as 'cantidadEstrella',sum(cantidad_estrella) as 'sumaEstrella'
     				 FROM producto_comentario
     				 WHERE 1 AND activo = 1 AND id_producto = ".$id_producto;
    $resEstrella = mysqli_query($conexion,$sqlEstrella);
    foreach ($resEstrella as $keyEstrella ) {
    	$personas = $keyEstrella['cantidadEstrella'];
    	if($keyEstrella['sumaEstrella'] == 0){
    		$estrellas = 0;
    	}else if($keyEstrella['cantidadEstrella'] == 0){
    		$estrellas = 0;
    	}else{
    		$estrellas = round($keyEstrella['sumaEstrella'] / $keyEstrella['cantidadEstrella'],0);
    	}
    	
    }
 ?>
<div class="col-md-3">
	<div id="rating">
		<div class="rating-avg">
			<span><?php echo $estrellas ?></span>
				<div class="rating-stars">
					<?php 
						if($personas > 0){
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
							?>	
							<i class="fa fa-star-o"></i>
							<i class="fa fa-star-o"></i>
							<i class="fa fa-star-o"></i>
							<i class="fa fa-star-o"></i>
							<i class="fa fa-star-o"></i>		
							<?php
						}
					
				 ?>
			    </div>
		</div>
		<ul class="rating">
			<?php 
				for ($i=5; $i >= 1; $i--) { 
					$sqlEstrella = " SELECT count(id_producto_comentario) as 'cantidadEstrella'
     				 FROM producto_comentario
     				 WHERE 1 AND activo = 1 AND cantidad_estrella = ".$i." AND id_producto = ".$id_producto ;
					$resEstrella = mysqli_query($conexion,$sqlEstrella);
					foreach ($resEstrella as $key) {
						$cantidadEstrella = $key['cantidadEstrella'];
					}
					if($cantidadEstrella > 0){
						$estrellasPorciento = round(($cantidadEstrella * 100) / $personas,0);
					}else{
						$estrellasPorciento = 0;
					}
					?>
					<li>
						<div class="rating-stars">
				        <?php
				    	for ($j=1; $j <= 5 ; $j++) { 
				    		if($i < $j){
				    		?>
								<i class="fa fa-star-o"></i>
				    		<?php
				    		}else{
				    		?>
							  <i class="fa fa-star"></i>		
				    		<?php
				    		}
				    	}
				    	//echo $i;
				    	?>
						</div>
							<div class="rating-progress">
								<div style="width:<?php echo $estrellasPorciento ?>%;"></div>
							</div>
							<span class="sum"><?php echo $cantidadEstrella ?></span>
					</li>
				    	<?php
				}								
			 ?>
		</ul>
	</div>
</div>
<script type="text/javascript">
	$("#cantidadComentarios").html("Comentarios <?php echo $personas ?>");
	$("#cantidadComentarios2").html("Comentarios <?php echo $personas ?>");
</script>