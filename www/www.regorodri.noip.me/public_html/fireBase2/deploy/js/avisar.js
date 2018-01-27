// Fijarse que la ruta de partida ahora es la colección productos:
var firebaseSMS=new Firebase('https://conserjeriarego.firebaseIO.com/mensajes');
var firebaseRes=new Firebase('https://conserjeriarego.firebaseIO.com/incidencia');
var productos={};

// Chequeamos la autenticación antes de acceder al resto de contenido de este fichero.
var datosAuth= firebaseSMS.getAuth();

if (datosAuth)
{
	if(datosAuth.password.email=="conserje@iessanclemente.net"){
		location.assign('conserjeria.html');
	}
	console.log('Usuario: '+datosAuth.uid+' está logueado con '+datosAuth.provider);
	var logueado='<li><p class="navbar-text navbar-center">'+datosAuth.password.email+' logueado! </p></li>';
	logueado+='<li><button type="button" class="btn btn-warning navbar-btn" id="botonLogout">Salir</button></li>';

	$(logueado).appendTo('.nav');
	$("#botonLogout").click(desconectar);
}
else
{
	console.log('Usuario no logueado');
	location.assign('login.html');
}

function desconectar()
{
	firebaseSMS.unauth();
	location.assign('login.html');
}
$('#notificar').click(function () {
	var select = $('#select :selected').text();
	var aclaracion = $('#aclaracion').val();
	var texto = $('#texto').val();
	var email=datosAuth.password.email;
	if(select==""|| aclaracion=="" ||texto==""){
		console.log("Faltan datos!");
		alert("Faltan datos, rellénelos por favor!");
	}else{
		if(aclaracion==""){
			console.log(email+"Valor de select "+select +" "+aclaracion+" "+texto);
		}
	}
	email=email.replace(".",' ');

	console.log(email);
	var newMessageRef = firebaseSMS.push();
	newMessageRef.set({
		aula: select,
		aclaracion: aclaracion,
		sms: texto,
		email:email,
		respuesta:""
	},function()
	{
		var referenciaRES=firebaseRes.child(newMessageRef.key());
		referenciaRES.set({
			idMensaje: newMessageRef.key(),
			resuelta:""
		},function()
		{
			$('#aclaracion').val("");
			$('#texto').val('');		
			alert('incidencia creada');
		});



		alert('Mensaje enviado');
		location.assign('listar.html');
	});/*)

	var path = (newMessageRef.key()).toString();
	console.log('clave '+path);
	path=path.replace("https://conserjeriarego.firebaseio.com/mensajes/"+email+"/",'');
	console.log("ID FIREBASE "+path);*/
	
});