<?php
namespace MyApp;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Servidorsocket implements MessageComponentInterface {
    protected $clients;
    protected $connection;
    protected $shell = null;
    protected $conectado = false;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn) {
        // Store the new connection to send messages to later
        $this->clients->attach($conn);
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $data = json_decode($msg,true);
        switch (key($data)) {
            case 'data':
                fwrite($this->shell,$data['data']['data']);
                usleep(800);
                while($line = fgets($this->shell)) {
                    $from->send(mb_convert_encoding($line, "UTF-8"));
                }
                break;
            case 'auth':
                if ($this->connectSSH($data['auth']['server'],$data['auth']['port'],$data['auth']['user'],$data['auth']['password'])){
                    $from->send(mb_convert_encoding("Connected....", "UTF-8"));
                    while($line = fgets($this->shell)) {
                        $from->send(mb_convert_encoding($line, "UTF-8"));
                    }
                }else{
                    $from->send(mb_convert_encoding("Error, can not connect to the server. Check the credentials", "UTF-8"));
                    $from->close();
                }
                break;
            default:
                if ($this->conectado){
                    while($line = fgets($this->shell)) {                    
                        $from->send(mb_convert_encoding($line, "UTF-8"));
                    }
                }
                break;
        }
    }

    public function connectSSH($server,$port,$user,$password){
        $this->connection = ssh2_connect($server, $port);
        if (ssh2_auth_password($this->connection, $user, $password)) {
          //$conn->send("Authentication Successful!\n");
          $this->shell=ssh2_shell($this->connection, 'xterm', null, 80, 40, SSH2_TERM_UNIT_CHARS);
          sleep(1);
          $this->conectado=true;
          return true;
        } else {
          return false;
        }        
    }

    public function onClose(ConnectionInterface $conn) {
        // The connection is closed, remove it, as we can no longer send it messages
        $this->conectado=false;
        $this->clients->detach($conn);
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        $conn->close();
    }
}

?>
