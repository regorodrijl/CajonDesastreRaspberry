<?php
// Código API BOT:
// 179083320:AAGaSi0J_r9ykw-7irY468_PBouxvTGNhJI

define('BOT_TOKEN','217401414:AAGP0JLg0fVRzngUI2EwzPBKPu2UwR1wq1Q');
define('API_URL','https://api.telegram.org/bot'.BOT_TOKEN);

setlocale(LC_ALL, "es_ES.UTF8");
$variacionHora=date('I',time())+1;

// Funciones de utilidad.
// http://apps.timwhitlock.info/emoji/tables/unicode (Emoticonos en Teclados: copiar código Bytes (UTF-8))
function enviarMensajeTexto($chat_id,$texto,$teclado=false)
{
	if($teclado)
	{
		switch($teclado)
		{
			case 'teclado1':
			$teclado=array(
				'keyboard'=>[ ["A Coruña","Lugo"],["Ourense","Pontevedra"] ],
				'one_time_keyboard' => true
				);
			break;
		}

		$teclado=json_encode($teclado);
		$post = array(
			'chat_id'   => $chat_id,
			'text' => $texto,
			'parse_mode' => 'HTML',
			'reply_markup' => $teclado
			);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,API_URL.'/sendMessage');
		curl_setopt($ch, CURLOPT_POST,1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		$result=curl_exec ($ch);
		curl_close ($ch);
	}
	else
		file_get_contents(API_URL."/sendMessage?chat_id=$chat_id&parse_mode=HTML&text=".urlencode($texto));
}

function enviarFoto($chat_id,$fotografia)
{
	$rutaRealFichero=realpath('./'.$fotografia);
	$post=array(
		'chat_id'=>$chat_id,
		'photo'=> new CURLFile($rutaRealFichero));

	// Creamos la conexión con CURL para enviar el fichero.
	$ch=curl_init();
	curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content/Type:multipart/form-data"));
	curl_setopt($ch, CURLOPT_URL,API_URL."/sendPhoto");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch, CURLOPT_POSTFIELDS,$post);
	curl_exec($ch);
}
function enviarAudio($chat_id,$ficheroAudio)
{
	$rutaRealFichero=realpath('./'.$ficheroAudio);
	$post=array(
		'chat_id'=>$chat_id,
		'audio'=> new CURLFile($rutaRealFichero)
		);
	// Creamos la conexión con CURL para enviar el fichero.
		$ch=curl_init();
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content/Type:multipart/form-data"));
		curl_setopt($ch, CURLOPT_URL,API_URL."/sendAudio");
		curl_setopt($ch, CURLOPT_POST,1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_POSTFIELDS,$post);
		curl_exec($ch);
	}

	function enviarLocalizacion($chat_id,$latitud,$longitud)
	{
		file_get_contents(API_URL."/sendLocation?chat_id=$chat_id&latitude=$latitud&longitude=$longitud");
	}

// Calculamos el último update para que el bot responda solamente
// a las peticiones nuevas desde que se pone a funcionar.
	$ultimoUpdate=0;
	$resultado=file_get_contents(API_URL."/getupdates");
	$resultado=json_decode($resultado);
	$total=sizeof($resultado->result);
	$total--;
	$ultimoUpdate=$resultado->result[$total]->update_id;

