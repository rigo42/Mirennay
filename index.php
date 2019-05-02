<?php
//Password de encriptamiento
define('KEY',"terribibibi42");
define('COD',"AES-128-ECB");

//Enrutadores
define('DS',DIRECTORY_SEPARATOR);
define('ROOT',realpath(dirname(__FILE__)).DS);
//Infinity free
//define('URL',"http://mirennay.epizy.com/");
//000WebHost
//define('URL',"https://fb-foto-movile.000webhostapp.com/");
//localhost
define('URL',"http://localhost/mirennayv3/");

//Ejecutar funcion automatizada
require_once('ajuste/autoload.php');
require_once('ajuste/enrutador.php');
require_once('ajuste/request.php');

autoload::run();
enrutador::run(new request());
?> 