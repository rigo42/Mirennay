<?php 
	include('conexion.php');
	session_start();

	$actividad = mysqli_real_escape_string($conexion,$_POST['actividad']);
	$usuario = mysqli_real_escape_string($conexion,$_POST['usuario']);
	$password = mysqli_real_escape_string($conexion,$_POST['password']);

	if($actividad == "nuevo"){
		$passwordC = mysqli_real_escape_string($conexion,$_POST['passwordC']);
		if($password == $passwordC){
			$correo = mysqli_real_escape_string($conexion,$_POST['correo']);
			$validarCorreo = validarCorreo($correo);
			if($validarCorreo == 1){
				$sqlValidarUsuario = " SELECT * FROM usuario WHERE usuario = '".$usuario."' AND activo = 1 ";
				if($resValidarUsuario = mysqli_query($conexion,$sqlValidarUsuario)){
					$rowValidarUsuario = mysqli_num_rows($resValidarUsuario);
					if($rowValidarUsuario > 0){
						echo "4";
					}else{

						$sqlValidarCorreo = " SELECT * FROM usuario WHERE correo = '".$correo."' AND activo = 1  ";
						if($resValidarCorreo = mysqli_query($conexion,$sqlValidarCorreo)){
							$rowValidarCorreo = mysqli_num_rows($resValidarCorreo);
							if($rowValidarCorreo > 0){
								echo "5";
							}else{
								$sqlInsertarUsuario = " INSERT INTO usuario (usuario,password,correo,rol,fecha_inicio,fecha_fin,fecha_alta,activo)
										VALUES('".$usuario."',SHA1('".$password."'),'".$correo."','cliente',NOW(),null,NOW(),1 ) ";
								if(mysqli_query($conexion,$sqlInsertarUsuario)){
									$sqlUsuario = "SELECT MAX(a.id_usuario) AS 'idUsuario', a.* FROM usuario a WHERE activo = 1 ";
									if($resUsuario2 = mysqli_query($conexion,$sqlUsuario)){
										foreach ($resUsuario2 as $keyUsuario2) {
											 $_SESSION['idUsuario'] = $keyUsuario2['idUsuario'];
											 $_SESSION['correo'] = $keyUsuario2['correo'];
											 $_SESSION['rol']  = $keyUsuario2['rol'];
											 $_SESSION['usuario']  = $keyUsuario2['usuario'];
										}
									}
									echo "1";
								}else{
									mysqli_error($conexion);
								}
							}
						}else{
							echo mysqli_error($conexion);
						}
					}
				}else{
					echo mysqli_error($conexion);
				}
			}else{
				echo "3";
			}
		}else{
			echo "2";
		}
	}else{
		if(isset($_POST['usuario']) && isset($_POST['password']) ){
			$sqlUsuario = "SELECT * FROM usuario WHERE (usuario = '".$usuario."' AND password = SHA1('".$password."')) OR (correo = '".$usuario."' AND password = SHA1('".$password."') ) AND activo = 1 ";
			if($resUsuario = mysqli_query($conexion,$sqlUsuario)){
				$rowUsuario = mysqli_num_rows($resUsuario);
				if($rowUsuario > 0){
					foreach ($resUsuario as $keyUsuario) {
						$_SESSION['idUsuario'] = $keyUsuario['id_usuario'];
						$_SESSION['rol']  = $keyUsuario['rol'];
						$_SESSION['usuario'] = $keyUsuario['usuario'];
					}
					echo "1";
				}else{
					echo "2";
				}
			}else{
				echo mysqli_error($conexion);
			}
		}
	}

	function validarCorreo($email){ 
	   	$mail_correcto = 0; 
	   	//compruebo unas cosas primeras 
	   	if ((strlen($email) >= 6) && (substr_count($email,"@") == 1) && (substr($email,0,1) != "@") && (substr($email,strlen($email)-1,1) != "@")){ 
	      	if ((!strstr($email,"'")) && (!strstr($email,"\"")) && (!strstr($email,"\\")) && (!strstr($email,"\$")) && (!strstr($email," "))) { 
	         	//miro si tiene caracter . 
	         	if (substr_count($email,".")>= 1){ 
	            	//obtengo la terminacion del dominio 
	            	$term_dom = substr(strrchr ($email, '.'),1); 
	            	//compruebo que la terminación del dominio sea correcta 
	            	if (strlen($term_dom)>1 && strlen($term_dom)<5 && (!strstr($term_dom,"@")) ){ 
	               	//compruebo que lo de antes del dominio sea correcto 
	               	$antes_dom = substr($email,0,strlen($email) - strlen($term_dom) - 1); 
	               	$caracter_ult = substr($antes_dom,strlen($antes_dom)-1,1); 
	               	if ($caracter_ult != "@" && $caracter_ult != "."){ 
	                  	$mail_correcto = 1; 
	               	} 
	            	} 
	         	} 
	      	} 
	   	} 
	   	if ($mail_correcto) 
	      	return 1; 
	   	else 
	      	return 0; 
	}
	
 ?>