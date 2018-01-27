<?php 
require_once "cabecera.php";?>
<div class="container well">
	<h1>Datos del Modelo</h1>
	<?php 	
	$pdo=BaseDatos::getInstancia();
	
	if(!empty($_POST['modelo']) && !empty($_POST['descripcion_es'])&& !empty($_POST['descripcion_en']) && !empty($_POST['foto'])) {
		$foto = $_POST['foto'];

		$autorizacion = generarCodigo(4);
		try{
			$marca="BicisPro";
		//preparamos la consulta de insert
			$stmt=$pdo->prepare("insert into bici(marca, modelo,descripcion_es,descripcion_en,foto) values(?,?,?,?,?)");
		//vinculamos los parametros
			$stmt->bindParam(1,$marca);
			$stmt->bindParam(2,$_POST["modelo"]);
			$stmt->bindParam(3,$_POST['descripcion_es']);
			$stmt->bindParam(4,$_POST['descripcion_en']);
			$stmt->bindParam(5,$foto);
		// Ejecutamos la consulta
			if($stmt->execute()){
				//$stmt->execute()
			
			}else {echo "Error al insertar.";}

		}catch(PDOException $error)
		{
			echo "Error: ".$error->getMessage();
		}

		echo "<div class='container well'><h3>Modelo Insertado Correctamente.</h3></div>";
		echo	"<div class='form-group'><div class='col-sm-offset-2 col-sm-10'><button type='submit' class='btn btn-info'><a href='modelo.php'>Ver</a></button></div></div>";
	}else{	

	// para abrir una conexion

		try {
		// Consulta 
			$stmt = $pdo->prepare("select * from bici;");
		// Indicamos que queremos los resultados en un array
		// asociativo. (opcional)
		//$stmt->debugDumpParams(); // Muestra la consulta para ver si esta bien 
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
		// Ejecutamos la consulta.
			$stmt->execute();
		// anuncio_anuncios ()

		} catch (Exception $e) {
			echo "Error: ".$e->getMessage();
		}
		?>
		<form class="col-md-7" name="formulario" action="" method="POST">
			<div class="form-group">
				<label for id="nombre">Modelo: </label>
				<div>
					<input type="nombre" class="form-control" name="modelo" id="modelo" placeholder="Nombre Modelo" required>
				</div>
			</div>
			<div class="form-group">
				<label for id="texto" >Descripcion ES: </label>
				<div>
					<textarea class="form-control" rows="3" id="texto" name="descripcion_es" placeholder="Texto en Español" required></textarea>
				</div>
				<label for id="texto" >Descripcion EN: </label>
				<div>
					<textarea class="form-control" rows="3" id="texto" name="descripcion_en" placeholder="Texto en Inglés" required></textarea>
				</div>
			</div>
			<img src="<?= $arrayConsulta['foto'] ?>" id='muestrafoto' style="max-height: 600px;width: auto;">

			<div class="form-group">
				<label for id="lfoto" class="control-label">URL Foto: </label>
				<div>
					<input type="foto" class="form-control" name="foto" id="foto" placeholder="URL de la foto" required>
				</div>
			</div>

			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<button type="submit" class="btn btn-info">Publicar</button>
				</div>
			</div>
		</form>
	</div>
	<script>
		document.getElementById('foto').addEventListener('input',function(){
			document.getElementById('muestrafoto').setAttribute('src', document.getElementById('foto').value);
		},true);
	</script>
	<?php }
	require_once "pie.php";
	?>