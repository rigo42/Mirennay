<div class="page-wrapper">

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Sub categorias</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo URL ?>">Inicio</a></li>
                            <li class="breadcrumb-item" aria-current="page"><a href="<?php echo URL ?>adminSubCategoria">Sub categorias</a></li>
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
                            <h6 class="card-title">Datos de la sub categoria <?php echo $value['sub_categoria'] ?></h6>
                            <div class="form-group row">
                                <label class="col-sm-3 text-right control-label col-form-label">Sub categoria</label>
                                <div class="col-sm-9">
                                    <input type="text" required name="subCategoria" value="<?php echo $value['sub_categoria'] ?>" class="form-control" placeholder="Nombre de la sub categoria">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 text-right control-label col-form-label">Categoria</label>
                                <div class="col-sm-9">
                                    <select required="" class="select form-control" name="idCategoria" style="width: 100%; height:36px;">
                                        <option value="<?php echo openssl_encrypt($value['id_categoria'], COD, KEY) ?>"><?php echo $value['categoria'] ?></option>
                                        <?php 
                                        $res = $this->selectCategoria();
                                        foreach ($res as $key) {
                                         ?>
                                         <option value="<?php echo openssl_encrypt($key['id_categoria'], COD, KEY) ?>"><?php echo $key['categoria'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                             <div class="form-group row">
                                <label class="col-sm-3 text-right control-label col-form-label">Estado</label>
                                <div class="col-sm-9">
                                    <select required="" class="select form-control" required name="activo" style="width: 100%; height:36px;">
                                        <?php if($value['subCategoriaActivo'] == 1){ ?>
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
                            <input type="hidden" name="idSubCategoria" value="<?php echo openssl_encrypt($idSubCategoria, COD, KEY) ?>">       
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

        tittlePage("#menuSubCategoria","Sub categorias | Editar");

        $("#editar").submit(function(e){
            e.preventDefault();
             var datos = $(this).serialize();
             formSubCategoriaServlet(datos);
        });
        
   });

</script>