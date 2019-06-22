<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
              <h5 class="card-title m-b-0">Tallas</h5>
            </div>
        </div>
    </div>
    <div class="container">
      <div class="table-responsive">
      <table class="table table-hover">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Talla</th>
                <th scope="col">Fecha</th>
              </tr>
            </thead>
            <tbody>
            	<?php 
              $n = 0;
            	foreach ($res as $key) {
            	?>
              <tr onclick="location='<?php echo URL ?>adminTalla/editar?idTalla=<?php echo urlencode(openssl_encrypt($key['id_talla'], COD, KEY)) ?> ' ">
                <th scope="row"><?php echo ++$n ?></th>
                <td><?php echo $key['talla'] ?></td>
                <td><?php echo $key['fechaAlta'] ?></td>
              </tr>
          	<?php } ?>
            </tbody>
      </table>
      </div>
   </div>
</div>