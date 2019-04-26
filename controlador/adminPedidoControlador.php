<?php

require_once 'modelo/adminPedidoModelo.php';

class adminPedidoControlador {

    private $adminPedidoModelo;

    //SIRVE: Para hacer un objeto mediante la instancia de este controlador al modelo de este mismo
    //PORQUE: Por que es necesario tener conectividad con el modelo que es el que se encarga de la base de datos
    public function __construct() {
        $this->adminPedidoModelo = new adminPedidoModelo();
    } 

    public function index(){
        session_start();
        if(isset($_SESSION['idEmpleado'])){
            if($_SESSION['rolEmpleado'] == "admin"){
                include('vista/admin/head/index.php');
                include('vista/admin/header/index.php');
                include('vista/admin/menu/index.php');

                include('vista/admin/pedido/index.php');

                include('vista/admin/footer/index.php');
            }else{
                header("Location: ".URL."adminPuntoVenta");
            }
        }else{
            header("Location: ".URL."adminLogin");
        }
    }

    public function mostrarPedidoGeneral(){
        session_start();
        if(isset($_SESSION['idEmpleado'])){
            if($_SESSION['rolEmpleado'] == "admin"){
                 
                if($_POST){
                    $searchSQL = "";
                    if(!empty($_POST['search'])){
                        $search = htmlspecialchars(addslashes($_POST['search']));
                        $searchSQL = " AND  (pu.folio like '%" .$search. "%') ";
                        $this->adminPedidoModelo->set("folio",$searchSQL);
                    }
                    $res = $this->adminPedidoModelo->mostrarPedidoGeneral();
                    $row = $res->rowCount();
                    if($row > 0){
                        include('vista/admin/pedido/pedido.php');
                    }else{
                        echo "No se han encontrado pedidos nuevos";
                    }
                }

            }else{
                header("Location: ".URL."adminPuntoVenta");
            }
        }else{
            header("Location: ".URL."adminLogin");
        }
    }

    public function mostrarPedidoDetalle($folio){
        if(isset($_SESSION['idEmpleado'])){
            if($_SESSION['rolEmpleado'] == "admin"){ 
                return $this->adminPedidoModelo->mostrarPedidoDetalle($folio);
            }else{
                header("Location: ".URL."adminPuntoVenta");
            }
        }else{
            header("Location: ".URL."adminLogin");
        }
         
    }

    public function modalDireccion(){
        session_start();
        if(isset($_SESSION['idEmpleado'])){
            if($_SESSION['rolEmpleado'] == "admin"){
                if($_POST){
                    $folio = $_POST['folio'];
                    $res = $this->adminPedidoModelo->modalDireccion($folio);
                    include('vista/admin/pedido/modalDireccion.php');
                }
            }else{
                header("Location: ".URL."adminPuntoVenta");
            }
        }else{
            header("Location: ".URL."adminLogin");
        }
    }

    public function obtenerPedido(){
        session_start();
        if(isset($_SESSION['idEmpleado'])){
            if($_SESSION['rolEmpleado'] == "admin"){
                if($_POST){
                    $folio = $_POST['folio'];
                    $res = $this->adminPedidoModelo->obtenerPedido($folio);
                    foreach ($res as $key) {
                       $this->adminPedidoModelo->insertarVentaOnline($key['id_pedido_usuario']);
                    }
                }
            }else{
                header("Location: ".URL."adminPuntoVenta");
            }
        }else{
            header("Location: ".URL."adminLogin");
        }
        
    }

}
?>
