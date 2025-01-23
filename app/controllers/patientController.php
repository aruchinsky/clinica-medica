<?php
    namespace app\controllers;
    use app\models\mainModel;
    use \PDOException;

    class patientController extends mainModel{

        //CONTROLADOR PARA REGISTRAR 
        public function registrarPacienteControlador(){

                //ALmacenando los datos que vienen de la vista
                //Persona
                $nombre = $this->limpiarCadena($_POST['pacienteNombre']);
                $apellido = $this->limpiarCadena($_POST['pacienteApellido']);
                $documentacionTipo = $this->limpiarCadena($_POST['pacienteDocumentacionTipo']);
                $documentacionNumero = $this->limpiarCadena($_POST['pacienteDocumentacionNumero']);
                $cuil = $this->limpiarCadena($_POST['pacienteCuil']);
                $numeroSegSocial = $this->limpiarCadena($_POST['pacienteNumeroSegSocial']);
                //Usuario
                $usuario = $this->limpiarCadena($_POST['pacienteUsuario']);
                $clave1 = $this->limpiarCadena($_POST['pacienteClave1']);
                $clave2 = $this->limpiarCadena($_POST['pacienteClave2']);
                //Contacto
                $correo = $this->limpiarCadena($_POST['pacienteCorreo']);
                $telefono = $this->limpiarCadena($_POST['pacienteTelefono']);
                //Direccion
                $calle = $this->limpiarCadena($_POST['pacienteCalle']);
                $barrio = $this->limpiarCadena($_POST['pacienteBarrio']);
                $provincia = $this->limpiarCadena($_POST['pacienteProvincia']);
                //Paciente
                $idMedico = $this->limpiarCadena($_POST['pacienteMedico']);
                $idEspecialidad = $idEspecialidad=$this->ejecutarConsulta("SELECT e.id
                                                                           FROM especialidades e
                                                                           JOIN medicos m
                                                                           ON e.id = m.id_especialidades
                                                                           WHERE m.id = '$idMedico'");
                $idEspecialidad = $idEspecialidad->fetch();
                $idEspecialidad = $idEspecialidad['id']; 

            //Verificando campos obligatorios
            if($nombre=="" || $apellido=="" || $documentacionTipo=="" || $documentacionNumero=="" || $telefono==""
            || $provincia=="" || $usuario=="" || $cuil=="" || $clave1=="" || $clave2=="" || $numeroSegSocial==""
			|| $idMedico=="" || $idEspecialidad==""){
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


            // DIrectorio de IMAGENES
            $img_dir = "../views/photos/";
            //Comprobar si se ha seleccionado una imagen
            // 1- Comprobamos si el archivo TIENE NOMBRE
            // 2- Comprobamos si el archivo TIENE UN TAMAÑO
            if($_FILES['pacienteFoto']['name']!="" && $_FILES['pacienteFoto']['size']>0){

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
                if(mime_content_type($_FILES['pacienteFoto']['tmp_name'])!="image/jpeg" &&
                    mime_content_type($_FILES['pacienteFoto']['tmp_name'])!="image/png"){

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
                if($_FILES['pacienteFoto']['size']/1024>5012){
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
                switch(mime_content_type($_FILES['pacienteFoto']['tmp_name'])){
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
                if(!move_uploaded_file($_FILES['pacienteFoto']['tmp_name'],$img_dir.$foto)){
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
                            "campo_valor"=> $_SESSION['usuario']
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
                            "campo_valor"=> $_SESSION['usuario']
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
                            "campo_valor"=> $_SESSION['usuario']
                        ]
                    ];
                    // 3-2. Registramos los datos de personas
                    $registrar_persona=$this->guardarDatosId("personas",$persona_datos_reg);
                    // 3-3. Seleccionamos el IDPersonas
                    $id_persona = $registrar_persona;


                    // 4-1. Cargamos el array de Documentaciones
                    $documentacion_datos_reg=[
                        [
                            "campo_nombre"=>"numero",
                            "campo_marcador"=>":Numero",
                            "campo_valor"=>$documentacionNumero
                        ],
                        [
                            "campo_nombre"=>"id_personas",
                            "campo_marcador"=>":IdPersonas",
                            "campo_valor"=>$id_persona
                        ],
                        [
                            "campo_nombre"=>"id_tipo_documentacion",
                            "campo_marcador"=>":IdTipoDocumentacion",
                            "campo_valor"=>$documentacionTipo
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
                            "campo_valor"=> $_SESSION['usuario']
                        ]
                    ];
                    // 4-2. Registramos los datos de Documentaciones
                    $registrar_documentacion=$this->guardarDatos("documentaciones",$documentacion_datos_reg);
    
    
                    // 5-1. Cargamos el array de USUARIOS
                    $usuario_datos_reg=[
                        [
                            "campo_nombre"=>"nombre_usuario",
                            "campo_marcador"=>":NombreUsuario",
                            "campo_valor"=>$usuario
                        ],
                        [
                            "campo_nombre"=>"clave",
                            "campo_marcador"=>":Clave",
                            "campo_valor"=>$clave
                        ],
                        [
                            "campo_nombre"=>"foto",
                            "campo_marcador"=>":Foto",
                            "campo_valor"=>$foto
                        ],
                        [
                            "campo_nombre"=>"id_tipo_usuarios",
                            "campo_marcador"=>":idTipoUsuarios",
                            "campo_valor"=>4
                        ],
                        [
                            "campo_nombre"=>"id_personas",
                            "campo_marcador"=>":idPersonas",
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
                            "campo_valor"=> $_SESSION['usuario']
                        ]
                    ];
                    // 5-2. Registramos los datos de usuarios
                    $registrar_usuario=$this->guardarDatosClave("usuarios",$usuario_datos_reg);

                    // 6-1. Cargamos el array de Paciente
                    $paciente_datos_reg=[
                        [
                            "campo_nombre"=>"id_personas",
                            "campo_marcador"=>":idPersonas",
                            "campo_valor"=>$id_persona
                        ],
                        [
                            "campo_nombre"=>"id_tipo_usuarios",
                            "campo_marcador"=>":idTipoUsuarios",
                            "campo_valor"=>4
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
                            "campo_valor"=> $_SESSION['usuario']
                        ]
                    ];
                    // 6-2. Registramos los datos de paciente
                    $registrar_paciente=$this->guardarDatosId("pacientes",$paciente_datos_reg);
                    // 3-3. Seleccionamos el IDPersonas
                    $id_paciente = $registrar_paciente;

				// 7-1. Cargamos el array de ADMINISTRATIVO
				$paciente_medico_datos_reg=[
                    [
						"campo_nombre"=>"id_pacientes",
						"campo_marcador"=>":idPacientes",
						"campo_valor"=>$id_paciente
					],
					[
						"campo_nombre"=>"id_medicos",
						"campo_marcador"=>":idMedicos",
						"campo_valor"=>$idMedico
					],
                    [
						"campo_nombre"=>"id_especialidades",
						"campo_marcador"=>":idEspecialidades",
						"campo_valor"=>$idEspecialidad
					],
                    [
						"campo_nombre"=>"fecha_creacion",
						"campo_marcador"=>":FechaCreacion",
						"campo_valor"=>date("Y-m-d H:i:s")
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
				// 8-2. Registramos los datos de ADMINISTRATIVO
				$registrar_pacientes_medicos=$this->guardarDatos("pacientes_medicos",$paciente_medico_datos_reg);

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

            if($registrar_pacientes_medicos->rowCount()==1){
			 	$alerta=[
			 		"tipo"=>"limpiar",
			 		"titulo"=>"Paciente Registrado!",
			 		"texto"=>"El paciente ".$nombre." ".$apellido." se registro con exito",
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
			 		"texto"=>"No se pudo registrar el paciente, por favor intente nuevamente",
					"icono"=>"error"
			 	];
			}

			 return json_encode($alerta);
        }

		//Controlador para lista
		public function listarPacienteControlador($pagina,$registros,$url,$busqueda){

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
				$consulta_datos = "SELECT a.id idAdministrativo, u.id idUsuario, p.nombre Nombre, p.apellido Apellido, u.nombre_usuario Usuario,
								   a.sector Sector, a.fecha_creacion FechaCreacion 
								   FROM administrativos a
								   JOIN personas p
								   ON p.id = a.id_personas
								   JOIN usuarios u
								   ON p.id = u.id_personas
								   WHERE a.flag_mostrar = 1  AND p.nombre LIKE '%$busqueda%' OR p.apellido LIKE '%$busqueda%' OR u.nombre_usuario LIKE '%$busqueda%'
                          		   ORDER BY p.nombre ASC LIMIT $inicio,$registros";

				$consulta_total = "SELECT count(a.id) 
								   FROM administrativos a
								   JOIN personas p
								   ON p.id = a.id_personas
								   JOIN usuarios u
								   ON p.id = u.id_personas
								   WHERE a.flag_mostrar = 1  AND p.nombre LIKE '%$busqueda%' OR p.apellido LIKE '%$busqueda%' OR u.nombre_usuario LIKE '%$busqueda%'
                          		   ORDER BY p.nombre ASC LIMIT $inicio,$registros";
			}else{
				$consulta_datos = "SELECT a.id idAdministrativo, u.id idUsuario, p.nombre Nombre, p.apellido Apellido, u.nombre_usuario Usuario,
								   a.sector Sector, a.fecha_creacion FechaCreacion
								   FROM administrativos a
								   JOIN personas p
								   ON p.id = a.id_personas
								   JOIN usuarios u
								   ON p.id = u.id_personas
								   WHERE u.flag_mostrar = 1          
                          		   ORDER BY p.nombre ASC LIMIT $inicio,$registros";

				$consulta_total = "SELECT count(a.id) 
								   FROM administrativos a
								   JOIN personas p
								   ON p.id = a.id_personas
							       JOIN usuarios u
								   ON p.id = u.id_personas
								   WHERE a.flag_mostrar=1";
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
								<th scope="col">Sector</th>
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
                                <td>'.$rows['Sector'].'</td>
								<td>'.date("d-m-Y",strtotime($rows['FechaCreacion'])).'</td>
                                <td>
                                    <a href="'.APP_URL.'adminPhoto/'.$rows['idUsuario'].'/" class="btn btn-secondary">
                                        <i class="fa-solid fa-image"></i>
                                    </a>
                                </td>
								<td>
                                    <a href="'.APP_URL.'adminUpdate/'.$rows['idUsuario'].'/" class="btn btn-success">
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

		//Controlador para eliminar
		public function eliminarPacienteControlador(){
			$id = $this->limpiarCadena($_POST['usuario_id']);

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
			$datos = $this->ejecutarConsulta("SELECT a.id idAdministrativo, p.id idPersona, e.id idEmpleado, c.id idContacto, dir.id idDireccion, d.id idDocumentacion,
                                                     a.sector Sector, a.id idAdministrativo, p.nombre Nombre, p.apellido Apellido, u.foto Foto
                                              FROM administrativos a
                                              JOIN personas p
                                              ON p.id = a.id_personas
                                              JOIN empleados e
                                              ON p.id = e.id_personas
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
                                              WHERE u.id='$id'");

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
                //Capturamos los id necesarios
                $id_contacto = $datos['idContacto'];
                $id_direccion = $datos['idDireccion'];
                $id_persona = $datos['idPersona'];
                $id_documentacion = $datos['idDocumentacion'];
                $id_administrativo = $datos['idAdministrativo'];
                $id_empleado = $datos['idEmpleado'];
                $id_usuario = $id;
			}

            //Eliminamos el contacto
            $eliminar_contacto= $this->eliminarRegistro("contactos","id",$id_contacto);
            //Eliminamos la direccion
            $eliminar_direccion= $this->eliminarRegistro("direcciones","id",$id_direccion);
            //Eliminamos la persona
            $eliminar_persona = $this->eliminarRegistro("personas","id",$id_persona);
            //Eliminamos la documentacion
            $eliminar_documentacion= $this->eliminarRegistro("documentaciones","id",$id_documentacion);
            //Eliminamos el usuario
            $eliminar_usuario = $this->eliminarRegistro("usuarios","id",$id_usuario);
            //Eliminamos el empleado
            $eliminar_empleado= $this->eliminarRegistro("empleados","id",$id_empleado);
            //Eliminamos el administrativo
            $eliminar_administrativo= $this->eliminarRegistro("administrativos","id",$id_administrativo);

			if($eliminar_administrativo->rowCount()==1){

				if(is_file("../views/photos/".$datos['Foto'])){
					chmod("../views/photos/".$datos['Foto'],0777);
					unlink("../views/photos/".$datos['Foto']);
				}

				$alerta=[
					"tipo"=>"recargar",
					"titulo"=>"Administrativo eliminado",
					"texto"=>"El administrativo ".$datos['Nombre']." ".$datos['Apellido']." se eliminó con exito",
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

            /*----------  Controlador actualizar  ----------*/
            public function actualizarPacienteControlador(){
    
                $id=$this->limpiarCadena($_POST['paciente_id']);
    
                # Verificando usuario #
                $datos=$this->ejecutarConsulta("SELECT pa.id idPacientes, p.id idPersonas, u.id idUsuarios, c.id idContactos, dir.id idDirecciones, d.id idDocumentaciones,
													concat(p.nombre,' ',p.apellido) nombreApellido, pa.fecha_creacion FechaCreacion, pro.nombre Provincia,
                                                    aes_decrypt(u.clave,'PEPE') Clave, pame.id idPacienteMedico, pame.id_medicos idMedico
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
                                                WHERE pa.id = '$id'");
                
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
                    $id_contacto = $datos['idContactos'];
                    $id_direccion = $datos['idDirecciones'];
                    $id_persona = $datos['idPersonas'];
                    $id_usuario = $datos['idUsuarios'];
                    $id_paciente_medico_up = $datos['idPacienteMedico'];
                }
    
                //ALmacenando los datos que vienen de la vista
                //Persona
                $nombre = $this->limpiarCadena($_POST['pacienteNombre']);
                $apellido = $this->limpiarCadena($_POST['pacienteApellido']);
                $documentacionTipo = $this->limpiarCadena($_POST['pacienteDocumentacionTipo']);
                $documentacionNumero = $this->limpiarCadena($_POST['pacienteDocumentacionNumero']);
                $cuil = $this->limpiarCadena($_POST['pacienteCuil']);
                $numeroSegSocial = $this->limpiarCadena($_POST['pacienteNumeroSegSocial']);
                //Usuario
                $usuario = $this->limpiarCadena($_POST['pacienteUsuario']);
                $clave1 = $this->limpiarCadena($_POST['pacienteClave1']);
                $clave2 = $this->limpiarCadena($_POST['pacienteClave2']);
                //Contacto
                $correo = $this->limpiarCadena($_POST['pacienteCorreo']);
                $telefono = $this->limpiarCadena($_POST['pacienteTelefono']);
                //Direccion
                $calle = $this->limpiarCadena($_POST['pacienteCalle']);
                $barrio = $this->limpiarCadena($_POST['pacienteBarrio']);
                $provincia = $this->limpiarCadena($_POST['pacienteProvincia']);
                //Administrativo
                $idMedico = $this->limpiarCadena($_POST['pacienteMedico']);

                $especialidad=$this->ejecutarConsulta("SELECT e.id idEspecialidad
                                                       FROM especialidades e
                                                       JOIN medicos m
                                                       ON e.id = m.id_especialidades
                                                       WHERE m.id = '$idMedico'");
                $especialidad=$especialidad->fetch();
                $idEspecialidad = $especialidad['idEspecialidad'];


                //Verificando campos obligatorios
                if($nombre=="" || $apellido=="" || $documentacionTipo=="" || $documentacionNumero=="" || $telefono==""
                || $provincia=="" || $usuario=="" || $cuil=="" || $numeroSegSocial==""
                || $idMedico==""){
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
                if($this->verificarDatos("[a-zA-Z0-9]{8,40}",$documentacionNumero)){
                    $alerta=[
                        "tipo"=>"simple",
                        "titulo"=>"Ocurrió un error inesperado",
                        "texto"=>"El NÚMERO DE DOCUMENTACIÓN no coincide con el formato solicitado",
                        "icono"=>"error"
                    ];
                    return json_encode($alerta);
                    exit();
                }
                if($this->verificarDatos("[0-9]{11,20}",$cuil)){
                    $alerta=[
                        "tipo"=>"simple",
                        "titulo"=>"Ocurrió un error inesperado",
                        "texto"=>"El CUIL no coincide con el formato solicitado",
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
                            "texto"=>"Las CLAVES no coinciden, por favor verifique e intente nuevamente",
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
                    
                    // Cargamos el array de Documentaciones
                    $documentacion_datos_up=[
                        [
                            "campo_nombre"=>"numero",
                            "campo_marcador"=>":Numero",
                            "campo_valor"=>$documentacionNumero
                        ],
                        [
                            "campo_nombre"=>"id_tipo_documentacion",
                            "campo_marcador"=>":IdTipoDocumentacion",
                            "campo_valor"=>$documentacionTipo
                        ],
                        [
                            "campo_nombre"=>"ultima_modificacion",
                            "campo_marcador"=>":UltimaModificacion",
                            "campo_valor"=>date("Y-m-d H:i:s")
                        ],
                        [
                            "campo_nombre"=>"usuario",
                            "campo_marcador"=>":Usuario",
                            "campo_valor"=> $_SESSION['usuario']
                        ]
                    ];
                    $condicion_documentacion=[
                        "condicion_campo"=>"id_personas",
                        "condicion_marcador"=>":ID",
                        "condicion_valor"=>$id_persona
                    ];
                    $ac_documentacion=$this->actualizarDatos("documentaciones",$documentacion_datos_up,$condicion_documentacion);


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
                            "campo_valor"=>$clave
                        ],
                        [
                            "campo_nombre"=>"ultima_modificacion",
                            "campo_marcador"=>":UltimaModificacion",
                            "campo_valor"=>date("Y-m-d H:i:s")
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

                            // 5-1. Cargamos el array de paciente_medico
                            $paciente_medico_datos_up=[
                                [
                                    "campo_nombre"=>"id_medicos",
                                    "campo_marcador"=>":idMedicos",
                                    "campo_valor"=>$idMedico
                                ],
                                [
                                    "campo_nombre"=>"id_especialidades",
                                    "campo_marcador"=>":idEspecialidades",
                                    "campo_valor"=>$idEspecialidad
                                ],
                                [
                                    "campo_nombre"=>"ultima_modificacion",
                                    "campo_marcador"=>":UltimaModificacion",
                                    "campo_valor"=>date("Y-m-d H:i:s")
                                ],
                                [
                                    "campo_nombre"=>"usuario",
                                    "campo_marcador"=>":Usuario",
                                    "campo_valor"=> $_SESSION['usuario']
                                ]
                            ];
                            $condicion_paciente_medico=[
                                "condicion_campo"=>"id",
                                "condicion_marcador"=>":ID",
                                "condicion_valor"=>$id_paciente_medico_up
                            ];
                            $ac_paciente=$this->actualizarDatos("pacientes_medicos",$paciente_medico_datos_up,$condicion_paciente_medico);
                    
                    
                    if($id_usuario==$_SESSION['id']){
                        $_SESSION['nombre']=$nombre." ".$apellido;
                        $_SESSION['usuario']=$usuario;
                    }

                    $alerta=[
                        "tipo"=>"recargar",
                        "titulo"=>"Paciente actualizado",
                        "texto"=>"Los datos se actualizaron correctamente",
                        "icono"=>"success"
                    ];
                    
                }catch(PDOException $exc){
                    $mensaje_error =  $exc->getMessage();
                    $alerta=[
                        "tipo"=>"simple",
                        "titulo"=>"Ocurrió un error inesperado",
                        "texto"=>$mensaje_error,
                        "icono"=>"error"
                    ];
                    return json_encode($alerta);
                    exit();  
                }
                return json_encode($alerta);
            }

            //Controlador para lista avanzada
            public function listarPacienteAvanzadoControlador($pagina,$registros,$url,$busqueda){
    
                $pagina = $this->limpiarCadena($pagina);
                $registros = $this->limpiarCadena($registros);
    
                $url = $this->limpiarCadena($url);
                $url = APP_URL.$url."/";

                if($busqueda[0]==''){$aKeyword='';}else{$aKeyword = explode(" ",$busqueda[0]);}

                if($busqueda[1]==''){$provinciaFil='';}else{$provinciaFil = $busqueda[1];}

                if($busqueda[2]==''){$ordenarPorFil='';}else{$ordenarPorFil = $busqueda[2];}

                if($busqueda[3]==''){$medicosFil='';}else{$medicosFil = $busqueda[3];}

                if($busqueda[4]==''){$especialidadesFil='';}else{$especialidadesFil = $busqueda[4];}
				// echo $ordenarPorFil;
				// exit();
                //Preguntamos si todos los filtros vienen vacios
                if($aKeyword=='' && $provinciaFil=='' && $ordenarPorFil=='' && $medicosFil=='' && $especialidadesFil==''){
                    //echo "Prueba ".$provinciaFil;
                    //exit();
                    $query = "SELECT pa.id idPacientes, p.id idPersonas, u.id idUsuarios, c.id idContactos, dir.id idDirecciones, d.id idDocumentaciones,
                                    concat(p.nombre,' ',p.apellido) nombreApellido, pa.fecha_creacion FechaCreacion, 
                                    pro.nombre Provincia, pame.id_medicos idMedicos, m.numero_colegiado nroMedico, e.descripcion Especialidad
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
                                ON e.id = m.id_especialidades
                                WHERE pa.flag_mostrar = 1";

                    $consulta_total = "SELECT count(pa.id) 
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
                                        ON e.id = m.id_especialidades
										WHERE pa.flag_mostrar = 1";
                    
                }else{
					// echo "Prueba ".$ordenarPorFil;
                    // exit();
                    //Generamos la consulta total
                    $query = "SELECT pa.id idPacientes, p.id idPersonas, u.id idUsuarios, c.id idContactos, dir.id idDirecciones, d.id idDocumentaciones,
                                    concat(p.nombre,' ',p.apellido) nombreApellido, pa.fecha_creacion FechaCreacion, 
                                    pro.nombre Provincia, pame.id_medicos idMedicos, m.numero_colegiado nroMedico, e.descripcion Especialidad
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
                                ON e.id = m.id_especialidades
                                WHERE pa.flag_mostrar = 1";

                    $consulta_total = "SELECT count(pa.id) 
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
                                        ON e.id = m.id_especialidades
										WHERE pa.flag_mostrar = 1";

                    //Si la variable de texto es distinta a una cadena vacia
                    if($aKeyword!=''){
						//  echo "Prueba ".$ordenarPorFil;
                    	//  exit();
                        //Concatena a la query los filtros de busqueda textual
                        $query.=" AND (p.nombre LIKE '%".$aKeyword[0]."%' OR p.apellido LIKE '%".$aKeyword[0]."%') ";

                        $consulta_total.=" AND (p.nombre LIKE '%".$aKeyword[0]."%' OR p.apellido LIKE '%".$aKeyword[0]."%') ";

                        //recorremos la busqueda textual por si hay mas de una palabra
                        for($i=1; $i< count($aKeyword); $i++){
                            if(!empty($aKeyword[$i])){
                                $query.=" AND (p.nombre LIKE '%".$aKeyword[$i]."%' OR p.apellido LIKE '%".$aKeyword[$i]."%') ";

                                $consulta_total.=" AND (p.nombre LIKE '%".$aKeyword[$i]."%' OR p.apellido LIKE '%".$aKeyword[$i]."%') ";
                            }
                        }
                    }

                }
				// echo $query;
				// exit();
				if($provinciaFil!=''){
                    $query.=" AND pro.id = '$provinciaFil' ";
                    $consulta_total.=" AND pro.id = '$provinciaFil' ";
                }

                if($medicosFil!=''){
                    $query.=" AND pame.id_medicos = '$medicosFil' ";
                    $consulta_total.=" AND pame.id_medicos = '$medicosFil' ";
                }

                if($especialidadesFil!=''){
                    $query.=" AND pame.id_especialidades = '$especialidadesFil' ";
                    $consulta_total.=" AND pame.id_especialidades = '$especialidadesFil' ";
                }

				if($ordenarPorFil == 1){
                    $query.=" ORDER BY p.nombre ASC ";
                    $consulta_total.=" ORDER BY p.nombre ASC ";
                }

                if($ordenarPorFil == 2){
                    $query.=" ORDER BY p.fecha_creacion DESC ";
                    $consulta_total.=" ORDER BY p.fecha_creacion DESC ";
                }

                if($ordenarPorFil == 3){
                    $query.=" ORDER BY p.fecha_creacion ASC ";
                    $consulta_total.=" ORDER BY p.fecha_creacion ASC ";
                }
				if($ordenarPorFil == 4){
                    $query.=" ORDER BY pro.nombre ASC ";
                    $consulta_total.=" ORDER BY pro.nombre ASC ";
                }

				//  echo $query;
				//  exit();

                $tabla = "";
    
                //Operador ternario : Se coloca una condicion entre parentesis,
                // si la condicion devuelve true se ejecuta lo que esta despues del signo de interrogacion7
                // y antes de los dos puntos, sino ejecuta lo que esta al final
                $pagina = (isset($pagina) && $pagina>0) ? (int) $pagina : 1;
    
                // Nos va a indicar desde que numero empezar a contar cuando recorramos el array
                // que carga la tabla
                $inicio = ($pagina>0) ? (($pagina * $registros) - $registros) : 0 ;

                $query.=" LIMIT $inicio,$registros ";
                
                $datos = $this->ejecutarConsulta($query);
                $datos = $datos->fetchAll();
                $_SESSION['tablaPaciente'] = $datos;
                $total = $this->ejecutarConsulta($consulta_total);
                $total = (int) $total->fetchColumn();

                $Npaginas = ceil($total/$registros);
    
                $tabla.='
                    <div class="card-body table-responsive p-0" style="height: 300px;">
                        <table class="table table-sm table-head-fixed text-nowrap text-center table-striped table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nombre y Apellido</th>
                                    <th scope="col">Número de Médico</th>
                                    <th scope="col">Especialidad</th>
                                    <th scope="col">Provincia</th>
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
                                    <td>'.$rows['nombreApellido'].'</td>
                                    <td>'.$rows['nroMedico'].'</td>
                                    <td>'.$rows['Especialidad'].'</td>
                                    <td>'.$rows['Provincia'].'</td>
                                    <td>'.date("d-m-Y",strtotime($rows['FechaCreacion'])).'</td>
                                    <td>
                                        <a href="'.APP_URL.'patientPhoto/'.$rows['idUsuarios'].'/" class="btn btn-secondary">
                                            <i class="fa-solid fa-image"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="'.APP_URL.'patientUpdate/'.$rows['idUsuarios'].'/" class="btn btn-success">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <form class="FormularioAjax" action="'.APP_URL.'app/ajax/patientAjax.php" method="post" autocomplete="off">
                                            <input type="hidden" name="modulo_paciente" value="eliminar">
                                            <input type="hidden" name="usuario_id" value="'.$rows['idUsuarios'].'">
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
    }



?>