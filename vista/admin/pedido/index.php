<div class="page-wrapper">

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Pedido</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo URL ?>">Inicio</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Pedidos</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="el-card-item">
            <div class="page-breadcrumb">
                <div class="row form-group">
                    <div class="col-md-5">
                        <div class="input-group">
                            <input type="search" name="search" class="form-control" placeholder="Buscar...">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
    	<div id="tablaDinamica" data-url="pedido/mostrarPedidoGeneral">
        </div>
    </div>

</div>

<div id="modalDireccion"></div>

<script type="text/javascript">
	$(document).ready(function(){

	    tittlePage("#menuPedido","Pedido");
	    tablaDinamica("","pedido/mostrarPedidoGeneral",1);

	    $(".folio").click(function(e){
	    	e.preventDefault();
	    	var folio = $(this).attr("data-folio");
	    	modalDireccion(folio);
	    });


	});
</script>