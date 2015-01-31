<?php

require "../vendor/autoload.php";

use App\RatchetImpl\Notifier;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;

$port = 3013;

//  Telnet testing
//$server = IoServer::factory(new Notifier(), 3013);
$notifier        = new Notifier();
$webSocketServer = new WsServer($notifier);
$httpServer      = new HttpServer($webSocketServer);
$server          = IoServer::factory($httpServer, $port);

echo "Server will be started at port {$port}";
echo "\n";

$server->run();
