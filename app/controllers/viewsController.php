<?php
    namespace app\controllers;
    use app\models\viewsModel;

    class viewsController extends viewsModel{

        public function obtenerVistasControlador($vista){

            //Preguntamos si esta vista viene VACIA
            if($vista!=""){
                //Utilizamos la funcion de modelo para obtener la VISTA
                $respuesta = $this->obtenerVistasModelo($vista);
            }else{
                //En caso que el valor NO VENGA DEFINIDO
                $respuesta = "login";
            }
            return $respuesta;
        }

    }

?>