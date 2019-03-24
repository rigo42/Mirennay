<div class="section-title text-center">
	<h3 class="title">Tu orden</h3>
</div>
<div class="order-summary">
	<div class="order-col">
		<div><strong>PRODUCTO</strong></div>
		<div><strong>TOTAL</strong></div>
	</div>

	<div class="order-products">
	<?php 
	$subTotal = 0;
	$subTotalNeto = 0;
	for ($i=0; $i<count($carrito); $i++) { 
		$subTotal = $carrito[$i]['precio'] * $carrito[$i]['idProductoDetalleCantidad'];
		$subTotalNeto += $subTotal;
	 ?>
		<div class="order-col">
			<div>Cant. <?php echo $carrito[$i]['idProductoDetalleCantidad'] ?> <?php echo $carrito[$i]['producto'] ?> <?php echo $carrito[$i]['color'] ?></div>
			<div>$<?php echo $subTotal ?> MXN</div>
		</div>
	<?php } ?>
	</div>

	<div class="order-col">
		<div>Envio</div>
		<div><strong>GRATIS</strong></div>
	</div>
	<div class="order-col">
		<div><strong>TOTAL</strong></div>
		<div><strong class="order-total">$<?php echo $subTotalNeto ?>.00 MXN</strong></div>
	</div>
</div>
<div class="payment-method">
<!--
	<div class="input-radio">
		<input type="radio" name="payment" id="payment-1" data-metodo="banco">
		<label for="payment-1">
			<span></span>
			Direct Bank Transfer
		</label>
		<div class="caption">
			<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
		</div>
	</div>

	<div class="input-radio">
		<input type="radio" name="payment" id="payment-2" data-metodo="deposito">
		<label for="payment-2">
			<span></span>
			Deposito
		</label>
		<div class="caption">
			<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
		</div>
	</div>
-->
	<div class="input-radio">
		<input type="radio" name="payment" id="payment-3" data-metodo="paypal">
		<label for="payment-3">
			<span></span>
			Paypal
		</label>
		<div class="caption">
			<p>La forma mas segura de pagar online</p>
		</div>
	</div>
</div>
<div class="input-checkbox">
	<input type="checkbox" id="terms">
	<label for="terms">
		<span></span>
		he leido y acepto los <a href="#">terminos y condiciones</a>
	</label>
	<p id="validarTerminosCondiciones" style="color: red;"></p>
</div>
<div id="validarFormPedido">
	<!-- <a href="#" class="primary-btn order-submit" id="validarFormPedido">Place order</a> -->
</div>
<input type="hidden" name="subTotalNeto" id="subTotalNeto" value="<?php echo $subTotalNeto ?>">

<script type="text/javascript">
	$(document).ready(function(){

		var metodo = "";
		var direccion = "";

		$(".input-radio").children("input").click(function(e){
			metodo = $(this).attr("data-metodo");
			$("#validarFormPedido").load("vista/cliente/pedido/"+metodo+".php");
		}); 

		//Aceptar termino y condiciones
		$("#terms").change(function(){
			if(metodo != ""){
				if(!$("#terms").prop("checked")){
					$("#validarFormPedido").html("");
				}else{
					$("#validarFormPedido").load("vista/cliente/pedido/"+metodo+".php");
				}
			}
		});	

		$("#shiping-address").change(function(){
			if(metodo != ""){
				if(!$("#terms").prop("checked")){
					$("#validarFormPedido").html("");
				}else{
					$("#validarFormPedido").load("vista/cliente/pedido/"+metodo+".php");
				}
			}
		});	

		$("#validarFormPedido").click(function(e){
			e.preventDefault();
			if($("#terms").prop("checked")){
				$("#validarTerminosCondiciones").html("");
				if($("#shiping-address").prop("checked")){
					direccion = $("#formPedidoDiferente").serialize();
					direccion += "&actividad=direccionNueva";
				}else{
					var actividad = $("#formPedido").attr("data-actividad");
					direccion = $("#formPedido").serialize();
					direccion += "&actividad="+actividad;
				}
				validarFormPedido(direccion,metodo);
			}else{
				$("#validarTerminosCondiciones").html("Asegurate de aceptar los terminos y condiciones");
			}
		});

	});	
</script>