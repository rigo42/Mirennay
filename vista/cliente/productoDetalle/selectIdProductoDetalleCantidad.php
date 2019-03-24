<?php 
	if($cantidad > 0){
		for ($i=1; $i <= $cantidad; $i++) { 
?>
			<option value="<?php echo $i ?>"><?php echo $i ?></option>
<?php
		}
?>
	<script type="text/javascript">
		$(".add-to-cart-btn").css("display","block");
	</script>
<?php
	}else{
?>
		<option value="">Producto agotado</option>
		<script type="text/javascript">
			$(".add-to-cart-btn").css("display","none");
		</script>
<?php
	}
 ?>