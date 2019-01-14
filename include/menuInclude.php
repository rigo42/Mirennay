<?php 

 if(isset($_GET['url'])){
 	if($_GET['url'] == "inicio"){
		header("Location: index.php");
	}else{
		$ruta1 = "../".$_GET['url'].".php";
		if(is_file($ruta1)){
			header("Location: Mirennay/".$ruta1);
		}else{
			header("Location: error404.php");
		}
	}
}
?>
<!-- HEADER -->
<header>
	<!-- TOP HEADER -->
	<div id="top-header">
		<div class="container">
			<ul class="header-links pull-left">
				<li><a href="#"><i class="fa fa-phone"></i>(+52) 323 115-36-78</a></li>
				<li><a href="#"><i class="fa fa-envelope-o"></i>rigoberto.villa42@gmail.com</a></li>
				<li><a href="#"><i class="fa fa-map-marker"></i>Santiago Ixcuintla Nayarit</a></li>
			</ul>
			<ul class="header-links pull-right">
				<li><a href="#"><i class="fa fa-dollar"></i> MXN</a></li>
				<?php if(isset($_SESSION['idUsuario'])){ ?>
				<li><a href="#"><i class="fa fa-user-o"></i> <?php echo $_SESSION['usuario'] ?></a></li>
				<?php } ?>
			</ul>
		</div>
	</div>
	<!-- /TOP HEADER -->

	<!-- MAIN HEADER -->
	<div id="header">
		<!-- container -->
		<div class="container">
			<!-- row -->
			<div class="row">
				<!-- LOGO -->
				<div class="col-md-3">
					<div class="header-logo">
						<a href="index.php" class="logo">
							<img src="./img/logoMirennay.png" alt="">
						</a>
					</div>
				</div>
				<!-- /LOGO -->

				<!-- SEARCH BAR -->
				<div class="col-md-6">
					<div class="header-search">
						<form>
							<input class="input" placeholder="Buscar aqui" name="producto" style="border-radius: 40px 0px 0px 40px;">
							<button class="search-btn">Buscar</button>
						</form>
					</div>
				</div>
				<!-- /SEARCH BAR -->

				<!-- ACCOUNT -->
				<div class="col-md-3 clearfix">
					<div class="header-ctn">

						<!-- Wishlist -->
						<div class="dropdown">
							<a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
								<i class="fa fa-heart-o"></i>
								<span>Favoritos</span>
								<div class="qty" id="cuantosProductosFavoritos"></div>
							</a>
							<div class="favorito-dropdown">
							
								<div class="cart-list">

									<div id="productoVentanaFavorito">
										
									</div>

								</div>
							</div>
						</div>
						<!-- /Wishlist -->

						<!-- Cart -->
						<div class="dropdown">
							<a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
								<i class="fa fa-shopping-cart"></i>
								<span>Carrito</span>
								<div class="qty cuantosProductosCarrito"></div>
							</a>
							<div class="cart-dropdown">
								<div class="cart-list">
								
								<div id="productoVentanaCarrito">
										
								</div>
									
								</div>
								<div class="cart-summary">
									<small><span class="cuantosProductosCarrito"></span> Producto(s)</small>
									<h5 id="subTotalProductosCarrito">SUB TOTAL: $<span id="subTotal"></span></h5>
								</div>
								<div class="cart-btns" id="cart-btns">
									<a href="pedido.php">Checkout  <i class="fa fa-arrow-circle-right"></i></a>
								</div>
							</div>
						</div>
						<!-- /Cart -->

						<!-- Menu Toogle -->
						<div class="menu-toggle">
							<a href="#">
								<i class="fa fa-bars"></i>
								<span>Menu</span>
							</a>
						</div>
						<!-- /Menu Toogle -->
					</div>
				</div>
				<!-- /ACCOUNT -->
			</div>
			<!-- row -->
		</div>
		<!-- container -->
	</div>
	<!-- /MAIN HEADER -->
</header>
<!-- /HEADER -->

<!-- NAVIGATION -->
<nav id="navigation">
	<!-- container -->
	<div class="container">
		<!-- responsive-nav -->
		<div id="responsive-nav">
			<!-- NAV -->
			<ul class="main-nav nav navbar-nav menu">
				<li id="menuInicio"><a href="index.php">Inicio</a></li>
				<li id="menuProducto"><a href="producto.php">Productos</a></li>
				<?php
				if(isset($_SESSION['idUsuario'])){
				?>
				<li id="cerrarSesion"><a href="#">Cerrar sesión</a></li>
				<?php
				} else{
				?>
				<li id="iniciarSesion"><a href="login.php?cliente=loginIniciar">Iniciar sesión</a></li>
				<li id="crearCuenta"><a href="login.php?cliente=loginNuevo">Crear cuenta</a></li>
				<?php
				}
				?>
				<?php if(isset($_SESSION['rol']) && ($_SESSION['rol'] == "admin") ){	
				?>

                <li id="menuAdministrador" class="nav-item dropdown">
				    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				     Administrador
				    </a>
				    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink" style="text-align: center;">
				      <a class="dropdown-item" href="administrador.php?admin=empresa">Empresas</a><br>
				      <a class="dropdown-item" href="administrador.php?admin=proveedor">Proveedores</a><br>
				      <a class="dropdown-item" href="administrador.php?admin=categoria">Categorias</a><br>
				      <a class="dropdown-item" href="administrador.php?admin=talla">Tallas</a><br>
				      <a class="dropdown-item" href="administrador.php?admin=aProducto">Productos</a><br>
				    </div>
			  </li>
				<?php } ?>
			  
			</ul>
			<!-- /NAV -->
		</div>
		<!-- /responsive-nav -->
	</div>
	<!-- /container -->
</nav>
<!-- /NAVIGATION -->

<script type="text/javascript">
	$(document).ready(function(){

		// Fix cart dropdown from closing
		$('.cart-dropdown').on('click', function (e) {
			e.stopPropagation();
		});

		// Mobile Nav toggle
		$('.menu-toggle > a').on('click', function (e) {
			e.preventDefault();
			$('#responsive-nav').toggleClass('active');
		});

		$(".search-btn").click(function(e){
			e.preventDefault();
			var producto = $("input[name='producto']").val();
			if(producto != ""){
				location="producto.php?producto="+producto;
			}
		});

		$("#cerrarSesion").click(function(e){
			e.preventDefault();
			$.post('include/cerrarSesionInclude.php',{
			},function(data){
				if(data==1){
					location="index.php";
				}else{
					alert("Hay un problema al tratar de cerrar sesion");
				}
			});
			 
		});

		productoVentanaFavorito();
		productoVentanaCarrito();

	});

	function productoVentanaFavorito(){
		$.post('include/productoVentanaFavorito.php',{
		},function(data){
			$("#productoVentanaFavorito").html(data);
		});
	}

	function productoVentanaCarrito(){
		$.post('include/productoVentanaCarrito.php',{
		},function(data){
			$("#productoVentanaCarrito").html(data);
		});
	}
</script>