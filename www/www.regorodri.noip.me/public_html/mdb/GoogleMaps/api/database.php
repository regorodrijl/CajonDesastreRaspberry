<?php
class Database{
	// Parámetros de conexión.
	private static $_host='localhost';
	private static $_dbname='';
	private static $_user='';
	private static $_pass='';

	// Propiedad que almacen la conexión a la base de datos
	// Será un objeto de la clase PDO
	private static $_conexion=false;

	// Creamos la conexión a la base de datos.
	private function __construct()
	{
		try{

		$stringConexion="mysql:host=".self::$_host.";dbname=".self::$_dbname.";charset=utf8";
		self::$_conexion= new PDO($stringConexion,self::$_user,self::$_pass);
		self::$_conexion->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		} catch(PDOException $error)
			{
				die("Error conectando al servidor de MySQL:".$error->getMessage());
			}
	}

	// En el patron Singleton se usa para asegurar que hay solamente 
	// una instancia de una clase, y se puede acceder a ella globalmente.
	// Creamos un método público que nos dará acceso a esa instancia.
	public static function get_conexion()
	{
		// Comprobamos si hay una conexion hecha.
		if (!self::$_conexion){
			// Creamos la conexion
			// Una opción sería:
			// self::__construct();

			// Otra opción
			new self;
		}

		// Devolver el objeto PDO.
		return self::$_conexion;
	}
}