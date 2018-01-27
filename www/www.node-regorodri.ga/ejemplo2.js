//
var app= require('express')();
var puerto=80;
app.listen(puerto,function(){
	console.log('Servidor escuchando en el puerto 80');
});
app.get('/',function(peticion,respuesta){
	respuesta.type('text/html');
	mensaje="servidor web con node.js y express";
	respuesta.send(mensaje);
});
app.get('/info',function(peticion,respuesta){
	respuesta.type('text/html');
	mensaje="Info sobre web con node.js y express";
	respuesta.send(mensaje);
});