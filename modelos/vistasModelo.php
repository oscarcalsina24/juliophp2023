<?php

        class vistasModelo{
        /*
        ----modelo para obtener vistas-----
        todos los modelos son protegidos ya que interactuan con la base de datos
        */
        protected static function obtener_vistas_modelo($vistas){ 
            /* protected es para seguridad y sttaic para utilizar de forma rapida*/
            $listaBlanca=["client-list","client-new","client-search","client-update","company","home","item-list","item-new","item-search","item-update","reservation-list","reservation-new","reservation-pending","reservation-search","reservation-update","user-list","reservation-reservation","user-new","user-search","user-update"];
			
            if(in_array($vistas,$listaBlanca)){ //in_array comprueba si valor esta en un array de datos

                    if(is_file("./vistas/contenidos/".$vistas."-view.php")){ 
                        /* 
                        is_file compruiba si hay un archivo mediante un url mediante el directorio.
                        se coloca el ./vistas por que esta carpeta esta al inicio del archivo index que es principal
                        */
                        $contenido="./vistas/contenidos/".$vistas."-view.php";
                    }else{
                        $contenido="404";
                    }
            
            
            }elseif($vistas=="login"||$vistas=="index"){
                $contenido="login";
            }else{
                $contenido="404";
            }
            return $contenido;

        }

        
        }