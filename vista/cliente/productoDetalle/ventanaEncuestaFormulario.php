<?php if(isset($_SESSION['idUsuario'])){ 
	$idProducto = $_POST['idProducto'];
?>
	<!-- Review Form -->
	<div class="col-md-3">
		<div id="review-form">
			<form class="review-form">
				<input disabled="" class="input" type="text" value="<?php echo $_SESSION['usuario'] ?>" required="">
				<input disabled="" class="input" type="email" value="<?php echo $_SESSION['correo'] ?>" required="" >
				<textarea class="input" placeholder="Your Review" name="comentario" maxlength="200" required=""></textarea>
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
				<button class="primary-btn" id="publicarComentario"  data-idProducto="<?php echo $idProducto ?>">Publicar comentario</button>
			</form>
		</div>
	</div>
	<!-- /Review Form -->
<?php } ?>

<script type="text/javascript">
	$(document).ready(function(){
		//Script para publicar un comentario y validar que el cliente califique este producto, solo si hay una sesión
		$("#publicarComentario").click(function(e){
			e.preventDefault();
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
				var idProducto = $(this).attr("data-idProducto");
				var comentario = $("textarea[name='comentario']").val();
				if(comentario != "" ){
					publicarComentario(idProducto,comentario,cantidadEstrella);
				}else{
					$("#comentarioMal").html("Completa el comentario");
				}			
			}
		});

	});

	
</script>