<?php foreach ($res as $key) { ?>
<div class="col-md-55">
  <div class="thumbnail">
    <div class="image view view-first producto">
      <img style="width: 100%; display: block;" src="<?php echo URL ?>libreria/imgProducto/<?php echo $key['imagen_principal'] ?>" alt="image" />
      <div class="mask">
        <p><?php echo $key['sub_categoria'] ?></p>
        
        <div class="tools tools-bottom">
          <!--
          <a href="#"><i class="fa fa-link"></i></a>
          <a href="#"><i class="fa fa-pencil"></i></a>
          <a href="#"><i class="fa fa-times"></i></a>
          -->
        </div>
      
      </div>
    </div>
    <div class="caption">
      <p>
        <?php if($key['activo_oferta'] == 1){
          echo "$".$key['precio_oferta']." Oferta";
        }else{
          echo $key['precio'];
        }
        ?></p>
    </div>
  </div>
</div>
<?php } ?>