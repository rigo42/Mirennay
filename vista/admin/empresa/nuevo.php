<div class="page-wrapper">

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Empresas</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo URL ?>">Inicio</a></li>
                            <li class="breadcrumb-item" aria-current="page"><a href="<?php echo URL ?>empresa">Empresas</a></li>
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
                    <form class="form-horizontal" id="formEmpresaNuevo">

                        <div class="card-body">
                            <h6 class="card-title">Agrege los datos</h6>
                            <div class="form-group row">
                                <label class="col-sm-3 text-right control-label col-form-label">Nombre</label>
                                <div class="col-sm-9">
                                    <input type="text" required name="empresa" class="form-control" placeholder="nombre de la empresa">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 text-right control-label col-form-label">Dirección</label>
                                <div class="col-sm-9">
                                    <input type="text" required name="direccion" class="form-control" placeholder="dirección de la empresa">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 text-right control-label col-form-label">Celular</label>
                                <div class="col-sm-9">
                                    <input type="tel" required name="celular" class="form-control" placeholder="Celular de la empresa">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 text-right control-label col-form-label">Correo</label>
                                <div class="col-sm-9">
                                    <input type="text" name="correo" class="form-control" placeholder="Correo de la empresa">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 text-right control-label col-form-label">Observación</label>
                                <div class="col-sm-9">
                                    <textarea required name="observacion" class="form-control"></textarea> 
                                </div>
                            </div>
                            
                        </div>
                        <div class="border-top">
                            <div class="card-body">
                                <input type="submit" class="btn btn-primary" value="Agregar">
                                <div id="agregar"></div>
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

        tittlePage("#menuEmpresa","Empresas | Nuevo");

        $("#formEmpresaNuevo").submit(function(e){
            e.preventDefault();
             var datos = $(this).serialize();
             formEmpresaNuevo(datos);
        });
        
   });

</script>