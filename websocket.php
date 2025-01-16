<?php

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use App\Http\Controllers\WebSocketController;

require './penampung/vendor/autoload.php';

// Inisialisasi Aplikasi Laravel
$app = require  './penampung/bootstrap/app.php';

// Memuat kernel HTTP
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new WebSocketController()
        )
    ),
    8080, // Port
    '0.0.0.0' // Host
);
echo "WebSocket server running on 0.0.0.0:8090\n";
$server->run();