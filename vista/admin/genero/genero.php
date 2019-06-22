<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
              <h5 class="card-title m-b-0">Genero</h5>
            </div>
        </div>
    </div>
    <div class="container">
      <div class="table-responsive">
      <table class="table table-hover">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Genero</th>
                <th scope="col">Fecha</th>
              </tr>
            </thead>
            <tbody>
            	<?php 
              $n = 0;
            	foreach ($res as $key) {
            	?>
              <tr onclick="location='<?php echo URL ?>adminGenero/editar?idGenero=<?php echo urlencode(openssl_encrypt($key['id_genero'], COD, KEY)) ?> ' ">
                <th scope="row"><?php echo ++$n ?></th>
                <td><?php echo $key['genero'] ?></td>
                <td><?php echo $key['fechaAlta'] ?></td>
              </tr>
          	<?php } ?>
            </tbody>
      </table>
      </div>
   </div>
</div>