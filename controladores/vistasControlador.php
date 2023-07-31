<?php

    require_once "./modelos/vistasModelo.php" ;// require permite incluir ese archivo

    class vistasControlador extends vistasModelo{
          /*
        ----controlador obtener plantilla-----
        todos los controladores son publicos para poder acceder  fuera de las clases cuando s eheredan
        */

        public function obtener_plantilla_controlador(){
            return require_once "./vistas/plantilla.php";
        }

          /*
        ----controlador obtener vistas-----
        */

        public function obtener_vistas_controlador(){
            if(isset($_GET['views'])){ // el valor views=$1 viene de la configuracion en .htaccess
                $ruta=explode("/",$_GET['views']);
                $respuesta=vistasModelo::obtener_vistas_modelo($ruta[0]);
            }else{
                $respuesta="login";
            }
            return $respuesta;
        }



    }
