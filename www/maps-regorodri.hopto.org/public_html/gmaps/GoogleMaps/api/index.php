<?php
require 'database.php';

require 'Slim/Slim.php';
\Slim\Slim::registerAutoloader();

// Conexión a la base de datos.
$pdo=Database::get_conexion();

// Nueva instancia de Slim Framework.
$app = new \Slim\Slim();

// Indicamos el tipo de contenido y condificación que devolvemos desde el framework Slim.
// Por defecto vamos a devolver application/json
$app->contentType('application/json; charset=utf-8');

// Página por defecto:
$app->get('/',function() use($app)
{
    // Cambiamos el content-type para mostrar mensaje en HTML
    $app->contentType('text/html; charset=utf-8');
    echo "<h2>Bienvenido al servicio web Airports REST API.</h2>";
    echo "<h3>Referencia de la API REST:</h3>";
    echo "<li>GET /countries/</li><li>GET /airports/</li><li>GET /airports/country</li><li>GET /airports/country/city</li><li>GET /airport/IATA  (3 letters)</li><li>GET /airport/ICAO (4 letters)</li><li>PUT /airports/ICAO</li><li>POST /airports/</li><li>DELETE /airports/ICAO</li><li>GET /weather/country/city </li><li>GET /airportsmap/latitude/longitude/distance</li><li>Santiago coordinates for testing purposes: (42.896333,-8.415144)</li>";
});

// Comenzamos a programar la API REST.

$app->get('/airports',function() use ($pdo)
{
    try{
        $consulta = $pdo->prepare("select * from aeropuertos order by aeropuerto");
        $consulta->execute();
        // Creamos  un objeto que es lo que enviaremos en formato JSON.
        // Nuestro objeto tendrá una propiedad estado y una propiedad datos con todos los registros.
        $enviar = new stdClass();
        $enviar->estado="ok";
        // Almacenamos en la propiedad datos los registros en formato array asociativo.
        $enviar->datos=$consulta->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($enviar);
    }
    catch(PDOException $error)
    {
        echo('{"estado":"Error en consulta SQL"}');
    }
});


$app->get('/airports/:country',function($pais) use ($pdo)
{
    try{
        $consulta = $pdo->prepare("select * from aeropuertos where pais=? order by aeropuerto");
        $consulta->bindValue(1,$pais);
        $consulta->execute();
        // Creamos  un objeto que es lo que enviaremos en formato JSON.
        // Nuestro objeto tendrá una propiedad estado y una propiedad datos con todos los registros.
        $enviar = new stdClass();
        $enviar->estado="ok";
        // Almacenamos en la propiedad datos los registros en formato array asociativo.
        $enviar->datos=$consulta->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($enviar);
    }
    catch(PDOException $error)
    {
        echo('{"estado":"Error en consulta SQL"}');
    }
});


$app->get('/airports/:country/:city',function($pais,$ciudad) use ($pdo)
{
    try{
        $consulta = $pdo->prepare("select * from aeropuertos where pais=? and ciudad=? order by aeropuerto");
        $consulta->bindValue(1,$pais);
        $consulta->bindValue(2,$ciudad);
        $consulta->execute();
        // Creamos  un objeto que es lo que enviaremos en formato JSON.
        // Nuestro objeto tendrá una propiedad estado y una propiedad datos con todos los registros.
        $enviar = new stdClass();
        $enviar->estado="ok";
        // Almacenamos en la propiedad datos los registros en formato array asociativo.
        $enviar->datos=$consulta->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($enviar);    
    }
    catch(PDOException $error)
    {
        echo('{"estado":"Error en consulta SQL"}');
    }
});


$app->get('/airport/:icaoiata',function($icaoiata) use ($pdo)
{
    try{
        if (strlen($icaoiata)==3)
            $consulta = $pdo->prepare("select * from aeropuertos where iata=?");
        else
            $consulta = $pdo->prepare("select * from aeropuertos where icao=?");   

        $consulta->bindValue(1,$icaoiata);
        $consulta->execute();
        // Creamos  un objeto que es lo que enviaremos en formato JSON.
        // Nuestro objeto tendrá una propiedad estado y una propiedad datos con todos los registros.
        $enviar = new stdClass();
        $enviar->estado="ok";
        // Almacenamos en la propiedad datos los registros en formato array asociativo.
        $enviar->datos=$consulta->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($enviar);    
    }
    catch(PDOException $error)
    {
        echo('{"estado":"Error en consulta SQL"}');
    }
});


