<?php 
	include('conexion.php');
	if(isset($_GET['id_empresa']) AND ($_GET['id_empresa'] != "")){
		$id_empresa = mysqli_real_escape_string($conexion,$_GET['id_empresa']);
		$sql = "SELECT * FROM empresa WHERE id_empresa = ".$id_empresa;
		$empresa = mysqli_query($conexion,$sql);	
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
					<li><a href="administrador.php?admin=empresa">Empresas</a></li>
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
						<h3 class="title">Datos de la empresa</h3>
					</div>
						<form id="form">
							<?php 
								foreach ($empresa as $key) {
							 ?>
							<div class="form-group">
							<input class="input" type="text" name="empresa" placeholder="Nombre de la empresa"  required="" value="<?php echo $key['empresa'] ?>">
							</div>
							<div class="form-group">
								<input class="input" type="tel" name="celular" placeholder="Celular" required="" maxlength="10" value="<?php echo $key['celular'] ?>">
							</div>
							<div class="form-group">
								<input class="input" type="text" name="direccion" placeholder="Dirección"  required="" value="<?php echo $key['direccion'] ?>">
							</div>
							<div class="form-group">
								<div class="input-checkbox">
									<div class="">
										<p>Observación</p>
										<div class="order-notes">
											<textarea class="input" placeholder="Otras notas" name="observacion" ><?php echo $key['observacion'] ?></textarea>
										</div>
									</div>
								</div>
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

							<!-- id_empresa para poderla editar -->
							<input type="hidden" name="id_empresa" value="<?php echo $id_empresa ?>">
							<!-- actividad para poderla mandar al servlet y que pueda entrar a la de editar -->
							<input type="hidden" name="actividad" value="editar">
							
							<?php } ?>
							<button type="submit" class="primary-btn order-submit editar" style="width: 100%;">Editar empresa</button> 
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
						$(".editar").html("<img src='gif/espere.gif'>");
					},success: function(data){
						if(data == "1"){
							document.getElementById("form").reset();
							$(".editar").html("Editar empresa");
							Push.create("Aviso",{
								body: "Empresa editada con exito",
								timeout: 4000,
								icon: 'img//M.png'
							});
							location="administrador.php?admin=empresa";
						}else{
							alert(data);
						}
					}
				}); 
			  }
		});
	});

</script>

<?php 
	}else{
		echo "<div class='container'><h3>No se puede identificar la empresa a editar</h3></div>";
	}
 ?>