<?php
//@session_start(); 
require_once "cabecera.php";?>
<div class="container well">
	<h1>Datos de Registro</h1>
	<?php 

	$pdo=BaseDatos::getInstancia();

	if(!empty($_POST['nick1']) && !empty($_POST['password1'])) {
		try{
		//preparamos la consulta de insert
			$stmt=$pdo->prepare("select * from adv_usuario where nick = ?");
		//vinculamos los parametros
			$stmt->bindParam(1,$_POST["nick1"]);
			//$stmt ->execute();
		// Ejecutamos la consulta
			$data=$stmt->execute();
			if($data){
				//var_dump($data["id"]);
				while ($fila = $stmt->fetch()){
					//var_dump($fila."\n");

					if (crypt($_POST['password1'], $fila['password'])==$fila['password']) {
						echo "Login correcto!";
						//echo "ID: ".$fila['id']."  nick ".$fila['nick'];
						$_SESSION['id']=$fila['id'];
						$_SESSION['usuario']=$_POST["nick1"];
						//sleep(1);
						header("location:index.php");
						//echo "ID: ".$data['id']."  nick ".$data['nick'];
					}else{
						//notificar error
						?>
						<form class="col-md-7" name="formulario" id="formulario" action="" method="POST">
							<div><?php echo "Errror, los datos no corresponden, vuelva a intentarlo."; ?></div>
							<div class="form-group">
								<label>Nick: </label>
								<div>
									<input type="nick" class="form-control" name="nick1" id="nick" placeholder="Nick" required autofocus>
								</div>

								<label for="exampleInputPassword1">Contraseña:</label>
								<input type="password" class="form-control" id="password" name="password1" placeholder="Contraseña" >
							</div>
							<div class="form-group">
								<div class="col-sm-offset-2 col-sm-10">
									<button type="submit" class="btn btn-info" id="login">Login</button>
								</div>
							</div>
						</form>
					</div>
					<script>
						$(document).ready(function(){
							$("#login").click(function(){
								var nick= $("#nick").val();
								var password = $("#password").val();
				// Checking for blank fields.     http://www.formget.com/jquery-login-form/
				if( nick=='' || password ==''){
					if (nick=='') {
						$('input[type="text"],input[type="nick"]').css("border","2px solid red");
					};
					if (password =='') {
						$('input[type="text"],input[type="password"]').css("border","2px solid red");
					};
					alert("Rellene los campos...!!!!!!");
				}else {
					$.post("login.php",{ nick1:nick, password1:password},
						function(data) {
							if(data=='Error al identificarse.'){
								alert(data);
							} else if(data=='Login correcto!'){
								console.log("Login correcto!");								
							}
						});
				}
			});
						});
					</script>
					<?php 
///////////

						//header("location:login.php");
				}
			}
		}else {
			echo "Error al identificarse.";
		}

	}catch(PDOException $error){
		echo "Error: ".$error->getMessage();
	}
}else{	

	?>
	<form class="col-md-7" name="formulario" id="formulario" action="" method="POST">
		<div class="form-group">
			<label>Nick: </label>
			<div>
				<input type="nick" class="form-control" name="nick1" id="nick" placeholder="Nick" required autofocus>
			</div>

			<label for="exampleInputPassword1">Contraseña:</label>
			<input type="password" class="form-control" id="password" name="password1" placeholder="Contraseña" >
		</div>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<button type="submit" class="btn btn-info" id="login">Login</button>
			</div>
		</div>
	</form>
</div>
<script>
	$(document).ready(function(){
		$("#login").click(function(){
			var nick= $("#nick").val();
			var password = $("#password").val();
				// Checking for blank fields.     http://www.formget.com/jquery-login-form/
				if( nick=='' || password ==''){
					if (nick=='') {
						$('input[type="text"],input[type="nick"]').css("border","2px solid red");
					};
					if (password =='') {
						$('input[type="text"],input[type="password"]').css("border","2px solid red");
					};
					alert("Rellene los campos...!!!!!!");
				}else {
					$.post("login.php",{ nick1:nick, password1:password},
						function(data) {
							if(data=='Error al identificarse.'){
								alert(data);
							} else if(data=='Login correcto!'){
								console.log("Login correcto!");								
							}
						});
				}
			});
	});
</script>
<?php } 
require_once "pie.php";
ob_end_flush();
?>