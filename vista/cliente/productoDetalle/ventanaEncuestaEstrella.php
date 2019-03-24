<div class="col-md-3">
	<div id="rating">
		<div class="rating-avg">
			<span><?php echo $estrellas ?></span>
				<div class="rating-stars">
					<?php 
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
		</div>
		<ul class="rating">
			<?php 
				for ($i=5; $i >= 1; $i--) { 
					$res = $this->productoEstrellaModelo->ventanaEncuestaEstrellaEscalera($i,$idProducto);
					foreach ($res as $key) {
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