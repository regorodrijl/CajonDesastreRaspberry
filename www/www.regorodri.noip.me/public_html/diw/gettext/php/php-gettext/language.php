<?php

	// Se cargan las librerias de php-gettext:
 	require_once( 'streams.php' );
	require_once( 'gettext.php' );


    // Obtiene el idioma que esta usando el usuario según la configuración de su navegador:
	switch( substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2) )
	{
		case 'es':
			$language = 'es_ES';
			break;

		default:
			$language = 'en_GB';
			break;
	}


	// Se carga el fichero de traducción:
	if( file_exists($pach .'languages/'. $language .'.mo') )
	{
		$gettext_tables = new gettext_reader( new CachedFileReader($pach .'languages/'. $language .'.mo') );
		$gettext_tables->load_tables();
	}


	// Recibe un texto y devuelve la traducción si existe en el catalogo, si no devuelve el texto original:
	function __($text)
	{
		global $gettext_tables;
        return( is_null($gettext_tables) ? $text : $gettext_tables->translate($text) );
	}


	// Recibe un texto e imprime la traducción si existe en el catalogo, si no imprime el texto original:
	function _e($text)
	{
		global $gettext_tables;
        echo( is_null($gettext_tables) ? $text : $gettext_tables->translate($text) );
	}

?>