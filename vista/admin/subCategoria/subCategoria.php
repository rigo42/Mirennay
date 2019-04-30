<div class="card">
    <div class="card-body">
        <h5 class="card-title m-b-0">Sub categorias</h5>
    </div>
    <div class="container">
      <div class="table-responsive">
      <table class="table table-hover">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Sub categorias</th>
                <th scope="col">Categoria</th>
                <th scope="col">Fecha</th>
              </tr>
            </thead>
            <tbody>
            	<?php 
              $n = 0;
            	foreach ($res as $key) {
            	?>
              <tr onclick="location='<?php echo URL ?>adminSubCategoria/editar?idSubCategoria=<?php echo urlencode(openssl_encrypt($key['id_sub_categoria'], COD, KEY)) ?> ' ">
                <th scope="row"><?php echo ++$n ?></th>
                <td><?php echo $key['sub_categoria'] ?></td>
                <td><?php echo $key['categoria'] ?></td>
                <td><?php echo $key['fechaAlta'] ?></td>
              </tr>
          	<?php } ?>
            </tbody>
      </table>
      </div>
   </div>
</div>