// Se ejecuta la consulta de updates cada 3 segundos.
	while (true)
	{
// Al arrancar el bot vamos a consultar los updates.
		$resultado=file_get_contents(API_URL."/getupdates?offset=$ultimoUpdate");

//echo $resultado;
		$resultado=json_decode($resultado);

// Recorremos todos los updates y los vamos respondiendo si fuera necesario.
/*
{
	"ok":true,
	"result":[
	{
		"update_id":522244009,
		"message":{
			"message_id":3,
			"from":{
				"id":4450792,
				"first_name":"Rafa",
				"last_name":"Veiga"
			},
			"chat":{
				"id":4450792,
				"first_name":"Rafa",
				"last_name":"Veiga",
				"type":"private"
			},
			"date":1459284392,
			"text":"Hola"
		}
	},
	{
		"update_id":522244010,
		"message":{
			"message_id":5,
			"from":{
				"id":4450792,
				"first_name":"Rafa",
				"last_name":"Veiga"
			},
			"chat":{
				"id":4450792,
				"first_name":"Rafa",
				"last_name":"Veiga",
				"type":"private"
			},
			"date":1459284399,
			"text":"Que tal?"
		}
	}
	]
}
*/
foreach ($resultado->result as $clave=>$datos)
{
	if ($ultimoUpdate < $datos->update_id)
	{

		$nombre=$datos->message->chat->first_name;
		if (property_exists($datos->message->chat, 'last_name'))
			$apellidos=$datos->message->chat->last_name;
		else
			$apellidos="";

		$update_id=$datos->update_id;
		$comando=$datos->message->text;
		$chat_id=$datos->message->chat->id;
		$ultimoUpdate=$update_id;

	//echo  "Nombre: $nombre, Apellidos: $apellidos, Update ID: $update_id, Texto: $texto<br/>";

		switch($comando)
		{
			case 'A Coruña':
			$comando='/meteo Spain,A Coruña';
			break;
			case 'Lugo':
			$comando='/meteo Spain,Lugo';
			break;
			case 'Pontevedra':
			$comando='/meteo Spain,Pontevedra';
			break;
			case 'Ourense':
			$comando='/meteo Spain,Ourense';
			break;
		}


		switch($comando)
		{
			case '/start':
			enviarMensajeTexto($chat_id,"Comandos disponibles:\n/start Muestra Ayuda\n/hora Muestra hora del sistema\n/salidasol Muestra hora salida del sol\n/puestasol Muestra hora puesta del sol\n/meteogalicia Meteo de Galicia actual\n/obradoiro Imagen del Obradoiro\n/localizacion Localizacion IES San Clemente");
			break;

			case '/hora':
				// Le enviamos la hora al cliente.
			$mensajeHora="Hola $nombre $apellidos. La hora y fecha actual en Santiago es: ".strftime("%A %e de %B de %Y",time())." y son las ".date("H:i:s");
			enviarMensajeTexto($chat_id,$mensajeHora);
			break;

			case '/salidasol':
			enviarMensajeTexto($chat_id,"$nombre, hoy el sol sale en Santiago de Compostela a las ".date_sunrise(time(),SUNFUNCS_RET_STRING,42.8786939968523,-8.547323048114777, 90.70, $variacionHora));
			break;

			case '/puestasol':
			enviarMensajeTexto($chat_id,"$nombre, hoy el sol se pone en Santiago de Compostela a las ".date_sunset(time(),SUNFUNCS_RET_STRING,42.8786939968523,-8.547323048114777, 90.70, $variacionHora));
			break;

			case '/meteogalicia':
			// Conseguimos la foto de la meteo.
			$foto=file_get_contents("http://www.meteogalicia.es/web/predicion/cprazo/getImaxeN.action");
			// Guardamos la foto para enviarla.
			// El servidor web necesita permisos de escritura en el directorio dónde está longpollingbot.php 775 Para el grupo.
			file_put_contents('meteo.jpg',$foto);
			enviarMensajeTexto($chat_id,"Predicción meteorológica en Galicia a las ".date("g:i a")."\n");
			enviarFoto($chat_id,'meteo.jpg');
			break;

			case '/obradoiro':
			// Conseguimos la foto de la meteo.
			$foto=file_get_contents("http://85.91.64.26/obradoiro/readImage.asp");
			// Guardamos la foto para enviarla.
			// El servidor web necesita permisos de escritura en el directorio dónde está longpollingbot.php 775 Para el grupo.
			file_put_contents('obradoiro.jpg',$foto);
			enviarMensajeTexto($chat_id,"Imagen del Obradoiro a las ".date("g:i a")."\n");
			enviarFoto($chat_id,'obradoiro.jpg');
			break;

			case '/localizacion':
			enviarMensajeTexto($chat_id,'Localización del IES San Clemente');
			enviarLocalizacion($chat_id,'42.8786939968523','-8.547323048114777');
			break;

			case (preg_match("/\/meteo (.*),(.*)/",$comando,$coincidencias) ? true:false):

			//print_r($coincidencias);

			// Me conecto a wunderground para obtener predicciones de Madrid.
			// Proceso el JSON
			// Genero una cadena de texto con las predicciones.
			// Envío el mensaje a Telegrama con las predicciones.
			$pais=trim($coincidencias[1]);
			$ciudad=trim($coincidencias[2]);
			$wunderground=json_decode(file_get_contents("http://api.wunderground.com/api/61f45636d937aab9/conditions/forecast/lang:SP/q/" . str_replace(' ', '_', $pais) . "/" . str_replace(' ', '_', $ciudad) . ".json"));

			if (!isset($wunderground->forecast->txt_forecast->forecastday))
				enviarMensajeTexto($chat_id,"No se ha encontrado méteo para la ciudad: <b>".$ciudad."</b>");
			else
			{
				$cadena='<b>Predicción meteorológica para '.ucwords($ciudad)."</b>:\n\n";
				foreach ($wunderground->forecast->txt_forecast->forecastday as $clave => $valor) {
					$cadena.="<b>".$valor->title."</b>: ".$valor->fcttext_metric."\n";
				}

				enviarMensajeTexto($chat_id,$cadena);
			}
			break;

			case '/meteo':
			enviarMensajeTexto($chat_id,"<b>Para consultar la predicción meteorológica de cualquier ciudad escriba</b>:\n/meteo Pais,Ciudad\n\n<b>También puede consultar las 4 provincias gallegas seleccionando en el teclado inferior.</b>","teclado1");
			break;

			case '/audio':
			enviarAudio($chat_id,"audio/champions.mp3");
			break;
		}
	}
}

sleep(3);
}
?>
