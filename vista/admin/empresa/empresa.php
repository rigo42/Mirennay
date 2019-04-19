<div class="card">
    <div class="card-body">
        <h5 class="card-title m-b-0">Empresas</h5>
    </div>
    <div class="container">
      <div class="table-responsive">
      <table class="table table-hover">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Empresa</th>
                <th scope="col">Dirección</th>
                <th scope="col">Celular</th>
                <th scope="col">Correo</th>
              </tr>
            </thead>
            <tbody>
            	<?php 
              $n = 0;
            	foreach ($res as $key) {
            	?>
              <tr onclick="location='<?php echo URL ?>empresa/editar?idEmpresa=<?php echo urlencode(openssl_encrypt($key['id_empresa'], COD, KEY)) ?> ' ">
                <th scope="row"><?php echo ++$n ?></th>
                <td><?php echo $key['empresa'] ?></td>
                <td><?php echo $key['direccion'] ?></td>
                <td><?php echo $key['celular'] ?></td>
                <td><?php echo $key['correo'] ?></td>
              </tr>
          	<?php } ?>
            </tbody>
      </table>
      </div>
   </div>
</div>