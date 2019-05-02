<?php

require_once 'modelo/pedidoModelo.php';
require_once 'controlador/perfilControlador.php';
require_once 'controlador/enviarCorreoControlador.php';

class pedidoControlador {

    private $pedidoModelo;
    private $perfilControlador;
    private $enviarCorreoControlador;

    //SIRVE: Para hacer un objeto mediante la instancia de este controlador al modelo de este mismo
    //PORQUE: Por que es necesario tener conectividad con el modelo que es el que se encarga de la base de datos
    public function __construct() {
        $this->pedidoModelo = new pedidoModelo();
        $this->perfilControlador = new perfilControlador();
    } 

	public function index() {
        session_start();
		include('vista/cliente/head/index.php');
        include('vista/cliente/header/index.php');
		include('vista/cliente/menu/index.php');
        if(isset($_SESSION['idUsuario'])){
            if(isset($_SESSION['carrito'])){
                if(count($_SESSION['carrito']) > 0){
                    include('vista/cliente/pedido/index.php');
                }else{
                    echo "No tienes nada en este momento";
                }   
            }else{
                echo "No tienes nada en este momento";
            }
        }else{
            header("Location: ".URL);
        }
    	include('vista/cliente/contacto/index.php');
    	include('vista/cliente/footer/index.php');
	}

    public function estado(){
        return $this->pedidoModelo->estado();
    }

    public function municipio(){
        if($_POST){
            $idEstado = openssl_decrypt($_POST['idEstado'], COD, KEY);
            $res = $this->pedidoModelo->municipio($idEstado);
            include('vista/cliente/pedido/selectMunicipio.php');
        }
    }

    public function validarFormPedido(){
        if($_POST){
            $datos = "";
            $validar = true;
            foreach($_POST as $variable => $valor){
                if($valor == ""){
                    if($variable != "observacion"){
                       $validar = false;
                    }
                }
            }
            if($validar == true){
                echo "1"; //Todo bien puede seguir
            }else{
                 echo "2"; //Le falta rellenar mas datos para el formulario de envio
            }
        }
    }

    public function pedido(){
        session_start();
        if($_POST){
            //Sandox
            $clientId = "AcMFerZoQD2g-P6ovLZLk7botreJCWy-TlixjF3V45Zyu5-csRsbp0Ns_yuYRTlsAOh5NaDGp2ZExbGZ";
            $secret = "ELAAGBSNpXBVYCljHC6Vq7rdU9HWS-KYAgrcr-ileBw_TasHuPfkmo9YofF6hneNaxmTup5LXn_lW859";
            $login = curl_init("https://api.sandbox.paypal.com/v1/oauth2/token");
            $venta = curl_init("https://api.sandbox.paypal.com/v1/payments/payment/".$_POST['paymentID']);

            //Production
            //$clientId = "AT4o3ZwgN-C9HSvQTylyJKI7tGGuPQFITrj34pLJWQwObT-6c57Y3KZd47QQ1iHZfrYGGK5uYqhfIoNt";
            //$secret = "EJEp-JlzpokAC2CIhOVMgRlCockZQDTFHuv_36B1xwaYTQ1VViPpYBw221o0kDTAu3vLat8bfjDhg1Di";
            //$login = curl_init("https://api.paypal.com/v1/oauth2/token");
            //$venta = curl_init("https://api.paypal.com/v1/payments/payment/".$_POST['paymentID']);


            curl_setopt($login, CURLOPT_RETURNTRANSFER, TRUE);

            curl_setopt($login, CURLOPT_USERPWD, $clientId.":".$secret);

            curl_setopt($login, CURLOPT_POSTFIELDS, "grant_type=client_credentials");

            $respuesta = curl_exec($login);


            $objRespuesta = json_decode($respuesta);

            $accessToken = $objRespuesta->access_token;

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
                $POST = $_POST;
                $actividad = $POST['actividad'];
                if($actividad == "direccion"){ 
                    $idUsuarioDetalle = openssl_decrypt($POST['idUsuarioDetalle'], COD, KEY);
                }else if($actividad=="direccionNueva"){
                    $idUsuarioDetalle = $this->perfilControlador->direccionNueva($POST);
                }

                $folio = $this->insertarPedido($idUsuarioDetalle);

                $carrito = $_SESSION['carrito'];
                $correo = $_SESSION['correo'];

                $subTotal = 0;
                $totalNeto = 0;
                $tabla = "";

                for ($i=0; $i<count($carrito); $i++) {
                $subTotal = $carrito[$i]['precio'] * $carrito[$i]['idProductoDetalleCantidad'];
                $totalNeto += $subTotal;
                $tabla .=  '<tr>
                                <td>'.$carrito[$i]['producto'].'</td>
                                <td>'.$carrito[$i]['idProductoDetalleCantidad'].'</td>
                                <td>'.$carrito[$i]['precio'].'</td>
                                <td>'.$carrito[$i]['talla'].'</td>
                                <td>'.$carrito[$i]['color'].'</td>
                                <td>'.'$'.$subTotal.' MXN'.'</td>
                            </tr>'; 
                }

                $texto = "¡Gracias por comprar con nosotros! Tu folio de compra es: $folio con un total de $ $totalNeto MXN.";
                $correo = $_SESSION['correo'];

                $this->enviarCorreoControlador = new enviarCorreoControlador();

                $asunto = "Datos del pedido.";
                $mensaje = file_get_contents('vista/cliente/correo/pedido.php');
                $mensaje = str_replace("{{year}}", date('Y'), $mensaje);
                $mensaje = str_replace("{{asunto}}", $asunto, $mensaje);
                $mensaje = str_replace("{{mensaje}}", $texto, $mensaje);
                $mensaje = str_replace("{{tabla}}", $tabla);
                
                $this->enviarCorreoControlador->enviarCorreo($correo,$asunto,$mensaje);

                unset($_SESSION['carrito']);
            }else{
                echo "No se aprovo el pago";
            }
        }
     }

    public function insertarPedido($idUsuarioDetalle){
        return $this->pedidoModelo->insertarPedido($idUsuarioDetalle);
    }

}
?>
