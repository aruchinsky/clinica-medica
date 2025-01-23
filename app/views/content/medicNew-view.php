<?php
    require_once "./autoload.php";
    use app\models\mainModel;

    $consultaDocumentacion = new mainModel();
    $consultaDocumentacion = $consultaDocumentacion->seleccionarDatos("Menu","tipo_documentacion",0,0);
    $consultaDocumentacion = $consultaDocumentacion->fetchAll(PDO::FETCH_OBJ);

    $consultaProvincias = new mainModel();
    $consultaProvincias = $consultaProvincias->seleccionarDatos("Menu","provincias",0,0);
    $consultaProvincias = $consultaProvincias->fetchAll(PDO::FETCH_OBJ);

    $consultaEspecialidades = new mainModel();
    $consultaEspecialidades = $consultaEspecialidades->seleccionarDatos("Menu","especialidades",0,0);
    $consultaEspecialidades = $consultaEspecialidades->fetchAll(PDO::FETCH_OBJ);

    $consultaSituacionRevista = new mainModel();
    $consultaSituacionRevista = $consultaSituacionRevista->seleccionarDatos("Menu","situacion_revista",0,0);
    $consultaSituacionRevista = $consultaSituacionRevista->fetchAll(PDO::FETCH_OBJ);

?>        
        <!-- Contenido de la Pagina -->
        <div class="content-wrapper" style="min-height: 227px;">

            <!-- Parte Superior del Contenido -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Nuevo Médico</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                                <li class="breadcrumb-item active">Nuevo Médico</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Parte superior del Contenido -->

            <!-- Contenido -->
            <section class="content">
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-12 col-6">
                            <div class="card card-lightblue">
                                <div class="card-header">
                                    <h3 class="card-title">Agregar nuevo médico</h3>
                                </div>
                                <form action="<?php echo APP_URL; ?>app/ajax/medicAjax.php" method="post" autocomplete="off" class="FormularioAjax"
                                enctype="multipart/form-data">
                                <input type="hidden" name="modulo_medico" value="registrar">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                <label>Nombre</label>
                                                    <input type="text" class="form-control form-control-border border-width-2" name="medicoNombre"
                                                        pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,25}" maxlength="25" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Apellido</label>
                                                    <input type="text" class="form-control form-control-border border-width-2" name="medicoApellido" 
                                                    pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,25}" maxlength="25" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Documentación</label>
                                                    <div class="input-group mb-3">
                                                        <select class="btn btn-info dropdown-toggle" id="category" name="medicoDocumentacionTipo" required="">
                                                            <option value="" class="form-control" type="button" data-bs-toggle="dropdown" aria-expanded="false">Seleccionar...</option>
                                                            <?php
                                                                    foreach($consultaDocumentacion as $dato){
                                                                ?>
                                                            <option value="<?php echo $dato->id ?>" class="form-control"><?php echo $dato->descripcion ?></option>
                                                                <?php
                                                                    } 
                                                                ?>
                                                        </select>
                                                        <input type="text" class="form-control form-control-border border-width-2" name="medicoDocumentacionNumero"
                                                        pattern="[a-zA-Z0-9]{8,15}" maxlength="15" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                            <div class="row">
                                                    <div class="form-group mr-2">
                                                        <label>CUIL</label>
                                                        <input type="text" class="form-control form-control-border border-width-2"
                                                        pattern="[0-9]{11,20}" name="medicoCuil" maxlength="20" required>
                                                    </div>
                                                    <div class="form-group ml-2">
                                                        <label>Número Seguro Social</label>
                                                        <input type="text" class="form-control form-control-border border-width-2"
                                                        pattern="[0-9]{7,10}" name="medicoNumeroSegSocial" maxlength="10" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
          
                                        <hr>
                                        <div class="row m-3"><h4>Información de Usuario</h4></div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                <label>Nombre de Usuario</label>
                                                    <input type="text" class="form-control form-control-border border-width-2" name="medicoUsuario"
                                                    pattern="[a-zA-Z0-9]{4,10}" maxlength="10" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="row">
                                                    <div class="form-group mr-2">
                                                        <label for="cuil">Clave</label>
                                                        <input type="text" class="form-control form-control-border border-width-2"
                                                        pattern="[a-zA-Z0-9$@.-]{4,100}" name="medicoClave1">
                                                    </div>
                                                    <div class="form-group ml-2">
                                                        <label for="cuil">Confirmar Clave</label>
                                                        <input type="text" class="form-control form-control-border border-width-2"
                                                        pattern="[a-zA-Z0-9$@.-]{4,100}" name="medicoClave2">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Foto de Perfil</label>
                                                    <div class="input-group">
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input" name="medicoFoto">
                                                            <label class="custom-file-label" for="foto">Seleccionar Foto</label>
                                                        </div>
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">.jpg / .png</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <hr>
                                        <div class="row m-3"><h4>Información de Contacto</h4></div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                <label>Correo</label>
                                                    <input type="text" class="form-control form-control-border border-width-2" name="medicoCorreo">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                <label>Telefono (Ej: 3704123456)</label>
                                                    <input type="text" class="form-control form-control-border border-width-2" name="medicoTelefono"
                                                    pattern="[0-9]{10,10}" maxlength="10">
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row m-3"><h4>Información de Domicilio</h4></div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                <label>Calle</label>
                                                    <input type="text" class="form-control form-control-border border-width-2" name="medicoCalle"
                                                    pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9 ]{7,40}" maxlength="40" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="row">
                                                    <div class="form-group mr-2">
                                                        <label for="cuil">Barrio</label>
                                                        <input type="text" class="form-control form-control-border border-width-2"
                                                        pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9 ]{7,20}" name="medicoBarrio" maxlength="20" required>
                                                    </div>
                                                    <div class="form-group ml-2">
                                                        <label>Provincias</label>
                                                        <select class="form-control btn-info dropdown-toggle" id="category" name="medicoProvincia" required>
                                                                <option value="" class="form-control" type="button" data-bs-toggle="dropdown" aria-expanded="false">Seleccionar...</option>
                                                                <?php
                                                                    foreach($consultaProvincias as $dato){
                                                                ?>
                                                            <option value="<?php echo $dato->id ?>" class="form-control"><?php echo $dato->nombre ?></option>
                                                                <?php
                                                                    } 
                                                                ?>           
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row m-3"><h4>Información de Profesión</h4></div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                <label>Clave de Seguridad Social</label>
                                                    <input type="text" class="form-control form-control-border border-width-2" name="medicoClaveSegSocial"
                                                    pattern="[0-9]{7,20}" maxlength="20" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                <label>Número de Colegiado</label>
                                                    <input type="text" class="form-control form-control-border border-width-2" name="medicoNumeroColegiado"
                                                    pattern="[0-9]{9,9}" maxlength="9" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Especialidades</label>
                                                    <select class="form-control btn-info dropdown-toggle" id="category" name="medicoEspecialidades" required>
                                                            <option value="" class="form-control" type="button" data-bs-toggle="dropdown" aria-expanded="false">Seleccionar...</option>
                                                            <?php
                                                                    foreach($consultaEspecialidades as $dato){
                                                                ?>
                                                            <option value="<?php echo $dato->id ?>" class="form-control"><?php echo $dato->descripcion ?></option>
                                                                <?php
                                                                    } 
                                                                ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Situación de Revista</label>
                                                    <select class="form-control btn-info dropdown-toggle" id="category" name="medicoSituacionRevista" required>
                                                            <option value="" class="form-control" type="button" data-bs-toggle="dropdown" aria-expanded="false">Seleccionar...</option>
                                                            <?php
                                                                    foreach($consultaSituacionRevista as $dato){
                                                                ?>
                                                            <option value="<?php echo $dato->id ?>" class="form-control"><?php echo $dato->descripcion ?></option>
                                                                <?php
                                                                    } 
                                                                ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-info float-right">Registrar</button>
                                        <button class="btn btn-secondary float-left btn-back"><?php include "./app/views/inc/btn_back.php"; ?></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>


