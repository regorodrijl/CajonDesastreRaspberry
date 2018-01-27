<?php 
require_once "cabecera.php";
$pdo = BaseDatos::getInstancia();

// el active al enlace, listado de categorias x id buscar 
if (!empty($_GET['cat1']) || !empty($_POST['bus'])) {
	
	if (!empty($_POST['bus']) && empty($_GET['cat1'])) {
		$stmt = $pdo->prepare("select * from anuncio_anuncios where nombre like ? or texto like ?;");
		$con="%".$_POST['bus']."%";
		$stmt ->bindParam(1,$con);
		$stmt ->bindParam(2,$con);
		$stmt ->execute();

		$stmtCate =$pdo->prepare("select * from anuncio_categoria order by nombre;");
		$stmtCate ->execute();
	}
	if (empty($_POST['bus']) && !empty($_GET['cat1'])){
		$stmt = $pdo->prepare("select * from anuncio_anuncios where id_categoria=?;");
		$stmt ->bindParam(1,$_GET['cat1']);
		$stmt ->execute();

		$stmtCate =$pdo->prepare("select * from anuncio_categoria order by nombre;");
		$stmtCate ->execute();
	}
	if (!empty($_POST['bus']) && !empty($_GET['cat1'])){
		$stmt = $pdo->prepare("select * from anuncio_anuncios where nombre like ? or texto like ? and id_categoria=?;");
		$con="%".$_POST['bus']."%";
		$stmt ->bindParam(1,$con);
		$stmt ->bindParam(2,$con);
		$stmt ->bindParam(3,$_POST['bus']);
		$stmt ->execute();

		$stmtCate =$pdo->prepare("select * from anuncio_categoria order by nombre;");
		$stmtCate ->execute();
	}
}else{
	try {
		$stmt = $pdo->prepare("select * from anuncio_anuncios;");
		$stmt ->execute();
		$stmtCate =$pdo->prepare("select * from anuncio_categoria order by nombre;");
		$stmtCate ->execute();

	} catch (Exception $e) {
		echo "Error al listar: ".$e->getMessage();
	}
}
?>
<div class="container ">
	<form class="col-md-7 form-horizontal" method="post" role="search">
		<div class="form-group">
			<div class="form-inline">
				<input type="text" name="bus" id="bus" class="form-control" placeholder="Buscar...">
				<button type="submit" class="btn btn-primary">Buscar</button>
			</div>
		</div>
		<div class="form-group">
			<div class="dropdown">
				<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
					Categorias
					<span class="caret"></span>
				</button>
				<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
					<?php while ($fila = $stmtCate->fetch()) {
						?>
						<li><a href="categoria.php?cat1=<?php echo $fila['id_categoria'] 	?>"><?php echo $fila['nombre'] 	?></a></li>
						<?php 	} ?>
					</ul>
				</div>
			</div>
		</form>
	</div>
	<div class="container well">
		<?php while ($array = $stmt -> fetch()) {
			?>
			<a href="modificar.php" style="text-decoration: none;margin-right:5%; color: #000;display: inline-block;">
				<h4><?= $array['nombre'] ?>&nbsp;</h4>
				<img src="<?= $array['foto'] ?>" onerror="this.src='./img/img.jpg'" style="max-height: 100px;width: auto;">
				<h6><?= $array['texto'] ?>&nbsp;</h6>
			</a>
			<?php }?>

		</div>
		<?php  

		require_once "pie.php";
		?>