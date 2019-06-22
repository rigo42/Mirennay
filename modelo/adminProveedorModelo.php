<?php
/**
 * Autor Rigoberto Villa Rodríguez
 */

require_once 'conexion.php';

class adminProveedorModelo{

	private $idProveedor;
	private $idEmpresa;
	private $proveedor;
	private $fechaAlta;
	private $activo;
	private $search;
	private $conexion;

	public function __construct() {
		$this->conexion = new conexion();
	} 

	public function construir(){
		$sql = "SELECT p.*,e.*,DATE_FORMAT(p.fecha_alta, '%e %M, %Y') AS fechaAlta,p.activo AS activoP
				FROM proveedor p
				INNER JOIN empresa e ON e.id_empresa = p.id_empresa
				WHERE 1 
				$this->idProveedor
				ORDER BY p.proveedor ASC
				";
		return $this->conexion->mostrarSQL($sql);
	}

	public function mostrar(){
		$sql = "SELECT p.*,e.*,DATE_FORMAT(p.fecha_alta, '%e %M, %Y') AS fechaAlta
				FROM proveedor p
				INNER JOIN empresa e ON e.id_empresa = p.id_empresa
				WHERE 1 
				$this->search
				$this->activo
				ORDER BY p.proveedor ASC
				";
		return $this->conexion->mostrarSQL($sql);
	}

	public function nuevo(){
		$sql = "INSERT INTO proveedor (id_empresa,proveedor,fecha_alta,activo)
				VALUES($this->idEmpresa,'$this->proveedor',NOW(),1)";
		$this->conexion->ejecutarSQL($sql);
	}

	public function editar(){
		$sql = "UPDATE proveedor 
				SET proveedor = '$this->proveedor',id_empresa = $this->idEmpresa, activo = $this->activo
				WHERE id_proveedor = $this->idProveedor";
		$this->conexion->ejecutarSQL($sql);
	}

	public function selectEmpresa(){
		$sql = "SELECT e.*
				FROM empresa e
				WHERE e.activo = 1";
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
