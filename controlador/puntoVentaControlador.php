<?php

require_once 'modelo/puntoVentaModelo.php';

class puntoVentaControlador {

    private $puntoVentaModelo;

    //SIRVE: Para hacer un objeto mediante la instancia de este controlador al modelo de este mismo
    //PORQUE: Por que es necesario tener conectividad con el modelo que es el que se encarga de la base de datos
    public function __construct() {
        $this->puntoVentaModelo = new puntoVentaModelo();
    } 

	public function index(){
        session_start();
        if(isset($_SESSION['idEmpleado']) && $_SESSION['rol'] == "admin" || $_SESSION['empleado']){
            include('vista/admin/head/index.php');
            include('vista/admin/header/index.php');
            include('vista/admin/menu/index.php');

            include('vista/admin/puntoVenta/index.php');

            include('vista/admin/footer/index.php');
        }else{
            header("Location: ".URL."inicio");
        }
    }

    public function ventanaCart(){
        session_start();
        //unset($_SESSION['carritoFisico']);
        if(isset($_SESSION['idEmpleado']) && $_SESSION['rol'] == "admin" || $_SESSION['empleado']){
               if(isset($_SESSION['carritoFisico'])){
                    $datos = $_SESSION['carritoFisico'];
                    $count = count($datos);
                    include('vista/admin/puntoVenta/puntoVenta.php');
                }else{
                    echo "Actualmente no tiene nada en el carrito";
                }
        }else{
            header("Location: ".URL."inicio");
        }
    }

    public function addCart(){
        session_start();
        if(isset($_SESSION['idEmpleado']) && $_SESSION['rol'] == "admin" || $_SESSION['empleado']){
            
            if ($_POST) {

                $codigo = htmlspecialchars(strip_tags($_POST['codigo']));
                $codigoSQL = " AND pd.codigo = '$codigo' ";
                $this->puntoVentaModelo->set("codigo",$codigoSQL);
                $res = $this->puntoVentaModelo->construir();
                $row =  $res->rowCount();

                if($row > 0){
                    foreach ($res as $key) {
                        $idProductoDetalle = $key['id_producto_detalle'];
                        $producto = $key['producto'];
                        $cantidad = $key['cantidad'];
                        $color = $key['color'];
                        $talla = $key['talla'];
                        $precio = $key['precio'];
                    }

                     $cantidadPedido = 1;
                     if(!empty($_POST['cantidadPedido'])){
                        $cantidadPedido =  htmlspecialchars(strip_tags($_POST['cantidadPedido']));
                     }

                     if(isset($_SESSION['carritoFisico'])){

                        $datos=$_SESSION['carritoFisico'];

                        //Posicion del arreglo donde se solicitara cambiar la cantidad del producto
                        $posicionCambiarCantidad = 0;
                        //Si es false: "No habra cambio de cantidad" caso contrario, si
                        $encontroCambiarCantidad = false;
                        //Si es false: "No habra producto nuevo", caso contario, si
                        $insertarNuevo=true;

                        if($cantidadPedido <= $cantidad){

                            for($i=0;$i<count($datos);$i++){
                                if($datos[$i]['codigo'] == $codigo && $datos[$i]['cantidadPedido'] != $cantidadPedido){
                                    $encontroCambiarCantidad = true;
                                    $posicionCambiarCantidad = $i;

                                }if($datos[$i]['codigo'] == $codigo){
                                    $insertarNuevo = false;
                                }
                            }
                            if($encontroCambiarCantidad == true){
                                $subTotal = $cantidadPedido * $datos[$posicionCambiarCantidad]['precio'];
                                $datos[$posicionCambiarCantidad]['subTotal'] = $subTotal;
                                $datos[$posicionCambiarCantidad]['cantidad'] = $cantidad;
                                $datos[$posicionCambiarCantidad]['cantidadPedido'] = $cantidadPedido;
                                $_SESSION['carritoFisico']=$datos;
                            }
                            if($insertarNuevo == true){
                                $datosNuevos=array('idProductoDetalle'=>$idProductoDetalle,'codigo'=>$codigo,'producto'=>$producto,'cantidad'=>$cantidad,'cantidadPedido'=>$cantidadPedido,'color'=>$color,'talla'=>$talla,'precio'=>$precio,'subTotal'=>$precio);
                                $_SESSION['carritoFisico']=$datos;
                                    array_push($datos, $datosNuevos);
                                    $_SESSION['carritoFisico']=$datos;
                            }

                        }else{
                            echo "La cantidad de pedido supera a la del inventario";
                        }

                    }else{
                        $datos[]=array('idProductoDetalle'=>$idProductoDetalle,'codigo'=>$codigo,'producto'=>$producto,'cantidad'=>$cantidad,'cantidadPedido'=>$cantidadPedido,'color'=>$color,'talla'=>$talla,'precio'=>$precio,'subTotal'=>$precio);
                        $_SESSION['carritoFisico']=$datos;
                    }
                }else{
                    echo "Codigo no reconocido";
                }

            }
        }else{
            header("Location: ".URL."inicio");
        }
    }

    public function deleteCart(){
        session_start();
        if(isset($_SESSION['idEmpleado']) && $_SESSION['rol'] == "admin" || $_SESSION['empleado']){

            if(isset($_SESSION['carritoFisico'])){
                if($_POST){
                    $codigo = htmlspecialchars(strip_tags($_POST['codigo']));
                    $arreglo=$_SESSION['carritoFisico'];
                    for($i=0;$i<count($arreglo);$i++){
                        if($arreglo[$i]['codigo'] == $codigo){
                            array_splice($arreglo, $i, 1);
                        }
                    }
                    $_SESSION['carritoFisico']=$arreglo;
                }else{
                    echo "Porfavor enviar los post";
                }
            }else{
                echo "No existe la sesión carrito";
            }
        }else{
            header("Location: ".URL."inicio");
        }        
    }

    public function dropCart(){
        session_start();
        if(isset($_SESSION['idEmpleado']) && $_SESSION['rol'] == "admin" || $_SESSION['empleado']){
            unset( $_SESSION['carritoFisico']);
        }else{
            header("Location: ".URL."inicio");
        }
    }

    public function confirmarPago(){
        session_start();
        if(isset($_SESSION['idEmpleado']) && $_SESSION['rol'] == "admin" || $_SESSION['empleado']){
            $this->puntoVentaModelo->confirmarPago();
            echo "SI ENTRO AQUI";
        }else{
            header("Location: ".URL."inicio");
        }
    }

}
?>
