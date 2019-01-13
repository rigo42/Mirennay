<?php 
	session_start();
	
	if(isset($_SESSION['idUsuario'])){
		if(isset($_POST['idProductoDetalle'])){
			 if(isset($_SESSION['carrito'])){

			 	$arreglo=$_SESSION['carrito'];
				$encontro=false;
				$numero=0;
				$cambiarCantidad = 0;
				$encontroCambiarCantidad = false;

				for($i=0;$i<count($arreglo);$i++){
					if($arreglo[$i]['idProductoDetalle']==$_POST['idProductoDetalle'] AND $arreglo[$i]['cantidad']==$_POST['cantidad']){
						$encontro=true;
						$numero=$i;
					}else if($arreglo[$i]['idProductoDetalle']==$_POST['idProductoDetalle'] AND $arreglo[$i]['cantidad']!=$_POST['cantidad']){
						$encontroCambiarCantidad=true;
						$cambiarCantidad=$i;
					}
				}
				if($encontro==true){
					if(isset($_POST['actividad'])){
				 		if($_POST['actividad'] == "eliminar"){
				 			array_splice($arreglo, $numero, 1);
							$_SESSION['carrito']=$arreglo;
				 		}
				 	}
				}else if($encontroCambiarCantidad==true){
					$arreglo[$cambiarCantidad]['cantidad'] = $_POST['cantidad'];
					$_SESSION['carrito']=$arreglo;
				}else{
					$datosNuevos=array('idProducto'=>$_POST['idProducto'],'cantidad'=>$_POST['cantidad'],'idProductoDetalle'=>$_POST['idProductoDetalle']);
					array_push($arreglo, $datosNuevos);
					$_SESSION['carrito']=$arreglo;
				}
			}else{
				if(isset($_POST['idProductoDetalle'])){
					$arreglo[]=array('idProducto'=>$_POST['idProducto'],'cantidad'=>$_POST['cantidad'],'idProductoDetalle'=>$_POST['idProductoDetalle']);
					$_SESSION['carrito']=$arreglo;
				}
			}
		}else{
			echo "No se ha enviado el idProductoDetalle";
		}
	}else{
		echo "<h6>Necesitas estar registrado para poder guardar en carrito</h6>";
	}
 ?>