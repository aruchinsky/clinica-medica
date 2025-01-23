<?php
    // Contiene el nombre de la aplicacion y de la sesion
    require_once "../../config/app.php";
    // Contiene el inicio de la sesion junto con el nombre de la sesion
    require_once "../views/inc/session_start.php";
    // Contiene la funcion de AUTOLOAD
    require_once "../../autoload.php";
    // LLAmamos a la calse patientController
    use app\controllers\patientController;


    //Verificamos si viene definida el MODULO DE FORMULARIO para poder empezar
    if(isset($_POST['modulo_paciente'])){
        //Instanciamos un objeto de tipo CONTROLADOR
        $insPaciente = new patientController();

        //Preguntamos que controlador vamos a utilizar: / registrar / actualizar / eliminar
        if($_POST['modulo_paciente']=="registrar"){
            //LLamamos al METODO para REGISTRAR - > Tambien dicho CONTROLADOR
            echo $insPaciente->registrarPacienteControlador();
        }

        //Preguntamos que controlador vamos a utilizar: / registrar / actualizar / eliminar
        if($_POST['modulo_paciente']=="eliminar"){
            //LLamamos al METODO para ELIMINAR - > Tambien dicho CONTROLADOR
            echo $insPaciente->eliminarPacienteControlador();
        }

        if($_POST['modulo_paciente']=="actualizar"){
            //LLamamos al METODO para ACTUALIZAR - > Tambien dicho CONTROLADOR
			echo $insPaciente->actualizarPacienteControlador();
		}

		if($_POST['modulo_paciente']=="eliminarFoto"){
			//echo $insPaciente->eliminarFotoUsuarioControlador();
		}

		if($_POST['modulo_paciente']=="actualizarFoto"){
			//echo $insPaciente->actualizarFotoUsuarioControlador();
		}

    }else{
        //Si no viene definida la variable modulo_usuario significa que se esta accediendo
        // a traves de la URL por eso DESTRUIMOS LA SESION y REDIRECCIONAMOS
        session_destroy();
        header("Location: ".APP_URL."login/");
    }


?>