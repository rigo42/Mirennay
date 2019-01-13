<?php 
	session_start();
	if(isset($_SESSION['idUsuario'])){
		if(isset($_SESSION['carrito'])){
			include('conexion.php');
			$subTotal = 0;
			$subTotalEsteProducto = 0;
			$datos = $_SESSION['carrito'];
			for($i=0;$i<count($datos);$i++){
				$sqlCarrito = " SELECT SUM(pd.cantidad) AS 'sumaCantidad',p.*,pd.*,t.* 
								FROM producto p
								INNER JOIN producto_detalle pd ON pd.id_producto = p.id_producto
								INNER JOIN producto_talla t ON t.id_talla = pd.id_talla
								WHERE p.activo = 1  AND pd.activo = 1 AND pd.id_producto_detalle = ".$datos[$i]['idProductoDetalle']." ";
				$resCarrito = mysqli_query($conexion,$sqlCarrito);
				$cuantosProductos = mysqli_num_rows($resCarrito);

				foreach ($resCarrito as $keyCarrito) {
					$imagenPrincipal = $keyCarrito['imagen_principal'];
					$producto = $keyCarrito['producto'];
					$talla = $keyCarrito['talla'];
					$color = $keyCarrito['color'];
					if($keyCarrito['activo_oferta']==1){
						$costo = $keyCarrito['precio_oferta'];
					}else{
						$costo = $keyCarrito['precio'];
					}
				}

				 $subTotalEsteProducto = $costo * $datos[$i]['cantidad'];
				 $subTotal += $subTotalEsteProducto;
?>
				<div class="product-widget">
					<div class="product-img">
						<img src="imgProducto/<?php echo $imagenPrincipal ?>" alt="" data-id="<?php echo $datos[$i]['idProducto'] ?>">
					</div>
					<div class="product-body">
						<h3 class="product-name"><a href="productoDetalle.php?id=<?php echo $datos[$i]['idProducto'] ?>"><?php echo $producto ?></a></h3>
						<h4 class="product-price"><span class="qty">Cant. <?php echo $datos[$i]['cantidad'] ?> | Talla: <?php echo $talla ?> | Color: <?php echo $color; ?></span> | $<?php echo $subTotalEsteProducto; ?> MXN</h4>
					</div>
					<button class="delete" data-id="<?php echo $datos[$i]['idProductoDetalle'] ?>" data-cantidad="<?php echo $datos[$i]['cantidad'] ?>" ><i class="fa fa-close"></i></button>
				</div>
<?php 
			}

		}else{
			echo "No tienes nada en tu carrito";
			$subTotal = 0;
		}
	}else{
		echo "Necesitas iniciar sesión";
	}

 ?>


<script type="text/javascript">
	$(document).ready(function(){

			$(".product-img").click(function(e){
				e.preventDefault();
				var id = $(this).children("img").attr("data-id");
				location="productoDetalle.php?id="+id;
			});

			<?php 
				if(isset($_SESSION['idUsuario'])){
					if(isset($_SESSION['carrito'])){
			?>
				$(".delete").click(function(e){
					e.preventDefault();
					var idProductoDetalle = $(this).attr("data-id");
					var cantidad = $(this).attr("data-cantidad");
					carritoProductoVentanaCarrito(idProductoDetalle,cantidad);
				});

				$(".cuantosProductosCarrito").html("<?php echo count($datos); ?>");
				<?php 
				if(count($datos) > 0){
					?>
					$("#subTotal").html("<?php echo $subTotal ?>");
					$("#cart-btns").show();
					<?php
				}else{
					?>
					$("#subTotal").html("0");
					$("#cart-btns").hide();
					<?php
				}
				?>
			<?php 
					}else{
						?>
						$(".cuantosProductosCarrito").html("0");
						$("#cart-btns").hide();
						<?php
					}
				}else{
					?>
						$(".cuantosProductosCarrito").html("0");
						$("#cart-btns").hide();
					<?php
				}	
			 ?>
	});
	

	function carritoProductoVentanaCarrito(idProductoDetalle,cantidad){
    	 $.ajax({
            type: "POST",
            url: "include/servletProductoSesionInclude.php",
            data: {
            	idProductoDetalle:idProductoDetalle,
            	cantidad:cantidad,
            	actividad:"eliminar"
            },
            cache: false,
    		beforeSend: function() {
               $('.favoritoSpan').html('<img src="gif/espere.gif" alt="reload" width="20" height="20">');
            },
            success: function(data) {
        		productoVentanaCarrito();
            }
        });
    }
</script>