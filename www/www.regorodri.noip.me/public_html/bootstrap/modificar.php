<?php
require_once "cabecera.php";

$pdo = BaseDatos::getInstancia();
$band="";
if(!empty($_POST['nombre']) && !empty($_POST['texto']) && !empty($_POST['foto'])) {
	$band=true;
	//echo $_GET['id_anuncio'];
	//echo "Insertando";
	$nombre = $_POST['nombre'];
	$texto = $_POST['texto'];
	$foto = $_POST['foto'];
	$fecha = date('Y-m-d H:i:s');
	$idCategoria = $_POST['categoria'] ;
	try{

		//preparamos la consulta de insert
		$stmtUp=$pdo->prepare("update adv_anuncio set nombre=?,texto=?,foto=?,fecha=?,id_categoria=?,id_usuario=? where id=?");
		//vinculamos los parametros
		$stmtUp->bindParam(1,$_POST["nombre"]);
		$stmtUp->bindParam(2,$_POST["texto"]);
		$stmtUp->bindParam(3,$_POST['foto']);
		$stmtUp->bindParam(4,$fecha);
		$stmtUp->bindParam(5,$idCategoria);
		$stmtUp->bindParam(6,$_SESSION['id']);
		$stmtUp->bindParam(7,$_GET['id_anuncio']);
		$stmtUp->execute();	
				//echo "<div class='container well'><h3>Anuncio con id {$id}, ha sido modificado correctamente.</h3></div>";
				//echo "".$stmtUp->debugDumpParams();// ecmz
	}catch(Exception $e) {echo "Error al modififcar: ".$e->getMessage();}
	echo "<div class='container well'><h3>Anuncio con id {$_SESSION['id']}, ha sido modificado correctamente.</h3>";
	echo	"<div class='form-group'><div class='col-sm-offset-2 col-sm-10'><button type='submit' class='btn btn-info'><a href='anuncios.php'>Ver</a></button></div></div></div>";
}else{
	if (!empty($_GET['id_anuncio']) && $band!=true) {
		//echo "ID anunciooo!";
		try {
			$stmt = $pdo->prepare("select * from adv_anuncio where id =?;");
			$stmt->bindParam(1,$_GET['id_anuncio']);
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
			$stmt->execute();
			$arrayConsulta = $stmt -> fetch();

			$stmtCate = $pdo->prepare("select * from adv_categoria;");
			// Indicamos que queremos los resultados en un array
			// asociativo. (opcional)
			//$stmt->debugDumpParams(); // Muestra la consulta para ver si esta bien
			$stmtCate->setFetchMode(PDO::FETCH_ASSOC);
			// Ejecutamos la consulta.
			$stmtCate->execute();

			?>
			<div class="container well">
				<form class="col-md-7" name="formularioMod" id="formularioMod" action="" method="POST">
					<div class="form-group">
						<label for id="nombre">Nombre: </label>
						<div>
							<input type="nombre" class="form-control" name="nombre" id="nombre" value="<?= $arrayConsulta['nombre'] ?>" required>
						</div>
					</div>
					<div class="form-group">
						<label for id="texto" >Texto: </label>
						<div>
							<textarea class="form-control" rows="3" id="texto" name="texto" required><?= $arrayConsulta['texto'] ?></textarea>
						</div>
					</div>
					<div class="form-group">
						<label for id="categoria" class="control-label">Categoria: </label>
						<div>
							<select class="form-control" name="categoria" id="categoria">
								<?php 
								while ($arrayCate = $stmtCate->fetch()) {
									echo "<option value='{$arrayCate['id_categoria']}' name='categoria' id='categoria'>{$arrayCate['nombre']}</option> ";
								}
								?>
							</select>
						</div>
					</div>
					<img src="<?= $arrayConsulta['foto'] ?>" onerror="this.src='./img/img.jpg'" id='muestrafoto' style="max-height: 600px;width: auto;">
					<div class="form-group">
						<label for id="lfoto" class="control-label">Foto en base64: </label>
						<div>
							<input type="foto" class="form-control" name="foto" id="foto" placeholder="botón derecho y copiar imagen."  value="<?= $arrayConsulta['foto'] ?>" required>
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<button type="submit" class="btn btn-success">Modificar</button>
							<button type="submit" id="cancelar"class="btn btn-danger">Cancelar</button>
						</div>
					</div>
				</form>
			</div>

			<?php
		} catch (Exception $e) {
			echo "Error al modififcar: ".$e->getMessage();
		}
	}else {
		echo "Debe seleccionar algún anuncio";
	}
}  
require_once "pie.php";
?>
<script>

	document.getElementById('cancelar').addEventListener('click',function(){
		document.location="index.php";
	});
		// al cambiar la imagen en input
		document.getElementById('foto').addEventListener('input',function(){
			document.getElementById('muestrafoto').setAttribute('src', document.getElementById('foto').value);
		},true);
	</script>