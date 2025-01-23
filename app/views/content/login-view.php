<div class="login-page" style="min-height: 466px;">
    <div class="login-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="#" class="h1">Clínica Médica</a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Identifíquese</p>

                <form action="" method="post" autocomplete="off">
                    <div class="input-group mb-3">

                        <input type="text" class="form-control" name="login_usuario"
                        pattern="[a-zA-Z0-9]{4,10}" placeholder="Usuario">
                        
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" name="login_clave"
                        pattern="[a-zA-Z0-9$@.-]{4,100}" placeholder="Clave">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember">
                                <label for="remember">
                                    Recuérdame
                                </label>
                            </div>
                        </div>
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Ingresar</button>
                        </div>

                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
    <!-- Script de SweetAlert2 -->
<script src="<?php echo APP_URL;?>app/views/js/sweetalert2.all.min.js"></script>
<?php
    if(isset($_POST['login_usuario']) || isset($_POST['login_clave'])){
        $insLogin->iniciarSesionControlador();
    }


?>