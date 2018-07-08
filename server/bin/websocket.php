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

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use MyApp\Servidorsocket;

    require dirname(__DIR__) . '/vendor/autoload.php';
    $server = IoServer::factory(
        new HttpServer(
            new WsServer(
                new Servidorsocket()
            )
        ),
        8080
    );

    $server->run();

?>
