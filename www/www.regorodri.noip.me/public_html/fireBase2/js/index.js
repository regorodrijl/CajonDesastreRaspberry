// Fijarse que la ruta de partida ahora es la colección productos:
var ref=new Firebase('https://conserjeriarego.firebaseIO.com');

var authData = ref.getAuth();
if (authData) {
	console.log(authData.password.email);
	if(authData.password.email=="conserje@iessanclemente.net"){
		console.log('Usuario CONSERJE logueado');
		location.assign('conserjeria.html');
	}else{
		location.assign('listar.html');
	}
	console.log("Authenticated user with uid:", authData.uid);
}else{
	location.assign('login.html');
}