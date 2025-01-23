<?php
        require_once "./autoload.php";

        use app\controllers\employeeController;
        use app\models\mainModel;
    
    
        $consultaTipoEmpleados = new mainModel();
        $consultaTipoEmpleados = $consultaTipoEmpleados->seleccionarDatos("Menu","tipo_empleados",0,0);
        $consultaTipoEmpleados = $consultaTipoEmpleados->fetchAll(PDO::FETCH_OBJ);
?>

<!-- Contenido de la Pagina -->
<div class="content-wrapper" style="min-height: 227px;">

    <!-- Parte Superior del Contenido -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Informe de Empleados por Cargo</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                        <li class="breadcrumb-item active">Informe de Empleados por Cargo</li>
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
                                //use app\controllers\medicController;
                                $insEmpleado = new employeeController();

                                if(!isset($_SESSION[$url[0]]) && empty($_SESSION[$url[0]])){
                            ?>
                            <div class="columns">
                                <div class="column">

                                <div class="container-fluid">
                                    <h2 class="text-center display-4">Búsqueda Avanzada</h2>
                                    <form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/buscadorAjax.php" method="POST" autocomplete="off" >
                                        <input type="hidden" name="modulo_buscador" value="buscar">
                                        <input type="hidden" name="modulo_entidad" value="empleado">
                                        <input type="hidden" name="modulo_url" value="<?php echo $url[0]; ?>">
                                        <div class="row">
                                            <div class="col-md-10 offset-md-1">
                                                <div class="row">
                                                    <!-- Tipo Empleado -->
                                                    <div class="col-4">
                                                            <select class="btn bg-lightblue dropdown-toggle" style="width: 100%; height: 75%;"  id="category" name="empleadoTipoFil">
                                                                    <option value="" class="form-control" type="button" data-bs-toggle="dropdown" aria-expanded="false">Cargo...</option>
                                                                    <?php
                                                                        foreach($consultaTipoEmpleados as $dato){
                                                                    ?>
                                                                            <option value="<?php echo $dato->id ?>" class="form-control"><?php echo $dato->descripcion ?></option>
                                                                    <?php
                                                                        } 
                                                                    ?>
                                                            </select>
                                                    </div>
                                                    <!-- Ordenar por -->
                                                    <div class="col-3">
                                                            <select class="btn bg-lightblue dropdown-toggle" style="width: 100%; height: 75%;" id="category" name="empleadoOrdenarPor">
                                                                <option value="" class="form-control" type="button" data-bs-toggle="dropdown" aria-expanded="false">Ordenar Por...</option>
                                                                <option value="1" class="form-control">Nombre</option>
                                                                <option value="2" class="form-control">Mas Recientes</option>
                                                                <option value="3" class="form-control">Mas Antiguos</option>
                                                                <option value="4" class="form-control">Provincias</option>
                                                            </select>
                                                    </div>
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
                                    </form>
                                                    <!-- Limpiar Busqueda -->
                                                    <div class="col-1">
                                                        <form class="input-group-append FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/buscadorAjax.php" method="POST" autocomplete="off" >
                                                            <input type="hidden" name="modulo_buscador" value="eliminar">
                                                            <input type="hidden" name="modulo_entidad" value="empleado">
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
                                    <h2 class="text-center display-4">Búsqueda Avanzada</h2>
                                    <form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/buscadorAjax.php" method="POST" autocomplete="off" >
                                        <?php 
                                            
                                        ?>
                                    <input type="hidden" name="modulo_buscador" value="buscar">
                                        <input type="hidden" name="modulo_entidad" value="empleado">
                                        <input type="hidden" name="modulo_url" value="<?php echo $url[0]; ?>">
                                        <div class="row">
                                            <div class="col-md-10 offset-md-1">
                                                <div class="row">
                                                    <!-- Tipo Empleados -->
                                                    <div class="col-4">
                                                            <select class="btn bg-lightblue dropdown-toggle" style="width: 100%; height: 75%;" id="category" name="empleadoTipoFil">
                                                                    <option value="" class="form-control" type="button" data-bs-toggle="dropdown" aria-expanded="false">Cargo...</option>
                                                                    <?php
                                                                        foreach($consultaTipoEmpleados as $dato){
                                                                    ?>
                                                                            <option value="<?php echo $dato->id ?>" <?php echo ($_SESSION['AvanzadaEmpleado'][0] == $dato->id) ? 'selected' : ''; ?> class="form-control"><?php echo $dato->descripcion ?></option>
                                                                    <?php
                                                                        } 
                                                                    ?>
                                                            </select>
                                                    </div>
                                                    <!-- Ordenar por -->
                                                    <div class="col-3">
                                                            <select class="btn bg-lightblue dropdown-toggle" style="width: 100%; height: 75%;" id="category" name="empleadoOrdenarPor">
                                                                <option value="" class="form-control" type="button" data-bs-toggle="dropdown" aria-expanded="false">Ordenar Por...</option>
                                                                <option value="1" class="form-control">Nombre</option>
                                                                <option value="2" class="form-control">Mas Recientes</option>
                                                                <option value="3" class="form-control">Mas Antiguos</option>
                                                                <option value="4" class="form-control">Provincias</option>
                                                            </select>
                                                    </div>
                                                    <!-- Barra de busqueda -->
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <div class="input-group input-group-lg">
                                                                <input type="search" class="form-control form-control-lg" 
                                                                name="txt_buscador" placeholder="Escribe aquí"
                                                                pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,30}" maxlength="30"
                                                                value="<?php echo $_SESSION['texto']; ?>">
                                                                <div class="input-group-append">
                                                                    <button type="submit" class="btn btn-lg btn-default">
                                                                        <i class="fa fa-search"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                    </form>
                                                    <!-- Limpiar Busqueda -->
                                                    <div class="col-1">
                                                        <form class="input-group-append FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/buscadorAjax.php" method="POST" autocomplete="off" >
                                                            <input type="hidden" name="modulo_buscador" value="eliminar">
                                                            <input type="hidden" name="modulo_entidad" value="empleado">
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
                                            echo $insEmpleado->listarEmpleadoAvanzadoControlador($url[1], 10, $url[0], $_SESSION['AvanzadaEmpleado']);
                                        }
                                        ?>

                                    </div>
                                    <div class="card-footer">
                                    <button class="btn btn-secondary float-left btn-back"><?php include "./app/views/inc/btn_back.php"; ?></button>
                                        <div class="text-right">
                                            <div class="btn-group btn-group-lg">
                                                <a href="<?php echo APP_URL; ?>app/views/fpdf/reporte_empleados.php" target="_blank" class="btn bg-navy">
                                                    <i class="fa-regular fa-file-pdf"></i>
                                                </a>
                                                <a href="<?php echo APP_URL; ?>app/views/excel/excel_empleado.php" target="_blank" class="btn bg-navy">
                                                    <i class="fa-regular fa-file-excel"></i>
                                                </a>
                                                <a  class="btn bg-navy">
                                                    <i class="fa-solid fa-print"></i>
                                                </a>
                                            </div>
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
