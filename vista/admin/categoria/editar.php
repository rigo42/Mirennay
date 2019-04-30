<div class="page-wrapper">

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Categorias</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo URL ?>">Inicio</a></li>
                            <li class="breadcrumb-item" aria-current="page"><a href="<?php echo URL ?>adminCategoria">Categorias</a></li>
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
                            <h6 class="card-title">Datos de la categoria <?php echo $value['categoria'] ?></h6>
                            <div class="form-group row">
                                <label class="col-sm-3 text-right control-label col-form-label">Categoria</label>
                                <div class="col-sm-9">
                                    <input type="text" required name="categoria" value="<?php echo $value['categoria'] ?>" class="form-control" placeholder="Nombre de la categoria">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 text-right control-label col-form-label">Imagen</label>
                                <div class="col-sm-9">
                                    <div class="custom-file">
                                        <label for="imagen">
                                            <div id="changeImagen">
                                                <img title="Editar" class="col-md-4" src="<?php echo URL ?>libreria/imgCategoria/<?php echo $value['imagen_principal'] ?>" alt="user" />
                                            </div>
                                        </label>

                                        <input type="file" id="imagen" name="imagen" class="form-control d-none">
                                        <input type="hidden" name="imagenBackup"  value="<?php echo $value['imagen_principal'] ?>" class="form-control">
                                    </div>
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
                            <input type="hidden" name="idCategoria" value="<?php echo openssl_encrypt($idCategoria, COD, KEY) ?>">       
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

        tittlePage("#menuCategoria","Categorias | Editar");

        $("#editar").submit(function(e){
            e.preventDefault();
            var datos = new FormData(document.getElementById('editar'));
            formCategoriaServlet(datos);
        });

        $("#imagen").change(function () {
            var id = "#changeImagen";
            filePreview(this,id);
        });
        
   });

</script>