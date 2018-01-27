<?php 
// autocarga de calses	
spl_autoload_register(function ($clase){
	include_once __DIR__.'/../config/'.strtolower($clase).'.php'; 
	//echo __DIR__.'/config/'.strtolower($clase).'.php';
});
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
function comprobarAdmin($nick){
	$pdo=BaseDatos::getInstancia();
	try{
		//preparamos la consulta de insert
		$stmt=$pdo->prepare("select admin from user where nick = ?;");
		//vinculamos los parametros
		$stmt->bindParam(1,$nick);
		//$stmt ->execute();
		// Ejecutamos la consulta
		$stmt->execute();
		$fila= $stmt->fetch();
		if($fila['admin']==1){
			return "ok";
		}else {
			return "ko";
		}

		$reg=$stmt->rowCount();

		$resultado= new stdClass();

		$resultado->status="ok";
		$resultado->data=$reg;
		//echo json_encode($resultado);
		
	}catch(PDOException $error){
		echo "Error: ".$error->getMessage();
		//return "ko";
	}
}
?>