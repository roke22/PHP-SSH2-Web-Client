## New project with laravel and server inventory with ssh web client
https://github.com/roke22/Laravel-ssh-client

![](https://raw.githubusercontent.com/roke22/PHP-SSH2-Web-Client/master/demo.gif)

## PHP SSH2 Cliente Web

Cliente Web SSH2 en PHP que usa websockets para conectar a otros servidores por SSH con el cliente web.

Necesitas tener activadas libssh2 instalado en el servidor y hospedarlo en un servidor linux, puedes comprobar libssh2 con "phpinfo()" mas informacion en http://php.net/manual/en/book.ssh2.php

## INSTALACION

1. Instala libssh2. Si tienes plesk puedes seguir este manual https://support.plesk.com/hc/en-us/articles/213930085-How-to-install-SSH2-extension-for-PHP-
2. Instala xterm con "npm install" o en el directorio principal ejecuta "npm install xterm"
3. En el directorio "server" instala ratchet (http://socketo.me/) con composer, ejecuta en el directorio "server" el comando "composer install"
4. Arranca el websocket que esta en la carpeta "server/bin", puedes hacerlo con el comando "php server/bin/websocket.php 2>&1 >/dev/null &" desde el directorio principal
5. Modifica la url del websocket en el fichero index.html, linea 81
6. Ahora puedes cargar la web

NOTA: Puedes cambiar el tamaño de la consola modificando las constantes ROWS y COLS en Servidorsocket.php pero tambien debes modificarlos en el index.html, en caso de ser diferente no dibujara correctamente la informacion en la terminal web.

## LICENCIA

Cliente Web SSH2 esta bajo la licencia MIT, mas informacion en https://opensource.org/licenses/mit-license.php


## PHP SSH2 Web Client

SSH2 Web Client that use php and websockets to connect to a SSH server by a webclient.

You need to have libssh2 installed in your server and host the project on a linux server, you can check libssh2 with a "phpinfo()" more info at http://php.net/manual/en/book.ssh2.php

## INSTALLATION

1. Install libssh2. If you have Plesk Panel follow this manual https://support.plesk.com/hc/en-us/articles/213930085-How-to-install-SSH2-extension-for-PHP-
2. Install xterm with npm with "npm install" or on the root folder execute "npm install xterm"
3. On the "server" folder install ratchet (http://socketo.me/) with composer, execute on the "server" folder "composer install" 
4. Run the websocket that is in the "server/bin" folder, you can do it with the commando "php server/bin/websocket.php 2>&1 >/dev/null &" from the root folder.
5. Modify the url of the websocket in the index.html file, line 81
6. Now you can load the url of the domain.

NOTE: You can change the size of the terminal modifying the constants ROWS and COLS in Servidorsocket.php but you have to do in index.html too. Must be the same size in both files or the web terminal will draw the information in a bad way.

## LICENSE

SSH2 Web Client is under MIT license, more info at https://opensource.org/licenses/mit-license.php
