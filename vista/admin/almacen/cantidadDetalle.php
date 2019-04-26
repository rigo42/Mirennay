<?php 
    for ($i=$inicioCantidad; $i <= $cantidadColor; $i++) { 
 ?>
<div class="card">
    <div class="card-body wizard-content">
        <h4 class="card-title">Color <?php echo $i ?></h4>
        <h6 class="card-subtitle"></h6>

        <div class="row mb-3">
            <div class="col-lg-3">
                <label for="userName">Talla <?php echo $i ?> *</label>
                <select required="" class="select form-control" name="idTalla<?php echo $i ?>" style="width: 100%; height:36px;">
                    <option value="">Seleccione una opción</option>
                    <?php 
                    $res = $this->selectTalla();
                    foreach ($res as $key) {
                     ?>
                     <option value="<?php echo openssl_encrypt($key['id_talla'], COD, KEY) ?>"><?php echo $key['talla'] ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-lg-3">
                <label>Color <?php echo $i ?>*</label>
                <input required="" placeholder="Verde con un poco de azul" name="color<?php echo $i ?>" type="text" class="form-control">
            </div>
            
            <div class="col-lg-3">
                <label>Codigo <?php echo $i ?>*</label>
                <input required="" placeholder="Codigo de barra" name="codigo<?php echo $i ?>" type="text" class="form-control">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-lg-3">
                <label>Cantidad <?php echo $i ?>*</label>
                <input required="" placeholder="Cuantos productos son de este color" name="cantidad<?php echo $i ?>" type="number" class="form-control">
            </div>
            <div class="col-lg-3">
                <label>Cantidad alerta <?php echo $i ?>*</label>
                <input required="" placeholder="Cantidad minima de producto" name="cantidadAlerta<?php echo $i ?>" type="number" class="form-control">
            </div>
        </div>

        <div class="row mb-3">
            <?php 
            for ($j=1; $j <= 3; $j++) {
            ?>
            <div class="col-lg-4">
                <label class="col-md-4">Imagen <?php echo $j ?> *</label>
                <div class="col-md-12">
                    <div class="custom-file">
                        <input type="file" name="imagen<?php echo $j.$i ?>" class="form-control">
                    </div>
                </div>
            </div>
         <?php } ?>
        </div>
        <div class="row mb-3">
            <?php 
            for ($j=4; $j <= 6; $j++) {
            ?>
            <div class="col-lg-4">
                <label class="col-md-4">Imagen <?php echo $j ?> *</label>
                <div class="col-md-12">
                    <div class="custom-file">
                        <input type="file" name="imagen<?php echo $j.$i ?>" class="form-control">
                    </div>
                </div>
            </div>
         <?php } ?>
        </div>
    </div>
</div>
<?php } ?>