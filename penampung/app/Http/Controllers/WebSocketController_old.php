<?php

namespace App\Http\Controllers;

use DateTime;
use App\Models\User;
use App\Models\Message;
use App\Models\Customer;
use App\Models\Percakapan;
use App\Models\Participant;
use Illuminate\Http\Request;
use Ratchet\WebSocket\WsServer;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;


class WebSocketController extends Controller implements MessageComponentInterface
{

    protected $clients;
    protected $admin;
    protected $channels;
    public function __construct()
    {
        // parent::__construct();
        $this->clients = new \SplObjectStorage; // atau array []
        $this->admin = null;
        $this->channels = [];

        // $this->clients = []; // Ganti dengan array kosong
    }

    public function onOpen(ConnectionInterface $conn)
    {
        // Parse the query parameters from the connection URI
        $queryParams = $conn->httpRequest->getUri()->getQuery();
        parse_str($queryParams, $params);

        if (isset($params)) {
            if ($params['type'] == 'customer') {
                $customerId = $params['type'] === 'customer' ? $params['id_user'] : $params['id_user'];
                $cabangId = $params['id_cabang'];

                // Check if this connection (resourceId) already exists in SplObjectStorage
                foreach ($this->clients as $clientConn) {
                    $clientInfo = $this->clients[$clientConn];
                    if ($clientConn->resourceId === $conn->resourceId) {
                        echo "Connection already exists for Resource ID: {$conn->resourceId}\n";
                        return; // Do not create a new connection if it already exists
                    }
                }

                // Update database with connection_id
                if ($params['type'] === 'customer') {
                    Customer::where('kd_customer', $customerId)->update(['connection_id' => $conn->resourceId]);
                } else if ($params['type'] === 'admin') {
                    User::where('kd_user', $customerId)->update(['connection_id' => $conn->resourceId]);
                }

                // Attach the connection to SplObjectStorage
                $this->clients->attach($conn, [
                    'conversation_id' => $params['conversation_id'],
                    'connection' => $conn,
                    'user_id' => $customerId,
                    'cabangId' => $cabangId,
                    'type' => $params['type'],
                ]);
            } elseif ($params['type'] == 'admin') {

                $admin = $params['id_user'];
                $cabangId =  $params['id_cabang'];
                foreach ($this->clients as $clientConn) {
                    $clientInfo = $this->clients[$clientConn];
                    if ($clientConn->resourceId === $conn->resourceId) {
                        echo "Connection already exists for Resource ID: {$conn->resourceId}\n";
                        return; // Do not create a new connection if it already exists
                    }
                }
 
                // Update database with connection_id
                if ($params['type'] === 'admin') {
                    User::where('kd_user', $admin)->update(['connection_id' => $conn->resourceId]);
                }

                // Attach the connection to SplObjectStorage
                $this->clients->attach($conn, [
                    'conversation_id' => $params['conversation_id'],
                    'connection' => $conn,
                    'user_id' => $admin,
                    'cabangId' => $cabangId,
                    'type' => $params['type'],
                ]);
            }

            echo "New connection opened for Resource ID: {$conn->resourceId}\n";
        }

        // Display the current clients
        $this->echoClients();
    }


