var firebaseDatos=new Firebase('https://conserjeriarego.firebaseIO.com/mensajes');
var firebase=new Firebase('https://conserjeriarego.firebaseIO.com');

var datosAuth= firebase.getAuth();

if (datosAuth)
{
	console.log('Usuario: '+datosAuth.uid+' está logueado con '+datosAuth.provider);

	var liSMS='<li><a href="avisar.html" title="">Mensajes</a></li>';
	var liCONSERJERIA='<li><a href="conserjeria.html" title="">Conserjeria</a></li>';
	var logueado='<li><p class="navbar-text navbar-center">'+datosAuth.password.email+' logueado! </p></li>';
	logueado+='<li><button type="button" class="btn btn-warning navbar-btn" id="botonLogout">Salir</button></li>';

	if(datosAuth.password.email=="conserje@iessanclemente.net"){
		//$(liCONSERJERIA).appendTo('.nav');
		location.assign('conserjeria.html');
	}else{
		$(liSMS).appendTo('.nav');
	}
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
	firebase.unauth();
	location.assign('login.html');
}
/*DATOS LISTADOS*/

var email=datosAuth.password.email; 
email=email.replace(".",' ');
var fb=new Firebase('https://conserjeriarego.firebaseIO.com/mensajes/');

fb.on("child_added", function(snapshot) {
	console.log("hola->"+snapshot.val().aula);
	console.log("aula->"+snapshot.key());
	if(snapshot.val().email==email){

		
		var mensaje = document.createElement("article");
		mensaje.setAttribute("id",snapshot.key());

		mensaje.innerHTML = datosSMS(snapshot);
		$(mensaje).appendTo('#SMS');
	}
});
fb.on("child_changed", function(snapshot) {
	var mensajeActualizar = document.getElementById(snapshot.key());
	mensajeActualizar.innerHTML = datosSMS(snapshot);

});
function datosSMS(datos){
	var fondo;
	if(datos.val().respuesta==""){
		fondo="#D3180E";
	}else{
		fondo="green";
	}
	SMS
	var datos='<div class="panel" style="color:#fff;background-color:'+fondo+'"><div class="row"><div class="col-xs-6 col-sm-4" id>Aula: '+datos.val().aula+'</div><div class="col-xs-6 col-sm-4">Aclaración: '+datos.val().aclaracion+'</div></div><div class="row"><div class="col-xs-12 col-sm-6 col-md-8">Mensaje: '+datos.val().sms+'</div></div></div>';
	return datos;
}