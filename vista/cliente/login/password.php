<!-- BREADCRUMB -->
<div id="breadcrumb" class="section">
	<!-- container -->
	<div class="container">
		<!-- row -->
		<div class="row">
			<div class="col-md-12">
				<h3 class="breadcrumb-header">Login</h3>
				<ul class="breadcrumb-tree">
					<li class="active">Cambiar password</li>
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
		<form id="cambiarPassword">
			<div class="row">
				<div class="form-group col-md-5">
					<input class="input" type="password" name="password" placeholder="Contraseña" id="password" required="">
				</div>
				<div class="form-group col-md-5">
					<input class="input" type="password" name="passwordc" placeholder="Confirmar la contraseña" id="passwordC" required="">
				</div>
				<div class="form-group col-md-2">
					<button type="submit" class="primary-btn" id="gif">Cambiar</button>
				</div>
			</div>	
			<!-- Inputs ocultos -->
            <input type="hidden" value="<?php echo $value['correo'] ?>" name="correo">
		</form>
	</div>
	<!-- /container -->
</div>
<!-- /SECTION -->

<script type="text/javascript">
	$(document).ready(function(){

		//Titulo para el html
		tittlePage("#menuLogin","Login | Nuevo");

		$("#cambiarPassword").submit(function(e){
			e.preventDefault();
			var password = $("input[name='password']").val();
            var passwordc = $("input[name='passwordc']").val();
            if(password != passwordc){
                notificacion("warning","Contraseñas no coinciden.");
                $("#password").css("border-color", "red");
        		$("#passwordC").css("border-color", "red");
            }else{
            	var correo = $("input[name='correo']").val();
                cambiarPassword(password,correo);
            }		 
		});

	});
</script>