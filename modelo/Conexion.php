<?php 
class Conexion{
	
	private $servidor = "localhost";
	private $usuario = "root";
	private $password = "";
	private $bd = "mirennayv2";
	private $conexion;
		
	public function __construct(){
		try{
		$this->conexion = new PDO('mysql:host='.$this->servidor.';dbname='.$this->bd, $this->usuario, $this->password);
		$this->conexion->exec("SET CHARACTER SET utf8");
		$this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}catch(PDOException $e){
		     die('Error al conectarse a la base de datos: <br>'.$e->getMessage());
		}
	}

	public function ejecutarSQL($sql){
		try{
	   		$res = $this->conexion->prepare($sql);
			$res->execute();
		}catch(PDOException $e){
	      	die('Error en la consulta: <br>'.$e->getMessage());
	    }
	}

	public function mostrarSQL($sql){
		try{
			return $res = $this->conexion->query($sql);
		 }catch(PDOException $e){
	      	die('Error en la consulta: <br>'.$e->getMessage());
	    }
	}

	public function rowSQL($sql) {
		try {
			$res = $this->conexion->query($sql);
			$row = $res->rowCount();
			return $row;
		} catch (PDOException $e){
			return "Error: ".$e->getMessage();
		}
	}


}
 ?>