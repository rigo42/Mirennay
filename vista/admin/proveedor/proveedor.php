<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
              <h5 class="card-title m-b-0">Proveedor</h5>
            </div>
        </div>
    </div>
    <div class="container">
      <div class="table-responsive">
      <table class="table table-hover">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Proveedor</th>
                <th scope="col">Empresa</th>
                <th scope="col">Fecha</th>
              </tr>
            </thead>
            <tbody>
            	<?php 
              $n = 0;
            	foreach ($res as $key) {
            	?>
              <tr onclick="location='<?php echo URL ?>adminProveedor/editar?idProveedor=<?php echo urlencode(openssl_encrypt($key['id_proveedor'], COD, KEY)) ?> ' ">
                <th scope="row"><?php echo ++$n ?></th>
                <td><?php echo $key['proveedor'] ?></td>
                <td><?php echo $key['empresa'] ?></td>
                <td><?php echo $key['fechaAlta'] ?></td>
              </tr>
          	<?php } ?>
            </tbody>
      </table>
      </div>
   </div>
</div>