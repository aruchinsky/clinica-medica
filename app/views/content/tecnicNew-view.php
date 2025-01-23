<?php
    require_once "./autoload.php";
    use app\models\mainModel;

    $consultaDocumentacion = new mainModel();
    $consultaDocumentacion = $consultaDocumentacion->seleccionarDatos("Menu","tipo_documentacion",0,0);
    $consultaDocumentacion = $consultaDocumentacion->fetchAll(PDO::FETCH_OBJ);

    $consultaProvincias = new mainModel();
    $consultaProvincias = $consultaProvincias->seleccionarDatos("Menu","provincias",0,0);
    $consultaProvincias = $consultaProvincias->fetchAll(PDO::FETCH_OBJ);

?>

<!-- Contenido de la Pagina -->
        <div class="content-wrapper" style="min-height: 227px;">

            <!-- Parte Superior del Contenido -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Nuevo Técnico de Salud</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                                <li class="breadcrumb-item active">Nuevo Técnico de Salud</li>
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
                                    <h3 class="card-title">Agregar Técnico de Salud</h3>
                                </div>
                                <form action="<?php echo APP_URL; ?>app/ajax/tecnicAjax.php" method="post" autocomplete="off" class="FormularioAjax"
                                enctype="multipart/form-data">
                                <input type="hidden" name="modulo_tecnico" value="registrar">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                <label for="nombre">Nombre</label>
                                                    <input type="text" class="form-control form-control-border border-width-2"
                                                    pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" name="tecnicoNombre" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="apellido">Apellido</label>
                                                    <input type="text" class="form-control form-control-border border-width-2"
                                                    pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" name="tecnicoApellido" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Documentación</label>
                                                    <div class="input-group mb-3">
                                                        <select class="btn btn-info dropdown-toggle" id="category" name="tecnicoDocumentacionTipo" required="">
                                                            <option value="" class="form-control" type="button" data-bs-toggle="dropdown" aria-expanded="false">Seleccionar...</option>
                                                                <?php
                                                                    foreach($consultaDocumentacion as $dato){
                                                                ?>
                                                            <option value="<?php  ?>" class="form-control"><?php echo $dato->descripcion ?></option>
                                                                <?php
                                                                    } 
                                                                ?>
                                                        </select>
                                                        <input type="text" class="form-control form-control-border border-width-2" name="tecnicoDocumentacionNumero">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="row">
                                                    <div class="form-group mr-2">
                                                        <label>CUIL</label>
                                                        <input type="text" class="form-control form-control-border border-width-2"
                                                        pattern="[0-9]{11,20}" name="tecnicoCuil" required>
                                                    </div>
                                                    <div class="form-group ml-2">
                                                        <label>Número Seguro Social</label>
                                                        <input type="text" class="form-control form-control-border border-width-2"
                                                        pattern="[0-9]{7,100}" name="tecnicoNumeroSegSocial">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
          
                                        <hr>

                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                <label for="cuil">Nombre de Usuario</label>
                                                    <input type="text" class="form-control form-control-border border-width-2"
                                                    pattern="[a-zA-Z0-9]{4,20}" name="tecnicoUsuario">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="row">
                                                    <div class="form-group mr-2">
                                                        <label for="cuil">Clave</label>
                                                        <input type="text" class="form-control form-control-border border-width-2"
                                                        pattern="[a-zA-Z0-9$@.-]{4,100}" name="tecnicoClave1">
                                                    </div>
                                                    <div class="form-group ml-2">
                                                        <label for="cuil">Confirmar Clave</label>
                                                        <input type="text" class="form-control form-control-border border-width-2"
                                                        pattern="[a-zA-Z0-9$@.-]{4,100}" name="tecnicoClave2">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <hr>
                                        <div class="row m-3"><h3>Datos de Contacto</h3></div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                <label for="cuil">Correo</label>
                                                    <input type="text" class="form-control form-control-border border-width-2" name="tecnicoCorreo">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                <label for="cuil">Telefono (Ej: 3704123456)</label>
                                                    <input type="text" class="form-control form-control-border border-width-2"
                                                    pattern="[0-9]{10,10}" name="tecnicoTelefono">
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row m-3"><h3>Datos del Domicilio</h3></div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                <label for="cuil">Calle</label>
                                                    <input type="text" class="form-control form-control-border border-width-2"
                                                    pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9 ]{7,100}" name="tecnicoCalle">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="row">
                                                    <div class="form-group mr-2">
                                                        <label for="cuil">Barrio</label>
                                                        <input type="text" class="form-control form-control-border border-width-2"
                                                        pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9 ]{7,100}" name="tecnicoBarrio">
                                                    </div>
                                                    <div class="form-group ml-2">
                                                        <label for="provincia">Provincias</label>
                                                        <select class="form-control btn-info dropdown-toggle" id="category" name="tecnicoProvincia" required="">
                                                                <option value="0" class="form-control" type="button" data-bs-toggle="dropdown" aria-expanded="false">Seleccionar...</option>
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
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="nombre">Ocupación</label>
                                                    <input type="text" class="form-control form-control-border border-width-2"
                                                    pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{4,40}" name="tecnicoOcupacion" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="foto">Foto de Perfil</label>
                                                    <div class="input-group">
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input" name="tecnicoFoto">
                                                            <label class="custom-file-label" for="foto">Seleccionar Foto</label>
                                                        </div>
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">.jpg / .png (MAX 5MB)</span>
                                                        </div>
                                                    </div>
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
                </div>
            </section>


