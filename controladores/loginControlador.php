<?php

	if($peticionAjax){
		require_once "../modelos/loginModelo.php";
	}else{
		require_once "./modelos/loginModelo.php";
	}

	class loginControlador extends loginModelo{

        /* controlador iniciar sesion  ---- 
        recordar que la vista login-view.php es el unico que no va
        trabajar con ajax y sera enviada en la misma vista */
        public function iniciar_sesion_controlador(){
            $usuario= mainModel::limpiar_cadena($_POST['usuario_log']);
            $clave= mainModel::limpiar_cadena($_POST['clave_log']);


            /* comprobar vacios*/

            if($usuario=="" || $clave==""){
                echo  '
                <script>
                Swal.fire({
                    title: "ocurre un error inesperado",
                    text: "no has llenado todos los campos",
                    type: "error",
                    confirmButtonText:"Aceptar ajax clave"
                });
                </script>
                
                ';
                exit();

            }

            /* verificar integridad de los datos*/
            if(mainModel::verificar_datos("[a-zA-Z0-9]{1,35}",$usuario)){
                echo  '
                <script>
                Swal.fire({
                    title: "ocurre un error inesperado",
                    text: "el nombre de usuraio no concide con el formato solicitado",
                    type: "error",
                    confirmButtonText:"Aceptar ajax clave"
                });
                </script>
                
                ';
                exit();
            }

            if(mainModel::verificar_datos("[a-zA-Z0-9$@.-]{7,100}",$clave)){
                echo  '
                <script>
                Swal.fire({
                    title: "ocurre un error inesperado",
                    text: "la clave no concide con el formato solicitado",
                    type: "error",
                    confirmButtonText:"Aceptar ajax clave"
                });
                </script>
                
                ';
                exit();
            }

            $clave=mainModel::encryption($clave);

            $datos_login=[
                "Usuario"=>$usuario,
                "Clave"=>$clave
            ];

            $datos_cuenta=loginModelo::iniciar_sesion_modelo($datos_login);
            if($datos_cuenta->rowCount()==1){
                $row=$datos_cuenta->fetch();

                session_start(['name'=>'SPM']);
                $_SESSION['id_spm']=$row['usuario_id'];
                $_SESSION['nombre_spm']=$row['usuario_nombre'];
                $_SESSION['apellido_spm']=$row['usuario_apellido'];
                $_SESSION['usuario_spm']=$row['usuario_usuario'];
                $_SESSION['privilegio_spm']=$row['usuario_privilegio'];
                $_SESSION['token_spm']=md5(uniqid(mt_rand(),true));

                return header("Location: ".SERVERURL."home/");
                

            }else{
                echo  '
                <script>
                Swal.fire({
                    title: "ocurre un error inesperado",
                    text: "usuario o clave son incorrectas",
                    type: "error",
                    confirmButtonText:"Aceptar ajax clave"
                });
                </script>
                
                ';
            }

        }

        /* CONTROLADOR FORZAR CIEERRE*/
        public function forzar_cierre_session_controlador(){
            session_unset();
            session_destroy();
            if(headers_sent()){ //headers_sent verifica si se esta enviando encabwzados php
//vamos a enviar al usuario al login usando javascrip
                return "<script> window.location.href='".SERVERURL."login/';</script>";
            }else{
// se envia directo al login con php
                return header("Location: ".SERVERURL."login/");
            }   
        }


          /* CONTROLADOR FORZAR CIEERRE*/
          public function cerrar_session_controlador(){
            session_start(['name'=>'SPM']);
            $token=mainModel::decryption($_POST['token']);
            $usuario=mainModel::decryption($_POST['usuario']);

            if($token==$_SESSION['token_spm'] && $usuario==$_SESSION['usuario_spm'])
            {
                
                session_unset();
                session_destroy();
                $alerta=[
                    "Alerta"=>"redireccionar",
                    "URL"=>SERVERURL."login/"
                ];

            }else{
                $alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"no se pudo cerrar la sesion ",
					"Tipo"=>"error"
				];
            }
            echo json_encode($alerta);
          }


    }