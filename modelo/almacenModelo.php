<?php
/**
 * Autor Rigoberto Villa Rodríguez
 */

require_once 'conexion.php';

class AlmacenModelo{
	
	//Atributos propios del producto
	private $idProducto;
	private $idProductoDetalle;
	private $idSubCategoria;
	private $genero;
	private $producto;
	private $descripcion;
	private $observacion;
	private $precio;
	private $imagenPrincipal;
	private $imagen;
	private $activoOferta;
	private $titulo;
	private $subTitulo;
	private $fechaFinOferta;
	private $imagenOferta;
	private $fechaAlta;
	private $activo;
	private $search;
	private $conexion;

	public function __construct() {
		$this->conexion = new Conexion();
	} 

	public function construir(){
		$sql = "SELECT p.*,sc.*,g.*,pr.*,p.observacion AS 'observacionProducto',pr.observacion AS 'observacionProveedor'
				FROM producto p
				INNER JOIN sub_categoria sc ON sc.id_sub_categoria = p.id_sub_categoria 
				INNER JOIN categoria c ON c.id_categoria = sc.id_categoria
				INNER JOIN producto_genero g ON g.id_genero = p.id_genero
				INNER JOIN proveedor pr ON pr.id_proveedor = p.id_proveedor
				WHERE 1 AND p.activo = 1
				".$this->idProducto."
				";
		return $this->conexion->mostrarSQL($sql);
	}

	public function producto(){
		$sql = "SELECT p.*,sc.*,g.* 
				FROM producto p
				INNER JOIN sub_categoria sc ON sc.id_sub_categoria = p.id_sub_categoria 
				INNER JOIN categoria c ON c.id_categoria = sc.id_categoria
				INNER JOIN producto_genero g ON g.id_genero = p.id_genero
				WHERE 1 
				".$this->search."
				".$this->activo."
				ORDER BY p.id_producto DESC
				LIMIT 1000
				";
		return $this->conexion->mostrarSQL($sql);
	}

	public function mostrarDetalle(){
		$sql = "SELECT pd.*,t.*
				FROM producto_detalle pd
				INNER JOIN producto_talla t ON t.id_talla = pd.id_talla
				WHERE 1 AND pd.activo = 1
				".$this->idProducto."
				";
		return $this->conexion->mostrarSQL($sql);
	}

	public function productoNuevo($producto,$precio,$idProveedor,$idSubCategoria,$idGenero,$descripcion,$imagenPrincipal,$observacion,$activoOferta,$precioOferta,$titulo,$subTitulo,$fechaFinOferta,$imagenOferta){
		$sql = " INSERT INTO producto (id_proveedor,id_sub_categoria,id_genero,producto,descripcion,observacion,precio,imagen_principal,activo_oferta,precio_oferta,titulo,sub_titulo,fecha_fin_oferta,imagen_oferta,fecha_alta,activo) VALUES($idProveedor,$idSubCategoria,$idGenero,'$producto','$descripcion','$observacion','$precio','$imagenPrincipal',$activoOferta,'$precioOferta','$titulo','$subTitulo','$fechaFinOferta','$imagenOferta',NOW(),1)";
		$this->conexion->ejecutarSQL($sql);
		$sql = "SELECT MAX(id_producto) AS 'idProducto' FROM producto WHERE activo = 1";
		$res = $this->conexion->mostrarSQL($sql);
		$idProducto = "";
		foreach ($res as $key) {
			$idProducto = $key['idProducto'];
		}
		return $idProducto;
	}

	public function productoNuevoDetalle($idProducto,$idTalla,$color,$imagen1,$imagen2,$imagen3,$imagen4,$imagen5,$imagen6,$cantidad){
		$sql = " INSERT INTO producto_detalle (id_producto,id_talla,color,imagen1,imagen2,imagen3,imagen4,imagen5,imagen6,cantidad,activo) VALUES ($idProducto,$idTalla,'$color','$imagen1','$imagen2','$imagen3','$imagen4','$imagen5','$imagen6',$cantidad,1)";
		$this->conexion->ejecutarSQL($sql);
	}

	public function productoEditar($idProducto,$producto,$precio,$idProveedor,$idSubCategoria,$idGenero,$descripcion,$imagenPrincipal,$observacion,$activoOferta,$precioOferta,$titulo,$subTitulo,$fechaFinOferta,$imagenOferta){
		$sql = "UPDATE producto SET id_proveedor = $idProveedor,id_sub_categoria = $idSubCategoria,id_genero = $idGenero,producto = '$producto',descripcion = '$descripcion',observacion = '$observacion',precio = '$precio',imagen_principal = '$imagenPrincipal',activo_oferta = $activoOferta,precio_oferta = '$precioOferta',titulo = '$titulo',sub_titulo = '$subTitulo',fecha_fin_oferta = '$fechaFinOferta',imagen_oferta = '$imagenOferta' WHERE id_producto = $idProducto ";
		$this->conexion->ejecutarSQL($sql);
	}

	public function detalleEditar($detalleSQL){
		$sql = "UPDATE producto_detalle SET $detalleSQL WHERE id_producto_detalle = $this->idProductoDetalle ";
		$this->conexion->ejecutarSQL($sql);
	}

	public function eliminarProducto($idProducto){
		$sql = "UPDATE producto SET activo = 0  WHERE id_producto = $idProducto";
		return $this->conexion->ejecutarSQL($sql);
	}

	public function eliminarImagen($idProductoDetalle,$atributo){
		$sql = "UPDATE producto_detalle SET $atributo = '' WHERE id_producto_detalle = $idProductoDetalle";
		return $this->conexion->ejecutarSQL($sql);
	}

	public function eliminarProductoDetalle(){
		$sql = "UPDATE producto_detalle SET activo = 0 WHERE id_producto_detalle = $this->idProductoDetalle";
		return $this->conexion->ejecutarSQL($sql);
	}

	public function selectProveedor(){
		$sql = "SELECT * FROM proveedor WHERE activo = 1";
		return $this->conexion->mostrarSQL($sql);
	}

	public function selectSubCategoria(){
		$sql = "SELECT * FROM sub_categoria WHERE activo = 1";
		return $this->conexion->mostrarSQL($sql);
	}

	public function selectGenero(){
		$sql = "SELECT * FROM producto_genero WHERE activo = 1";
		return $this->conexion->mostrarSQL($sql);
	}

	public function selectTalla(){
		$sql = "SELECT * FROM producto_talla WHERE activo = 1";
		return $this->conexion->mostrarSQL($sql);
	}

    public function set($atributo,$contenido){
		$this->$atributo = $contenido;
	}

	public function get($atributo){
		return $this->$atributo;
	}


}
?>
