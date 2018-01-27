// Antes de ejecutar este código tendremos que instalar sus dependencias con:
// npm install
// Atención: asegurarse de tener el fichero package.json para que sepa que módulos tiene que instalar el npm.
 
// Puerto en el que escuchará nuestro servidor:
var puerto = 8080;
 
// Cargamos el módulo de express en un objeto al que llamamos moduloexpress.
 
var moduloexpress = require('express');
 
// Creamos una nueva aplicación sobre la variable app, llamando a () sobre el objeto moduloexpress
 
var app = moduloexpress();
 
// Se puede hacer todo en una única línea con:
 
//var app = require('express')();
 
// Gracias al framework express podremos más adelante gestionar las peticiones http
 
// Para instalar socket.io es necesario que tengamos instanciado previamente un servidor http.
// Cargamos el módulo http y creamos un servidor con createServer()
// Como parámetro se le pasa una función con 2 parámetros (req,resp) o en este caso se le pasa
// una instancia de express, que es la forma sencilla de procesar las peticiones que lleguen al servidor.
 
var servidor = require('http').createServer(app);
 
// Por último queda cargar el módulo de socket.io y pasarle el servidor como parámetro.
 
var io = require('socket.io').listen(servidor);
 
// Comenzamos a aceptar peticiones en el puerto e ip especificadas:   .listen(puerto,[IP])
// Si no se indica IP, lo hará en todas las interfaces.
 
servidor.listen(puerto);
 
// Mostramos mensaje en la consola de Node.js:
 
console.log('Servidor de websockets escuchando en puerto: ' + puerto);
 
// Mediante express gestionamos las rutas de las peticiones http al servidor.
// Cuando  alguien haga una petición a la raiz del servidor web, le enviamos un texto de información.
// También se le podría enviar un fichero con  res.sendfile(__dirname + '/index.html');
 
app.get('/', function(req, res) {
    res.end('Servidor de websockets para DWEC IES San Clemente.');
});
 
 
/////////////////////////////////////////////////////////////////////////////////////
////////////  PROGRAMACION DE LOS EVENTOS QUE GESTIONA EL SERVIDOR  /////////////////
//  https://github.com/LearnBoost/socket.io/wiki/Exposed-events
/////////////////////////////////////////////////////////////////////////////////////
 
// Vamos a programar las respuestas a los eventos que se pueden producir en el servidor.
//
// Primero tendremos que gestionar si se está produciendo una nueva conexión de websockets al servidor:
// lo haremos programando el evento 'connection' sobre io.sockets
// El argumento 'socket' de la función callback será utilizado en las futuras conexiones con el cliente.
// OS recuerdo que un socket en términos de Internet, queda definido por un par de direcciones IP 
// (local y remota), un protocolo de transporte y números de puerto local y remoto.
 
// Eventos en servidor: 'connection','anything','disconnect','message')
// Ver la url https://github.com/LearnBoost/socket.io/wiki/Exposed-events
// para información detallada.
 
io.sockets.on('connection', function(socket)
{
    // Cada vez que se conecta un cliente mostramos un mensaje en la consola de Node.
    console.log('++++ Nuevo cliente conectado ++++');
 
    // A través del objeto socket que escribimos en la función de callback
    // gestionamos el intercambio de mensajes con el cliente.
    // 
    // Nombres de eventos reservados para ese socket:'message', 'disconnect', 'mispropios-eventos'
 
    socket.on('message', function(datosrecibidos)
    {
        // Al recibir un mensaje lo retransmitimos al resto de usuarios. Ver opciones en:
        // https://github.com/LearnBoost/socket.io/wiki/How-do-I-send-a-response-to-all-clients-except-sender%3F
        io.sockets.emit('message', datosrecibidos);
    });
 
    socket.on('disconnect', function()
    {
        console.log('>>>> Se ha desconectado un cliente.');
    });
 
    // A parte de esos eventos reservados podemos programar nuestros propios eventos con el nombre
    // que deseemos. Por ejemplo socket.on('teletienda',function()..
 
    socket.on('teletienda', function(datosrecibidos) {
 
        // Usamos io.sockets.emit() para retransmitir datosrecibidos a todos 
        // los que escuchan el evento 'teletienda'
        io.sockets.emit('teletienda', datosrecibidos);
        // Si queremos retransmitir a todos los que escuchan el evento 'teletienda'
        // excepto al remitente del mensaje usaremos socket.broadcast.emit()
        // socket.broadcast.emit('teletienda', datosrecibidos);
        // Más info en: https://github.com/LearnBoost/socket.io/wiki/How-do-I-send-a-response-to-all-clients-except-sender%3F
    });
 
    socket.on('avisos', function(datosrecibidos)
    {
        io.sockets.emit('avisos', datosrecibidos);
    });
 
});
 
 
// Para ejecutar el servidor de websockets con Node.js escribir desde el terminal:
// node server.js