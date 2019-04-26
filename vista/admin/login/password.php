<div class="auth-wrapper d-flex no-block justify-content-center align-items-center bg-dark">
    <div class="auth-box bg-dark border-top border-secondary">

        <div id="loginform">
            <div class="text-center p-t-20 p-b-20">
                <span class="db"><img src="<?php echo URL ?>libreria/img/logoM.png" alt="logo" /></span>
            </div>
            <!-- Form -->
            <form class="form-horizontal m-t-20" id="cambiarPassword" >
                <div class="row p-b-30">
                    <div class="col-12">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-success text-white"><i class="ti-pencil"></i></span>
                            </div>
                            <input type="password" name="password" class="form-control form-control-lg" placeholder="Nueva contraseña" required="">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-warning text-white"><i class="ti-pencil"></i></span>
                            </div>
                            <input type="password" name="passwordc" class="form-control form-control-lg" placeholder="Confirmar contraseña" required="">
                        </div>
                    </div>
                </div>


                <div class="row border-top border-secondary">
                    <div class="col-12">
                        <div class="form-group">
                            <div class="p-t-20">
                                <button class="btn btn-success float-right" type="submit">Confirmar</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="cargarPassword"></div>
                
                <!-- Inputs ocultos -->
                <input type="hidden" value="<?php echo $value['correo'] ?>" name="correo">
            </form>
        </div>

    </div>
</div>

<script>
    
    $(document).ready(function(){

        tittlePage("","Recuperar contraseña");

        $("#cambiarPassword").submit(function(e){
            e.preventDefault();
            var password = $("input[name='password']").val();
            var passwordc = $("input[name='passwordc']").val();
            if(password != passwordc){
                notificacion("warning","Contraseñas no coinciden.");
            }else{
                var correo = $("input[name='correo']").val();
                cambiarPassword(password,correo);
            }
        });

    });

</script>
