<?php 	
function encriptar($password, $vueltas = 7) {
	$caracteres = './ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

	$semilla = sprintf('$2a$%02d$', $vueltas);
	for ($i = 0; $i < 22; $i++)
		$semilla.=$caracteres[rand(0, 63)];
	return crypt($password, $semilla);
}

function generarCodigo($longitud) {
	$key = '';
	$pattern = '1234567890abcdefghijklmnopqrstuvwxyz';
	$max = strlen($pattern)-1;
	for($i=0;$i < $longitud;$i++) $key .= $pattern{mt_rand(0,$max)};
		return $key;
}
?>