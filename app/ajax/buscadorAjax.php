<?php
	
	require_once "../../config/app.php";
	require_once "../views/inc/session_start.php";
	require_once "../../autoload.php";
	
	use app\controllers\searchController;

	if(isset($_POST['modulo_buscador'])){

		$insBuscador = new searchController();

		if($_POST['modulo_buscador']=="buscar"){

			if($_POST['modulo_entidad']=="medico"){
				echo $insBuscador->iniciarBuscadorMedicoControlador();
			}


			if($_POST['modulo_entidad']=="administrativo"){
				echo $insBuscador->iniciarBuscadorAdministrativoControlador();
			}

			if($_POST['modulo_entidad']=="tecnico"){
				echo $insBuscador->iniciarBuscadorTecnicoControlador();
			}

			if($_POST['modulo_entidad']=="paciente"){
				echo $insBuscador->iniciarBuscadorPacienteControlador();
			}

			if($_POST['modulo_entidad']=="empleado"){
				echo $insBuscador->iniciarBuscadorEmpleadoControlador();
			}

		}

		if($_POST['modulo_buscador']=="eliminar"){

			if($_POST['modulo_entidad']=="medico"){
				echo $insBuscador->eliminarBuscadorMedicoControlador();
			}
			if($_POST['modulo_entidad']=="administrativo"){
				echo $insBuscador->eliminarBuscadorAdministrativoControlador();
			}

			if($_POST['modulo_entidad']=="tecnico"){
				echo $insBuscador->eliminarBuscadorTecnicoControlador();
			}

			if($_POST['modulo_entidad']=="paciente"){
				echo $insBuscador->eliminarBuscadorPacienteControlador();
			}

			if($_POST['modulo_entidad']=="empleado"){
				echo $insBuscador->eliminarBuscadorEmpleadoControlador();
			}
		}
		
	}else{
		session_destroy();
		header("Location: ".APP_URL."login/");
	}