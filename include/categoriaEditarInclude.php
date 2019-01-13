<?php 
	include('conexion.php');
	if(isset($_GET['id_categoria']) AND ($_GET['id_categoria'] != "")){
		$id_categoria = mysqli_real_escape_string($conexion,$_GET['id_categoria']);
		$sql = "SELECT * FROM categoria WHERE id_categoria = ".$id_categoria;
		$categoria = mysqli_query($conexion,$sql);	
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
					<li><a href="administrador.php?admin=categoria">categorias</a></li>
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
						<h3 class="title">Datos de la categoria</h3>
					</div>
						<form id="form">
							<?php 
								foreach ($categoria as $key) {
							 ?>
							<div class="form-group">
							<input class="input" type="text" name="categoria" placeholder="Nombre de la categoria"  required="" value="<?php echo $key['categoria'] ?>">
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

							<!-- id_categoria para poderla editar -->
							<input type="hidden" name="id_categoria" value="<?php echo $id_categoria ?>">
							<!-- actividad para poderla mandar al servlet y que pueda entrar a la de editar -->
							<input type="hidden" name="actividad" value="editar">
							
							<?php } ?>
							<button type="submit" class="primary-btn order-submit editar" style="width: 100%;">Editar categoria</button> 
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
					url:'include/servletCategoriaInclude.php',
					data:datos,
					beforeSend : function(){
						$(".editar").html("<img src='gif/espere.gif'>");
					},success: function(data){
						if(data == "1"){
							$(".editar").html("Editar categoria");
							Push.create("Aviso",{
								body: "categoria editada con exito",
								timeout: 4000,
								icon: 'img//M.png'
							});
							location="administrador.php?admin=categoria";
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
		echo "<div class='container'><h3>No se puede identificar la categoria a editar</h3></div>";
	}
 ?>