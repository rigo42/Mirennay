<?php

require_once 'modelo/adminTallaModelo.php';

class adminTallaControlador{

    private $adminTallaModelo;

    //SIRVE: Para hacer un objeto mediante la instancia de este controlador al modelo de este mismo
    //PORQUE: Por que es necesario tener conectividad con el modelo que es el que se encarga de la base de datos
    public function __construct() {
        $this->adminTallaModelo = new adminTallaModelo();
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

                include('vista/admin/talla/index.php');

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

                include('vista/admin/talla/nuevo.php');

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

                if(isset($_GET['idTalla'])){
                    $idTalla = htmlspecialchars(strip_tags(openssl_decrypt($_GET['idTalla'], COD, KEY)));
                    $idTallaSQL = " AND t.id_talla = $idTalla";
                    $this->adminTallaModelo->set("idTalla",$idTallaSQL);
                    $res = $this->adminTallaModelo->construir();
                    foreach ($res as $key => $value) {}
                    include('vista/admin/talla/editar.php');
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
                        $searchSQL = " AND  (t.talla like '%" .$search. "%') ";
                        $this->adminTallaModelo->set("search",$searchSQL);
                    }
                    $activoSQL = "";
                    if($_POST['activo'] != ""){
                        $activo = htmlspecialchars(strip_tags($_POST['activo']));
                        $activoSQL = " AND  t.activo = $activo ";
                        $this->adminTallaModelo->set("activo",$activoSQL);
                    }
                    $res = $this->adminTallaModelo->mostrar();
                    include('vista/admin/talla/talla.php');
                }
            }else{
                header("Location: ".URL."adminPuntoVenta");
            }
        }else{
            header("Location: ".URL."adminLogin");
        }
    }

    public function tallaServlet(){
        session_start();
        if(isset($_SESSION['idEmpleado'])){
            if($_SESSION['rolEmpleado'] == "admin" || $_SESSION['rolEmpleado'] == "gerente"){
                if($_POST){

                    //Obtenemos datos via post
                    $talla = htmlspecialchars(strip_tags($_POST['talla']));

                    //Seteamos los datos obtenidos al modelo
                    $this->adminTallaModelo->set("talla",$talla);

                    if($_POST['actividad'] == "nuevo"){
                        
                        $this->adminTallaModelo->nuevo();
                        echo 1; //Nuevo correctamente
                    }else if($_POST['actividad'] == "editar"){

                        $idTalla = openssl_decrypt(htmlspecialchars(strip_tags($_POST['idTalla'])), COD, KEY);
                        $activo = htmlspecialchars(strip_tags($_POST['activo']));

                        $this->adminTallaModelo->set("idTalla",$idTalla);
                        $this->adminTallaModelo->set("activo",$activo);

                        $this->adminTallaModelo->editar();
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


}
?>
