var productoId= window.name;
//console.log(productoId);
 
var firebase=new Firebase('https://regoapp.firebaseIO.com/productos');
 
var articulo, descripcion, precio, imagen;
 
var producto={};
 
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
 
 
// Buscamos el artículo.
firebase.child(productoId).once('value',function(datos)
{
	producto=datos.val();
 
	articulo= producto.articulo;
	descripcion= producto.descripcion;
	precio=producto.precio;
	imagenEdicion=producto.imagen;
 
	$('#articulo').val(articulo);
	$('#descripcion').val(descripcion);
	$('#precio').val(precio);
	$('#previsualizacion').attr('src',imagenEdicion);
});
 
 
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
 
function alFinalizar(error)
{
	if (error)
	{
		alert('Ha habido problemas al realizar la operación: '+error.code);
	}
	else{
		alert('Operación realizada con éxito !');
		location.assign('administracion.html');
	}
}
 
$("#botonActualizar").click(function()
{
	var articulo=$("#articulo").val();
	var descripcion=$("#descripcion").val();
	var precio=$("#precio").val();
	var imagen=imagenEdicion;
 
	// Guardamos los datos en Firebase
	firebase.child(productoId).update(
	{
		articulo: articulo,
		descripcion: descripcion,
		precio: precio,
		imagen: imagen,
	}, alFinalizar);
});