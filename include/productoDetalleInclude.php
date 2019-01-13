<?php 
	include('conexion.php');

	
	if($_GET['id'] != null){
		$idProducto = $_GET['id'];
		$comprobarFavorito = 0;
		if(isset($_SESSION['idUsuario'])){
			$sqlComprobarFavorito = "SELECT pf.activo AS 'comprobarActivo' FROM producto_favorito pf
								 INNER JOIN usuario u ON u.id_usuario = pf.id_usuario
								 INNER JOIN producto p ON p.id_producto = pf.id_producto
								 WHERE pf.id_producto = ".$idProducto." AND pf.id_usuario = ".$_SESSION['idUsuario']." ";
			$resComprobarFavorito = mysqli_query($conexion,$sqlComprobarFavorito);
			foreach ($resComprobarFavorito as $keyComprobarFavorito) {
				$comprobarFavorito = $keyComprobarFavorito['comprobarActivo'];
			}
		}

		$sqlEstrella = " SELECT count(id_producto_comentario) as 'cantidadEstrella',sum(cantidad_estrella) as 'sumaEstrella'
		 				 FROM producto_comentario
		 				 WHERE 1 AND activo = 1 AND id_producto = ".$idProducto;
		$resEstrella = mysqli_query($conexion,$sqlEstrella);
		foreach ($resEstrella as $keyEstrella ) {
			$personas = $keyEstrella['cantidadEstrella'];
			if($keyEstrella['sumaEstrella'] == 0){
				$estrellas = 0;
			}else if($keyEstrella['cantidadEstrella'] == 0){
				$estrellas = 0;
			}else{
				$estrellas = round($keyEstrella['sumaEstrella'] / $keyEstrella['cantidadEstrella'],0);
			}
			
		}

		$sqlProducto = "SELECT p.*,pd.*,t.*,c.*
						FROM producto p
						INNER JOIN producto_detalle pd ON pd.id_producto = p.id_producto
						INNER JOIN categoria c ON c.id_categoria = p.id_categoria
						INNER JOIN producto_talla t ON t.id_talla = pd.id_talla
						WHERE p.activo = 1 AND pd.activo = 1 AND c.activo = 1 AND t.activo = 1 AND p.id_producto = ".$idProducto;
		$resProducto = mysqli_query($conexion,$sqlProducto);
		foreach ($resProducto as $keyProducto) {
			$imagen_principal = $keyProducto['imagen_principal'];
			$id_categoria = $keyProducto['id_categoria'];
			$categoria = $keyProducto['categoria'];
			$producto = $keyProducto['producto'];
			$descripcion = $keyProducto['descripcion'];
			$observacion = $keyProducto['observacion'];
			$precio = $keyProducto['precio'];
			$talla = $keyProducto['talla'];
			$color = $keyProducto['color'];
			$activoOferta = $keyProducto['activo_oferta'];
			$precioOferta = $keyProducto['precio_oferta'];
		}

		$sqlDetalle = "SELECT p.*,pd.*,t.*,c.*
						FROM producto p
						INNER JOIN producto_detalle pd ON pd.id_producto = p.id_producto
						INNER JOIN categoria c ON c.id_categoria = p.id_categoria
						INNER JOIN producto_talla t ON t.id_talla = pd.id_talla
						WHERE p.activo = 1 AND pd.activo = 1 AND c.activo = 1 AND t.activo = 1 AND p.id_producto = ".$idProducto;
		$resDetalle = mysqli_query($conexion,$sqlDetalle);

		if(isset($_SESSION['idUsuario'])){
			$sqlUsuario = " SELECT * FROM usuario
							WHERE activo = 1 AND id_usuario = ".$_SESSION['idUsuario'];
			$resUsuario = mysqli_query($conexion,$sqlUsuario);
			foreach ($resUsuario as $keyUsuario) {
				$usuario = $keyUsuario['usuario'];
				$correo = $keyUsuario['correo'];
			}
		}



		?>
		<!-- BREADCRUMB -->
		<div id="breadcrumb" class="section">
		<!-- container -->
		<div class="container">
			<!-- row -->
			<div class="row">
				<div class="col-md-12">
					<ul class="breadcrumb-tree">
						<li><a href="index.php">Inicio</a></li>
						<li><a href="producto.php">Todas las categorias</a></li>
						<li><a href="producto.php?producto=<?php echo $categoria; ?>"><?php echo $categoria; ?></a></li>
						<li class="active"><?php echo $producto ?></li>
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
			<!-- row -->
			<div class="row">
				<!-- Product main img -->
				<div class="col-md-5 col-md-push-2">
					<div id="product-main-img">
						<div class="product-preview">
							<img src="imgProducto/<?php echo $imagen_principal ?>" alt="">
						</div>
					<?php
						foreach ($resProducto as $keyProducto) {
							for ($i=1; $i <= 7; $i++) { 
							if($keyProducto['imagen'.$i] != ""){
					?>
						<div class="product-preview">
							<img src="imgProducto/<?php echo $keyProducto['imagen'.$i] ?>" alt="">
						</div>
					<?php } }  } ?>
					</div>
				</div>
				<!-- /Product main img -->

				<!-- Product thumb imgs -->
				<div class="col-md-2  col-md-pull-5">
					<div id="product-imgs">
						<div class="product-preview">
							<img src="imgProducto/<?php echo $imagen_principal ?>" alt="">
						</div>
					<?php
					foreach ($resProducto as $keyProducto) {
						for ($i=1; $i <= 7; $i++) { 
						if($keyProducto['imagen'.$i] != ""){
					 ?>
					<div class="product-preview">
						<img src="imgProducto/<?php echo $keyProducto['imagen'.$i] ?>" alt="">
					</div>
					<?php } }  } ?>
					</div>
				</div>
				<!-- /Product thumb imgs -->

				<!-- Product details -->
				<div class="col-md-5">
					<div class="product-details">
						<h2 class="product-name"><?php echo $producto ?></h2>
						<div>
							<div class="product-rating">
								<?php 
									if($personas > 0){
										for ($i=1; $i <= 5 ; $i++) { 
											if($estrellas >= $i){
												?>
												 <i class="fa fa-star"></i>
												<?php
											}else{
												?>
												 <i class="fa fa-star-o"></i>
												<?php
											}
										}
									}else{
										?>	
										<i class="fa fa-star-o"></i>
										<i class="fa fa-star-o"></i>
										<i class="fa fa-star-o"></i>
										<i class="fa fa-star-o"></i>
										<i class="fa fa-star-o"></i>		
										<?php
									}
								
							 ?>
							</div>
								<a data-toggle="tab" href="#tab3" class="review-link" id="cantidadComentarios"></a>
								<?php if(isset($_SESSION['idUsuario'])){ ?>
								<a data-toggle="tab" href="#tab3" class="review-link">| Añadir tu comentario</a> 
								<?php } ?>
						</div>

						<div>
							<h3 class="product-price">
								<?php 
								if($activoOferta==1){
							 ?>
								$<?php echo $precioOferta ?> MXN <del class="product-old-price">$<?php echo $precio ?></del>
							 <?php 
							 	}else{
							 		?>
								$<?php echo $precio ?> MXN
							 		<?php
							 	}
							  ?>
							</h3>
							<span class="product-available">In Stock</span>
						</div>

						<p><?php echo $descripcion ?></p>

						<div class="product-options">
							<label>
								TALLA - COLOR
								<select class="input-select" name="id_producto_detalle" id="id_producto_detalle">
									<?php foreach ($resDetalle as $keyDetalle) {	 ?>
									<option value="<?php echo $keyDetalle['id_producto_detalle'] ?>">Talla (<?php echo $keyDetalle['talla'] .") Color (". $keyDetalle['color'] ?>)</option>
									<?php } ?>
								</select>
							</label>
						</div>

						<div class="add-to-cart">
							<div class="qty-label">
								Cantidad
								<div class="input-number">
									<select class="input-select" name="cantidad">
										
									</select>
								</div>
							</div>
							<?php 
								
								$encontro = false;
								$numero = 0;
								if(isset($_SESSION['carrito'])){
									$datos = $_SESSION['carrito'];
									for ($i=0; $i < count($datos); $i++) { 
										if($datos[$i]['idProducto'] == $idProducto){
											$numero = $i;
											$encontro = true;
										}
									}
								}
								if($encontro == true){
									?>
										<button class="add-to-cart-btn"><i class="fa fa-shopping-cart"></i> <span>Dentro del carrito</span></button>
									<?php
								}else{
									?>
									<button class="add-to-cart-btn"><i class="fa fa-shopping-cart"></i> <span>Añadir al carrito</span></button>
									<?php
								}
							 ?>

							
						
						</div>
						<?php if(isset($_SESSION['idUsuario'])){ ?>
						<ul class="product-btns">
							<?php if($comprobarFavorito == 0){ ?>
							<li><a href="#" class="favorito"><i class="fa fa-heart-o" ></i> <span id="favoritoSpan">Añadir a favoritos</span></a></li>
							<?php }else{
							?>
							<li><a href="#" class="favorito"><i class="fa fa-heart"></i> <span id="favoritoSpan">Quitar de favoritos</span></a></li>
							<?php
							} 
							?>
						</ul>
						<?php } ?>

						<ul class="product-links">
							<li>Categoria:</li>
							<li><a href="producto.php?producto=<?php echo $categoria; ?>"><?php echo $categoria ?></a></li>
						</ul>

						<ul class="product-links">
							<li>Compartir:</li>
							<li><a href="#"><i class="fa fa-facebook"></i></a></li>
							<li><a href="#"><i class="fa fa-twitter"></i></a></li>
							<li><a href="#"><i class="fa fa-google-plus"></i></a></li>
							<li><a href="#"><i class="fa fa-envelope"></i></a></li>
						</ul>

					</div>
				</div>
				<!-- /Product details -->



				<!-- Product tab -->
				<div class="col-md-12">
					<div id="product-tab">
						<!-- product tab nav -->
						<div id="dezplazar"></div>

						<ul class="tab-nav">
							<li class="active"><a data-toggle="tab" href="#tab1">Descripción</a></li>
							<li><a data-toggle="tab" href="#tab2">Detalles</a></li>
							<li id="activeTab3"><a data-toggle="tab" href="#tab3" id="cantidadComentarios2"></a></li>
						</ul>
						<!-- /product tab nav -->
						

						<!-- product tab content -->
						<div class="tab-content">
							<!-- tab1  -->
							<div id="tab1" class="tab-pane fade in active">
								<div class="row">
									<div class="col-md-12">
										<p><?php echo $descripcion ?>.</p>
									</div>
								</div>
							</div>
							<!-- /tab1  -->

							<!-- tab2  -->
							<div id="tab2" class="tab-pane fade in">
								<div class="row">
									<div class="col-md-12">
										<p><?php echo $observacion ?>.</p>
									</div>
								</div>
							</div>
							<!-- /tab2  -->
							

							<!-- tab3  -->
							<div id="tab3" class="tab-pane fade in">
								<div class="row">

									<!-- Rating -->
									<div id="productoEncuestaInclude"></div>
									<div id="loaderEncuesta"></div>
									<!-- /Rating -->

									<!-- Comentarios -->
									<div id="productoComentarioTablaInclude"></div>
									<div id="loader"></div>
									<!-- /Comentarios -->

								<?php if(isset($_SESSION['idUsuario'])){ 
								?>
									<!-- Review Form -->
									<div class="col-md-3">
										<div id="review-form">
											<form class="review-form">
												<input disabled="" class="input" type="text" value="<?php echo $usuario ?>" required="">
												<input disabled="" class="input" type="email" value="<?php echo $correo ?>" required="" >
												<textarea class="input" placeholder="Your Review" name="comentario" maxlength="200" required=""></textarea>
												<input type="hidden" name="actividad" value="nuevo">
												<div class="input-rating">
													<span>Tu calificación:</span>
													<div class="stars">
														<input id="star5" name="cantidadEstrella" value="5" type="radio"><label for="star5"></label>
														<input id="star4" name="cantidadEstrella" value="4" type="radio"><label for="star4"></label>
														<input id="star3" name="cantidadEstrella" value="3" type="radio"><label for="star3"></label>
														<input id="star2" name="cantidadEstrella" value="2" type="radio"><label for="star2"></label>
														<input id="star1" name="cantidadEstrella" value="1" type="radio"><label for="star1"></label>
													</div>
												</div>
												<p id="comentarioMal" style="color:red;"></p>
												<button class="primary-btn" id="publicarComentario">Publicar comentario</button>
											</form>
										</div>
									</div>
									<!-- /Review Form -->
								<?php } ?>
								</div>
							</div>
							<!-- /tab3  -->
						</div>
						<!-- /product tab content  -->
					</div>
				</div>
				<!-- /product tab -->
			</div>
			<!-- /row -->
		</div>
		<!-- /container -->
		</div>
		<!-- /SECTION -->
		<?php 
		$sqlProductoRelacionado = "SELECT p.*,c.*,g.*,NOW() AS 'hoy',p.fecha_alta AS 'fecha_alta_producto' FROM producto p
				INNER JOIN categoria c ON c.id_categoria = p.id_categoria 
				INNER JOIN producto_genero g ON g.id_genero = p.id_genero
				WHERE  p.activo = 1 AND g.activo = 1 AND c.activo = 1 AND p.id_producto != ".$idProducto." AND c.id_categoria = ".$id_categoria." 
				ORDER BY p.id_producto DESC LIMIT 4 ";
		$resProductoRelacionado = mysqli_query($conexion, $sqlProductoRelacionado);
		if(mysqli_num_rows($resProductoRelacionado) > 0 ){
		?>
		<!-- Section -->
		<div class="section">
		<!-- container -->
		<div class="container">
			<!-- row -->
			<div class="row">

				<div class="col-md-12">
					<div class="section-title text-center">
						<h3 class="title">Producos relacionados</h3>
					</div>
				</div>

			<!-- product -->
			<?php foreach ($resProductoRelacionado as $data) { ?>
			<div class="col-md-4 col-xs-6">
				<div class="product">
					<div class="product-img" >
						<img src="imgProducto/<?php echo $data['imagen_principal'] ?>" alt="" data-id="<?php echo $data['id_producto'] ?>">
						<div class="product-label">
							<?php 
							if($data['activo_oferta'] == 1 ){
								$porcentaje = 100 - round(($data['precio_oferta'] * 100) / $data['precio'],0);
								?>
								<span class="sale">-<?php echo $porcentaje ?>%</span>
								<?php
							}
						 	?>
							
							<?php 
								$fechaAlta = date_create($data['fecha_alta']);
								date_add($fechaAlta, date_interval_create_from_date_string('7 days'));
								$fechaFinNuevo = date_format($fechaAlta, 'Y-m-d');
								if($data['fecha_alta'] <= $fechaFinNuevo){
									?>
									 <span class="new">NEW</span>
									<?php
								}

							 ?>
							
						</div>
					</div>
					<div class="product-body seleccion">
						<p class="product-category"><?php echo $data['categoria'] ?></p>
						<h3 class="product-name"><a href="productoDetalle.php"><?php echo $data['producto'] ?></a></h3>

						<h4 class="product-price">
							<?php 
								if($data['activo_oferta']==1){
							 ?>
								$<?php echo $data['precio_oferta'] ?> <del class="product-old-price">$<?php echo $data['precio'] ?></del>
							 <?php 
							 	}else{
							 		?>
								$<?php echo $data['precio'] ?>
							 		<?php
							 	}
							  ?>
						</h4>
						<div class="product-rating">
							<?php 
								$sqlEstrella = " SELECT count(id_producto_comentario) as 'cantidadEstrella',sum(cantidad_estrella) as 'sumaEstrella'
		 				 			FROM producto_comentario
		 				 			WHERE id_producto = ".$data['id_producto'];
								$resEstrella = mysqli_query($conexion,$sqlEstrella);

								foreach ($resEstrella as $key) {
									if($key['cantidadEstrella'] > 0){
										$estrellas = round($key['sumaEstrella'] / $key['cantidadEstrella'],0);
										for ($i=1; $i <= 5 ; $i++) { 
											if($estrellas >= $i){
												?>
												 <i class="fa fa-star"></i>
												<?php
											}else{
												?>
												 <i class="fa fa-star-o"></i>
												<?php
											}
										}
									}else{
										for ($i=1; $i <= 5 ; $i++) { 
											?>
											<i class="fa fa-star-o"></i>
											<?php
										}
									}
								}
							 ?>
						</div>
						<div class="product-btns">
							<button class="quick-view" data-id="<?php echo $data['id_producto'] ?>"><i class="fa fa-eye"></i><span class="tooltipp">quick view</span></button>
						</div>
					</div>
				</div>
				</div>
				 <?php  
					} 
				}else{
					//echo "<h3>No se encontro este producto :c intente de nuevo</h3>";
				}
					mysqli_free_result($resProductoRelacionado);
				 ?>
			<!-- /product -->

			</div>
			<!-- /row -->
		</div>
		<!-- /container -->
		</div>
		<!-- /Section -->

		<script type="text/javascript">
		$(document).ready(function(){
		// Product Main img Slick
		$('#product-main-img').slick({
		infinite: true,
		speed: 300,
		dots: false,
		arrows: true,
		fade: true,
		asNavFor: '#product-imgs',
		});

		$('#product-imgs').slick({
		slidesToShow: 3,
		slidesToScroll: 1,
		arrows: true,
		centerMode: true,
		focusOnSelect: true,
			centerPadding: 0,
			vertical: true,
		asNavFor: '#product-main-img',
			responsive: [{
		    breakpoint: 991,
		    settings: {
						vertical: false,
						arrows: false,
						dots: true,
		        }
		      },
		    ]
		  });


		var zoomMainProduct = document.getElementById('product-main-img');
		if (zoomMainProduct) {
			$('#product-main-img .product-preview').zoom();
		}

		//Script automatico al iniciar la pagina el cual obtendra el tipo de color y ropa que se muestra primero para 
		//mostrar cuanta ropa hay de este mismo color y talla
		var id_producto_detalle = $("select[name='id_producto_detalle']").val();
		selectCantidadProducto(id_producto_detalle);

		//Script para escuchar cuando el cliente cambie de seleccion del tipo de COLOR Y TALLA 
		//Y se le enviara a una funcion para que esta me traiga la cantidad de ropa total que se tiene de esta mismo color y talla
		$("#id_producto_detalle").change(function(){
			var id_producto_detalle = $(this).val();
			$(".add-to-cart-btn span").html("Añadir al carrito");
			selectCantidadProducto(id_producto_detalle);
		});

		$("select[name='cantidad']").change(function(){
			$(".add-to-cart-btn span").html("Añadir al carrito");
		});


		//Script para ver el producto
		$(".product-img").click(function(e){
			e.preventDefault();
			var id = $(this).children("img").attr("data-id");
			location="productoDetalle.php?id="+id;
		});

		//Script para ver el producto
		$(".quick-view").click(function(e){
			var id = $(this).attr("data-id");
			location="productoDetalle.php?id="+id;
		});

		//Script para deslizar hasta la parte de abajo donde se ven los comentarios
		$(".review-link").click(function(){
			$(".tab-nav li").removeClass("active");
			$("#activeTab3").addClass("active");
			$('html,body').animate({
		        scrollTop: $("#dezplazar").offset().top
		    }, 500);
		});

		//Script para escuchar cuando le den click a Agregar favorito o Quitar favorito y posteriormente se guarda en la bd
		$(".favorito").click(function(e){
			e.preventDefault();
			<?php if(isset($_SESSION['idUsuario'])){ ?>
			if($("ul li .favorito i").hasClass("fa fa-heart")){
				$("ul li .favorito i").removeClass("fa fa-heart");
				$("ul li .favorito i").addClass("fa fa-heart-o");
				$("#favoritoSpan").html("Añadir a favoritos");
				var activo = 0;
				var actividad = "editar";
				favoritoProductoDetalle(activo,"<?php echo $idProducto ?>","<?php echo $_SESSION['idUsuario'] ?>",actividad);
			}else if($("ul li .favorito i").hasClass("fa fa-heart-o")){
				$("ul li .favorito i").removeClass("fa fa-heart-o");
				$("ul li .favorito i").addClass("fa fa-heart");
				$("#favoritoSpan").html("Quitar de favoritos");
				var activo = 1;
				var actividad = "nuevo";
				favoritoProductoDetalle(activo,"<?php echo $idProducto ?>","<?php echo $_SESSION['idUsuario'] ?>",actividad);
			}
			<?php }else{
				?>
				alert("Debe estar registrado");
				<?php
			} 
			?>
		});

		//Script para publicar un comentario y validar que el cliente califique este producto, solo si hay una sesión
		$("#publicarComentario").click(function(e){
			e.preventDefault();
			<?php if(isset($_SESSION['idUsuario'])){  ?>
				var cantidadEstrella = "";
				$(".stars input").each(function(d){
					if(this.checked){
						 cantidadEstrella = $(this).val();
					}
				});
				if(cantidadEstrella == ""){
					$("#comentarioMal").html("Selecciona una calificacion de estrella");
				}else{
					$("#comentarioMal").html("");
					var id_producto = "<?php echo $idProducto; ?>";
					var id_usuario = "<?php echo $_SESSION['idUsuario']; ?>";
					var comentario = $("textarea[name='comentario']").val();
					var actividad = $("input[name='actividad']").val();
					publicarComentario(id_producto,id_usuario,comentario,cantidadEstrella,actividad);				
				}
			<?php } ?>
			
		});

		$(".add-to-cart-btn").click(function(e){
			e.preventDefault();
			<?php if(isset($_SESSION['idUsuario'])){ ?>
			var idProducto = "<?php echo $idProducto; ?>";
			var idProductoDetalle = $("#id_producto_detalle").val();
			var cantidad = $("select[name='cantidad']").val();
			$(this).children("span").html("Agregado");
			carritoProductoDetalleInclude(idProducto,idProductoDetalle,cantidad);
			<?php 
				}else{
					?>
					alert("Debe estar registrado");
					<?php
				}
			 ?>
		});

		//Script automatico para ejecutar la funcion del paginador de comentarios
		paginador("<?php echo $idProducto ?>",3,1);
		//Script automatico para ejecutar la funciona que sirve para mostrar una y otra ves la tabla de encuesta 
		//cada ves que se requiera llamar esta funcion
		productoEncuesta("<?php echo $idProducto ?>");


		});

		function selectCantidadProducto(id_producto_detalle){
			$.post('include/selectCantidadProducto.php',{
				id_producto_detalle:id_producto_detalle
			},function(data){
				$("select[name='cantidad']").html(data);
			});
		}

		function paginador(id_producto,cantidadPagina, paginaNumero) {
		    $.ajax({
		        type: "POST",
		        url: "include/productoComentarioTablaInclude.php",
		        data: {
		        	id_producto:id_producto,
		        	paginaNumero:paginaNumero,
		        	cantidadPagina:cantidadPagina
		        },
		        cache: false,
				beforeSend: function() {
		            $('#loader').html('<img src="gif/espere.gif" alt="reload" width="20" height="20">');
		        },
		        success: function(html) {
		            $("#productoComentarioTablaInclude").html(html);
		            $('#loader').html(''); 
		        }
		    });
		}

		function productoEncuesta(id_producto) {
		    $.ajax({
		        type: "POST",
		        url: "include/productoEncuestaInclude.php",
		        data: {
		        	id_producto:id_producto
		        },
		        cache: false,
				beforeSend: function() {
		            $('#loaderEncuesta').html('<img src="gif/espere.gif" alt="reload" width="20" height="20">');
		        },
		        success: function(html) {
		            $("#productoEncuestaInclude").html(html);
		            $('#loaderEncuesta').html(''); 
		        }
		    });
		}

		function publicarComentario(id_producto,id_usuario,comentario,cantidadEstrella,actividad){
			 $.ajax({
		        type: "POST",
		        url: "include/servletProductoComentarioInclude.php",
		        data: {
		        	id_producto:id_producto,
		        	id_usuario:id_usuario,
		        	comentario:comentario,
		        	cantidadEstrella:cantidadEstrella,
		        	actividad:actividad
		        },
		        cache: false,
				beforeSend: function() {
		            $('#publicarComentario').html('<img src="gif/espere.gif" alt="reload" width="20" height="20">');
		        },
		        success: function(data){
		        	if(data == 1){
		        		paginador("<?php echo $idProducto ?>",3,1);
		        		productoEncuesta("<?php echo $idProducto ?>");
		            	$('#publicarComentario').html('Publicar comentario'); 
		            	Push.create("Aviso",{
							body: "Comentario agregado con exito",
							timeout: 4000,
							icon: 'img//M.png'
						});
		        	}else{
		        		alert(data);
		        	}
		            
		        }
		    });
		}

		function favoritoProductoDetalle(activo,idProducto,idUsuario,actividad){
			 $.ajax({
		        type: "POST",
		        url: "include/servletProductoFavoritoInclude.php",
		        data: {
		        	activo:activo,
		        	idProducto:idProducto,
		        	idUsuario:idUsuario,
		        	actividad:actividad
		        },
		        cache: false,
				beforeSend: function() {
		           $('#favoritoSpan').html('<img src="gif/espere.gif" alt="reload" width="20" height="20">');
		        },
		        success: function(data) {
		        	if(data == 1){
		        		if(activo == 0){
							$("#favoritoSpan").html("Añadir a favoritos");
		        		}else{
							$("#favoritoSpan").html("Quitar de favoritos");
		        		}
		    			 productoVentanaFavorito();
		    		}else{
		    			alert(data);
		    		}
		        }
		    });
		}
		function carritoProductoDetalleInclude(idProducto,idProductoDetalle,cantidad){
			 $.ajax({
		        type: "POST",
		        url: "include/servletProductoSesionInclude.php",
		        data: {
		        	idProducto:idProducto,
		        	idProductoDetalle:idProductoDetalle,
		        	cantidad:cantidad
		        },
		        cache: false,
				beforeSend: function() {
		        },
		        success: function(data) {
		    		productoVentanaCarrito();
		        }
		    });
		}

		</script>
		<?php
	}else{
		echo "<h3>Porfavor envie el identificador del producto</h3>";
	}