<?php
require './SocketServer.php';
require './Protocol.php';
require './EchoSocketServer.php';
require './EchoProtocol.php';
require './Logger.php';



$server = new \app\components\EchoSocketServer();
$server->attach(new app\components\Logger($server));

try {
	$server->start();
} catch(\app\components\SocketServerException $e) {
	echo $e->getMessage();
}