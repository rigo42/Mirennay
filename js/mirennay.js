$(document).ready(function(){

		//Para ver el producto en detalles cuando se le de click a la imagen
		$(".product-img img").click(function(e){
			e.preventDefault();
			var id = $(this).attr("data-id");
			location="productoDetalle.php?id="+id;
		});
		
		//Para ver el producto en detalles cuando se le de click al ojito
		$(".quick-view").click(function(e){
			var id = $(this).attr("data-id");
			location="productoDetalle.php?id="+id;
		});

		//Para añadir a favorito
		$(".add-to-wishlist").click(function(e){
			e.preventDefault();
			var sesion = $(this).attr("data-sesion");
			if(sesion == "si"){
				if($(this).children("i").hasClass("fa fa-heart")){
					$(this).children("i").removeClass("fa fa-heart");
					$(this).children("i").addClass("fa fa-heart-o");
					var activo = 0;
					var actividad = "editar";
					var idProducto = $(this).attr("data-idProducto");
					
					favoritoProducto(activo,idProducto,actividad);
				}else if($(this).children("i").hasClass("fa fa-heart-o")){
					$(this).children("i").removeClass("fa fa-heart-o");
					$(this).children("i").addClass("fa fa-heart");
					var activo = 1;
					var actividad = "nuevo";
					
					var idProducto = $(this).attr("data-idProducto");
					favoritoProducto(activo,idProducto,actividad);
				}
			}else{
				var actividad = "favorito";
				var idProducto = $(this).attr("data-idProducto");
				window.location="login.php?cliente=loginIniciar&idProducto="+idProducto+"&actividad="+actividad+" ";
			}
		});

		//Para añadir al carrito
		$(".add-to-cart-btn").click(function(e){
			e.preventDefault();
			var sesion = $(this).attr("data-sesion");
			if(sesion == "si"){
				var idProducto = $(this).attr("data-idProducto");
				var idProductoDetalle = $("#id_producto_detalle").val();
				var cantidad = $("select[name='cantidad']").val();
				var actividad = "nuevo";
				$(this).children("span").html("Agregado");
				carritoProducto(actividad,idProducto,idProductoDetalle,cantidad);
			}else{
				var actividad = "carrito";
				var idProducto = $(this).attr("data-idProducto");
				var idProductoDetalle = $("#id_producto_detalle").val();
				var cantidad = $("select[name='cantidad']").val();
				window.location="login.php?cliente=loginIniciar&idProducto="+idProducto+"&actividad="+actividad+"&idProductoDetalle= "+idProductoDetalle+"&cantidad="+cantidad+" ";
			}
		});

		//Script para publicar un comentario y validar que el cliente califique este producto, solo si hay una sesión
		$("#publicarComentario").click(function(e){
			e.preventDefault();
				var sesion = $(this).attr("data-sesion");
				if(sesion=="si"){
					var cantidadEstrella = "";
					$(".stars input").each(function(d){
						if(this.checked){
							 cantidadEstrella = $(this).val();
						}
					});
					if(cantidadEstrella == ""){
						$("#comentarioMal").html("Selecciona una calificacion de estrella");
					}else{
						$("#comentarioMal").html("");
						var id_producto = $(this).attr("data-idProducto");
						var comentario = $("textarea[name='comentario']").val();
						var actividad = $("input[name='actividad']").val();
						if(comentario != "" ){
							publicarComentario(id_producto,id_usuario,comentario,cantidadEstrella,actividad);
						}else{
							$("#comentarioMal").html("Completa el comentario");
						}			
					}
				}else{
					alert("Necesitas iniciar sesión");
				}
		});


		// Fix cart dropdown from closing
		$('.cart-dropdown').on('click', function (e) {
			e.stopPropagation();
		});

		// Mobile Nav toggle
		$('.menu-toggle > a').on('click', function (e) {
			e.preventDefault();
			$('#responsive-nav').toggleClass('active');
		});

		//Si el cliente le dan en buscar al input de busqueda, lo busca solo si no esta vacio este campo
		$(".search-btn").click(function(e){
			e.preventDefault();
			var producto = $("input[name='producto']").val();
			if(producto != ""){
				location="producto.php?producto="+producto;
			}
		});

		//Si el cliente le da en cerrar sesion entonces cierra la sesion we :v
		$("#cerrarSesion").click(function(e){
			e.preventDefault();
			$.post('include/cerrarSesionInclude.php',{
			},function(data){
				if(data==1){
					location="index.php";
				}else{
					alert("Hay un problema al tratar de cerrar sesion");
				}
			});
			 
		});

		// Producto Detalle include
		$('#product-main-img').slick({
		infinite: true,
		speed: 300,
		dots: false,
		arrows: true,
		fade: true,
		asNavFor: '#product-imgs',
		});

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

		//Producto nuevo include
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

		//Producto Mas vendido Min
		$('.products-widget-slick').each(function() {
			var $this = $(this),
			$nav = $this.attr('data-nav');

			$this.slick({
				infinite: true,
				autoplay: true,
				speed: 1000,
				dots: false,
				arrows: true,
				appendArrows: $nav ? $nav : false,
			});
		});

		//Script automatico al iniciar la pagina el cual obtendra el tipo de color y ropa que se muestra primero para 
		//mostrar cuanta ropa hay de este mismo color y talla
		var id_producto_detalle = $("select[name='id_producto_detalle']").val();
		selectCantidadProducto(id_producto_detalle);

		//Script para escuchar cuando el cliente cambie de seleccion del tipo de COLOR Y TALLA 
		//Y se le enviara a una funcion para que esta me traiga la cantidad de ropa total que se tiene de esta mismo color y talla
		$("#id_producto_detalle").change(function(){
			var id_producto_detalle = $(this).val();
			$(".add-to-cart-btn span").html("Añadir al carrito");
			selectCantidadProducto(id_producto_detalle);
		});

		//Si llegase hacer un cambio a la cantidad del producto el cliente, le digo al boton que otra ves se ponga como Añadir al carrito
		$("select[name='cantidad']").change(function(){
			$(".add-to-cart-btn span").html("Añadir al carrito");
		});

		//Script para deslizar hasta la parte de abajo donde se ven los comentarios
		$(".review-link").click(function(){
			$(".tab-nav li").removeClass("active");
			$("#activeTab3").addClass("active");
			$('html,body').animate({
		        scrollTop: $("#dezplazar").offset().top
		    }, 500);
		});


		//Para hacer zoom :v
		var zoomMainProduct = document.getElementById('product-main-img');
		if (zoomMainProduct) {
			$('#product-main-img .product-preview').zoom();
		}

		//Ejecutar automaticamente  funciones aqui abajo colocar
		productoVentanaFavorito();
		productoVentanaCarrito();

	});

	//Actualizar la cantidad del producto dependiendo de la talla y el color que eligieron
	function selectCantidadProducto(id_producto_detalle){
		$.post('include/selectCantidadProducto.php',{
			id_producto_detalle:id_producto_detalle
		},function(data){
			$("select[name='cantidad']").html(data);
		});
	}

	//Actualizar la seccion del icono de favorito
	function productoVentanaFavorito(){
		$.post('include/productoVentanaFavorito.php',{
		},function(data){
			$("#productoVentanaFavorito").html(data);
		});
	}

	//Actualizar la seccion del icono de carrito
	function productoVentanaCarrito(){
		$.post('include/productoVentanaCarrito.php',{
		},function(data){
			$("#productoVentanaCarrito").html(data);
		});
	}

	//Actualizar la seccion de encuestas
	function productoEncuesta(id_producto) {
	    $.ajax({
	        type: "POST",
	        url: "include/productoEncuestaInclude.php",
	        data: {
	        	id_producto:id_producto
	        },
	        cache: false,
			beforeSend: function() {
	            $('#loaderEncuesta').html('<img src="gif/espere.gif" alt="reload" width="20" height="20">');
	        },
	        success: function(html) {
	            $("#productoEncuestaInclude").html(html);
	            $('#loaderEncuesta').html(''); 
	        }
	    });
	}

	function paginadorComentario(id_producto,cantidadPagina, paginaNumero) {
		    $.ajax({
		        type: "POST",
		        url: "include/productoComentarioTablaInclude.php",
		        data: {
		        	id_producto:id_producto,
		        	paginaNumero:paginaNumero,
		        	cantidadPagina:cantidadPagina
		        },
		        cache: false,
				beforeSend: function() {
		            $('#loader').html('<img src="gif/espere.gif" alt="reload" width="20" height="20">');
		        },
		        success: function(html) {
		            $("#productoComentarioTablaInclude").html(html);
		            $('#loader').html(''); 
		        }
		    });
		}

	function publicarComentario(id_producto,id_usuario,comentario,cantidadEstrella,actividad){
			 $.ajax({
		        type: "POST",
		        url: "include/servletProductoComentarioInclude.php",
		        data: {
		        	id_producto:id_producto,
		        	id_usuario:id_usuario,
		        	comentario:comentario,
		        	cantidadEstrella:cantidadEstrella,
		        	actividad:actividad
		        },
		        cache: false,
				beforeSend: function() {
		            $('#publicarComentario').html('<img src="gif/espere.gif" alt="reload" width="20" height="20">');
		        },
		        success: function(data){
		        	if(data == 1){
		        		paginador(id_producto,3,1);
		        		productoEncuesta(id_producto);
		            	$('#publicarComentario').html('Publicar comentario'); 
		            	Push.create("Aviso",{
							body: "Comentario agregado con exito",
							timeout: 4000,
							icon: 'img//M.png'
						});
		        	}else{
		        		alert(data);
		        	}
		            
		        }
		    });
		}

	 function favoritoProducto(activo,idProducto,actividad){
    	 $.ajax({
            type: "POST",
            url: "include/servletProductoFavoritoInclude.php",
            data: {
            	activo:activo,
            	idProducto:idProducto,
            	actividad:actividad
            },
            cache: false,
    		beforeSend: function() {
               $('#avoritoSpan').html('<img src="gif/espere.gif" alt="reload" width="20" height="20">');
            },
            success: function(data) {
            	if(data == 1){
            		if(activo == 0){
						$("#favoritoSpan").html("Añadir a favoritos");
            		}else{
						$("#favoritoSpan").html("Quitar de favoritos");
            		}
        			 productoVentanaFavorito();
        		}else{
        			alert(data);
        		}
            }
        });
    }

    function carritoProducto(actividad,idProducto,idProductoDetalle,cantidad){
			 $.ajax({
		        type: "POST",
		        url: "include/servletProductoSesionInclude.php",
		        data: {
		        	idProducto:idProducto,
		        	idProductoDetalle:idProductoDetalle,
		        	cantidad:cantidad,
		        	actividad:actividad
		        },
		        cache: false,
				beforeSend: function() {
		        },
		        success: function(data) {
		    		productoVentanaCarrito();
		        }
		    });
		}
