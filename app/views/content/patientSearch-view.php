<?php
        require_once "./autoload.php";
        use app\models\mainModel;
    
        $consultaProvincias = new mainModel();
        $consultaProvincias = $consultaProvincias->seleccionarDatos("Menu","provincias",0,0);
        $consultaProvincias = $consultaProvincias->fetchAll(PDO::FETCH_OBJ);

        $consultaEspecialidades = new mainModel();
        $consultaEspecialidades = $consultaEspecialidades->seleccionarDatos("Menu","especialidades",0,0);
        $consultaEspecialidades = $consultaEspecialidades->fetchAll(PDO::FETCH_OBJ);

        $consultaMedicos = new mainModel();
        $consultaMedicos = $consultaMedicos->ejecutarConsultaLibre("SELECT m.id id, concat(p.nombre,' ',p.apellido) nombre
                                                                    FROM medicos m
                                                                    JOIN personas p
                                                                    ON p.id = m.id_personas");
        $consultaMedicos = $consultaMedicos->fetchAll(PDO::FETCH_OBJ);

?>

<!-- Contenido de la Pagina -->
<div class="content-wrapper" style="min-height: 227px;">

    <!-- Parte Superior del Contenido -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Búsqueda de Pacientes</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                        <li class="breadcrumb-item active">Búsqueda de Pacientes</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- /Parte superior del Contenido -->

    <!-- Contenido -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-6">
                    <div class="card card-lightblue">
                        <div class="card-body">
                            <!-- Formulario de Búsqueda -->
                            <?php
                                use app\controllers\patientController;
                                $insPatient = new patientController();

                                if(!isset($_SESSION[$url[0]]) && empty($_SESSION[$url[0]])){
                            ?>
                            <div class="columns">
                                <div class="column">

                                <div class="container-fluid">
                                    <h2 class="text-center display-4">Buscar</h2>
                                    <form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/buscadorAjax.php" method="POST" autocomplete="off" >
                                        <input type="hidden" name="modulo_buscador" value="buscar">
                                        <input type="hidden" name="modulo_entidad" value="paciente">
                                        <input type="hidden" name="modulo_url" value="<?php echo $url[0]; ?>">
                                        <div class="row">
                                            <div class="col-md-10 offset-md-1">
                                                <div class="row">
                                                    <!-- Medicos -->
                                                    <div class="col-6 mb-3">
                                                        <select class="btn bg-lightblue dropdown-toggle" style="width: 100%;" id="category" name="pacienteMedicoFil">
                                                            <option value="" class="form-control" type="button" data-bs-toggle="dropdown" aria-expanded="false">-- Médicos --</option>
                                                            <?php
                                                                    foreach($consultaMedicos as $dato){
                                                                ?>
                                                            <option value="<?php echo $dato->id ?>" class="form-control"><?php echo $dato->nombre ?></option>
                                                                <?php
                                                                    } 
                                                                ?>
                                                        </select>
                                                    </div>
                                                    <!-- Especialidades -->
                                                    <div class="col-6 mb-3">
                                                        <select class="btn bg-lightblue dropdown-toggle" style="width: 100%;" id="category" name="pacienteEspecialidadesFil">
                                                            <option value="" class="form-control" type="button" data-bs-toggle="dropdown" aria-expanded="false">-- Especialidades --</option>
                                                            <?php
                                                                    foreach($consultaEspecialidades as $dato){
                                                                ?>
                                                            <option value="<?php echo $dato->id ?>" class="form-control"><?php echo $dato->descripcion ?></option>
                                                                <?php
                                                                    } 
                                                                ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <!-- Barra de busqueda -->
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <div class="input-group input-group-lg">
                                                                <input type="search" class="form-control form-control-lg" 
                                                                name="txt_buscador" placeholder="Escribe aquí"
                                                                pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,30}" maxlength="30">
                                                                <div class="input-group-append">
                                                                    <button type="submit" class="btn btn-lg btn-default">
                                                                        <i class="fa fa-search"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Provincia -->
                                                    <div class="col-4">
                                                            <select class="btn bg-lightblue dropdown-toggle" style="width: 100%; height: 75%;" id="category" name="pacienteProvinciaFil">
                                                                <option value="" class="form-control" type="button" data-bs-toggle="dropdown" aria-expanded="false">Provincias...</option>
                                                                <?php
                                                                        foreach($consultaProvincias as $dato){
                                                                    ?>
                                                                <option value="<?php echo $dato->id ?>" class="form-control"><?php echo $dato->nombre ?></option>
                                                                    <?php
                                                                        } 
                                                                    ?>
                                                            </select>
                                                    </div>
                                                    <!-- Ordenar por -->
                                                    <div class="col-3">
                                                            <select class="btn bg-lightblue dropdown-toggle" style="width: 100%; height: 75%;" id="category" name="pacienteOrdenarPorFil">
                                                                <option value="" class="form-control" type="button" data-bs-toggle="dropdown" aria-expanded="false">Ordenar Por...</option>
                                                                <option value="1" class="form-control">Nombre</option>
                                                                <option value="2" class="form-control">Mas Recientes</option>
                                                                <option value="3" class="form-control">Mas Antiguos</option>
                                                                <option value="4" class="form-control">Provincias</option>
                                                            </select>
                                                    </div>
                                    </form>
                                                    <!-- Limpiar Busqueda -->
                                                    <div class="col-1">
                                                        <form class="input-group-append FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/buscadorAjax.php" method="POST" autocomplete="off" >
                                                            <input type="hidden" name="modulo_buscador" value="eliminar">
                                                            <input type="hidden" name="modulo_entidad" value="paciente">
                                                            <input type="hidden" name="modulo_url" value="<?php echo $url[0]; ?>">
                                                            <div class="form-group">
                                                                <div class="input-group input-group-lg">
                                                                    <button type="submit" class="btn btn-lg bg-lightblue">
                                                                        <i class="fa-solid fa-filter-circle-xmark"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                </div>
                                   
                            <?php } else { ?>
                                <div class="container-fluid">
                                    <h2 class="text-center display-4">Buscar</h2>
                                    <form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/buscadorAjax.php" method="POST" autocomplete="off" >
                                        <input type="hidden" name="modulo_buscador" value="buscar">
                                        <input type="hidden" name="modulo_entidad" value="paciente">
                                        <input type="hidden" name="modulo_url" value="<?php echo $url[0]; ?>">
                                        <div class="row">
                                            <div class="col-md-10 offset-md-1">
                                            <div class="row">
                                                    <!-- Medicos -->
                                                    <div class="col-6 mb-3">
                                                        <select class="btn bg-lightblue dropdown-toggle" style="width: 100%;" id="category" name="pacienteMedicoFil">
                                                            <option value="" class="form-control" type="button" data-bs-toggle="dropdown" aria-expanded="false">-- Médicos --</option>
                                                            <?php
                                                                    foreach($consultaMedicos as $dato){
                                                                ?>
                                                            <option value="<?php echo $dato->id ?>" <?php echo ($_SESSION['AvanzadaPaciente'][3] == $dato->id) ? 'selected' : ''; ?> class="form-control"><?php echo $dato->nombre ?></option>
                                                                <?php
                                                                    } 
                                                                ?>
                                                        </select>
                                                    </div>
                                                    <!-- Especialidades -->
                                                    <div class="col-6 mb-3">
                                                        <select class="btn bg-lightblue dropdown-toggle" style="width: 100%;" id="category" name="pacienteEspecialidadesFil">
                                                            <option value="" class="form-control" type="button" data-bs-toggle="dropdown" aria-expanded="false">-- Especialidades --</option>
                                                            <?php
                                                                    foreach($consultaEspecialidades as $dato){
                                                                ?>
                                                            <option value="<?php echo $dato->id ?>" <?php echo ($_SESSION['AvanzadaPaciente'][4] == $dato->id) ? 'selected' : ''; ?> class="form-control"><?php echo $dato->descripcion ?></option>
                                                                <?php
                                                                    } 
                                                                ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <!-- Barra de busqueda -->
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <div class="input-group input-group-lg">
                                                                <input type="search" class="form-control form-control-lg" 
                                                                name="txt_buscador" placeholder="Escribe aquí"
                                                                pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,30}" maxlength="30">
                                                                <div class="input-group-append">
                                                                    <button type="submit" class="btn btn-lg btn-default">
                                                                        <i class="fa fa-search"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Provincia -->
                                                    <div class="col-4">
                                                        <select class="btn bg-lightblue dropdown-toggle" style="width: 100%; height: 75%;" id="category" name="pacienteProvinciaFil">
                                                            <option value="" class="form-control" type="button" data-bs-toggle="dropdown" aria-expanded="false">Provincias...</option>
                                                            <?php
                                                                foreach($consultaProvincias as $dato){
                                                            ?>
                                                            <option value="<?php echo $dato->id ?>" <?php echo ($_SESSION['AvanzadaPaciente'][1] == $dato->id) ? 'selected' : ''; ?> class="form-control"><?php echo $dato->nombre ?></option>
                                                            
                                                            <?php
                                                                } 
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <!-- Ordenar por -->
                                                    <div class="col-3">
                                                            <select class="btn bg-lightblue dropdown-toggle" style="width: 100%; height: 75%;" id="category" name="pacienteOrdenarPorFil">
                                                                <option value="" class="form-control" type="button" data-bs-toggle="dropdown" aria-expanded="false">Ordenar Por...</option>
                                                                <option value="1" class="form-control">Nombre</option>
                                                                <option value="2" class="form-control">Mas Recientes</option>
                                                                <option value="3" class="form-control">Mas Antiguos</option>
                                                                <option value="4" class="form-control">Provincias</option>
                                                            </select>
                                                    </div>
                                    </form>
                                                    <!-- Limpiar Filtros -->
                                                    <div class="col-1">
                                                        <form class="input-group-append FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/buscadorAjax.php" method="POST" autocomplete="off" >
                                                            <input type="hidden" name="modulo_buscador" value="eliminar">
                                                            <input type="hidden" name="modulo_entidad" value="paciente">
                                                            <input type="hidden" name="modulo_url" value="<?php echo $url[0]; ?>">
                                                            <div class="form-group">
                                                                <div class="input-group input-group-lg">
                                                                    <button type="submit" class="btn btn-lg bg-lightblue">
                                                                        <i class="fa-solid fa-filter-circle-xmark"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                                <div class="card">
                                <div class="card-body">
                                        <?php
                                            echo $insPatient->listarPacienteAvanzadoControlador($url[1], 10, $url[0], $_SESSION['AvanzadaPaciente']);
                                        }
                                        ?>

                                    </div>
                                    <div class="card-footer">
                                        <div class="float-right">
                                            <div class="btn-group btn-group-lg">
                                                <a href="<?php echo APP_URL; ?>app/views/fpdf/reporte_paciente.php" target="_blank" class="btn bg-navy">
                                                    <i class="fa-regular fa-file-pdf"></i>
                                                </a>
                                                <a href="<?php echo APP_URL; ?>app/views/excel/excel_paciente.php" target="_blank" class="btn bg-navy">
                                                    <i class="fa-regular fa-file-excel"></i>
                                                </a>
                                                <a  class="btn bg-navy">
                                                    <i class="fa-solid fa-print"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="btn-group">
                                            <button class="btn btn-secondary float-left btn-back"><?php include "./app/views/inc/btn_back.php"; ?></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <!-- Pie de pagina -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
