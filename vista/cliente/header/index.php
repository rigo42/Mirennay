<!-- HEADER -->
<header>
	<!-- TOP HEADER -->
	<div id="top-header">
		<div class="container">
			<ul class="header-links pull-left">
				<li><a href="#"><i class="fa fa-phone"></i> (+52) 323-115-36-78</a></li>
				<li><a href="#"><i class="fa fa-envelope-o"></i> rigoberto.villa42@gmail.com</a></li>
				<li><a href="#"><i class="fa fa-map-marker"></i> Primero de enero #27</a></li>
				<li><a href="#"><i class="fa fa-dollar"></i> MXN</a></li>
			</ul>
			<ul class="header-links pull-right">
				<?php if(isset($_SESSION['idUsuario'])){ ?>
				<li><a href="#"><i class="fa fa-user-o"></i><?php echo $_SESSION['usuario'] ?></a></li>
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
						<a href="#" class="logo">
							<img src="<?php echo URL ?>libreria/img/logoM.png" alt="">
						</a>
					</div>
				</div>
				<!-- /LOGO -->

				<!-- SEARCH BAR -->
				<div class="col-md-6">
					<div class="header-search">
						<form action="<?php echo URL ?>tienda" method="GET">
							<input type="search" class="input" placeholder="Buscar aqui" name="search" required="" style="border-radius: 40px 0px 0px 40px;">
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
								<div class="qty" id="cuantosProductosFavoritos">0</div>
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
								<div class="qty cuantosProductosCarrito">0</div>
							</a>
							<div class="cart-dropdown">
								<div class="cart-list">

									<div id="productoVentanaCarrito">
											
									</div>

								</div>
								<div class="cart-summary">
									<small class="cuantosProductosCarrito">0</small>
									Productos(s) seleccionados
									<h5 id="subTotal"></h5>
								</div>
								<div class="cart-btns" id="checkout" style="display: none;">
									<a href="#" style="background-color: #333;">Ver carrito</a>
									<a href="<?php echo URL ?>pedido">Checkout<i class="fa fa-arrow-circle-right"></i></a>
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

