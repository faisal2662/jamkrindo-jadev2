<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Message;
use App\Models\Customer;
use App\Models\Percakapan;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Illuminate\Console\Command;
use Ratchet\WebSocket\WsServer;
use Ratchet\ConnectionInterface;
use Illuminate\Support\Facades\Auth;
use Ratchet\MessageComponentInterface;
use App\Http\Controllers\WebSocketController;

class WebSocketServer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'websocket:serve';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */



    public function __construct()
    {
        parent::__construct();
        // $this->clients = new \SplObjectStorage; // atau array []
        // $this->admin = null;
        // $this->channels = [];

        // $this->clients = []; // Ganti dengan array kosong
    }
    public function handle()
    {
        $server = IoServer::factory(
            new HttpServer(
                new WsServer(
                    // $this
                    new WebSocketController()
                )
            ),
            8090,
	    '0.0.0.0'

        );
        $this->info('WebSocket server started on ws://localhost:8090');
        $server->run();
    }


    // public function onOpen(ConnectionInterface $conn)
    // {
    //     $this->clients->attach($conn);
    //     $queryParams = $conn->httpRequest->getUri()->getQuery();
    //     parse_str($queryParams, $params);

    //     if (isset($params['type']) && $params['type'] === 'admin') {
    //         $this->admin = $conn;
    //         echo "masukkkk";
    //     } else {
    //         $chatId = $params['chat_id'] ?? null;
    //         if ($chatId) {
    //             if (!isset($this->channels[$chatId])) {
    //                 $this->channels[$chatId] = new \SplObjectStorage;
    //             }
    //             $this->channels[$chatId]->attach($conn);
    //         }
    //     }
    //     echo "New connection! ({$conn->resourceId})\n";
    // }

    // public function onMessage(ConnectionInterface $from, $msg)
    // {

    //     echo "Message received: $msg\n";
    //     // Logic untuk menangani pesan yang diterima

    //     // Decode the JSON message
    //     $data = json_decode($msg, true);

    //     if (json_last_error() !== JSON_ERROR_NONE) {
    //         echo 'JSON Decode Error: ' . json_last_error_msg() . "\n";
    //         return;
    //     }

    //     // Check if the decoded message is null
    //     if (is_null($data)) {
    //         echo "Invalid JSON reiceived\n";
    //         return;
    //     }

    //     // Check if the required keys exist in the array
    //     if (!isset($data['conversation_id'], $data['sender_id'], $data['message'])) {
    //         echo "Incomplete message data received\n";
    //         return;
    //     }

    //     // Try to find the conversation
    //     $conversation = Percakapan::find($data['conversation_id']);
    //     if (!$conversation) {
    //         echo "Conversation not found\n";
    //         return;
    //     }
    //     // Simpan pesan ke database

    //     // try {
    //     //     if ($data['status']) {
    //     //         $message = Message::create([
    //     //             'conversation_id' => $data['conversation_id'],
    //     //             'send_id' => $data['sender_id'],
    //     //             'message' => $data['message'],
    //     //             'status' => 1,
    //     //         ]);
    //     //     } else {
    //     //         $message = Message::create([
    //     //             'conversation_id' => $data['conversation_id'],
    //     //             'send_id' => $data['sender_id'],
    //     //             'message' => $data['message'],

    //     //         ]);
    //     //     }
    //     // } catch (\Exception $e) {
    //     //     echo "Failed to save message: " . $e->getMessage() . "\n";
    //     //     return;
    //     // }
    //     echo "Number of connected clients: " . count($this->clients) . "\n";

    //     $queryParams = $from->httpRequest->getUri()->getQuery();
    //     parse_str($queryParams, $params);

    //     if (isset($params['type']) && $params['type'] === 'admin') {
    //         // Admin sends messages to a specific chat
    //         $chatId = $params['chat_id'] ?? null;
    //         // echo $this->channels[$chatId];
    //         if ($chatId) {
    //             echo "masuk " . $chatId;
    //             if (isset($this->channels[$chatId])) {
    //                 foreach ($this->channels[$chatId] as $client) {
    //                     if ($from !== $client) {
    //                         $client->send(json_encode([
    //                             'pesan' => "masuk"
    //                         ]));
    //                         //         if ($message->status) {

    //                         //     $user = User::where('kd_user', $message->send_id)->first();
    //                         //     $client->send(json_encode([
    //                         //         'conversation_id' => $message->conversation_id,
    //                         //         'sender_id' => $message->send_id,
    //                         //         'user' => $user->nm_user,
    //                         //         'message' => $message->message,
    //                         //         'created_at' => $message->created_date->toDateTimeString(),
    //                         //     ]));
    //                         // } else {
    //                         //     $user = Customer::where('kd_customer', $message->send_id)->first();
    //                         //     $client->send(json_encode([

    //                         //         'conversation_id' => $message->conversation_id,
    //                         //         'sender_id' => $message->send_id,
    //                         //         'user' => $user->nama_customer,
    //                         //         'message' => $message->message,
    //                         //         'created_at' => $message->created_date->toDateTimeString(),
    //                         //     ]));
    //                         // }
    //                     }
    //                 }
    //                 try {
    //                     if ($data['status']) {
    //                         $message = Message::create([
    //                             'conversation_id' => $data['conversation_id'],
    //                             'send_id' => $data['sender_id'],
    //                             'message' => $data['message'],
    //                             'status' => 1,
    //                         ]);
    //                     } else {
    //                         $message = Message::create([
    //                             'conversation_id' => $data['conversation_id'],
    //                             'send_id' => $data['sender_id'],
    //                             'message' => $data['message'],

    //                         ]);
    //                     }
    //                 } catch (\Exception $e) {
    //                     echo "Failed to save message: " . $e->getMessage() . "\n";
    //                     return;
    //                 }
    //             }
    //         }
    //     } else {
    //         // Handle customer messages if needed
    //         echo "masuk customer";
    //     }
    //     // var_dump("masuk : {$this->clients} ");
    //     // Kirim pesan ke semua klien yang terhubung
    //     // foreach ($this->clients as $client) {

    //     //     if ($from !== $client) {

    //     //         if ($message->status) {

    //     //             $user = User::where('kd_user', $message->send_id)->first();
    //     //             $client->send(json_encode([
    //     //                 'conversation_id' => $message->conversation_id,
    //     //                 'sender_id' => $message->send_id,
    //     //                 'user' => $user->nm_user,
    //     //                 'message' => $message->message,
    //     //                 'created_at' => $message->created_date->toDateTimeString(),
    //     //             ]));
    //     //         } else {
    //     //             $user = Customer::where('kd_customer', $message->send_id)->first();
    //     //             $client->send(json_encode([

    //     //                 'conversation_id' => $message->conversation_id,
    //     //                 'sender_id' => $message->send_id,
    //     //                 'user' => $user->nama_customer,
    //     //                 'message' => $message->message,
    //     //                 'created_at' => $message->created_date->toDateTimeString(),
    //     //             ]));
    //     //         }
    //     //         echo "Message sent to client {$client->resourceId}\n";
    //     //     }
    //     // }
    //     // 

    // }

    // public function onClose(ConnectionInterface $conn)
    // {
    //     // Logic ketika koneksi ditutup
    //     $this->clients->detach($conn);
    //     foreach ($this->channels as $chatId => $clients) {
    //         $clients->detach($conn);
    //         if ($clients->count() === 0) {
    //             unset($this->channels[$chatId]);
    //         }
    //     }
    //     echo "Connection {$conn->resourceId} has disconnected\n";
    // }

    // public function onError(ConnectionInterface $conn, \Exception $e)
    // {
    //     echo "An error has occurred: {$e->getMessage()}\n";
    //     // Logic untuk menangani error
    //     $conn->close();
    // }
}