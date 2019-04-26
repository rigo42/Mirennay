<?php 
	$actividad = "";
	$idProducto = "";
	$idProductoDetalle = "";
	$idProductoDetalleCantidad = "";
	$producto = "";
	$precio = "";
	$imagenPrincipal = "";
	$talla = "";
	$color = "";
	$titulo = "";

	if(htmlspecialchars(addslashes(isset($_GET['actividad'])))){
		$actividad = htmlspecialchars(addslashes($_GET['actividad']));
		$idProducto = htmlspecialchars(addslashes($_GET['idProducto']));
		if($actividad == "favorito"){
			$titulo = "Para agregar a favorito inicia sesión.";
		}else if($actividad == "carrito"){
			$titulo = "Para agregar a carrito inicia sesión.";
			$idProductoDetalle = htmlspecialchars(addslashes($_GET['idProductoDetalle']));
			$idProductoDetalleCantidad = htmlspecialchars(addslashes($_GET['idProductoDetalleCantidad']));
			$producto = htmlspecialchars(addslashes($_GET['producto']));
			$precio = htmlspecialchars(addslashes($_GET['precio']));
			$imagenPrincipal = htmlspecialchars(addslashes($_GET['imagenPrincipal']));
			$talla = htmlspecialchars(addslashes($_GET['talla']));
			$color = htmlspecialchars(addslashes($_GET['color']));
		}
	}else{
		$actividad = "normal";
		$titulo = "Te espera una gran cantidad de productos a un precio excelente.";
	}
 ?>
<!-- BREADCRUMB -->
<div id="breadcrumb" class="section">
	<!-- container -->
	<div class="container">
		<!-- row -->
		<div class="row">
			<div class="col-md-12">
				<h3 class="breadcrumb-header">Login</h3>
				<ul class="breadcrumb-tree">
					<li><a href="#">Inicia sesión</a></li>
					<li class="active"><?php echo $titulo ?></li>
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
		<div class="section-title">
			<h3 class="title">Iniciar sesión</h3>
		</div>
		<form id="formLogin">
			<div class="row">
				<div class="form-group col-md-5">
					<input class="input" type="text" name="usuario" placeholder="Nombre de usuario o correo" id="usuario" required="">
				</div>
				<div class="form-group col-md-5">
					<input class="input" type="password" name="password" placeholder="Password" id="password" required="">
				</div>
				<div class="form-group col-md-2">
					<input class="primary-btn order-submit" type="submit" value="Ingresar">
				</div>
				<!-- Input ocultos -->
				<input type="hidden" name="actividad" value="<?php echo $actividad ?>">
				<input type="hidden" name="idProductoUrlEncode" value="<?php echo htmlspecialchars(addslashes(urlencode($idProducto))) ?>">
				<?php if($actividad == "favorito"){ ?>
				<input type="hidden" name="idProducto" value="<?php echo $idProducto ?>">
				<?php }elseif($actividad == "carrito"){ ?>
				<input type="hidden" name="idProducto" value="<?php echo $idProducto ?>">
				<input type="hidden" name="idProductoDetalle" value="<?php echo $idProductoDetalle ?>">
				<input type="hidden" name="idProductoDetalleCantidad" value="<?php echo $idProductoDetalleCantidad ?>">
				<input type="hidden" name="producto" value="<?php echo $producto ?>">
				<input type="hidden" name="precio" value="<?php echo $precio ?>">
				<input type="hidden" name="imagenPrincipal" value="<?php echo $imagenPrincipal ?>">
				<input type="hidden" name="talla" value="<?php echo $talla ?>">
				<input type="hidden" name="color" value="<?php echo $color ?>">
				<?php } ?>
				<!-- //Input ocultos -->
				<div class="form-group col-md-2">
					<a href="<?php echo URL ?>login/nuevo">¿No tienes una cuenta?</a>
				</div>
			</div>	
			<div id="mensajeLogin"></div>
		</form>

		<!-- Recuperar password -->
		<div class="shiping-details">
			<div class="section-title">
				<h3 class="title">Recuperar password</h3>
			</div>
			<div class="input-checkbox">
				<input type="checkbox" id="recuperarPassword">
				<label for="recuperarPassword">
					<span></span>
					Recuperar password
				</label>
				<div class="caption">
					<form id="cambiarPassword">
						<div class="form-group col-md-6">
							<input maxlength="100" required="" class="input" type="text" name="correo" placeholder="A este correo se enviaran los pasos a seguir">
						</div>
						<div class="form-group col-md-2">
							<button type="submit" class="primary-btn order-submit" id="gif">Enviar</button>
						</div>
					</form>
				</div>
			</div>
		</div>
		<!-- /Recuperar password -->
	</div>
	<!-- /container -->

	
</div>
<!-- /SECTION -->

<script type="text/javascript">
	$(document).ready(function(){

		//Titulo para el html
		tittlePage("#menuLogin","Login");

		$("#formLogin").submit(function(e){
			e.preventDefault();
			var datos = $(this).serialize();
			iniciarSesion(datos);
		});

		$("#cambiarPassword").submit(function(e){
			e.preventDefault();
			var datos = $(this).serialize();
			activarCodigoVerificacion(datos);
		});

	});
		
</script>