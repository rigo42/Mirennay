 <!-- Img galery -->
<script src="<?php echo URL ?>libreria/js/admin/jquery.magnific-popup.min.js"></script>
<script src="<?php echo URL ?>libreria/js/admin/meg.init.js"></script>
<?php 
    $row = $res->rowCount();
    if($row > 0){
    foreach ($res as $key) {
 ?>
<div class="col-lg-3 col-md-6">
    <div class="card">
        <div class="el-card-item">
            <div class="el-card-avatar el-overlay-1"> <img src="<?php echo URL ?>libreria/imgProducto/<?php echo $key['imagen_principal'] ?>" alt="user" />
                <div class="el-overlay">
                    <ul class="list-style-none el-info">
                        <li class="el-item"><a class="btn default btn-outline image-popup-vertical-fit el-link" href="<?php echo URL ?>libreria/imgProducto/<?php echo $key['imagen_principal'] ?>"><i class="mdi mdi-magnify-plus"></i></a></li>
                        <li class="el-item"><a class="btn default btn-outline el-link" href="<?php echo URL ?>almacen/editar?idProducto=<?php echo urlencode(openssl_encrypt($key['id_producto'], COD, KEY))?>"><i class="fas fa-edit"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="el-card-content">
                <h4 class="m-b-0"><?php echo $key['producto'] ?></h4> 
                <span class="text-muted">
                <?php 
                    if($key['activo_oferta'] == 1){
                        echo $key['precio_oferta']." MXN Oferta";
                    }else{
                        echo $key['precio']." MXN";
                    }
                 ?>
                </span>
            </div>
        </div>
    </div>
</div>
<?php 
    }
   }else{
    echo "No se encontro producto en almacen";
   }
 ?>