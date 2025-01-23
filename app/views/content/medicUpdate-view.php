<!-- Contenido de la Pagina -->
<div class="content-wrapper" style="min-height: 227px;">
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

        //Recuperamos el id de usuario que enviamos
        //El ARRAY llamado URL es creado en el INDEX del sistema
        //En el ARRAY llamado URL viene: [0] = nombre de la vista, [1] = id que enviamos
		$idUsuario=$insLogin->limpiarCadena($url[1]);


            $datos=$insLogin->ejecutarConsultaLibre("SELECT m.id idMedicos, p.id idPersonas, u.id idUsuarios, c.id idContactos, te.descripcion TipoEmpleado, td.id idTipoDocumentacion,
                                                            dir.id idDirecciones, d.id idDocumentaciones, sr.id idSituacionRevista, e.id idEspecialidades, pro.id idProvincia,
                                                            m.clave_seguridad_social claveSegSocial, m.numero_colegiado numColegiado, sr.descripcion situacionRevista, e.descripcion especialidades,
                                                            p.nombre Nombre, p.apellido Apellido, d.numero nroDocumentacion, pro.nombre Provincia, p.cuil Cuil, p.numero_seg_social numSegSocial,
                                                            u.nombre_usuario Usuario, c.correo Correo, c.telefono Telefono, dir.calle Calle, dir.barrio Barrio,
                                                            m.fecha_creacion FechaCreacion, m.ultima_modificacion UltimaModificacion
                                                    FROM medicos m
                                                    JOIN especialidades e
                                                    ON e.id = m.id_especialidades
                                                    JOIN situacion_revista sr
                                                    ON sr.id = m.id_situacion_revista
                                                    JOIN personas p
                                                    ON p.id = m.id_personas
                                                    JOIN contactos c
                                                    ON c.id = p.id_contactos
                                                    JOIN direcciones dir
                                                    ON dir.id = p.id_direcciones
                                                    JOIN provincias pro
                                                    ON pro.id = dir.id_provincias
                                                    JOIN documentaciones d
                                                    ON p.id = d.id_personas
                                                    JOIN tipo_documentacion td
                                                    ON td.id = d.id_tipo_documentacion
                                                    JOIN tipo_empleados te
                                                    ON te.id = m.id_tipo_empleados
                                                    JOIN usuarios u
                                                    ON p.id = u.id_personas
                                                    WHERE U.id = '$idUsuario'");
            if($datos->rowCount()==1){
                $datos = $datos->fetch();
    ?>
                <!-- Parte Superior del Contenido -->
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0">Administrar Médico</h1>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                                    <li class="breadcrumb-item active">Administrar Médico</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Contenido -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12 col-6">
                                <div class="card card-lightblue">
                                    <div class="card-header">
                                        <h3 class="card-title"><?php echo $datos['Nombre']." ".$datos['Apellido']." ( ".$datos['especialidades']." )"; ?></h3>
                                    </div>
                                    <h5><p class="text-center pb-6"><?php echo "<strong>Creado el: </strong> ".date("d-m-Y  h:i:s A",strtotime($datos['FechaCreacion'])).
                                            " &nbsp; <strong>Ultima actualización :</strong> ".date("d-m-Y  h:i:s A",strtotime($datos['UltimaModificacion'])); ?></p></h5>
                                    

                                    <form action="<?php echo APP_URL; ?>app/ajax/medicAjax.php" method="post" autocomplete="off" class="FormularioAjax">
                                        <input type="hidden" name="modulo_medico" value="actualizar">
                                        <input type="hidden" name="medico_id" value="<?php echo $datos['idMedicos']; ?>">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                    <label>Nombre</label>
                                                        <input type="text" class="form-control form-control-border border-width-2" name="medicoNombre"
                                                        pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,25}" maxlength="25" value="<?php echo $datos['Nombre']; ?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Apellido</label>
                                                        <input type="text" class="form-control form-control-border border-width-2" name="medicoApellido"
                                                        pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,25}" maxlength="25" value="<?php echo $datos['Apellido']; ?>" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Documentación</label>
                                                        <div class="input-group mb-3">
                                                            <select class="btn btn-info dropdown-toggle" id="category" name="medicoDocumentacionTipo" required>
                                                                <option value="" class="form-control" type="button" data-bs-toggle="dropdown" aria-expanded="false">Seleccionar...</option>
                                                                <?php
                                                                foreach($consultaDocumentacion as $dato){
                                                                ?>
                                                                <option value="<?php echo $dato->id ?>" <?php echo ($datos['idTipoDocumentacion'] == $dato->id) ? 'selected' : ''; ?> class="form-control"><?php echo $dato->descripcion ?></option>
                                                                <?php
                                                                } 
                                                                ?>
                                                            </select>
                                                            <input type="text" class="form-control form-control-border border-width-2" name="medicoDocumentacionNumero"
                                                            pattern="[a-zA-Z0-9]{8,15}" maxlength="15" value="<?php echo $datos['nroDocumentacion']; ?>" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="row">
                                                        <div class="form-group mr-2">
                                                            <label>CUIL</label>
                                                            <input type="text" class="form-control form-control-border border-width-2"
                                                            pattern="[0-9]{11,20}" maxlength="20" name="medicoCuil" value="<?php echo $datos['Cuil']; ?>" required>
                                                        </div>
                                                        <div class="form-group ml-2">
                                                            <label>Número Seguro Social</label>
                                                            <input type="text" class="form-control form-control-border border-width-2"
                                                            pattern="[0-9]{7,10}" maxlength="10" name="medicoNumeroSegSocial" value="<?php echo $datos['numSegSocial']; ?>" required>
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
                                                         pattern="[a-zA-Z0-9]{4,10}" maxlength="10" value="<?php echo $datos['Usuario']; ?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="row">
                                                        <div class="form-group mr-2">
                                                            <label for="cuil">Clave</label>
                                                            <input type="text" class="form-control form-control-border border-width-2"
                                                            pattern="[a-zA-Z0-9$@.-]{4,100}"  name="medicoClave1">
                                                        </div>
                                                        <div class="form-group ml-2">
                                                            <label for="cuil">Confirmar Clave</label>
                                                            <input type="text" class="form-control form-control-border border-width-2"
                                                            pattern="[a-zA-Z0-9$@.-]{4,100}" name="medicoClave2">
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
                                                        <input type="text" class="form-control form-control-border border-width-2" name="medicoCorreo"
                                                         value="<?php echo $datos['Correo']; ?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                    <label>Telefono</label>
                                                        <input type="text" class="form-control form-control-border border-width-2" name="medicoTelefono"
                                                        pattern="[0-9]{10,10}" maxlength="10" value="<?php echo $datos['Telefono']; ?>" required>
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
                                                        pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9 ]{7,20}" maxlength="20" value="<?php echo $datos['Calle']; ?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="row">
                                                        <div class="form-group mr-2">
                                                            <label for="cuil">Barrio</label>
                                                            <input type="text" class="form-control form-control-border border-width-2"
                                                            pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9 ]{7,20}" maxlength="20" value="<?php echo $datos['Barrio']; ?>" name="medicoBarrio" required>
                                                        </div>
                                                        <div class="form-group ml-2">
                                                            <label>Provincias</label>
                                                            <select class="form-control btn-info dropdown-toggle" id="category" name="medicoProvincia" required>
                                                                    <option value="" class="form-control" type="button" data-bs-toggle="dropdown" aria-expanded="false">Seleccionar...</option>
                                                                    <?php
                                                                    foreach($consultaProvincias as $dato){
                                                                    ?>
                                                                    <option value="<?php echo $dato->id ?>" <?php echo ($datos['idProvincia'] == $dato->id) ? 'selected' : ''; ?> class="form-control"><?php echo $dato->nombre ?></option>
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
                                                        pattern="[0-9]{7,20}" maxlength="20" value="<?php echo $datos['claveSegSocial']; ?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                    <label>Número de Colegiado</label>
                                                        <input type="text" class="form-control form-control-border border-width-2" name="medicoNumeroColegiado"
                                                        pattern="[0-9]{9,9}" maxlength="9" value="<?php echo $datos['numColegiado']; ?>" required>
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
                                                                <option value="<?php echo $dato->id ?>" <?php echo ($datos['idEspecialidades'] == $dato->id) ? 'selected' : ''; ?> class="form-control"><?php echo $dato->descripcion ?></option>
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
                                                                <option value="<?php echo $dato->id ?>" <?php echo ($datos['idSituacionRevista'] == $dato->id) ? 'selected' : ''; ?> class="form-control"><?php echo $dato->descripcion ?></option>
                                                                <?php
                                                                } 
                                                                ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer d-flex justify-content-between">
                                            <a href="<?php echo APP_URL; ?>medicSearch/" class="btn btn-secondary">Cancelar</a>                   
                                            <button type="submit" class="btn btn-info mx-auto">Actualizar</button> 
                                    </form>
                                            <a>                                        
                                                <form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/medicAjax.php" method="post" autocomplete="off">
                                                    <input type="hidden" name="modulo_medico" value="eliminar">
                                                    <input type="hidden" name="usuario_id" value="<?php echo $datos['idUsuarios']; ?>">
                                                    <button type="submit" class="btn btn-danger">
                                                        Eliminar
                                                    </button>
                                                </form>
                                            </a>
                                        </div>
    <?php
            }else{
                include "./app/views/inc/error_alert.php";
            }  
        
    ?>