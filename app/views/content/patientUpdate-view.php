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
    
        $consultaMedicos = new mainModel();
        $consultaMedicos = $consultaMedicos->ejecutarConsultaLibre("SELECT m.id idMedico, concat(p.nombre,' ',p.apellido,' -- (',e.descripcion,')') Nombre
                                                                    FROM medicos m
                                                                    JOIN personas p
                                                                    ON p.id = m.id_personas
                                                                    JOIN especialidades e
                                                                    ON e.id = m.id_especialidades
                                                                    ORDER BY e.descripcion ASC");
        $consultaMedicos = $consultaMedicos->fetchAll(PDO::FETCH_OBJ);

        //Recuperamos el id de usuario que enviamos
        //El ARRAY llamado URL es creado en el INDEX del sistema
        //En el ARRAY llamado URL viene: [0] = nombre de la vista, [1] = id que enviamos
		$idUsuario=$insLogin->limpiarCadena($url[1]);


            $datos=$insLogin->ejecutarConsultaLibre("SELECT pa.id idPacientes, p.id idPersonas, u.id idUsuarios, c.id idContactos, td.id idTipoDocumentacion,
                                                           dir.id idDirecciones, d.id idDocumentaciones, pro.id idProvincia, pame.id_medicos idMedico,
                                                          p.nombre Nombre, p.apellido Apellido, d.numero nroDocumentacion, pro.nombre Provincia, p.cuil Cuil, p.numero_seg_social numSegSocial,
                                                          u.nombre_usuario Usuario, c.correo Correo, c.telefono Telefono, dir.calle Calle, dir.barrio Barrio,
                                                          pa.fecha_creacion FechaCreacion, pa.ultima_modificacion UltimaModificacion
                                                    FROM pacientes pa
                                                    JOIN personas p
                                                    ON p.id = pa.id_personas
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
                                                    JOIN usuarios u
                                                    ON p.id = u.id_personas
                                                    JOIN pacientes_medicos pame
                                                    ON pa.id = pame.id_pacientes
                                                    JOIN medicos m
                                                    ON m.id = pame.id_medicos
                                                    JOIN especialidades e
                                                    ON e.id = pame.id_especialidades
                                                    WHERE u.id = '$idUsuario'");
            if($datos->rowCount()==1){
                $datos = $datos->fetch();

                $idMedico = $datos['idMedico'];
                $datos_medico = $insLogin->ejecutarConsultaLibre("SELECT m.id idMedico, concat(p.nombre,' ',p.apellido) Nombre, e.descripcion Especialidad
                                                                  FROM medicos m
                                                                  JOIN especialidades e
                                                                  ON e.id = m.id_especialidades
                                                                  JOIN personas p
                                                                  ON p.id = m.id_personas
                                                                  WHERE m.id = '$idMedico'");
                $datos_medico = $datos_medico->fetch();

    ?>
                <!-- Parte Superior del Contenido -->
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0">Actualizar Paciente</h1>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                                    <li class="breadcrumb-item active">Actualizar Paciente</li>
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
                                        <h3 class="card-title"><?php echo $datos['Nombre']." ".$datos['Apellido']." ( Medico Asignado: ".$datos_medico['Nombre']." -- Especialidad: ".$datos_medico['Especialidad']." )"; ?></h3>
                                    </div>
                                    <h5><p class="text-center pb-6"><?php echo "<strong>Creado el: </strong> ".date("d-m-Y  h:i:s A",strtotime($datos['FechaCreacion'])).
                                            " &nbsp; <strong>Ultima actualización :</strong> ".date("d-m-Y  h:i:s A",strtotime($datos['UltimaModificacion'])); ?></p></h5>
                                    

                                    <form action="<?php echo APP_URL; ?>app/ajax/patientAjax.php" method="post" autocomplete="off" class="FormularioAjax">
                                        <input type="hidden" name="modulo_paciente" value="actualizar">
                                        <input type="hidden" name="paciente_id" value="<?php echo $datos['idPacientes']; ?>">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                    <label>Nombre</label>
                                                        <input type="text" class="form-control form-control-border border-width-2" name="pacienteNombre"
                                                        pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" value="<?php echo $datos['Nombre']; ?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Apellido</label>
                                                        <input type="text" class="form-control form-control-border border-width-2" name="pacienteApellido"
                                                        pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" value="<?php echo $datos['Apellido']; ?>" required>
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
                                                                <option value="<?php echo $dato->id ?>" <?php echo ($datos['idTipoDocumentacion'] == $dato->id) ? 'selected' : ''; ?> class="form-control"><?php echo $dato->descripcion ?></option>
                                                                <?php
                                                                } 
                                                                ?>
                                                            </select>
                                                            <input type="text" class="form-control form-control-border border-width-2" name="pacienteDocumentacionNumero"
                                                            pattern="[a-zA-Z0-9]{8,40}" value="<?php echo $datos['nroDocumentacion']; ?>" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="row">
                                                        <div class="form-group mr-2">
                                                            <label>CUIL</label>
                                                            <input type="text" class="form-control form-control-border border-width-2"
                                                            pattern="[0-9]{11,20}" name="pacienteCuil" value="<?php echo $datos['Cuil']; ?>" required>
                                                        </div>
                                                        <div class="form-group ml-2">
                                                            <label>Número Seguro Social</label>
                                                            <input type="text" class="form-control form-control-border border-width-2"
                                                            pattern="[0-9]{7,100}" name="pacienteNumeroSegSocial" value="<?php echo $datos['numSegSocial']; ?>" required>
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
                                                        <input type="text" class="form-control form-control-border border-width-2" name="pacienteUsuario"
                                                         pattern="[a-zA-Z0-9]{4,10}" value="<?php echo $datos['Usuario']; ?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="row">
                                                        <div class="form-group mr-2">
                                                            <label for="cuil">Clave</label>
                                                            <input type="text" class="form-control form-control-border border-width-2"
                                                            pattern="[a-zA-Z0-9$@.-]{4,100}"  name="pacienteClave1">
                                                        </div>
                                                        <div class="form-group ml-2">
                                                            <label for="cuil">Confirmar Clave</label>
                                                            <input type="text" class="form-control form-control-border border-width-2"
                                                            pattern="[a-zA-Z0-9$@.-]{4,100}" name="pacienteClave2">
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
                                                        <input type="text" class="form-control form-control-border border-width-2" name="pacienteCorreo"
                                                         value="<?php echo $datos['Correo']; ?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                    <label>Telefono</label>
                                                        <input type="text" class="form-control form-control-border border-width-2" name="pacienteTelefono"
                                                        pattern="[0-9]{10,20}" value="<?php echo $datos['Telefono']; ?>" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>
                                            <div class="row m-3"><h4>Información de Domicilio</h4></div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                    <label>Calle</label>
                                                        <input type="text" class="form-control form-control-border border-width-2" name="pacienteCalle"
                                                        pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9 ]{1,100}" value="<?php echo $datos['Calle']; ?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="row">
                                                        <div class="form-group mr-2">
                                                            <label for="cuil">Barrio</label>
                                                            <input type="text" class="form-control form-control-border border-width-2"
                                                            pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9 ]{1,100}" value="<?php echo $datos['Barrio']; ?>" name="pacienteBarrio">
                                                        </div>
                                                        <div class="form-group ml-2">
                                                            <label for="provincia">Provincias</label>
                                                            <select class="form-control btn-info dropdown-toggle" id="category" name="pacienteProvincia" required="">
                                                                    <option value="0" class="form-control" type="button" data-bs-toggle="dropdown" aria-expanded="false">Seleccionar...</option>
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
                                            <div class="row m-3"><h4>Seleccione a su Médico</h4></div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <select class="form-control btn-info dropdown-toggle" id="pacienteMedico" name="pacienteMedico" required="">
                                                                <option value="0" class="form-control" type="button" data-bs-toggle="dropdown" aria-expanded="false">Seleccionar...</option>
                                                                <?php
                                                                        foreach($consultaMedicos as $dato){
                                                                    ?>
                                                                <option value="<?php echo $dato->idMedico ?>" <?php echo ($datos_medico['idMedico'] == $dato->idMedico) ? 'selected' : ''; ?> class="form-control"><?php echo $dato->Nombre ?></option>
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
                                            <button type="submit" class="btn btn-info float-right">Actualizar</button>
                                            <button class="btn btn-secondary float-left btn-back"><?php include "./app/views/inc/btn_back.php"; ?></button>
                                        </div>
                                    </form>
    <?php
            }else{
                include "./app/views/inc/error_alert.php";
            }  
        
    ?>