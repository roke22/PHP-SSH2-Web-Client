<?php
/*
** PHP SSH2 Web Client
** Autor: Jose Joaquin Anton
** Email: roke@roke.es
**
** License: The MIT License -> https://opensource.org/licenses/mit-license.php
**  Copyright (c) 2018 Jose Joaquin Anton
**  
**  Se concede permiso, libre de cargos, a cualquier persona que obtenga una copia de este software y de los archivos de documentación asociados 
**  (el "Software"), para utilizar el Software sin restricción, incluyendo sin limitación los derechos a usar, copiar, modificar, fusionar, publicar, 
**  distribuir, sublicenciar, y/o vender copias del Software, y a permitir a las personas a las que se les proporcione el Software a hacer lo mismo,
**  sujeto a las siguientes condiciones:
**  
**  El aviso de copyright anterior y este aviso de permiso se incluirán en todas las copias o partes sustanciales del Software.
**  
**  EL SOFTWARE SE PROPORCIONA "TAL CUAL", SIN GARANTÍA DE NINGÚN TIPO, EXPRESA O IMPLÍCITA, INCLUYENDO PERO NO LIMITADA A GARANTÍAS DE 
**  COMERCIALIZACIÓN, IDONEIDAD PARA UN PROPÓSITO PARTICULAR Y NO INFRACCIÓN. EN NINGÚN CASO LOS AUTORES O PROPIETARIOS DE LOS DERECHOS DE 
**  AUTOR SERÁN RESPONSABLES DE NINGUNA RECLAMACIÓN, DAÑOS U OTRAS RESPONSABILIDADES, YA SEA EN UNA ACCIÓN DE CONTRATO, AGRAVIO O CUALQUIER OTRO
**  MOTIVO, DERIVADAS DE, FUERA DE O EN CONEXIÓN CON EL SOFTWARE O SU USO U OTRO TIPO DE ACCIONES EN EL SOFTWARE.
*/

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
