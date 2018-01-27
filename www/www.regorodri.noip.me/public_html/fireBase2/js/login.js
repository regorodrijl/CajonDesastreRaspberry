function alFinal(error, datosUsuario)
{
	if (error)
	{
		alert("Login incorrecto! ", error);
	}else /*if($("#email").val()==="conserje@iessanclemente.net")*/{
		alert('Usuario logueado !');
		location.assign('index.html');
	}	/*else
	{
		alert('Usuario logueado !');
		location.assign('listar.html');
	}*/
}

$("#botonLogin").click(function()
{
	var email=$("#email").val();
	var password=$("#password").val();

	var firebase= new Firebase('https://conserjeriarego.firebaseIO.com');

	
	firebase.authWithPassword(
	{
		email: email,
		password: password
	},alFinal);
	
});


$("#botonRegistro").click(function()
{
	location.assign('registro.html');
});


$("#botonCancelar").click(function()
{
	location.assign('index.html');
});