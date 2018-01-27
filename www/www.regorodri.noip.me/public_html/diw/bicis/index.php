<?php require "cabecera.php"; ?>
<!-- CARRPUSEL -->

<div class="container">
  <br>
  <div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel" data-slide-to="1"></li>
      <li data-target="#myCarousel" data-slide-to="2"></li>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner" role="listbox">

      <div class="item active">
        <img src="./img/BMX.jpg" alt="Chania" width="460" height="345">
        <div class="carousel-caption">
          <h3><?php echo gettext("moma-BMX");?></h3>
          <p><?php echo gettext("Preparada para el freestyle.");?></p>
        </div>
      </div>

      <div class="item">
        <img src="./img/pro.jpeg" alt="Chania" width="460" height="345">
        <div class="carousel-caption">
          <h3><?php echo gettext("e-Triks");?></h3>
          <p><?php echo gettext("Tu todoterreno, listo para la acción.")?></p>
        </div>
      </div>

      <div class="item">
        <img src="./img/bora.jpg" alt="Flower" width="460" height="345">
        <div class="carousel-caption">
          <h3><?php echo gettext("HK");?></h3>
          <p><?php echo gettext("Especialista en carreteras.")?></p>
        </div>
      </div>

    </div>

    <!-- Left and right controls -->
    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
</div>

<br><br>
<br><br>

<div id="map-container" class="col-md-6"></div>
<script>  

  function init_map() {
    var var_location = new google.maps.LatLng(42.87869,-8.54732);

    var var_mapoptions = {
      center: var_location,
      zoom: 14
    };

    var var_marker = new google.maps.Marker({
      position: var_location,
      map: var_map,
      title:"IES San Clemente"});

    var var_map = new google.maps.Map(document.getElementById("map-container"),
      var_mapoptions);

    var_marker.setMap(var_map); 

  }

  google.maps.event.addDomListener(window, 'load', init_map);

</script>
<br><div></div><br>
<br><br>

<?php require "pie.php"; ?>











