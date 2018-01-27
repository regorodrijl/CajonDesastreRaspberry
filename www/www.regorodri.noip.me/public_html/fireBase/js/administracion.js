// Fijarse que la ruta de partida ahora es la colección productos:
var firebase=new Firebase('https://regoapp.firebaseIO.com/productos');

var productos={};
 
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
	location.assign('index.html');
}
 
 
// Eventos de lectura sobre Firebase
// https://www.firebase.com/docs/web/guide/retrieving-data.html
 
/*
Evento: value
 
The value event is used to read a static snapshot of the contents at a given database path,
as they existed at the time of the read event. It is triggered once with the initial data and again every time the data changes.
The event callback is passed a snapshot containing all data at that location, including child data. In our code example above,
value returned all of the blog posts in our app. Everytime a new blog post is added, the callback function will return all of the posts.
*/
 
firebase.on('value',function(datos)
{
	// Eliminamos el contenido del listado para actualizarlo.
	$("#listado div.row").remove();
 
	productos=datos.val();
 
	// Recorremos los productos y los mostramos
	$.each(productos, function(indice,valor)
	{
		var prevProducto='<div class="row" id="'+indice+'"><div class="col-md-3 cabeceraProducto">';
 
		prevProducto+='<h2>'+valor.articulo+'</h2></div>';
 
		prevProducto+='<div class="row"><div class="col-md-3 cabeceraProducto">';
		prevProducto+='<h2>'+valor.precio+' €.</h2></div>';
		prevProducto+='</div>';
 
		prevProducto+='<div class="row">';
		prevProducto+='<div class="col-md-3 imagenFix">';
		if (valor.imagen=='NONE')
			prevProducto+='<img alt="Sin Fotografía"/>';
		else
			prevProducto+='<img src="'+valor.imagen+'"/>';
		prevProducto+='</div>';
 
		prevProducto+='<div class="col-md-3">';
		prevProducto+='<p>'+valor.descripcion+'</p>';
		prevProducto+='</div>';
		prevProducto+='</div>';
 
		prevProducto+='<div class="row">';
 
		prevProducto+='<div class="col-md-3">';
		prevProducto+='<button type="button" class="btn btn-warning" onclick="editarProducto(\''+indice+'\')">Editar Producto</button>';
		prevProducto+='</div>';
 
		prevProducto+='<div class="col-md-3">';
		prevProducto+='<button type="button" class="btn btn-danger" onclick="borrarProducto(\''+indice+'\')">Borrar Producto</button>';
		prevProducto+='</div>';
 
		prevProducto+='</div>';
		prevProducto+='<div class="row espaciador">';
		prevProducto+='</div>';
 
		$(prevProducto).appendTo('#listado');
});
 
},function(objetoError){
	console.log('Error de lectura:'+objetoError.code);
});
 
function editarProducto(id)
{
	// Para pasar el ID a otro proceso lo hacemos a través de window.name
	window.name= id;
 
	// Cargamos la página editarproducto.html
	location.assign('editarproducto.html');
}
 
function borrarProducto(id)
{
	if (confirm("¿Está seguro/a de que quiere borrar este artículo?") == true)
	{
		firebase.child(id).remove();
	}
}