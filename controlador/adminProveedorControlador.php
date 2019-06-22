<?php

require_once 'modelo/adminProveedorModelo.php';

class adminProveedorControlador{

    private $adminProveedorModelo;

    //SIRVE: Para hacer un objeto mediante la instancia de este controlador al modelo de este mismo
    //PORQUE: Por que es necesario tener conectividad con el modelo que es el que se encarga de la base de datos
    public function __construct() {
        $this->adminProveedorModelo = new adminProveedorModelo();
    } 

    //SIRVE: Para mostrar la vista principal
    //PORQUE: Es necesaria una vista
    public function index(){
        session_start();
        if(isset($_SESSION['idEmpleado'])){
            if($_SESSION['rolEmpleado'] == "admin" || $_SESSION['rolEmpleado'] == "gerente"){
                include('vista/admin/head/index.php');
                include('vista/admin/header/index.php');
                include('vista/admin/menu/index.php');

                include('vista/admin/proveedor/index.php');

                include('vista/admin/footer/index.php');
            }else{
                header("Location: ".URL."adminPuntoVenta");
            }
        }else{
            header("Location: ".URL."adminLogin");
        }
    }


    public function nuevo(){
        session_start();
        if(isset($_SESSION['idEmpleado'])){
            if($_SESSION['rolEmpleado'] == "admin" || $_SESSION['rolEmpleado'] == "gerente"){
                include('vista/admin/head/index.php');
                include('vista/admin/header/index.php');
                include('vista/admin/menu/index.php');

                include('vista/admin/proveedor/nuevo.php');

                include('vista/admin/footer/index.php');
            }else{
                header("Location: ".URL."adminPuntoVenta");
            }
        }else{
            header("Location: ".URL."adminLogin");
        }
    }

    public function editar(){
        session_start();
        if(isset($_SESSION['idEmpleado'])){
            if($_SESSION['rolEmpleado'] == "admin" || $_SESSION['rolEmpleado'] == "gerente"){
                include('vista/admin/head/index.php');
                include('vista/admin/header/index.php');
                include('vista/admin/menu/index.php');

                if(isset($_GET['idProveedor'])){
                    $idProveedor = htmlspecialchars(strip_tags(openssl_decrypt($_GET['idProveedor'], COD, KEY)));
                    $idProveedorSQL = " AND p.id_proveedor = $idProveedor";
                    $this->adminProveedorModelo->set("idProveedor",$idProveedorSQL);
                    $res = $this->adminProveedorModelo->construir();
                    foreach ($res as $key => $value) {}
                    include('vista/admin/proveedor/editar.php');
                }else{
                    echo "Por favor envie el identificador";
                }

                include('vista/admin/footer/index.php');
            }else{
                header("Location: ".URL."adminPuntoVenta");
            }
        }else{
            header("Location: ".URL."adminLogin");
        }
    }

    //SIRVE: Mostrar todos los productos con limite de 1000, dinamicamente
    //PORQUE: Es necesario mostrarlos para de ahí escoger el producto a editar o verlo
    public function mostrar(){
        session_start();
        if(isset($_SESSION['idEmpleado'])){
            if($_SESSION['rolEmpleado'] == "admin" || $_SESSION['rolEmpleado'] == "gerente"){
                if($_POST){
                    $searchSQL = "";
                    if($_POST['search'] != ""){
                        $search = htmlspecialchars(strip_tags($_POST['search']));
                        $searchSQL = " AND  (p.proveedor like '%" .$search. "%' OR e.empresa like '%" .$search. "%') ";
                        $this->adminProveedorModelo->set("search",$searchSQL);
                    }
                    $activoSQL = "";
                    if($_POST['activo'] != ""){
                        $activo = htmlspecialchars(strip_tags($_POST['activo']));
                        $activoSQL = " AND  p.activo = $activo ";
                        $this->adminProveedorModelo->set("activo",$activoSQL);
                    }
                    $res = $this->adminProveedorModelo->mostrar();
                    include('vista/admin/proveedor/proveedor.php');
                }
            }else{
                header("Location: ".URL."adminPuntoVenta");
            }
        }else{
            header("Location: ".URL."adminLogin");
        }
    }

    public function proveedorServlet(){
        session_start();
        if(isset($_SESSION['idEmpleado'])){
            if($_SESSION['rolEmpleado'] == "admin" || $_SESSION['rolEmpleado'] == "gerente"){
                if($_POST){

                    //Obtenemos datos via post
                    $proveedor = htmlspecialchars(strip_tags($_POST['proveedor']));
                    $idEmpresa = openssl_decrypt(htmlspecialchars(strip_tags($_POST['idEmpresa'])), COD, KEY);

                    //Seteamos los datos obtenidos al modelo
                    $this->adminProveedorModelo->set("proveedor",$proveedor);
                    $this->adminProveedorModelo->set("idEmpresa",$idEmpresa);

                    if($_POST['actividad'] == "nuevo"){
                        
                        $this->adminProveedorModelo->nuevo();
                        echo 1; //Nuevo correctamente
                    }else if($_POST['actividad'] == "editar"){

                        $idProveedor = openssl_decrypt(htmlspecialchars(strip_tags($_POST['idProveedor'])), COD, KEY);
                        $activo = htmlspecialchars(strip_tags($_POST['activo']));

                        $this->adminProveedorModelo->set("idProveedor",$idProveedor);
                        $this->adminProveedorModelo->set("activo",$activo);

                        $this->adminProveedorModelo->editar();
                        echo 2; //Editado correctamente
                    }
                                
                }
            }else{
                header("Location: ".URL."adminPuntoVenta");
            }
        }else{
            header("Location: ".URL."adminLogin");
        }
    }

    public function selectEmpresa(){
        return $this->adminProveedorModelo->selectEmpresa();
    }

}
?>
