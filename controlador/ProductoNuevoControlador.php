<?php

require_once 'modelo/ProductoNuevoModelo.php';
require_once 'controlador/ProductoFavoritoControlador.php';
require_once 'controlador/ProductoEstrellaControlador.php';


class ProductoNuevoControlador {

    private $productoNuevoModelo; //variable para generar el objeto de la instancia al modelo de este controlador
    private $productoFavoritoControlador; 
    private $productoEstrellaControlador; 

    //SIRVE: Para hacer un objeto mediante la instancia de este controlador al modelo de este mismo
    //PORQUE: Por que es necesario tener conectividad con el modelo que es el que se encarga de la base de datos
    public function __construct() {
        $this->productoNuevoModelo = new ProductoNuevoModelo();
        $this->productoFavoritoControlador = new ProductoFavoritoControlador();
        $this->productoEstrellaControlador = new ProductoEstrellaControlador();
    } 

    public function productoNuevo(){
       $res = $this->productoNuevoModelo->productoNuevo();
       $row = $res->rowCount();
       if($row > 0){
          $pagina = "productoNuevo";
          include 'vista/cliente/producto/index.php';
       }
    }

}
?>
