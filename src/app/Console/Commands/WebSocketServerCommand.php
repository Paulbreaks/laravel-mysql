<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use App\WebSocketServer;

class WebSocketServerCommand extends Command
{
    protected $signature = 'websocket:start';
    protected $description = 'Starting WebSocket-server';

    public function handle()
    {
        $server = IoServer::factory(
            new HttpServer(new WsServer(new WebSocketServer())),
            6001 // Port WebSockets
        );

        $this->info("WebSocket-server started on port 6001...");
        $server->run();
    }
}
