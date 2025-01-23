<?php
    // Contiene el nombre de la aplicacion y de la sesion
    require_once "../../config/app.php";
    // Contiene el inicio de la sesion junto con el nombre de la sesion
    require_once "../views/inc/session_start.php";
    // Contiene la funcion de AUTOLOAD
    require_once "../../autoload.php";
    // LLamamos al controlador
    use app\controllers\medicController;

    //Verificamos si viene definida el MODULO DE FORMULARIO para poder empezar
    if(isset($_POST['modulo_medico'])){
        //Instanciamos un objeto de tipo CONTROLADOR
        $insMedic = new medicController();

        //Preguntamos que METODO vamos a utilizar: / registrar / actualizar / eliminar
        if($_POST['modulo_medico']=="registrar"){
            //LLamamos al METODO para REGISTRAR - > Tambien dicho CONTROLADOR
            echo $insMedic->registrarMedicoControlador();
        }

        if($_POST['modulo_medico']=="eliminar"){
            //LLamamos al METODO para ELIMINAR - > Tambien dicho CONTROLADOR
            echo $insMedic->eliminarMedicoControlador();
        }

        if($_POST['modulo_medico']=="actualizar"){
            //LLamamos al METODO para ACTUALIZAR - > Tambien dicho CONTROLADOR
			echo $insMedic->actualizarMedicoControlador();
		}

		if($_POST['modulo_medico']=="eliminarFoto"){
			//echo $insMedic->eliminarFotoUsuarioControlador();
		}

		if($_POST['modulo_medico']=="actualizarFoto"){
			//echo $insMedic->actualizarFotoUsuarioControlador();
		}

    }else{
        //Si no viene definido el MODULO DE FORMULARIO significa que se esta accediendo
        // a traves de la URL por eso DESTRUIMOS LA SESION y REDIRECCIONAMOS
        session_destroy();
        header("Location: ".APP_URL."login/");
    }


?>