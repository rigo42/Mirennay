<div class="card">
    <div class="card-body">
        <h5 class="card-title m-b-0">Categorias</h5>
    </div>
    <div class="container">
      <div class="table-responsive">
      <table class="table table-hover">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Categorias</th>
                <th scope="col">Imagen</th>
                <th scope="col">Fecha</th>
              </tr>
            </thead>
            <tbody>
            	<?php 
              $n = 0;
            	foreach ($res as $key) {
            	?>
              <tr onclick="location='<?php echo URL ?>adminCategoria/editar?idCategoria=<?php echo urlencode(openssl_encrypt($key['id_categoria'], COD, KEY)) ?> ' ">
                <th scope="row"><?php echo ++$n ?></th>
                <td><?php echo $key['categoria'] ?></td>
                <td><img class="col-md-2" src="<?php echo URL ?>libreria/imgCategoria/<?php echo $key['imagen_principal'] ?>"></td>
                <td><?php echo $key['fechaAlta'] ?></td>
              </tr>
          	<?php } ?>
            </tbody>
      </table>
      </div>
   </div>
</div>