<?php

class request{
    
    private $controlador;
    private $metodo;
    private $argumento;

    function __construct(){
      if(isset($_GET['m'])){

        $ruta = filter_input(INPUT_GET, 'm', FILTER_SANITIZE_URL);
        $ruta = explode("/", $ruta);
        $ruta = array_filter($ruta);

        $this->controlador = (array_shift($ruta));
        
        $this->metodo = (array_shift($ruta));

        if(!$this->metodo){
          $this->metodo = "index";
        }
        $this->argumento = (array_shift($ruta));
      }else{
        $this->controlador = 'inicio';
        $this->metodo = "index";
      }
    }

  
      public function getControlador() {
          return $this->controlador;
      }

      public function getMetodo(){
          return $this->metodo;
      }

      public function getArgumento(){
          return $this->argumento;
      }
}