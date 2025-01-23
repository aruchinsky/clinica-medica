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

        //Recuperamos el id de usuario que enviamos
        //El ARRAY llamado URL es creado en el INDEX del sistema
        //En el ARRAY llamado URL viene: [0] = nombre de la vista, [1] = id que enviamos
		$idUsuario=$insLogin->limpiarCadena($url[1]);


            $datos=$insLogin->ejecutarConsultaLibre("SELECT ts.id idTecnicoSalud, p.id idPersonas, u.id idUsuarios, c.id idContactos, te.descripcion TipoEmpleado, td.id idTipoDocumentacion,
                                                        dir.id idDirecciones, d.id idDocumentaciones, pro.id idProvincia, ts.ocupacion Ocupacion,
                                                        p.nombre Nombre, p.apellido Apellido, d.numero nroDocumentacion, pro.nombre Provincia, p.cuil Cuil, p.numero_seg_social numSegSocial,
                                                        u.nombre_usuario Usuario, c.correo Correo, c.telefono Telefono, dir.calle Calle, dir.barrio Barrio,
                                                        ts.fecha_creacion FechaCreacion, ts.ultima_modificacion UltimaModificacion
                                                    FROM tecnico_salud ts
                                                    JOIN personas p
                                                    ON p.id = ts.id_personas
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
                                                    ON te.id = ts.id_tipo_empleados
                                                    JOIN usuarios u
                                                    ON p.id = u.id_personas
                                                    WHERE u.id = '$idUsuario'");
            if($datos->rowCount()==1){
                $datos = $datos->fetch();
    ?>
                <!-- Parte Superior del Contenido -->
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0">Actualizar Técnico de Salud</h1>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                                    <li class="breadcrumb-item active">Actualizar Técnico de Salud</li>
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
                                        <h3 class="card-title"><?php echo $datos['Nombre']." ".$datos['Apellido']." ( ".$datos['Ocupacion']." )"; ?></h3>
                                    </div>
                                    <h5><p class="text-center pb-6"><?php echo "<strong>Creado el: </strong> ".date("d-m-Y  h:i:s A",strtotime($datos['FechaCreacion'])).
                                            " &nbsp; <strong>Ultima actualización :</strong> ".date("d-m-Y  h:i:s A",strtotime($datos['UltimaModificacion'])); ?></p></h5>
                                    

                                    <form action="<?php echo APP_URL; ?>app/ajax/tecnicAjax.php" method="post" autocomplete="off" class="FormularioAjax">
                                        <input type="hidden" name="modulo_tecnico" value="actualizar">
                                        <input type="hidden" name="tecnico_id" value="<?php echo $datos['idTecnicoSalud']; ?>">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                    <label>Nombre</label>
                                                        <input type="text" class="form-control form-control-border border-width-2" name="tecnicoNombre"
                                                        pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" value="<?php echo $datos['Nombre']; ?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Apellido</label>
                                                        <input type="text" class="form-control form-control-border border-width-2" name="tecnicoApellido"
                                                        pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" value="<?php echo $datos['Apellido']; ?>" required>
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
                                                                <option value="<?php echo $dato->id ?>" <?php echo ($datos['idTipoDocumentacion'] == $dato->id) ? 'selected' : ''; ?> class="form-control"><?php echo $dato->descripcion ?></option>
                                                                <?php
                                                                } 
                                                                ?>
                                                            </select>
                                                            <input type="text" class="form-control form-control-border border-width-2" name="tecnicoDocumentacionNumero"
                                                            pattern="[a-zA-Z0-9]{8,40}" value="<?php echo $datos['nroDocumentacion']; ?>" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="row">
                                                        <div class="form-group mr-2">
                                                            <label>CUIL</label>
                                                            <input type="text" class="form-control form-control-border border-width-2"
                                                            pattern="[0-9]{11,20}" name="tecnicoCuil" value="<?php echo $datos['Cuil']; ?>" required>
                                                        </div>
                                                        <div class="form-group ml-2">
                                                            <label>Número Seguro Social</label>
                                                            <input type="text" class="form-control form-control-border border-width-2"
                                                            pattern="[0-9]{7,100}" name="tecnicoNumeroSegSocial" value="<?php echo $datos['numSegSocial']; ?>" required>
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
                                                        <input type="text" class="form-control form-control-border border-width-2" name="tecnicoUsuario"
                                                         pattern="[a-zA-Z0-9]{4,10}" value="<?php echo $datos['Usuario']; ?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="row">
                                                        <div class="form-group mr-2">
                                                            <label for="cuil">Clave</label>
                                                            <input type="text" class="form-control form-control-border border-width-2"
                                                            pattern="[a-zA-Z0-9$@.-]{4,100}"  name="tecnicoClave1">
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
                                            <div class="row m-3"><h4>Información de Contacto</h4></div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                    <label>Correo</label>
                                                        <input type="text" class="form-control form-control-border border-width-2" name="tecnicoCorreo"
                                                         value="<?php echo $datos['Correo']; ?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                    <label>Telefono</label>
                                                        <input type="text" class="form-control form-control-border border-width-2" name="tecnicoTelefono"
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
                                                        <input type="text" class="form-control form-control-border border-width-2" name="tecnicoCalle"
                                                        pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9 ]{1,100}" value="<?php echo $datos['Calle']; ?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="row">
                                                        <div class="form-group mr-2">
                                                            <label for="cuil">Barrio</label>
                                                            <input type="text" class="form-control form-control-border border-width-2"
                                                            pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9 ]{1,100}" value="<?php echo $datos['Barrio']; ?>" name="tecnicoBarrio">
                                                        </div>
                                                        <div class="form-group ml-2">
                                                            <label for="provincia">Provincias</label>
                                                            <select class="form-control btn-info dropdown-toggle" id="category" name="tecnicoProvincia" required="">
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
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                    <label>Ocupación</label>
                                                        <input type="text" class="form-control form-control-border border-width-2" name="tecnicoOcupacion"
                                                        pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{4,20}" value="<?php echo $datos['Ocupacion']; ?>" required>
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