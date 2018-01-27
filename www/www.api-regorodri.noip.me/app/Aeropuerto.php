<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Aeropuerto extends Model
{
    // Nombre de la tabla en MySQL.
	protected $table='aeropuertos';
	// no hace falta hacer referencia al id ya que existe un campo id en la tabla (phpmyadmin)
	//protected $primaryKey ='id';
	// Aquí ponemos los campos que no queremos que se devuelvan en las consultas.
	

	// es para que los campos created_at... no se creen("problemas con update.") 
	public $timestamps = false;
	
	protected $fillable = array('aeropuerto','ciudad','pais','iata','icao','latitud','longitud','elevacion','utc','dst');
	protected $hidden = ['created_at','updated_at']; 

	// Definimos a continuación la relación de esta tabla con otras.
	// Ejemplos de relaciones:
	// 1 usuario tiene 1 teléfono   ->hasOne() Relación 1:1
	// 1 teléfono pertenece a 1 usuario   ->belongsTo() Relación 1:1 inversa a hasOne()
	// 1 post tiene muchos comentarios  -> hasMany() Relación 1:N 
	// 1 comentario pertenece a 1 post ->belongsTo() Relación 1:N inversa a hasMany()
	// 1 usuario puede tener muchos roles  ->belongsToMany()
	//  etc..
	// 
	// 
}
