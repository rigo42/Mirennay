<!-- BREADCRUMB -->
<div id="breadcrumb" class="section">
	<!-- container -->
	<div class="container">
		<!-- row -->
		<div class="row">
			<div class="col-md-12">
				<h3 class="breadcrumb-header">Login</h3>
				<ul class="breadcrumb-tree">
					<li class="active">Crear cuenta</li>
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
		<form id="usuarioNuevo">
			<div class="row">
				<div class="form-group col-md-5">
					<input class="input" type="text" name="usuario" placeholder="Nombre de usuario" id="usuario" required="">
				</div>
				<div class="form-group col-md-5">
					<input class="input" type="email" name="correo" placeholder="Correo electronico" id="correo" required="">
				</div>
				<div class="form-group col-md-5">
					<input class="input" type="password" name="password" placeholder="Password" id="password" required="">
				</div>
				<div class="form-group col-md-5">
					<input class="input" type="password" name="passwordc" placeholder="PasswordC" id="passwordC" required="">
				</div>
				<div class="form-group col-md-2">
					<button type="submit" class="primary-btn order-submit" id="gif">Registrarse</button>
				</div>
			</div>	
		</form>
	</div>
	<!-- /container -->
</div>
<!-- /SECTION -->

<script type="text/javascript">
	$(document).ready(function(){

		//Titulo para el html
		tittlePage("#menuLogin","Login | Nuevo");

		$("#usuarioNuevo").submit(function(e){
			e.preventDefault();
			var password = $("input[name='password']").val();
            var passwordc = $("input[name='passwordc']").val();
            if(password != passwordc){
                notificacion("warning","Contraseñas no coinciden.");
                $("#password").css("border-color", "red");
        		$("#passwordC").css("border-color", "red");
        		$("#correo").css("border-color", "#fff");
        		$("#usuario").css("border-color", "#fff");
            }else{
            	var datos = $(this).serialize();
                usuarioNuevo(datos);
            }		 
		});

	});
</script>