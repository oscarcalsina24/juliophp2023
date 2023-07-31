<?php

    require_once "./config/APP.php";
    require_once "./controladores/vistasControlador.php";

    $plantilla = new vistasControlador();
   //la flecha ->significa instancia
    $plantilla->obtener_plantilla_controlador();

