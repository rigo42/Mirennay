<?php 
	include('conexion.php');

	if(isset($_GET['id_proveedor']) AND ($_GET['id_proveedor'] != "")){

		$id_proveedor = mysqli_real_escape_string($conexion,$_GET['id_proveedor']);

		$sqlProveedor ="SELECT edo.*, m.*, p.*, e.*, p.direccion AS 'pDireccion',p.celular AS 'pCelular', p.observacion AS 'pObservacion', p.activo AS 'pActivo'
						FROM proveedor p 
						INNER JOIN empresa e ON e.id_empresa = p.id_empresa 
						INNER JOIN municipio m ON m.id_municipio = p.id_municipio
						INNER JOIN estado edo ON edo.id_estado = m.id_estado
						WHERE id_proveedor = ".$id_proveedor;
		$resProveedor = mysqli_query($conexion,$sqlProveedor);	

		    

		$sqlEmpresa = "SELECT * FROM empresa WHERE activo = 1";
		$resEmpresa = mysqli_query($conexion,$sqlEmpresa);

		$sqlEstado = "SELECT * FROM estado";
		$resEstado = mysqli_query($conexion,$sqlEstado);
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
					<li><a href="administrador.php?admin=proveedor">Proveedor</a></li>
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
						<h3 class="title">Datos de la proveedor</h3>
					</div>
						<form id="form">
							<?php 
								foreach ($resProveedor as $key) {
							 ?>
							<div class="form-group">
								<select class="input-select" required="" name="id_empresa">
									<?php 
									foreach ($resProveedor as $key) {
									 ?>
									<option value="<?php echo $key['id_empresa'] ?>"><?php echo $key['empresa'] ?></option>
									<?php } ?>

									<?php 
										foreach ($resEmpresa as $key) {
									 ?>
									 <option value="<?php echo $key['id_empresa'] ?>"><?php echo $key['empresa'] ?></option>
									<?php } ?>
								</select>
							</div>
							<div class="form-group">
								<select class="input-select" required="" name="id_estado">
									<?php 
									foreach ($resProveedor as $key) {
									 ?>
									<option value="<?php echo $key['id_estado'] ?>"><?php echo $key['estado'] ?></option>
									<?php } ?>
									<?php 
										foreach ($resEstado as $key) {
									 ?>
									 <option value="<?php echo $key['id_estado'] ?>"><?php echo $key['estado'] ?></option>
									<?php } ?>
								</select>
							</div>
							<div class="form-group">
								<select class="input-select" required="" name="id_municipio">
									<?php 
									foreach ($resProveedor as $key) {
									 ?>
									<option value="<?php echo $key['id_municipio'] ?>"><?php echo $key['municipio'] ?></option>
									<?php } ?>
									<div id="municipios"></div>
								</select>
							</div>
							<div class="form-group">
							<input class="input" type="text" name="proveedor" placeholder="Nombre del proveedor"  required="" value="<?php echo $key['proveedor'] ?>">
							</div>
							<div class="form-group">
								<input class="input" type="text" name="direccion" placeholder="Dirección"  required="" value="<?php echo $key['pDireccion'] ?>">
							</div>
							<div class="form-group">
								<input class="input" type="tel" name="codigo_postal" placeholder="codigo postal" required="" maxlength="5" value="<?php echo $key['codigo_postal'] ?>">
							</div>
							<div class="form-group">
								<input class="input" type="tel" name="celular" placeholder="Celular" required="" maxlength="10" value="<?php echo $key['pCelular'] ?>">
							</div>
							
							<div class="form-group">
									<div class="">
										<p>Observación</p>
										<div class="order-notes">
											<textarea class="input" placeholder="Otras notas" name="observacion" ><?php echo $key['pObservacion'] ?></textarea>
										</div>
									</div>
							</div>

							<div class="form-group">
								<select class="input-select" name="activo">
									<?php 
										if($key['pActivo'] == 0){
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
							<input type="hidden" name="id_proveedor" value="<?php echo $id_proveedor ?>">
							<!-- actividad para poderla mandar al servlet y que pueda entrar a la de editar -->
							<input type="hidden" name="actividad" value="editar">
							
							<?php } ?>
							<button type="submit" class="primary-btn order-submit nuevo" style="width: 100%;">Editar proveedor</button> 
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

		$("select[name='id_estado']").change(function(){
			var id_estado = $(this).val();
			$("select[name='id_municipio']").html("<option>Espere...</option>");
			$.post('include/selectMunicipioInclude.php',{
				id_estado:id_estado
			},function(data){
				$("select[name='id_municipio']").html(data);
			});
		});

		$("#form").submit(function(e){
			e.preventDefault();
			var celular = $("input[name='celular']").val();

			 if(!/^([0-9])*$/.test(celular)){
		      alert("El valor " + celular + " No es un número, utilize un número valido");
			  }else{
			  	var datos = $(this).serialize();
				$.ajax({
					type:'POST',
					url:'include/servletProveedorInclude.php',
					data:datos,
					beforeSend : function(){
						$(".nuevo").html("<img src='gif/espere.gif'>");
					},success: function(data){
						if(data == "1"){
							document.getElementById("form").reset();
							$(".nuevo").html("Nueva proveedor");
							Push.create("Aviso",{
								body: "proveedor editado con exito",
								timeout: 4000,
								icon: 'img//M.png'
							});
							location="administrador.php?admin=proveedor";
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
		echo "<div class='container'><h3>No se puede identificar el proveedor a editar</h3></div>";
	}
 ?>