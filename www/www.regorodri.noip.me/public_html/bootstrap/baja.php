<?php 
require_once "cabecera.php";

$pdo=BaseDatos::getInstancia();

if (!empty($_POST['autorizacion']) && !empty($_POST['identificador'])) {
	$auto=$_POST['autorizacion'];
	$id=$_POST['identificador'];
	
	try {
		$stmt = $pdo->prepare("select id,autorizacion from anuncio_anuncios where id ={$id};");
		//
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		$stmt->execute();
		$arrayConsulta = $stmt -> fetch();
		if ($auto===$arrayConsulta['autorizacion']) {
			$stmt = $pdo->prepare("delete from anuncio_anuncios where id = {$id};");
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
			$stmt->execute();	
			echo "<div class='container well'><h3>Anuncio con id {$id}, ha sido borrado correctamente.</h3>";
			echo	"<div class='form-group'><div class='col-sm-offset-2 col-sm-10'><button type='submit' class='btn btn-info'><a href='categoria.php'>Ver</a></button></div></div></div>";
			
		}
	} catch (Exception $e) {
		echo "Error al borrar: ".$e->getMessage();
	}
	
	
}else{
	?>
	<div class="container well">
		<form class="col-md-7" name="formulario" action="" method="POST">
			<h1>Datos del Anuncio a Borrar</h1>
			<div class="form-group">
				<label for id="autorizacion">Autorización: </label>
				<div>
					<input type="autorizacion" class="form-control" name="autorizacion" id="autorizacion" placeholder="Autorización del anuncio." required>
				</div>
			</div>
			<div class="form-group">
				<label for id="identificador" >Identificador: </label>
				<div>
					<input class="form-control" id="identificador" name="identificador" placeholder="Identificador del anuncio." required></input>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<button type="submit" class="btn btn-danger">Borrar</button>
					<button type="reset" id="cancelar" class="btn btn-success">Volver</button>
				</div>
			</div>
		</form>
	</div>
	<script>

		document.getElementById('cancelar').addEventListener('click',function(){
			document.location="index.php";
		});
	</script>	

	<?php  
} 
require_once "pie.php";
?>