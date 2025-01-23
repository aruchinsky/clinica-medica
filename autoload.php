<?php
    //SPL_AUTOLOAD_REGISTER() Obtener el nombre de las clases que se estan usando actualmente en el sistema
    //SE COLOCA UNA FUNCION ANONIMA QUE RECIBE COMO PARAMETRO EL NAMESPACE DE LA CLASE
    spl_autoload_register(function($clase){
        // La constante __DIR__ obtiene el directorio actual donde se encuentra el archivo que se esta ejecutando.
        $archivo = __DIR__."/".$clase.".php";
        $archivo = str_replace('\\','/',$archivo);

        if(is_file($archivo)){
            require_once $archivo;
        }
    });
