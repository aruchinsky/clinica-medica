<?php
    require_once "./autoload.php";
    use app\models\mainModel;

    $consultaDocumentacion = new mainModel();
    $consultaDocumentacion = $consultaDocumentacion->seleccionarDatos("Menu","tipo_documentacion",0,0);
    $consultaDocumentacion = $consultaDocumentacion->fetchAll(PDO::FETCH_OBJ);

    $consultaProvincias = new mainModel();
    $consultaProvincias = $consultaProvincias->seleccionarDatos("Menu","provincias",0,0);
    $consultaProvincias = $consultaProvincias->fetchAll(PDO::FETCH_OBJ);

    $consultaMedicos = new mainModel();
    $consultaMedicos = $consultaMedicos->ejecutarConsultaLibre("SELECT m.id idMedico, concat(p.nombre,' ',p.apellido,' -- (',e.descripcion,')') Nombre
                                                                FROM medicos m
                                                                JOIN personas p
                                                                ON p.id = m.id_personas
                                                                JOIN especialidades e
                                                                ON e.id = m.id_especialidades
                                                                ORDER BY e.descripcion ASC");
    $consultaMedicos = $consultaMedicos->fetchAll(PDO::FETCH_OBJ);
?>
<!-- Contenido de la Pagina -->
        <div class="content-wrapper" style="min-height: 227px;">

            <!-- Parte Superior del Contenido -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Nuevo Paciente</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                                <li class="breadcrumb-item active">Nuevo Paciente</li>
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
                                    <h3 class="card-title">Agregar nuevo paciente</h3>
                                </div>
                                <form action="<?php echo APP_URL; ?>app/ajax/patientAjax.php" method="post" autocomplete="off" class=""
                                enctype="multipart/form-data">
                                <input type="hidden" name="modulo_paciente" value="registrar">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                <label for="nombre">Nombre</label>
                                                    <input type="text" class="form-control form-control-border border-width-2"
                                                    pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" name="pacienteNombre" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="apellido">Apellido</label>
                                                    <input type="text" class="form-control form-control-border border-width-2"
                                                    pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" name="pacienteApellido" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Documentación</label>
                                                    <div class="input-group mb-3">
                                                        <select class="btn btn-info dropdown-toggle" id="category" name="pacienteDocumentacionTipo" required="">
                                                            <option value="" class="form-control" type="button" data-bs-toggle="dropdown" aria-expanded="false">Seleccionar...</option>
                                                                <?php
                                                                    foreach($consultaDocumentacion as $dato){
                                                                ?>
                                                            <option value="<?php echo $dato->id ?>" class="form-control"><?php echo $dato->descripcion ?></option>
                                                                <?php
                                                                    } 
                                                                ?>
                                                        </select>
                                                        <input type="text" class="form-control form-control-border border-width-2" name="pacienteDocumentacionNumero">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="row">
                                                    <div class="form-group mr-2">
                                                        <label>CUIL</label>
                                                        <input type="text" class="form-control form-control-border border-width-2"
                                                        pattern="[0-9]{11,20}" name="pacienteCuil" required>
                                                    </div>
                                                    <div class="form-group ml-2">
                                                        <label>Número Seguro Social</label>
                                                        <input type="text" class="form-control form-control-border border-width-2"
                                                        pattern="[0-9]{7,100}" name="pacienteNumeroSegSocial">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
          
                                        <hr>

                                        <hr>
                                        <div class="row m-3"><h4>Información de Usuario</h4></div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                <label>Nombre de Usuario</label>
                                                    <input type="text" class="form-control form-control-border border-width-2" name="pacienteUsuario">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="row">
                                                    <div class="form-group mr-2">
                                                        <label for="cuil">Clave</label>
                                                        <input type="text" class="form-control form-control-border border-width-2"
                                                        pattern="[a-zA-Z0-9$@.-]{4,100}" name="pacienteClave1">
                                                    </div>
                                                    <div class="form-group ml-2">
                                                        <label for="cuil">Confirmar Clave</label>
                                                        <input type="text" class="form-control form-control-border border-width-2"
                                                        pattern="[a-zA-Z0-9$@.-]{4,100}" name="pacienteClave2">
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
                                                            <input type="file" class="custom-file-input" name="pacienteFoto">
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
                                        <div class="row m-3"><h3>Datos de Contacto</h3></div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                <label for="cuil">Correo</label>
                                                    <input type="text" class="form-control form-control-border border-width-2" name="pacienteCorreo">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                <label for="cuil">Telefono (Ej: 3704123456)</label>
                                                    <input type="text" class="form-control form-control-border border-width-2"
                                                    pattern="[0-9]{10,10}" name="pacienteTelefono">
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
                                                    pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9 ]{7,100}" name="pacienteCalle">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="row">
                                                    <div class="form-group mr-2">
                                                        <label for="cuil">Barrio</label>
                                                        <input type="text" class="form-control form-control-border border-width-2"
                                                        pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9 ]{7,100}" name="pacienteBarrio">
                                                    </div>
                                                    <div class="form-group ml-2">
                                                        <label for="provincia">Provincias</label>
                                                        <select class="form-control btn-info dropdown-toggle" id="category" name="pacienteProvincia" required="">
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
                                        <hr>
                                        <div class="row m-3"><h4>Seleccione a su Médico</h4></div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <select class="form-control btn-info dropdown-toggle" id="pacienteMedico" name="pacienteMedico" required="">
                                                            <option value="0" class="form-control" type="button" data-bs-toggle="dropdown" aria-expanded="false">Seleccionar...</option>
                                                            <?php
                                                                    foreach($consultaMedicos as $dato){
                                                                ?>
                                                            <option value="<?php echo $dato->idMedico ?>" class="form-control"><?php echo $dato->Nombre ?></option>
                                                                <?php
                                                                    } 
                                                                ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">

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


