
var firebase=new Firebase('https://conserjeriarego.firebaseIO.com');

var firebaseDatos=new Firebase('https://conserjeriarego.firebaseIO.com/mensajes');
var firebaseRes=new Firebase('https://conserjeriarego.firebaseIO.com/incidencia');


var Datos={};
 // CONTROL LOGIN
// Chequeamos la autenticación antes de acceder al resto de contenido de este fichero.
var datosAuth= firebase.getAuth();

if (datosAuth)
{
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
	firebase.unauth();
	location.assign('login.html');
}


var SMSEmail;
var SMSTxt;


var arrayIdIncidencia=[];
// PARA LOS EVENTOS
var data_emailRemit, data_aula, data_aclara, data_sms, data_Key;
firebaseRes.on('child_added',function(datos){
	//console.log(datos.val());
	if(datos.val().resuelta!="si"){
		arrayIdIncidencia.push(datos.key());
	}
	//console.log(datos.key());
},function(objetoError){
	console.log('Error de lectura:'+objetoError.code);
});

setTimeout(function() {
	//console.log("array",arrayIdIncidencia);
	firebaseDatos.on("child_added",function(SMS){
		//console.log(SMS.val(),SMS.key());
		var resuelta=true;
		for (var i = 0; i < arrayIdIncidencia.length; ++i) {
			if (arrayIdIncidencia[i]==SMS.key()) {
				resuelta=false;
				break;
			}
		}
		if(!resuelta){
			relleno(SMS);
		}
	});
}, 2000);


firebaseDatos.on("child_changed", function(snapshot) {
	console.log("dentro");
	console.log(snapshot.key());
	console.log(snapshot.val());
	$('.caja').each(function(elemento){
		//console.log($(this));
		console.log("selector ele",$(this).attr("data-key"));
		if($(this).attr("data-key")==snapshot.key()){
			$(this).remove();

		}	
	});
	

	//var mensajeActualizar = document.getElementById(snapshot.key());
	//mensajeActualizar.innerHTML = datosSMS(snapshot);

});
function relleno(SMS){
	var datosHTML='<div class="caja" data-email="'+SMS.val().email+'" data-aula="'+SMS.val().aula+'" data-sms="'+SMS.val().sms+'" data-aclara="'+SMS.val().aclaracion+'" data-key="'+SMS.key()+'" >'+
	'<div class="panel" id="'+SMS.key()+'">'+
	'<div class="row"><div class="col-xs-6 col-sm-4" id="aula">Aula: '+SMS.val().aula+'</div>'+
	'<div id="aclaracion" class="col-xs-6 col-sm-4">Aclaración: '+SMS.val().aclaracion+'</div></div>'+
	'<div class="row"><div id="sms" class="col-xs-12 col-sm-6 col-md-8">Mensaje: '+SMS.val().sms+" RESUELTA  KEY "+SMS.key()+'</div></div></div></div>';
	$(datosHTML).appendTo('#recibidos').on("click",function(event){ 

		console.log($(event.currentTarget).attr("data-aula"));
		$("textarea#respuesta").val("");
		data_emailRemit=$(event.currentTarget).attr("data-email");
		data_aula=$(event.currentTarget).attr("data-aula");
		data_aclara=$(event.currentTarget).attr("data-aclara");
		data_sms=$(event.currentTarget).attr("data-sms");
		data_Key=$(event.currentTarget).attr("data-key");
		$("span#remitente").text(data_emailRemit);
		$("textarea#SMS").text("Aula: "+data_aula+" Aclaración: "+data_aclara+"\nMensaje: "+data_sms);

		$("textarea#respuesta").removeAttr("readOnly");
	});
}

$('input#notificar').click(function() {
	//console.log("DATOS UPDATE "+data_emailRemit+data_Key);
	var updateSMS=new Firebase('https://conserjeriarego.firebaseIO.com/mensajes/'+data_Key);
	var updateInci=new Firebase('https://conserjeriarego.firebaseIO.com/incidencia/'+data_Key);
	var resp = $('textarea#respuesta').val();
	//console.log("resp "+resp);
	//console.log("DATOS A DONDE SE ENVIARA:");
	//console.log(data_emailRemit);
	//console.log(data_Key);
	
	updateSMS.update({
		respuesta:resp
	});
	updateInci.update({
		resuelta:"si"
	});
});
