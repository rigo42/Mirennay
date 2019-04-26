<?php 

	/**
	 * Autor Rigoberto Villa
	 */

	class optimizarImagenControlador
	{
		
		function __construct(){
			
		}

		public function optimizarImagen($origen, $destino, $calidad) {

		      $info = getimagesize($origen);

		      if ($info['mime'] == 'image/jpeg'){
			    $imagen = imagecreatefromjpeg($origen);
		      }

			  else if ($info['mime'] == 'image/gif'){
			    $imagen = imagecreatefromgif($origen);
			  }

			  else if ($info['mime'] == 'image/png'){
			    $imagen = imagecreatefrompng($origen);
			  }

			  imagejpeg($imagen, $destino, $calidad);
			  
			  return $destino;
			  
		}
		/* asi se llama la funcion
			$imagen = optimizarImagen( $_FILES['imagen']['tmp_name'], $destino, 40 );
		*/
	}
 ?>