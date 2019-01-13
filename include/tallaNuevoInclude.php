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
					<li class="active">Nuevo</li>
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
							<div class="form-group">
							<input class="input" type="text" name="talla" placeholder="Nombre de la talla"  required="">
							</div>
							<!-- actividad para poderla mandar al servlet y que pueda entrar a la de nuevo -->
							<input type="hidden" name="actividad" value="nuevo">

							<button type="submit" class="primary-btn order-submit nuevo" style="width: 100%;">Nueva talla</button> 
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
						$(".nuevo").html("<img src='gif/espere.gif'>");
					},success: function(data){
						if(data == "1"){
							document.getElementById("form").reset();
							$(".nuevo").html("Nueva talla");
							Push.create("Aviso",{
								body: "talla añadida con exito",
								timeout: 4000,
								icon: 'img//M.png'
							});
						}else{
							alert(data);
						}
					}
				}); 
		});
	});

</script>