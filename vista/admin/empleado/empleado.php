<div class="row">

    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title m-b-0">Empleados</h4>
            </div>
            <div class="comment-widgets scrollable">
                <?php 
                foreach ($res as $key) { 

                  if(!empty($key['imagen'])){
                    $imagen = $key['imagen'];
                  }else{
                     $imagen = "default.jpg";
                  }

                  if($key['rol'] == "admin"){
                    $texColor = "text-success";
                  }else if($key['rol'] == "gerente"){
                    $texColor = "text-primary";
                  }else if($key['rol'] == "cajero"){
                    $texColor = "text-warning";
                  }else{
                    $texColor = "";
                  }
                ?>
                <!-- Comment Row -->
                <div class="d-flex flex-row comment-row m-t-0" style="cursor: pointer;" onclick="location='<?php echo URL ?>adminEmpleado/editar?idEmpleado=<?php echo urlencode(openssl_encrypt($key['id_empleado'], COD, KEY)) ?> '">
                    <div class="p-2"><img src="<?php echo URL ?>libreria/imgEmpleado/<?php echo $imagen ?>" alt="user" width="50" class="rounded-circle"></div>
                    <div class="comment-text w-100">
                        <h6 class="font-medium <?php echo $texColor ?>"> <?php echo $key['nombre_completo'] ?></h6>
                        <span class="m-b-15 d-block"></span>
                        <div class="comment-footer">
                            <span class="text-muted float-right"><?php echo $key['fecha_alta'] ?></span> 
                        </div>
                    </div>
                </div>
                <!-- // Comment Row -->
                <?php } ?>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title m-b-0">Tasks</h5>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Descripción</th>
                        <th scope="col">Rol</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Permisos completos</td>
                        <td class="text-success">ADMIN</td>
                        <td>
                            <a href="#" data-toggle="tooltip" data-placement="top" title="Actualizar">
                                <i class="mdi mdi-check"></i>
                            </a>
                            <a href="#" data-toggle="tooltip" data-placement="top" title="Eliminar">
                                </i><i class="mdi mdi-close"></i>
                            </a>     
                            <a href="#" data-toggle="tooltip" data-placement="top" title="Nuevo">
                                </i><i class="mdi mdi-plus"></i>
                            </a>  
                             <a href="#" data-toggle="tooltip" data-placement="top" title="Ventas">
                                <i class="mdi mdi-cart"></i>
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>Permisos limitados</td>
                        <td class="text-primary">GERENTE</td>
                        <td>
                            <a href="#" data-toggle="tooltip" data-placement="top" title="Ventas">
                                <i class="mdi mdi-cart"></i>
                            </a>
                            <a href="#" data-toggle="tooltip" data-placement="top" title="Nuevo">
                                </i><i class="mdi mdi-plus"></i>
                            </a>
                            <a href="#" data-toggle="tooltip" data-placement="top" title="Financiero">
                                </i><i class="mdi mdi-cash"></i>
                            </a>
                        </td>  
                    </tr>
                    <tr>
                        <td>Permisos limitados</td>
                        <td class="text-warning">CAJERO</td>
                        <td>
                            <a href="#" data-toggle="tooltip" data-placement="top" title="Ventas">
                                <i class="mdi mdi-cart"></i>
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>


