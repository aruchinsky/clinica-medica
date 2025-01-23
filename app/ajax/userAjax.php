<?php
    // Contiene el nombre de la aplicacion y de la sesion
    require_once "../../config/app.php";
    // Contiene el inicio de la sesion junto con el nombre de la sesion
    require_once "../views/inc/session_start.php";
    // Contiene la funcion de AUTOLOAD
    require_once "../../autoload.php";
    // LLAmamos a la calse userController
    use app\controllers\userController;

    //Verificamos si viene definida la variable MODULO_USUARIO para poder empezar
    if(isset($_POST['modulo_usuario'])){
        //Instanciamos un objeto de tipo CONTROLADOR DE USUARIO
        $insUser = new userController();

        //Preguntamos que controlador vamos a utilizar: / registrar / actualizar / eliminar
        if($_POST['modulo_usuario']=="registrar"){
            //LLamamos al METODO para REGISTRAR UN USUARIO - > Tambien dicho CONTROLADOR
            echo $insUser->registrarUsuarioControlador();
        }

        //Preguntamos que controlador vamos a utilizar: / registrar / actualizar / eliminar
        if($_POST['modulo_usuario']=="eliminar"){
            //LLamamos al METODO para REGISTRAR UN USUARIO - > Tambien dicho CONTROLADOR
            echo $insUser->eliminarUsuarioControlador();
        }

        if($_POST['modulo_usuario']=="actualizar"){
			echo $insUser->actualizarUsuarioControlador();
		}

		if($_POST['modulo_usuario']=="eliminarFoto"){
			//echo $insAdmin->eliminarFotoUsuarioControlador();
		}

		if($_POST['modulo_usuario']=="actualizarFoto"){
			//echo $insAdmin->actualizarFotoUsuarioControlador();
		}

    }else{
        //Si no viene definida la variable modulo_usuario significa que se esta accediendo
        // a traves de la URL por eso DESTRUIMOS LA SESION y REDIRECCIONAMOS
        session_destroy();
        header("Location: ".APP_URL."login/");
    }


?>