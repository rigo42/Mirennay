<!-- Modal -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Dirección</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	<?php
      	foreach ($res as $key) {
      	?>
      	<p>Municipio: <?php echo $key['municipio'] ?></p>
      	<p>Calle: <?php echo $key['direccion'] ?></p>
    		<p>Observaciones: <?php echo $key['observacion'] ?></p>
    		<p>Codigo postal: <?php echo $key['codigo_postal'] ?></p>
    		<p>Celular: <?php echo $key['celular'] ?></p>
      	<?php } ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="enviarProducto" data-folio="<?php echo $folio ?>">Enviar producto</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
	$(document).ready(function(){

		$("#modal").modal("show");

		$("#enviarProducto").click(function(e){
			e.preventDefault();
			if(confirm("¿Ya entregaste el paquete a correos?")){
				var folio = $(this).attr("data-folio");
				obtenerPedido(folio);
			}
		});

	});
</script>