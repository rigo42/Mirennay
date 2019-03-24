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
		<form id="formLogin">
			<div class="row">
				<div class="form-group col-md-5">
					<input class="input" type="text" name="usuario" placeholder="Nombre de usuario o correo" id="usuario" required="">
				</div>
				<div class="form-group col-md-5">
					<input class="input" type="password" name="password" placeholder="Password" id="password" required="">
				</div>
				<div class="form-group col-md-2">
					<input class="primary-btn order-submit" type="submit" name="Ingresar">
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
			<div id="loader"></div>
		</form>
	</div>
	<!-- /container -->
</div>
<!-- /SECTION -->

<script type="text/javascript">
	$(document).ready(function(){
		$("#formLogin").submit(function(e){
			e.preventDefault();
			var datos = $(this).serialize();
			validarLogin(datos);
		});
		//Titulo para el html
		tittlePage("#menuLogin","Login");
	});
		function validarLogin(datos){
			$.ajax({
	            type: "POST",
	            url: "login/iniciarSesion",
	            data: datos,
	            cache: false,
	    		beforeSend: function() {
	                $('#loader').html('<img src="libreria/img/espere.gif" alt="reload" width="20" height="20">');
	            },
	            success: function(data) {
	            	var idProducto = $("input[name='idProductoUrlEncode']").val();
	            	if(data == 1){
	            		location="productoDetalle?idProducto="+idProducto;
	            	}else if(data == 2){
	            		location="productoDetalle?idProducto="+idProducto;
	            	}else if(data == 3){
	            		 location="inicio";
	            	}else if(data == 4){
	            		$('#loader').html('Usuario o contraseña es incorrecto');
	            	}else{
	            		alert(data);
	            	}
	            }
       	    });
		}
</script>