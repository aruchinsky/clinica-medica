<?php
    // Contiene el nombre de la aplicacion y de la sesion
    require_once "../../config/app.php";
    // Contiene el inicio de la sesion junto con el nombre de la sesion
    require_once "../views/inc/session_start.php";
    // Contiene la funcion de AUTOLOAD
    require_once "../../autoload.php";
    // LLAmamos a la calse userController
    use app\controllers\adminController;

    //Verificamos si viene definida el MODULO DE FORMULARIO para poder empezar
    if(isset($_POST['modulo_administrativo'])){
        //Instanciamos un objeto de tipo CONTROLADOR
        $insAdmin = new adminController();

        //Preguntamos que controlador vamos a utilizar: / registrar / actualizar / eliminar
        if($_POST['modulo_administrativo']=="registrar"){
            //LLamamos al METODO para REGISTRAR - > Tambien dicho CONTROLADOR
            echo $insAdmin->registrarAdminControlador();
        }

        //Preguntamos que controlador vamos a utilizar: / registrar / actualizar / eliminar
        if($_POST['modulo_administrativo']=="eliminar"){
            //LLamamos al METODO para ELIMINAR - > Tambien dicho CONTROLADOR
            echo $insAdmin->eliminarAdminControlador();
        }

        if($_POST['modulo_administrativo']=="actualizar"){
            //LLamamos al METODO para ACTUALIZAR - > Tambien dicho CONTROLADOR
			echo $insAdmin->actualizarAdminControlador();
		}

		if($_POST['modulo_administrativo']=="eliminarFoto"){
			//echo $insAdmin->eliminarFotoUsuarioControlador();
		}

		if($_POST['modulo_administrativo']=="actualizarFoto"){
			//echo $insAdmin->actualizarFotoUsuarioControlador();
		}

    }else{
        //Si no viene definida la variable modulo_usuario significa que se esta accediendo
        // a traves de la URL por eso DESTRUIMOS LA SESION y REDIRECCIONAMOS
        session_destroy();
        header("Location: ".APP_URL."login/");
    }


?>