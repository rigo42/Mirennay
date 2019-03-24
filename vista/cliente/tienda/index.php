<?php 
	$idCategoria = "";
	if(isset($_GET['idCategoria'])){
		$idCategoria = $_GET['idCategoria'];
	}
	$search = "";
	if(isset($_GET['search'])){
		$search = $_GET['search'];
	}
 ?>
<!-- SECTION -->
<div class="section">
	<!-- container -->
	<div class="container">
		<!-- row -->
		<div class="row">
			<!-- ASIDE -->
			<div id="aside" class="col-md-3">
				<!-- aside Widget -->
				<div class="aside">
					<h3 class="aside-title">Categories</h3>
					<div class="checkbox-filter">
						<div class="input-checkbox">
							<input type="checkbox" id="todo" name="idSubCategoria" value="todo">
							<label for="todo">
								<span></span>
								Todo
								<small>()</small>
							</label>
						</div>
						<?php 
							$resSubCategoria = $this->mostrarSubCategoria(); 
							foreach ($resSubCategoria as $keySubCategoria) {
						?>
						<div class="input-checkbox">
							<input type="checkbox" id="<?php echo openssl_encrypt($keySubCategoria['id_sub_categoria'],COD,KEY) ?>" name="idSubCategoria" value="<?php echo openssl_encrypt($keySubCategoria['id_sub_categoria'],COD,KEY) ?>">
							<label for="<?php echo openssl_encrypt($keySubCategoria['id_sub_categoria'],COD,KEY) ?>">
								<span></span>
								<?php echo $keySubCategoria['sub_categoria'] ?>
								<small>(<?php echo $keySubCategoria['cuantos'] ?>)</small>
							</label>
						</div>
						<?php } ?>
					</div>
				</div>
				<!-- /aside Widget -->

				<!-- aside Widget -->
				<div class="aside">
					<h3 class="aside-title">Precio</h3>
					<div class="price-filter">
						<div id="price-slider"></div>
						<div class="input-number price-min">
							<button type="button" id="btnPrecio" class="primary-btn">Filtrar</button>
							<input type="hidden" name="precioMin">
							<input type="hidden" name="precioMax">
						</div>
						<div class="input-number price-max">
							$<span id="price-min"></span> - $<span id="price-max"></span>
						</div>
					</div>
				</div>
				<!-- /aside Widget -->


				<!-- aside Widget -->
				<div class="aside">
					<h3 class="aside-title">Top mas vendido</h3>
					<?php $this->productoMasVendidoControlador->productoMasVendidoMin(); ?>
				</div>
				<!-- /aside Widget -->
			</div>
			<!-- /ASIDE -->

			<!-- STORE -->
			<div id="store" class="col-md-9">
				<!-- store top filter -->
				<div class="store-filter clearfix">
					<div class="store-sort">
						<label>
							Genero:
							<select class="input-select" name="idGenero">
								<option value="">Todo</option>
								<?php 
								$resGenero = $this->mostrarGenero();
								foreach ($resGenero as $keyGenero) {
								?>
								<option value="<?php echo openssl_encrypt($keyGenero['id_genero'],COD,KEY) ?>"><?php echo $keyGenero['genero'] ?></option>
								<?php
								}
								 ?>
							</select>
						</label>
					</div>
					<!--
					<ul class="store-grid">
						<li class="active"><i class="fa fa-th"></i></li>
						<li><a href="#"><i class="fa fa-th-list"></i></a></li>
					</ul>
					-->
				</div>
				<!-- /store top filter -->

				<!-- store products -->
				<div  id="tienda"></div>
				<!-- /store products -->

			</div>
			<!-- /STORE -->
		</div>
		<!-- /row -->
	</div>
	<!-- /container -->
</div>
<!-- /SECTION -->

<input type="hidden" name="idCategoria" value="<?php echo $idCategoria ?>">
<input type="hidden" name="search" id="search" value="<?php echo $search ?>">

