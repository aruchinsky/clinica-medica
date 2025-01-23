<?php
    namespace app\controllers;
    use app\models\mainModel;
    use \PDOException;

    class loginController extends mainModel{

        //Controlador INICIAR SESION
        public function iniciarSesionControlador(){


            //Almacenamos los valores del formulario de inicio de sesion
            $usuario = $this->limpiarCadena($_POST['login_usuario']);
            $clave =  $this->limpiarCadena($_POST['login_clave']);

            //Verificando campos obligatorios
            if($usuario=="" || $clave==""){

                echo "
                    <script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Ocurrio un error inesperado',
                            text: 'No has llenado todos los campos que son obligatorios',
                            confirmButtonText: 'Aceptar'
                        });
                    </script>
                ";
            }else{

                //Verificando la integridad de los datos
                if($this->verificarDatos("[a-zA-Z0-9]{4,10}",$usuario)){
                    echo "
                        <script>
                            Swal.fire({
                                icon: 'error',
                                title: 'Ocurrio un error inesperado',
                                text: 'El USUARIO no coincide con el formato solicitado',
                                confirmButtonText: 'Aceptar'
                            });
                        </script>
                    ";
                }else{
                    if($this->verificarDatos("[a-zA-Z0-9$@.-]{4,100}",$clave)){
                        echo "
                            <script>
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Ocurrio un error inesperado',
                                    text: 'La clave no coincide con el formato solicitado',
                                    confirmButtonText: 'Aceptar'
                                });
                            </script>
                        ";
                    }else{

                        # Verificando usuario #
                        //Consultamos si existe el usuario
                        $check_usuario=$this->ejecutarConsulta("SELECT u.id idUsuarios, tu.id idTipoUsuarios, u.nombre_usuario Usuario, 
                                                                u.foto nombreFoto, concat(p.nombre,' ',p.apellido) nombreApellido,
                                                                aes_decrypt(u.clave, 'PEPE') Clave, tu.descripcion tipoUsuario
                                                                FROM usuarios u
                                                                JOIN personas p
                                                                ON p.id = u.id_personas
                                                                JOIN tipo_usuarios tu
                                                                ON tu.id = u.id_tipo_usuarios
                                                                WHERE u.nombre_usuario = '$usuario';");
                        // $check_usuario = $check_usuario->fetch();
                        // echo $check_usuario['Clave'];
                        // exit();

                        if($check_usuario->rowCount()==1){
                            //Si el usuario existe creamos un array con los datos del mismo
                            $check_usuario = $check_usuario->fetch();
                            //  print_r($check_usuario['Clave']);
                            //  exit();
                            //Preguntamos si el nombre de usuario y la clave desencriptada son iguales 
                            // a las que ingresaron en el login
                            if($check_usuario['Usuario']==$usuario && $check_usuario['Clave']==$clave){

                                $_SESSION['id'] = $check_usuario['idUsuarios'];
                                $_SESSION['idTipoUsuario'] = $check_usuario['idTipoUsuarios'];
                                $_SESSION['nombre'] = $check_usuario['nombreApellido'];
                                $_SESSION['foto'] = $check_usuario['nombreFoto'];
                                $_SESSION['usuario'] = $check_usuario['Usuario'];
                                $_SESSION['tipoUsuario'] = $check_usuario['tipoUsuario'];
                                
                                //Corroboramos si los encabezados se han enviado
                                if(headers_sent()){
                                    //Si ya se han enviado encabezados, usamos javascript para redireccionar
                                    echo "
                                        <script>window.location.href='".APP_URL."dashboard';</script>
                                    ";
                                }else{
                                    //Si no se han enviado encabezados usamos PHP puro para redireccionar
                                    header("Location: ".APP_URL."dashboard");
                                }
                            }else{
                                echo "
                                    <script>
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Ocurrio un error inesperado',
                                            text: 'Usuario o Clave incorrectos',
                                            confirmButtonText: 'Aceptar'
                                        });
                                    </script>
                                ";
                            }
                        }else{
                            echo "
                                <script>
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Ocurrio un error inesperado',
                                        text: 'Usuario o Clave incorrectos',
                                        confirmButtonText: 'Aceptar'
                                    });
                                </script>
                            ";
                        }
                    }
                }
            }



        }

        //Controlador CERRAR SESION
        public function cerrarSesionControlador(){
            //Eliminamos todas las variables de sesion
            session_destroy();
            //Corroboramos si los encabezados se han enviado
            if(headers_sent()){
                //Si ya se han enviado encabezados, usamos javascript para redireccionar
                echo "
                    <script>window.location.href='".APP_URL."login/';</script>
                ";
            }else{
                //Si no se han enviado encabezados usamos PHP puro para redireccionar
                header("Location: ".APP_URL."login/");
            }
        }




    }