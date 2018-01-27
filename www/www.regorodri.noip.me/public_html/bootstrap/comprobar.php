<?php 	
spl_autoload_register(function ($clase){
	include_once 'clases/'.strtolower($clase).'.php'; 

});
$pdo=BaseDatos::getInstancia();
try{
	if (isset($_POST['username'])) {
		//preparamos la consulta de insert
		$stmt=$pdo->prepare("select * from adv_usuario where nick = ?");
		//vinculamos los parametros
		$stmt->bindParam(1,$_POST["username"]);
		//$stmt ->execute();
		// Ejecutamos la consulta
		$stmt->execute();
		$reg=$stmt->rowCount();

		$resultado= new stdClass();

		$resultado->status="ok";
		$resultado->data=$reg;
		echo json_encode($resultado);
	}
}catch(PDOException $error){
	echo "Error: ".$error->getMessage();
}
?>