<script type="text/javascript">
	$(document).ready(function(){

		//Ejecutar funciones automaticamente//
		var idSubCategoria = [];
		var idCategoria = $("input[name='idCategoria']").val();
		var search = $("#search").val();

		//Titulo para el html
		tittlePage("#menuTienda","Tienda");
		paginadorProducto(search,idCategoria,"","","",idSubCategoria,9,1);

		//Eventos listeners
		$("input[name='idSubCategoria']").change(function(e){
			e.preventDefault();
			if (this.checked) {
        		if($(this).val() == "todo"){
        			$("input[name='idSubCategoria']").prop('checked', false);
        			$(this).prop('checked', true);
        			idSubCategoria = [];
        			$("#price-min").html(1);
					$("input[name='precioMin']").val(1);
					$("#price-max").html(15001);
					$("input[name='precioMax']").val(15001);
            		paginadorProducto("","","","","",idSubCategoria,9,1);
        		}else{
        			idSubCategoria.push($(this).val());
        			$("#todo").prop('checked', false);
        			var idGenero = $("select[name='idGenero']").val();
        			var precioMin = $("input[name='precioMin']").val();
					var precioMax = $("input[name='precioMax']").val();
            		paginadorProducto("","",precioMin,precioMax,idGenero,idSubCategoria,9,1);
        		}
        	}else{
        		if($(this).val() == "todo"){
        			idSubCategoria = [];
        			$("#price-min").html(1);
					$("input[name='precioMin']").val(1);
					$("#price-max").html(15001);
					$("input[name='precioMax']").val(15001);
        			$("input[name='idSubCategoria']").prop('checked', false);
        			$(this).prop('checked', true);
            		paginadorProducto("","","","","",idSubCategoria,9,1);
        		}else{
        			$("#todo").prop('checked', false);
        			var index = idSubCategoria.indexOf($(this).val());
            		idSubCategoria.splice(index, 1);
            		var idGenero = $("select[name='idGenero']").val();
            		var precioMin = $("input[name='precioMin']").val();
					var precioMax = $("input[name='precioMax']").val();
            		paginadorProducto("","",precioMin,precioMax,idGenero,idSubCategoria,9,1);
        		}
        	}
		});

		// Price Slider
		var priceSlider = document.getElementById('price-slider');
		if (priceSlider) {
			noUiSlider.create(priceSlider, {
				start: [1, 15001],
				connect: true,
				step: 100,
				range: {
					'min': 1,
					'max': 15001
				}
			});

			priceSlider.noUiSlider.on('update', function( values, handle ) {
				var min = values[0];
				var max = values[1];
				$("#price-min").html(min);
				$("input[name='precioMin']").val(min);
				$("#price-max").html(max);
				$("input[name='precioMax']").val(max);
			});
		}

		$("select[name='idGenero']").change(function(e){
			e.preventDefault();
			var idGenero = $(this).val();
			var precioMin = $("input[name='precioMin']").val();
			var precioMax = $("input[name='precioMax']").val();
			paginadorProducto("","",precioMin,precioMax,idGenero,idSubCategoria,9,1);
		});

		$("#btnPrecio").click(function(e){
			e.preventDefault();
			var idGenero = $("select[name='idGenero']").val();
			var precioMin = $("input[name='precioMin']").val();
			var precioMax = $("input[name='precioMax']").val();
			paginadorProducto("","",precioMin,precioMax,idGenero,idSubCategoria,9,1);
		});

	});

	function paginadorProducto(search,idCategoria,precioMin,precioMax,idGenero,idSubCategoria,cantidadPagina,paginaNumero){
		$.ajax({
	        type: "GET",
	        url: "<?php echo URL?>Tienda/tiendaPaginadorEnlistar",
	        data: {
	        	search:search,
	        	idCategoria:idCategoria,
	        	precioMax:precioMax,
	        	precioMin:precioMin,
	        	idGenero:idGenero,
	        	idSubCategoria:JSON.stringify(idSubCategoria),
	        	paginaNumero:paginaNumero,
	        	cantidadPagina:cantidadPagina
	        },
	        cache: false,
			beforeSend: function() {
	        },
	        success: function(data) {
	    		$("#tienda").html(data);
	        }
		});
	}
</script>
