<?php

//imports
require_once 'modelo/tiendaModelo.php';
require_once 'controlador/productoFavoritoControlador.php';
require_once 'controlador/productoEstrellaControlador.php';
require_once 'controlador/productoMasVendidoControlador.php';

class TiendaControlador{

	//variable para generar el objeto de la instancia al modelo de este controlador
	private $tiendaModelo; 
	//variable para generar el objeto de la instancia al controlador de productoControlador
	private $productoFavoritoControlador; 
    private $productoEstrellaControlador; 
    private $productoMasVendidoControlador; 

			
	//SIRVE: Para hacer un objeto mediante la instancia de este controlador al modelo de este mismo
	//PORQUE: Por que es necesario tener conectividad con el modelo que es el que se encarga de la base de datos
	public function __construct(){
		$this->tiendaModelo = new tiendaModelo();
		$this->productoFavoritoControlador = new productoFavoritoControlador();
        $this->productoEstrellaControlador = new productoEstrellaControlador();
        $this->productoMasVendidoControlador = new productoMasVendidoControlador();

	} 

	public function index() {
		session_start();
		include('vista/cliente/head/index.php');
        include('vista/cliente/header/index.php');
		include('vista/cliente/menu/index.php');

    	include('vista/cliente/tienda/index.php');

    	include('vista/cliente/contacto/index.php');
    	include('vista/cliente/footer/index.php');
	}
	
	//SIRVE: Para paginar los registros
	//PORQUE: Porque permite mantener el tamaño de cada página dentro de lo manejable
	public function tiendaPaginadorEnlistar(){ 
		session_start();
		if($_POST){
			$cantidadPagina = 9;
			if(isset($_POST['cantidadPagina'])){
				$cantidadPagina = $_POST['cantidadPagina'];
			}
			$paginaNumero = 1;
			if(isset($_POST['paginaNumero'])){
				$paginaNumero = $_POST['paginaNumero'];
			}
			$idSubCategoriaSQL = "";
			if(!empty($_POST['idSubCategoria'])){
				$idSubCategoriaArray = $_POST['idSubCategoria'];
				$idSubCategoria = json_decode($_POST['idSubCategoria']);
				$longitudIdSubCategoria = count($idSubCategoria);
				if($longitudIdSubCategoria > 0){
					for ($i=0; $i < $longitudIdSubCategoria ; $i++) { 
						if($i == 0){
							$idSubCategoriaSQL .= " AND ( sc.id_sub_categoria = ".openssl_decrypt($idSubCategoria[$i],COD,KEY)." ";
						}if($i > 0){
							$idSubCategoriaSQL .= "OR sc.id_sub_categoria = ".openssl_decrypt($idSubCategoria[$i],COD,KEY)." ";
						}
					}
					$idSubCategoriaSQL .= ")";
				}
			}
			$idGeneroSQL = "";
			$idGenero = "";
			if(!empty($_POST['idGenero'])){
				$idGenero = $_POST['idGenero'];
				$idGeneroSQL = " AND g.id_genero = ".openssl_decrypt($_POST['idGenero'],COD,KEY);
			}
			$precioSQL = "";
			$precioMin = "";
			$precioMax = "";
			if(isset($_POST['precioMin']) && isset($_POST['precioMax'])){
				$precioMin = $_POST['precioMin'];
				$precioMax = $_POST['precioMax'];
				if($_POST['precioMin'] == "" && $_POST['precioMax'] == ""){
					$precioSQL = "";
				}else{
					$precioSQL = " AND  ( (p.precio >= '$precioMin' AND p.precio <= '$precioMax' AND p.activo_oferta = 0) OR (p.precio_oferta >= '$precioMin' AND p.precio_oferta <= '$precioMax' AND p.activo_oferta = 1) ) ";
				}
			}
			$idCategoriaSQL = "";
			$idCategoria = "";
			if(isset($_POST['idCategoria']) && $_POST['idCategoria'] != ""){
				$idCategoria = $_POST['idCategoria'];
				if($idCategoria != ""){
					$idCategoriaSQL = " AND c.id_categoria = ".openssl_decrypt($_POST['idCategoria'],COD,KEY);
				}
			}
			$searchSQL = "";
			$search = "";
			if(isset($_POST['search']) && $_POST['search'] != ""){
				$search = $_POST['search'];
				$searchSQL = " AND  (p.producto like '%" . $_POST['search'] . "%' OR  sc.sub_categoria like '%" . $_POST['search'] . "%' OR p.precio like '%" . $_POST['search'] . "%' OR  c.categoria like '%" . $_POST['search'] . "%') ";
			}

			//Obtener el total de registros
			$rowCount = $this->tiendaModelo->tiendaPaginadorEnlistarRowCount($searchSQL,$idCategoriaSQL,$idGeneroSQL,$precioSQL,$idSubCategoriaSQL);

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
				$res = $this->tiendaModelo->tiendaPaginadorEnlistar($searchSQL,$idCategoriaSQL,$idGeneroSQL,$precioSQL,$idSubCategoriaSQL,$limiteSQL,$cantidadPagina);

				if($res != false){
					//Si hay resultados pues los mostramos
					$pagina = "tienda";
					include 'vista/cliente/producto/index.php';
					include 'vista/cliente/tienda/paginador.php';
				}else{
					echo "Lociento no hay productos";
				}
			}else{ 
				echo "Lociento no hay productos";
			}

		}	
	} 

	//SIRVE: Para mostrar solamente las sub categorias que estan relacionadas con algun producto
	//PORQUE: Ya que de nada sirve mostrar las sub categorias si algunas no tendran un producto relacionado
	public function mostrarSubCategoria(){
		return $res = $this->tiendaModelo->mostrarSubCategoria();
	}

	//SIRVE: Para mostrar solamente los generos que estan relacionadas con algun producto
	//PORQUE: Ya que de nada sirve mostrar los generos si algunos no tendran un producto relacionado
	public function mostrarGenero(){
		return $res = $this->tiendaModelo->mostrarGenero();
	}

}
?>
