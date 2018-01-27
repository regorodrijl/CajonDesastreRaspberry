<?
// Ejemplo de conexión a diferentes tipos de bases de datos.
# Conectamos a la base de datos
$host='regorodri.noip.me';
$dbname='telegram';
$user='telegram';
$pass='Nahyr17.7';
 
try {
  # MS SQL Server ySybase con PDO_DBLIB
  $pdo = new PDO("mssql:host=$host;dbname=$dbname, $user, $pass");
  $pdo = new PDO("sybase:host=$host;dbname=$dbname, $user, $pass");
 
  # MySQL con PDO_MYSQL
  # Para que la conexion al mysql utilice las collation UTF-8 añadir charset=utf8 al string de la conexion.
  $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
 
  # Para que genere excepciones a la hora de reportar errores.
  $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
 
  # SQLite Database
  $pdo = new PDO("sqlite:my/database/path/database.db");
}
catch(PDOException $e) {
    echo $e->getMessage();
}
?>