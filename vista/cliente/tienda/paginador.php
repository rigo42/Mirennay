<input type="hidden" name="idCategoria" value="<?php echo $idCategoria ?>">
<input type="hidden" name="precioMin" value="<?php echo $precioMin ?>">
<input type="hidden" name="precioMax" value="<?php echo $precioMax ?>">
<input type="hidden" name="idGenero" value="<?php echo $idGenero ?>">
<input type="hidden" name="cantidadPagina" value="<?php echo $cantidadPagina ?>">

<!-- store bottom filter -->
<div class="store-filter clearfix">
	<span class="store-qty">Mirando <?php echo $cantidadPagina; ?> de <?php echo $rowCount; ?> productos</span>
		<ul class="store-pagination">
<?php
 if($paginaNumero > 1){ 
?>
		<li class="paginador" data-paginaNumero="<?php echo $paginaNumero-1 ?>"><a href="#"><i class="fa fa-angle-left"></i></a></li>
<?php
}
 
for($i=$pagInicio; $i<=$pagFin; $i++) {
	if($i == $paginaNumero){
		?>
			<li class="active" ><a style="color: #fff;" href="#"><?php echo $i ?></a></li>
		<?php
	}else{
		?>
			<li class="paginador" data-paginaNumero="<?php echo $i ?>"><a href="#"><?php echo $i ?></a></li>
		<?php
	}
}

 if($paginaNumero < $totalPag){
 ?>
		<li class="paginador" data-paginaNumero="<?php echo $paginaNumero+1 ?>"><a href="#"><i class="fa fa-angle-right"></i></a></li>
 <?php } ?>

	</ul>
</div>	
<!-- /store bottom filter -->
<script type="text/javascript">
	$(document).ready(function(){
		$(".paginador").click(function(e){
			e.preventDefault();
			var paginaNumero = $(this).attr("data-paginaNumero");
			var idCategoria = $("input[name='idCategoria']").val();
			var precioMin = $("input[name='precioMin']").val();
			var precioMax = $("input[name='precioMax']").val();
			var idGenero = $("input[name='idGenero']").val();
			var cantidadPagina = $("input[name='cantidadPagina']").val();
			var idSubCategoria = <?php echo json_encode($idSubCategoria) ?>;
			paginadorProducto("",idCategoria,precioMin,precioMax,idGenero,idSubCategoria,cantidadPagina,paginaNumero);
		});
	});
</script>
