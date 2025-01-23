<?php
    namespace app\controllers;
    use app\models\mainModel;
    use \PDOException;

    class userController extends mainModel{

        //CONTROLADOR PARA REGISTRAR USUARIO
        public function registrarUsuarioControlador(){

            //ALmacenando los datos que vienen de la vista
            $nombre = $this->limpiarCadena($_POST['administrativoNombre']);
            $apellido = $this->limpiarCadena($_POST['administrativoApellido']);
            $documentacionTipo = $this->limpiarCadena($_POST['administrativoDocumentacionTipo']);
            $documentacionNumero = $this->limpiarCadena($_POST['administrativoDocumentacionNumero']);
            $cuil = $this->limpiarCadena($_POST['administrativoCuil']);
            $usuario = $this->limpiarCadena($_POST['administrativoUsuario']);
            $clave1 = $this->limpiarCadena($_POST['administrativoClave1']);
            $clave2 = $this->limpiarCadena($_POST['administrativoClave2']);
            $correo = $this->limpiarCadena($_POST['administrativoCorreo']);
            $telefono = $this->limpiarCadena($_POST['administrativoTelefono']);
            $calle = $this->limpiarCadena($_POST['administrativoCalle']);
            $barrio = $this->limpiarCadena($_POST['administrativoBarrio']);
            $provincia = $this->limpiarCadena($_POST['administrativoProvincia']);
            $numeroSegSocial = $this->limpiarCadena($_POST['administrativoNumeroSegSocial']);
			$sector = $this->limpiarCadena($_POST['administrativoSector']);

            //Verificando campos obligatorios
            if($nombre=="" || $apellido=="" || $documentacionTipo=="" || $documentacionNumero=="" || $telefono==""
            || $provincia=="" || $usuario=="" || $cuil=="" || $clave1=="" || $clave2=="" || $numeroSegSocial==""
			|| $sector==""){
                //Definimos todo los valores de un array para la alerta
                $alerta = [
                    "tipo" => "simple",
                    "titulo" => "Ocurrió un error inesperado",
                    "texto" => "No has llenado todos los campos que son obligatorios.",
                    "icono" => "error",

                ];
                //Devolvemos el array codificado en JSON
                return json_encode($alerta);
                exit();
            }

            //Verificando la integridad de los datos
            if($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}",$nombre)){
                //Definimos todo los valores de un array para la alerta
                $alerta = [
                    "tipo" => "simple",
                    "titulo" => "Ocurrió un error inesperado",
                    "texto" => "El nombre no coincide con el formato solicitado",
                    "icono" => "error",

                ];
                //Devolvemos el array codificado en JSON
                return json_encode($alerta);
                exit();
            }
		    if($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}",$apellido)){
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El APELLIDO no coincide con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }
		    if($this->verificarDatos("[a-zA-Z0-9]{4,10}",$usuario)){
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El USUARIO no coincide con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }
		    if($this->verificarDatos("[a-zA-Z0-9$@.-]{4,100}",$clave1) || $this->verificarDatos("[a-zA-Z0-9$@.-]{4,100}",$clave2)){
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"Las CLAVES no coinciden con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }
		    # Verificando email #
		    if($correo!=""){
				if(filter_var($correo, FILTER_VALIDATE_EMAIL)){
					$check_email=$this->ejecutarConsulta("SELECT correo FROM contactos WHERE correo='$correo'");
					if($check_email->rowCount()>0){
						$alerta=[
							"tipo"=>"simple",
							"titulo"=>"Ocurrió un error inesperado",
							"texto"=>"El EMAIL que acaba de ingresar ya se encuentra registrado en el sistema, por favor verifique e intente nuevamente",
							"icono"=>"error"
						];
						return json_encode($alerta);
						exit();
					}
				}else{
					$alerta=[
						"tipo"=>"simple",
						"titulo"=>"Ocurrió un error inesperado",
						"texto"=>"Ha ingresado un correo electrónico no valido",
						"icono"=>"error"
					];
					return json_encode($alerta);
					exit();
				}
            }
            # Verificando claves #
            if($clave1!=$clave2){
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"Las contraseñas que acaba de ingresar no coinciden, por favor verifique e intente nuevamente",
					"icono"=>"error"
				];
				return json_encode($alerta);
				exit();
			}else{
                $clave = $clave1;
            }

            # Verificando usuario #
		    $check_usuario=$this->ejecutarConsulta("SELECT nombre_usuario FROM usuarios WHERE nombre_usuario='$usuario'");
		    if($check_usuario->rowCount()>0){
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El USUARIO ingresado ya se encuentra registrado, por favor elija otro",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

			if($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{4,40}",$sector)){
                //Definimos todo los valores de un array para la alerta
                $alerta = [
                    "tipo" => "simple",
                    "titulo" => "Ocurrió un error inesperado",
                    "texto" => "El sector no coincide con el formato solicitado",
                    "icono" => "error",

                ];
                //Devolvemos el array codificado en JSON
                return json_encode($alerta);
                exit();
            }


            // DIrectorio de IMAGENES
            $img_dir = "../views/photos/";
            //Comprobar si se ha seleccionado una imagen
            // 1- Comprobamos si el archivo TIENE NOMBRE
            // 2- Comprobamos si el archivo TIENE UN TAMAÑO
            if($_FILES['administrativoFoto']['name']!="" && $_FILES['administrativoFoto']['size']>0){

                //Creamos el directorio de las imagenes en caso de que nos este creado
                // FILE_EXISTS -> Nos permite comprobar si una ruta o archivo existe
                if(!file_exists($img_dir)){
                    //Si no existe la creamos
                    if(!mkdir($img_dir,0777)){
                        $alerta=[
                            "tipo"=>"simple",
                            "titulo"=>"Ocurrió un error inesperado",
                            "texto"=>"Error al crear el directorio",
                            "icono"=>"error"
                        ];
                        return json_encode($alerta);
                        exit();
                    }
                }

                //Verificando formato de imagenes
                if(mime_content_type($_FILES['administrativoFoto']['tmp_name'])!="image/jpeg" &&
                    mime_content_type($_FILES['administrativoFoto']['tmp_name'])!="image/png"){

                        $alerta=[
                            "tipo"=>"simple",
                            "titulo"=>"Ocurrió un error inesperado",
                            "texto"=>"La imagen que se ha seleccionado no es de un formato permitido",
                            "icono"=>"error"
                        ];
                        return json_encode($alerta);
                        exit();
                }

                //Verificando el peso de las imagenes
                if($_FILES['administrativoFoto']['size']/1024>5012){
                    $alerta=[
                        "tipo"=>"simple",
                        "titulo"=>"Ocurrió un error inesperado",
                        "texto"=>"La imagen que has seleccionado supera el peso permitido!",
                        "icono"=>"error"
                    ];
                    return json_encode($alerta);
                    exit();
                }

                //Definir el nombre de la imagen subida
                $foto = str_ireplace(" ","_",$nombre);
                $foto = $foto."_".rand(0,100);

                //Colocaremos la extension de la imagen a la foto
                switch(mime_content_type($_FILES['administrativoFoto']['tmp_name'])){
                    case "image/jpeg":
                        $foto=$foto.".jpg";
                        break;
                    case "image/png":
                        $foto=$foto.".png";
                        break;
                }

                //Le damos permisos de lectura y escritura a la carpeta donde vamos a archivar la imagen
                //Esto para mover la imagen
                chmod($img_dir,0777);

                //Movemos la imagen al directorio (EN CASO QUE NO MOSTRAMOS ALERTA)
                // 1er parametro el origen de la imagen
                // 2do paraemtro a donde queremos destinar la imagen
                if(!move_uploaded_file($_FILES['administrativoFoto']['tmp_name'],$img_dir.$foto)){
                    $alerta=[
                        "tipo"=>"simple",
                        "titulo"=>"Ocurrió un error inesperado",
                        "texto"=>"No podemos subir la imagen al sistema en este momento",
                        "icono"=>"error"
                    ];
                    return json_encode($alerta);
                    exit();
                }

            }else{
                $foto = "";
            }



            try{
				// 1-1. Cargamos el array de CONTACTOS
				$contacto_datos_reg=[
					[
						"campo_nombre"=>"telefono",
						"campo_marcador"=>":Telefono",
						"campo_valor"=>$telefono
					],
					[
						"campo_nombre"=>"correo",
						"campo_marcador"=>":Correo",
						"campo_valor"=>$correo
					],
					[
						"campo_nombre"=>"ultima_modificacion",
						"campo_marcador"=>":UltimaModificacion",
						"campo_valor"=>date("Y-m-d H:i:s")
					],
					[
						"campo_nombre"=>"fecha_creacion",
						"campo_marcador"=>":FechaCreacion",
						"campo_valor"=>date("Y-m-d H:i:s")
					],
					[
						"campo_nombre"=>"flag_mostrar",
						"campo_marcador"=>":FlagMostrar",
						"campo_valor"=> 1
					],
					[
						"campo_nombre"=>"usuario",
						"campo_marcador"=>":Usuario",
						"campo_valor"=> 40083172
					]
				];
                // 1-2. Registramos los datos de contactos
                $registrar_contacto=$this->guardarDatosId("contactos",$contacto_datos_reg);
                // 1-3. Seleccionamos el IDContacto
				$id_contacto = $registrar_contacto;


				// 2-1. Cargamos el array de DIRECCIONES
				$direccion_datos_reg=[
					[
						"campo_nombre"=>"calle",
						"campo_marcador"=>":Calle",
						"campo_valor"=>$calle
					],
					[
						"campo_nombre"=>"barrio",
						"campo_marcador"=>":Barrio",
						"campo_valor"=>$barrio
					],
					[
						"campo_nombre"=>"id_provincias",
						"campo_marcador"=>":IdProvincias",
						"campo_valor"=>$provincia
					],
					[
						"campo_nombre"=>"ultima_modificacion",
						"campo_marcador"=>":UltimaModificacion",
						"campo_valor"=>date("Y-m-d H:i:s")
					],
					[
						"campo_nombre"=>"fecha_creacion",
						"campo_marcador"=>":FechaCreacion",
						"campo_valor"=>date("Y-m-d H:i:s")
					],
					[
						"campo_nombre"=>"flag_mostrar",
						"campo_marcador"=>":FlagMostrar",
						"campo_valor"=> 1
					],
					[
						"campo_nombre"=>"usuario",
						"campo_marcador"=>":Usuario",
						"campo_valor"=> 40083172
					]
				];
                // 2-2. Registramos los datos de direccion
                $registrar_direccion=$this->guardarDatosId("direcciones",$direccion_datos_reg);
                // 2-3. Seleccionamos el IDDireccion
                $id_direccion = $registrar_direccion;


				// 3-1. Cargamos el array de PERSONAS
				$persona_datos_reg=[
					[
						"campo_nombre"=>"apellido",
						"campo_marcador"=>":Apellido",
						"campo_valor"=>$apellido
					],
					[
						"campo_nombre"=>"nombre",
						"campo_marcador"=>":Nombre",
						"campo_valor"=>$nombre
					],
					[
						"campo_nombre"=>"cuil",
						"campo_marcador"=>":Cuil",
						"campo_valor"=>$cuil
					],
					[
						"campo_nombre"=>"id_contactos",
						"campo_marcador"=>":idContactos",
						"campo_valor"=>$id_contacto
					],
					[
						"campo_nombre"=>"id_direcciones",
						"campo_marcador"=>":idDirecciones",
						"campo_valor"=>$id_direccion
					],
					[
						"campo_nombre"=>"numero_seg_social",
						"campo_marcador"=>":NumeroSegSocial",
						"campo_valor"=>$numeroSegSocial
					],
					[
						"campo_nombre"=>"ultima_modificacion",
						"campo_marcador"=>":UltimaModificacion",
						"campo_valor"=>date("Y-m-d H:i:s")
					],
					[
						"campo_nombre"=>"fecha_creacion",
						"campo_marcador"=>":FechaCreacion",
						"campo_valor"=>date("Y-m-d H:i:s")
					],
					[
						"campo_nombre"=>"flag_mostrar",
						"campo_marcador"=>":FlagMostrar",
						"campo_valor"=> 1
					],
					[
						"campo_nombre"=>"usuario",
						"campo_marcador"=>":Usuario",
						"campo_valor"=> 40083172
					]
				];
                // 3-2. Registramos los datos de personas
                $registrar_persona=$this->guardarDatosId("personas",$persona_datos_reg);
                // 3-3. Seleccionamos el IDPersonas
                $id_persona = $registrar_persona;


				// 4-1. Cargamos el array de USUARIOS
				$usuario_datos_reg=[
					[
						"campo_nombre"=>"nombre_usuario",
						"campo_marcador"=>":NombreUsuario",
						"campo_valor"=>$usuario
					],
					[
						"campo_nombre"=>"clave",
						"campo_marcador"=>":Clave",
						"campo_valor"=>"aes_encrypt('$clave','PEPE')"
					],
					[
						"campo_nombre"=>"foto",
						"campo_marcador"=>":Foto",
						"campo_valor"=>$foto
					],
					[
						"campo_nombre"=>"id_tipo_usuarios",
						"campo_marcador"=>":idTipoUsuarios",
						"campo_valor"=>3
					],
					[
						"campo_nombre"=>"id_personas",
						"campo_marcador"=>":Foto",
						"campo_valor"=>$id_persona
					],
					[
						"campo_nombre"=>"ultima_modificacion",
						"campo_marcador"=>":UltimaModificacion",
						"campo_valor"=>date("Y-m-d H:i:s")
					],
					[
						"campo_nombre"=>"fecha_creacion",
						"campo_marcador"=>":FechaCreacion",
						"campo_valor"=>date("Y-m-d H:i:s")
					],
					[
						"campo_nombre"=>"flag_mostrar",
						"campo_marcador"=>":FlagMostrar",
						"campo_valor"=> 1
					],
					[
						"campo_nombre"=>"usuario",
						"campo_marcador"=>":Usuario",
						"campo_valor"=> 40083172
					]
				];
                // 4-2. Registramos los datos de usuarios
                $registrar_usuario=$this->guardarDatos("usuarios",$usuario_datos_reg);


				// 5-1. Cargamos el array de ADMINISTRATIVO
				$administrativo_datos_reg=[
					[
						"campo_nombre"=>"sector",
						"campo_marcador"=>":Sector",
						"campo_valor"=>$sector
					],
					[
						"campo_nombre"=>"id_personas",
						"campo_marcador"=>":idPersonas",
						"campo_valor"=>$id_persona
					],
					[
						"campo_nombre"=>"id_tipo_empleados",
						"campo_marcador"=>":idTipoEmpleados",
						"campo_valor"=>3
					],
					[
						"campo_nombre"=>"ultima_modificacion",
						"campo_marcador"=>":UltimaModificacion",
						"campo_valor"=>date("Y-m-d H:i:s")
					],
					[
						"campo_nombre"=>"fecha_creacion",
						"campo_marcador"=>":FechaCreacion",
						"campo_valor"=>date("Y-m-d H:i:s")
					],
					[
						"campo_nombre"=>"flag_mostrar",
						"campo_marcador"=>":FlagMostrar",
						"campo_valor"=> 1
					],
					[
						"campo_nombre"=>"usuario",
						"campo_marcador"=>":Usuario",
						"campo_valor"=> 40083172
					]
				];
				// 5-2. Registramos los datos de ADMINISTRATIVO
				$registrar_administrativo=$this->guardarDatos("administrativos",$administrativo_datos_reg);

            }catch(PDOException $exc){
                $mensaje_error =  $exc->getMessage();
                $alerta=[
                    "tipo"=>"simple",
                    "titulo"=>"Ocurrió un error inesperado",
                    "texto"=>$exc,
                    "icono"=>"error"
                ];
                return json_encode($alerta);
                exit();  
            }

            if($registrar_administrativo->rowCount()==1){
			 	$alerta=[
			 		"tipo"=>"limpiar",
			 		"titulo"=>"Usuario registrado",
			 		"texto"=>"El usuario ".$nombre." ".$apellido." se registro con exito",
			 		"icono"=>"success"
			 	];
			}else{
				
			 	if(is_file($img_dir.$foto)){
		             chmod($img_dir.$foto,0777);
		             unlink($img_dir.$foto);
		         }

			 	$alerta=[
			 		"tipo"=>"simple",
			 		"titulo"=>"Ocurrió un error inesperado",
			 		"texto"=>"No se pudo registrar el usuario, por favor intente nuevamente",
					"icono"=>"error"
			 	];
			}

			 return json_encode($alerta);
        }

		//Controlador para lista de administrativos
		public function listarUsuarioControlador($pagina,$registros,$url,$busqueda){

			$pagina = $this->limpiarCadena($pagina);
			$registros = $this->limpiarCadena($registros);

			$url = $this->limpiarCadena($url);
			$url = APP_URL.$url."/";

			$busqueda = $this->limpiarCadena($busqueda);

			$tabla = "";

			//Operador ternario : Se coloca una condicion entre parentesis,
			// si la condicion devuelve true se ejecuta lo que esta despues del signo de interrogacion7
			// y antes de los dos puntos, sino ejecuta lo que esta al final
			$pagina = (isset($pagina) && $pagina>0) ? (int) $pagina : 1;

			// Nos va a indicar desde que numero empezar a contar cuando recorramos el array
			// que carga la tabla
			$inicio = ($pagina>0) ? (($pagina * $registros) - $registros) : 0 ;

			//Si la busqueda viene definida Y su texto no esta vacio
			if(isset($busqueda) && $busqueda!=""){
				$consulta_datos = "SELECT u.id idUsuario, p.nombre Nombre, p.apellido Apellido, u.nombre_usuario Usuario,
								    u.fecha_creacion FechaCreacion 
								   FROM usuarios u
								   JOIN personas p
								   ON p.id = u.id_personas
								   WHERE u.flag_mostrar = 1  AND p.nombre LIKE '%$busqueda%' OR p.apellido LIKE '%$busqueda%' OR u.nombre_usuario LIKE '%$busqueda%'
                          			ORDER BY p.nombre ASC LIMIT $inicio,$registros";

				$consulta_total = "SELECT count(u.id) 
								   FROM usuarios u
								   JOIN personas p
								   ON p.id = u.id_personas
								   WHERE u.flag_mostrar = 1  AND p.nombre LIKE '%$busqueda%' OR p.apellido LIKE '%$busqueda%' OR u.nombre_usuario LIKE '%$busqueda%'
                          			ORDER BY p.nombre ASC LIMIT $inicio,$registros";
			}else{
				$consulta_datos = "SELECT u.id idUsuario, p.nombre Nombre, p.apellido Apellido, u.nombre_usuario Usuario,
								   	u.fecha_creacion FechaCreacion
								   FROM usuarios u
								   JOIN personas p
								   ON p.id = u.id_personas
								  WHERE u.flag_mostrar = 1          
                          			ORDER BY p.nombre ASC LIMIT $inicio,$registros";

				$consulta_total = "SELECT count(u.id) 
								   FROM usuarios u
								   JOIN personas p
								   ON p.id = u.id_personas
								   WHERE u.flag_mostrar=1";
			}

			$datos = $this->ejecutarConsulta($consulta_datos);
			$datos = $datos->fetchAll();

			$total = $this->ejecutarConsulta($consulta_total);
			$total = (int) $total->fetchColumn();
			// print_r($total);
			// exit();
			$Npaginas = ceil($total/$registros);

			$tabla.='
				<div class="table-responsive">
					<table class="table table-sm text-center table-striped table-hover table-bordered">
						<thead>
							<tr>
								<th scope="col">#</th>
								<th scope="col">Nombre y Apellido</th>
								<th scope="col">Usuario</th>
								<th scope="col">Fecha de Alta</th>
								<th colspan="3" scope="col" style="text-align: center;">Opciones</th>
							</tr>
						</thead>
						<tbody class="table-group-divider">
			';


			if($total>=1 && $pagina<=$Npaginas){
				#Este contador es solamente para enumerar los registros en la tabla
				$contador = $inicio + 1;
				#Variable que sera usada en el texto inferior de la tabla
				$paginador_inicio = $inicio + 1;

				#Recorremos todos los datos
				foreach($datos as $rows){
					$tabla.='
                            <tr>
                                <td>'.$contador.'</td>
                                <td>'.$rows['Nombre'].' '.$rows['Apellido'].'</td>
                                <td>'.$rows['Usuario'].'</td>
								<td>'.date("d-m-Y",strtotime($rows['FechaCreacion'])).'</td>
                                <td>
                                    <a href="'.APP_URL.'userPhoto/'.$rows['idUsuario'].'/" class="btn btn-secondary">
                                        <i class="fa-solid fa-image"></i>
                                    </a>
                                </td>
								<td>
                                    <a href="'.APP_URL.'userUpdate/'.$rows['idUsuario'].'/" class="btn btn-success">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                </td>
                                <td>
									<form class="FormularioAjax" action="'.APP_URL.'app/ajax/adminAjax.php" method="post" autocomplete="off">
										<input type="hidden" name="modulo_administrativo" value="eliminar">
										<input type="hidden" name="administrativo_id" value="'.$rows['idUsuario'].'">
										<button type="submit" class="btn btn-danger">
											<i class="fa-solid fa-trash"></i>
										</button>
									</form>
                                </td>
                            </tr>
					';
					#INcrementamos el contador de uno en uno
					$contador ++;
				}
				#Variable que sera usada en el texto inferior de la tabla
				$paginador_final = $contador - 1;
			}else{
				#Si hay registros pero estamos en una pagina que no exista
				if($total>=1){
					$tabla.='
						<tr class="text-center">
							<td colspan="8">
								<a href="'.$url.'1/" class="btn btn-secondary">
									Haga clic aquí para recargar el listado
								</a>
							</td>
						</tr>
					';
				}else{
					#Si no hay registros
					$tabla.='
						<tr class="text-center">
							<td colspan="8">
								No hay registros en el sistema
							</td>
						</tr>
					';
				}
			}


			$tabla.='
			 			</tbody>
                    </table>
                </div>
			';

			if($total>=1 && $pagina<=$Npaginas){
				$tabla.='
					<p class="has-text-right">Mostrando usuarios 
						<strong>'.$paginador_inicio.'</strong> al <strong>'.
						$paginador_final.'</strong> de un <strong>total de '.$total.'</strong></p>
				';
				$tabla.= $this->paginadorTablas($pagina,$Npaginas,$url,10);
			}

			return $tabla;
		}

		//Controlador para eliminar un administrativo
		public function eliminarUsuarioControlador(){
			$id = $this->limpiarCadena($_POST['administrativo_id']);

			if($id==1){
                //Definimos todo los valores de un array para la alerta
                $alerta = [
                    "tipo" => "simple",
                    "titulo" => "Ocurrió un error inesperado",
                    "texto" => "No podemos eliminar el usuario principal del sistema.",
                    "icono" => "error",

                ];
                //Devolvemos el array codificado en JSON
                return json_encode($alerta);
                exit();
			}

			//Verificar el usuario
			$datos = $this->ejecutarConsulta("SELECT a.id idAdministrativo, p.id idPersona, a.sector Sector,
											  p.nombre Nombre, p.apellido Apellido, u.foto Foto
											  FROM administrativos a
											  JOIN personas p
											  ON p.id = a.id_personas
											  JOIN usuarios u
											  ON p.id = u.id_personas
											  WHERE a.id='$id'");

			if($datos->rowCount()<=0){
				//Definimos todo los valores de un array para la alerta
                $alerta = [
                    "tipo" => "simple",
                    "titulo" => "Ocurrió un error inesperado",
                    "texto" => "No hemos encontrado al usuario en el sistema.",
                    "icono" => "error",

                ];
                //Devolvemos el array codificado en JSON
                return json_encode($alerta);
                exit();
			}else{
				$datos = $datos->fetch();
			}

			$eliminar_admin= $this->eliminarRegistro("administrativos","id",$id);

			if($eliminar_admin->rowCount()==1){

				if(is_file("../views/photos/".$datos['Foto'])){
					chmod("../views/photos/".$datos['Foto'],0777);
					unlink("../views/photos/".$datos['Foto']);
				}

				$alerta=[
					"tipo"=>"recargar",
					"titulo"=>"Usuario eliminado",
					"texto"=>"El usuario ".$datos['Nombre']." ".$datos['Apellido']." se eliminó con exito",
					"icono"=>"success"
				];

			}else{
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No se pudo eliminar el usuario ".$datos['Nombre']." ".$datos['Apellido'].",
							  por favor intente nuevamente",
				   "icono"=>"error"
				];
			}
			return json_encode($alerta);
		}

		/*----------  Controlador actualizar usuario  ----------*/
		public function actualizarUsuarioControlador(){

			$id=$this->limpiarCadena($_POST['usuarioId']);

			# Verificando usuario #
		    $datos=$this->ejecutarConsulta("SELECT u.id idUsuario, p.nombre Nombre, p.apellido Apellido, u.nombre_usuario Usuario,
                                                    u.fecha_creacion FechaCreacion, u.ultima_modificacion UltimaModificacion,
                                                    td.id idTipoDocumentacion, td.descripcion TipoDocumentacion, d.numero DocumentacionNumero,
                                                    p.cuil Cuil, pro.id idProvincia, p.numero_seg_social NumSegSocial, c.correo Correo,
                                                    c.telefono Telefono, dir.calle Calle, dir.barrio Barrio, c.id idContacto,
													dir.id idDireccion, p.id idPersona, aes_decrypt(u.clave, 'PEPE') Clave
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
		    
			if($datos->rowCount()<=0){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos encontrado el usuario en el sistema",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }else{
		    	$datos=$datos->fetch();
				//Capturamos los id necesarios
				$id_contacto = $datos['idContacto'];
				$id_direccion = $datos['idDireccion'];
				$id_persona = $datos['idPersona'];
				$id_usuario = $datos['idUsuario'];
		    }

            //ALmacenando los datos que vienen de la vista
            $nombre = $this->limpiarCadena($_POST['administrativoNombre']);
            $apellido = $this->limpiarCadena($_POST['administrativoApellido']);
            $documentacionTipo = $this->limpiarCadena($_POST['administrativoDocumentacionTipo']);
            $documentacionNumero = $this->limpiarCadena($_POST['administrativoDocumentacionNumero']);
            $cuil = $this->limpiarCadena($_POST['administrativoCuil']);
            $usuario = $this->limpiarCadena($_POST['administrativoUsuario']);
            $clave1 = $this->limpiarCadena($_POST['administrativoClave1']);
            $clave2 = $this->limpiarCadena($_POST['administrativoClave2']);
            $correo = $this->limpiarCadena($_POST['administrativoCorreo']);
            $telefono = $this->limpiarCadena($_POST['administrativoTelefono']);
            $calle = $this->limpiarCadena($_POST['administrativoCalle']);
            $barrio = $this->limpiarCadena($_POST['administrativoBarrio']);
            $provincia = $this->limpiarCadena($_POST['administrativoProvincia']);
            $numeroSegSocial = $this->limpiarCadena($_POST['administrativoNumeroSegSocial']);

            //Verificando campos obligatorios
            if($nombre=="" || $apellido=="" || $documentacionTipo=="" || $documentacionNumero=="" || $telefono==""
            || $provincia=="" || $usuario=="" || $cuil=="" || $numeroSegSocial==""){
                //Definimos todo los valores de un array para la alerta
                $alerta = [
                    "tipo" => "simple",
                    "titulo" => "Ocurrió un error inesperado",
                    "texto" => "No has llenado todos los campos que son obligatorios.",
                    "icono" => "error",

                ];
                //Devolvemos el array codificado en JSON
                return json_encode($alerta);
                exit();
            }

			//Verificando la integridad de los datos
            if($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}",$nombre)){
                //Definimos todo los valores de un array para la alerta
                $alerta = [
                    "tipo" => "simple",
                    "titulo" => "Ocurrió un error inesperado",
                    "texto" => "El nombre no coincide con el formato solicitado",
                    "icono" => "error",

                ];
                //Devolvemos el array codificado en JSON
                return json_encode($alerta);
                exit();
            }
		    if($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}",$apellido)){
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El APELLIDO no coincide con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }
		    if($this->verificarDatos("[a-zA-Z0-9]{4,10}",$usuario)){
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El USUARIO no coincide con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

			if($clave1=="" && $clave2==""){
				$clave = $datos['Clave'];
			}else{
				if($this->verificarDatos("[a-zA-Z0-9$@.-]{4,100}",$clave1) || $this->verificarDatos("[a-zA-Z0-9$@.-]{4,100}",$clave2)){
					$alerta=[
						"tipo"=>"simple",
						"titulo"=>"Ocurrió un error inesperado",
						"texto"=>"Las CLAVES no coinciden con el formato solicitado",
						"icono"=>"error"
					];
					return json_encode($alerta);
					exit();
				}
				# Verificando claves #
				if($clave1!=$clave2){
					$alerta=[
						"tipo"=>"simple",
						"titulo"=>"Ocurrió un error inesperado",
						"texto"=>"Las contraseñas que acaba de ingresar no coinciden, por favor verifique e intente nuevamente",
						"icono"=>"error"
					];
					return json_encode($alerta);
					exit();
				}else{
					$clave = $clave1;
				}
			}

			try{
				// 1-1. Cargamos el array de CONTACTOS
				$contacto_datos_up=[
					[
						"campo_nombre"=>"telefono",
						"campo_marcador"=>":Telefono",
						"campo_valor"=>$telefono
					],
					[
						"campo_nombre"=>"correo",
						"campo_marcador"=>":Correo",
						"campo_valor"=>$correo
					],
					[
						"campo_nombre"=>"ultima_modificacion",
						"campo_marcador"=>":UltimaModificacion",
						"campo_valor"=>date("Y-m-d H:i:s")
					],
					[
						"campo_nombre"=>"flag_mostrar",
						"campo_marcador"=>":FlagMostrar",
						"campo_valor"=> 1
					],
					[
						"campo_nombre"=>"usuario",
						"campo_marcador"=>":Usuario",
						"campo_valor"=> $_SESSION['usuario']
					]
				];
				$condicion_contacto=[
					"condicion_campo"=>"id",
					"condicion_marcador"=>":ID",
					"condicion_valor"=>$id_contacto
				];
                $ac_contacto=$this->actualizarDatos("contactos",$contacto_datos_up,$condicion_contacto);

				// 2-1. Cargamos el array de DIRECCIONES
				$direccion_datos_up=[
					[
						"campo_nombre"=>"calle",
						"campo_marcador"=>":Calle",
						"campo_valor"=>$calle
					],
					[
						"campo_nombre"=>"barrio",
						"campo_marcador"=>":Barrio",
						"campo_valor"=>$barrio
					],
					[
						"campo_nombre"=>"id_provincias",
						"campo_marcador"=>":IdProvincias",
						"campo_valor"=>$provincia
					],
					[
						"campo_nombre"=>"ultima_modificacion",
						"campo_marcador"=>":UltimaModificacion",
						"campo_valor"=>date("Y-m-d H:i:s")
					],
					[
						"campo_nombre"=>"flag_mostrar",
						"campo_marcador"=>":FlagMostrar",
						"campo_valor"=> 1
					],
					[
						"campo_nombre"=>"usuario",
						"campo_marcador"=>":Usuario",
						"campo_valor"=> $_SESSION['usuario']
					]
				];
				$condicion_direccion=[
					"condicion_campo"=>"id",
					"condicion_marcador"=>":ID",
					"condicion_valor"=>$id_direccion
				];
				$ac_direccion=$this->actualizarDatos("direcciones",$direccion_datos_up,$condicion_direccion);

				// 3-1. Cargamos el array de PERSONAS
				$persona_datos_up=[
					[
						"campo_nombre"=>"apellido",
						"campo_marcador"=>":Apellido",
						"campo_valor"=>$apellido
					],
					[
						"campo_nombre"=>"nombre",
						"campo_marcador"=>":Nombre",
						"campo_valor"=>$nombre
					],
					[
						"campo_nombre"=>"cuil",
						"campo_marcador"=>":Cuil",
						"campo_valor"=>$cuil
					],
					[
						"campo_nombre"=>"numero_seg_social",
						"campo_marcador"=>":NumeroSegSocial",
						"campo_valor"=>$numeroSegSocial
					],
					[
						"campo_nombre"=>"ultima_modificacion",
						"campo_marcador"=>":UltimaModificacion",
						"campo_valor"=>date("Y-m-d H:i:s")
					],
					[
						"campo_nombre"=>"flag_mostrar",
						"campo_marcador"=>":FlagMostrar",
						"campo_valor"=> 1
					],
					[
						"campo_nombre"=>"usuario",
						"campo_marcador"=>":Usuario",
						"campo_valor"=> $_SESSION['usuario']
					]
				];
				$condicion_persona=[
					"condicion_campo"=>"id",
					"condicion_marcador"=>":ID",
					"condicion_valor"=>$id_persona
				];
				$ac_persona=$this->actualizarDatos("personas",$persona_datos_up,$condicion_persona);

				// 4-1. Cargamos el array de USUARIOS
				$usuario_datos_up=[
					[
						"campo_nombre"=>"nombre_usuario",
						"campo_marcador"=>":NombreUsuario",
						"campo_valor"=>$usuario
					],
					[
						"campo_nombre"=>"clave",
						"campo_marcador"=>":Clave",
						"campo_valor"=> $clave
					],
					[
						"campo_nombre"=>"ultima_modificacion",
						"campo_marcador"=>":UltimaModificacion",
						"campo_valor"=>date("Y-m-d H:i:s")
					],
					[
						"campo_nombre"=>"flag_mostrar",
						"campo_marcador"=>":FlagMostrar",
						"campo_valor"=> 1
					],
					[
						"campo_nombre"=>"usuario",
						"campo_marcador"=>":Usuario",
						"campo_valor"=> $_SESSION['usuario']
					]
				];
				$condicion_usuario=[
					"condicion_campo"=>"id",
					"condicion_marcador"=>":ID",
					"condicion_valor"=>$id_usuario
				];
				$ac_usuario=$this->actualizarDatosConClave("usuarios",$usuario_datos_up,$condicion_usuario);

				if($id_usuario==$_SESSION['id']){
					$_SESSION['nombre']=$nombre." ".$apellido;
					$_SESSION['usuario']=$usuario;
				}
				$alerta=[
					"tipo"=>"recargar",
					"titulo"=>"Usuario actualizado",
					"texto"=>"Los datos del usuario ".$datos['Nombre']." ".$datos['Apellido']." se actualizaron correctamente",
					"icono"=>"success"
				];
				
			}catch(PDOException $exc){
                $mensaje_error =  $exc->getMessage();
                $alerta=[
                    "tipo"=>"simple",
                    "titulo"=>"Ocurrió un error inesperado",
                    "texto"=>$exc,
                    "icono"=>"error"
                ];
                return json_encode($alerta);
                exit();  
            }
			return json_encode($alerta);
		}
    }



?>