<?php 
	include('conexion.php');
	$producto = "";
	if(isset($_GET['producto'])){
		 $producto = " AND  (p.producto like '%" . $_GET['producto'] . "%' OR  c.categoria like '%" . $_GET['producto'] . "%') ";
		?>
		<script type="text/javascript">
			$(document).ready(function(){
				$("input[name='producto']").val("<?php echo $_GET['producto'] ?>");
				 paginador("<?php echo $producto ?>","todo","",6, 1);
			});
		</script>
		<?php
	}

	$sql = "SELECT c.*,count(p.id_producto) as 'cuantos'
			FROM categoria c
			inner join producto p ON p.id_categoria = c.id_categoria
			WHERE c.activo = 1 AND p.activo = 1
			GROUP by c.categoria";
	$categoria = mysqli_query($conexion,$sql);

 ?>
 <input type="hidden" name="producto" id="producto">
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
							<input class="categoria" type="checkbox" id="todo" name="categoria" value="todo">
							<label for="todo">
								<span></span>
								Todo
								<small>(120)</small>
							</label>
						</div>

						<?php 
							foreach ($categoria as $datos) {
						 ?>
						<div class="input-checkbox">
							<input class="categoria" type="checkbox" id="<?php echo $datos['id_categoria'] ?>" name="categoria" value="<?php echo $datos['id_categoria'] ?>">
							<label for="<?php echo $datos['id_categoria'] ?>">
								<span></span>
								<?php echo $datos['categoria'] ?>
								<small><?php echo $datos['cuantos'] ?></small>
							</label>
						</div>
						<?php } ?>

					</div>
				</div>
				<!-- /aside Widget -->

				<!-- aside Widget -->
				<div class="aside">
					<h3 class="aside-title">Price</h3>
					<div class="price-filter">
						<div id="price-slider"></div>
						<div class="input-number price-max">
							<input id="price-max" type="number" disabled="">
						</div>
					</div>
				</div>
				<!-- /aside Widget -->

				<!-- aside Widget 
				<div class="aside">
					<h3 class="aside-title">Brand</h3>
					<div class="checkbox-filter">
						<div class="input-checkbox">
							<input type="checkbox" id="brand-1">
							<label for="brand-1">
								<span></span>
								SAMSUNG
								<small>(578)</small>
							</label>
						</div>
						<div class="input-checkbox">
							<input type="checkbox" id="brand-2">
							<label for="brand-2">
								<span></span>
								LG
								<small>(125)</small>
							</label>
						</div>
						<div class="input-checkbox">
							<input type="checkbox" id="brand-3">
							<label for="brand-3">
								<span></span>
								SONY
								<small>(755)</small>
							</label>
						</div>
						<div class="input-checkbox">
							<input type="checkbox" id="brand-4">
							<label for="brand-4">
								<span></span>
								SAMSUNG
								<small>(578)</small>
							</label>
						</div>
						<div class="input-checkbox">
							<input type="checkbox" id="brand-5">
							<label for="brand-5">
								<span></span>
								LG
								<small>(125)</small>
							</label>
						</div>
						<div class="input-checkbox">
							<input type="checkbox" id="brand-6">
							<label for="brand-6">
								<span></span>
								SONY
								<small>(755)</small>
							</label>
						</div>
					</div>
				</div>
				 /aside Widget -->

				<!-- aside Widget -->
				<div class="aside">
					<h3 class="aside-title">Top selling</h3>
					<div class="product-widget">
						<div class="product-img">
							<img src="./img/product01.png" alt="">
						</div>
						<div class="product-body">
							<p class="product-category">Category</p>
							<h3 class="product-name"><a href="#">product name goes here</a></h3>
							<h4 class="product-price">$980.00 <del class="product-old-price">$990.00</del></h4>
						</div>
					</div>

					<div class="product-widget">
						<div class="product-img">
							<img src="./img/product02.png" alt="">
						</div>
						<div class="product-body">
							<p class="product-category">Category</p>
							<h3 class="product-name"><a href="#">product name goes here</a></h3>
							<h4 class="product-price">$980.00 <del class="product-old-price">$990.00</del></h4>
						</div>
					</div>

					<div class="product-widget">
						<div class="product-img">
							<img src="./img/product03.png" alt="">
						</div>
						<div class="product-body">
							<p class="product-category">Category</p>
							<h3 class="product-name"><a href="#">product name goes here</a></h3>
							<h4 class="product-price">$980.00 <del class="product-old-price">$990.00</del></h4>
						</div>
					</div>
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
						Ordenar por:
						<select class="input-select ordenar">
							<option value="">Todo</option>
							<option value=" AND g.genero ='Mujer' ">Mujer</option>
							<option value=" AND g.genero ='Hombre'">Hombre</option>
							<option value=" AND g.genero = 'Niño' ">Niño</option>
							<option value=" AND g.genero = 'Niña' ">Niña</option>
						</select>
					</label>

					<label>
						Ver:
						<select class="input-select cantidadPagina">
							<option value="6">6</option>
							<option value="12">12</option>
							<option value="18">18</option>
							<option value="24">24</option>
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
				<div id="productoTablaInclude"></div>
	     	    <div id="loader"></div>

	     	    <script type="text/javascript">
			       
	   			</script>

			</div>
			<!-- /STORE -->
			
		</div>
		<!-- /row -->
	</div>
	<!-- /container -->
