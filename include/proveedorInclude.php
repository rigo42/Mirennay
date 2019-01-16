<!-- BREADCRUMB -->
<div id="breadcrumb" class="section">
	<!-- container -->
	<div class="container">
		<!-- row -->
		<div class="row">
			<div class="col-md-12">
				<h3 class="breadcrumb-header">Administrador</h3>
				<ul class="breadcrumb-tree">
					<li><a href="#">Proveedores</a></li>
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
					<input class="input" type="text" name="proveedor" placeholder="Buscar proveedor" id="proveedor">
				</div>
				<div class="form-group col-md-6">
					<ul class="store-grid">
						<li id="nuevo" title="Nueva proveedor"><i class="fa fa-plus"></i></li>
						<li id="inactivo" title="Ver los dados de baja"><i class="fa fa-times"></i></li>
						<li id="activo" title="Ver los dados de alta"><i class="fa fa-check"></i></li>
					</ul>
				</div>
			</div>		
		</div>

		<div id="proveedorTablaInclude"></div>
	    <div id="loader"></div>

	</div>
	<!-- /container -->
</div>
<!-- /SECTION -->

<script type="text/javascript">

	$(document).ready(function(){

		tablaInteractiva("","1");	

		$("#nuevo").click(function(){
			location="administrador.php?admin=proveedorNuevo";
		});
		$("#activo").click(function(){
			var proveedor = $("#proveedor").val();
			tablaInteractiva(proveedor,"1");	
		});
		$("#inactivo").click(function(){
			var proveedor = $("#proveedor").val();
			tablaInteractiva(proveedor,"0");	
		});
		$("#proveedor").keyup(function(e){
			e.preventDefault();
			if(e.which == 13){
				var proveedor = $(this).val();
				tablaInteractiva(proveedor,"1");	
			}
		}); 
	});

	function tablaInteractiva(proveedor, activo) {
        $.ajax({
            type: "GET",
            url: "include/proveedorTablaInclude.php",
            data: {
            	proveedor:proveedor,
            	activo:activo
            },
            cache: false,
    		beforeSend: function() {
                $('#loader').html('<img src="gif/espere.gif" alt="reload" width="20" height="20">');
            },
            success: function(html) {
                $("#proveedorTablaInclude").html(html);
                $('#loader').html(''); 
            }
        });
    }
</script>
