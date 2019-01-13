<?php
require_once ("conexion.php");


//Acachar la pagina en la que se pidio
if(isset($_POST['paginaNumero'])) {
    $paginaNumero = $_POST['paginaNumero'];
}
//Acachar cuantos datos quiere ver
if(isset($_POST['cantidadPagina'])) {
    $cantidadPagina = $_POST['cantidadPagina'];
}

if(isset($_POST['id_producto'])) {
    $id_producto = $_POST['id_producto'];
}

$sql = "SELECT p.*,pc.*,u.* FROM producto_comentario pc
		INNER JOIN producto p ON pc.id_producto = p.id_producto
		INNER JOIN usuario u ON u.id_usuario = pc.id_usuario
		WHERE 1 AND pc.id_producto = ".$id_producto." AND p.activo = 1 AND pc.activo = 1 AND u.activo =1";
if ($res = mysqli_query($conexion, $sql)) {
     $rowCount = mysqli_num_rows($res);
    //Siempre se debe liberar el resultado con mysqli_free_result(), cuando el objeto del resultado ya no es necesario.
    //mysqli_free_result($res);
}

$pagesCount = ceil($rowCount / $cantidadPagina);

$limite = ($paginaNumero - 1) * $cantidadPagina;

$sql = "SELECT p.*,pc.*,u.*, u.fecha_alta AS 'fecha_comentario' FROM producto_comentario pc
		INNER JOIN producto p ON pc.id_producto = p.id_producto
		INNER JOIN usuario u ON u.id_usuario = pc.id_usuario
		WHERE 1 AND p.activo = 1 AND pc.activo = 1 AND u.activo = 1 AND pc.id_producto = ".$id_producto."  
		ORDER BY pc.id_producto_comentario DESC
		LIMIT ".$limite." , ".$cantidadPagina." ";
$res = mysqli_query($conexion, $sql);
if(mysqli_num_rows($res) > 0 ){

?>

<div class="col-md-6">
	<div id="reviews">
		<ul class="reviews">
			<?php 
				foreach ($res as $key) {
			 ?>
			<li>
				<div class="review-heading">
					<h5 class="name"><?php echo $key['usuario'] ?></h5>
					<p class="date"><?php echo $key['fecha_comentario'] ?></p>
					<div class="review-rating">
						<?php 
							for ($i=1; $i <= 5 ; $i++) { 
								if($key['cantidad_estrella'] >= $i){
									?>
									 <i class="fa fa-star"></i>
									<?php
								}else{
									?>
									 <i class="fa fa-star-o"></i>
									<?php
								}
							}
						
						 ?>
					</div>
				</div>
				<div class="review-body">
					<p><?php echo $key['comentario'] ?></p>
				</div>
			</li>
			<?php } ?>
		</ul>
		<!-- paginador -->
	<?php 
  	//Operacion matematica para botón siguiente y atrás 
    $incrementarNum = (($paginaNumero + 1) <= $pagesCount) ? ($paginaNumero + 1) : 1;
    $decrementarNum = (($paginaNumero -1))<1?1:($paginaNumero - 1);
	 ?>

<!-- store bottom filter -->
		<ul class="reviews-pagination">
			<li><a href="#" id="paginadorAtras"><i class="fa fa-angle-left"></i></a></li>
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
			             <li class="active"><?php echo $i ?></li>
			          <?php
			          }else {
			           ?>
			              <li><a href="#" class="paginacion" data-i="<?php echo $i ?>"><?php echo $i ?></a></li>
			           <?php
			          }             
			        }
			     }
			?>
            <li><a href="#" id="paginadorAdelante" ><i class="fa fa-angle-right"></i></a></li>			
		</ul>
	<!-- /store bottom filter -->
	<!-- paginador -->
	</div>
</div>

<?php 

}else{
	?>
<div class="col-md-6">
	<div id="reviews">
		<ul class="reviews">
			<li>
				<div class="review-heading">
					<h5 class="name"></h5>
					<p class="date"></p>
					<div class="review-rating">
						
					</div>
				</div>
				<div class="review-body">
					<p></p>
				</div>
			</li>
		</ul>
	</div>
</div>
	<?php
}
 ?>
 <script type="text/javascript">
 	$(document).ready(function(){

	 	$("#paginadorAdelante").click(function(e){
	 		e.preventDefault();
	 		var id_producto = "<?php echo $id_producto ?>";
	 		var cantidadPagina = "<?php echo $cantidadPagina ?>";
	 		var paginaNumero = "<?php echo $incrementarNum ?>";
	 		paginadorAdelanteAtras(id_producto,cantidadPagina,paginaNumero);
	 	});

	 	$(".paginacion").click(function(e){
	 		e.preventDefault();
	 		var id_producto = "<?php echo $id_producto ?>";
	 		var cantidadPagina = "<?php echo $cantidadPagina ?>";
	 		var paginaNumero = $(this).attr("data-i");
	 		paginadorAdelanteAtras(id_producto,cantidadPagina,paginaNumero);
	 	});

	 	$("#paginadorAtras").click(function(e){
	 		e.preventDefault();
	 		var id_producto = "<?php echo $id_producto ?>";
	 		var cantidadPagina = "<?php echo $cantidadPagina ?>";
	 		var paginaNumero = "<?php echo $decrementarNum ?>";
	 		paginadorAdelanteAtras(id_producto,cantidadPagina,paginaNumero);
 		});
	});

 	function paginadorAdelanteAtras(id,cant,pag){
 		 $.ajax({
	            type: "POST",
	            url: "include/productoComentarioTablaInclude.php",
	            data: {
	            	id_producto:id,
	            	cantidadPagina:cant,
	            	paginaNumero:pag
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
 	
 </script>


 