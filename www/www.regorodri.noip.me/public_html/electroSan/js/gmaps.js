// GOOGLE-Maps 
function initMap() {
  var latLng = {lat: 46.5496272, lng: 6.513005900000053};
  var mapOptions = {
    zoom: 12,
    center: latLng,
    mapTypeId: 'terrain',
      zoomControl: true,
      scaleControl: false,
  };
  var map = new google.maps.Map(document.getElementById('map'),  mapOptions);
  map.setCenter(latLng);
  var image = {
    url: './img/marcador4.ico',
  };

  var marcador = new google.maps.Marker({
    position: latLng,
    map: map,
    icon: image
  });
  contenido = '<h6>Les Corbes 2  </br>1121 Bremblens</h6>';	 

  var infowindow = new google.maps.InfoWindow({
    content: contenido
  });
  google.maps.event.addListener(marcador, 'click', function(){
    infowindow.open(map,marcador);
  });
}