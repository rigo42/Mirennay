<?php 
foreach ($res as $key) {
 ?>
 <option value="<?php echo openssl_encrypt($key['id_municipio'], COD, KEY) ?>"><?php echo $key['municipio'] ?></option>
 <?php } ?>