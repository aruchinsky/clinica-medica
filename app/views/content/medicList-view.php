<!-- Contenido de la Pagina -->
<div class="content-wrapper" style="min-height: 227px;">

<!-- Parte Superior del Contenido -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Lista de Medicos</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                    <li class="breadcrumb-item active">Lista de Medicos</li>
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
                        <!-- Tabla de Datos -->
                        <?php
                            use app\controllers\medicController;

                            $insMedic = new medicController();

                            echo $insMedic->listarMedicoControlador($url[1],10,$url[0],"");
                        ?>
                    </div>
                    <div class="card-footer">
                        <!-- Paginador -->

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
