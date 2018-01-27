function alFinalizar(error, datosUsuario)
{
	if (error)
	{
		alert("Login incorrecto! ", error);
	}
	else
	{
		alert('Usuario logueado !');
		location.assign('index.html');
	}
}
 
$("#botonLogin").click(function()
{
	var email=$("#email").val();
	var password=$("#password").val();
 
	var firebase= new Firebase('https://regoapp.firebaseIO.com');
 
	firebase.authWithPassword(
	{
		email: email,
		password: password
	},alFinalizar);
});
 
 
$("#botonRegistro").click(function()
{
	location.assign('registro.html');
});
 
 
$("#botonCancelar").click(function()
{
	location.assign('index.html');
});