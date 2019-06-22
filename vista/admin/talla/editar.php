<div class="page-wrapper">

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Tallas</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo URL ?>">Inicio</a></li>
                            <li class="breadcrumb-item" aria-current="page"><a href="<?php echo URL ?>adminTalla">Tallas</a></li>
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
                    <form class="form-horizontal" id="editar">

                        <div class="card-body">
                            <h6 class="card-title">Datos del talla <?php echo $value['talla'] ?></h6>
                            <div class="form-group row">
                                <label class="col-sm-3 text-right control-label col-form-label">Talla</label>
                                <div class="col-sm-9">
                                    <input type="text" required name="talla" value="<?php echo $value['talla'] ?>" class="form-control" placeholder="Nombre de la talla">
                                </div>
                            </div>
                             <div class="form-group row">
                                <label class="col-sm-3 text-right control-label col-form-label">
                                    Estado
                                </label>
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
                            <input type="hidden" name="idTalla" value="<?php echo openssl_encrypt($idTalla, COD, KEY) ?>">       
                            <input type="hidden" name="actividad" value="editar">                   
                        </div>
                        <div class="border-top">
                            <div class="card-body">
                                <button type="submit" class="btn btn-primary" id="gif">Modificar</button>
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

        tittlePage("#menuTalla","Tallas | Editar");

        $("#editar").submit(function(e){
            e.preventDefault();
            var datos = $(this).serialize();
            formTallaServlet(datos);
        });

   });

</script>