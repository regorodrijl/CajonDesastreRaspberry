var http= require('http');

http.createServer(function(peticion, respuesta){
	respuesta.writeHead(200,{'Content-Type':'text/plain'});
	respuesta.end('Hola Mundo!\n.Todo bien en el servidor node.');
}).listen(444);

console.log('Servidor funcionando en http://127.0.0.1:1111/');
