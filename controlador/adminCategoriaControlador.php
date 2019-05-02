<?php

require_once 'modelo/adminCategoriaModelo.php';
require_once 'controlador/optimizarImagenControlador.php'; 
require_once 'controlador/reportePlantillaFPDF.php';

class adminCategoriaControlador{

    private $adminCategoriaModelo;
    private $optimizarImagenControlador;
    private $reportePlantillaFPDF;

    //SIRVE: Para hacer un objeto mediante la instancia de este controlador al modelo de este mismo
    //PORQUE: Por que es necesario tener conectividad con el modelo que es el que se encarga de la base de datos
    public function __construct() {
        $this->adminCategoriaModelo = new adminCategoriaModelo();
        $this->reportePlantillaFPDF = new reportePlantillaFPDF();
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

                include('vista/admin/categoria/index.php');

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

                include('vista/admin/categoria/nuevo.php');

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

                if(isset($_GET['idCategoria'])){
                    $idCategoria = htmlspecialchars(strip_tags(openssl_decrypt($_GET['idCategoria'], COD, KEY)));
                    $idCategoriaSQL = " AND c.id_categoria = $idCategoria";
                    $this->adminCategoriaModelo->set("idCategoria",$idCategoriaSQL);
                    $res = $this->adminCategoriaModelo->construir();
                    foreach ($res as $key => $value) {}
                    include('vista/admin/categoria/editar.php');
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
                        $searchSQL = " AND  (c.categoria like '%" .$search. "%') ";
                        $this->adminCategoriaModelo->set("search",$searchSQL);
                    }
                    $activoSQL = "";
                    if($_POST['activo'] != ""){
                        $activo = htmlspecialchars(strip_tags($_POST['activo']));
                        $activoSQL = " AND  c.activo = $activo ";
                        $this->adminCategoriaModelo->set("activo",$activoSQL);
                    }
                    $res = $this->adminCategoriaModelo->mostrar();
                    include('vista/admin/categoria/categoria.php');
                }
            }else{
                header("Location: ".URL."adminPuntoVenta");
            }
        }else{
            header("Location: ".URL."adminLogin");
        }
    }

    public function categoriaServlet(){
        session_start();
        if(isset($_SESSION['idEmpleado'])){
            if($_SESSION['rolEmpleado'] == "admin" || $_SESSION['rolEmpleado'] == "gerente"){
                if($_POST){

                    //Instancia 
                    $this->optimizarImagenControlador = new optimizarImagenControlador();

                    $extencion = ".webp";
                    $calidad = 70;
                    $ruta = "libreria/imgCategoria/";

                    //Obtenemos datos via post
                    $categoria = htmlspecialchars(strip_tags($_POST['categoria']));

                    if(!empty($_FILES['imagen']['name'])){

                        //Eliminamos la anterior imagen
                        if(!empty($_POST['imagenBackup'])){
                            if(file_exists($ruta.$_POST['imagenBackup'])){
                                unlink($ruta.$_POST['imagenBackup']);
                            }else{
                                echo "NO SE ENCUENTRO LA RUTA: ".$ruta.$_POST['imagenBackup'];
                            }
                        }

                        //Obtenemos los datos de la nueva imagen e insertamos
                        $imagen = date('i-s').$_FILES['imagen']['name'].$extencion;
                        $imagenTmpName = $_FILES['imagen']['tmp_name'];
                        $this->optimizarImagenControlador->optimizarImagen($imagenTmpName, $ruta.$imagen, $calidad);

                    }else{
                        $imagen = $_POST['imagenBackup'];
                    }

                    //Seteamos los datos obtenidos al modelo
                    $this->adminCategoriaModelo->set("categoria",$categoria);
                    $this->adminCategoriaModelo->set("imagen",$imagen);

                    if($_POST['actividad'] == "nuevo"){
                        
                        $this->adminCategoriaModelo->nuevo();
                        echo 1; //Nuevo correctamente
                    }else if($_POST['actividad'] == "editar"){

                        $idCategoria = openssl_decrypt(htmlspecialchars(strip_tags($_POST['idCategoria'])), COD, KEY);
                        $activo = htmlspecialchars(strip_tags($_POST['activo']));

                        $this->adminCategoriaModelo->set("idCategoria",$idCategoria);
                        $this->adminCategoriaModelo->set("activo",$activo);

                        $this->adminCategoriaModelo->editar();
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

    public function reporte(){
        session_start();
        if(isset($_SESSION['idEmpleado'])){
            if($_SESSION['rolEmpleado'] == "admin" || $_SESSION['rolEmpleado'] == "gerente"){
                    
                    //Inicio
                    $this->reportePlantillaFPDF->inicio();
                     // Título
                    $this->reportePlantillaFPDF->titulo("Reporte de categorias");
                    //Encabezado
                    $this->reportePlantillaFPDF->Header();
                    //Encabezado de tablas
                    $this->reportePlantillaFPDF->fpdf->Cell(100,10,'Categoria',1,0,'C',0);
                    $this->reportePlantillaFPDF->fpdf->Cell(45,10,'Fecha',1,1,'C',0);
                    //Cuerpo
                    $res = $this->adminCategoriaModelo->mostrar();
                    foreach ($res as $key) {
                        $this->reportePlantillaFPDF->fpdf->Cell(100,10,$key['categoria'],1,0,'C',0);
                        $this->reportePlantillaFPDF->fpdf->Cell(45,10,$key['fechaAlta'],1,1,'C',0);
                    }
                   // $this->reportePlantillaFPDF->Footer();
                    $this->reportePlantillaFPDF->fpdf->Output();
                   

            }else{
                header("Location: ".URL."adminPuntoVenta");
            }
        }else{
            header("Location: ".URL."adminLogin");
        }
    }

    //Funcion especial para ver todas las categorias que estan ligadas a los productos por parte de las sub categorias para la pagina de incio
	public function coleccion() {
       return $this->adminCategoriaModelo->coleccion();
	}

}
?>