// Actualización de registros.
$app->put('/airports/:icao',function($icao) use ($pdo)
{
    try{
        $consulta = $pdo->prepare("update aeropuertos set aeropuerto=?,ciudad=?,pais=?,iata=?,icao=?,latitud=?,longitud=?, elevacion=?, utc=?, dst=? where icao=?");
        $consulta->bindValue(1,$app->request->post('aeropuerto'));
        $consulta->bindValue(2,$app->request->post('ciudad'));
        $consulta->bindValue(3,$app->request->post('pais'));
        $consulta->bindValue(4,$app->request->post('iata'));
        $consulta->bindValue(5,$app->request->post('icao'));
        $consulta->bindValue(6,$app->request->post('latitud'));
        $consulta->bindValue(7,$app->request->post('longitud'));
        $consulta->bindValue(8,$app->request->post('elevacion'));
        $consulta->bindValue(9,$app->request->post('utc'));
        $consulta->bindValue(10,$app->request->post('dst'));
        $consulta->bindValue(11,$icao);

        $consulta->execute();

        // Creamos  un objeto que es lo que enviaremos en formato JSON.
        // Nuestro objeto tendrá una propiedad estado y una propiedad datos con todos los registros.
        $enviar = new stdClass();
        
        if ($consulta->rowCount()==1)
            $enviar->estado="ok";
        else
            $enviar->estado="Error: no se encuentra el código ICAO indicado.";

        echo json_encode($enviar);
    }
    catch(PDOException $error)
    {
        echo('{"estado":"Error: datos incompletos."}');
    }
});



// Inserción de registros.
$app->post('/airports',function() use ($pdo,$app)
{
    try{
        $consulta = $pdo->prepare("insert into aeropuertos(aeropuerto,ciudad,pais,iata,icao,latitud,longitud,elevacion,utc,dst) values(?,?,?,?,?,?,?,?,?,?)");
        $consulta->bindValue(1,$app->request->post('aeropuerto'));
        $consulta->bindValue(2,$app->request->post('ciudad'));
        $consulta->bindValue(3,$app->request->post('pais'));
        $consulta->bindValue(4,$app->request->post('iata'));
        $consulta->bindValue(5,$app->request->post('icao'));
        $consulta->bindValue(6,$app->request->post('latitud'));
        $consulta->bindValue(7,$app->request->post('longitud'));
        $consulta->bindValue(8,$app->request->post('elevacion'));
        $consulta->bindValue(9,$app->request->post('utc'));
        $consulta->bindValue(10,$app->request->post('dst'));
        
        $consulta->execute();

        // Creamos  un objeto que es lo que enviaremos en formato JSON.
        // Nuestro objeto tendrá una propiedad estado y una propiedad datos con todos los registros.
        $enviar = new stdClass();
        $enviar->estado="ok";
        echo json_encode($enviar);
    }
    catch(PDOException $error)
    {
        echo('{"estado":"Error: datos incompletos."}');
    }
});


// Actualización de registros.
$app->delete('/airports/:icao',function($icao) use ($pdo)
{
    try{
        $consulta = $pdo->prepare("delete from aeropuertos where icao=?");
        $consulta->bindValue(1,$icao);
        $consulta->execute();

        // Creamos  un objeto que es lo que enviaremos en formato JSON.
        // Nuestro objeto tendrá una propiedad estado y una propiedad datos con todos los registros.
        $enviar = new stdClass();
        
        if ($consulta->rowCount()==1)
            $enviar->estado="ok";
        else
            $enviar->estado="Error: no se encuentra el código ICAO indicado.";

        echo json_encode($enviar);
    }
    catch(PDOException $error)
    {
        echo('{"estado":"Error en consulta SQL"}');
    }
});


// Meteorología haciendo uso de un servicio web externo wunderground.:
$app->get('/weather/:country/:city', function($pais,$ciudad)
{
    $codigoAPI="61f45636d937aab9";

    // Petición a la API REST de wunderground. Devolverá un json.
    $solicitud=file_get_contents("http://api.wunderground.com/api/$codigoAPI/conditions/forecast/lang:SP/q/" . str_replace(' ', '_', $pais) . "/" . str_replace(' ', '_', $ciudad) . ".json");

    $solicitud=json_decode($solicitud);

    // Creamos el objeto que vamos a enviar como respuesta.
    $enviar=new stdClass();

    if (isset($solicitud->response->error) || isset($solicitud->response->results))
    {
        $enviar->estado="Error: City not found or multiples cities with the same name.";
    }
    else
    {
        $enviar->estado="ok";

        $enviar->situacion=$solicitud->current_observation->display_location->full;
        $enviar->tiempo=$solicitud->current_observation->weather;
        $enviar->temperatura_actual=$solicitud->current_observation->temp_c;
        $enviar->humedad_relativa=$solicitud->current_observation->relative_humidity;
        $enviar->predicciones=array();

        // Sacar todas las predicciones.
        foreach($solicitud->forecast->txt_forecast->forecastday as $predictions)
        {
            $prediccion=new stdClass();
            $prediccion->dia=$predictions->title;
            $prediccion->texto=$predictions->fcttext_metric;
            $prediccion->icono=$predictions->icon_url;
            $enviar->predicciones[]=$prediccion;
        }
    }

    echo json_encode($enviar);

});

