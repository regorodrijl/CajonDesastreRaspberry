<?php 
// Autocarga de clases
@session_start();
spl_autoload_register(function ($clase){
  include_once 'clases/'.strtolower($clase).'.php'; 

});
require_once "funciones.php";

?>
<script src="./js/jquery-2.2.0.js"></script>
<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-86031054-1', 'auto');
    ga('send', 'pageview');
  </script>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <title>TusAnuncios.CoM</title>

  <!-- Bootstrap -->
  <link href="css/bootstrap.min.css" rel="stylesheet">     

</head>
<body style="margin-top: 80px;">
  <nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">

        </button>
        <a class="navbar-brand" href="index.php">TusAnuncios.CoM</a>
      </div>
      <?php   
      if(isset($_SESSION['usuario'])) {
        //echo "Bienvenido!!!!!!!!!";
        ?>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li id="alta"><a href="alta.php?cat=alta" >Nuevo Anuncios</a></li>
            <li id="baja"><a href="anuncios.php?cat=anuncios">Mis Anuncios</a></li>
            <li id="baja"><a href="categoria.php?cat=categoria">Todos los Anuncios</a></li>
            <li id="categoria"><a href="logout.php?cat=logout">Cerrar Sesión</a></li>

          </ul>
          <div class="navbar-form navbar-right">
            <a class="btn btn-sm btn btn-primary" href="#" role="button">Avatar! Futuro Desplegable</a>
            
          </div>
        </div><!--/.nav-collapse -->

      </div>
    </nav>
    <?php 
  }else{
    ?>


    <div id="navbar" class="collapse navbar-collapse">
      <ul class="nav navbar-nav">
       <!-- <li id="alta"><a href="alta.php?cat=alta" >Alta Anuncios</a></li>
        <li id="baja"><a href="baja.php?cat=baja">Bajas de Anuncios</a></li>
        <li id="modificar"><a href="modificar.php?cat=modificar">Modificar Anuncios</a></li>-->
        <li id="categoria"><a href="categoria.php?cat=categoria">Ver Anuncios</a></li>

      </ul>
      <div class="navbar-form navbar-right">
        <a class="btn btn-sm btn btn-primary" href="login.php" role="button">Login</a>
        <a class="btn btn-sm btn-success" href="registro.php" role="button">Registrarse</a>
      </div>
    </div><!--/.nav-collapse -->
    <div>
    </div>
  </nav>
  <?php  
  if (!empty($_GET['cat'])) { 
    ?>
    <script>
      document.getElementById('<?= $_GET["cat"] ?>').setAttribute('class','active');
    </script>
    <?php } }
    ob_end_flush();
    ?>