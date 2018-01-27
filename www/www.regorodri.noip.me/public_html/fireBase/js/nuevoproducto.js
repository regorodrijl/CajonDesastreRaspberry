var firebase=new Firebase('https://regoapp.firebaseIO.com');
 
var articulo;
var descripcion;
var precio;
var imagen;
 
// Chequeamos la autenticación.
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
	location.assign('index.html');
}
 
 
$("#imagen").change(function()
{
	var descriptor=new FileReader();
	descriptor.readAsDataURL(this.files[0]);
 
	descriptor.onloadend = function()
	{
		imagen=descriptor.result;
		$("#previsualizacion").attr("src",imagen);
	};
});
 
 
$("#formularioAlta").change(function()
{
	articulo=$("#articulo").val();
	descripcion=$("#descripcion").val();
	precio=$("#precio").val();
 
	if (articulo && descripcion && precio)
	{
		$("#botonGuardar").prop("disabled",false);
	}
	else
	{
		$("#botonGuardar").prop("disabled",true);
	}
 
});
 
 
$("#botonGuardar").click(function()
{
	articulo=$("#articulo").val();
	descripcion=$("#descripcion").val();
	precio=$("#precio").val();
 
	if (!imagen)
	{
		imagen="NONE";
	}
 
	// Indicamos que la referencia base de nuestra base de datos es productos (algo así como el padre)
	// del que colgarán el resto de nodos hijos.
	/*
	var usersRef = new Firebase('https://samplechat.firebaseio-demo.com/users');
	var fredRef = usersRef.child('fred');
	var fredFirstNameRef = fredRef.child('name/first');
	*/
	var referencia=firebase.child("productos");
 
 
	// De la siguiente forma el método sobreescribe los datos
/*
	referencia.set(
	{
		articulo: articulo,
		descripcion: descripcion,
		precio: precio,
		imagen: imagen
	});
	*/
 
	// Ahora estamos poniendo el articulo como clave en la colección
	// De esta manera podremos añadir nuevos articulos o actualizar uno ya existente.
 
/*
	referencia.child(articulo).set(
	{
		descripcion: descripcion,
		precio: precio,
		imagen: imagen
	});
*/
 
	// Si queremos permitir que hayas artículos con nombres duplicados entonces tendremos
	// que decirle a Firebase que utilice otra clave en lugar del nombre del articulo.
	// Usaremos el método push en lugar de set
	referencia.push(
	{
		articulo: articulo,
		descripcion: descripcion,
		precio: precio,
		imagen: imagen
	},function()
	{
		alert('El alta se ha realizado correctamente');
	});
});
