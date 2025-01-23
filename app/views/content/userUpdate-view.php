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

		$id=$insLogin->limpiarCadena($url[1]);

        if($id==$_SESSION['id']){

            $datos=$insLogin->ejecutarConsultaLibre("SELECT u.id idUsuario, p.nombre Nombre, p.apellido Apellido, u.nombre_usuario Usuario,
                                                    u.fecha_creacion FechaCreacion, u.ultima_modificacion UltimaModificacion,
                                                    td.id idTipoDocumentacion, td.descripcion TipoDocumentacion, d.numero DocumentacionNumero,
                                                    p.cuil Cuil, pro.id idProvincia, p.numero_seg_social NumSegSocial, c.correo Correo,
                                                    c.telefono Telefono, dir.calle Calle, dir.barrio Barrio
                                                    FROM usuarios u
                                                    JOIN personas p
                                                    ON p.id = u.id_personas
                                                    JOIN documentaciones d
                                                    ON p.id = d.id_personas
                                                    JOIN contactos c
                                                    ON c.id = p.id_contactos
                                                    JOIN direcciones dir
                                                    ON dir.id = p.id_direcciones
                                                    JOIN provincias pro
                                                    ON pro.id = dir.id_provincias
                                                    JOIN tipo_documentacion td
                                                    ON td.id = d.id_tipo_documentacion
                                                    WHERE u.id = '$id'");

            if($datos->rowCount()==1){
                $datos = $datos->fetch();
    ?>
        <!-- Parte Superior del Contenido -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Mi Cuenta</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                            <li class="breadcrumb-item active">Actualizar Mi Cuenta</li>
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
                            <h3 class="card-title"><?php echo $datos['Nombre']." ".$datos['Apellido']; ?></h3>
                        </div>
                        <h5><p class="text-center pb-6"><?php echo "<strong>Usuario creado:</strong> ".date("d-m-Y  h:i:s A",strtotime($datos['FechaCreacion'])).
                                " &nbsp; <strong>Usuario actualizado:</strong> ".date("d-m-Y  h:i:s A",strtotime($datos['UltimaModificacion'])); ?></p></h5>
                        

                        <form action="<?php echo APP_URL; ?>app/ajax/userAjax.php" method="post" autocomplete="off" class=""
                              enctype="multipart/form-data">
                            <input type="hidden" name="modulo_usuario" value="actualizar">
                            <input type="hidden" name="usuarioId" value="<?php echo $datos['idUsuario']; ?>">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="nombre">Nombre</label>
                                            <input type="text" class="form-control form-control-border border-width-2"
                                                   pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" name="administrativoNombre" value="<?php echo $datos['Nombre']; ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="apellido">Apellido</label>
                                            <input type="text" class="form-control form-control-border border-width-2"
                                                   pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" name="administrativoApellido" value="<?php echo $datos['Apellido']; ?>" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Documentación</label>
                                            <div class="input-group mb-3">
                                                <select class="btn btn-info dropdown-toggle" id="category" name="administrativoDocumentacionTipo" required="">
                                                    <option value="" class="form-control" type="button" data-bs-toggle="dropdown" aria-expanded="false">Seleccionar...</option>
                                                    <?php
                                                    foreach($consultaDocumentacion as $dato){
                                                    ?>
                                                    <option value="<?php echo $dato->id ?>" <?php echo ($datos['idTipoDocumentacion'] == $dato->id) ? 'selected' : ''; ?> class="form-control"><?php echo $dato->descripcion ?></option>
                                                    <?php
                                                    } 
                                                    ?>
                                                </select>
                                                <input type="text" class="form-control form-control-border border-width-2" name="administrativoDocumentacionNumero" value="<?php echo $datos['DocumentacionNumero']; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="row">
                                            <div class="form-group mr-2">
                                                <label>CUIL</label>
                                                <input type="text" class="form-control form-control-border border-width-2"
                                                       pattern="[0-9]{11,20}" name="administrativoCuil" value="<?php echo $datos['Cuil']; ?>" required>
                                            </div>
                                            <div class="form-group ml-2">
                                                <label>Número Seguro Social</label>
                                                <input type="text" class="form-control form-control-border border-width-2"
                                                       pattern="[0-9]{7,100}" name="administrativoNumeroSegSocial" value="<?php echo $datos['NumSegSocial']; ?>">
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
                                                   pattern="[a-zA-Z0-9]{4,20}" name="administrativoUsuario" value="<?php echo $datos['Usuario']; ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="row">
                                            <div class="form-group mr-2">
                                                <label for="cuil">Clave</label>
                                                <input type="password" class="form-control form-control-border border-width-2"
                                                       pattern="[a-zA-Z0-9$@.-]{4,100}" name="administrativoClave1">
                                            </div>
                                            <div class="form-group ml-2">
                                                <label for="cuil">Confirmar Clave</label>
                                                <input type="password" class="form-control form-control-border border-width-2"
                                                       pattern="[a-zA-Z0-9$@.-]{4,100}" name="administrativoClave2">
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
                                            <input type="text" class="form-control form-control-border border-width-2" name="administrativoCorreo" value="<?php echo $datos['Correo']; ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="cuil">Telefono (Ej: 3704123456)</label>
                                            <input type="text" class="form-control form-control-border border-width-2"
                                                   pattern="[0-9]{10,10}" name="administrativoTelefono" value="<?php echo $datos['Telefono']; ?>">
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
                                                   pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9 ]{7,100}" name="administrativoCalle" value="<?php echo $datos['Calle']; ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="row">
                                            <div class="form-group mr-2">
                                                <label for="cuil">Barrio</label>
                                                <input type="text" class="form-control form-control-border border-width-2"
                                                       pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9 ]{7,100}" name="administrativoBarrio" value="<?php echo $datos['Barrio']; ?>">
                                            </div>
                                            <div class="form-group ml-2">
                                                <label for="provincia">Provincias</label>
                                                <select class="form-control btn-info dropdown-toggle" id="category" name="administrativoProvincia" required="">
                                                    <option value="0" class="form-control" type="button" data-bs-toggle="dropdown" aria-expanded="false">Seleccionar...</option>
                                                    <?php
                                                    foreach($consultaProvincias as $dato){
                                                    ?>
                                                    <option value="<?php echo $dato->id ?>" <?php echo ($datos['idProvincia'] == $dato->id) ? 'selected' : ''; ?> class="form-control"><?php echo $dato->nombre?></option>
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

                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="foto">Foto de Perfil</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" name="administrativoFoto">
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
                                <button type="submit" class="btn btn-info float-right">Actualizar</button>
                                <button class="btn btn-secondary float-left btn-back"><?php include "./app/views/inc/btn_back.php"; ?></button>
                            </div>
                        </form>

    <?php
            }else{
                include "./app/views/inc/error_alert.php";
            }        
        
        }else{
            $datos=$insLogin->ejecutarConsultaLibre("SELECT a.id idAdministrativo, u.id idUsuario, p.nombre Nombre, p.apellido Apellido, u.nombre_usuario Usuario,
                                                    a.sector Sector, a.fecha_creacion FechaCreacion, a.ultima_modificacion UltimaModificacion,
                                                    td.id idTipoDocumentacion, td.descripcion TipoDocumentacion, d.numero DocumentacionNumero,
                                                    p.cuil Cuil, pro.id idProvincia, p.numero_seg_social NumSegSocial, c.correo Correo,
                                                    c.telefono Telefono, dir.calle Calle, dir.barrio Barrio, te.descripcion TipoEmpleado
                                                    FROM administrativos a
                                                    JOIN personas p
                                                    ON p.id = a.id_personas
                                                    JOIN usuarios u
                                                    ON p.id = u.id_personas
                                                    JOIN documentaciones d
                                                    ON p.id = d.id_personas
                                                    JOIN contactos c
                                                    ON c.id = p.id_contactos
                                                    JOIN direcciones dir
                                                    ON dir.id = p.id_direcciones
                                                    JOIN provincias pro
                                                    ON pro.id = dir.id_provincias
                                                    JOIN tipo_documentacion td
                                                    ON td.id = d.id_tipo_documentacion
                                                    JOIN tipo_empleados te
                                                    ON te.id = a.id_tipo_empleados
                                                    WHERE a.id = '$id'");
            if($datos->rowCount()==1){
                $datos = $datos->fetch();
    ?>
                <!-- Parte Superior del Contenido -->
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0">Actualizar Usuario</h1>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                                    <li class="breadcrumb-item active">Actualizar Usuario</li>
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
                                        <h3 class="card-title"><?php echo $datos['Nombre']." ".$datos['Apellido']." (".$datos['TipoEmpleado'].")"; ?></h3>
                                    </div>
                                    <h5><p class="text-center pb-6"><?php echo "<strong>Usuario creado:</strong> ".date("d-m-Y  h:i:s A",strtotime($datos['FechaCreacion'])).
                                            " &nbsp; <strong>Usuario actualizado:</strong> ".date("d-m-Y  h:i:s A",strtotime($datos['UltimaModificacion'])); ?></p></h5>
                                    

                                    <form action="<?php echo APP_URL; ?>app/ajax/adminAjax.php" method="post" autocomplete="off" class=""
                                        enctype="multipart/form-data">
                                        <input type="hidden" name="modulo_administrativo" value="actualizar">
                                        <input type="hidden" name="administrativoId" value="<?php echo $datos['idAdministrativo']; ?>">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="nombre">Nombre</label>
                                                        <input type="text" class="form-control form-control-border border-width-2"
                                                            pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" name="administrativoNombre" value="<?php echo $datos['Nombre']; ?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="apellido">Apellido</label>
                                                        <input type="text" class="form-control form-control-border border-width-2"
                                                            pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" name="administrativoApellido" value="<?php echo $datos['Apellido']; ?>" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Documentación</label>
                                                        <div class="input-group mb-3">
                                                            <select class="btn btn-info dropdown-toggle" id="category" name="administrativoDocumentacionTipo" required="">
                                                                <option value="" class="form-control" type="button" data-bs-toggle="dropdown" aria-expanded="false">Seleccionar...</option>
                                                                <?php
                                                                foreach($consultaDocumentacion as $dato){
                                                                ?>
                                                                <option value="<?php echo $dato->id ?>" <?php echo ($datos['idTipoDocumentacion'] == $dato->id) ? 'selected' : ''; ?> class="form-control"><?php echo $dato->descripcion ?></option>
                                                                <?php
                                                                } 
                                                                ?>
                                                            </select>
                                                            <input type="text" class="form-control form-control-border border-width-2" name="administrativoDocumentacionNumero" value="<?php echo $datos['DocumentacionNumero']; ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="row">
                                                        <div class="form-group mr-2">
                                                            <label>CUIL</label>
                                                            <input type="text" class="form-control form-control-border border-width-2"
                                                                pattern="[0-9]{11,20}" name="administrativoCuil" value="<?php echo $datos['Cuil']; ?>" required>
                                                        </div>
                                                        <div class="form-group ml-2">
                                                            <label>Número Seguro Social</label>
                                                            <input type="text" class="form-control form-control-border border-width-2"
                                                                pattern="[0-9]{7,100}" name="administrativoNumeroSegSocial" value="<?php echo $datos['NumSegSocial']; ?>">
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
                                                            pattern="[a-zA-Z0-9]{4,20}" name="administrativoUsuario" value="<?php echo $datos['Usuario']; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="row">
                                                        <div class="form-group mr-2">
                                                            <label for="cuil">Clave</label>
                                                            <input type="password" class="form-control form-control-border border-width-2"
                                                                pattern="[a-zA-Z0-9$@.-]{4,100}" name="administrativoClave1">
                                                        </div>
                                                        <div class="form-group ml-2">
                                                            <label for="cuil">Confirmar Clave</label>
                                                            <input type="password" class="form-control form-control-border border-width-2"
                                                                pattern="[a-zA-Z0-9$@.-]{4,100}" name="administrativoClave2">
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
                                                        <input type="text" class="form-control form-control-border border-width-2" name="administrativoCorreo" value="<?php echo $datos['Correo']; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="cuil">Telefono (Ej: 3704123456)</label>
                                                        <input type="text" class="form-control form-control-border border-width-2"
                                                            pattern="[0-9]{10,10}" name="administrativoTelefono" value="<?php echo $datos['Telefono']; ?>">
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
                                                            pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9 ]{7,100}" name="administrativoCalle" value="<?php echo $datos['Calle']; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="row">
                                                        <div class="form-group mr-2">
                                                            <label for="cuil">Barrio</label>
                                                            <input type="text" class="form-control form-control-border border-width-2"
                                                                pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9 ]{7,100}" name="administrativoBarrio" value="<?php echo $datos['Barrio']; ?>">
                                                        </div>
                                                        <div class="form-group ml-2">
                                                            <label for="provincia">Provincias</label>
                                                            <select class="form-control btn-info dropdown-toggle" id="category" name="administrativoProvincia" required="">
                                                                <option value="0" class="form-control" type="button" data-bs-toggle="dropdown" aria-expanded="false">Seleccionar...</option>
                                                                <?php
                                                                foreach($consultaProvincias as $dato){
                                                                ?>
                                                                <option value="<?php echo $dato->id ?>" <?php echo ($datos['idProvincia'] == $dato->id) ? 'selected' : ''; ?> class="form-control"><?php echo $dato->nombre?></option>
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
                                                        <label for="nombre">Sector</label>
                                                        <input type="text" class="form-control form-control-border border-width-2"
                                                            pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{4,40}" name="administrativoSector" value="<?php echo $datos['Sector']; ?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="foto">Foto de Perfil</label>
                                                        <div class="input-group">
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input" name="administrativoFoto">
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
                                            <button type="submit" class="btn btn-info float-right">Actualizar</button>
                                            <button class="btn btn-secondary float-left btn-back"><?php include "./app/views/inc/btn_back.php"; ?></button>
                                        </div>
                                    </form>
    <?php
            }else{
                include "./app/views/inc/error_alert.php";
            }  
        }
    ?>