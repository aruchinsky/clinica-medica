        <!-- Contenido de la Pagina -->
        <div class="content-wrapper" style="min-height: 227px;">

            <!-- Parte Superior del Contenido -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Acceso Rápido</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                                <li class="breadcrumb-item active">Acceso Rápido</li>
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

<div class="container is-fluid mb-6">
	<?php 

		$id=$insLogin->limpiarCadena($url[1]);

		if($id==$_SESSION['id']){ 
	?>
	<h1 class="title">Mi foto de perfil</h1>
	<h2 class="subtitle">Actualizar foto de perfil</h2>
	<?php }else{ ?>
	<h1 class="title">Usuarios</h1>
	<h2 class="subtitle">Actualizar foto de perfil</h2>
	<?php } ?>
</div>
<div class="container pb-6 pt-6">
	<?php
	
		include "./app/views/inc/btn_back.php";

		$datos=$insLogin->ejecutarConsultaLibre("SELECT u.id idUsuario, p.nombre Nombre, p.apellido Apellido, u.nombre_usuario Usuario,
                                                    u.fecha_creacion FechaCreacion, u.ultima_modificacion UltimaModificacion,
                                                    td.id idTipoDocumentacion, td.descripcion TipoDocumentacion, d.numero DocumentacionNumero,
                                                    p.cuil Cuil, pro.id idProvincia, p.numero_seg_social NumSegSocial, c.correo Correo,
                                                    c.telefono Telefono, dir.calle Calle, dir.barrio Barrio, u.foto Foto
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
			$datos=$datos->fetch();
	?>

	<h2 class="title has-text-centered"><?php echo $datos['Nombre']." ".$datos['Apellido']; ?></h2>

	<p class="has-text-centered pb-6"><?php echo "<strong>Usuario creado:</strong> ".date("d-m-Y  h:i:s A",strtotime($datos['FechaCreacion']))." &nbsp; <strong>Usuario actualizado:</strong> ".date("d-m-Y  h:i:s A",strtotime($datos['UltimaModificacion'])); ?></p>

	<div class="columns">
		<div class="column is-two-fifths">
            <?php if(is_file("./app/views/photos/".$datos['Foto'])){ ?>
			<figure class="image mb-6">
                <img class="is-rounded" src="<?php echo APP_URL; ?>app/views/photos/<?php echo $datos['Foto']; ?>">
			</figure>
			
			<form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/usuarioAjax.php" method="POST" autocomplete="off" >

				<input type="hidden" name="modulo_usuario" value="eliminarFoto">
				<input type="hidden" name="usuario_id" value="<?php echo $datos['idUsuario']; ?>">

				<p class="has-text-centered">
					<button type="submit" class="button is-danger is-rounded">Eliminar foto</button>
				</p>
			</form>
			<?php }else{ ?>
			<figure class="image mb-6">
			  	<img class="is-rounded" src="<?php echo APP_URL; ?>app/views/img/logo.png">
			</figure>
			<?php }?>
		</div>


		<div class="column">
			<form class="mb-6 has-text-centered FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/usuarioAjax.php" method="POST" enctype="multipart/form-data" autocomplete="off" >

				<input type="hidden" name="modulo_usuario" value="actualizarFoto">
				<input type="hidden" name="usuario_id" value="<?php echo $datos['idUsuario']; ?>">
				
				<label>Foto o imagen del usuario</label><br>

				<div class="file has-name is-boxed is-justify-content-center mb-6">
				  	<label class="file-label">
						<input class="file-input" type="file" name="usuario_foto" accept=".jpg, .png, .jpeg" >
						<span class="file-cta">
							<span class="file-label">
								Seleccione una foto
							</span>
						</span>
						<span class="file-name">JPG, JPEG, PNG. (MAX 5MB)</span>
					</label>
				</div>
				<p class="has-text-centered">
					<button type="submit" class="button is-success is-rounded">Actualizar foto</button>
				</p>
			</form>
		</div>
	</div>
	<?php
		}else{
			include "./app/views/inc/error_alert.php";
		}
	?>
</div>

                    </div>
                </div>
            </section>