<?php 
	//Obtenemos el id del producto para proceder a obtener sus datos
	$idProducto = openssl_decrypt($_GET['idProducto'], COD, KEY);
	//Seteamos el identificador al modelo
	$this->adminAlmacenModelo->set("idProducto"," AND p.id_producto = ".$idProducto);
	//Obtenemos los datos dados del identificador
	$resGeneral = $this->construir();
	foreach($resGeneral as $variableGeneral => $datoGeneral){}
?>
<div class="page-wrapper">

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Producto</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                            <li class="breadcrumb-item" aria-current="page"><a href="<?php echo URL ?>adminAlmacen">Almacen</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Editar</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">

        <div class="card">
            <div class="card-body wizard-content">
                 <div class="row">
                    <div class="col-md-6">
                        <h4 class="card-title">Producto editar</h4>
                    </div>
                    <div class="col-md-6" 
                        style="justify-content: flex-end;
                               display: flex;">
                        <i title="Eliminar este producto" class="fas fa-trash-alt eliminarProducto" 
                           data-idProducto="<?php echo openssl_encrypt($idProducto, COD, KEY)  ?>"
                        ></i>
                    </div>
                </div>
                <h6 class="card-subtitle"></h6>
                <form id="formProductoEditar" action="#" class="m-t-40">
                    
                    <div>
                        <h3>General</h3>
                        <section>
                            <div class="row mb-3">
                                <div class="col-lg-4">
                                    <label>Nombre *</label>
                                    <input name="producto" value="<?php echo $datoGeneral['producto'] ?>" value="$datoGeneral['producto']" required="" type="text" class="form-control" placeholder="Camisa">
                                </div>
                                <div class="col-lg-4">
                                    <label>Precio *</label>
                                    <div class="input-group">
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="basic-addon2">$</span>
                                        </div>
                                        <input type="number" value="<?php echo $datoGeneral['precio'] ?>" required="" name="precio" class="form-control" placeholder="5.000">
                                        <div class="input-group-append">
                                            <span class="input-group-text">MXN</span>
                                        </div>
                                    </div>
                                </div>                                
                            </div>

                             <div class="row mb-3">
                                <div class="col-lg-4">
                                    <label>Proveedor *</label>
                                    <select required="" class="select form-control" name="idProveedor" style="width: 100%; height:36px;">
                                        <option value="<?php echo openssl_encrypt($datoGeneral['id_proveedor'], COD, KEY) ?>"><?php echo $datoGeneral['proveedor'] ?></option>
                                        <?php 
                                        $res = $this->selectProveedor();
                                        foreach ($res as $key) {
                                         ?>
                                         <option value="<?php echo openssl_encrypt($key['id_proveedor'], COD, KEY) ?>"><?php echo $key['proveedor'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="col-lg-4">
                                    <label>Sub categoria *</label>
                                    <select required="" class="select form-control" name="idSubCategoria" style="width: 100%; height:36px;">
                                       <option value="<?php echo openssl_encrypt($datoGeneral['id_sub_categoria'], COD, KEY) ?>"><?php echo $datoGeneral['sub_categoria'] ?></option>
                                        <?php 
                                        $res = $this->selectSubCategoria();
                                        foreach ($res as $key) {
                                         ?>
                                         <option value="<?php echo openssl_encrypt($key['id_sub_categoria'], COD, KEY) ?>"><?php echo $key['sub_categoria'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="col-lg-4">
                                    <label>Genero *</label>
                                    <select required="" class="select form-control" name="idGenero" style="width: 100%; height:36px;">
                                        <option value="<?php echo openssl_encrypt($datoGeneral['id_genero'], COD, KEY) ?>"><?php echo $datoGeneral['genero'] ?></option>
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
                                    <textarea required="" name="descripcion" placeholder="En tres tipos de colores etc." type="text" class="form-control"><?php echo $datoGeneral['descripcion'] ?></textarea>
                                </div>
                                <div class="col-lg-6">
                                    <label>Estado *</label>
                                    <select required="" class="select form-control" name="activo" style="width: 100%; height:36px;">
                                        <?php 
                                        if($datoGeneral['productoActivo'] == 1){
                                        ?>
                                        <option value="1">Activo</option>
                                        <option value="0">Inactivo</option>
                                        <?php
                                        }else{
                                        ?>
                                        <option value="0">Inactivo</option>
                                        <option value="1">Activo</option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-lg-12">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                  <th scope="col">#</th>
                                                  <th scope="col">Imagen</th>
                                                  <th scope="col">Cambiar imagen</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                  <th scope="row">1</th>
                                                  <td>
                                                     <div id="changeImagenPrincipal">
                                                        <img class="col-md-2" src="<?php echo URL ?>libreria/imgProducto/<?php echo $datoGeneral['imagen_principal'] ?>">
                                                     </div>
                                                  </td>
                                                  <td title="Cambiar esta imagen" >
                                                    <label for="imagenPrincipal">
                                                        <i class="fas fa-edit"></i>
                                                        <input class="d-none" id="imagenPrincipal" type="file" name="imagenPrincipal">
                                                        <input required="" id="imagenPrincipalBackup" value="<?php echo $datoGeneral['imagen_principal'] ?>" type="hidden" name="imagenPrincipalBackup">
                                                    </label>
                                                  </td>
                                                </tr>  
                                            </tbody>
                                     </table>
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
                                                <?php echo $datoGeneral['observacionProducto'] ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
							<?php 
							if($datoGeneral['activo_oferta'] == 1){
								$class = "oferta d-block";
								$checked = "checked";
							}else{
								$class = "oferta d-none";
								$checked = "";
							}
							?>
                            <div class="row mb-3">
                                <div class="col-lg-2">
                                    <label>¿Oferta?</label>
                                      <div class="custom-control custom-radio">
                                        <input type="checkbox" <?php echo $checked ?> class="custom-control-input" name="oferta" id="oferta">
                                        <label class="custom-control-label" for="oferta">Oferta
                                         </label>
                                      </div>
                                </div>           
                            </div>

                            <!-- Oferta -->
                            <div class="<?php echo $class ?>">

                                <div class="row mb-3">
                                    <div class="col-lg-3">
                                        <label>Precio oferta</label>
                                        <div class="input-group">
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="basic-addon2">$</span>
                                            </div>
                                            <input type="text" value="<?php echo $datoGeneral['precio_oferta'] ?>" name="precioOferta" class="form-control" placeholder="5.000">
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="basic-addon2">MXN</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <label>Titulo *</label>
                                        <input name="titulo" value="<?php echo $datoGeneral['titulo'] ?>" type="text" class="form-control">
                                     </div>
                                     <div class="col-lg-3">
                                        <label>Sub titulo *</label>
                                        <input name="subTitulo" value="<?php echo $datoGeneral['sub_titulo'] ?>" type="text" class="form-control">
                                     </div>   
                                    <div class="col-lg-3">
                                        <label>Fecha limite *</label>
                                        <input name="fechaFinOferta" value="<?php echo date('Y-m-d', strtotime($datoGeneral['fecha_fin_oferta'])) ?>" type="date" class="form-control">
                                    </div> 
                                </div>

                                <?php 
                                if(!empty($datoGeneral['imagen_oferta'])){
                                    $classImagenOferta = "d-block";
                                    $classFileOferta = "d-none";
                                }else{
                                   $classImagenOferta = "d-none";
                                   $classFileOferta = "d-block";
                                }
                                ?>
                                
                                <div class="row mb-3">
                                    <div class="col-lg-9">
                                        <label class="col-md-9" for="imagenOferta">Imagen oferta
                                            <div class="col-md-9">
                                                <div class="custom-file">
                                                    <input type="file" id="imagenOferta" name="imagenOferta" class="form-control <?php echo $classFileOferta ?>">
                                                    <img title="Editar" class="col-md-4 <?php echo $classImagenOferta ?>" src="<?php echo URL ?>libreria/imgProductoOferta/<?php echo $datoGeneral['imagen_oferta'] ?>" alt="user" />
                                                    <input type="hidden" name="imagenOfertaBackup"  value="<?php echo $datoGeneral['imagen_oferta'] ?>" class="form-control">
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                </div>

                            </div>
                            <!-- /Oferta -->

                        </section>
                        <h3>Detalle</h3>
                        <section>

                        	<?php
                        	$this->adminAlmacenModelo->set("idProducto"," AND pd.id_producto = ".$idProducto);
                        	$resDetalle = $this->mostrarDetalle(); 
                            $rowDetalle = $resDetalle->rowCount();
                            $inicioCantidad = 0;
                            $posicionImagenDetalle = array();
                        	foreach ($resDetalle as $keyDetalle) {
                            $inicioCantidad++;
                            $posicionImagenDetalle = [];
                        	?>

                            <div class="card">
                                <div class="card-body wizard-content">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h4 class="card-title">Color <?php echo $inicioCantidad ?></h4>
                                        </div>
                                        <div class="col-md-6" 
                                            style="justify-content: flex-end;
                                                   display: flex;">
                                            <i title="Eliminar este detalle" class="fas fa-trash-alt eliminarProductoDetalle" 
                                               data-idProductoDetalle="<?php echo openssl_encrypt($keyDetalle['id_producto_detalle'], COD, KEY)  ?>"
                                            ></i>
                                        </div>
                                    </div>
                                    
                                    <h6 class="card-subtitle"></h6>

                                    <div class="row mb-3">
                                        <div class="col-lg-3">
                                            <label>Talla <?php echo $inicioCantidad ?> *</label>
                                            <select required="" class="select form-control" name="idTalla<?php echo $inicioCantidad ?>" style="width: 100%; height:36px;">
                                                <option value="<?php echo openssl_encrypt($keyDetalle['id_talla'], COD, KEY) ?>"><?php echo $keyDetalle['talla'] ?></option>
                                                <?php 
                                                $res = $this->selectTalla();
                                                foreach ($res as $key) {
                                                 ?>
                                                 <option value="<?php echo openssl_encrypt($key['id_talla'], COD, KEY) ?>"><?php echo $key['talla'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
                                            <label>Color <?php echo $inicioCantidad ?>*</label>
                                            <input required="" value="<?php echo $keyDetalle['color'] ?>" placeholder="Verde con un poco de azul" name="color<?php echo $inicioCantidad ?>" type="text" class="form-control">
                                        </div>
                                        
                                        <div class="col-lg-3">
                                            <label>Codigo <?php echo $inicioCantidad ?>*</label>
                                            <input required="" value="<?php echo $keyDetalle['codigo'] ?>" placeholder="Codigo de barra" name="codigo<?php echo $inicioCantidad ?>" type="text" class="form-control">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-lg-3">
                                            <label>Cantidad <?php echo $inicioCantidad ?>*</label>
                                            <input required=""  value="<?php echo $keyDetalle['cantidad'] ?>" placeholder="Cuantos productos son de este color" name="cantidad<?php echo $inicioCantidad ?>" type="number" class="form-control">
                                        </div>
                                        <div class="col-lg-3">
                                            <label>Cantidad alerta <?php echo $inicioCantidad ?>*</label>
                                            <input required=""  value="<?php echo $keyDetalle['cantidad_alerta'] ?>" placeholder="Cantidad minima de producto" name="cantidadAlerta<?php echo $inicioCantidad ?>" type="number" class="form-control">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                      <th scope="col">#</th>
                                                      <th scope="col">Imagen</th>
                                                      <th scope="col">Eliminar imagen</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                    for ($i=1; $i<=6; $i++) { 
                                                        if(!empty($keyDetalle['imagen'.$i])){
                                                    ?>
                                                    <tr>
                                                      <th scope="row"><?php echo $i ?></th>
                                                      <td><img class="col-md-2" src="<?php echo URL ?>libreria/imgProducto/<?php echo $keyDetalle['imagen'.$i] ?>"></td>
                                                      <td title="Eliminar esta imagen" >
                                                        <i class="fas fa-trash eliminarImagen" 
                                                            data-idProductoDetalle="<?php echo openssl_encrypt($keyDetalle['id_producto_detalle'], COD, KEY) ?>"
                                                            data-atributo="imagen<?php echo $i ?>"
                                                        ></i>
                                                      </td>
                                                    </tr>  
                                                <?php
                                                    }else{
                                                        array_push($posicionImagenDetalle, $i);
                                                    }
                                                }
                                                ?>
                                                </tbody>
                                         </table>
                                        </div>
                                        <div class="row mb-3">
                                            <?php 
                                            for ($i=0; $i < count($posicionImagenDetalle); $i++) { 
                                            ?>
                                             <div class="col-lg-4">
                                                <label class="col-md-4">Imagen <?php echo $posicionImagenDetalle[$i] ?> *</label>
                                                <div class="col-md-12">
                                                    <div class="custom-file">
                                                        <input  type="file" name="imagen<?php echo $posicionImagenDetalle[$i].$inicioCantidad ?>" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" value="<?php echo openssl_encrypt($keyDetalle['id_producto_detalle'], COD, KEY) ?>" name="idProductoDetalle<?php echo $inicioCantidad ?>">
                            <?php
                        	}
                        	?>

                            <div class="row mb-3">
                                <div class="col-lg-12">
                                    <label title="Especifica cuantos tipos de producto hay de este mismo, ejemplo: 3 camisas iguales pero cada una de diferente color, entonces la cantidad de detalle seria 3">¿Agregar mas detalles? *</label>
                                   <select class="select form-control" name="cantidadColor" style="width: 100%; height:36px;">
                                       <option value="0">Ninguno</option>
                                        <?php 
                                        $limiteMasDetalle = (6 - $rowDetalle);
                                        for ($i=1; $i<=$limiteMasDetalle; $i++) {
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
                    <input type="hidden" name="idProducto" id="idProducto" value="<?php echo openssl_encrypt($idProducto, COD, KEY) ?>">
                    <input type="hidden" name="rowDetalle" value="<?php echo $rowDetalle ?>">
                </form>
            </div>
        </div>

    </div>

</div>

<script>
// Basic Example with form

$(document).ready(function(){
    
    tittlePage("#menuProducto","Almacen | Editar");

    var form = $("#formProductoEditar");

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
            var datos = new FormData(document.getElementById('formProductoEditar'));
            var observacion = quill.root.innerHTML;
            var idProducto = $("#idProducto").val();
            var rowDetalle = $("input[name='rowDetalle']").val();
            datos.append('observacion', observacion);
            datos.append('idProducto', idProducto);
            datos.append('rowDetalle' , rowDetalle);
            productoEditar(datos);
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
        var cantidadColor = parseInt($(this).val());
        var inicioCantidad = parseInt("<?php echo $inicioCantidad; ?>");
        cantidadColor = (cantidadColor + inicioCantidad);
        inicioCantidad++;
        cantidadColor1(inicioCantidad,cantidadColor);
    });

    $("#imagenPrincipal").change(function () {
        var id = "#changeImagenPrincipal";
        filePreview(this,id);
    });

    $(".eliminarProducto").click(function(e){
        e.preventDefault();
        if(confirm("¿Estás seguro que quieres eliminar este producto?")){
            var idProducto = $(this).attr("data-idProducto");
            var activo = 0;
            productoActivo(idProducto,activo);
        }
    });

    $(".eliminarProductoDetalle").click(function(e){
        e.preventDefault();
        if(confirm("¿Estás seguro que quieres eliminar este detalle?")){
            $(this).parent().parent().parent().addClass("d-none");
            var idProductoDetalle = $(this).attr("data-idProductoDetalle");
            eliminarProductoDetalle(idProductoDetalle);
        }
    });

    $(".eliminarImagen").click(function(e){
        e.preventDefault();
        if(confirm("¿Estás seguro que quieres eliminar esta imagen?")){
             $(this).parent().parent().addClass("d-none");
            var idProductoDetalle = $(this).attr("data-idProductoDetalle");
            var atributo = $(this).attr("data-atributo");
            eliminarImagen(idProductoDetalle,atributo);
        }
    });

    var quill = new Quill('#editor', {
        theme: 'snow'
    });
});



 
</script>