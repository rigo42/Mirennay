<?php 
	$actividad = "";
	$idProducto = "";
	$idProductoDetalle = "";
	$cantidad = "";
	$titulo = "";
	if(isset($_GET['actividad'])){
		$actividad = $_GET['actividad'];
		$idProducto = $_GET['idProducto'];

		if($actividad == "favorito"){
			$titulo = "Para agregar a favorito inicia sesión";
		}else if($actividad == "carrito"){
			$idProductoDetalle = $_GET['idProductoDetalle'];
			$cantidad = $_GET['cantidad'];
			$titulo = "Para agregar a carrito inicia sesión";
		}

	}else{
		$titulo = "Te espera una gran cantidad de productos a un precio excelente :3";
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
				<input type="hidden" value="iniciar" name="actividad">
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
			var datos = $(this).serialize();
			e.preventDefault();
				$.ajax({
		            type: "POST",
		            url: "include/servletUsuarioInclude.php",
		            data: datos,
		            cache: false,
		    		beforeSend: function() {
		                $('#loader').html('<img src="gif/espere.gif" alt="reload" width="20" height="20">');
		            },
		            success: function(data) {
		            	if(data == 1){
		            		$("#loader").html("");

		            		var idProducto = "<?php echo $idProducto ?>";
		            		var actividad = "<?php echo $actividad ?>";
		            		var activo = 1;

		            		if(actividad == "favorito"){
	            				$.post('include/servletProductoFavoritoInclude.php',{
	            					activo:activo,
	            					actividad:"nuevo",
	            					idProducto:idProducto
	            				},function(e){
	            					productoVentanaFavorito();
	            					location="productoDetalle.php?id="+idProducto;
	            				});
	            			}else if(actividad == "carrito"){
	            				var idProductoDetalle = "<?php echo $idProductoDetalle ?>";
	            				var cantidad = "<?php echo $cantidad ?>";
	            				$.post('include/servletProductoSesionInclude.php',{
	            					idProductoDetalle:idProductoDetalle,
	            					cantidad:cantidad,
	            					idProducto:idProducto
	            				},function(e){
	            					productoVentanaCarrito();
	            					location="productoDetalle.php?id="+idProducto;
	            				});
	            			}else{
	            				location="producto.php";
	            			}
		            	}else if(data == 2){
		            		$('#loader').html('Usuario o contraseña es incorrecto'); 
		            	}else{		                
		               		 $('#loader').html(data); 
		            	}
		            }
	       	    });
		});

		$(".menu li").removeClass('active');
		$("#iniciarSesion").addClass('active');
		
	});
</script>