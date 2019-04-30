<div class="page-wrapper">

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Empresas</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo URL ?>">Inicio</a></li>
                            <li class="breadcrumb-item" aria-current="page"><a href="<?php echo URL ?>adminEmpresa">Empresas</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Editar</li>
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
                    <form class="form-horizontal" id="formEmpresaEditar">

                        <div class="card-body">
                            <h6 class="card-title">Actualize los datos</h6>
                            <div class="form-group row">
                                <label class="col-sm-3 text-right control-label col-form-label">Nombre</label>
                                <div class="col-sm-9">
                                    <input type="text" required name="empresa" value="<?php echo $value['empresa'] ?>" class="form-control" placeholder="nombre de la empresa">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 text-right control-label col-form-label">Dirección</label>
                                <div class="col-sm-9">
                                    <input type="text" value="<?php echo $value['direccion'] ?>" required name="direccion" class="form-control" placeholder="dirección de la empresa">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 text-right control-label col-form-label">Celular</label>
                                <div class="col-sm-9">
                                    <input type="tel" value="<?php echo $value['celular'] ?>" required name="celular" class="form-control" placeholder="Celular de la empresa">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 text-right control-label col-form-label">Correo</label>
                                <div class="col-sm-9">
                                    <input type="text" value="<?php echo $value['correo'] ?>"  name="correo" class="form-control" placeholder="Correo de la empresa">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 text-right control-label col-form-label">Observación</label>
                                <div class="col-sm-9">
                                    <textarea required name="observacion" class="form-control"><?php echo $value['observacion'] ?></textarea> 
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 text-right control-label col-form-label">Estado</label>
                                <div class="col-sm-9">
                                    <select required="" class="select form-control" required name="activo" style="width: 100%; height:36px;">
                                        <?php if($value['activo'] == 1){ ?>
                                        <option value="1">Activo</option>
                                        <option value="0">Baja</option>
                                        <?php }else{ ?>
                                        <option value="0">Baja</option>
                                        <option value="1">Activo</option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <!-- inputs ocultos -->
                            <input type="hidden" required="" value="<?php echo openssl_encrypt($idEmpresa, COD, KEY) ?>" name="idEmpresa" class="form-control">
                            
                        </div>
                        <div class="border-top">
                            <div class="card-body">
                                <input type="submit" class="btn btn-primary" value="Modificar">
                                <div id="modificar"></div>
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

        tittlePage("#menuEmpresa","Empresas | Editar");

        $("#formEmpresaEditar").submit(function(e){
            e.preventDefault();
             var datos = $(this).serialize();
             formEmpresaEditar(datos);
        });
        
   });

</script>