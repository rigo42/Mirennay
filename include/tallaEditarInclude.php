<?php 
	include('conexion.php');
	if(isset($_GET['id_talla']) AND ($_GET['id_talla'] != "")){
		$id_talla = mysqli_real_escape_string($conexion,$_GET['id_talla']);
		$sql = "SELECT * FROM producto_talla WHERE id_talla = ".$id_talla;
		$talla = mysqli_query($conexion,$sql);	
 ?>
<!-- BREADCRUMB -->
<div id="breadcrumb" class="section">
	<!-- container -->
	<div class="container">
		<!-- row -->
		<div class="row">
			<div class="col-md-12">
				<h3 class="breadcrumb-header">Administrador</h3>
				<ul class="breadcrumb-tree">
					<li><a href="administrador.php?admin=talla">Tallas</a></li>
					<li class="active">Editar</li>
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

			<div class="col-md-5">
				<!-- Billing Details -->
				<div class="billing-details">
					<div class="section-title">
						<h3 class="title">Datos de la talla</h3>
					</div>
						<form id="form">
							<?php 
								foreach ($talla as $key) {
							 ?>
							<div class="form-group">
							<input class="input" type="text" name="talla" placeholder="Nombre de la talla"  required="" value="<?php echo $key['talla'] ?>">
							</div>
							<div class="form-group">
								<select class="input-select" name="activo">
									<?php 
										if($key['activo'] == 0){
											?>
											<option value="0">Baja</option>
											<option value="1">Activo</option>
											<?php
										}else{
											?>
											<option value="1">Activo</option>
											<option value="0">Baja</option>
											<?php
										}
									 ?>
									
								</select>
							</div>

							<!-- id_talla para poderla editar -->
							<input type="hidden" name="id_talla" value="<?php echo $id_talla ?>">
							<!-- actividad para poderla mandar al servlet y que pueda entrar a la de editar -->
							<input type="hidden" name="actividad" value="editar">
							
							<?php } ?>
							<button type="submit" class="primary-btn order-submit editar" style="width: 100%;">Editar talla</button> 
						</form>
				</div>

				<!-- /Billing Details -->
			</div>

		</div>
		<!-- /row -->
	</div>
	<!-- /container -->
</div>
<!-- /SECTION -->

<script type="text/javascript">

	$(document).ready(function(e){
		$("#form").submit(function(e){
			e.preventDefault();
			
			  	var datos = $(this).serialize();
				$.ajax({
					type:'POST',
					url:'include/servletTallaInclude.php',
					data:datos,
					beforeSend : function(){
						$(".editar").html("<img src='gif/espere.gif'>");
					},success: function(data){
						if(data == "1"){
							$(".editar").html("Editar talla");
							Push.create("Aviso",{
								body: "talla editada con exito",
								timeout: 4000,
								icon: 'img//M.png'
							});
							location="administrador.php?admin=talla";
						}else{
							alert(data);
						}
					}
				}); 
		});
	});

</script>

<?php 
	}else{
		echo "<div class='container'><h3>No se puede identificar la talla a editar</h3></div>";
	}
 ?>