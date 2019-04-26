<!-- Modal -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Datos de envio</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

         <!-- Nav tabs -->
          <ul class="nav nav-tabs" role="tablist">
              <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#direccion" role="tab"><span class="hidden-sm-up"></span> <span class="hidden-xs-down">Dirección</span></a> </li>
              <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#profile" role="tab"><span class="hidden-sm-up"></span> <span class="hidden-xs-down">Productos</span></a> </li>
          </ul>
          <!-- Tab panes -->
          <div class="tab-content tabcontent-border">

              <div class="tab-pane active" id="direccion" role="tabpanel">
                  <div class="p-20">
                    <?php
                      foreach ($res as $key) {
                      ?>
                      <p><b>Municipio:</b> <?php echo $key['municipio'] ?></p>
                      <p><b>Calle:</b> <?php echo $key['direccion'] ?></p>
                      <p><b>Observaciones:</b> <?php echo $key['observacion'] ?></p>
                      <p><b>Codigo postal:</b> <?php echo $key['codigo_postal'] ?></p>
                      <p><b>Celular:</b> <?php echo $key['celular'] ?></p>
                   <?php } ?>
                  </div>
              </div>

              <div class="tab-pane  p-20" id="profile" role="tabpanel">
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
                            $n = 0;
                            $res = $this->mostrarPedidoDetalle($folio);
                            foreach ($res as $key) {
                            ?>
                            <tr>
                              <th scope="row"><?php echo ++$n ?></th>
                              <td><img class="img-fluid" src="<?php echo URL ?>libreria/imgProducto/<?php echo $key['imagen_principal'] ?>"></td>
                              <td><?php echo $key['producto'] ?></td>
                              <td><?php echo $key['cantidad'] ?></td>
                              <td><?php echo $key['talla'] ?></td>
                              <td><?php echo $key['color'] ?></td>
                            </tr>
                          <?php } ?>
                          </tbody>
                    </table>
                  </div>
              </div>

          </div>
      	
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Volver</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
	$(document).ready(function(){

		$("#modal").modal("show");

	});
</script>