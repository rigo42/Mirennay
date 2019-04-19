 <div class="card">
  <div class="card-body">
      <h5 class="card-title m-b-0 folio">Punto de venta</h5>
  </div>
  <div class="container">
    <div class="table-responsive">
    <table class="table table-hover">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Nombre</th>
              <th scope="col">Cantidad</th>
              <th scope="col">Color - Talla</th>
              <th scope="col">Precio</th>
              <th scope="col">Sub total</th>
              <th scope="col">Eliminar</i></th>
            </tr>
          </thead>
          <tbody>
          	<?php 
          		$n = 0;
              $totalNeto = 0;
			        for ($i=0; $i<$count; $i++) {
                $totalNeto += $datos[$i]['subTotal'];
                $iva = $totalNeto * 0.16;
                $totalNetoIva = $totalNeto * 1.16;
		        ?>
            <tr>
              <th scope="row"><?php echo ++$n ?></th>
              <td><?php echo $datos[$i]['producto'] ?></td>
              <td><input type="number" name="cantidadPedido" value="<?php echo $datos[$i]['cantidadPedido'] ?>" data-codigo="<?php echo  $datos[$i]['codigo']?>"></td>
              <td><?php echo $datos[$i]['color']." | ".$datos[$i]['talla'] ?></td>
              <td><?php echo $datos[$i]['precio'] ?></td>
              <td><?php echo $datos[$i]['subTotal'] ?></td>
              <td><i class="fas fa-trash-alt eliminar" data-codigo="<?php echo  $datos[$i]['codigo']?>" style="cursor: pointer;"></td>
            </tr>
        	 <?php } ?>
          </tbody>
    </table>
    </div>

  </div>
</div>
<?php 
  if($count > 0){
 ?>
<div class="card">
  <div class="card-body">
      <h5 class="card-title m-b-0 folio" style="cursor: pointer;">Cobro</h5>
  </div>
  <div class="row container">
    <div class="col-md-8">
      <button type="button" class="btn btn-secondary cancelar">Cancelar</button>
     <button type="button" class="btn btn-success pagar">Pagar</button>
    </div>
    <div class="col-md-4">
       <p><b>Total</b> $<?php echo $totalNetoIva ?></p>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Confirmar</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6">
            <h6>Datos de la compra</h6>
            <p>Total $<?php echo $totalNeto ?></p>
            <p>Mas iva: $<?php echo $iva ?></p>
            <p><b>Total neto: $<?php echo $totalNetoIva ?></b></p>
            <input type="hidden" name="totalNetoIva" value="<?php echo $totalNetoIva ?>">
          </div>
          <div class="col-md-6">
            <h6>Cantidad de pago</h6>
            <input type="number" class="col-md-8" name="cantidadPago">
          </div>
          <div class="col-md-12">
            <p id="cambioPago" style="justify-content: center;display: flex;"></p>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Volver</button>
        <button type="button" class="btn btn-primary" id="confirmar" style="display: none;">Confirmar</button>
      </div>
    </div>
  </div>
</div>

<?php } ?>

<script type="text/javascript">
  $(document).ready(function(){

    $("input[name='cantidadPedido']").keyup(function(e){
      if(e.keyCode == 13){
        var cantidadPedido = $(this).val();
        var codigo = $(this).attr("data-codigo");
        addCart(codigo,cantidadPedido);
      }
    }); 

    $(".eliminar").click(function(e){
      e.preventDefault();
      if(confirm("¿Estas seguro que quieres quitar este producto?")){
        var codigo = $(this).attr("data-codigo");
        deleteCart(codigo);
      }
    });

    $(".cancelar").click(function(e){
      e.preventDefault();
      dropCart();
    });

    $(".pagar").click(function(e){
      e.preventDefault();
      $("#modal").modal("show");
    });

    $("input[name='cantidadPago']").keyup(function(e){
      if(e.keyCode == 13){
        validarPago();
      }
    });

    $("#confirmar").click(function(e){
      e.preventDefault();
      var validar = validarPago();
      if(validar == true){
        confirmarPago();
      }
    });

  });

  function validarPago(){
    var cantidadPago = parseFloat($("input[name='cantidadPago']").val());

    var totalNetoIva = parseFloat($("input[name='totalNetoIva']").val());

    if(cantidadPago < totalNetoIva){
      $("#cambioPago").html("El pago es inferior al total");
      $("#confirmar").css("display","none");
      return false;
    }else{
      var cambio = (cantidadPago - totalNetoIva);
      var cambioParceado = cambio.toFixed(2);
      $("#cambioPago").html("Su cambio es de: $"+cambioParceado);
      $("#confirmar").css("display","block");
      return true;
    }
  }
</script>