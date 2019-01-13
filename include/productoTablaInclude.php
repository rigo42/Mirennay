<?php
session_start();

require_once ("conexion.php");

//Acachar la pagina en la que se pidio
if(isset($_GET['paginaNumero'])) {
    $paginaNumero = $_GET['paginaNumero'];
}
//Acachar cuantos datos quiere ver
if(isset($_GET['cantidadPagina'])) {
    $cantidadPagina = $_GET['cantidadPagina'];
}
//Acachar como lo quiere ordenar
if(isset($_GET['ordenar']) || $_GET['ordenar'] == "") {
    $ordenar = $_GET['ordenar'];
}

//Acachar como el id de la categoria1
$categoriaSQL = "";
//si es diferente al valor "todo" entonces entrara aqui por que significa que selecciono varias categorias o minimo una categoria
// y las hize con la sintaxis json , que se descodifica con el json_decode
if ($_GET['categoria'] != "todo") {
  if($categoria = json_decode($_GET['categoria'])){
	    foreach($categoria  as $data){
	    	 $categoriaSQL .= $data;
	  }
	  $categoriaSQL .= ")";
  }else{
  		$categoriaSQL = $_GET['categoria'];
  }
}else{
	$categoriaSQL = "";
}
//Acachar el precio que pide el cliente
if(isset($_GET['precio'])) {
	if($_GET['precio'] == ""){
		$precio = "";
	}else{
		$precio = $_GET['precio'];
	}
}

//Acachar el producto que pide el cliente
if($_GET['producto'] == "") {
	$producto = "";
}else{
	$producto = $_GET['producto'];
}

$sql = "SELECT p.*,c.*,g.* FROM producto p
		INNER JOIN categoria c ON c.id_categoria = p.id_categoria 
		INNER JOIN producto_genero g ON g.id_genero = p.id_genero
		WHERE 1 
		".$producto."
		".$precio." 
		".$categoriaSQL."  ";

if ($res = mysqli_query($conexion, $sql)) {
     $rowCount = mysqli_num_rows($res);
    //Siempre se debe liberar el resultado con mysqli_free_result(), cuando el objeto del resultado ya no es necesario.
    //mysqli_free_result($res);
}

$pagesCount = ceil($rowCount / $cantidadPagina);

$limite = ($paginaNumero - 1) * $cantidadPagina;

$sql = "SELECT p.*,c.*,g.*,NOW() AS 'hoy',p.fecha_alta AS 'fecha_alta_producto' FROM producto p
		INNER JOIN categoria c ON c.id_categoria = p.id_categoria 
		INNER JOIN producto_genero g ON g.id_genero = p.id_genero
		WHERE 1 
		".$producto."
		".$precio."
		".$ordenar."	
		".$categoriaSQL."
		LIMIT ".$limite." , ".$cantidadPagina." ";
$res = mysqli_query($conexion, $sql);
if(mysqli_num_rows($res) > 0 ){

?>

<!-- store products -->
	<div class="row">
		<!-- product -->
		<?php foreach ($res as $data) { 
			$comprobarFavorito = 0;
			if(isset($_SESSION['idUsuario'])){
				$sqlComprobarFavorito = "SELECT pf.activo AS 'comprobarActivo' 
									 FROM producto_favorito pf
									 INNER JOIN usuario u ON u.id_usuario = pf.id_usuario
									 INNER JOIN producto p ON p.id_producto = pf.id_producto
									 WHERE p.id_producto = ".$data['id_producto']." AND u.id_usuario = ".$_SESSION['idUsuario']." ";
				$resComprobarFavorito = mysqli_query($conexion,$sqlComprobarFavorito);
				foreach ($resComprobarFavorito as $keyComprobarFavorito) {
					$comprobarFavorito = $keyComprobarFavorito['comprobarActivo'];
				}
			}
		?>
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
					<?php if(isset($_SESSION['idUsuario'])){ ?>
							<?php if($comprobarFavorito == 1){ ?>
							<button class="add-to-wishlist" data-idProducto="<?php echo $data['id_producto'] ?>"><i class="fa fa-heart"></i><span class="tooltipp favoritoSpan">Quitar</span></button>
							<?php }else{ ?>
							<button class="add-to-wishlist" data-idProducto="<?php echo $data['id_producto'] ?>"><i class="fa fa-heart-o"></i><span class="tooltipp favoritoSpan">Añadir</span></button>
							<?php } ?>
					<?php 
						}else{
							?>
							<button class="add-to-wishlist"><i class="fa fa-heart-o"></i><span class="tooltipp favoritoSpan">Añadir</span></button>
							<?php
						}
					 ?>
						<button class="quick-view" data-id="<?php echo $data['id_producto'] ?>"><i class="fa fa-eye"></i><span class="tooltipp">quick view</span></button>
					</div>
				</div>
			</div>
			</div>
			 <?php  
				} 
			}else{
				echo "<h3>No se encontro este producto :c intente de nuevo</h3>";
			}
				mysqli_free_result($res);
			 ?>
		<!-- /product -->
	</div>
	<!-- /store products -->

	<!-- paginador -->
	<?php 
  	//Operacion matematica para botón siguiente y atrás 
    $incrementarNum = (($paginaNumero + 1) <= $pagesCount) ? ($paginaNumero + 1) : 1;
    $decrementarNum = (($paginaNumero -1))<1?1:($paginaNumero - 1);
	 ?>

