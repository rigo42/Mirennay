<?php
//Password de encriptamiento
define('KEY',"terribibibi42");
define('COD',"AES-128-ECB");

//Enrutadores
define('DS',DIRECTORY_SEPARATOR);
define('ROOT',realpath(dirname(__FILE__)).DS);
define('URL',"http://localhost/mirennayv3/");

//Ejecutar funcion automatizada
require_once('ajuste/autoload.php');
Autoload::run();
Enrutador::run(new Request());
?>