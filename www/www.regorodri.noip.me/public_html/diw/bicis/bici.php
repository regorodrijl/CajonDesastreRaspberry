<?php
@session_start(); 
require_once "cabecera.php";
if (isset($_GET['op'])) {
	$op= $_GET['op'] ;
	$modelo;$desc;$foto;

	switch ($op) {
		case '1':
		$modelo="moma-BMX";
		$desc="Preparada para el freestyle.";
		$foto="img/BMX.jpg";
		break;

		case '2':
		$modelo="e-Triks";
		$desc="Tu todoterreno, listo para la acción.";
		$foto="img/pro.jpeg";
		break;	

		case '3':
		$modelo="HK";
		$desc="Especialista en carreteras.";
		$foto="img/bora.jpg";
		break;

		case '4':
		$modelo="Relax Cloot";
		$desc="Para un paseo o para el día a día.";
		$foto="img/paseo.jpg";
		break;
		default:

		break;
	}
}
echo "<div id='bici' class='vertical-center'><article><img id='foto' src=".$foto." class='img-rounded'><section><h2>Modelo: ".$modelo."</h2><h3>Descripción: ".$desc."</h3></section></article></div>";

require_once "pie.php";
?>