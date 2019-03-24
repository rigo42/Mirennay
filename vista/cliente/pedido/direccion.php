<!-- Billing Details -->
<div class="billing-details">
	<div class="section-title">
		<h3 class="title">Dirección</h3>
	</div>
	<form id="formPedido" data-actividad="direccion">
		<div class="form-group">
			<select class="input-select" name="idUsuarioDetalle" required="">
				<?php foreach ($res as $key) { ?>
				<option value="<?php echo openssl_encrypt($key['id_usuario_detalle'], COD, KEY) ?>"><?php echo $key['direccion'] ?> | <?php echo $key['municipio'] ?> | <?php echo $key['estado'] ?></option>
				<?php } ?>
			</select>
		</div>
	</form>
</div>
<!-- /Billing Details -->
 