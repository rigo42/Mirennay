
<?php 
	include('conexion.php');
	$producto = "";
	if(isset($_GET['producto'])){
		 $producto = " AND  (p.producto like '%" . $_GET['producto'] . "%' OR  c.categoria like '%" . $_GET['producto'] . "%') ";
		?>
		<script type="text/javascript">
			$(document).ready(function(){
				$("input[name='producto']").val("<?php echo $_GET['producto'] ?>");
				 paginador("","","<?php echo $producto ?>","","",6, 1);
			});
		</script>
		<?php
	}

	$idCategoriaPadre = "";
	if(isset($_GET['idCategoriaPadre'])){
		 $idCategoriaPadre = " AND  ( cp.id_categoria_padre = ". $_GET['idCategoriaPadre'] . " ) ";
		?>
		<script type="text/javascript">
			$(document).ready(function(){
				 paginador("","<?php echo $idCategoriaPadre ?>","","","",6, 1);
			});
		</script>
		<?php
	}

	$sql = "SELECT c.*,count(p.id_producto) as 'cuantos'
			FROM categoria c
			INNER JOIN producto p ON p.id_categoria = c.id_categoria
			INNER JOIN categoria_padre cp ON cp.id_categoria_padre = c.id_categoria_padre
			WHERE c.activo = 1 AND p.activo = 1
			GROUP by c.categoria";
	$categoria = mysqli_query($conexion,$sql);

$sqlProductoMasVendido = "SELECT p.*, SUM(pu.cantidad) AS TotalVentas, c.* ,p.fecha_alta AS 'fecha_alta_producto',NOW() AS 'hoy'
							FROM pedido_usuario pu
						    INNER JOIN producto_detalle pd ON pd.id_producto_detalle = pu.id_producto_detalle 
						    INNER JOIN producto p ON p.id_producto = pd.id_producto
                            INNER JOIN categoria c ON c.id_categoria = p.id_categoria
						    GROUP BY p.id_producto 
						    ORDER BY SUM(pu.cantidad) DESC 
						    LIMIT 0 , 6";
$resProductoMasVendido = mysqli_query($conexion, $sqlProductoMasVendido);
$rowProductoMasVendido = mysqli_num_rows($resProductoMasVendido);
$validarProductoVendido = false;
if($rowProductoMasVendido > 0){
	$validarProductoVendido = true;
}

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
								<small></small>
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
					<h3 class="aside-title">Precio</h3>
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
				
				<?php if($validarProductoVendido == true){ ?>
				<!-- aside Widget -->
				<div class="aside">
					<h3 class="aside-title">Mas vendido</h3>

					<?php foreach ($resProductoMasVendido as $keyProductoMasVendido) { ?>
						<!-- product widget -->
						<div class="product-widget">
							<div class="product-img">
								<img src="imgProducto/<?php echo $keyProductoMasVendido['imagen_principal'] ?>" alt="">
							</div>
							<div class="product-body">
								<p class="product-category"><?php echo $keyProductoMasVendido['categoria'] ?></p>
								<h3 class="product-name"><a href="#"><?php echo $keyProductoMasVendido['producto'] ?></a></h3>
								<h4 class="product-price">
									<?php 
										if($keyProductoMasVendido['activo_oferta']==1){
									 ?>
										$<?php echo $keyProductoMasVendido['precio_oferta'] ?> <del class="product-old-price">$<?php echo $keyProductoMasVendido['precio'] ?></del>
									 <?php 
									 	}else{
									 		?>
										$<?php echo $keyProductoMasVendido['precio'] ?>
									 		<?php
									 	}
									  ?>
								</h4>
							</div>
						</div>
						<!-- product widget -->
						<?php } ?>

				</div>
				<!-- /aside Widget -->
				<?php } ?>
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

			</div>
			<!-- /STORE -->
			
		</div>
		<!-- /row -->
	</div>
	<!-- /container -->
</div>
<!-- /SECTION -->
<script type="text/javascript">

	 function paginador(idCategoriaPadre,producto,precio,categoria,ordenar, cantidadPagina, paginaNumero) {
	 	
	 	if(categoria == ""){
	 		categoria = " ";
	 	}else if(Array.isArray(categoria)){
    		categoria = JSON.stringify(categoria);
    	}
        $.ajax({
            type: "GET",
            url: "include/productoTablaInclude.php",
            data: {
            	producto:producto,
            	precio:precio,
            	categoria: categoria,
            	idCategoriaPadre:idCategoriaPadre,
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

        paginador("","","","","",6, 1);

         var categoria = new Array();

        $(".cantidadPagina").change(function(e){
        	e.preventDefault();
        	var cantidadPagina = $(this).val();
        	var ordenar = $(".ordenar").val();
        	var precio = "AND p.precio <= "+$('#price-max').val();
        	var producto = "<?php echo $producto ?>";
        	var idCategoriaPadre = "<?php echo $idCategoriaPadre ?>";
        	paginador(idCategoriaPadre,producto,precio,categoria,ordenar,cantidadPagina,1);
        });
        $(".ordenar").change(function(e){
        	e.preventDefault();
        	var ordenar = $(this).val();
        	var cantidadPagina = $(".cantidadPagina").val();
        	var precio = "AND p.precio <= "+$('#price-max').val();
        	//var producto = "<?php echo $producto ?>";
        	paginador("","",precio,categoria,ordenar,cantidadPagina,1);
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
        			paginador("","","","","",6,1);
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
        			paginador("","",precio,categoria,ordenar,cantidadPagina,1);
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
        			paginador("","","","","",6,1);
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
            		paginador("","",precio,categoria,ordenar,cantidadPagina,1);
        		}
        	}
        });

        var priceSlider = document.getElementById('price-slider');
		if (priceSlider) {
			noUiSlider.create(priceSlider, {
				start: 30000,
				connect: true,
				step: 100,
				range: {
					'min': 1,
					'max': 30000
				}
			});
			priceSlider.noUiSlider.on('update', function(values) {
				$('#price-max').val(values);
				var precio = "AND p.precio <= "+$('#price-max').val();
				var ordenar = $(".ordenar").val();
        		var cantidadPagina = $(".cantidadPagina").val();
        		var producto = $("input[name='producto']").val();
        		var idCategoriaPadre = "<?php echo $idCategoriaPadre ?>";
        		var producto2 = "  AND  (p.producto like '%" + producto + "%' OR  c.categoria like '%" + producto + "%') ";
        		paginador(idCategoriaPadre,producto2,precio,categoria,ordenar,cantidadPagina,1);
			});
		}

    });
</script>
