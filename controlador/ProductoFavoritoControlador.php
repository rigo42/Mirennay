<?php

require_once 'modelo/ProductoFavoritoModelo.php';


class ProductoFavoritoControlador {
 
    private $productoFavoritoModelo; //variable para generar el objeto de la instancia al modelo de este controlador

    //SIRVE: Para hacer un objeto mediante la instancia de este controlador al modelo de este mismo
    //PORQUE: Por que es necesario tener conectividad con el modelo que es el que se encarga de la base de datos
    public function __construct() {
        $this->productoFavoritoModelo = new ProductoFavoritoModelo();
    } 

    //SIRVE: Para mostrar la plantilla ventana de favorito
    //PORQUE: Porque es mejor tener todo esto bien separado. y llamarlo cuando haga falta
    public function ventanaFavorito($res,$row){
        include('vista/cliente/header/ventanaFavorito.php');
    }

    //SIRVE: Para mostrar los productos favoritos del cliente
    //PORQUE: Porque es necesario mostrar al cliente sus productos favoritos
    public function productoVentanaFavorito(){
        session_start();
        if(isset($_SESSION['idUsuario'])){
            $idUsuario = $_SESSION['idUsuario'];
            $res = $this->productoFavoritoModelo->productoVentanaFavorito($idUsuario);
            $row = $res->rowCount();
            $this->ventanaFavorito($res,$row);
        }else{
          echo "Necesitas iniciar sesión para guardar en favoritos";
        }
    }

    //SIRVE: Para añadir o quitar de favorito
    //PORQUE: Para administrar los favoritos del usuario
    public function productoFavorito(){
        if(!isset($_SESSION['idUsuario'])){
            session_start();
        }
        if($_POST){
            if(isset($_SESSION['idUsuario'])){
                if(isset($_POST['idProducto'])){
                    $idProducto = openssl_decrypt($_POST['idProducto'], COD, KEY);
                    $idUsuario = $_SESSION['idUsuario'];
                    $this->productoFavoritoModelo->productoFavorito($idProducto,$idUsuario);
                }
            }else{
                echo 1; //Significa que debe iniciar sesión;
            }
        }
    }

    //SIRVE: Para mostrar el icono de corazon azul si lo tiene en favorito, o normal si no lo tiene o simplemente no tiene sesion iniciada
    //PORQUE: Por que el usuario necesita identificar si su producto esta en favorito o no
    public function productoFavoritoComprobar($idProducto){
        if(isset($_SESSION['idUsuario'])){
            $idUsuario = $_SESSION['idUsuario'];
            $res = $this->productoFavoritoModelo->productoFavoritoComprobar($idProducto,$idUsuario);
            $row = $res->rowCount();
            if($row > 0){
                foreach ($res as $key) {
                    $comprobarActivo = $key['comprobarActivo'];
                }
                return $comprobarActivo;
            }else{
                return $comprobarActivo = 0;
            }
        }else{
           return 2; //Debe iniciar sesión
        }
    }

}
?>
