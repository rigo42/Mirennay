<!-- BREADCRUMB -->
<div id="breadcrumb" class="section">
	<!-- container -->
	<div class="container">
		<!-- row -->
		<div class="row">
			<div class="col-md-12">
				<h3 class="breadcrumb-header">Administrador</h3>
				<ul class="breadcrumb-tree">
					<li><a href="#">productos</a></li>
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

		<div class="store-filter clearfix">
			<div class="row">
				<div class="form-group col-md-6">
					<input class="input" type="text" name="producto" placeholder="Buscar producto" id="producto">
				</div>
				<div class="form-group col-md-6">
					<ul class="store-grid">
						<li id="nuevo" title="Nuevo producto"><i class="fa fa-plus"></i></li>
						<li id="inactivo" title="Ver los dados de baja"><i class="fa fa-times"></i></li>
						<li id="activo" title="Ver los dados de alta"><i class="fa fa-check"></i></li>
					</ul>
				</div>
			</div>		
		</div>

		<div id="aProductoTablaInclude"></div>
	    <div id="loader"></div>

	</div>
	<!-- /container -->
</div>
<!-- /SECTION -->

<script type="text/javascript">

	 function tablaInteractiva(producto, activo) {
        $.ajax({
            type: "GET",
            url: "include/aProductoTablaInclude.php",
            data: {
            	producto:producto,
            	activo:activo
            },
            cache: false,
    		beforeSend: function() {
                $('#loader').html('<img src="gif/espere.gif" alt="reload" width="20" height="20">');
            },
            success: function(html) {
                $("#aProductoTablaInclude").html(html);
                $('#loader').html(''); 
            }
        });
    }

	$(document).ready(function(){

		tablaInteractiva("","1");	

		$("#nuevo").click(function(){
			location="administrador.php?admin=aProductoNuevo";
		});
		$("#activo").click(function(){
			var producto = $("#producto").val();
			tablaInteractiva(producto,"1");	
		});
		$("#inactivo").click(function(){
			var producto = $("#producto").val();
			tablaInteractiva(producto,"0");	
		});
		$("#producto").keyup(function(e){
			e.preventDefault();
			if(e.which == 13){
				var producto = $(this).val();
				tablaInteractiva(producto,"1");	
			}
		}); 
	});
</script>
