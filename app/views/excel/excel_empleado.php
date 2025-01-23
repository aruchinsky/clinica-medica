<?php
require_once "C:/xampp/htdocs/c_m/config/app.php";
require_once "C:/xampp/htdocs/c_m/autoload.php";
require_once "C:/xampp/htdocs/c_m/app/views/inc/session_start.php";

	header("Content-Type: application/xls");    
	header("Content-Disposition: attachment; filename=documento_exportado_" . date('Y:m:d:m:s').".xls");
	header("Pragma: no-cache"); 
	header("Expires: 0");
?>
<!--ACENTOS Y CARACTERES RAROS OFF-->
<head>
    <meta charset="UTF-8">
</head>
<?php
	
	$output = "";
	
		$output .='
                    <table class="table table-sm table-head-fixed text-nowrap text-center table-striped table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nombre y Apellido</th>
                                    <th scope="col">Cargo</th>
                                    <th scope="col">Provincia</th>
                                    <th scope="col">Fecha de Alta</th>
                                </tr>
                            </thead>
                            <tbody class="table-group-divider">
		';
		
        $consulta_reporte = $_SESSION['tablaEmpleados'];
        //  print_r($consulta_reporte);
        //  exit();
        $i = 1;
        foreach($consulta_reporte as $dato){
            $output .= "
                <tr>
                    <td>".$i."</td>
                    <td>".$dato['nombreApellido']."</td>
                    <td>".$dato['tipoEmpleado']."</td>
                    <td>".$dato['provincia']."</td>
                    <td>".$dato['fechaAlta']."</td>
                </tr>
            ";
            $i++;    
        }

		$output .="
				</tbody>
				
			</table>
		";
		
		echo $output;
	
?>