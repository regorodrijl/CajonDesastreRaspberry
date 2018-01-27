<?php 
require_once "cabecera.php";
$pdo = BaseDatos::getInstancia();

// el active al enlace, listado de categorias  
if (!empty($_GET['cat1'])) {
	$stmt = $pdo->prepare("select * from adv_anuncio where id_categoria=? and id_usuario=?;");
	$stmt ->bindParam(1,$_GET['cat1']);
	$stmt ->bindParam(2,$_SESSION['id']);
	$stmt ->execute();
	
	$stmtCate =$pdo->prepare("select * from adv_categoria order by nombre;");
	$stmtCate ->execute();
}else{
	try {
		$stmt = $pdo->prepare("select * from adv_anuncio where id_usuario=?;");
		$stmt ->bindParam(1,$_SESSION['id']);
		$stmt ->execute();
		
		$stmtCate =$pdo->prepare("select * from adv_categoria order by nombre;");
		$stmtCate ->execute();

	} catch (Exception $e) {
		echo "Error al listar: ".$e->getMessage();
	}
}
?>
<div class="container ">
	<form class="col-md-7 form-horizontal" method="post" role="search">
		<div class="form-group">
			<div class="dropdown">
				<label>Buscar por:</label>
				<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
					Categoria
					<span class="caret"></span>
				</button>
				<a class="btn btn-sm btn btn-primary" href="anuncios.php?cat=anuncios" role="button">Todos</a>

				<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
					<?php while ($fila = $stmtCate->fetch()) {
						?>
						<li><a href="anuncios.php?cat1=<?php echo $fila['id_categoria'] 	?>"><?php echo $fila['nombre'] 	?></a></li>
						<?php 	} ?>
					</ul>
				</div>
			</div>
		</form>
	</div>
	<div class="container well">
		<?php while ($array = $stmt -> fetch()) {
			?>
			<a href="modificar.php?id_anuncio=<?php echo $array['id']?>" style="text-decoration: none;margin-right:5%; color: #000;display: inline-block;">
				<h4><?= $array['nombre'] ?>&nbsp;</h4>
				<img src="<?= $array['foto'] ?>" onerror="this.src='./img/img.jpg'" style="max-height: 100px;width: auto;">
				<h6><?= $array['texto'] ?>&nbsp;</h6>
			</a>
			<?php }?>

		</div>
		<?php  

		require_once "pie.php";
		?>