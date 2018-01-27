<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Response;
use App\Http\Controllers\Controller;
// ACORDARSE DE AÑADIR LA CLASE!!!!!!!!!!!!!!!
use App\Aeropuerto;
// Activamos uso de caché.
use \Illuminate\Support\Facades\Cache;
class AeropuertoController extends Controller
{
	public function index()
	{
		//return "devolveria todos los aeropuertos";
		// // Devolverá todos los aeropuertos
		return response()->json(['status'=>'ok','data'=>Aeropuerto::all()], 200);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		// 
		return "Se muestra formulario para crear un fabricante.";

	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{

				//ME DICE QUE FALTAN DATOS ---------->>>

		// Primero comprobaremos si estamos recibiendo todos los campos.
		if (empty($request->input('aeropuerto')) || empty($request->input('ciudad')) || empty($request->input('pais')) || empty($request->input('iata')) || empty($request->input('icao')) || empty($request->input('latitud')) || empty($request->input('longitud')) || empty($request->input('elevacion')) || empty($request->input('utc')) || empty($request->input('dst')))
		{
			// Se devuelve un array errors con los errores encontrados y cabecera HTTP 422 Unprocessable Entity – [Entidad improcesable] Utilizada para errores de validación.
			// En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
			return response()->json(['errors'=>array(['code'=>422,'message'=>'Faltan datos necesarios para el proceso de alta.'])],422);
		}

		// Insertamos una fila en Fabricante con create pasándole todos los datos recibidos.
		// En $request->all() tendremos todos los campos del formulario recibidos.
		$nuevoAeropuerto=Aeropuerto::create($request->all());

		// Más información sobre respuestas en http://jsonapi.org/format/
		// Devolvemos el código HTTP 201 Created – [Creada] Respuesta a un POST que resulta en una creación. Debería ser combinado con un encabezado Location, apuntando a la ubicación del nuevo recurso.
		$response = Response::make(json_encode(['data'=>$nuevoAeropuerto]), 201)->header('Location', 'http://www.info.local/api/aeropuertos/'.$nuevoAeropuerto->id)->header('Content-Type', 'application/json');
		return $response;
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
		$aeropuerto=Aeropuerto::find($id);
		//return $aeropuerto;
		// Si no existe ese fabricante devolvemos un error.
		if (!$aeropuerto)
		{
			// Se devuelve un array errors con los errores encontrados y cabecera HTTP 404.
			// En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un fabricante con ese código.'])],404);
		}

		return response()->json(['status'=>'ok','data'=>$aeropuerto],200);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
		return "Se muestra formulario para editar Fabricante con id: $id";
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request $request,$id)
	{
		//		return "hacer update";
		//		comprobamos si existe id
		$aeropuerto=Aeropuerto::find($id);
		// si no existe return error
		if (!$aeropuerto) {
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra Aeropuerto con ese id para modificar/put'])]);
		}
		// Listado de campos recibidos teóricamente.
		$aero=$request->input('aeropuerto');
		$ciudad=$request->input('ciudad');
		$pais=$request->input('pais');
		$iata=$request->input('iata');
		$icao=$request->input('icao');
		$latitud=$request->input('latitud');
		$longitud=$request->input('longitud');
		$elevacion=$request->input('elevacion');
		$utc=$request->input('utc');
		$dst=$request->input('dst');
		// detectarmos que peticion nos llega con el $request->method();
		// PATCH actualizacion parcial
		if ($request->method()==='PATCH') {
			// la bandera es para controlar si se cambia algun datos en este metodo.
			$bandera=false;
			if ($aero) {
				$aeropuerto->aeropuerto=$aero;
				$bandera=true;
			}if ($ciudad) {
				$aeropuerto->ciudad=$ciudad;
				$bandera=true;
			}if ($pais) {
				$aeropuerto->pais=$pais;
				$bandera=true;
			}if ($iata) {
				$aeropuerto->iata=$iata;
				$bandera=true;
			}if ($icao) {
				$aeropuerto->icao=$icao;
				$bandera=true;
			}if ($latitud) {
				$aeropuerto->latitud=$latitud;
				$bandera=true;
			}if ($longitud) {
				$aeropuerto->longitud=$longitud;
				$bandera=true;
			}if ($elevacion) {
				$aeropuerto->elevacion=$elevacion;
				$bandera=true;
			}if ($utc) {
				$aeropuerto->utc=$utc;
				$bandera=true;
			}if ($dst) {
				$aeropuerto->dst=$dst;
				$bandera=true;
			}
			if ($bandera)
			{
				// Almacenamos en la base de datos el registro.
				$aeropuerto->save();
				return response()->json(['status'=>'ok','data'=>$aeropuerto], 200);
			}
			else
			{
				// Se devuelve un array errors con los errores encontrados y cabecera HTTP 304 Not Modified – [No Modificada] Usado cuando el cacheo de encabezados HTTP está activo
				// Este código 304 no devuelve ningún body, así que si quisiéramos que se mostrara el mensaje usaríamos un código 200 en su lugar.
				return response()->json(['errors'=>array(['code'=>304,'message'=>'No se ha modificado ningún dato de aeropuerto.'])],304);
			}
		}
		// Si el método no es PATCH entonces es PUT y tendremos que actualizar todos los datos.
		if (!$aero || !$ciudad || !$pais || !$iata|| !$icao|| !$latitud || !$longitud || !$elevacion || !$utc || !$dst)
		{
			// Se devuelve un array errors con los errores encontrados y cabecera HTTP 422 Unprocessable Entity – [Entidad improcesable] Utilizada para errores de validación.
			return response()->json(['errors'=>array(['code'=>422,'message'=>'Faltan valores para completar el procesamiento UPDATE/PUT.'])],422);
		}

		$aeropuerto->aeropuerto=$aero;
		$aeropuerto->ciudad=$ciudad;
		$aeropuerto->pais=$pais;
		$aeropuerto->iata=$iata;
		$aeropuerto->icao=$icao;
		$aeropuerto->latitud=$latitud;
		$aeropuerto->longitud=$longitud;
		$aeropuerto->elevacion=$elevacion;
		$aeropuerto->utc=$utc;
		$aeropuerto->dst=$dst;


	}

	/**
	 * Remove the specified resource from storage.
	 *()
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		// Primero eliminaremos todos los aviones de un aeropuerto y luego el aeropuerto en si mismo.
		// Comprobamos si el aeropuerto que nos están pasando existe o no.
		$aeropuerto=Aeropuerto::find($id);

		// Si no existe ese aeropuerto devolvemos un error.
		if (!$aeropuerto)
		{
			// Se devuelve un array errors con los errores encontrados y cabecera HTTP 404.
			// En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un aeropuerto con ese código.'])],404);
		}		
			// Procedemos por lo tanto a eliminar el aeropuerto.
		$aeropuerto->delete();

		// Se usa el código 204 No Content – [Sin Contenido] Respuesta a una petición exitosa que no devuelve un body (como una petición DELETE)
		// Este código 204 no devuelve body así que si queremos que se vea el mensaje tendríamos que usar un código de respuesta HTTP 200.
		return response()->json(['code'=>204,'message'=>'Se ha eliminado el aeropuerto correctamente.'],204);

	}
}
