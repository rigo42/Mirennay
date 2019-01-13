<?php include('productoColeccionInclude.php'); ?>

<?php include('productoNuevoInclude.php'); ?>

<?php include('productoPublicidadInclude.php'); ?>

<?php include('productoMasVendidoInclude.php'); ?>

<?php include('productoMasVendidoMinInclude.php'); ?>

<script type="text/javascript">
	// Products Widget Slick
	$('.products-widget-slick').each(function() {
		var $this = $(this),
		$nav = $this.attr('data-nav');

		$this.slick({
			infinite: true,
			autoplay: true,
			speed: 3000,
			dots: false,
			arrows: true,
			appendArrows: $nav ? $nav : false,
		});
	});
	//Products Slick
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
</script>