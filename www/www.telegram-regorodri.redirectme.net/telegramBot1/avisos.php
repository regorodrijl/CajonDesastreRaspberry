<?
require_once __DIR__.'/Telegram.php';
require_once 'basedatos.php';
require_once 'Funciones.php';
require_once (__DIR__.'/php/autoloader.php');

define('BOT_TOKEN','200447207:AAFGPqGdWKHCzAHHA43oHbFeTkmpRxG6Nlg');//bot->@regorodri_bot




$bot = new Telegram(BOT_TOKEN);
$chat_id=$bot->getChatID();
$bot->sendSMS("Hola desde el pais");
?>