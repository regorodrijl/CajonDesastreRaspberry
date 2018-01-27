<?php
//@session_start(); 
require_once "cabecera.php";
?>
<div class="container well">
	<h1>Datos de Registro</h1>
	<?php 
	$pdo=BaseDatos::getInstancia();

	if(!empty($_POST['nombre']) && !empty($_POST['nick']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['passwordRep'])) {
		if ($_POST['password']===$_POST['passwordRep']) {
			try{
				$pas=encriptar($_POST['password']);
				//echo $pas;
				//preparamos la consulta de insert
				$stmt=$pdo->prepare("insert into adv_usuario(nombre,nick,email,password) values(?,?,?,?)");
				//vinculamos los parametros
				$stmt->bindParam(1,$_POST["nombre"]);
				$stmt->bindParam(2,$_POST["nick"]);
				$stmt->bindParam(3,$_POST['email']);
				$stmt->bindParam(4,$pas);
				// Ejecutamos la consulta
				if($stmt->execute()){
					//$stmt->execute()
				}else {
					echo "Error al insertar.";
				}

			}catch(PDOException $error){
				echo "Error: ".$error->getMessage();
			}
		}
		echo "<div ><h3>Registrado correctamente.</h3></div>";
		echo	"<div class='form-group'><div class='col-sm-offset-2 '><button type='submit' class='btn btn-info'><a href='index.php'>index</a></button></div></div>";
	}else{	

		?>
		<form class="col-md-7" name="formulario" id="formulario" action="" method="POST">
			<div class="form-group">
				<label for id="nombre">Nombre: </label>
				<div>
					<input type="nombre" class="form-control" name="nombre" id="nombre" placeholder="Nombre" required>
				</div>
				<label>Nick: </label>
				<div>
					<input type="nick" class="form-control" name="nick" id="nick" placeholder="Nick" required>
				</div><div id="Info"></div>

				<label for id="email" >E-mail: </label>
				<div>
					<input class="form-control" id="email" name="email" placeholder="Correo e-mail." required></input>
				</div>

				<label for="exampleInputPassword1">Contraseña:</label>
				<input type="password" class="form-control" id="password" name="password" placeholder="Contraseña">
				<label for="exampleInputPassword1">Repetir Contraseña:</label>
				<input type="password" class="form-control" id="passwordRep" name="passwordRep" placeholder="Contraseña">
			</div>


			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<button type="submit" class="btn btn-info">Registrarse</button>
				</div>
			</div>
		</form>
	</div>
	<script src="//code.jquery.com/jquery-1.12.0.min.js" ></script>
	<script>

		var disponible;

		document.getElementById("nick").addEventListener("blur",function(){
			var datoNick ="username="+document.getElementById("nick").value;
			$.ajax({
				type:"POST",
				url:"comprobar.php",
				data: datoNick,
				success: function(datas){
					datos=jQuery.parseJSON(datas);
					console.log(datos);
					if (datos.data==0) {
						disponible=true;
						
							//disponible
						}else 	
						disponible=false;
					} 		
				});
		});
		document.getElementById("formulario").addEventListener("submit",function(e){
			e.preventDefault();
			if(document.getElementById('password').value===document.getElementById('passwordRep').value){
				if(disponible==true){
					this.submit();
				}else{
					document.getElementById("nick").value="";
					alert("Nick ya existe");
				}
			}else{
				alert("Error de contraseña!!!!!!!!");
				document.getElementById('passwordRep').value="";
			}
		},true);
		document.getElementById('passwordRep').addEventListener('blur',function(){
			if(document.getElementById('password').value!==document.getElementById('passwordRep').value){
				alert("La contraseña no coincide, Corígela o no te podras registrar!!!!!!!!");
			}
		},true);

		
	</script>
	<?php } 
	require_once "pie.php";
	?>