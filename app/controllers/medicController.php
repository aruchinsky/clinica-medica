<?php
    namespace app\controllers;
    use app\models\mainModel;
    use \PDOException;

class medicController extends mainModel{

            //CONTROLADOR PARA REGISTRAR 
            public function registrarMedicoControlador(){

                //ALmacenando los datos que vienen de la vista
                //Persona
                $nombre = $this->limpiarCadena($_POST['medicoNombre']);
                $apellido = $this->limpiarCadena($_POST['medicoApellido']);
                $documentacionTipo = $this->limpiarCadena($_POST['medicoDocumentacionTipo']);
                $documentacionNumero = $this->limpiarCadena($_POST['medicoDocumentacionNumero']);
                $cuil = $this->limpiarCadena($_POST['medicoCuil']);
                $numeroSegSocial = $this->limpiarCadena($_POST['medicoNumeroSegSocial']);
                //Usuario
                $usuario = $this->limpiarCadena($_POST['medicoUsuario']);
                $clave1 = $this->limpiarCadena($_POST['medicoClave1']);
                $clave2 = $this->limpiarCadena($_POST['medicoClave2']);
                //Contacto
                $correo = $this->limpiarCadena($_POST['medicoCorreo']);
                $telefono = $this->limpiarCadena($_POST['medicoTelefono']);
                //Direccion
                $calle = $this->limpiarCadena($_POST['medicoCalle']);
                $barrio = $this->limpiarCadena($_POST['medicoBarrio']);
                $provincia = $this->limpiarCadena($_POST['medicoProvincia']);
                //Medico
                $claveSegSocial = $this->limpiarCadena($_POST['medicoClaveSegSocial']);
                $numeroColegiado = $this->limpiarCadena($_POST['medicoNumeroColegiado']);
                $especialidades = $this->limpiarCadena($_POST['medicoEspecialidades']);
                $situacion_revista = $this->limpiarCadena($_POST['medicoSituacionRevista']);
    
                //Verificando campos obligatorios
                if($nombre=="" || $apellido=="" || $documentacionTipo=="" || $documentacionNumero=="" || $telefono==""
                || $provincia=="" || $usuario=="" || $cuil=="" || $clave1=="" || $clave2=="" || $numeroSegSocial==""
                || $claveSegSocial=="" || $claveSegSocial=="" || $numeroColegiado=="" || $especialidades==""
                || $situacion_revista==""){
                    //Definimos todo los valores de un array para la alerta
                    $alerta = [
                        "tipo" => "simple",
                        "titulo" => "Ocurrió un error inesperado",
                        "texto" => "No has completado todos los datos que son obligatorios.",
                        "icono" => "error",
    
                    ];
                    //Devolvemos el array codificado en JSON
                    return json_encode($alerta);
                    exit();
                }
    
                //Verificando la integridad de los datos
                if($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,25}",$nombre)){
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
                if($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,25}",$apellido)){
                    $alerta=[
                        "tipo"=>"simple",
                        "titulo"=>"Ocurrió un error inesperado",
                        "texto"=>"El APELLIDO no coincide con el formato solicitado",
                        "icono"=>"error"
                    ];
                    return json_encode($alerta);
                    exit();
                }
                if($this->verificarDatos("[a-zA-Z0-9]{8,15}",$documentacionNumero)){
                    //Definimos todo los valores de un array para la alerta
                    $alerta = [
                        "tipo" => "simple",
                        "titulo" => "Ocurrió un error inesperado",
                        "texto" => "El número de documentación no coincide con el formato solicitado",
                        "icono" => "error",
    
                    ];
                    //Devolvemos el array codificado en JSON
                    return json_encode($alerta);
                    exit();
                }
                if($this->verificarDatos("[0-9]{11,20}",$cuil)){
                    //Definimos todo los valores de un array para la alerta
                    $alerta = [
                        "tipo" => "simple",
                        "titulo" => "Ocurrió un error inesperado",
                        "texto" => "El número de cuil no coincide con el formato solicitado",
                        "icono" => "error",
    
                    ];
                    //Devolvemos el array codificado en JSON
                    return json_encode($alerta);
                    exit();
                }
                if($this->verificarDatos("[0-9]{7,10}",$numeroSegSocial)){
                    //Definimos todo los valores de un array para la alerta
                    $alerta = [
                        "tipo" => "simple",
                        "titulo" => "Ocurrió un error inesperado",
                        "texto" => "El número de seguro social no coincide con el formato solicitado",
                        "icono" => "error",
    
                    ];
                    //Devolvemos el array codificado en JSON
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
                if($this->verificarDatos("[0-9]{10,10}",$telefono)){
                    $alerta=[
                        "tipo"=>"simple",
                        "titulo"=>"Ocurrió un error inesperado",
                        "texto"=>"El telefono no coincide con el formato solicitado",
                        "icono"=>"error"
                    ];
                    return json_encode($alerta);
                    exit();
                }
                if($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9 ]{7,20}",$calle)){
                    $alerta=[
                        "tipo"=>"simple",
                        "titulo"=>"Ocurrió un error inesperado",
                        "texto"=>"La calle no coincide con el formato solicitado",
                        "icono"=>"error"
                    ];
                    return json_encode($alerta);
                    exit();
                }
                if($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9 ]{7,20}",$barrio)){
                    $alerta=[
                        "tipo"=>"simple",
                        "titulo"=>"Ocurrió un error inesperado",
                        "texto"=>"El barrio no coincide con el formato solicitado",
                        "icono"=>"error"
                    ];
                    return json_encode($alerta);
                    exit();
                }
                if($this->verificarDatos("[0-9]{7,20}",$claveSegSocial)){
                    $alerta=[
                        "tipo"=>"simple",
                        "titulo"=>"Ocurrió un error inesperado",
                        "texto"=>"La clave de seguridad social no coincide con el formato solicitado",
                        "icono"=>"error"
                    ];
                    return json_encode($alerta);
                    exit();
                }
                if($this->verificarDatos("[0-9]{9,9}",$numeroColegiado)){
                    $alerta=[
                        "tipo"=>"simple",
                        "titulo"=>"Ocurrió un error inesperado",
                        "texto"=>"El número de colegiado no coincide con el formato solicitado",
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
                if($_FILES['medicoFoto']['name']!="" && $_FILES['medicoFoto']['size']>0){
    
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
                    if(mime_content_type($_FILES['medicoFoto']['tmp_name'])!="image/jpeg" &&
                        mime_content_type($_FILES['medicoFoto']['tmp_name'])!="image/png"){
    
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
                    if($_FILES['medicoFoto']['size']/1024>5012){
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
                    switch(mime_content_type($_FILES['medicoFoto']['tmp_name'])){
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
                    if(!move_uploaded_file($_FILES['medicoFoto']['tmp_name'],$img_dir.$foto)){
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
                            "campo_valor"=>3
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
    
    
                    // 6-1. Cargamos el array de Medico
                    $medico_datos_reg=[
                        [
                            "campo_nombre"=>"clave_seguridad_social",
                            "campo_marcador"=>":ClaveSeguridadSocial",
                            "campo_valor"=>$claveSegSocial
                        ],
                        [
                            "campo_nombre"=>"numero_colegiado",
                            "campo_marcador"=>":NumeroColegiado",
                            "campo_valor"=>$numeroColegiado
                        ],
                        [
                            "campo_nombre"=>"id_personas",
                            "campo_marcador"=>":idPersonas",
                            "campo_valor"=>$id_persona
                        ],
                        [
                            "campo_nombre"=>"id_especialidades",
                            "campo_marcador"=>":idEspecialidades",
                            "campo_valor"=>$especialidades
                        ],
                        [
                            "campo_nombre"=>"id_situacion_revista",
                            "campo_marcador"=>":idSituacionRevista",
                            "campo_valor"=>$situacion_revista
                        ],
                        [
                            "campo_nombre"=>"id_tipo_empleados",
                            "campo_marcador"=>":idTipoEmpleados",
                            "campo_valor"=>2
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
                    // 6-2. Registramos los datos de Medico
                    $registrar_medico=$this->guardarDatos("medicos",$medico_datos_reg);

                    // 7-1. Cargamos el array de Empleados
                    $empleado_datos_reg=[
                        [
                            "campo_nombre"=>"id_personas",
                            "campo_marcador"=>":idPersonas",
                            "campo_valor"=>$id_persona
                        ],
                        [
                            "campo_nombre"=>"id_tipo_empleados",
                            "campo_marcador"=>":idTipoEmpleados",
                            "campo_valor"=>2
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
                    // 7-2. Registramos los datos de Empleado
                    $registrar_empleado=$this->guardarDatos("empleados",$empleado_datos_reg);
    
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
    
                if($registrar_empleado->rowCount()==1){
                     $alerta=[
                         "tipo"=>"limpiar",
                         "titulo"=>"Medico registrado",
                         "texto"=>"El medico ".$nombre." ".$apellido." se registro con exito",
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
                         "texto"=>"No se pudo registrar el medico, por favor intente nuevamente",
                        "icono"=>"error"
                     ];
                }
    
                 return json_encode($alerta);
            }
    
            //Controlador para lista avanzada
            public function listarMedicoAvanzadoControlador($pagina,$registros,$url,$busqueda){
    
                $pagina = $this->limpiarCadena($pagina);
                $registros = $this->limpiarCadena($registros);
    
                $url = $this->limpiarCadena($url);
                $url = APP_URL.$url."/";
    
                //$busqueda = $this->limpiarCadena($busqueda);

                //Dividimos los filtros
                // $aKeyword = explode(" ",$busqueda[0]);
                // $provinciaFil = $busqueda[1];
                // $especialidadFil = $busqueda[2];
                // $situacionRevistaFil = $busqueda[3];
                // $ordenarPorFil = $busqueda[4];

                if(!isset($busqueda[0])){$aKeyword='';}else{$aKeyword = explode(" ",$busqueda[0]);}
                if(!isset($busqueda[1])){$provinciaFil='';}else{$provinciaFil = $busqueda[1];}
                if(!isset($busqueda[2])){$especialidadFil='';}else{$especialidadFil = $busqueda[2];}
                if(!isset($busqueda[3])){$situacionRevistaFil='';}else{$situacionRevistaFil = $busqueda[3];}
                if(!isset($busqueda[4])){$ordenarPorFil='';}else{$ordenarPorFil = $busqueda[4];}

                //Preguntamos si todos los filtros vienen vacios
                if($aKeyword=='' && $provinciaFil=='' && $especialidadFil=='' && $situacionRevistaFil=='' && $ordenarPorFil==''){
                    //  echo "Prueba ".$provinciaFil;
                    //  exit();
                    $query = "SELECT m.id idMedicos, p.id idPersonas, u.id idUsuarios, c.id idContactos, dir.id idDirecciones, d.id idDocumentaciones, sr.id idSituacionRevista, e.id idEspecialidades,
                                m.clave_seguridad_social claveSegSocial, m.numero_colegiado numColegiado, sr.descripcion situacionRevista, e.descripcion especialidades,
                                concat(p.nombre,' ',p.apellido) nombreApellido, m.fecha_creacion FechaCreacion, pro.nombre Provincia
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
                              JOIN usuarios u
                              ON p.id = u.id_personas
                              WHERE m.flag_mostrar = 1";

                    $consulta_total = "SELECT count(m.id) 
								       FROM medicos m
                                       WHERE m.flag_mostrar = 1";
                    
                }else{
                    //Generamos la consulta total
                    $query = "SELECT m.id idMedicos, p.id idPersonas, u.id idUsuarios, c.id idContactos, dir.id idDirecciones, d.id idDocumentaciones, sr.id idSituacionRevista, e.id idEspecialidades,
                                m.clave_seguridad_social claveSegSocial, m.numero_colegiado numColegiado, sr.descripcion situacionRevista, e.descripcion especialidades,
                                concat(p.nombre,' ',p.apellido) nombreApellido, m.fecha_creacion FechaCreacion, pro.nombre Provincia
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
                            JOIN usuarios u
                            ON p.id = u.id_personas
                            WHERE m.flag_mostrar = 1";

                    $consulta_total = "SELECT count(m.id) 
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
                                       JOIN usuarios u
                                       ON p.id = u.id_personas
                                       WHERE m.flag_mostrar = 1";

                    //Si la variable de texto es distinta a una cadena vacia
                    if($aKeyword!=''){
                        //Concatena a la query los filtros de busqueda textual
                        $query.=" AND (p.nombre LIKE '%".$aKeyword[0]."%' OR p.apellido LIKE '%".$aKeyword[0]."%')";

                        $consulta_total.=" AND (p.nombre LIKE '%".$aKeyword[0]."%' OR p.apellido LIKE '%".$aKeyword[0]."%')";

                        //recorremos la busqueda textual por si hay mas de una palabra
                        for($i=1; $i< count($aKeyword); $i++){
                            if(!empty($aKeyword[$i])){
                                $query.=" AND (p.nombre LIKE '%".$aKeyword[$i]."%' OR p.apellido LIKE '%".$aKeyword[$i]."%')";

                                $consulta_total.=" AND (p.nombre LIKE '%".$aKeyword[$i]."%' OR p.apellido LIKE '%".$aKeyword[$i]."%')";
                            }
                        }
                    }

                }

                if($provinciaFil!=''){
                    $query.=" AND pro.id = '$provinciaFil' ";
                    $consulta_total.=" AND pro.id = '$provinciaFil' ";
                }

                if($especialidadFil!=''){
                    $query.=" AND e.id = '$especialidadFil' ";
                    $consulta_total.=" AND e.id = '$especialidadFil' ";
                }

                if($situacionRevistaFil!=''){
                    $query.=" AND sr.id = '$situacionRevistaFil' ";
                    $consulta_total.=" AND sr.id = '$situacionRevistaFil' ";
                }

                if($ordenarPorFil == 1){
                    $query.=" ORDER BY p.nombre ASC ";
                    $consulta_total.=" ORDER BY p.nombre ASC ";
                }

                if($ordenarPorFil == 2){
                    $query.=" ORDER BY m.fecha_creacion DESC ";
                    $consulta_total.=" ORDER BY m.fecha_creacion DESC ";
                }

                if($ordenarPorFil == 3){
                    $query.=" ORDER BY m.fecha_creacion ASC ";
                    $consulta_total.=" ORDER BY m.fecha_creacion ASC ";
                }

                if($ordenarPorFil == 4){
                    $query.=" ORDER BY sr.descripcion ASC ";
                    $consulta_total.=" ORDER BY sr.descripcion ASC ";
                }

                if($ordenarPorFil == 5){
                    $query.=" ORDER BY e.descripcion ASC ";
                    $consulta_total.=" ORDER BY e.descripcion ASC ";
                }

                if($ordenarPorFil == 6){
                    $query.=" ORDER BY pro.nombre ASC ";
                    $consulta_total.=" ORDER BY pro.nombre ASC ";
                }

                // echo $ordenarPorFil;
                // exit();

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
                $_SESSION['tablaMedicos'] = $datos;
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
                                    <th scope="col">Especialidad</th>
                                    <th scope="col">Situacion de Revista</th>
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
                                    <td>'.$rows['especialidades'].'</td>
                                    <td>'.$rows['situacionRevista'].'</td>
                                    <td>'.$rows['Provincia'].'</td>
                                    <td>'.date("d-m-Y",strtotime($rows['FechaCreacion'])).'</td>
                                    <td>
                                        <form class="" action="'.APP_URL.'medicUpdate/'.$rows['idUsuarios'].'/" method="post" autocomplete="off">
                                            <button type="submit" class="btn btn-sm btn-secondary">
                                                Administrar
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

            // Filtrado de Especialidades
            public function listarMedicoAvanzadoEspecialidad($pagina, $registros, $url, $busqueda){
    
                $pagina = $this->limpiarCadena($pagina);
                $registros = $this->limpiarCadena($registros);
            
                $url = $this->limpiarCadena($url);
                $url = APP_URL.$url."/";
            
                // Dividimos los filtros
                $aKeyword = explode(" ", $busqueda[0]); // Búsqueda por palabra
                $especialidadFil = $busqueda[2]; // Filtro de especialidad
                $ordenarPorFil = $busqueda[4]; // Filtro de ordenado
            
                // Preguntamos si el filtro de especialidad viene vacío
                // if($especialidadFil == ''){
                //     return 'Debe seleccionar una especialidad.';
                // }
            
                $query = "SELECT m.id idMedicos, p.id idPersonas, u.id idUsuarios, c.id idContactos, dir.id idDirecciones, d.id idDocumentaciones, sr.id idSituacionRevista, e.id idEspecialidades,
                            m.clave_seguridad_social claveSegSocial, m.numero_colegiado numColegiado, sr.descripcion situacionRevista, e.descripcion especialidades,
                            concat(p.nombre,' ',p.apellido) nombreApellido, m.fecha_creacion FechaCreacion, pro.nombre Provincia
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
                          JOIN usuarios u
                          ON p.id = u.id_personas
                          WHERE m.flag_mostrar = 1"; // Agregamos el filtro de especialidad
            
                $consulta_total = "SELECT count(m.id) 
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
                                    JOIN usuarios u
                                    ON p.id = u.id_personas
                                   WHERE m.flag_mostrar = 1"; // Agregamos el filtro de especialidad
            
                // Si la variable de texto no es una cadena vacía
                if($aKeyword != ''){
                    $query .= " AND (p.nombre LIKE '%".$aKeyword[0]."%' OR p.apellido LIKE '%".$aKeyword[0]."%')";
                    $consulta_total .= " AND (p.nombre LIKE '%".$aKeyword[0]."%' OR p.apellido LIKE '%".$aKeyword[0]."%')";
            
                    // Recorremos la búsqueda textual por si hay más de una palabra
                    for($i = 1; $i < count($aKeyword); $i++){
                        if(!empty($aKeyword[$i])){
                            $query .= " AND (p.nombre LIKE '%".$aKeyword[$i]."%' OR p.apellido LIKE '%".$aKeyword[$i]."%')";
                            $consulta_total .= " AND (p.nombre LIKE '%".$aKeyword[$i]."%' OR p.apellido LIKE '%".$aKeyword[$i]."%')";
                        }
                    }
                }

                if($especialidadFil!=''){
                    $query.=" AND e.id = '$especialidadFil' ";
                    $consulta_total.=" AND e.id = '$especialidadFil' ";
                }
            
                // Aplicamos los filtros de ordenado
                if($ordenarPorFil == 1){
                    $query .= " ORDER BY p.nombre ASC ";
                    $consulta_total .= " ORDER BY p.nombre ASC ";
                } elseif($ordenarPorFil == 2){
                    $query .= " ORDER BY m.fecha_creacion DESC ";
                    $consulta_total .= " ORDER BY m.fecha_creacion DESC ";
                } elseif($ordenarPorFil == 3){
                    $query .= " ORDER BY m.fecha_creacion ASC ";
                    $consulta_total .= " ORDER BY m.fecha_creacion ASC ";
                } elseif($ordenarPorFil == 4){
                    $query .= " ORDER BY sr.descripcion ASC ";
                    $consulta_total .= " ORDER BY sr.descripcion ASC ";
                } elseif($ordenarPorFil == 5){
                    $query .= " ORDER BY e.descripcion ASC ";
                    $consulta_total .= " ORDER BY e.descripcion ASC ";
                } elseif($ordenarPorFil == 6){
                    $query .= " ORDER BY pro.nombre ASC ";
                    $consulta_total .= " ORDER BY pro.nombre ASC ";
                }
            
                $tabla = "";
            
                $pagina = (isset($pagina) && $pagina > 0) ? (int)$pagina : 1;
                $inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0;
            
                $query .= " LIMIT $inicio, $registros ";
                
                $datos = $this->ejecutarConsulta($query);
                $datos = $datos->fetchAll();
                $_SESSION['tablaMedicos'] = $datos;
                $total = $this->ejecutarConsulta($consulta_total);
                $total = (int) $total->fetchColumn();
            
                $Npaginas = ceil($total/$registros);
            
                $tabla .= '
                    <div class="card-body table-responsive p-0" style="height: 300px;">
                        <table class="table table-sm table-head-fixed text-nowrap text-center table-striped table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nombre y Apellido</th>
                                    <th scope="col">Especialidad</th>
                                    <th scope="col">Situacion de Revista</th>
                                    <th scope="col">Numero de Colegiado</th>
                                    <th scope="col">Provincia</th>
                                    <th scope="col">Fecha de Alta</th>
                                    <th colspan="3" scope="col" style="text-align: center;">Opciones</th>
                                </tr>
                            </thead>
                            <tbody class="table-group-divider">
                ';
            
                if($total >= 1 && $pagina <= $Npaginas){
                    $contador = $inicio + 1;
                    $paginador_inicio = $inicio + 1;
            
                    foreach($datos as $rows){
                        $tabla .= '
                            <tr>
                                <td>'.$contador.'</td>
                                <td>'.$rows['nombreApellido'].'</td>
                                <td>'.$rows['especialidades'].'</td>
                                <td>'.$rows['situacionRevista'].'</td>
                                <td>'.$rows['numColegiado'].'</td>
                                <td>'.$rows['Provincia'].'</td>
                                <td>'.date("d-m-Y", strtotime($rows['FechaCreacion'])).'</td>
                                <td>
                                    <a href="'.APP_URL.'userPhoto/'.$rows['idUsuarios'].'/" class="btn btn-secondary">
                                        <i class="fa-solid fa-image"></i>
                                    </a>
                                </td>
                                <td>
                                    <a href="'.APP_URL.'medicUpdate/'.$rows['idUsuarios'].'/" class="btn btn-success">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                </td>
                                <td>
                                    <form class="FormularioAjax" action="'.APP_URL.'app/ajax/medicAjax.php" method="post" autocomplete="off">
                                        <input type="hidden" name="modulo_medico" value="eliminar">
                                        <input type="hidden" name="usuario_id" value="'.$rows['idUsuarios'].'">
                                        <button type="submit" class="btn btn-danger">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        ';
                        $contador++;
                    }
                    $paginador_final = $contador - 1;
                } else {
                    if($total >= 1){
                        $tabla .= '
                            <tr class="text-center">
                                <td colspan="8">
                                    <a href="'.$url.'1/" class="btn btn-secondary">
                                        Haga clic aquí para recargar el listado
                                    </a>
                                </td>
                            </tr>
                        ';
                    } else {
                        $tabla .= '
                            <tr class="text-center">
                                <td colspan="8">
                                    No hay registros en el sistema
                                </td>
                            </tr>
                        ';
                    }
                }
            
                $tabla .= '
                            </tbody>
                        </table>
                    </div>
                ';
            
                if($total >= 1 && $pagina <= $Npaginas){
                    $tabla .= '
                        <p class="has-text-right">Mostrando usuarios 
                            <strong>'.$paginador_inicio.'</strong> al <strong>'.
                            $paginador_final.'</strong> de un <strong>total de '.$total.'</strong></p>
                    ';
                    $tabla .= $this->paginadorTablas($pagina, $Npaginas, $url, 10);
                }
            
                return $tabla;
            }
    
            //Controlador para lista 
            public function listarMedicoControlador($pagina,$registros,$url,$busqueda){
    
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
                    $consulta_datos = "SELECT m.id idMedicos, p.id idPersonas, u.id idUsuarios, c.id idContactos, dir.id idDirecciones, d.id idDocumentaciones, sr.id idSituacionRevista, e.id idEspecialidades,
                                              m.clave_seguridad_social claveSegSocial, m.numero_colegiado numColegiado, sr.descripcion situacionRevista, e.descripcion especialidades,
                                              concat(p.nombre,' ',p.apellido) nombreApellido, m.fecha_creacion FechaCreacion
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
                                       JOIN documentaciones d
                                       ON p.id = d.id_personas
                                       JOIN tipo_documentacion td
                                       ON td.id = d.id_tipo_documentacion
                                       JOIN usuarios u
                                       ON p.id = u.id_personas
								       WHERE m.flag_mostrar = 1  AND
                                             p.nombre LIKE '%$busqueda%' OR p.apellido LIKE '%$busqueda%' 
                                             OR sr.descripcion LIKE '%$busqueda%' OR e.descripcion LIKE '%$busqueda%'                                            
                          			   ORDER BY p.apellido ASC LIMIT $inicio,$registros";
    
                    $consulta_total = "SELECT count(m.id) 
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
                                       JOIN documentaciones d
                                       ON p.id = d.id_personas
                                       JOIN tipo_documentacion td
                                       ON td.id = d.id_tipo_documentacion
                                       JOIN usuarios u
                                       ON p.id = u.id_personas
								       WHERE m.flag_mostrar = 1  AND
                                             p.nombre LIKE '%$busqueda%' OR p.apellido LIKE '%$busqueda%' 
                                             OR sr.descripcion LIKE '%$busqueda%' OR e.descripcion LIKE '%$busqueda%'                                            
                          			   ORDER BY p.apellido ASC LIMIT $inicio,$registros";
                }else{
                    $consulta_datos = "SELECT m.id idMedicos, p.id idPersonas, u.id idUsuarios, c.id idContactos, dir.id idDirecciones, d.id idDocumentaciones, sr.id idSituacionRevista, e.id idEspecialidades,
                                              m.clave_seguridad_social claveSegSocial, m.numero_colegiado numColegiado, sr.descripcion situacionRevista, e.descripcion especialidades,
                                              concat(p.nombre,' ',p.apellido) nombreApellido, m.fecha_creacion FechaCreacion
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
                                       JOIN documentaciones d
                                       ON p.id = d.id_personas
                                       JOIN tipo_documentacion td
                                       ON td.id = d.id_tipo_documentacion
                                       JOIN usuarios u
                                       ON p.id = u.id_personas
								       WHERE m.flag_mostrar = 1                                            
                          			   ORDER BY p.apellido ASC LIMIT $inicio,$registros";
    
                    $consulta_total = "SELECT count(m.id) 
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
                                       JOIN documentaciones d
                                       ON p.id = d.id_personas
                                       JOIN tipo_documentacion td
                                       ON td.id = d.id_tipo_documentacion
                                       JOIN usuarios u
                                       ON p.id = u.id_personas
								       WHERE m.flag_mostrar = 1 ";
                }
    
                $datos = $this->ejecutarConsulta($consulta_datos);
                $datos = $datos->fetchAll();
    
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
                                    <th scope="col">Especialidad</th>
                                    <th scope="col">Situacion de Revista</th>
                                    <th scope="col">Numero de Colegiado</th>
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
                                    <td>'.$rows['especialidades'].'</td>
                                    <td>'.$rows['situacionRevista'].'</td>
                                    <td>'.$rows['numColegiado'].'</td>
                                    <td>'.date("d-m-Y",strtotime($rows['FechaCreacion'])).'</td>
                                    <td>
                                        <a href="'.APP_URL.'medicPhoto/'.$rows['idUsuarios'].'/" class="btn btn-secondary">
                                            <i class="fa-solid fa-image"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="'.APP_URL.'medicUpdate/'.$rows['idUsuarios'].'/" class="btn btn-success">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <form class="FormularioAjax" action="'.APP_URL.'app/ajax/medicAjax.php" method="post" autocomplete="off">
                                            <input type="hidden" name="modulo_medico" value="eliminar">
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

            //Controlador para eliminar
            public function eliminarMedicoControlador(){
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
    
                //Verificar
                $datos = $this->ejecutarConsulta("SELECT m.id idMedico, p.id idPersona, emp.id idEmpleado, m.numero_colegiado numColegiado, d.id idDocumentacion,
                                                  p.nombre Nombre, p.apellido Apellido, u.foto Foto, c.id idContacto, dir.id idDireccion
                                                FROM medicos m
                                                JOIN especialidades e
                                                ON e.id = m.id_especialidades
                                                JOIN situacion_revista sr
                                                ON sr.id = m.id_situacion_revista
                                                JOIN personas p
                                                ON p.id = m.id_personas
                                                JOIN empleados emp
                                                ON p.id = emp.id_personas
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
                        "texto" => "No hemos encontrado al medico en el sistema.",
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
                    $id_medico = $datos['idMedico'];
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
                //Eliminamos el medico
                $eliminar_medico= $this->eliminarRegistro("medicos","id",$id_medico);

                if($eliminar_medico->rowCount()==1 && $eliminar_persona->rowCount()==1 &&
                    $eliminar_usuario->rowCount()==1 && $eliminar_contacto->rowCount()==1 &&
                    $eliminar_direccion->rowCount()==1 && $eliminar_documentacion->rowCount()==1){
    
                    if(is_file("../views/photos/".$datos['Foto'])){
                        chmod("../views/photos/".$datos['Foto'],0777);
                        unlink("../views/photos/".$datos['Foto']);
                    }
    
                    $alerta=[
                        "tipo"=>"redireccionar",
                        "url"=>APP_URL.'medicSearch/'
                        
                    ];
    
                }else{
                    $alerta=[
                        "tipo"=>"simple",
                        "titulo"=>"Ocurrió un error inesperado",
                        "texto"=>"No se pudo eliminar el medico ".$datos['Nombre']." ".$datos['Apellido'].",
                                  por favor intente nuevamente",
                       "icono"=>"error"
                    ];
                }
                return json_encode($alerta);
            }
    
            /*----------  Controlador actualizar  ----------*/
            public function actualizarMedicoControlador(){
    
                $id=$this->limpiarCadena($_POST['medico_id']);
    
                # Verificando usuario #
                $datos=$this->ejecutarConsulta("SELECT m.id idMedico, u.id idUsuario, c.id idContacto, dir.id idDireccion, p.id idPersona,
                                                        p.nombre Nombre, p.apellido Apellido, p.numero_seg_social numSegSocial,
                                                        p.cuil cuil,td.id idTipoDocumentacion, td.descripcion tipoDocumentacion,d.numero documentacionNumero,
                                                        u.nombre_usuario usuario, aes_decrypt(u.clave, 'PEPE') Clave, m.fecha_creacion fechaCreacion, m.ultima_modificacion ultimaModificacion, 		m.numero_colegiado numeroColegiado, m.clave_seguridad_social claveSegSocial, sr.id idSituacionRevista, sr.descripcion situacionRevista, 	  e.id idEspecialidades, e.descripcion especialidades, c.telefono telefono, c.correo correo, dir.calle calle, dir.barrio barrio
                                                FROM medicos m
                                                JOIN especialidades e
                                                ON e.id = m.id_especialidades
                                                JOIN situacion_revista sr
                                                ON sr.id = m.id_situacion_revista
                                                JOIN personas p
                                                ON p.id = m.id_personas
                                                JOIN empleados emp
                                                ON p.id = emp.id_personas
                                                JOIN contactos c
                                                ON c.id = p.id_contactos
                                                JOIN direcciones dir
                                                ON dir.id = p.id_direcciones
                                                JOIN documentaciones d
                                                ON p.id = d.id_personas
                                                JOIN tipo_documentacion td
                                                ON td.id = d.id_tipo_documentacion
                                                JOIN usuarios u
                                                ON p.id = u.id_personas
                                                WHERE m.id = '$id'");
                
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
                    $id_medico = $datos['idMedico'];
                }
    
                //ALmacenando los datos que vienen de la vista
                //Persona
                $nombre = $this->limpiarCadena($_POST['medicoNombre']);
                $apellido = $this->limpiarCadena($_POST['medicoApellido']);
                $documentacionTipo = $this->limpiarCadena($_POST['medicoDocumentacionTipo']);
                $documentacionNumero = $this->limpiarCadena($_POST['medicoDocumentacionNumero']);
                $cuil = $this->limpiarCadena($_POST['medicoCuil']);
                $numeroSegSocial = $this->limpiarCadena($_POST['medicoNumeroSegSocial']);
                //Usuario
                $usuario = $this->limpiarCadena($_POST['medicoUsuario']);
                $clave1 = $this->limpiarCadena($_POST['medicoClave1']);
                $clave2 = $this->limpiarCadena($_POST['medicoClave2']);
                //Contacto
                $correo = $this->limpiarCadena($_POST['medicoCorreo']);
                $telefono = $this->limpiarCadena($_POST['medicoTelefono']);
                //Direccion
                $calle = $this->limpiarCadena($_POST['medicoCalle']);
                $barrio = $this->limpiarCadena($_POST['medicoBarrio']);
                $provincia = $this->limpiarCadena($_POST['medicoProvincia']);
                //Medico
                $claveSegSocial = $this->limpiarCadena($_POST['medicoClaveSegSocial']);
                $numeroColegiado = $this->limpiarCadena($_POST['medicoNumeroColegiado']);
                $especialidades = $this->limpiarCadena($_POST['medicoEspecialidades']);
                $situacion_revista = $this->limpiarCadena($_POST['medicoSituacionRevista']);
    
                //Verificando campos obligatorios
                if($nombre=="" || $apellido=="" || $documentacionTipo=="" || $documentacionNumero=="" || $telefono==""
                || $provincia=="" || $usuario=="" || $cuil=="" || $numeroSegSocial==""
                || $claveSegSocial=="" || $claveSegSocial=="" || $numeroColegiado==""
                || $especialidades=="" || $situacion_revista==""){
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
                if($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,25}",$nombre)){
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
                if($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,25}",$apellido)){
                    $alerta=[
                        "tipo"=>"simple",
                        "titulo"=>"Ocurrió un error inesperado",
                        "texto"=>"El APELLIDO no coincide con el formato solicitado",
                        "icono"=>"error"
                    ];
                    return json_encode($alerta);
                    exit();
                }
                if($this->verificarDatos("[a-zA-Z0-9]{8,15}",$documentacionNumero)){
                    //Definimos todo los valores de un array para la alerta
                    $alerta = [
                        "tipo" => "simple",
                        "titulo" => "Ocurrió un error inesperado",
                        "texto" => "El número de documentación no coincide con el formato solicitado",
                        "icono" => "error",
    
                    ];
                    //Devolvemos el array codificado en JSON
                    return json_encode($alerta);
                    exit();
                }
                if($this->verificarDatos("[0-9]{11,20}",$cuil)){
                    //Definimos todo los valores de un array para la alerta
                    $alerta = [
                        "tipo" => "simple",
                        "titulo" => "Ocurrió un error inesperado",
                        "texto" => "El número de cuil no coincide con el formato solicitado",
                        "icono" => "error",
    
                    ];
                    //Devolvemos el array codificado en JSON
                    return json_encode($alerta);
                    exit();
                }
                if($this->verificarDatos("[0-9]{7,10}",$numeroSegSocial)){
                    //Definimos todo los valores de un array para la alerta
                    $alerta = [
                        "tipo" => "simple",
                        "titulo" => "Ocurrió un error inesperado",
                        "texto" => "El número de seguro social no coincide con el formato solicitado",
                        "icono" => "error",
    
                    ];
                    //Devolvemos el array codificado en JSON
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
                if($this->verificarDatos("[0-9]{10,10}",$telefono)){
                    $alerta=[
                        "tipo"=>"simple",
                        "titulo"=>"Ocurrió un error inesperado",
                        "texto"=>"El telefono no coincide con el formato solicitado",
                        "icono"=>"error"
                    ];
                    return json_encode($alerta);
                    exit();
                }
                if($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9 ]{7,20}",$calle)){
                    $alerta=[
                        "tipo"=>"simple",
                        "titulo"=>"Ocurrió un error inesperado",
                        "texto"=>"La calle no coincide con el formato solicitado",
                        "icono"=>"error"
                    ];
                    return json_encode($alerta);
                    exit();
                }
                if($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9 ]{7,20}",$barrio)){
                    $alerta=[
                        "tipo"=>"simple",
                        "titulo"=>"Ocurrió un error inesperado",
                        "texto"=>"El barrio no coincide con el formato solicitado",
                        "icono"=>"error"
                    ];
                    return json_encode($alerta);
                    exit();
                }
                if($this->verificarDatos("[0-9]{7,20}",$claveSegSocial)){
                    $alerta=[
                        "tipo"=>"simple",
                        "titulo"=>"Ocurrió un error inesperado",
                        "texto"=>"La clave de seguridad social no coincide con el formato solicitado",
                        "icono"=>"error"
                    ];
                    return json_encode($alerta);
                    exit();
                }
                if($this->verificarDatos("[0-9]{9,9}",$numeroColegiado)){
                    $alerta=[
                        "tipo"=>"simple",
                        "titulo"=>"Ocurrió un error inesperado",
                        "texto"=>"El número de colegiado no coincide con el formato solicitado",
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
    
                if($this->verificarDatos("[0-9]{9,10}",$numeroColegiado)){
                    //Definimos todo los valores de un array para la alerta
                    $alerta = [
                        "tipo" => "simple",
                        "titulo" => "Ocurrió un error inesperado",
                        "texto" => "El numero de colegiado no coincide con el formato solicitado",
                        "icono" => "error",
    
                    ];
                    //Devolvemos el array codificado en JSON
                    return json_encode($alerta);
                    exit();
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
    
                    // 5-1. Cargamos el array de Medicos
                    $medicos_datos_up=[
                        [
                            "campo_nombre"=>"clave_seguridad_social",
                            "campo_marcador"=>":ClaveSeguridadSocial",
                            "campo_valor"=>$claveSegSocial
                        ],
                        [
                            "campo_nombre"=>"numero_colegiado",
                            "campo_marcador"=>":NumeroColegiado",
                            "campo_valor"=>$numeroColegiado
                        ],
                        [
                            "campo_nombre"=>"id_especialidades",
                            "campo_marcador"=>":IdEspecialidades",
                            "campo_valor"=>$especialidades
                        ],
                        [
                            "campo_nombre"=>"id_situacion_revista",
                            "campo_marcador"=>":SituacionRevista",
                            "campo_valor"=>$situacion_revista
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
                    $condicion_medico=[
                        "condicion_campo"=>"id",
                        "condicion_marcador"=>":ID",
                        "condicion_valor"=>$id_medico
                    ];
                    $ac_medico=$this->actualizarDatos("medicos",$medicos_datos_up,$condicion_medico);
                    
                    
                    if($id_usuario==$_SESSION['id']){
                        $_SESSION['nombre']=$nombre." ".$apellido;
                        $_SESSION['usuario']=$usuario;
                    }

                    $alerta=[
                        "tipo"=>"recargar",
                        "titulo"=>"Medico actualizado",
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
}
?>