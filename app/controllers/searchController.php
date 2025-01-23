<?php

	namespace app\controllers;
	use app\models\mainModel;

	class searchController extends mainModel{

		/*----------  Controlador iniciar busqueda Administrativo  ----------*/
		public function iniciarBuscadorAdministrativoControlador(){

		    $url=$this->limpiarCadena($_POST['modulo_url']);
			if(!isset($_POST['txt_buscador'])){$texto=' ';}else{$texto = $_POST['txt_buscador'];}
			if(!isset($_POST['adminProvinciaFil'])){$provincia='';}else{$provincia = $_POST['adminProvinciaFil'];}
			if(!isset($_POST['adminOrdenarPorFil'])){$ordenar_por='';}else{$ordenar_por = $_POST['adminOrdenarPorFil'];}
			$_SESSION['AvanzadaAdministrativo'] = [];
			$busqueda_avanzada = [$texto,$provincia,$ordenar_por];
			// print_r($busqueda_avanzada);
			// exit();

			if($this->modulosBusquedaControlador($url)){
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No podemos procesar la petición en este momento",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
			}

			$_SESSION['AvanzadaAdministrativo']=$busqueda_avanzada;
			$_SESSION['texto']=$busqueda_avanzada[0];
			$_SESSION[$url]=$texto;

			$alerta=[
				"tipo"=>"redireccionar",
				"url"=>APP_URL.$url."/"
			];

			return json_encode($alerta);
		}
		/*----------  Controlador eliminar busqueda Administrativo ----------*/
		public function eliminarBuscadorAdministrativoControlador(){

			$url=$this->limpiarCadena($_POST['modulo_url']);

			if($this->modulosBusquedaControlador($url)){
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No podemos procesar la petición en este momento",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
			}

			unset($_SESSION[$url]);
			unset($_SESSION['tablaAdministrativos']);

			$alerta=[
				"tipo"=>"redireccionar",
				"url"=>APP_URL.$url."/"
			];

			return json_encode($alerta);
		}

		/*----------  Controlador modulos de busquedas LISTA DE MODULOS  ----------*/
		public function modulosBusquedaControlador($modulo){

			$listaModulos=['userSearch',
						   'adminSearch',
						   'medicSearch',
						   'tecnicSearch',
						   'patientSearch',
						   'medicInform',
						   'employeeInform'];

			if(in_array($modulo, $listaModulos)){
				return false;
			}else{
				return true;
			}
		}

		/*----------  Controlador iniciar busqueda Medico  ----------*/
		public function iniciarBuscadorMedicoControlador(){

		    $url=$this->limpiarCadena($_POST['modulo_url']);
			if(!isset($_POST['txt_buscador'])){$texto=' ';}else{$texto = $_POST['txt_buscador'];}
			if(!isset($_POST['medicoProvinciaFil'])){$provincia='';}else{$provincia = $_POST['medicoProvinciaFil'];}
			if(!isset($_POST['medicoEspecialidadFil'])){$especialidad='';}else{$especialidad = $_POST['medicoEspecialidadFil'];}
			if(!isset($_POST['medicoSituacionRevistaFil'])){$situacion_revista='';}else{$situacion_revista = $_POST['medicoSituacionRevistaFil'];}
			if(!isset($_POST['medicoOrdenarPorFil'])){$ordenar_por='';}else{$ordenar_por = $_POST['medicoOrdenarPorFil'];}
			$_SESSION['busquedaAvanzadaMedico'] = [];
			$busqueda_avanzada = [$texto,$provincia,$especialidad,$situacion_revista,$ordenar_por];
			// print_r($busqueda_avanzada);
			// exit();

			if($this->modulosBusquedaControlador($url)){
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No podemos procesar la petición en este momento",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
			}

			$_SESSION['busquedaAvanzadaMedico']=$busqueda_avanzada;
			$_SESSION['texto']=$busqueda_avanzada[0];
			$_SESSION[$url]=$texto;

			$alerta=[
				"tipo"=>"redireccionar",
				"url"=>APP_URL.$url."/"
			];

			return json_encode($alerta);
		}

		/*----------  Controlador eliminar busqueda Medico ----------*/
		public function eliminarBuscadorMedicoControlador(){

			$url=$this->limpiarCadena($_POST['modulo_url']);

			if($this->modulosBusquedaControlador($url)){
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No podemos procesar la petición en este momento",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
			}

			unset($_SESSION[$url]);
			unset($_SESSION['tablaMedicos']);

			$alerta=[
				"tipo"=>"redireccionar",
				"url"=>APP_URL.$url."/"
			];

			return json_encode($alerta);
		}

		/*----------  Controlador eliminar busqueda Empleado ----------*/	
		public function eliminarBuscadorEmpleadoControlador(){

			$url=$this->limpiarCadena($_POST['modulo_url']);

			if($this->modulosBusquedaControlador($url)){
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No podemos procesar la petición en este momento",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
			}

			unset($_SESSION[$url]);
			unset($_SESSION['tablaEmpleado']);

			$alerta=[
				"tipo"=>"redireccionar",
				"url"=>APP_URL.$url."/"
			];

			return json_encode($alerta);
		}

		/*----------  Controlador iniciar busqueda Empleado ----------*/
		public function iniciarBuscadorEmpleadoControlador(){

			$url=$this->limpiarCadena($_POST['modulo_url']);
			if(!isset($_POST['txt_buscador'])){$texto=' ';}else{$texto = $_POST['txt_buscador'];}
			if(!isset($_POST['empleadoOrdenarPor'])){$ordenar_por='';}else{$ordenar_por = $_POST['empleadoOrdenarPor'];}
			if(!isset($_POST['empleadoTipoFil'])){$tipo_empleado='';}else{$tipo_empleado = $_POST['empleadoTipoFil'];}
			$_SESSION['AvanzadaEmpleado'] = [];
			$busqueda_avanzada = [$tipo_empleado,$ordenar_por,$texto];

			//  echo $busqueda_avanzada[0];
			//  echo $busqueda_avanzada[1];
			//  echo $busqueda_avanzada[2];
			//  exit();

			if($this->modulosBusquedaControlador($url)){
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No podemos procesar la petición en este momento",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
			}

			$_SESSION['AvanzadaEmpleado']=$busqueda_avanzada;
			$_SESSION['texto']=$busqueda_avanzada[2];
			$_SESSION[$url]=$texto;

			$alerta=[
				"tipo"=>"redireccionar",
				"url"=>APP_URL.$url."/"
			];

			return json_encode($alerta);
		}

		/*----------  Controlador iniciar busqueda UNIVERSAL  ----------*/
		public function iniciarBuscadorControlador(){

		    $url=$this->limpiarCadena($_POST['modulo_url']);
			$texto=$this->limpiarCadena($_POST['txt_buscador']);

			if($this->modulosBusquedaControlador($url)){
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No podemos procesar la petición en este momento",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
			}

			if($texto==""){
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"Introduce un termino de busqueda",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
			}

			if($this->verificarDatos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,30}",$texto)){
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El termino de busqueda no coincide con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
			}

			$_SESSION[$url]=$texto;

			$alerta=[
				"tipo"=>"redireccionar",
				"url"=>APP_URL.$url."/"
			];

			return json_encode($alerta);
		}

		/*----------  Controlador eliminar busqueda UNIVERSAL  ----------*/
		public function eliminarBuscadorControlador(){

			$url=$this->limpiarCadena($_POST['modulo_url']);

			if($this->modulosBusquedaControlador($url)){
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No podemos procesar la petición en este momento",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
			}

			unset($_SESSION[$url]);

			$alerta=[
				"tipo"=>"redireccionar",
				"url"=>APP_URL.$url."/"
			];

			return json_encode($alerta);
		}

		/*----------  Controlador iniciar busqueda Tecnico  ----------*/
		public function iniciarBuscadorTecnicoControlador(){

		    $url=$this->limpiarCadena($_POST['modulo_url']);
			if(!isset($_POST['txt_buscador'])){$texto=' ';}else{$texto = $_POST['txt_buscador'];}
			if(!isset($_POST['tecnicoProvinciaFil'])){$provincia='';}else{$provincia = $_POST['tecnicoProvinciaFil'];}
			if(!isset($_POST['tecnicoOrdenarPorFil'])){$ordenar_por='';}else{$ordenar_por = $_POST['tecnicoOrdenarPorFil'];}
			$_SESSION['AvanzadaTecnico'] = [];
			$busqueda_avanzada = [$texto,$provincia,$ordenar_por];
			// print_r($busqueda_avanzada);
			// exit();

			if($this->modulosBusquedaControlador($url)){
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No podemos procesar la petición en este momento",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
			}

			$_SESSION['AvanzadaTecnico']=$busqueda_avanzada;
			$_SESSION['texto']=$busqueda_avanzada[0];
			$_SESSION[$url]=$texto;

			$alerta=[
				"tipo"=>"redireccionar",
				"url"=>APP_URL.$url."/"
			];

			return json_encode($alerta);
		}
		/*----------  Controlador eliminar busqueda Tecnico ----------*/
		public function eliminarBuscadorTecnicoControlador(){

			$url=$this->limpiarCadena($_POST['modulo_url']);

			if($this->modulosBusquedaControlador($url)){
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No podemos procesar la petición en este momento",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
			}

			unset($_SESSION[$url]);
			unset($_SESSION['tablaTecnico']);

			$alerta=[
				"tipo"=>"redireccionar",
				"url"=>APP_URL.$url."/"
			];

			return json_encode($alerta);
		}

		/*----------  Controlador iniciar busqueda Paciente ----------*/
		public function iniciarBuscadorPacienteControlador(){

		    $url=$this->limpiarCadena($_POST['modulo_url']);
			if(!isset($_POST['txt_buscador'])){$texto=' ';}else{$texto = $_POST['txt_buscador'];}
			if(!isset($_POST['pacienteProvinciaFil'])){$provincia='';}else{$provincia = $_POST['pacienteProvinciaFil'];}
			if(!isset($_POST['pacienteOrdenarPorFil'])){$ordenar_por='';}else{$ordenar_por = $_POST['pacienteOrdenarPorFil'];}
			if(!isset($_POST['pacienteMedicoFil'])){$medico='';}else{$medico = $_POST['pacienteMedicoFil'];}
			if(!isset($_POST['pacienteEspecialidadesFil'])){$especialidades='';}else{$especialidades = $_POST['pacienteEspecialidadesFil'];}
			$_SESSION['AvanzadaTecnico'] = [];
			$busqueda_avanzada = [$texto,$provincia,$ordenar_por,$medico,$especialidades];
			// print_r($busqueda_avanzada);
			// exit();

			if($this->modulosBusquedaControlador($url)){
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No podemos procesar la petición en este momento",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
			}

			$_SESSION['AvanzadaPaciente']=$busqueda_avanzada;
			$_SESSION['texto']=$busqueda_avanzada[0];
			$_SESSION[$url]=$texto;

			$alerta=[
				"tipo"=>"redireccionar",
				"url"=>APP_URL.$url."/"
			];

			return json_encode($alerta);
		}
		/*----------  Controlador eliminar busqueda Paciente ----------*/
		public function eliminarBuscadorPacienteControlador(){

			$url=$this->limpiarCadena($_POST['modulo_url']);

			if($this->modulosBusquedaControlador($url)){
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No podemos procesar la petición en este momento",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
			}

			unset($_SESSION[$url]);
			unset($_SESSION['tablaPaciente']);

			$alerta=[
				"tipo"=>"redireccionar",
				"url"=>APP_URL.$url."/"
			];

			return json_encode($alerta);
		}

	}