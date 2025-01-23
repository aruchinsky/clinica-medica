<?php 
    namespace app\models;
    use \PDO;

    //Preguntamos si el archivo existe 
    if(file_exists(__DIR__."/../../config/server.php")){
        //si existe lo llamamos
        require_once __DIR__."/../../config/server.php";
    }

    class mainModel{

        private $server = DB_SERVER;
        private $db = DB_NAME;
        private $user = DB_USER;
        private $pass = DB_PASS;

        protected function conectar(){
            $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC);
            $conexion = new PDO("mysql:host=".$this->server."; dbname=".$this->db,
                $this->user,$this->pass, $options);
            //PErmite utilizar caracteres españoles
            $conexion->exec("SET CHARACTER SET utf8");

            return $conexion;
        }

        //Funcion para ejecutar cualquier consulta genérica
        protected function ejecutarConsulta($consulta){
            //Preparamos la consulta
            $sql = $this->conectar()->prepare($consulta);
            //Ejecutamos la consulta
            $sql->execute();
            //Devolvemos el resultado
            return $sql;
        }

        public function ejecutarConsultaLibre($consulta){
            //Preparamos la consulta
            $sql = $this->conectar()->prepare($consulta);
            //Ejecutamos la consulta
            $sql->execute();
            //Devolvemos el resultado
            return $sql;
        }

        public function limpiarCadena($cadena){
            $palabras = ["<script>","</script>","<script src","<script type=","SELECT * FROM",
                         "DELETE FROM","INSERT INTO","DROP TALBE","DROP DATABASE","TRUNCATE TABLE",
                         "SHOW TABLE;","SHOW DATABASES;","<?php","?>","--","^","<","[","]","==",";","::"];

            $cadena=trim($cadena);
            $cadena=stripslashes($cadena);
            
            foreach($palabras as $palabra){
                $cadena = str_ireplace($palabra,"",$cadena);
            }

            $cadena=trim($cadena);
            $cadena=stripslashes($cadena);

            return $cadena;

        }

        protected function verificarDatos($filtro,$cadena){
            if(preg_match("/^".$filtro."$/",$cadena)){
                return false;
            }else{
                return true;
            }
        }

        protected function guardarDatos($tabla,$datos){
            $query = "INSERT INTO $tabla (";

            $contador = 0;

            foreach($datos as $clave){
                if($contador>=1){$query.=",";}
                $query.=$clave["campo_nombre"];
                $contador++;
            }

            $query.=") VALUES(";
            $contador = 0;

            foreach($datos as $clave){
                if($contador>=1){$query.=",";}
                $query.=$clave["campo_marcador"];
                $contador++;
            }

            $query.=")";
            $sql = $this->conectar()->prepare($query);

            foreach($datos as $clave){
                $sql->bindParam($clave["campo_marcador"],$clave["campo_valor"]);
            }

            $sql->execute();

            return $sql;
        }

        protected function guardarDatosIdClave($tabla, $datos) {
            // Obtener la conexión a la base de datos
            $pdo = $this->conectar();
        
            // Construir la consulta de inserción
            $query = "INSERT INTO $tabla (";
        
            $contador = 0;
        
            foreach($datos as $clave) {
                if($contador >= 1) {
                    $query .= ",";
                }
                $query .= $clave["campo_nombre"];
                $contador++;
            }
        
            $query .= ") VALUES(";
            $contador = 0;
        
            foreach($datos as $clave) {
                if($contador >= 1) {
                    $query .= ",";
                }
                if ($clave["campo_marcador"] == ":Clave") {
                    // Si el marcador es Clave, usar AES_ENCRYPT
                    $query .= "AES_ENCRYPT(" . $clave["campo_marcador"] . ", 'PEPE')";
                } else {
                    // De lo contrario, usar el marcador normalmente
                    $query .= $clave["campo_marcador"];
                }
                $contador++;
            }
        
            $query .= ")";
            
            // Preparar y ejecutar la consulta
            $sql = $pdo->prepare($query);
        
            foreach($datos as $clave) {
                $sql->bindParam($clave["campo_marcador"], $clave["campo_valor"]);
            }
        
            $sql->execute();
        
            // Obtener el ID del último registro insertado
            $lastInsertId = $pdo->lastInsertId();
        
            // Retornar el ID del último registro insertado
            return $lastInsertId;
        }

        protected function guardarDatosId($tabla, $datos) {
            // Obtener la conexión a la base de datos
            $pdo = $this->conectar();
        
            // Construir la consulta de inserción
            $query = "INSERT INTO $tabla (";
        
            $contador = 0;
        
            foreach($datos as $clave) {
                if($contador >= 1) {
                    $query .= ",";
                }
                $query .= $clave["campo_nombre"];
                $contador++;
            }
        
            $query .= ") VALUES(";
            $contador = 0;
        
            foreach($datos as $clave) {
                if($contador >= 1) {
                    $query .= ",";
                }
                $query .= $clave["campo_marcador"];
                $contador++;
            }
        
            $query .= ")";
            
            // Preparar y ejecutar la consulta
            $sql = $pdo->prepare($query);
        
            foreach($datos as $clave) {
                $sql->bindParam($clave["campo_marcador"], $clave["campo_valor"]);
            }
        
            $sql->execute();
        
            // Obtener el ID del último registro insertado
            $lastInsertId = $pdo->lastInsertId();
        
            // Retornar el ID del último registro insertado
            return $lastInsertId;
        }

        protected function guardarDatosClave($tabla, $datos) {
            // Construir la consulta de inserción
            $query = "INSERT INTO $tabla (";
        
            $contador = 0;
        
            foreach($datos as $clave) {
                if($contador >= 1) {
                    $query .= ",";
                }
                $query .= $clave["campo_nombre"];
                $contador++;
            }
        
            $query .= ") VALUES(";
            $contador = 0;
        
            foreach($datos as $clave) {
                if($contador >= 1) {
                    $query .= ",";
                }
                if ($clave["campo_marcador"] == ":Clave") {
                    // Si el marcador es Clave, usar AES_ENCRYPT
                    $query .= "AES_ENCRYPT(" . $clave["campo_marcador"] . ", 'PEPE')";
                } else {
                    // De lo contrario, usar el marcador normalmente
                    $query .= $clave["campo_marcador"];
                }
                $contador++;
            }
        
            $query .= ")";
            
            // Preparar y ejecutar la consulta
            $sql = $this->conectar()->prepare($query);
        
            foreach($datos as $clave) {
                if ($clave["campo_marcador"] == ":Clave") {
                    // Si el marcador es Clave, bindear el valor cifrado
                    $sql->bindParam($clave["campo_marcador"], $clave["campo_valor"]);
                } else {
                    // De lo contrario, bindear el valor normalmente
                    $sql->bindParam($clave["campo_marcador"], $clave["campo_valor"]);
                }
            }
        
            $sql->execute();
        
            return $sql;
        }

        public function seleccionarDatos($tipo,$tabla,$campo,$id){
            $tipo=$this->limpiarCadena($tipo);
            $tabla=$this->limpiarCadena($tabla);
            $campo=$this->limpiarCadena($campo);
            $id=$this->limpiarCadena($id);

            //Unico hace referenica a una sola fila o a una seleccion de algo unico
            if($tipo == "Unico"){
                $sql=$this->conectar()->prepare("SELECT * FROM $tabla WHERE $campo=:id");
                $sql->bindParam(":id",$id);

            }elseif($tipo=="Normal"){
                //Normal hace referenica a una seleccion de un campo con todos sus registros de una tabla
                $sql=$this->conectar()->prepare("SELECT $campo FROM $tabla ");


            }elseif($tipo=="Menu"){
                //Menu hace referencia a la seleccion de una tabla para cargar un menu desplegable
                $sql=$this->conectar()->prepare("SELECT * FROM $tabla ");
            }

            $sql->execute();
            return $sql;
        }

        protected function actualizarDatos($tabla,$datos,$condicion){
            $query = "UPDATE $tabla SET ";

            $contador = 0;

            foreach($datos as $clave){
                if($contador>=1){$query.=",";}

                $query.=$clave["campo_nombre"]."=".$clave["campo_marcador"];
                $contador++;
            }

            $query.=" WHERE ".$condicion["condicion_campo"]."=".$condicion["condicion_marcador"];
            $sql = $this->conectar()->prepare($query);

            foreach($datos as $clave){
                if($clave["campo_marcador"]==":Clave"){
                    $sql->bindParam($clave["campo_marcador"],"aes_encrypt(".$clave["campo_valor"].",'PEPE')");
                }
                $sql->bindParam($clave["campo_marcador"],$clave["campo_valor"]);

            }
            $sql->bindParam($condicion["condicion_marcador"],$condicion["condicion_valor"]);

            $sql->execute();
            return $sql;
        }

        protected function actualizarDatosConClave($tabla, $datos, $condicion) {
            $query = "UPDATE $tabla SET ";
            $contador = 0;
        
            foreach($datos as $clave){
                if($contador >= 1) {
                    $query .= ",";
                }
        
                if($clave["campo_marcador"] == ":Clave") {
                    $query .= $clave["campo_nombre"] . "=AES_ENCRYPT(" . $clave["campo_marcador"] . ", 'PEPE')";
                } else {
                    $query .= $clave["campo_nombre"] . "=" . $clave["campo_marcador"];
                }
                $contador++;
            }
        
            $query .= " WHERE " . $condicion["condicion_campo"] . "=" . $condicion["condicion_marcador"];
            $sql = $this->conectar()->prepare($query);
        
            foreach($datos as $clave){
                $sql->bindParam($clave["campo_marcador"], $clave["campo_valor"]);
            }
            $sql->bindParam($condicion["condicion_marcador"], $condicion["condicion_valor"]);
        
            $sql->execute();
            return $sql;
        }

        protected function eliminarRegistro($tabla,$campo,$id){
            $sql=$this->conectar()->prepare("UPDATE $tabla
                                             SET flag_mostrar = 0,
                                                 ultima_modificacion = '".date("Y-m-d H:i:s")."'
                                             WHERE $campo =:id");
            $sql->bindParam(":id",$id);
            $sql->execute();
            return $sql;
        }

        #Funcion para paginador de tablas
        protected function paginadorTablas($pagina,$NPaginas,$url,$botones){
            $tabla='<nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-center">';

            #Condicion para deshabilitar boton anterior si estamos en la primer pagina
            if($pagina<=1){
                $tabla.='    <li class="page-item disabled">
                                <a class="page-link">Anterior</a>
                            </li>';
            }else{
                $tabla.='    <li class="page-item">
                                <a class="page-link" href="'.$url.($pagina-1).'/">Anterior</a>
                            </li>
                            <li class="page-item"><a class="page-link" href="'.$url.'1/">1</a></li>
                            <li><span class="page-ellipsis">&hellip;</span></li>
                            ';
            }

            $contador_iteraciones=0;
            #El primer argumento sirve para crear los botones desde la pagina donde se encuentre actualmente
            #El segundo argumento valida si i es menor o igual al numero de paginas TOTALES
            #El tercer argumento es el autoincremental para la i
            for($i=$pagina; $i<=$NPaginas; $i++){
                #Corta el cilco for cuando los botones generados son suficientes y asi no generar
                #botones de mas
                if($contador_iteraciones>=$botones){
                    break;
                }
                #Para saber si nos encontramos en la pagina actual que se genera
                #Crea el boton RESALTADO en el paginador
                if($pagina==$i){

                    $tabla.='
                        <li class="page-item active"><a class="page-link" href="'.$url.$i.'/">'.$i.'</a></li>
                    ';
                }else{
                    $tabla.='
                    <li class="page-item"><a class="page-link" href="'.$url.$i.'/">'.$i.'</a></li>
                    ';
                }
                $contador_iteraciones++;
            }

            #Condicion para deshabilitar boton siguiente si estamos en la ULTIMA pagina
            if($pagina==$NPaginas){
                $tabla.='<li class="page-item disabled" disabled><a class="page-link">Siguiente</a></li>';
            }else{
                $tabla.='
                <li><span class="page-ellipsis">&hellip;</span></li>
                <li class="page-item"><a class="page-link" href="'.$url.$NPaginas.'/">'.$NPaginas.'</a></li>
                <li class="page-item"><a class="page-link" href="'.$url.($pagina+1).'/">Siguiente</a></li>
                ';
            }

            // Cerramos el paginador
            $tabla.='</ul></nav>';

            return $tabla;
        }

        }

?>