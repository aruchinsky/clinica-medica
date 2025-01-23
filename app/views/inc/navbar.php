        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                <a href="<?php echo APP_URL; ?>dashboard" class="nav-link">Inicio</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                <a href="#" class="nav-link">Contacto</a>
                </li>
            </ul>

            <ul class="navbar-nav ml-auto">

                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                    <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- Navbar -->
        <!-- Dashboard -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Logo Encabezado -->
            <a href="<?php echo APP_URL; ?>dashboard/" class="brand-link">
                <img src="<?php echo APP_URL; ?>app/views/img/logo.png" alt="Bulma" class="brand-image img-circle elevation-3">
                <span class="brand-text font-weight-light">Clinica Médica</span>
            </a>
            <!-- /Logo Encabezado -->

            <div class="sidebar">
                            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                                <div class="info">
                                <a href="#" class="d-block"><?php echo $_SESSION['nombre']; ?></a>
                                <a href="#" class="d-block">( <?php echo $_SESSION['tipoUsuario']; ?> )</a>
                                </div>

                            </div>
                            <div class="form-inline">
                                <div class="input-group" data-widget="sidebar-search">
                                <input class="form-control form-control-sidebar" id="buscar" placeholder="Buscar">
                                <div class="input-group-append">
                                <button class="btn btn-sidebar">
                                <i class="fas fa-search fa-fw"></i>
                                </button>
                                </div>
                                </div>
                            </div>
                            <nav class="mt-2">
                                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                                        <!-- Empleados -->
                                        <li class="nav-item">
                                            <a href="#" class="nav-link">
                                            <i class="nav-icon fa-solid fa-user-tie"></i>
                                                <p>
                                                Empleados
                                                <i class="right fas fa-angle-left"></i>
                                                </p>
                                            </a>
                                            <ul class="nav nav-treeview" style="display: none;">
                                                <!-- Medicos -->
                                                <li class="nav-item">
                                                    <a href="#" class="nav-link">
                                                    <i class="fa-solid fa-suitcase-medical nav-icon"></i>
                                                        <p>
                                                        Médicos
                                                        <i class="right fas fa-angle-left"></i>
                                                        </p>
                                                    </a>
                                                    <ul class="nav nav-treeview">
                                                        <li class="nav-item">
                                                            <a href="<?php echo APP_URL; ?>medicNew/" class="nav-link">
                                                            <i class="fas fa-plus-circle nav-icon"></i>
                                                            <p>Agregar</p>
                                                            </a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a href="<?php echo APP_URL; ?>medicSearch/" class="nav-link">
                                                            <i class="fa fa-search nav-icon"></i>
                                                            <p>Buscar</p>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </li>
                                                <!-- Tecnicos -->
                                                <li class="nav-item">
                                                    <a href="#" class="nav-link">
                                                        <i class="fa-solid fa-user-doctor nav-icon"></i>
                                                        <p>
                                                        Técnicos
                                                        <i class="right fas fa-angle-left"></i>
                                                        </p>
                                                    </a>
                                                    <ul class="nav nav-treeview">
                                                        <li class="nav-item">
                                                            <a href="<?php echo APP_URL; ?>tecnicNew/" class="nav-link">
                                                            <i class="fas fa-plus-circle nav-icon"></i>
                                                            <p>Agregar</p>
                                                            </a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a href="<?php echo APP_URL; ?>tecnicSearch/" class="nav-link">
                                                            <i class="fa fa-search nav-icon"></i>
                                                            <p>Buscar</p>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </li>
                                                <!-- Administrativos -->
                                                <li class="nav-item">
                                                    <a href="#" class="nav-link">
                                                        <i class="fas fa-briefcase nav-icon"></i>
                                                        <p>
                                                        Administrativos
                                                        <i class="right fas fa-angle-left"></i>
                                                        </p>
                                                    </a>
                                                    <ul class="nav nav-treeview">
                                                        <li class="nav-item">
                                                            <a href="<?php echo APP_URL; ?>adminNew/" class="nav-link">
                                                            <i class="fas fa-plus-circle nav-icon"></i>
                                                            <p>Agregar</p>
                                                            </a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a href="<?php echo APP_URL; ?>adminSearch/" class="nav-link">
                                                            <i class="fa fa-search nav-icon"></i>
                                                            <p>Buscar</p>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </li>
                                        <!-- Pacientes -->
                                        <li class="nav-item">
                                            <!-- Encabezado Desplegable -->
                                            <a href="#" class="nav-link">
                                            <i class="nav-icon fa-solid fa-hospital-user"></i>
                                                <p>Pacientes<i class="right fas fa-angle-left"></i></p>
                                            </a>
                                            <!-- /Encabezado Desplegable -->

                                             <!-- Items -->
                                            <ul class="nav nav-treeview">
                                                <li class="nav-item">
                                                    <a href="<?php echo APP_URL; ?>patientNew/" class="nav-link">
                                                    <i class="fa fa-plus-circle nav-icon"></i>
                                                    <p>Agregar</p>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="<?php echo APP_URL; ?>patientSearch/" class="nav-link">
                                                    <i class="fa fa-search nav-icon"></i>
                                                    <p>Buscar</p>
                                                    </a>
                                                </li>
                                            </ul>
                                            <!-- /Items -->
                                        </li>
                                        <!-- Usuarios -->
                                        <li class="nav-item">
                                            <!-- Encabezado Desplegable -->
                                            <a href="#" class="nav-link">
                                                <i class="nav-icon fas fa-solid fa-users"></i>
                                                <p>Usuarios<i class="right fas fa-angle-left"></i></p>
                                            </a>
                                            <!-- /Encabezado Desplegable -->

                                             <!-- Items -->
                                            <ul class="nav nav-treeview">
                                                <li class="nav-item">
                                                    <a href="<?php echo APP_URL; ?>userNew/" class="nav-link">
                                                    <i class="fa fa-plus-circle nav-icon"></i>
                                                    <p>Agregar</p>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="<?php echo APP_URL; ?>userSearch/" class="nav-link">
                                                    <i class="fa fa-search nav-icon"></i>
                                                    <p>Buscar</p>
                                                    </a>
                                                </li>
                                            </ul>
                                            <!-- /Items -->
                                        </li>
                                        <!-- Mi cuenta -->
                                        <li class="nav-item">
                                            <!-- Encabezado Desplegable -->
                                            <a href="#" class="nav-link">
                                                <i>
                                                    <!-- Mi Cuenta -->
                                                    <?php
                                                        if(is_file("./app/views/photos/".$_SESSION['foto'])){
                                                            echo '<img src="'.APP_URL.'app/views/photos/'.$_SESSION['foto'].'" alt="Bulma" width="32" height="32"
                                                                     class="brand-image img-circle elevation-3">';
                                                        }else{

                                                            echo '<img src="'.APP_URL.'app/views/img/avatar5.png" alt="Bulma" width="32" height="32"
                                                                     class="brand-image img-circle elevation-3">';
                                                        }
                                                    ?>
                                                </i>
                                                <p><?php echo $_SESSION['usuario']; ?><i class="right fas fa-angle-left"></i></p>
                                            </a>
                                            <!-- /Encabezado Desplegable -->

                                             <!-- Items -->
                                            <ul class="nav nav-treeview">
                                                <li class="nav-item">
                                                    <a href="<?php echo APP_URL."userUpdate/".$_SESSION['id']."/"; ?>" class="nav-link">
                                                    <i class="fas fa-address-card nav-icon"></i>
                                                    <p>Datos Personales</p>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="<?php echo APP_URL."userPhoto/".$_SESSION['id']."/"; ?>" class="nav-link">
                                                    <i class="fa fa-file-image nav-icon"></i>
                                                    <p>Mi foto</p>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="<?php echo APP_URL; ?>logOut/" id="btn_exit" class="nav-link">
                                                        <i class="fa fa-times nav-icon"></i>
                                                        <p>Cerrar Sesion</p>
                                                    </a>
                                                </li>
                                            </ul>
                                            <!-- /Items -->
                                        </li>
                                    </ul>
                            </nav>
            </div>


        </aside>
        <!-- /Dashboard -->