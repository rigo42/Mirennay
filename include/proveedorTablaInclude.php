<?php 
	include('conexion.php');

	$proveedor = "";
	if($_GET['proveedor'] != ""){
		$proveedor = " AND  (p.proveedor like '%" . $_GET['proveedor'] . "%' OR e.empresa like '%" . $_GET['proveedor'] . "%' )";
	}
	if(isset($_GET['activo'])){
		$activo = $_GET['activo'];
	}

	$sql = "SELECT p.*, e.*, p.direccion AS 'pDireccion',p.celular AS 'pCelular', p.observacion AS 'pObservacion'
			FROM proveedor p
			INNER JOIN empresa e ON e.id_empresa = p.id_empresa 
			INNER JOIN municipio m ON m.id_municipio = p.id_municipio
			INNER JOIN estado edo ON edo.id_estado = m.id_estado
			WHERE p.activo = ".$activo ." AND e.activo = 1 ".$proveedor." ";

	$proveedor = mysqli_query($conexion,$sql);

	function formatoCelular($celular){

		$array = $celular;
		$formato = '';
		$formato= "(".substr($array,0,3).") ";
		$formato.=substr($array,3,3)." ";
		$formato.=substr($array,6,2)." ";
		$formato.=substr($array,8,2);
		return $formato;
	}
	
 ?>
<div class="table-responsive">
	<table class="table table-hover">
	  <thead>
	    <tr>
	      <th scope="col">#</th>
	      <th scope="col">PROVEEDOR</th>
	      <th scope="col">EMPRESA</th>
	      <th scope="col">DIRECCION</th>
	      <th scope="col">C.P</th>
	      <th scope="col">CELULAR</th>
	      <th scope="col">OBSERVACIÓN</th>
	    </tr>
	  </thead>
	  <tbody>
	  	<?php
	  		$n = 0;
	  	 	foreach ($proveedor as $key) { 
	  		++$n;
	  	?>
	    <tr class="seleccion" data-id="<?php echo $key['id_proveedor'] ?>">
	      <th scope="row"><?php echo $n ?></th>
	      <td><?php echo $key['proveedor'] ?></td>
	      <td><?php echo $key['empresa'] ?></td>
	      <td><?php echo $key['pDireccion'] ?></td>
	      <td><?php echo $key['codigo_postal'] ?></td>
	      <td><?php echo formatoCelular($key['pCelular']) ?></td>
	      <td><?php echo $key['pObservacion'] ?></td>
	    </tr>
		<?php 
		}
		mysqli_free_result($proveedor);
		 ?>
	  </tbody>
	</table>
</div>

<script type="text/javascript">
	$(".seleccion").click(function(e){
		  	e.preventDefault();
		  	var id_proveedor = $(this).attr("data-id");
		  	location="administrador.php?admin=proveedorEditar&id_proveedor="+id_proveedor;
		  });
</script>