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
						<h3 class="title">Datos de la categoria</h3>
					</div>
						<form id="form">
							<div class="form-group">
							<input class="input" type="text" name="categoria" placeholder="Nombre de la categoria"  required="">
							</div>
							<!-- actividad para poderla mandar al servlet y que pueda entrar a la de nuevo -->
							<input type="hidden" name="actividad" value="nuevo">

							<button type="submit" class="primary-btn order-submit nuevo" style="width: 100%;">Nueva categoria</button> 
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
						$(".nuevo").html("<img src='gif/espere.gif'>");
					},success: function(data){
						if(data == "1"){
							document.getElementById("form").reset();
							$(".nuevo").html("Nueva categoria");
							Push.create("Aviso",{
								body: "categoria añadida con exito",
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