<?php

require_once 'modelo/productoMasVendidoModelo.php';
require_once 'controlador/productoFavoritoControlador.php';
require_once 'controlador/productoEstrellaControlador.php';


class ProductoMasVendidoControlador {

    private $productoMasVendidoModelo; //variable para generar el objeto de la instancia al modelo de este controlador
    private $productoFavoritoControlador; 
    private $productoEstrellaControlador; 

    //SIRVE: Para hacer un objeto mediante la instancia de este controlador al modelo de este mismo
    //PORQUE: Por que es necesario tener conectividad con el modelo que es el que se encarga de la base de datos
    public function __construct() {
        $this->productoMasVendidoModelo = new ProductoMasVendidoModelo();
        $this->productoFavoritoControlador = new ProductoFavoritoControlador();
        $this->productoEstrellaControlador = new ProductoEstrellaControlador();
    } 

    public function productoMasVendido(){
       $res = $this->productoMasVendidoModelo->productoMasVendido();
       $row = $res->rowCount();
       if($row > 0){
          $pagina = "productoNuevo";
          include 'vista/cliente/producto/index.php';
       }
    }

    public function productoMasVendidoMin(){
       $res = $this->productoMasVendidoModelo->productoMasVendido();
       $row = $res->rowCount();
       if($row > 0){
          include 'vista/cliente/productoMin/index.php';
       }
    }

}
?>
