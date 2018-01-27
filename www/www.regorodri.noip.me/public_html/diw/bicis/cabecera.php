<?php 
//evitamos problemas con las cabeceras
ob_start();
@session_start();
require_once( 'app/gettext/streams.php' );
require_once( 'app/gettext/gettext.php' );
require_once "app/funciones.php";
// Autocarga de clases
spl_autoload_register(function ($clase){
  include_once 'config/'.strtolower($clase).'.php'; 
});

$idioma = (isset($_GET["language"])) ? trim(strip_tags($_GET["language"])) : "es_ES.utf8";
putenv("LANG=$idioma");
putenv("LC_ALL={$idioma}");
setlocale(LC_ALL, $idioma);
if (false === function_exists('gettext'))
{
 echo "No tienes la libreria gettext instalada.";
 exit(1);
}else {
 // echo "INSTALADO";
}
// Define la ubicación de los ficheros de traduccion
bindtextdomain("message", "./locale");
bind_textdomain_codeset('message', 'utf-8');
textdomain("message");
//Mostramos el texto
//echo(gettext("Prueba de texto en castellano"));
/*
$idioma= substr($_SERVER["HTTP_ACCEPT_LANGUAGE"],0,5);
$idioma=str_replace("-", "_", $idioma);

if (isset($_GET['idioma']) && $_GET['idioma']!=''){
  $idioma=$_GET['idioma'];
}else{
  $idioma='es_ES';
}
// inicializar idioma
//$locale = 'en_US'; // o es_ES
// Define el idioma
putenv('LANG=' . $idioma);
setlocale(LC_MESSAGES, $idioma.'.UTF-8');
// Define la ubicación de los ficheros de traducción
bindtextdomain("message", "./locale");
textdomain("message");
*/
?>



<!DOCTYPE html>
<html lang="es">
<head>
  <title>BicisPro</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="css/bootstrap.min.css" rel="stylesheet">   
  <script src="http://maps.google.com/maps/api/js?sensor=false"></script>
  <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/font-awesome/3.1.1/css/font-awesome.css">
  <link href="css/style.css" rel="stylesheet" type="text/css">
  <style type="text/css">
    body {
      background: url(./img/fito.jpg) center center cover no-repeat fixed;
    }
  </style>
</head>
<body style="margin-top: 80px;">
  <nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">

        </button>
        <a class="navbar-brand" href="index.php">BicisPro</a>
      </div>
      <?php   

      if (isset($_SESSION['usuario'])) {

        $admin=comprobarAdmin($_SESSION['usuario']);
        if ($admin==="ok") {

          ?>
          <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
              <li id="alta"><a href="alta.php" >Nuevo Modelo</a></li>
              <li id="baja"><a href="modelo.php">Modelo</a></li>
            </ul>
            <div class="navbar-form navbar-right">
              <a class="btn btn-sm btn " href="index.php?language=es_ES.utf8" role="button">ES</a>
              <a class="btn btn-sm btn " href="index.php?language=en_US.utf8" role="button">EN</a>
              <a class="btn btn-sm btn btn-primary" href="logout.php?cat=logout" role="button"><?php echo gettext("Cerrar Sesión"); ?></a>

            </div>
          </div>

        </div>
      </nav>
      <?php

    }else {

      ?>
      <div id="navbar" class="collapse navbar-collapse">
        <ul class="nav navbar-nav">

         <li id="modificar"><a href="modelo.php">Modelos</a></li>
       </ul>
       <div class="navbar-form navbar-right">
        <a class="btn btn-sm btn " href="index.php?language=es_ES.utf8" role="button">ES</a>
        <a class="btn btn-sm btn " href="index.php?language=en_US.utf8" role="button">EN</a>
        <a class="btn btn-sm btn btn-primary" href="logout.php?cat=logout" role="button"><?php echo gettext("Cerrar Sesión"); ?></a>

      </div>
    </div>
    <div>
    </div>
  </nav>
  <?php

}

}else{
  ?>
  <div id="navbar" class="collapse navbar-collapse">
    <ul class="nav navbar-nav">
       <!-- <li id="alta"><a href="alta.php?cat=alta" >Alta Anuncios</a></li>
        <li id="baja"><a href="baja.php?cat=baja">Bajas de Anuncios</a></li>
        <li id="modificar"><a href="modificar.php?cat=modificar">Modificar Anuncios</a></li>-->
      </ul>
      <div class="navbar-form navbar-right">
        <a class="btn btn-sm btn " href="index.php?language=es_ES.utf8" role="button">ES</a>
        <a class="btn btn-sm btn " href="index.php?language=en_US.utf8" role="button">EN</a>
        <a class="btn btn-sm btn btn-primary" href="login.php" role="button"><?php echo gettext("Sign in"); ?></a>
        <a class="btn btn-sm btn-success" href="registro.php" role="button"><?php echo gettext("Registrarse"); ?></a>
      </div>
    </div><!--/.nav-collapse -->
    <div>
    </div>
  </nav>
  <h3 class="reg"><?php echo gettext("Registrate para conoces nuestros modelos."); ?></<h3></h3><br>
  <?php  }
  ?>