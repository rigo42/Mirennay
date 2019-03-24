<?php 

	$datos = $_SESSION['carrito'];
	$countDatos = count($datos);
	$subTotalNeto = 0;
	$subTotal = 0;

	if($countDatos > 0){

	for($i=0;$i<count($datos);$i++){
		$subTotal = $datos[$i]['precio'] * $datos[$i]['idProductoDetalleCantidad'];
		$subTotalNeto += $subTotal;
?>
		<div class="product-widget">
			<div class="product-img">
				<img src="<?php echo URL ?>libreria/imgProducto/<?php echo $datos[$i]['imagenPrincipal'] ?>" alt="">
			</div>
			<div class="product-body">
				<h3 class="product-name"><a href="<?php URL ?>ProductoDetalle?idProducto=<?php  echo urlencode(openssl_encrypt($datos[$i]['idProducto'], COD, KEY)) ?>"><?php echo $datos[$i]['producto'] ?></a></h3>
				<h4 class="product-price"><span class="qty">Cant. <?php echo $datos[$i]['idProductoDetalleCantidad'] ?> | Talla: <?php echo $datos[$i]['talla'] ?> | Color: <?php echo $datos[$i]['color']; ?></span> | $<?php echo $subTotal; ?> MXN</h4>
			</div>
			<button class="delete" data-idProductoDetalle="<?php echo openssl_encrypt( $datos[$i]['idProductoDetalle'], COD, KEY) ?>"><i class="fa fa-close"></i></button>
		</div>
		<?php } ?>
	<?php
		}else{
			echo "Actualmente no tiene nada en el carrito";
		}
?>
<input type="hidden" name="countDatos" value="<?php echo $countDatos ?>">
<input type="hidden" name="subTotalNeto" value="<?php echo $subTotalNeto ?>">


<script type="text/javascript">
	$(document).ready(function(){
		
		var countDatos = $("input[name='countDatos']").val();
		var subTotalNeto = $("input[name='subTotalNeto']").val();

		if(countDatos > 0){
			$("#checkout").css("display","block");
			$("#subTotal").html("SUBTOTAL: $<?php echo $subTotalNeto ?> MXN");
			$(".delete").click(function(e){
				e.preventDefault();
				var idProductoDetalle = $(this).attr("data-idProductoDetalle");
				deleteProductoCarrito(idProductoDetalle);
			});
		}else{
			$("#checkout").css("display","none");
		}

		$(".cuantosProductosCarrito").html(countDatos);
	});
</script>