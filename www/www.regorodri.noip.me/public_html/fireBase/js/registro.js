var firebase=new Firebase('https://regoapp.firebaseIO.com');
 
var email,password,passwordConfirm;
 
$("#formularioRegistro").change(function()
{
	password=$("#password").val();
	passwordConfirm=$("#password2").val();
 
	if (password== passwordConfirm)
	{
		$("#botonRegistro").prop("disabled",false);
	}
	else
	{
		$("#botonRegistro").prop("disabled",true);
	}
});
 
 
function alFinalizar(error, datosUsuario)
{
	if (error)
	{
		switch(error.code)
		{
			case 'EMAIL_TAKEN':
			alert('ERROR: No se puede crear la nueva cuenta de usuario, por que el e-mail ya está en uso !');
			break;
			case 'INVALID_EMAIL':
			alert('ERROR: El e-mail facilitado no es un e-mail correcto.');
			break;
			default:
			alert('Se ha producido un error al crear el usuario: '+error);
			break;
		}
	}
	else
	{
		alert('Se ha creado la cuenta de usuario correctamente. ');
		location.assign('index.html');
	}
}
 
// Programamos el click de los botones del formulario:
 
$("#botonRegistro").click(function()
{
	email=$("#email").val();
	password=$("#password").val();
 
	firebase.createUser(
	{
		email: email,
		password: password
	},alFinalizar);
 
});
 
 
$("#botonCancelar").click(function()
{
	location.assign('index.html');
});