<?php 
	include('conexion.php');
	if(isset($_SESSION['idUsuario'])){
		if(isset($_SESSION['carrito']) && count($_SESSION['carrito']) > 0){
			$subTotal = 0;
			$datos = $_SESSION['carrito'];

			$sqlUsuario = " SELECT u.*,ud.*,m.*,e.* FROM usuario u
					INNER JOIN usuario_detalle ud ON ud.id_usuario = u.id_usuario
					INNER JOIN municipio m ON m.id_municipio = ud.id_municipio 
					INNER JOIN estado e ON e.id_estado = m.id_estado
					WHERE u.activo = 1 AND ud.activo = 1 AND u.id_usuario = ".$_SESSION['idUsuario']."
					ORDER BY ud.direccion";
			$resUsuario = mysqli_query($conexion,$sqlUsuario);
			$rowUsuario = mysqli_num_rows($resUsuario);

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
				<h3 class="breadcrumb-header">Checkout</h3>
				<ul class="breadcrumb-tree">
					<li><a href="index.php">Inicio</a></li>
					<li class="active">Pedido	</li>
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

			<div class="col-md-7">
				<?php 
					if($rowUsuario == 0){
				 ?>
				<!-- Billing Details -->
				<div class="billing-details">
					<div class="section-title">
						<h3 class="title">Dirección</h3>
					</div>
					<form id="formNuevo">
					<input type="checkbox" id="shiping-address" value="nuevaDireccion" checked="" style="display: none;">
					<div class="form-group">
					<input class="input" type="text" name="nombre_completo" placeholder="Nombre completo" required="">
					</div>
					<div class="form-group">
						<select class="input-select" required="" name="id_estado">
							<option>Seleccione el estado</option>
							<?php 
								foreach ($resEstado as $keyEstado) {
							 ?>
							 <option value="<?php echo $keyEstado['id_estado'] ?>"><?php echo $keyEstado['estado'] ?></option>
							<?php } ?>
						</select>
					</div>
					<div class="form-group">
						<select class="input-select" required="" name="id_municipio">
							<option>Seleccione el municipio</option>
							<div id="municipios"></div>
						</select>
					</div>
					<div class="form-group">
						<input class="input" type="text" name="direccion" placeholder="Calle, Colonia, #Numero" required="">
					</div>
					<div class="form-group">
						<input class="input" type="text" name="codigo_postal" placeholder="Codigo postal" required="">
					</div>
					<div class="form-group">
						<input class="input" type="tel" name="celular" placeholder="Celular 10 digitos" required="">
					</div>
					<!-- Order notes -->
					<div class="order-notes">
						<textarea class="input" placeholder="Order Notes" name="observacion"></textarea>
					</div>
					<!-- /Order notes -->
					</form>
				</div>
				<!-- /Billing Details -->
				<?php 
				}else{
				?>
			
				<form id="formPedido">
				<div class="billing-details">
					<div class="section-title">
						<h3 class="title">Seleccione la dirección</h3>
					</div>
					<div class="form-group">
						<select class="input-select" required="" name="idUsuarioDetalle">
							<?php foreach ($resUsuario as $keyUsuario) { ?>
							<option value="<?php echo $keyUsuario['id_usuario_detalle'] ?>"><?php echo $keyUsuario['direccion'] ?> | <?php echo $keyUsuario['municipio'] ?> | <?php echo $keyUsuario['estado'] ?></option>
							<?php } ?>
						</select>
					</div>
				</div>
				</form>

				<!-- Shiping Details -->
				<div class="shiping-details">
					<div class="section-title">
						<h3 class="title">¿Otra dirección diferente?</h3>
					</div>
					<div class="input-checkbox">
						<input type="checkbox" id="shiping-address">
						<label for="shiping-address">
							<span></span>
							Enviar a otra dirección
						</label>
						<div class="caption">
							<form id="formNuevo">
								<div class="form-group">
									<input class="input" type="text" name="nombre_completo" placeholder="Nombre completo" required="">
								</div>
								<div class="form-group">
									<select class="input-select" required="" name="id_estado">
										<option>Seleccione el estado</option>
										<?php 
											foreach ($resEstado as $keyEstado) {
										 ?>
										 <option value="<?php echo $keyEstado['id_estado'] ?>"><?php echo $keyEstado['estado'] ?></option>
										<?php } ?>
									</select>
								</div>
								<div class="form-group">
									<select class="input-select" required="" name="id_municipio">
										<option>Seleccione el municipio</option>
										<div id="municipios"></div>
									</select>
								</div>
								<div class="form-group">
									<input class="input" type="text" name="direccion" placeholder="Calle, Colonia, #Numero" required="">
								</div>
								<div class="form-group">
									<input class="input" type="text" name="codigo_postal" placeholder="Codigo postal" required="">
								</div>
								<div class="form-group">
									<input class="input" type="tel" name="celular" placeholder="Celular 10 digitos" required="">
								</div>
								<!-- Order notes -->
								<div class="order-notes">
									<textarea class="input" placeholder="Order Notes" name="observacion"></textarea>
								</div>
								<!-- /Order notes -->
							</form>
						</div>
					</div>
				</div>
				<!-- /Shiping Details -->
				
				<?php
				} 
				?>
			</div>

			<!-- Order Details -->
			<div class="col-md-5 order-details">
				<div class="section-title text-center">
					<h3 class="title">Tu orden</h3>
				</div>

				<div class="order-summary">
					<div class="order-col">
						<div><strong>PRODUCT</strong></div>
						<div><strong>TOTAL</strong></div>
					</div>
					<?php 
						for ($i=0; $i<count($datos); $i++) { 
							$sqlCarrito = " SELECT SUM(pd.cantidad) AS 'sumaCantidad',p.*,pd.* 
											FROM producto p
											INNER JOIN producto_detalle pd ON pd.id_producto = p.id_producto
											WHERE p.activo = 1  AND pd.activo = 1 AND p.id_producto = ".$datos[$i]['idProducto']."
											GROUP by p.id_producto";
							$resCarrito = mysqli_query($conexion,$sqlCarrito);
						foreach ($resCarrito as $keyCarrito) {
							$imagenPrincipal = $keyCarrito['imagen_principal'];
							$producto = $keyCarrito['producto'];
							if($keyCarrito['activo_oferta']==1){
								$costo = $keyCarrito['precio_oferta'];
							}else{
								$costo = $keyCarrito['precio'];
							}
							$subTotalEsteProducto = $costo * $datos[$i]['cantidad'];
							$subTotal += $subTotalEsteProducto;
						}
					?>
					<div class="order-products">
						<div class="order-col">
							<div>Cant. <?php echo $datos[$i]['cantidad'] ?> <?php echo $producto ?></div>
							<div>$<?php echo $subTotalEsteProducto ?> MXN</div>
						</div>
					</div>
					<?php
						}
					?>
						<div class="order-col">
							<div>Envio</div>
							<div><strong>FREE</strong></div>
						</div>
						<div class="order-col">
							<div><strong>TOTAL</strong></div>
							<div><strong class="order-total">$<?php echo $subTotal ?> MXN</strong></div>
						</div>				
				</div>

				<div class="payment-method">
					<!--
					<div class="input-radio">
						<input type="radio" name="payment" id="payment-1" value="tarjeta">
						<label for="payment-1">
							<span></span>
							<img src="https://www.paypalobjects.com/webstatic/en_US/i/buttons/cc-badges-ppmcvdam.png" alt="Credit Card Badges">
						</label>
						<div class="caption">
							<p>Puedes utilizar tu tarjeta bancaria para realizar la compra.</p>
						</div>
					</div>
					

					<div class="input-radio">
						<input type="radio" name="payment" id="payment-3" value="paypal">
						<label for="payment-3">
							<span></span>
							<img src="https://www.paypalobjects.com/webstatic/en_US/i/buttons/PP_logo_h_100x26.png" alt="PayPal Logo">							
						</label>
						<div class="caption">
							<p>La mejor forma segura de pagar.</p>
						</div>
					</div>
					-->
				</div>
	
				<div class="input-checkbox">
					<input type="checkbox" id="terms" value="acepto" name="terms">
					<label for="terms">
						<span></span>
						he leido y acepto los  <a href="#">terminos y condiciones</a>
					</label>
				</div>
					
					<div id='paypal-button-container'></div>
				 
			</div>
			<!-- /Order Details -->
		</div>
		<!-- /row -->
	</div>
	<!-- /container -->
</div>
<!-- /SECTION -->
<div id="prueba"></div>

<script type="text/javascript">
	$(document).ready(function(){

		$("select[name='id_estado']").change(function(){
			var id_estado = $(this).val();
			$("select[name='id_municipio']").html("<option>Espere...</option>");
			$.post('include/selectMunicipioInclude.php',{
				id_estado:id_estado
			},function(data){
				$("select[name='id_municipio']").html(data);
			});
		});

		$("#paypal-button-container").css("display","none");
		var actividad = "";
		$("#terms").change(function(e){
			e.preventDefault();
			if( $('#terms').prop('checked') ) {
				$("#msg").html("");
				$(".validarPago").css("display","block");
				$("#paypal-button-container").css("display","block");

				if($("#shiping-address").prop("checked")){
					actividad = "nuevaDireccion";
				}else if($("#shiping-address").prop("checked",false)){
					actividad = "normalDireccion";
				}
			}else{
				$("#paypal-button-container").css("display","none");
			}
		});

		paypal.Button.render({
        
        // Set your environment

        env: 'sandbox', // sandbox | production

        // Specify the style of the button

        style: {
            label: 'checkout',  // checkout | credit | pay | buynow | generic
            size:  'responsive', // small | medium | large | responsive
            shape: 'pill',   // pill | rect
            color: 'blue'   // gold | blue | silver | black
        },

        // PayPal Client IDs - replace with your own
        // Create a PayPal app: https://developer.paypal.com/developer/applications/create

        client: {
            sandbox:    'AcMFerZoQD2g-P6ovLZLk7botreJCWy-TlixjF3V45Zyu5-csRsbp0Ns_yuYRTlsAOh5NaDGp2ZExbGZ',
            production: 'AT4o3ZwgN-C9HSvQTylyJKI7tGGuPQFITrj34pLJWQwObT-6c57Y3KZd47QQ1iHZfrYGGK5uYqhfIoNt'
        },

        // Wait for the PayPal button to be clicked

        payment: function(data, actions) {
            return actions.payment.create({
                payment: {
                    transactions: [
                        {
                            amount: { total: "<?php echo $subTotal ?>", currency: 'MXN' },
                            description: "Compra de productos a Mirennay $<?php echo  number_format($subTotal,2) ?> MXN",
                            custom: "<?php echo $_SESSION['idUsuario'] ?>#"
                        }
                    ]
                }
            });
        },

        // Wait for the payment to be authorized by the customer

        onAuthorize: function(data, actions) {
            return actions.payment.execute().then(function() {

              	pago(actividad,data.paymentID);
            });
        },
    
    }, '#paypal-button-container');

	});

	function pago(actividad,paymentID){
		var datos = "";
		if(actividad == "nuevaDireccion"){
			 datos = $("#formNuevo").serialize();
		}else if(actividad == "normalDireccion"){
			datos = $("#formPedido").serialize();
		}
		datos+="&paymentId="+paymentID+"&actividad="+actividad;
		$.post('include/verificarPaypalInclude.php',datos,function(e){
			if(e == 1){
				alert("listo fijate en la base de datos");
				location="index.php";
			}else{
				$("#prueba").html(e);
				alert(e);
			}
		});
	}
</script>

<?php 
		}else{
			echo "<div align='center'><h3>Carrito vacio</h3></div>";
		}
	}else{
		echo "<div align='center'><h3>Necesitas iniciar sesión</h3></div>";
	}
 ?>