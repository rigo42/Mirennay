<?php 
	
	session_start();

	//Sandox
	$clientId = "AcMFerZoQD2g-P6ovLZLk7botreJCWy-TlixjF3V45Zyu5-csRsbp0Ns_yuYRTlsAOh5NaDGp2ZExbGZ";
	$secret = "ELAAGBSNpXBVYCljHC6Vq7rdU9HWS-KYAgrcr-ileBw_TasHuPfkmo9YofF6hneNaxmTup5LXn_lW859";

	//Production
	//$clientId = "AT4o3ZwgN-C9HSvQTylyJKI7tGGuPQFITrj34pLJWQwObT-6c57Y3KZd47QQ1iHZfrYGGK5uYqhfIoNt";
	//$secret = "EJEp-JlzpokAC2CIhOVMgRlCockZQDTFHuv_36B1xwaYTQ1VViPpYBw221o0kDTAu3vLat8bfjDhg1Di";

	//Sandox
	$login = curl_init("https://api.sandbox.paypal.com/v1/oauth2/token");

	//Production
	//$login = curl_init("https://api.paypal.com/v1/oauth2/token");

	curl_setopt($login, CURLOPT_RETURNTRANSFER, TRUE);

	curl_setopt($login, CURLOPT_USERPWD, $clientId.":".$secret);

	curl_setopt($login, CURLOPT_POSTFIELDS, "grant_type=client_credentials");

	$respuesta = curl_exec($login);


	$objRespuesta = json_decode($respuesta);

	$accessToken = $objRespuesta->access_token;

	//Sanbox
	$venta = curl_init("https://api.sandbox.paypal.com/v1/payments/payment/".$_POST['paymentId']);

	//Production
	//$venta = curl_init("https://api.paypal.com/v1/payments/payment/".$_POST['paymentId']);

	curl_setopt($venta, CURLOPT_HTTPHEADER, array("Content-Type: application/json","Authorization: Bearer ".$accessToken));

	curl_setopt($venta, CURLOPT_RETURNTRANSFER, TRUE);

	$respuestaVenta = curl_exec($venta);

	$objDatosTransaccion = json_decode($respuestaVenta);

	$state = $objDatosTransaccion->state;
	$email = $objDatosTransaccion->payer->payer_info->email;

	$total = $objDatosTransaccion->transactions[0]->amount->total;
	$currency = $objDatosTransaccion->transactions[0]->amount->currency;
	$custom = $objDatosTransaccion->transactions[0]->custom;
	 
	 curl_close($venta);
	 curl_close($login);

	 if($state == "approved"){
	 	include('conexion.php');
	 	 $datos = $_SESSION['carrito'];

	 	 $sqlFolio = " SELECT MAX(folio) AS 'folio' FROM pedido_usuario ";
	 	 $folio = "";
	 	 if($resFolio = mysqli_query($conexion,$sqlFolio)){
	 	 	$rowFolio = mysqli_num_rows($resFolio);
	 	 	if($rowFolio > 0){
	 	 		foreach ($resFolio as $keyFolio) {
	 	 			$folio = $keyFolio['folio'];
	 	 		}
	 	 	}else{
	 	 		$folio = "Mirennay00000001";
	 	 	}
	 	 	
	 	 }else{
	 	 	echo mysqli_error($conexion);
	 	 }
	 	 $folio = ++$folio;

	 	 if($_POST['actividad'] == "normalDireccion"){
		 	 $sql = "INSERT INTO pedido_usuario(id_producto_detalle ,id_usuario_detalle ,cantidad,subtotal,folio,fecha_pedido,entregado,activo) VALUES ";

			 for ($i=0; $i < count($datos) ; $i++) { 
			 	$subTotal = 0;
			 	$subTotal = $datos[$i]['precio'] * $datos[$i]['cantidad'];

				$sql .= "( '".$datos[$i]['idProductoDetalle']."','".$_POST['idUsuarioDetalle']."','".$datos[$i]['cantidad']."','".$subTotal."','".$folio."',NOW(),0,1)";

				if($i == count($datos)-1){
					$sql .= ";"; // si es que se llega al final, termina la consulta
				}else{
					$sql .= ", "; // sino se pone una , y se continua.
				}
			}
			
			if(mysqli_query($conexion,$sql)){
				for ($i=0; $i < count($datos) ; $i++) { 
					$sqlUpdate = " UPDATE producto_detalle SET cantidad = cantidad - ".$datos[$i]['cantidad']." WHERE id_producto_detalle =  ".$datos[$i]['idProductoDetalle']." ";
						if(mysqli_query($conexion,$sqlUpdate)){
							$sqlCantidad = "SELECT cantidad FROM producto_detalle WHERE id_producto_detalle = ".$datos[$i]['idProductoDetalle'];
							$resCantidad = mysqli_query($conexion,$sqlCantidad);
							foreach ($resCantidad as $keyCantidad) {
								$cantidad = $keyCantidad['cantidad'];
								if($cantidad == 0){
									$sqlUpdateInactivo = " UPDATE producto_detalle SET activo = 0 WHERE id_producto_detalle =  ".$datos[$i]['idProductoDetalle']." ";
									mysqli_query($conexion,$sqlUpdateInactivo);
										
								}
							}						
						}
					}
					echo "1";
					unset($_SESSION['carrito']);
				
			}else{
				echo mysqli_error($conexion);
			}
	 	 }else if($_POST['actividad'] == "nuevaDireccion"){
	 	 	$sqlNuevoUsuarioDetalle = " INSERT INTO usuario_detalle(id_usuario,id_municipio,nombre_completo,direccion,observacion,codigo_postal,celular,fecha_alta,activo)
	 	 		VALUES(".$_SESSION['idUsuario'].",".$_POST['id_municipio'].",'".$_POST['nombre_completo']."','".$_POST['direccion']."','".$_POST['observacion']."','".$_POST['codigo_postal']."','".$_POST['celular']."',NOW(), 1 ) ";
	 	 	if(mysqli_query($conexion,$sqlNuevoUsuarioDetalle)){
	 	 		$sqlObtenerNuevoUsuarioDetalle = " SELECT MAX(id_usuario_detalle) AS 'id_usuario_detalle' FROM usuario_detalle WHERE activo = 1 AND id_usuario = ".$_SESSION['idUsuario'];
	 	 		if($resObtenerNuevoUsuarioDetalle = mysqli_query($conexion,$sqlObtenerNuevoUsuarioDetalle)){
	 	 			foreach ($resObtenerNuevoUsuarioDetalle as $keyObtenerNuevoUsuarioDetalle) {
	 	 				$idUsuarioDetalle = $keyObtenerNuevoUsuarioDetalle['id_usuario_detalle'];
	 	 			}
	 	 			$sql = "INSERT INTO pedido_usuario(id_producto_detalle ,id_usuario_detalle ,cantidad,subtotal,folio,fecha_pedido,entregado,activo) VALUES ";

					 for ($i=0; $i < count($datos) ; $i++) { 
					 	$subTotal = 0;
					 	$subTotal = $datos[$i]['precio'] * $datos[$i]['cantidad'];

						$sql .= "( '".$datos[$i]['idProductoDetalle']."','".$idUsuarioDetalle."','".$datos[$i]['cantidad']."','".$subTotal."','".$folio."',NOW(),0,1)";

						if($i == count($datos)-1){
							$sql .= ";"; // si es que se llega al final, termina la consulta
						}else{
							$sql .= ", "; // sino se pone una , y se continua.
						}
					}
					
					if(mysqli_query($conexion,$sql)){
						for ($i=0; $i < count($datos) ; $i++) { 
							$sqlUpdate = " UPDATE producto_detalle SET cantidad = cantidad - ".$datos[$i]['cantidad']." WHERE id_producto_detalle =  ".$datos[$i]['idProductoDetalle']." ";
								if(mysqli_query($conexion,$sqlUpdate)){
									$sqlCantidad = "SELECT cantidad FROM producto_detalle WHERE id_producto_detalle = ".$datos[$i]['idProductoDetalle'];
									$resCantidad = mysqli_query($conexion,$sqlCantidad);
									foreach ($resCantidad as $keyCantidad) {
										$cantidad = $keyCantidad['cantidad'];
										if($cantidad == 0){
											$sqlUpdateInactivo = " UPDATE producto_detalle SET activo = 0 WHERE id_producto_detalle =  ".$datos[$i]['idProductoDetalle']." ";
											mysqli_query($conexion,$sqlUpdateInactivo);
												
										}
									}						
								}
							}
							echo "1";
							unset($_SESSION['carrito']);
						
					}else{
						echo mysqli_error($conexion);
					}

	 	 		}else{
	 	 			echo mysqli_error($conexion);
	 	 		}
	 	 	}else{
	 	 		echo mysqli_error($conexion);
	 	 	}
	 	 }


	 }else{
	 	echo $mensajePaypal = "Hubo un problema con el pago";
	 }

	
 ?>