<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Vista Aeropuerto</title>
	<link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

	<style>
		html, body {
			height: 100%;
			font-family:'Leelawadee UI';
			font-weight: bold;
			text-align: center;
		}
		section{
			font-weight: bold;
			color: #f00;
		}
		body {
			margin: 0;
			padding: 0;
			width: 100%;
			display: table;
			font-weight: 100;
			
		}
		table{
			margin: 0 auto;
		}
		.container {
			text-align: center;
			display: table-cell;
			vertical-align: middle;
		}

		.content {
			text-align: center;
			display: inline-block;
		}

		.title {
			font-size: 96px;
		}
	</style>
</head>
<body >
	<h1  >Bienvenido a Laravel</h1>
	<h2>Rutas del ejercicio de la API</h2>
	<article>
		<b>(Using a controller)</b><br/><br/>

		GET / -> show an info page (with a view).<br/>
		GET /api/aeropuertos/ -> json<br/>
		GET /api/aeropuertos/{id_aeropuerto} -> json<br/>
		POST /api/aeropuertos/ -> json<br/>
		PUT /api/aeropuertos/{id_aeropuerto}  -> json<br/>
		DELETE /api/aeropuertos{id_aeropuerto} -> json<br/><br/>

		<b> (Manual Routes)</b><br/><br/>

		GET /api/aeropuertosmapa/latitude/longitude/distance   ---> returns all the airports within a square with center point the lat and long provided and distance (km) around. -> json<br/>
		==> http://www.cosmocode.de/en/blog/gohr/2010-06/29-calculate-a-destination-coordinate-based-on-distance-and-bearing-in-php<br/>

		==> http://www.vitutor.com/geo/eso/as_6.html<br/>

		GET /api/aeropuertos/{country}/{city} -> json<br/>
		GET /api/aeropuerto/{IATA} (3 letters) -> json<br/>
		GET /api/aeropuerto/{ICAO} (4 letters) -> json<br/>
	</article>
	<hr>
	<h2>Predicción para {{ $ciudad }} </h2>
	<h3>Tiempo Actual: {{ $meteo->data->tiempo }}, Tª {{ $meteo->data->temperatura_actual }}ºC, humedad:{{ $meteo->data->humedad_relativa }}  </h3>
	<table >
		@foreach($meteo->data->predicciones as $val)


		<tr>
			<td><strong>Día:</strong></td>
			<td>{{$val->dia}}</td>
		</tr>
		<tr>
			<td><strong>Predicción:</strong></td>
			<td>{{$val->texto}}</td>
		</tr>
		<tr >
			<td colspan="2">
				<img src={{$val->icono}}>
			</td>
		</tr>


		@endforeach

	</table>



</body>
</html>