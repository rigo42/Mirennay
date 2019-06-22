<?php

require_once 'modelo/adminGeneroModelo.php';

class adminGeneroControlador{

    private $adminGeneroModelo;

    //SIRVE: Para hacer un objeto mediante la instancia de este controlador al modelo de este mismo
    //PORQUE: Por que es necesario tener conectividad con el modelo que es el que se encarga de la base de datos
    public function __construct() {
        $this->adminGeneroModelo = new adminGeneroModelo();
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

                include('vista/admin/genero/index.php');

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

                include('vista/admin/genero/nuevo.php');

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

                if(isset($_GET['idGenero'])){
                    $idGenero = htmlspecialchars(strip_tags(openssl_decrypt($_GET['idGenero'], COD, KEY)));
                    $idGeneroSQL = " AND g.id_genero = $idGenero";
                    $this->adminGeneroModelo->set("idGenero",$idGeneroSQL);
                    $res = $this->adminGeneroModelo->construir();
                    foreach ($res as $key => $value) {}
                    include('vista/admin/genero/editar.php');
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
                        $searchSQL = " AND  (g.genero like '%" .$search. "%') ";
                        $this->adminGeneroModelo->set("search",$searchSQL);
                    }
                    $activoSQL = "";
                    if($_POST['activo'] != ""){
                        $activo = htmlspecialchars(strip_tags($_POST['activo']));
                        $activoSQL = " AND  g.activo = $activo ";
                        $this->adminGeneroModelo->set("activo",$activoSQL);
                    }
                    $res = $this->adminGeneroModelo->mostrar();
                    include('vista/admin/genero/genero.php');
                }
            }else{
                header("Location: ".URL."adminPuntoVenta");
            }
        }else{
            header("Location: ".URL."adminLogin");
        }
    }

    public function generoServlet(){
        session_start();
        if(isset($_SESSION['idEmpleado'])){
            if($_SESSION['rolEmpleado'] == "admin" || $_SESSION['rolEmpleado'] == "gerente"){
                if($_POST){

                    //Obtenemos datos via post
                    $genero = htmlspecialchars(strip_tags($_POST['genero']));

                    //Seteamos los datos obtenidos al modelo
                    $this->adminGeneroModelo->set("genero",$genero);

                    if($_POST['actividad'] == "nuevo"){
                        
                        $this->adminGeneroModelo->nuevo();
                        echo 1; //Nuevo correctamente
                    }else if($_POST['actividad'] == "editar"){

                        $idGenero = openssl_decrypt(htmlspecialchars(strip_tags($_POST['idGenero'])), COD, KEY);
                        $activo = htmlspecialchars(strip_tags($_POST['activo']));

                        $this->adminGeneroModelo->set("idGenero",$idGenero);
                        $this->adminGeneroModelo->set("activo",$activo);

                        $this->adminGeneroModelo->editar();
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
