
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
		<form id="formLogin">
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
					<input class="input" type="password" name="passwordC" placeholder="PasswordC" id="passwordC" required="">
				</div>
				<div class="form-group col-md-2">
					<input class="primary-btn order-submit" type="submit" name="Registrarse">
				</div>
				<input type="hidden" name="actividad" value="nuevo">
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
		            		$("#password").css("border-color", "#fff");
	            			$("#passwordC").css("border-color", "#fff");
	            			$("#usuario").css("border-color", "#fff");
	            			$("#correo").css("border-color", "#fff");
		            		Push.create("Exito",{
								body: "Tu cuenta ah sido creada",
								timeout: 4000,
								icon: 'img//M.png'
							});
	            			location="index.php";
	            		}else if(data == 2){
	            			$('#loader').html("Las contraseñas no coinciden"); 
	            			$("#password").css("border-color", "red");
	            			$("#passwordC").css("border-color", "red");
	            			$("#correo").css("border-color", "#fff");
	            			$("#usuario").css("border-color", "#fff");
	            		}else if(data == 3){
	            			$('#loader').html("El correo electronico no es valido"); 
	            			$("#correo").css("border-color", "red");
	            			$("#password").css("border-color", "#fff");
	            			$("#passwordC").css("border-color", "#fff");
	            			$("#usuario").css("border-color", "#fff");
	            		}else if(data == 4){
	            			$('#loader').html("El usuario ya esta en uso"); 
	            			$("#correo").css("border-color", "#fff");
	            			$("#password").css("border-color", "#fff");
	            			$("#passwordC").css("border-color", "#fff");
	            			$("#usuario").css("border-color", "red");
	            		}else if(data == 5){
	            			$('#loader').html("El correo ya esta en uso"); 
	            			$("#usuario").css("border-color", "#fff");
	            			$("#password").css("border-color", "#fff");
	            			$("#passwordC").css("border-color", "#fff");
	            			$("#correo").css("border-color", "red");
	            		}else{		                
		               		 $('#loader').html(data); 
		            	}
		            }
	       	    });
			});

		$(".menu li").removeClass('active');
		$("#crearCuenta").addClass('active');
		
	});
</script>