<?php 
	include('conexion.php');

	$empresa = "";
	if($_GET['empresa'] != ""){
		$empresa = " AND  (empresa like '%" . $_GET['empresa'] . "%' OR  direccion like '%" . $_GET['empresa'] . "%'
					 OR  celular like '%" . $_GET['empresa'] . "%') ";
	}
	if(isset($_GET['activo'])){
		$activo = $_GET['activo'];
	}

	$sql = "SELECT * FROM empresa 
				 WHERE activo = ".$activo ." 
				 	   ".$empresa." ";
	$empresa = mysqli_query($conexion,$sql);

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
	      <th scope="col">EMPRESA</th>
	      <th scope="col">DIRECCIÓN</th>
	      <th scope="col">CELULAR</th>
	      <th scope="col">OBSERVACIÓN</th>
	    </tr>
	  </thead>
	  <tbody>
	  	<?php
	  		$n = 0;
	  	 	foreach ($empresa as $key) { 
	  		++$n;
	  	?>
	    <tr class="seleccion" data-id="<?php echo $key['id_empresa'] ?>">
	      <th scope="row"><?php echo $n ?></th>
	      <td><?php echo $key['empresa'] ?></td>
	      <td><?php echo $key['direccion'] ?></td>
	      <td><?php echo formatoCelular($key['celular']) ?></td>
	      <td><?php echo $key['observacion'] ?></td>
	    </tr>
		<?php 
		}
		mysqli_free_result($empresa);
		 ?>
	  </tbody>
	</table>
</div>

<script type="text/javascript">
	$(".seleccion").click(function(e){
		  	e.preventDefault();
		  	var id_empresa = $(this).attr("data-id");
		  	location="administrador.php?admin=empresaEditar&id_empresa="+id_empresa;
		  });
</script>