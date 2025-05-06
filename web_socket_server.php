<?php
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/core/Session.php'; // Jika Anda ingin menggunakan sesi

class NotificationServer implements MessageComponentInterface {
    protected $clients;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn) {
        $this->clients->attach($conn);
        echo "New connection! ({$conn->resourceId})\n";
        // Mungkin kirim ID pengguna saat koneksi dan simpan di sini
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        // Handle pesan dari klien (jika diperlukan)
        echo sprintf('Connection %d sending message "%s" %s', $from->resourceId, $msg, "\n");
    }

    public function onClose(ConnectionInterface $conn) {
        $this->clients->detach($conn);
        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";
        $conn->close();
    }

    // Metode untuk mengirim notifikasi ke pengguna tertentu
    public function sendNotification($userId, $type, $message) {
        foreach ($this->clients as $client) {
            // Jika kita menyimpan ID pengguna terkait dengan koneksi
            // if ($client->userId == $userId) {
                $client->send(json_encode(['type' => $type, 'message' => $message]));
            // }
        }
    }
}

$server = IoServer::factory(
    new WsServer(
        new NotificationServer()
    ),
    8080 // Port untuk WebSocket server
);

$server->run();
?>
