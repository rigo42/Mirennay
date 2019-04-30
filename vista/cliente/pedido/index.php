<?php 
	$carrito = $_SESSION['carrito'];
 ?>
<!-- BREADCRUMB -->
<div id="breadcrumb" class="section">
	<!-- container -->
	<div class="container">
		<!-- row -->
		<div class="row">
			<div class="col-md-12">
				<h3 class="breadcrumb-header">Checkout</h3>
				<ul class="breadcrumb-tree">
					<li><a href="<?php echo URL ?>">Inicio</a></li>
					<li class="active">Checkout</li>
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

			<div class="col-md-7">
				<?php 
					$res = $this->perfilControlador->direccion();
					if($res->rowCount() > 0){
						include('vista/cliente/pedido/direccion.php');
						include('vista/cliente/pedido/direccionDiferente.php');
					}else{
						include('vista/cliente/pedido/direccionNueva.php');
					}
				 ?>
			</div>

			<!-- Order Details -->
			<div class="col-md-5 order-details">
				<?php include('vista/cliente/pedido/pedido.php'); ?>
			</div>
			<!-- /Order Details -->
		</div>
		<!-- /row -->
	</div>
	<!-- /container -->
</div>
<!-- /SECTION -->

<script type="text/javascript">
	$(document).ready(function(){

		tittlePage("","Pedido");

		var idEstado = $("select[name='idEstado']").val();
		municipio(idEstado);

		$("select[name='idEstado']").change(function(){
			var idEstado = $(this).val();
			municipio(idEstado);
		});
		
	});

</script>