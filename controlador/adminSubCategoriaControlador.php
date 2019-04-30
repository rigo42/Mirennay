<?php

require_once 'modelo/adminSubCategoriaModelo.php';

class adminSubCategoriaControlador {

    private $adminSubCategoriaModelo;

    //SIRVE: Para hacer un objeto mediante la instancia de este controlador al modelo de este mismo
    //PORQUE: Por que es necesario tener conectividad con el modelo que es el que se encarga de la base de datos
    public function __construct() {
        $this->adminSubCategoriaModelo = new adminSubCategoriaModelo();
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

                include('vista/admin/subCategoria/index.php');

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

                include('vista/admin/subCategoria/nuevo.php');

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

                if(isset($_GET['idSubCategoria'])){
                    $idSubCategoria = htmlspecialchars(strip_tags(openssl_decrypt($_GET['idSubCategoria'], COD, KEY)));
                    $idSubCategoriaSQL = " AND sc.id_sub_categoria = $idSubCategoria";
                    $this->adminSubCategoriaModelo->set("idSubCategoria",$idSubCategoriaSQL);
                    $res = $this->adminSubCategoriaModelo->construir();
                    foreach ($res as $key => $value) {}
                    include('vista/admin/subCategoria/editar.php');
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
                        $searchSQL = " AND  (sc.sub_categoria like '%" .$search. "%') ";
                        $this->adminSubCategoriaModelo->set("search",$searchSQL);
                    }
                    $activoSQL = "";
                    if($_POST['activo'] != ""){
                        $activo = htmlspecialchars(strip_tags($_POST['activo']));
                        $activoSQL = " AND  sc.activo = $activo ";
                        $this->adminSubCategoriaModelo->set("activo",$activoSQL);
                    }
                    $res = $this->adminSubCategoriaModelo->mostrar();
                    include('vista/admin/subCategoria/subCategoria.php');
                }
            }else{
                header("Location: ".URL."adminPuntoVenta");
            }
        }else{
            header("Location: ".URL."adminLogin");
        }
    }

    public function subCategoriaServlet(){
        session_start();
        if(isset($_SESSION['idEmpleado'])){
            if($_SESSION['rolEmpleado'] == "admin" || $_SESSION['rolEmpleado'] == "gerente"){
                if($_POST){
                    //Obtenemos datos via post

                    $idCategoria = openssl_decrypt(htmlspecialchars(strip_tags($_POST['idCategoria'])), COD, KEY);
                    $subCategoria = htmlspecialchars(strip_tags($_POST['subCategoria']));

                    //Seteamos los datos obtenidos al modelo
                    $this->adminSubCategoriaModelo->set("idCategoria",$idCategoria);
                    $this->adminSubCategoriaModelo->set("subCategoria",$subCategoria);

                    if($_POST['actividad'] == "nuevo"){
                        
                        $this->adminSubCategoriaModelo->nuevo();
                        echo 1; //Nuevo correctamente
                    }else if($_POST['actividad'] == "editar"){

                        $idSubCategoria = openssl_decrypt(htmlspecialchars(strip_tags($_POST['idSubCategoria'])), COD, KEY);
                        $activo = htmlspecialchars(strip_tags($_POST['activo']));

                        $this->adminSubCategoriaModelo->set("idSubCategoria",$idSubCategoria);
                        $this->adminSubCategoriaModelo->set("activo",$activo);

                        $this->adminSubCategoriaModelo->editar();
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

    public function selectCategoria(){
        return $this->adminSubCategoriaModelo->selectCategoria();
    }


}
?>
