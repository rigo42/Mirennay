<!-- Billing Details -->
<div class="billing-details">
	<div class="section-title">
		<h3 class="title">Nueva dirección</h3>
	</div>
	<form id="formPedido" data-actividad="direccionNueva">
		<div class="form-group">
			<input maxlength="200" required="" class="input" type="text" name="nombreCompleto" placeholder="Nombre completo">
		</div>
		<div class="form-group">
			<input maxlength="200" required="" class="input" type="text" name="direccion" placeholder="Direccion">
		</div> 
		
		<div class="form-group">
			<?php $res = $this->estado(); ?>
			<select class="input-select" name="idEstado">
				<?php foreach ($res as $key) { ?>
				<option value="<?php echo openssl_encrypt($key['id_estado'], COD, KEY) ?>"><?php echo $key['estado'] ?></option>
				<?php } ?>
			</select>
		</div>
		<div class="form-group">
			<select class="input-select" name="idMunicipio">
			</select>
		</div>
		<div class="form-group">
			<input maxlength="200" required="" class="input" type="text" name="codigoPostal" placeholder="Codigo postal">
		</div>
		<div class="form-group">
			<input maxlength="200" required="" class="input" type="tel" name="celular" placeholder="Celular">
		</div>
		<!-- Order notes -->
		<div class="order-notes">
			<textarea class="input" name="observacion" placeholder="Otras notas" maxlength="200"></textarea>
		</div>
		<!-- /Order notes -->
	</form>
</div>
<!-- /Billing Details -->

