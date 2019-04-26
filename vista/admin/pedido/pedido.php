<div class="row">
  <div class="col-md-6">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title m-b-0">Pedidos recientes</h4>
        </div>
        <div class="comment-widgets scrollable">
            
            <?php 
            foreach ($res as $key) { 

              if(!empty($key['imagen'])){
                $imagen = $key['imagen'];
              }else{
                 $imagen = "default.jpg";
              }

            ?>
            <!-- Comment Row -->
            <div class="d-flex flex-row comment-row m-t-0">
                <div class="p-2"><img src="<?php echo URL ?>libreria/imgCliente/<?php echo $imagen ?>" alt="user" width="50" class="rounded-circle"></div>
                <div class="comment-text w-100">
                    <h6 class="font-medium "> <?php echo $key['nombre_completo']." (".$key['folio'].")" ?></h6>
                    <span class="m-b-15 d-block"></span>
                    <div class="comment-footer">
                        <span class="text-muted float-right"><?php echo $key['fecha_alta'] ?></span> 
                        <button type="button" class="btn btn-primary btn-sm folio" data-folio="<?php echo $key['folio'] ?>">Ver</button>
                        <button type="button" class="btn btn-success btn-sm enviarProducto" data-folio="<?php echo $key['folio'] ?>">Enviar</button>
                    </div>
                </div>
            </div>
            <!-- // Comment Row -->
            <?php } ?>
            
        </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function(){

      $(".folio").click(function(e){
        e.preventDefault();
        var folio = $(this).attr("data-folio");
        modalDireccion(folio);
      });

      $(".enviarProducto").click(function(e){
        e.preventDefault();
        if(confirm("¿Ya entregaste el paquete a correos?")){
          var folio = $(this).attr("data-folio");
          obtenerPedido(folio);
        }
      });

  });
</script>