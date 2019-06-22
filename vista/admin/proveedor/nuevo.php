<div class="page-wrapper">

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Proveedores</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo URL ?>">Inicio</a></li>
                            <li class="breadcrumb-item" aria-current="page"><a href="<?php echo URL ?>adminProveedor">Proveedores</a></li>
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
                            <h6 class="card-title">Nuevo proveedor</h6>
                            <div class="form-group row">
                                <label class="col-sm-3 text-right control-label col-form-label">
                                        Proveedor *
                                </label>
                                <div class="col-sm-9">
                                    <input type="text" required name="proveedor" class="form-control" placeholder="Nombre del proveedor">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 text-right control-label col-form-label">
                                    Empresa *
                                </label>
                                <select required="" class="select form-control col-sm-9" name="idEmpresa" style="width: 100%; height:36px;">
                                    <option value="">Seleccione una opción</option>
                                    <?php 
                                    $res = $this->selectEmpresa();
                                    foreach ($res as $key) {
                                     ?>
                                     <option value="<?php echo openssl_encrypt($key['id_empresa'], COD, KEY) ?>"><?php echo $key['empresa'] ?></option>
                                    <?php } ?>
                                </select>
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

        tittlePage("#menuProveedor","Proveedores | Nuevo");

        $("#nuevo").submit(function(e){
            e.preventDefault();
            var datos = $(this).serialize();
            formProveedorServlet(datos);
        });
        
   });

</script>