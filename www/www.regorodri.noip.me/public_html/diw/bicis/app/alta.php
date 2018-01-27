<?php 
require_once "cabecera.php";?>
<div class="container well">
	<h1>Datos del Anuncio</h1>
	<?php 	
	$pdo=BaseDatos::getInstancia();

	if(!empty($_POST['nombre']) && !empty($_POST['texto']) && !empty($_POST['foto'])) {
		$nombre = $_POST['nombre'];
		$texto = $_POST['texto'];
		$foto = $_POST['foto'];

		$autorizacion = generarCodigo(4);

		$fecha = date('Y-m-d H:i:s');
		$idCategoria = $_POST['categoria'] ;

		try{

		//preparamos la consulta de insert
			$stmt=$pdo->prepare("insert into bici(nombre,texto,foto,autorizacion,fecha,id_categoria) values(?,?,?,?,?,?)");
		//vinculamos los parametros
			$stmt->bindParam(1,$_POST["nombre"]);
			$stmt->bindParam(2,$_POST["texto"]);
			$stmt->bindParam(3,$_POST['foto']);
			$stmt->bindParam(4,$autorizacion);
			$stmt->bindParam(5,$fecha);
			$stmt->bindParam(6,$idCategoria);
		// Ejecutamos la consulta
			if($stmt->execute()){
				//$stmt->execute()
				?>
				<script>alert("Apunta estos datos: \n Autorización: <?php echo $autorizacion; ?>\n Identificador: <?php echo $pdo->lastInsertId();?>")</script>
				<?php
			}else {echo "Error al insertar.";}

		}catch(PDOException $error)
		{
			echo "Error: ".$error->getMessage();
		}

		echo "<div class='container well'><h3>Anuncio Insertado Correctamente, Si no has apuntado los datos mandanos un correo con los datos.</h3></div>";
		echo	"<div class='form-group'><div class='col-sm-offset-2 col-sm-10'><button type='submit' class='btn btn-info'><a href='categoria.php'>Ver</a></button></div></div>";
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
				<label for id="nombre">Nombre: </label>
				<div>
					<input type="nombre" class="form-control" name="nombre" id="nombre" placeholder="Nombre" required>
				</div>
			</div>
			<div class="form-group">
				<label for id="texto" >Texto: </label>
				<div>
					<textarea class="form-control" rows="3" id="texto" name="texto" placeholder="Texto del anuncio" required></textarea>
				</div>
			</div>
			<img src="<?= $arrayConsulta['foto'] ?>" onerror="this.src=''" id='muestrafoto' style="max-height: 600px;width: auto;">
			<div class="form-group">
				<label for id="categoria" class="control-label">Categoria: </label>
				<div>
					<select class="form-control" name="categoria" id="categoria">
						<?php 
						while ($arrayConsulta = $stmt->fetch()) {
							echo "<option value='{$arrayConsulta['id_categoria']}' name='categoria' id='categoria'>{$arrayConsulta['nombre']}</option> ";
						}
						?>
					</select>
				</div>
			</div>
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