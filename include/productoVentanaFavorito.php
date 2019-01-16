<?php 
	session_start();
	include('conexion.php');
	if(isset($_SESSION['idUsuario'])){
	$sqlFavorito = "SELECT SUM(pd.cantidad) AS 'sumaCantidad', pf.*,p.*,pd.* FROM producto_favorito pf
					INNER JOIN producto p ON p.id_producto = pf.id_producto
					INNER JOIN producto_detalle pd ON pd.id_producto = p.id_producto
					INNER JOIN usuario u ON u.id_usuario = pf.id_usuario
					WHERE p.activo = 1 AND pf.activo = 1 AND pd.activo = 1 AND u.id_usuario = ".$_SESSION['idUsuario']."
					GROUP by p.id_producto
					ORDER BY pf.fecha_alta DESC";
	$resFavorito = mysqli_query($conexion,$sqlFavorito);
	$cuantosProductos = mysqli_num_rows($resFavorito);
	if($cuantosProductos == 0){
			echo "Actualmente no tienes un producto favorito";
	}else{
		foreach ($resFavorito as $keyFavorito) {
		?>
			<div class="product-widget">
				<div class="product-img">
					<img src="imgProducto/<?php echo $keyFavorito['imagen_principal'] ?>" alt="" data-id="<?php echo $keyFavorito['id_producto'] ?>">
				</div>
				<div class="product-body">
					<h3 class="product-name"><a href="productoDetalle.php?id=<?php echo $keyFavorito['id_producto'] ?>"><?php echo $keyFavorito['producto'] ?></a></h3>
					<h4 class="product-price"><span class="qty"><?php echo $keyFavorito['sumaCantidad'] ?> In Stock
					<?php 
					if($keyFavorito['activo_oferta'] == 1){ ?>
					</span><?php echo $keyFavorito['precio_oferta'] ?> MXN</h4>
					<?php }else{
					?>
					</span><?php echo $keyFavorito['precio'] ?> MXN</h4>
					<?php
					} 
					?>
				</div>
				<button class="delete deleteFavorito" data-id="<?php echo $keyFavorito['id_producto'] ?>" data-idUsuario="<?php echo $_SESSION['idUsuario'] ?>"><i class="fa fa-close"></i></button>
			</div>
			<?php
		}
	}
	
	?>
	<script type="text/javascript">

		$(".product-img").click(function(e){
			e.preventDefault();
			var id = $(this).children("img").attr("data-id");
			location="productoDetalle.php?id="+id;
		});

		<?php if(isset($_SESSION['idUsuario'])){ ?>

			$(".deleteFavorito").click(function(e){
				e.preventDefault();
				var activo = 0;
				var idProducto = $(this).attr("data-id");
				var actividad = "editar";
				favoritoProducto(activo,idProducto,actividad);
			});

			$("#cuantosProductosFavoritos").html("<?php echo $cuantosProductos ?>");

		<?php }else{ ?>
			$("#cuantosProductosFavoritos").html("0");
		<?php } ?>
	</script>
<?php
	}else{
		?>
		<script type="text/javascript">
			$("#cuantosProductosFavoritos").html("0");
		</script>
		<?php
	echo "<h6>Necesitas estar registrado para poder guardar en favoritos</h6>";

	} 
?>
