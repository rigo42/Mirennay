<div class="page-wrapper">

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Empleados</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo URL ?>">Inicio</a></li>
                            <li class="breadcrumb-item" aria-current="page"><a href="<?php echo URL ?>adminEmpleado">Empleados</a></li>
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
                            <h6 class="card-title">Datos del empleado <?php echo $value['empleado'] ?></h6>
                            <div class="form-group row">
                                <label class="col-sm-3 text-right control-label col-form-label">Rol</label>
                                <div class="col-sm-9">
                                    <select required="" class="select form-control" name="idRol" style="width: 100%; height:36px;">
                                        <option value="<?php echo openssl_encrypt($value['id_rol'], COD, KEY) ?>"><?php echo $value['rol'] ?></option>
                                        <?php 
                                        $res = $this->selectRol();
                                        foreach ($res as $key) {
                                         ?>
                                         <option value="<?php echo openssl_encrypt($key['id_rol'], COD, KEY) ?>"><?php echo $key['rol'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 text-right control-label col-form-label">Nombre</label>
                                <div class="col-sm-9">
                                    <input type="text" required name="nombre" value="<?php echo $value['nombre'] ?>" class="form-control" placeholder="nombre del empleado">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 text-right control-label col-form-label">Apellido Paterno</label>
                                <div class="col-sm-9">
                                    <input type="text" required value="<?php echo $value['apellido_paterno'] ?>" name="apellidoPaterno" class="form-control" placeholder="Apellido paterno">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 text-right control-label col-form-label">Apellido Materno</label>
                                <div class="col-sm-9">
                                    <input type="text" required name="apellidoMaterno" value="<?php echo $value['apellido_materno'] ?>" class="form-control" placeholder="Apellido materno">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 text-right control-label col-form-label">NSS</label>
                                <div class="col-sm-9">
                                    <input type="text" required name="nss" value="<?php echo $value['nss'] ?>" class="form-control" placeholder="Numero seguro social">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 text-right control-label col-form-label">Salario</label>
                                <div class="col-sm-9">
                                    <input type="text" required name="salario" value="<?php echo $value['salario'] ?>" class="form-control" placeholder="Salario a la quincena">
                                </div>
                            </div>
                             <div class="form-group row">
                                <label class="col-sm-3 text-right control-label col-form-label">Correo</label>
                                <div class="col-sm-9">
                                    <input type="text" name="correo" value="<?php echo $value['correo'] ?>" class="form-control" placeholder="Ahi se enviara la información de su usuario">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 text-right control-label col-form-label">Celular</label>
                                <div class="col-sm-9">
                                    <input type="tel" required name="celular" value="<?php echo $value['celular'] ?>" class="form-control" placeholder="Celular del empleado">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 text-right control-label col-form-label">Estado</label>
                                <div class="col-sm-9">
                                    <select required="" class="select form-control" required name="activo" style="width: 100%; height:36px;">
                                        <?php if($value['empleadoActivo'] == 1){ ?>
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
                            <input type="hidden" name="idEmpleado" value="<?php echo openssl_encrypt($idEmpleado, COD, KEY) ?>">       
                            <input type="hidden" name="actividad" value="editar">                   
                        </div>
                        <div class="border-top">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                         <input type="submit" class="btn btn-primary" value="Modificar">
                                    </div>
                                      <div class="col-md-6">
                                          <div id="mensajeEmpleado" class="text-danger"></div>
                                    </div>
                                </div>
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

        tittlePage("#menuEmpleado","Empleados | Editar");

        $("#editar").submit(function(e){
            e.preventDefault();
             var datos = $(this).serialize();
             formEmpleadoServlet(datos);
        });
        
   });

</script>