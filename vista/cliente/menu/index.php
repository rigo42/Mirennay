<!-- NAVIGATION -->
<nav id="navigation">
	<!-- container -->
	<div class="container">
		<!-- responsive-nav -->
		<div id="responsive-nav">
			<!-- NAV -->
			<ul class="main-nav nav navbar-nav">
				<li id="menuInicio"><a href="<?php echo URL ?>inicio">Inicio</a></li>
				<li id="menuTienda"><a href="<?php echo URL ?>tienda">Tienda</a></li>
			<?php if(isset($_SESSION['idUsuario'])){ ?>	
			<?php 
				if($_SESSION['rol'] == "admin" || $_SESSION['rol'] == "empleado"){
			?>
				<li><a href="<?php echo URL ?>almacen">Administración</a></li>
			<?php
				}
			?>
				<li id="menuPerfil"><a href="<?php echo URL ?>perfil">Mi perfil</a></li>	
				<li id="menuLoginCerrar"><a href="#">Cerrar Sesión</a></li>
			<?php }else{ ?>
				<li id="menuLogin"><a href="<?php echo URL ?>login">Iniciar Sesión</a></li>
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
		$("#menuLoginCerrar").click(function(e){
			e.preventDefault();
			$.post('login/cerrarSesion',{},function(data){
				location="inicio";
			});
		});
	});
</script>