// Localizacion de aeropuertos en una zona de un mapa y a una distancia determinada.
$app->get('/airportsmap/:latitude/:longitude/:distance',function($latitud,$longitud,$distancia) use ($pdo)
{

    // Cálculo de las coordenadas de las esquinas del cuadrado
    // A -> punto superior izquierdo. array (latitud, longitud) -45 grados.
    // B -> punto inferior derecho. +135 (90+45)
    $a = geo_destination([$latitud,$longitud],$distancia,-45);
    $b = geo_destination([$latitud,$longitud],$distancia,135);

    try{
        $consulta = $pdo->prepare("select * from aeropuertos where latitud<=? and latitud>=? and longitud>=? and longitud<=? ");
        $consulta->bindParam(1,$a[0]);
        $consulta->bindParam(2,$b[0]);
        $consulta->bindParam(3,$a[1]);
        $consulta->bindParam(4,$b[1]);

        $consulta->execute();
        // Creamos  un objeto que es lo que enviaremos en formato JSON.
        // Nuestro objeto tendrá una propiedad estado y una propiedad datos con todos los registros.
        $enviar = new stdClass();
        $enviar->estado="ok";
        // Almacenamos en la propiedad datos los registros en formato array asociativo.
        $enviar->datos=$consulta->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($enviar);    
    }
    catch(PDOException $error)
    {
        echo('{"estado":"Error en consulta SQL"}');
    }
});


// Localizacion de aeropuertos en una zona de un mapa en base a coordenadas superior derecha e inferior izquierda.
$app->get('/airportsmap/:latNE/:lonNE/:latSW/:lonSW/',function($latNE, $lonNE, $latSW, $lonSW) use ($pdo)
{

    try{
        $consulta = $pdo->prepare("select * from aeropuertos where latitud<=? and latitud>=? and longitud<=? and longitud>=?");
        $consulta->bindParam(1,$latNE);
        $consulta->bindParam(2,$latSW);
        $consulta->bindParam(3,$lonNE);
        $consulta->bindParam(4,$lonSW);

        $consulta->execute();
        // Creamos  un objeto que es lo que enviaremos en formato JSON.
        // Nuestro objeto tendrá una propiedad estado y una propiedad datos con todos los registros.
        $enviar = new stdClass();
        $enviar->estado="ok";
        // Almacenamos en la propiedad datos los registros en formato array asociativo.
        $enviar->datos=$consulta->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($enviar);    
    }
    catch(PDOException $error)
    {
        echo('{"estado":"Error en consulta SQL"}');
    }
});


// Listado de paises
$app->get('/countries',function() use ($pdo)
{
    try{
        $consulta = $pdo->prepare("select distinct pais from aeropuertos order by pais asc");
        $consulta->execute();
        // Creamos  un objeto que es lo que enviaremos en formato JSON.
        // Nuestro objeto tendrá una propiedad estado y una propiedad datos con todos los registros.
        $enviar = new stdClass();
        $enviar->estado="ok";
        // Almacenamos en la propiedad datos los registros en formato array normal.
        $enviar->datos=$consulta->fetchAll(PDO::FETCH_COLUMN);
        echo json_encode($enviar);    
    }
    catch(PDOException $error)
    {
        echo('{"estado":"Error en consulta SQL"}');
    }
});


// Para que las peticiones a nuestra API funcionen bien con file_get_contents
// Enviar esta cabecera de cierre de conexión cuando termine la solicitud.
header('Connection: close');

$app->run();


/**
 * Calculate a new coordinate based on start, distance and bearing
 *
 * @param $start array - start coordinate as decimal lat/lon pair
 * @param $dist  float - distance in kilometers
 * @param $brng  float - bearing in degrees (compass direction)
 *
*/

function geo_destination($start,$dist,$brng){
    $lat1 = toRad($start[0]);
    $lon1 = toRad($start[1]);
    $dist = $dist/6371.01; //Earth's radius in km
    $brng = toRad($brng); 

    $lat2 = asin( sin($lat1)*cos($dist) +
      cos($lat1)*sin($dist)*cos($brng) );
    $lon2 = $lon1 + atan2(sin($brng)*sin($dist)*cos($lat1),
      cos($dist)-sin($lat1)*sin($lat2));
    $lon2 = fmod(($lon2+3*pi()),(2*pi())) - pi();  

    return array(toDeg($lat2),toDeg($lon2));
}

function toRad($deg){
    return $deg * pi() / 180;
}

function toDeg($rad){
    return $rad * 180 / pi();
}