//Inifinity free
var URL = "http://mirennay.epizy.com/"; 

//000WebHost
//var URL = "https://fb-foto-movile.000webhostapp.com/"; 

//MiPropia
//var URL = "http://mirennay.mipropia.com/"; 

//localhost

//var URL = "http://localhost/mirennayv3/"; 


$(document).ready(function(){

	//Load page
    $("#loader").fadeOut(); 

	productoVentanaFavorito();

	productoVentanaCarrito();
    

	// Mobile Nav toggle
	$('.menu-toggle > a').on('click', function (e) {
		e.preventDefault();
		$('#responsive-nav').toggleClass('active');
	});

	// Fix cart dropdown from closing
	$('.cart-dropdown').on('click', function (e) {
		e.stopPropagation();
	});

	// Products Slick
	$('.products-slick').each(function() {
		var $this = $(this),
				$nav = $this.attr('data-nav');

		$this.slick({
			slidesToShow: 4,
			slidesToScroll: 1,
			autoplay: true,
			infinite: true,
			speed: 300,
			dots: false,
			arrows: true,
			appendArrows: $nav ? $nav : false,
			responsive: [{
	        breakpoint: 991,
	        settings: {
	          slidesToShow: 2,
	          slidesToScroll: 1,
	        }
	      },
	      {
	        breakpoint: 480,
	        settings: {
	          slidesToShow: 1,
	          slidesToScroll: 1,
	        }
	      },
	    ]
		});
	});
	

	// Products Widget Slick
	$('.products-widget-slick').each(function() {
		var $this = $(this),
				$nav = $this.attr('data-nav');

		$this.slick({
			infinite: true,
			autoplay: true,
			speed: 300,
			dots: false,
			arrows: true,
			appendArrows: $nav ? $nav : false,
		});
	});

	
	// Product Main img Slick
	$('#product-main-img').slick({
	    infinite: true,
	    speed: 300,
	    dots: false,
	    arrows: true,
	    fade: true,
	    asNavFor: '#product-imgs',
	});

	// Product imgs Slick
 	 $('#product-imgs').slick({
	    slidesToShow: 3, 
	    slidesToScroll: 1,
	    arrows: true,
	    centerMode: true,
	    focusOnSelect: true,
			centerPadding: 0,
			vertical: true,
	    asNavFor: '#product-main-img',
			responsive: [{
	        breakpoint: 991,
	        settings: {
						vertical: false,
						arrows: false,
						dots: true,
	        }
	      },
	    ]
	  });

	// Product img zoom
	var zoomMainProduct = document.getElementById('product-main-img');
	if (zoomMainProduct) {
		$('#product-main-img .product-preview').zoom();
	}

	//Script automatico al iniciar la pagina el cual obtendra el tipo de color y ropa que se muestra primero para 
	//mostrar cuantos productos hay de este mismo color y talla
	var idProductoDetalle = $("select[name='idProductoDetalle']").val();
	selectCantidadProducto(idProductoDetalle);

	/*
	Script para escuchar cuando el cliente cambie de seleccion del tipo de COLOR Y TALLA 
	Y se le enviara a una funcion para que esta me traiga la cantidad de ropa total que se tiene de esta mismo color y talla
	*/
	$("select[name='idProductoDetalle']").change(function(){
		var idProductoDetalle = $(this).val();
		selectCantidadProducto(idProductoDetalle);
		$(".add-to-cart-btn span").html("Añadir");
	});

	//Si llegase hacer un cambio a la cantidad del producto el cliente, le digo al boton que otra ves se ponga como Añadir al carrito
	$("select[name='idProductoDetalleCantidad']").change(function(){
		$(".add-to-cart-btn span").html("Añadir");
	});

	//Para añadir al carrito
	$(".add-to-cart-btn").click(function(e){
		e.preventDefault();
		var idProducto = $(this).attr("data-idProducto");
		var idProductoDetalle = $("select[name='idProductoDetalle']").val();
		var idProductoDetalleCantidad = $("select[name='idProductoDetalleCantidad']").val();
		var producto = $(this).attr("data-producto");
		var precio = $(this).attr("data-precio");
		var imagenPrincipal = $(this).attr("data-productoImagenPrincipal");
		var talla = $('option:selected',"select[name='idProductoDetalle']").attr("data-talla");
		var color = $('option:selected',"select[name='idProductoDetalle']").attr("data-color");
		$(this).children("span").html("Añadido");
		addProductoCarrito(idProducto,idProductoDetalle,idProductoDetalleCantidad,producto,precio,imagenPrincipal,talla,color);
	});

	//Para añadir o quitar de favorito (solo para la pantalla de inicio)
	$(".addWishlist").click(function(e){
		e.preventDefault();
		if($(this).children("i").hasClass("fa fa-heart")){
			$(this).children("i").removeClass("fa fa-heart");
			$(this).children("i").addClass("fa fa-heart-o");
		}else{
			$(this).children("i").removeClass("fa fa-heart-o");
			$(this).children("i").addClass("fa fa-heart");
		}
		var idProducto = $(this).attr("data-idProducto");
		productoFavorito(idProducto);
	});

});

	//SIRVE: Para setearle un titulo a la pagina
	//PORQUE: Por que el usaurio identificara en que pagina esta si lee el tittle
	function tittlePage(id,titulo){
		$(id).addClass("active");
		$("#titulo").html(titulo);
	}

	//SIRVE: Para resaltar una notificacion
	//PORQUE: El usuario debe darse cuenta que esta pasando
	function notificacion(tipo,mensaje){
	    if(tipo == "success"){
	        toastr.success(mensaje);
	    }if(tipo == "info"){
	        toastr.info(mensaje);
	    }if(tipo == "warning"){
	        toastr.warning(mensaje);
	    }if(tipo == "error"){
	        toastr.error(mensaje);
	    }
	}


	//Paginador de productos
	function paginadorProducto(search,idCategoria,precioMin,precioMax,idGenero,idSubCategoria,cantidadPagina,paginaNumero){
		$.ajax({
	        type: "POST",
	        url: URL+"tienda/tiendaPaginadorEnlistar1",
	        data: {
	        	search:search,
	        	idCategoria:idCategoria,
	        	precioMax:precioMax,
	        	precioMin:precioMin,
	        	idGenero:idGenero,
	        	idSubCategoria:idSubCategoria,
	        	paginaNumero:paginaNumero,
	        	cantidadPagina:cantidadPagina
	        },
	        cache: false,
			beforeSend: function() {
				$('#tienda').html('<img src="'+URL+'libreria/img/espere.gif" alt="reload" width="20" height="20">');
	        },
	        success: function(data) {
	    		$("#tienda").html(data);
	        }
		});
	}


	//SIRVE: Para añadir o quitar de favorito
	//PORQUE: Para administrar los favoritos del usuario
	function productoFavorito(idProducto){
		$.ajax({
	        type: "POST",
	        url: URL+"productoFavorito/productoFavorito",
	        data: {
	        	idProducto:idProducto
	        },
	        cache: false,
			beforeSend: function() {
	        },
	        success: function(data) {
	        	if(data != 1){
	        		productoVentanaFavorito(); //Esta funcion me actualiza mi ventana de favoritos
	        	}else{
	        		location = URL+"login?actividad=favorito&idProducto="+idProducto;
	        	}
	        }
		});
	}

	//SIRVE: Para mostrar en la ventana favorito todos sus favoritos
	//PORQUE: Para que el usuario pueda ver cuales son su productos favoritos mas facimente en una ventana
	function productoVentanaFavorito(){
		$.ajax({
	        type: "POST",
	        url: URL+"productoFavorito/productoVentanaFavorito",
	        data: {
	        },
	        cache: false,
			beforeSend: function() {
				//$("#productoVentanaFavorito").html("<img src='<?php echo URL ?>libreria/img/espere.gif'>");
	        },
	        success: function(data) {
	    		$("#productoVentanaFavorito").html(data);
	        }
		});
	}

	//SIRVE: Para mostrar en la ventana carrito todos sus productos guardados en la variable de sesion
	//PORQUE: Para que el usuario pueda ver cuales son su productos en carrito mas facimente en una ventana
	function productoVentanaCarrito(){
		$.ajax({
	        type: "POST",
	        url: URL+"productoCarrito/productoVentanacarrito",
	        data: {
	        },
	        cache: false,
			beforeSend: function() {
				//$("#productoVentanaCarrito").html("<img src='<?php echo URL ?>libreria/img/espere.gif'>");
	        },
	        success: function(data) {
	    		$("#productoVentanaCarrito").html(data);
	        }
		});
	}

	//SIRVE: Para añadir del carrito
	//PORQUE: Para administrar los productos del carrito del usuario
	 function addProductoCarrito(idProducto,idProductoDetalle,idProductoDetalleCantidad,producto,precio,imagenPrincipal,talla,color){
		$.ajax({
	        type: "POST",
	        url: URL+"productoCarrito/addProductoCarrito",
	        data: {
	        	idProducto:idProducto,
	        	idProductoDetalle:idProductoDetalle,
	        	idProductoDetalleCantidad:idProductoDetalleCantidad,
	        	producto:producto,
	        	precio:precio,
	        	imagenPrincipal:imagenPrincipal,
	        	talla:talla,
	        	color:color
	        },
	        cache: false,
			beforeSend: function() {
	        },
	        success: function(data) {
	        	if(data != 1){
	        		productoVentanaCarrito();
	        	}else{
	        		location = URL+"login?actividad=carrito&idProducto="+idProducto+
	        		"&idProductoDetalle="+idProductoDetalle+
	        		"&idProductoDetalleCantidad="+idProductoDetalleCantidad+
	        		"&producto="+producto+
	        		"&precio="+precio+
	        		"&imagenPrincipal="+imagenPrincipal+
	        		"&talla="+talla+
	        		"&color="+color;
	        	}
	        }
	    });
	}

	//SIRVE: Para eliminar del carrito
	//PORQUE: Para administrar los productos del carrito del usuario
	 function deleteProductoCarrito(idProductoDetalle){
		$.ajax({
	        type: "POST",
	        url: URL+"productoCarrito/deleteProductoCarrito",
	        data: {
	        	idProductoDetalle:idProductoDetalle
	        },
	        cache: false,
			beforeSend: function() {
	        },
	        success: function(data) {
	    		productoVentanaCarrito();
	        }
	    });
	}

	//Actualizar la cantidad del producto dependiendo de la talla y el color que eligieron
	function selectCantidadProducto(idProductoDetalle){
		$.post(URL+'productoDetalle/selectIdProductoDetalleCantidad',{
			idProductoDetalle:idProductoDetalle
		},function(data){
			$("select[name='idProductoDetalleCantidad']").html(data);
		});
	}

	//SIRVE: Actualiza la ventana de comentarios del producto
	//PORQUE: Es necesario actualizar de manera dinamica automatizada
	function ventanaEncuestaComentario(idProducto,cantidadPagina, paginaNumero) {
	    $.ajax({
	        type: "POST", 
	        url: URL+"productoEstrella/ventanaEncuestaComentario",
	        data: {
	        	idProducto:idProducto,
	        	paginaNumero:paginaNumero,
	        	cantidadPagina:cantidadPagina
	        },
	        cache: false,
			beforeSend: function() {
	            $('#ventanaEncuestaComentario').html('<img src="'+URL+'libreria/img/espere.gif" alt="reload" width="20" height="20">');
	        },
	        success: function(data) {
	            $("#ventanaEncuestaComentario").html(data);
	        }
	    });
	}

	//SIRVE: Actualiza la ventana de la encuesta de estrellas del producto
	//PORQUE: Es necesario actualizar de manera dinamica automatizada
	function ventanaEncuestaEstrella(idProducto) {
	    $.ajax({
	        type: "POST",
	        url: URL+"productoEstrella/ventanaEncuestaEstrella",
	        data: {
	        	idProducto:idProducto
	        },
	        cache: false,
			beforeSend: function() {
	            $('#ventanaEncuestaEstrella').html('<img src="'+URL+'libreria/img/espere.gif" alt="reload" width="20" height="20">');
	        },
	        success: function(html) {
	            $("#ventanaEncuestaEstrella").html(html);
	        }
	    });
	}

	//SIRVE: Actualiza la ventana de la encuesta del formulario del producto
	//PORQUE: Es necesario actualizar de manera dinamica automatizada
	function ventanaEncuestaFormulario(idProducto){
	    $.ajax({
	        type: "POST",
	        url: URL+"productoEstrella/ventanaEncuestaFormulario",
	        data: {
	        	idProducto:idProducto
	        },
	        cache: false,
			beforeSend: function() {
	            $('#ventanaEncuestaFormulario').html('<img src="'+URL+'libreria/img/espere.gif" alt="reload" width="20" height="20">');
	        },
	        success: function(data) {
	            $("#ventanaEncuestaFormulario").html(data);
	        }
	    });
	}

	//SIRVE: Publicar un comentario deacuerdo al producto de detalle que este viendo
	//PORQUE: Es bueno ver comentarios buenos en un producto
	function publicarComentario(idProducto,comentario,cantidadEstrella){
		 $.ajax({
	        type: "POST",
	        url: URL+"productoEstrella/insertarEncuestaFormulario",
	        data: {
	        	idProducto:idProducto,
	        	comentario:comentario,
	        	cantidadEstrella:cantidadEstrella
	        },
	        cache: false,
			beforeSend: function() {
	            $('#publicarComentario').html('<img src="'+URL+'libreria/img/espere.gif" alt="reload" width="20" height="20">');
	        },
	        success: function(data){
        		ventanaEncuestaEstrella(idProducto);
				ventanaEncuestaComentario(idProducto,3,1);
            	ventanaEncuestaFormulario(idProducto);
	        }
	    });
	}

	//SIRVE: Para solamente ver los municipios del estado seleccionado
	//PORQUE: No se deben mostrar estados y municipios revueltos
	function municipio(idEstado){
		$("select[name='idMunicipio']").html("Espere...");
		$.post(URL+'pedido/municipio',{
			idEstado:idEstado
		},function(data){
			$("select[name='idMunicipio']").html(data);
		});
	}

	//SIRVE: Validar los datos de direccion que todos los campos esten bien
	//PORQUE: Es  importante y necesario que todo salga bien
	function validarFormPedido(direccion,metodo){
		$.ajax({
	        type: "POST",
	        url: URL+"pedido/validarFormPedido",
	        data: direccion,
	        cache: false,
			beforeSend: function() {
	            //$('#ventanaEncuestaEstrella').html('<img src="'+URL+'libreria/img/espere.gif" alt="reload" width="20" height="20">');
	        },
	        success: function(data) {
	          	if(data == "1"){
	          		if(metodo == "paypal"){
	          			pagoPaypal();
	          		}
	          	}else{
	          		alert("Rellene correctamente los campos de dirección");
	          	}	
	        }
	    });
	}

	//SIRVE: Es la api de paypal
	//PORQUE: No se puede pagar sin ello
	function pagoPaypal(){
		$("#validarFormPedido").html("");
		var subTotalNeto = $("#subTotalNeto").val();

		paypal.Button.render({
        
        // Set your environment

        env: 'sandbox', // sandbox | production

        // Specify the style of the button

        style: {
            label: 'checkout',  // checkout | credit | pay | buynow | generic
            size:  'responsive', // small | medium | large | responsive
            shape: 'pill',   // pill | rect
            color: 'blue'   // gold | blue | silver | black
        },

        // PayPal Client IDs - replace with your own
        // Create a PayPal app: https://developer.paypal.com/developer/applications/create

        client: {
            sandbox:    'AcMFerZoQD2g-P6ovLZLk7botreJCWy-TlixjF3V45Zyu5-csRsbp0Ns_yuYRTlsAOh5NaDGp2ZExbGZ',
            production: 'AT4o3ZwgN-C9HSvQTylyJKI7tGGuPQFITrj34pLJWQwObT-6c57Y3KZd47QQ1iHZfrYGGK5uYqhfIoNt'
        },

        // Wait for the PayPal button to be clicked

        payment: function(data, actions) {
            return actions.payment.create({
                payment: {
                    transactions: [
                        {
                            amount: { total: subTotalNeto, currency: 'MXN' },
                            description: "Compra de productos a Mirennay "+subTotalNeto+" MXN",
                            custom: "<?php echo 1 ?>#"
                        }
                    ]
                }
            });
        },

        // Wait for the payment to be authorized by the customer

        onAuthorize: function(data, actions) {
            return actions.payment.execute().then(function() {
            	if($("#shiping-address").prop("checked")){
					direccion = $("#formPedidoDiferente").serialize();
					direccion += "&actividad=direccionNueva";
				}else{
					var actividad = $("#formPedido").attr("data-actividad");
					direccion = $("#formPedido").serialize();
					direccion += "&actividad="+actividad;
				}
				direccion += "&paymentID="+data.paymentID;
				pedido(direccion); 
            });
        },
    
    	}, '#validarFormPedido');

	}

	//SIRVE: Insertar el pedido cuando se complete con exito la tranferencia bancaria
	//PORQUE: Se debe de registrar el pedido de a donde se enviaran los productos y cual y cuantos
	function pedido(direccion){
		$.ajax({
	        type: "POST",
	        url: URL+"pedido/pedido",
	        data: direccion,
	        cache: false,
			beforeSend: function() {
	        },
	        success: function(data) {
	    		if(data != ""){
	    			notificacion("error",data);
	    		}else{
	    			location=URL+"inicio";
	    		}
	        }
		});
	}

	function iniciarSesion(datos){
		$.ajax({
            type: "POST",
            url: URL+"login/iniciarSesion",
            data: datos,
            cache: false,
    		beforeSend: function() {
                $('#mensajeLogin').html('<img src="'+URL+'libreria/img/espere.gif" alt="reload" width="20" height="20">');
            },
            success: function(data) {
            	var idProducto = $("input[name='idProductoUrlEncode']").val();
            	if(data == 1){
            		location=URL+"productoDetalle?idProducto="+idProducto;
            	}else if(data == 2){
            		location=URL+"productoDetalle?idProducto="+idProducto;
            	}else if(data == 3){
            		 location=URL+"inicio";
            	}else if(data == 4){
            		$('#mensajeLogin').html('');
            		notificacion("error","Usuario o contraseña es incorrecto");
            	}else{
            		$('#mensajeLogin').html('');
            		notificacion("error","ERROR: "+data);
            	}
            }
   	    });
	}

	function usuarioNuevo(datos){
		$.ajax({
            type: "POST",
            url: URL+"login/usuarioNuevo",
            data: datos,
            cache: false,
    		beforeSend: function() {
                $('#gif').html('<img src=" '+URL+'libreria/img/espere.gif" alt="reload" width="20" height="20">');
            },
            success: function(data) {
            	if(data == 1){
            		$("#password").css("border-color", "#fff");
        			$("#passwordC").css("border-color", "#fff");
        			$("#usuario").css("border-color", "#fff");
        			$("#correo").css("border-color", "#fff");
        			iniciarSesion(datos);
        		}else if(data == 3){
        			notificacion("warning","El correo electronico no es valido");
        			$('#gif').html('Registrarse');
        			$("#correo").css("border-color", "red");
        			$("#password").css("border-color", "#fff");
        			$("#passwordC").css("border-color", "#fff");
        			$("#usuario").css("border-color", "#fff");
        		}else if(data == 4){
        			notificacion("warning","El usuario ya esta en uso");
        			$('#gif').html('Registrarse');
        			$("#correo").css("border-color", "#fff");
        			$("#password").css("border-color", "#fff");
        			$("#passwordC").css("border-color", "#fff");
        			$("#usuario").css("border-color", "red");
        		}else if(data == 5){
        			notificacion("warning","El correo ya esta en uso");
        			$('#gif').html('Registrarse'); 
        			$("#usuario").css("border-color", "#fff");
        			$("#password").css("border-color", "#fff");
        			$("#passwordC").css("border-color", "#fff");
        			$("#correo").css("border-color", "red");
        		}else{		                
        			$('#gif').html('Registrarse'); 
               		notificacion("error",data);
            	}
            }
   	    });
	}

	function activarCodigoVerificacion(datos){
	    $.ajax({
	        type: "POST",
	        url: URL+"login/activarCodigoVerificacion",
	        data: datos,
	        cache: false,
	        beforeSend: function() {
	            $('#gif').html('<img src="'+URL+'libreria/img/espere.gif" alt="reload" width="20" height="20">');
	        }, 
	        success: function(data){
	            if(data == 1){
	                $('#gif').html('Listo');
	                notificacion("success","Revisa tu correo electronico.");
	            }else if(data == 2){
	                $('#gif').html('Intente otra vez');
	                notificacion("warning","Correo invalido.");
	            }else if(data == 3){
	                $('#gif').html('Intente otra vez');
	                notificacion("warning","Correo no encontrado en el sistema.");
	            }else{
	                $('#gif').html("Intente de nuevo");
	                notificacion("error",data);
	            }
	        }
	    });
	}

	function cambiarPassword(password,correo){
	    $.ajax({
	        type: "POST",
	        url: URL+"login/cambiarPassword",
	        data: {
	            password:password,
	            correo:correo
	        },
	        cache: false,
	        beforeSend: function() {
	            $('#gif').html('<img src="'+URL+'libreria/img/espere.gif" alt="reload" width="20" height="20">');
	        },
	        success: function(data){
	            if(data == 1){
	                $('#gif').html('Listo');
	                notificacion("success","¡Listo! vuelve a iniciar sesión.");
	                location=URL+"login";
	            }else{
	                $('#gif').html('');
	                notificacion("error",data);
	            }
	        }
	    });
	}

	function cerrarSesion(){
		$.ajax({
	        type: "POST",
	        url: URL+"login/cerrarSesion",
	        data: {},
	        cache: false,
	        success: function(data){
	            window.location=URL+"inicio";
	        }
	    });
	}

	