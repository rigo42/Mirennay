<!-- BREADCRUMB -->
<div id="breadcrumb" class="section">
	<!-- container -->
	<div class="container">
		<!-- row -->
		<div class="row">
			<div class="col-md-12">
				<h3 class="breadcrumb-header">Administrador</h3>
				<ul class="breadcrumb-tree">
					<li><a href="administrador.php?admin=empresa">Empresas</a></li>
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
						<h3 class="title">Datos de la empresa</h3>
					</div>
						<form id="form">
							<div class="form-group">
							<input class="input" type="text" name="empresa" placeholder="Nombre de la empresa"  required="">
							</div>
							<div class="form-group">
								<input class="input" type="tel" name="celular" placeholder="Celular" required="" maxlength="10">
							</div>
							<div class="form-group">
								<input class="input" type="text" name="direccion" placeholder="Dirección"  required="">
							</div>
							<div class="form-group">
								<div class="input-checkbox">
									<input type="checkbox" id="observacion">
									<label for="observacion">
										<span></span>
										¿Agregar observaciones?
									</label>
									<div class="caption">
										<p>Observación</p>
										<div class="order-notes">
											<textarea class="input" placeholder="Otras notas" name="observacion" ></textarea>
										</div>
									</div>
								</div>
							</div>

							<!-- actividad para poderla mandar al servlet y que pueda entrar a la de nuevo -->
							<input type="hidden" name="actividad" value="nuevo">

							<button type="submit" class="primary-btn order-submit nuevo" style="width: 100%;">Nueva empresa</button> 
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
			var celular = $("input[name='celular']").val();

			 if(!/^([0-9])*$/.test(celular)){
		      alert("El valor " + celular + " No es un número, utilize un número valido");
			  }else{
			  	var datos = $(this).serialize();
				$.ajax({
					type:'POST',
					url:'include/servletEmpresaInclude.php',
					data:datos,
					beforeSend : function(){
						$(".nuevo").html("<img src='gif/espere.gif'>");
					},success: function(data){
						if(data == "1"){
							document.getElementById("form").reset();
							$(".nuevo").html("Nueva empresa");
							Push.create("Aviso",{
								body: "Empresa añadida con exito",
								timeout: 4000,
								icon: 'img//M.png'
							});
						}else{
							alert(data);
						}
					}
				}); 
			  }
		});
	});

</script>