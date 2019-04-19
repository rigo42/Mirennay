<?php 
  $n=0;
	foreach ($res as $key) { 
	?>
        	
<div class="card">
    <div class="card-body">
        <h5 class="card-title m-b-0 folio" data-folio="<?php echo $key['folio'] ?>" style="cursor: pointer;"><?php echo $key['nombre_completo']." (".$key['folio'].")" ?></h5>
    </div>
    <div class="container">
      <div class="table-responsive">
      <table class="table table-hover">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Imagen</th>
                <th scope="col">Nombre</th>
                <th scope="col">Cantidad</th>
                <th scope="col">Talla</th>
                <th scope="col">Color</th>
              </tr>
            </thead>
            <tbody>
            	<?php 
            	$res2 = $this->mostrarPedidoDetalle($key['folio']);
            	foreach ($res2 as $key2) {
            	?>
              <tr>
                <th scope="row"><?php echo ++$n ?></th>
                <td><img class="col-md-2" src="<?php echo URL ?>libreria/imgProducto/<?php echo $key2['imagen_principal'] ?>"></td>
                <td><?php echo $key2['producto'] ?></td>
                <td><?php echo $key2['cantidad'] ?></td>
                <td><?php echo $key2['talla'] ?></td>
                <td><?php echo $key2['color'] ?></td>
              </tr>
          	<?php } $n=0; ?>
            </tbody>
      </table>
      </div>
   </div>
</div>

	<?php
   } 
	?>
<script type="text/javascript">
  $(document).ready(function(){

      $(".folio").click(function(e){
        e.preventDefault();
        var folio = $(this).attr("data-folio");
        modalDireccion(folio);
      });


  });
</script>