</div>
<!-- /SECTION -->
<script type="text/javascript">

	 function paginador(producto,precio,categoria,ordenar, cantidadPagina, paginaNumero) {
	 	
	 	if(categoria == ""){
	 		categoria = "todo";
	 	}
    	if(Array.isArray(categoria)){
    		categoria = JSON.stringify(categoria);
    	}
        $.ajax({
            type: "GET",
            url: "include/productoTablaInclude.php",
            data: {
            	producto:producto,
            	precio:precio,
            	categoria: categoria,
            	ordenar:ordenar,
            	paginaNumero:paginaNumero,
            	cantidadPagina:cantidadPagina
            },
            cache: false,
    		beforeSend: function() {
                $('#loader').html('<img src="gif/espere.gif" alt="reload" width="20" height="20">');
            },
            success: function(html) {
                $("#productoTablaInclude").html(html);
                $('#loader').html(''); 
            }
        });
    }

    $(document).ready(function() {

        paginador("","","todo","",6, 1);

         var categoria = new Array();

        $(".cantidadPagina").change(function(e){
        	e.preventDefault();
        	var cantidadPagina = $(this).val();
        	var ordenar = $(".ordenar").val();
        	var precio = "AND p.precio <= "+$('#price-max').val();
        	var producto = "<?php echo $producto ?>";
        	paginador(producto,precio,categoria,ordenar,cantidadPagina,1);
        });
        $(".ordenar").change(function(e){
        	e.preventDefault();
        	var ordenar = $(this).val();
        	var cantidadPagina = $(".cantidadPagina").val();
        	var precio = "AND p.precio <= "+$('#price-max').val();
        	//var producto = "<?php echo $producto ?>";
        	paginador("",precio,categoria,ordenar,cantidadPagina,1);
        });

       
        $(".categoria").change(function(e){
        	e.preventDefault();
        	if (this.checked) {
        		if($(this).val() == "todo"){
        			$(".categoria").prop('checked', false);
        			$(this).prop('checked', true);
        			var ordenar = $(".ordenar").val();
        			var cantidadPagina = $(".cantidadPagina").val();
        			var precio = "AND p.precio <= "+$('#price-max').val();
        			var producto = "<?php echo $producto ?>";
        			$("input[name='producto']").val("");
        			categoria = new Array();
        			console.log(categoria);
        			paginador("","",categoria,"",6,1);
        		}else{
        			if(categoria.length > 0 ){
        				categoria.push(" OR c.id_categoria = "+$(this).val());
        			}else{
        				categoria.push(" AND ( c.id_categoria = "+$(this).val());
        			}
        			$("#todo").prop('checked', false);
        			var ordenar = $(".ordenar").val();
        			var cantidadPagina = $(".cantidadPagina").val();
        			var precio = "AND p.precio <= "+$('#price-max').val();
        			var producto = "<?php echo $producto ?>";
        			console.log(categoria);
        			paginador("",precio,categoria,ordenar,cantidadPagina,1);
        		}
        	}else{
        		if($(this).val() == "todo"){
        			categoria = new Array();
        			$(".categoria").prop('checked', false);
        			$(this).prop('checked', true);
        			var ordenar = $(".ordenar").val();
        			var cantidadPagina = $(".cantidadPagina").val();
        			var precio = "AND p.precio <= "+$('#price-max').val();
        			var producto = "<?php echo $producto ?>";
        			$("input[name='producto']").val("");
        			console.log(categoria);
        			paginador("","",categoria,"",6,1);
        		}else{
        			if(categoria.length > 0 ){
        				categoria.push(" OR c.id_categoria = "+$(this).val());
        			}else{
        				categoria.push(" AND ( c.id_categoria = "+$(this).val());
        			}
        			$("#todo").prop('checked', false);
        			var index1 = categoria.indexOf(" OR c.id_categoria = "+$(this).val());
        			var index2 = categoria.indexOf(" AND c.id_categoria = "+$(this).val());
            		categoria.splice(index1, 1);
            		categoria.splice(index2, 1);
            		console.log(categoria);
            		var ordenar = $(".ordenar").val();
        			var cantidadPagina = $(".cantidadPagina").val();
        			var precio = "AND p.precio <= "+$('#price-max').val();
        			var producto = "<?php echo $producto ?>";
            		paginador("",precio,categoria,ordenar,cantidadPagina,1);
        		}
        	}
        });

        var priceSlider = document.getElementById('price-slider');
		if (priceSlider) {
			noUiSlider.create(priceSlider, {
				start: 1000,
				connect: true,
				step: 100,
				range: {
					'min': 1,
					'max': 1000
				}
			});
			priceSlider.noUiSlider.on('update', function(values) {
				$('#price-max').val(values);
				var precio = "AND p.precio <= "+$('#price-max').val();
				var ordenar = $(".ordenar").val();
        		var cantidadPagina = $(".cantidadPagina").val();
        		var producto = $("input[name='producto']").val();
        		var producto2 = "  AND  (p.producto like '%" + producto + "%' OR  c.categoria like '%" + producto + "%') ";
        		paginador(producto2,precio,categoria,ordenar,cantidadPagina,1);
			});
		}

    });
</script>
