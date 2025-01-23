<?php
    require_once "./config/app.php";
    require_once "./autoload.php";
    require_once "./app/views/inc/session_start.php";

    if(isset($_GET['views'])){
        //EXPLODE = Funcion que divide una cadena en base a un caracter
        $url=explode("/",$_GET['views']);
    }else{
        $url=["login"];
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <?php require_once "./app/views/inc/head.php"; ?>
</head>
<body class="sidebar-mini layout-navbar-fixed layout-fixed" style="height: auto;">
    <!-- Contenedor PRINCIPAL -->
    <div class="wrapper">

    <?php
        //LLamamos al CONTROLADOR de VIEWSCONTROLLER
        use app\controllers\viewsController;
        //LLamamos al CONTROLADOR de LOGIN
        use app\controllers\loginController;  
        //Instanciamos este controlador
        $insLogin = new loginController();
        //Instanciamos este controlador
        $viewsController = new viewsController();
        $vista = $viewsController->obtenerVistasControlador($url[0]);

        //Validamos si viene login o 404 para cargar esas vistas
        if($vista=="login" || $vista=="404"){
            require_once "./app/views/content/".$vista."-view.php";
        }else{

            //Con ISSET preguntamos si la variable session ID esta iniciada.
            // En caso que no este iniciada significa que no iniciaron sesion
            // entonces cerramos el sistema y redireccionamos al LOGIN
            if(!isset($_SESSION['id']) || !isset($_SESSION['idTipoUsuario'])
            || !isset($_SESSION['usuario']) || $_SESSION['id']==""
            || $_SESSION['idTipoUsuario']=="" || $_SESSION['usuario']==""){
                $insLogin->cerrarSesionControlador();
                exit();
            }

            //Incluimos la barra de navegacion junto con la vista
            if($_SESSION['idTipoUsuario']==1){
                require_once "./app/views/inc/navbar.php";
                require_once $vista;
            }elseif($_SESSION['idTipoUsuario']==2){
                require_once "./app/views/inc/navbar.php";
                require_once $vista;
            }elseif($_SESSION['idTipoUsuario']==3){
                require_once "./app/views/inc/navbar.php";
                require_once $vista;
            }elseif($_SESSION['idTipoUsuario']==4){
                require_once "./app/views/inc/navbar.php";
                require_once $vista;
            }
        

        }
            require_once "./app/views/inc/script.php";

    ?>

    </div>
    <!-- /Contenedor PRINCIPAL -->
</body>
</html>