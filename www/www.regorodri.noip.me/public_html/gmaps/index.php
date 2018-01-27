<?php
require_once(__DIR__.'/php/autoloader.php');

$feed = new SimplePie();
$feed->set_feed_url('http://feeds.weblogssl.com/xataka2');
$feed->init();

foreach ($feed->get_items() as $item) {

	echo $item->get_title()."<br>";
	echo $item->get_description()."<br>";
}
?>