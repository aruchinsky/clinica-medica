<?php
require_once "C:/xampp/htdocs/c_m/config/app.php";
require_once "C:/xampp/htdocs/c_m/autoload.php";
require_once "C:/xampp/htdocs/c_m/app/views/inc/session_start.php";

    header("Content-Type: application/xls");
    header("Content-Disposition: attachment; filename= archivo.xls");

    $_SESSION['tablaMedicos'];

?>

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
                                </tr>
                            </thead>
                            <tbody class="table-group-divider">
<?php
$consulta_reporte = $_SESSION['tablaMedicos'];
//  print_r($consulta_reporte);
//  exit();
$i = 1;
foreach($consulta_reporte as $dato){
    ?>
        <tr>
            <td><?php echo $i ?></td>
            <td><?php echo $dato['nombreApellido'] ?></td>
            <td><?php echo $dato['especialidades'] ?></td>
            <td><?php echo $dato['situacionRevista'] ?></td>
            <td><?php echo $dato['numColegiado'] ?></td>
            <td><?php echo $dato['Provincia'] ?></td>
            <td><?php date("d-m-Y",strtotime($dato['FechaCreacion'])) ?></td>
        </tr>
    <?php
    $i++;    
}

?>