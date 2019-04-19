<!-- store bottom filter -->
<div class="store-filter clearfix">
	<span class="store-qty">Mirando <?php echo $cantidadPagina; ?> de <?php echo $rowCount; ?> productos</span>
		<ul class="store-pagination">
<?php
 if($paginaNumero > 1){ 
?>
		<li><a href="#" onclick='paginadorProducto("","<?php echo $idCategoria ?>","<?php echo $precioMin ?>","<?php echo $precioMax ?>","<?php echo $idGenero ?>",<?php print_r($idSubCategoriaArray); ?>,<?php echo $cantidadPagina;  ?>, <?php echo $paginaNumero-1; ?>);'><i class="fa fa-angle-left"></i></a></li>
<?php
}
 
for($i=$pagInicio; $i<=$pagFin; $i++) {
	if($i == $paginaNumero){
		?>
			<li class="active" ><a style="color: #fff;" href="#"><?php echo $i ?></a></li>
		<?php
	}else{
		?>
			<li><a href="#"  onclick='paginadorProducto("","<?php echo $idCategoria ?>","<?php echo $precioMin ?>","<?php echo $precioMax ?>","<?php echo $idGenero ?>",<?php print_r($idSubCategoriaArray); ?>,<?php echo $cantidadPagina;  ?>, <?php echo $i; ?>);'><?php echo $i ?></a></li>
		<?php
	}
}

 if($paginaNumero < $totalPag){
 ?>
		<li><a href="#" onclick='paginadorProducto("","<?php echo $idCategoria ?>","<?php echo $precioMin ?>","<?php echo $precioMax ?>","<?php echo $idGenero ?>",<?php print_r($idSubCategoriaArray); ?>,<?php echo $cantidadPagina;  ?>, <?php echo $paginaNumero+1; ?>);'><i class="fa fa-angle-right"></i></a></li>
 <?php } ?>

	</ul>
</div>	
<!-- /store bottom filter -->
<?php