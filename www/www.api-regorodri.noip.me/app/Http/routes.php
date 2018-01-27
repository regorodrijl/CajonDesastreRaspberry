<?php
// ACORDARSE DE AÑADIR LA CLASE!!!!!!!!!!!!!!!
use App\Aeropuerto;
require_once('C:/dominios/info.local/funciones/funciones.php');
/*
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
}*/
//use DB;
Route:: group(array('prefix'=>'api'),function()
{
	//Route::get('/aeropuertos', array('uses' => 'AeropuertoController'))  
	Route::resource('aeropuertos','AeropuertoController',[ 'only'=>['index','show','update','destroy','store']]);
	Route::get('/', function()
	{
		$country='spain';
		$city='Santiago de Compostela';

		$dato = file_get_contents("http://www.info.local/api/weather/spain/santiago_de_compostela");
		$dato=json_decode($dato);
		

		return View('homePage',array('pais'=>$country,'ciudad'=>$city,'meteo'=>$dato));
		//return view('homePage');
	});



	Route::get('aeropuertos/{latitud}/{longitud}/{distancia}', function($latitud,$longitud,$distancia)
	{

		$esquinaArriba = geo_destination([$latitud,$longitud],$distancia,-45);
		$esquinaAbajo = geo_destination([$latitud,$longitud],$distancia,135);

		$consulta = DB::table('aeropuertos')->whereBetween('latitud',[$esquinaAbajo[0],$esquinaArriba[0]])->whereBetween('longitud',[$esquinaArriba[1],$esquinaAbajo[1]])->get();
		
		return response()->json(['status'=>'ok','datos'=>$consulta],200);

	});
	Route::get('/weather/{country}/{city}', function($country,$city)
	{
	//peticion
		$country = str_replace(" ", "_", $country);
		$city = str_replace(" ", "_", $city);

		$json_string = file_get_contents("http://api.wunderground.com/api/61f45636d937aab9/conditions/forecast/lang:SP/q/$country/$city.json");
		
		$objeto = new stdClass();

		$parsed_json = json_decode($json_string);		

		$objeto->situacion = $parsed_json->current_observation->display_location->full;
		$objeto->tiempo = $parsed_json->current_observation->weather;
		$objeto->temperatura_actual = $parsed_json->current_observation->temp_c;
		$objeto->humedad_relativa = $parsed_json->current_observation->relative_humidity;

			//array("dia"=>);
			$prevision= $parsed_json->forecast->txt_forecast->forecastday;//->date;
			//var_dump($prevision);
			foreach ($prevision as $value) {
				$objPred= new stdClass();

				$objPred->dia = $value->title;
				$objPred->texto = $value->fcttext_metric;
				$objPred->icono = $value->icon_url;

				$objeto->predicciones[]=$objPred;
			}

			//var_dump(json_encode($objeto));
			return response()->json(['status'=>'ok','data'=>$objeto],200);


		});



	Route::get('aeropuertos/{country}/{city}',function($country,$city)
	{
	//return "Los country y city aeropuerto";
		$pais=Aeropuerto::where('pais', $country)->first();
		$ciudad=Aeropuerto::where('ciudad', $city)->first();
		if (!$pais||!$ciudad ) {
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un PAIS con ese NOMBRE.'])],404);
		}else{

			$dato=DB::table('aeropuertos')->where('pais', $country)->where('ciudad', $city)->get();
//$dato=Section::select('pais, ciudad')->where($country, $city)->get();
			return response()->json(['status'=>'ok','data'=>$dato],200);
		}
	});
	Route::get('aeropuerto/{DATO}',function($dato)
	{
		$dato=strtoupper($dato);
		if($dato==null || strlen($dato)>=5 || strlen($dato)<=2 ){
			return "Faltan/Sobran datos!";
		}elseif (strlen($dato)==3) {
// IATA
			$aeropuerto=Aeropuerto::where('iata', $dato)->first();
			if (!$aeropuerto)
			{
	// Se devuelve un array errors con los errores encontrados y cabecera HTTP 404.
	// En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
				return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un aeropuerto con ese código IATA.'])],404);
			}

			return response()->json(['status'=>'ok','data'=>$aeropuerto],200);


		}elseif (strlen($dato)==4) {
// ICAO
			$aeropuerto=Aeropuerto::where('icao', $dato)->first();
			if (!$aeropuerto)
			{
	// Se devuelve un array errors con los errores encontrados y cabecera HTTP 404.
	// En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
				return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un aeropuerto con ese código ICAO.'])],404);
			}

			return response()->json(['status'=>'ok','data'=>$aeropuerto],200);
		}

//return "Los country y city aeropuerto";
	});
/*
Route::get('aeropuerto/{ICAO}',function($icao)
{
	return "Los country y city aeropuerto";
});*/
});

