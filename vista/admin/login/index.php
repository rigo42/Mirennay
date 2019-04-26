<div class="auth-wrapper d-flex no-block justify-content-center align-items-center bg-dark">
    <div class="auth-box bg-dark border-top border-secondary">

        <div id="loginform">
            <div class="text-center p-t-20 p-b-20">
                <span class="db"><img src="<?php echo URL ?>libreria/img/logoM.png" alt="logo" /></span>
            </div>
            <!-- Form -->
            <form class="form-horizontal m-t-20" id="iniciarSesion" >
                <div class="row p-b-30">
                    <div class="col-12">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-success text-white"><i class="ti-user"></i></span>
                            </div>
                            <input type="text" name="empleado" class="form-control form-control-lg" placeholder="Usuario" required="">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-warning text-white"><i class="ti-pencil"></i></span>
                            </div>
                            <input type="password" name="password" class="form-control form-control-lg" placeholder="Password" required="">
                        </div>
                    </div>
                </div>

                <p class="text-danger" id="mensajeAdminLogin"></p>

                <div class="row border-top border-secondary">
                    <div class="col-12">
                        <div class="form-group">
                            <div class="p-t-20">
                                <button class="btn btn-info" id="to-recover" type="button"><i class="fa fa-lock m-r-5"></i> Recuperar password</button>
                                <button class="btn btn-success float-right" type="submit">Login</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div id="recoverform">
            <div class="text-center">
                <span class="text-white">Ingrese su dirección de correo electrónico a continuación y le enviaremos instrucciones sobre cómo recuperar una contraseña.</span>
            </div>
            <div class="row m-t-20">
                <!-- Form -->
                <form class="col-12" id="recuperarPassword">
                    <!-- email -->
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-danger text-white" id="basic-addon1"><i class="ti-email"></i></span>
                        </div>
                        <input type="email" name="correo" required class="form-control form-control-lg" placeholder="Correo electronico" aria-label="Username">
                    </div>
                    <!-- pwd -->
                    <div class="row m-t-20 p-t-20 border-top border-secondary">
                        <div class="col-12">
                            <a class="btn btn-success" href="#" id="to-login" name="action">Regresar al login</a>
                            <button class="btn btn-info float-right" type="submit">Enviar a correo</button>
                        </div>
                    </div>
                    <p id="mensajeRecuperarPassword"></p>
                </form>
            </div>
        </div>

    </div>
</div>

<script>
    
    $(document).ready(function(){

        tittlePage("","Login");

        $('[data-toggle="tooltip"]').tooltip();
        $(".preloader").fadeOut();
        // ============================================================== 
        // Login and Recover Password 
        // ============================================================== 
        $('#to-recover').on("click", function() {
            $("#loginform").slideUp();
            $("#recoverform").fadeIn();
        });
        $('#to-login').click(function(){
            
            $("#recoverform").hide();
            $("#loginform").fadeIn();
        });

        $("#iniciarSesion").submit(function(e){
            e.preventDefault();
            var datos = $(this).serialize();
            iniciarSesion(datos);
        });

        $("#recuperarPassword").submit(function(e){
            e.preventDefault();
            var datos = $(this).serialize();
            activarCodigoVerificacion(datos);
        });

    });
    
</script>
