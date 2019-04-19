<?php
require_once 'conexion.php';

class perfilModelo{

	private $conexion;

	public function __construct() {
		$this->conexion = new conexion();
	} 

	public function direccion($idUsuario){
		$sql = "SELECT u.*,ud.*,m.*,e.* 
				FROM usuario u
				INNER JOIN usuario_detalle ud ON ud.id_usuario = u.id_usuario
				INNER JOIN municipio m ON m.id_municipio = ud.id_municipio 
				INNER JOIN estado e ON e.id_estado = m.id_estado
				WHERE u.activo = 1 AND ud.activo = 1 AND u.id_usuario = $idUsuario
				ORDER BY ud.direccion";
		return $this->conexion->mostrarSQL($sql);
	}

	public function direccionNueva($POST,$idUsuario){
		$idMunicipio = openssl_decrypt($POST['idMunicipio'], COD, KEY);
		$nombreCompleto = htmlspecialchars(addslashes($POST['nombreCompleto']));
		$direccion = htmlspecialchars(addslashes($POST['direccion']));
		$observacion = htmlspecialchars(addslashes($POST['observacion']));
		$codigoPostal = htmlspecialchars(addslashes($POST['codigoPostal']));
		$celular = htmlspecialchars(addslashes($POST['celular']));

		$sql = "INSERT INTO usuario_detalle(id_usuario,id_municipio,nombre_completo,direccion,observacion,codigo_postal,celular,fecha_alta,activo) VALUES($idUsuario,$idMunicipio ,'$nombreCompleto','$direccion','$observacion','$codigoPostal','$celular',NOW(),1)";
		$this->conexion->ejecutarSQL($sql);

		$sql = "SELECT MAX(id_usuario_detalle) AS 'idUsuarioDetalle' FROM usuario_detalle WHERE id_usuario = $idUsuario ";
		$res = $this->conexion->mostrarSQL($sql);

		foreach ($res as $key) {
			$idUsuarioDetalle = $key['idUsuarioDetalle'];
		}
		return $idUsuarioDetalle;
	}

	public function set($atributo,$contenido){
		$this->$atributo = $contenido;
	}

	public function get($atributo){
		return $this->$atributo;
	}

}
?>