    protected function echoClients()
    {
        foreach ($this->clients as $conn) {
            $clientInfo = $this->clients[$conn];
            // echo "Chat ID: {$clientInfo['chat_id']}\n";
            echo " - Resource ID: {$conn->resourceId}, User ID: {$clientInfo['user_id']}, type: {$clientInfo['type']}, cabang: {$clientInfo['cabangId']}, conversation: {$clientInfo['conversation_id']}\n";
        }
    }
    public function onMessage(ConnectionInterface $from, $msg)
    {
        echo "Message received: $msg\n";

        // Decode the JSON message
        $data = json_decode($msg, true);

        $queryParams = $from->httpRequest->getUri()->getQuery();
        parse_str($queryParams, $params);
        if (isset($params)) {
            $cabang = $params['id_cabang'] ?? null;
            if ($params['type'] == 'customer') {

                $customerId = $params['id_user'];

                $conversation =    Percakapan::where('kd_customer', $customerId)->first();
                if (!$conversation) {
                    $customer = Customer::where('kd_customer', $customerId)->first();
                    $conversation =   Percakapan::create([
                        // 'kd_wilayah' => $params['wilayahId'],
                        'kd_cabang' =>  $customer->kd_cabang,
                        'kd_customer' => $customerId,
                        'created_by' => $customer->nama_customer
                    ]);

                    Participant::created([
                        'conversation_id' => $conversation->id,
                        'send_id' => $customerId
                    ]);
                }
                $message = Message::create([
                    'conversation_id' => $conversation->id,
                    'message' =>  $data['message'],
                    'send_id' => $customerId,
                    'created_date' => $data['created_date']
                ]);

                $customer = Customer::where('kd_customer', $message->send_id)->first();
                $date = new DateTime($message->created_date->toDateTimeString());
                $time = $date->format('H:i');
                foreach ($this->clients as $clientConn) {
                    $clientInfo = $this->clients[$clientConn];
                    if ($clientInfo['type'] === 'admin' && $clientInfo['cabangId'] === $cabang) {
                        $clientConn->send(json_encode([
                    	    'conversation_id' => $conversation->id, 
                            'message' => $message->message,
                            'send_id' => $customer->nama_customer,
                            'created_at' => $time,
                        ]));
                        echo "terkirim ke admin";
                    }
                }
                // if ($customerId && isset($this->clients[$customerId])) {
                //     // foreach ($this->clients[$customerId] as $client) {
                //     //     // Kirim pesan ke admin yang berada di region yang sama
                //     //     if ($client['type'] === 'admin' && $client['wilayahId'] === $wilayah) {
                //     //         $client->resourceId->send($msg);
                //     //         echo "terkirim ke admin";
                //     //     }
                //     // }

                // } else {
                //     echo "Chat ID {$customerId} does not exist.\n";
                // }
            } elseif ($params['type'] === 'admin') {
                // Handle admin messages
                $chatId = $data['conversation_id'];

                if ($chatId) {
                    $recipientFound = false;
                    try {

                        $message = Message::create([
                            'conversation_id' => $chatId,
                            'send_id' => $data['sender_id'],
                            'message' => $data['message'],
                            'created_date' => $data['created_date'],
                            'status' => 1

                        ]);
                    } catch (\Exception $e) {
                        echo "Failed to save message: " . $e->getMessage() . "\n";
                        return;
                    }

                    $user = User::where('kd_user', $message->send_id)->first();
                    $date = new DateTime($message->created_date->toDateTimeString());
                    $time = $date->format('H:i');
                    foreach ($this->clients as $clientConn) {
                        $clientInfo = $this->clients[$clientConn];


                        // Ensure the message is sent to the correct customer
                        if ($clientInfo['type'] === 'customer' && $clientInfo['conversation_id'] == $chatId) {
                            $clientInfo['connection']->send(json_encode([
                                'conversation_id' => $chatId,
                                'message' => $message->message,
                                'send_id' => $user->nm_user,
                                'created_at' => $time,
                            ]));
                            // $clientInfo->send(json_encode($msg));

                            $recipientFound = true;
                            echo "terkirim ke customer ";
                        }
                    }

                    if (!$recipientFound) {
                        echo "Recipient customer not found for Chat ID: {$chatId}\n";
                    }
                } else {
                    echo "Invalid Chat ID: {$chatId}\n";
                }
            }
        }
    }

    public function onClose(ConnectionInterface $conn)
    {
        // foreach ($this->clients as $chatId => $clientGroup) {
        //     if (isset($clientGroup[$conn->resourceId])) {
        //         unset($this->clients[$chatId][$conn->resourceId]);
        //         echo "Connection closed! Chat ID: $chatId\n";
        //     }
        // }
        // Check if the connection exists in the storage before detaching
        if ($this->clients->contains($conn)) {
            $clientInfo = $this->clients[$conn];

            // Output information about the closed connection
            echo "Connection closed! Chat ID: {$clientInfo['username_id']}, User ID: {$clientInfo['user_id']}, Role: {$clientInfo['role']}, Region: {$clientInfo['region']}\n";

            // Detach the connection from the SplObjectStorage
            $this->clients->detach($conn);

            // Optionally, you can check the size of the client group for this chat ID
            $chatId = $clientInfo['chat_id'];
            if ($this->countClientsInChat($chatId) === 0) {
                echo "No more clients connected to Chat ID: $chatId\n";
                // Optionally, handle logic when no clients remain for a chat ID
            }
        } else {
            echo "Connection was not found in storage!\n";
        }
        // Menampilkan isi dari $clients setelah koneksi ditutup
        $this->echoClients();
    }

    protected function countClientsInChat($chatId)
    {
        $count = 0;
        foreach ($this->clients as $conn) {
            $clientInfo = $this->clients[$conn];
            if ($clientInfo['chat_id'] === $chatId) {
                $count++;
            }
        }
        return $count;
    }
    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "An error has occurred: {$e->getMessage()}\n";
        // Logic untuk menangani error
        $conn->close();
    }
}