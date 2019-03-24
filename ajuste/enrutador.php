<?php 
	class Enrutador{
		
		public function run(Request $request){

			//Variables si todo esta bien
		    $controlador = $request->getControlador()."Controlador";
		    $metodo = $request->getMetodo();
		    $argumento = $request->getArgumento();
			$ruta = ROOT."controlador".DS.$controlador.".php";

			//Variables si llegase haber un error por parte del usuario
			$controladorError404 = "Error404Controlador";
		    $metodoError404 = "index";
		    $rutaError404 = ROOT."controlador".DS."Error404Controlador.php";
			

			if(file_exists($ruta)){
			  	require_once($ruta);
			  	$controlador = new $controlador();
				if(method_exists($controlador,$metodo)){
					 $controlador->$metodo($argumento);
				}else{
					if(file_exists($rutaError404)){
						require_once($rutaError404);
					  	$controladorError404 = new $controladorError404();
					  	$controladorError404->$metodoError404();
					}else{
						echo "Ruta pagina Error404 erronea";
					}
				}
			}else{
			  	if(file_exists($rutaError404)){
					require_once($rutaError404);
				  	$controladorError404 = new $controladorError404();
				  	$controladorError404->$metodoError404();
				}else{
					echo "Ruta pagina Error404 erronea";
				}
			}

		}
	}
 ?>