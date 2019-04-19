<?php 
class conexion{
	
	//Inifini free
	/*
	private $servidor = "sql202.epizy.com";
	private $usuario = "epiz_21423647";
	private $password = "6qYUZrr7xazk";
	private $bd = "epiz_21423647_carritocompras";
	private $conexion;
	*/
	//000webhost
	/*
	private $servidor = "localhost";
	private $usuario = "id4198174_mirennay";
	private $password = "mirennay";
	private $bd = "id4198174_mirennay";
	private $conexion;
	*/
	//localhost
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
	      	die('Error en la consulta ejecutar: <br>'.$e->getMessage());
	    }
	}

	public function mostrarSQL($sql){
		try{
			return $res = $this->conexion->query($sql);
		 }catch(PDOException $e){
	      	die('Error en la consulta mostrar: <br>'.$e->getMessage());
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