<!-- store bottom filter -->
	<div class="store-filter clearfix">
		<span class="store-qty">Mirando <?php echo $cantidadPagina; ?> de <?php echo $rowCount; ?> productos</span>
		<ul class="store-pagination">
			<li><a href="#" onclick="paginador('<?php echo $producto ?>','<?php echo $precio; ?>','<?php echo $categoriaSQL; ?>','<?php echo $ordenar;  ?>','<?php echo $cantidadPagina;  ?>', '<?php echo $decrementarNum; ?>');"><i class="fa fa-angle-left"></i></a></li>
			<?php
			//Se resta y suma con el numero de pag actual con el cantidad de 
			    //números  a mostrar
			     $desde=$paginaNumero-(ceil($paginaNumero/2)-1);
			     $hasta=$paginaNumero+(ceil($paginaNumero/2)-1);
			     
			     //Se valida
			     $desde=($desde<1)?1: $desde;
			     $hasta=($hasta<$paginaNumero)?$paginaNumero:$hasta;
			     //Se muestra los números de paginas
			     for($i=$desde; $i<=$hasta;$i++){
			        //Se valida la paginacion total
			        //de registros
			        if($i<=$pagesCount){
			            //Validamos la pag activo
			          if($i==$paginaNumero){
			          ?>
			             <li class="active"><a href="#" style="color: #fff;"><?php echo $i ?></a></li>
			          <?php
			          }else {
			           ?>
			              <li><a href="#"  onclick="paginador('<?php echo $producto ?>','<?php echo $precio; ?>','<?php echo $categoriaSQL; ?>','<?php echo $ordenar;  ?>','<?php echo $cantidadPagina;  ?>', '<?php echo $i; ?>');"><?php echo $i ?></a></li>
			           <?php
			          }             
			        }
			     }
			?>
            <li><a href="#"  onclick="paginador('<?php echo $producto ?>','<?php echo $precio; ?>','<?php echo $categoriaSQL; ?>','<?php echo $ordenar;  ?>','<?php echo $cantidadPagina;  ?>', '<?php echo $incrementarNum; ?>');"><i class="fa fa-angle-right"></i></a></li>			
		</ul>
	</div>
	<!-- /store bottom filter -->
	<!-- paginador -->

<script type="text/javascript">
	
	$(".product-img img").click(function(e){
		e.preventDefault();
		var id = $(this).attr("data-id");
		location="productoDetalle.php?id="+id;
	});
	
	$(".quick-view").click(function(e){
		var id = $(this).attr("data-id");
		location="productoDetalle.php?id="+id;
	});

	//Script para escuchar cuando le den click a Agregar favorito o Quitar favorito y posteriormente se guarda en la bd
	$(".add-to-wishlist").click(function(e){
		e.preventDefault();
		<?php if(isset($_SESSION['idUsuario'])){ ?>
		if($(this).children("i").hasClass("fa fa-heart")){
			$(this).children("i").removeClass("fa fa-heart");
			$(this).children("i").addClass("fa fa-heart-o");
			$(this).children(".favoritoSpan").html("Añadir a favoritos");
			var activo = 0;
			var actividad = "editar";
			var idProducto = $(this).attr("data-idProducto");
			favoritoProductoInclude(activo,idProducto,"<?php echo $_SESSION['idUsuario'] ?>",actividad);
		}else if($(this).children("i").hasClass("fa fa-heart-o")){
			$(this).children("i").removeClass("fa fa-heart-o");
			$(this).children("i").addClass("fa fa-heart");
			$(this).children(".favoritoSpan").html("Quitar de favoritos");
			var activo = 1;
			var actividad = "nuevo";
			var idProducto = $(this).attr("data-idProducto");
			favoritoProductoInclude(activo,idProducto,"<?php echo $_SESSION['idUsuario'] ?>",actividad);
		}
		<?php }else{
			?>
			alert("Debe estar registrado");
			<?php
		} 
		?>
	});

	 function favoritoProductoInclude(activo,idProducto,idUsuario,actividad){
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
               $('.favoritoSpan').html('<img src="gif/espere.gif" alt="reload" width="20" height="20">');
            },
            success: function(data) {
            	if(data == 1){
            		if(activo == 0){
						$(".favoritoSpan").html("Añadir a favoritos");
            		}else{
						$(".favoritoSpan").html("Quitar de favoritos");
            		}
        			 productoVentanaFavorito();
        		}else{
        			alert(data);
        		}
            }
        });
    }

</script>