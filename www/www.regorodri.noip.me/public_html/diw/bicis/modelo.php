<?php
@session_start(); 
require_once "cabecera.php";
$pdo = BaseDatos::getInstancia();

try {
	$stmt = $pdo->prepare("select * from bici;");
	$stmt ->execute();

} catch (Exception $e) {
	echo "Error al listar: ".$e->getMessage();
}
?>


<div class="jumbotron col-md-10 vertical-center">
	<div class="container">
		<div class="jumbotron col-md-10 vertical-center">
			<div class="container" id="bicis">

				<div class="col-xs-3">
					<div class="thumbnail">
						<img src="img/BMX.jpg" class="img-responsive img-thumbnail" >
						<div class="caption">
							<h3 name="modelo">moma-BMX</h3>
							<p name="desc">Preparada para el freestyle.</p>
							<p>
								<a href="bici.php?op=1" name="foto" class="btn btn-primary">Ver</a> 
							</p>
						</div>
					</div>
				</div>

				<div class="col-xs-3">
					<div class="thumbnail">
						<img src="img/pro.jpeg" class="img-responsive img-rounded" >
						<div class="caption">
							<h3>e-Triks</h3>
							<p>Tu todoterreno, listo para la acción.</p>
							<p>
								<a href="bici.php?op=2" class="btn btn-primary">Ver</a> 
							</p>
						</div>
					</div>
				</div>


				<div class="col-xs-3">
					<div class="thumbnail">
						<img src="img/bora.jpg" class="img-responsive img-thumbnail" >
						<div class="caption">
							<h3>HK</h3>
							<p>Especialista en carreteras.</p>
							<p>
								<a href="bici.php?op=3" class="btn btn-primary">Ver</a> 
							</p>
						</div>
					</div>
				</div>

				<div class="col-xs-3">
					<div class="thumbnail">
						<img src="img/paseo.jpg" class="img-responsive img-rounded" >
						<div class="caption">
							<h3>Relax Cloot</h3>
							<p>Para un paseo o para el día a día.</p>
							<p>
								<a href="bici.php?op=4" class="btn btn-primary">Ver</a> 
							</p>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>
<?php  
require_once "pie.php";
?>