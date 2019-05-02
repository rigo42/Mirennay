
  <link rel="stylesheet" href="<?php echo URL ?>libreria/css/admin/ticket.css">
  
  <div class="ticket">
    <img src="<?php echo URL ?>libreria/img/M.png" alt="Logotipo">
    <p class="centrado">Mirennay
      <br><?php echo date("Y-m-d h:i:sa") ?> #<?php echo $value['folio'] ?>
      <br>23/08/2017 08:22 a.m.</p>
    <table>
      <thead>
        <tr>
          <th class="cantidad">CANT</th>
          <th class="producto">PRODUCTO</th>
          <th class="precio">$$</th>
        </tr>
      </thead>
      <tbody>
        <?php 
        $res = $this->adminPuntoVentaModelo->ticket();
        foreach ($res as $key) {
        ?>
        <tr>
          <td class="cantidad"><?php echo $key['cantidad'] ?></td>
          <td class="producto"><?php echo $key['producto'] ?></td>
          <td class="precio"><?php echo $key['subTotal'] ?></td>
        </tr>
      <?php } ?>
      </tbody>
    </table>
    <p class="centrado">¡GRACIAS POR SU COMPRA!
      <br>Sigue comprando por fis :3</p>
  </div>

  <div id="ticket1"></div>

<script type="text/javascript">
  $(document).ready(function(){
    window.print();
  });
</script>