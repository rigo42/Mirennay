<div class="page-wrapper">

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Generos</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo URL ?>">Inicio</a></li>
                            <li class="breadcrumb-item" aria-current="page"><a href="<?php echo URL ?>adminGenero">Generos</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Nuevo</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <form class="form-horizontal" id="nuevo">

                        <div class="card-body">
                            <h6 class="card-title">Nuevo genero</h6>
                            <div class="form-group row">
                                <label class="col-sm-3 text-right control-label col-form-label">Genero</label>
                                <div class="col-sm-9">
                                    <input type="text" required name="genero" class="form-control" placeholder="Nombre del genero">
                                </div>
                            </div>
                            <!-- inputs ocultos -->    
                            <input type="hidden" name="actividad" value="nuevo">                   
                        </div>
                        <div class="border-top">
                            <div class="card-body">
                                <button type="submit" class="btn btn-primary" id="gif">Nuevo</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

<script type="text/javascript">
   $(document).ready(function(){

        tittlePage("#menuGenero","Genero | Nuevo");

        $("#nuevo").submit(function(e){
            e.preventDefault();
            var datos = $(this).serialize();
            formGeneroServlet(datos);
        });
        
   });

</script>