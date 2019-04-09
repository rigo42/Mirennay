<div class="page-wrapper">

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Producto</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                            <li class="breadcrumb-item" aria-current="page"><a href="<?php echo URL ?>almacen">Almacen</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Nuevo</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">

        <div class="card">
            <div class="card-body wizard-content">
                <h4 class="card-title">Producto nuevo</h4>
                <h6 class="card-subtitle"></h6>
                <form id="formProductoNuevo" action="#" class="m-t-40">
                    <div>
                        <h3>General</h3>
                        <section>
                            <div class="row mb-3">
                                <div class="col-lg-9">
                                    <label>Nombre *</label>
                                    <input name="producto" required="" type="text" class="form-control" placeholder="Camisa">
                                </div>
                                <div class="col-lg-3">
                                    <label>Precio *</label>
                                    <div class="input-group">
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="basic-addon2">$</span>
                                        </div>
                                        <input type="number" required="" name="precio" class="form-control" placeholder="5.000">
                                        <div class="input-group-append">
                                            <span class="input-group-text">MXN</span>
                                        </div>
                                    </div>
                                </div>                                  
                            </div>

                             <div class="row mb-3">
                                <div class="col-lg-4">
                                    <label for="userName">Proveedor *</label>
                                    <select required="" class="select form-control" name="idProveedor" style="width: 100%; height:36px;">
                                        <option value="">Seleccione una opción</option>
                                        <?php 
                                        $res = $this->selectProveedor();
                                        foreach ($res as $key) {
                                         ?>
                                         <option value="<?php echo openssl_encrypt($key['id_proveedor'], COD, KEY) ?>"><?php echo $key['proveedor'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="col-lg-4">
                                    <label for="userName">Sub categoria *</label>
                                    <select required="" class="select form-control" name="idSubCategoria" style="width: 100%; height:36px;">
                                       <option value="">Seleccione una opción</option>
                                        <?php 
                                        $res = $this->selectSubCategoria();
                                        foreach ($res as $key) {
                                         ?>
                                         <option value="<?php echo openssl_encrypt($key['id_sub_categoria'], COD, KEY) ?>"><?php echo $key['sub_categoria'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="col-lg-4">
                                    <label for="userName">Genero *</label>
                                    <select required="" class="select form-control" name="idGenero" style="width: 100%; height:36px;">
                                        <option value="">Seleccione una opción</option>
                                        <?php 
                                        $res = $this->selectGenero();
                                        foreach ($res as $key) {
                                         ?>
                                         <option value="<?php echo openssl_encrypt($key['id_genero'], COD, KEY) ?>"><?php echo $key['genero'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-lg-6">
                                    <label>Descripción *</label>
                                    <textarea required="" name="descripcion" placeholder="En tres tipos de colores etc." type="text" class="form-control"></textarea>
                                </div>   
                                <div class="col-lg-6">
                                    <label>Imagen principal *</label>
                                    <div class="col-md-9">
                                        <div class="custom-file">
                                            <input required="" type="file" name="imagenPrincipal" class="form-control">
                                        </div>
                                    </div>
                                </div>        
                            </div>

                            <!-- editor -->
                            <div class="row mb-3">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="card-title">Observación</h4>
                                            <!-- Create the editor container -->
                                            <div id="editor" style="height: 300px;">
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-lg-2">
                                    <label>¿Oferta?</label>
                                      <div class="custom-control custom-radio">
                                        <input type="checkbox" class="custom-control-input" name="oferta" id="oferta">
                                        <label class="custom-control-label" for="oferta">Oferta
                                         </label>
                                      </div>
                                </div>           
                            </div>

                            <!-- Oferta -->
                            <div class="oferta d-none">

                                <div class="row mb-3">
                                    <div class="col-lg-3">
                                        <label>Precio oferta</label>
                                        <div class="input-group">
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="basic-addon2">$</span>
                                            </div>
                                            <input type="text" name="precioOferta" class="form-control" placeholder="5.000">
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="basic-addon2">MXN</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <label>Titulo *</label>
                                        <input name="titulo" type="text" class="form-control">
                                     </div>
                                     <div class="col-lg-3">
                                        <label>Sub titulo *</label>
                                        <input name="subTitulo" type="text" class="form-control">
                                     </div>   
                                    <div class="col-lg-3">
                                        <label>Fecha limite *</label>
                                        <input name="fechaFinOferta" type="date" class="form-control">
                                    </div> 
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-lg-9">
                                        <label class="col-md-3">Imagen oferta</label>
                                        <div class="col-md-9">
                                            <div class="custom-file">
                                                <input type="file" name="imagenOferta" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-- /Oferta -->

                        </section>
                        <h3>Detalle</h3>
                        <section>
                            <div class="row mb-3">
                                <div class="col-lg-12">
                                    <label title="Especifica cuantos tipos de producto hay de este mismo, ejemplo: 3 camisas iguales pero cada una de diferente color, entonces la cantidad de detalle seria 3">¿Cuantos colores diferentes? *</label>
                                   <select required="" class="select form-control" name="cantidadColor"style="width: 100%; height:36px;">
                                       <option value="">Seleccione una opción</option>
                                        <?php 
                                        for ($i=1; $i<=6; $i++) {
                                         ?>
                                         <option value="<?php echo $i ?>"><?php echo $i ?></option>
                                        <?php } ?>
                                    </select>
                                </div> 
                            </div>

                            <div id="cantidadColor">
                                
                            </div>

                        </section>
                    </div>
                </form>
            </div>
        </div>

    </div>

</div>

<script>
// Basic Example with form

$(document).ready(function(){
    
    tittlePage("#menuProducto","Almacen | Nuevo");

    var form = $("#formProductoNuevo");

     form.children("div").steps({
        headerTag: "h3",
        bodyTag: "section",
        transitionEffect: "slideLeft",
        onStepChanging: function(event, currentIndex, newIndex) {
            form.validate().settings.ignore = ":disabled,:hidden";
            return form.valid();
        },
        onFinishing: function(event, currentIndex) {
            form.validate().settings.ignore = ":disabled";
            return form.valid();
        },
        onFinished: function(event, currentIndex) {
            var datos = new FormData(document.getElementById('formProductoNuevo'));
            var observacion = quill.root.innerHTML;
            datos.append('observacion', observacion);
            productoNuevo(datos);
        }
    });

    $("#oferta").change(function(e){
        e.preventDefault();
        if($("#oferta").prop("checked")){
             $(".oferta").removeClass("d-none");
             $("input[name='precioOferta']").attr("required","");
             $("input[name='titulo']").attr("required","");
             $("input[name='subTitulo']").attr("required","");
             $("input[name='fechaFinOferta']").attr("required","");
             $("input[name='imagenOferta']").attr("required","");
        }else{
            $(".oferta").addClass("d-none");
            $("input[name='precioOferta']").removeAttr("required");
             $("input[name='titulo']").removeAttr("required");
             $("input[name='subTitulo']").removeAttr("required");
             $("input[name='fechaFinOferta']").removeAttr("required");
             $("input[name='imagenOferta']").removeAttr("required");
        }
    });

    $("select[name='cantidadColor']").change(function(e){
        e.preventDefault();
        var cantidadColor = $(this).val();
        cantidadColor1(1,cantidadColor);
    });
    
    var quill = new Quill('#editor', {
        theme: 'snow'
    });
});

 
</script>