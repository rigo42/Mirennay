<?php

require_once 'modelo/ProductoEstrellaModelo.php';


class ProductoEstrellaControlador {

    private $productoEstrellaModelo; //variable para generar el objeto de la instancia al modelo de este controlador

    //SIRVE: Para hacer un objeto mediante la instancia de este controlador al modelo de este mismo
    //PORQUE: Por que es necesario tener conectividad con el modelo que es el que se encarga de la base de datos
    public function __construct() {
        $this->productoEstrellaModelo = new ProductoEstrellaModelo();
    } 


    //SIRVE: Muestra la cantidad de estrellas de cada producto
    //PORQUE: El usuario se da a guiar con la cantidad de estrellas del producto
    public function productoEstrella($idProducto){
        $res = $this->productoEstrellaModelo->productoEstrella($idProducto);
        foreach ($res as $key ) {
            if($key['sumaEstrella'] == 0){
                $estrellas = 0;
            }else if($key['cantidadEstrella'] == 0){
                $estrellas = 0;
            }else{
                $estrellas = round($key['sumaEstrella'] / $key['cantidadEstrella'],0);
            }
        }
        return $estrellas;
    }

    //SIRVE: Muestra la cantidad de estrellas que le an dado los clientes en forma de encuesta
    //PORQUE: El usuario se da a guiar con la cantidad de estrellas del producto
    public function ventanaEncuestaEstrella(){
        if($_POST){
            $idProducto = openssl_decrypt($_POST['idProducto'], COD, KEY);
            $estrellas = $this->productoEstrella($idProducto);
            $resPersonas = $this->productoEstrellaModelo->productoEstrella($idProducto);
            foreach ($resPersonas as $keyPersonas) {
                $personas = $keyPersonas['cantidadEstrella'];
            }
            include('vista/cliente/productoDetalle/ventanaEncuestaEstrella.php');
        }
    }

    public function ventanaEncuestaComentario(){
        session_start();
        if($_POST){

            $idProducto = openssl_decrypt($_POST['idProducto'], COD, KEY);
            $paginaNumero = $_POST['paginaNumero'];
            $cantidadPagina = $_POST['cantidadPagina'];

            $rowCount = $this->productoEstrellaModelo->ventanaEncuestaComentarioRowCount($idProducto);

            //Validamos si hay registros, si hay que siga el funcionamiento
            if($rowCount>0){

                //Obtener el total de paginas que seran
                $totalPag =  ceil(($rowCount / $cantidadPagina));
                
                //
                $div = 1;
                 
                 //Inicio del rango del paginador
                 if($paginaNumero > $div){
                    $pagInicio = ($paginaNumero - $div);
                 }else{
                    $pagInicio = 1;
                 }
                 //Tamaño del paginador
                if ($totalPag > $div) {
                   $pagRestantes = $totalPag - $paginaNumero;
                    if($pagRestantes > $div){
                        $pagFin = $paginaNumero + $div;
                    }else{
                        $pagFin = $totalPag;
                    }
                }else {
                    $pagFin = $totalPag;
                }

                //Validar el limite de la consulta de base de datos
                $limiteSQL = ($paginaNumero - 1) * $cantidadPagina;

                //Obtener todos los productos limitando para el paginador con el limit de la base de datos
                $res = $this->productoEstrellaModelo->ventanaEncuestaComentarioEnlistar($idProducto,$limiteSQL,$cantidadPagina);
            }
            include('vista/cliente/productoDetalle/ventanaEncuestaComentario.php');
        }
    }

    public function ventanaEncuestaFormulario($idProducto){
        session_start();
        if(isset($_SESSION['idUsuario'])){
            include('vista/cliente/productoDetalle/ventanaEncuestaFormulario.php');
        }
    }

    public function insertarEncuestaFormulario(){
        session_start();
        if($_POST){
            $idProducto = openssl_decrypt($_POST['idProducto'], COD, KEY);
            $idUsuario = $_SESSION['idUsuario'];
            $comentario = htmlspecialchars(addslashes($_POST['comentario']));
            $cantidadEstrella = $_POST['cantidadEstrella'];
            $this->productoEstrellaModelo->insertarEncuestaFormulario($idUsuario,$idProducto,$comentario,$cantidadEstrella);
        }
    }

}
?>
