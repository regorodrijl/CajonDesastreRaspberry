<?php 
require_once "cabecera.php";

$pdo = BaseDatos::getInstancia();

if (!empty($_POST['autorizacion']) && !empty($_POST['identificador'])) {
	$auto=$_POST['autorizacion'];
	$id=$_POST['identificador'];
	
	try {
		$stmt = $pdo->prepare("select * from anuncio_anuncios where id =? and autorizacion=?;");
		$stmt->bindParam(1,$id);
		$stmt->bindParam(2,$auto);
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		$stmt->execute();
		$arrayConsulta = $stmt -> fetch();

		$stmtCate=$pdo->prepare("select * from anuncio_categoria;");
		$stmtCate->execute();
		

		if(!empty($_POST['nombre']) && !empty($_POST['texto']) && !empty($_POST['foto'])) {
			$nombre = $_POST['nombre'];
			$texto = $_POST['texto'];
			$foto = $_POST['foto'];
			$fecha = date('Y-m-d H:i:s');
			$idCategoria = $_POST['categoria'] ;
			try{
				$stmtUp = $pdo->prepare("update anuncio_anuncios set nombre=?,texto=?,foto=?,fecha=?,id_categoria=? where id=?");

				$stmtUp->bindParam(1,$nombre);
				$stmtUp->bindParam(2,$texto);
				$stmtUp->bindParam(3,$foto);
				$stmtUp->bindParam(4,$fecha);
				$stmtUp->bindParam(5,$idCategoria);
				$stmtUp->bindParam(6,$id);
				$stmtUp->execute();	
				//echo "<div class='container well'><h3>Anuncio con id {$id}, ha sido modificado correctamente.</h3></div>";
				//echo "".$stmtUp->debugDumpParams();// ecmz

			}catch(Exception $e) {echo "Error al modififcar: ".$e->getMessage();}
			echo "<div class='container well'><h3>Anuncio con id {$id}, ha sido modificado correctamente.</h3>";
			echo	"<div class='form-group'><div class='col-sm-offset-2 col-sm-10'><button type='submit' class='btn btn-info'><a href='categoria.php'>Ver</a></button></div></div></div>";
		}else{
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
						<label for id="lfoto" class="control-label">URL Foto: </label>
						<div>
							<input type="foto" class="form-control" name="foto" id="foto" value="<?= $arrayConsulta['foto'] ?>" required>
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<button type="submit" class="btn btn-success">Modificar</button>
							<button type="reset"  class="btn btn-info">Descartar Cambios</button>
							<button type="reset" id="cancelar" class="btn btn-danger">Volver</button>
						</div>		
					</div>
					<input type="hidden" value="<?php echo $auto ?>" name="autorizacion">
					<input type="hidden" value="<?php echo $id ?>" name="identificador">
				</form>
			</div>

			<?php
		}	
	} catch (Exception $e) {
		echo "Error al modififcar: ".$e->getMessage();
	}
}else{
	?>
	<div class="container well">
		<form class="col-md-7" name="formulario" action="" method="POST">
			<h1>Datos del Anuncio a Modificador </h1>
			<div class="form-group">
				<label for id="autorizacion">Autorización: </label>
				<div>
					<input type="autorizacion" class="form-control" name="autorizacion" id="autorizacion" placeholder="Autorización del anuncio." >
				</div>
			</div>
			<div class="form-group">
				<label for id="identificador" >Identificador: </label>
				<div>
					<input class="form-control" id="identificador" name="identificador" placeholder="Identificador del anuncio." ></input>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<button type="submit" class="btn btn-warning">Modificar</button>
				</div>
			</div>
		</form>
	</div>

	
	<?php  
} 
require_once "pie.php";


/*

}else{
			echo "<div class='container well'><h3>Datos insertados no validos.</h3></div>";
			echo "<div class='form-group'><div class='col-sm-offset-2 col-sm-10'><button type='submit' class='btn btn-warning'><a href='modificar.php'>Volver</a></button></div></div>";		
		}*/
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