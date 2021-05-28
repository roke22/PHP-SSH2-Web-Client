## New project with laravel and server inventory with ssh web client
https://github.com/roke22/Laravel-ssh-client

![](https://raw.githubusercontent.com/roke22/PHP-SSH2-Web-Client/master/demo.gif)

# PHP SSH2 Cliente Web

Cliente Web SSH2 en PHP que usa websockets para conectar a otros servidores por SSH con el cliente web.

Necesitas tener activadas libssh2 instalado en el servidor y hospedarlo en un servidor linux, puedes comprobar libssh2 con "phpinfo()" mas informacion en http://php.net/manual/en/book.ssh2.php

## Instalación

1. Instala libssh2. Si tienes plesk puedes seguir este manual https://support.plesk.com/hc/en-us/articles/213930085-How-to-install-SSH2-extension-for-PHP-
2. Copia el contenido del directorio `server` al directorio raiz de tu servidor web, y cambia tu directorio activo a ese.
3. Instala xterm y sus addons con `npm install`.
4. Instala ratchet con `composer install`.
5. Arranca el websocket que esta en el directorio `server/bin`, puedes hacerlo con el comando `php server/bin/websocket.php 2>&1 >/dev/null &` desde el directorio principal.
6. Modifica la url del websocket en el fichero `index.html`, linea 81. Por defecto, apunta a `localhost:8080`.
7. Ahora puedes cargar la web en http://localhost.

NOTA: Puedes cambiar el tamaño de la consola modificando las constantes ROWS y COLS en `server/src/Servidorsocket.php` pero tambien debes modificarlos en `server/index.html`, en caso de ser diferente no dibujara correctamente la informacion en la terminal web.

## Licencia

Cliente Web SSH2 esta bajo la licencia MIT, mas informacion en https://opensource.org/licenses/mit-license.php

# PHP SSH2 Web Client

SSH2 Web Client that use php and websockets to connect to a SSH server by a webclient.

You need to have libssh2 installed in your server and host the project on a linux server, you can check libssh2 with a "phpinfo()" more info at http://php.net/manual/en/book.ssh2.php

## Installation

1. Install libssh2. If you have Plesk Panel follow this manual https://support.plesk.com/hc/en-us/articles/213930085-How-to-install-SSH2-extension-for-PHP-
2. Copy the `server` directory contents to your webserver root, and change your current directory to that.
3. Install xterm.js and addons using `npm install`.
4. Install ratchet using `composer install`.
5. Run the websocket that is in the `server/bin` directory. For reference, you can use the command `php server/bin/websocket.php 2>&1 >/dev/null &` from the root folder.
6. Modify the url of the websocket in the `index.html` file, line 81.
7. Now you can load the website on http://localhost.

NOTE: You can change the size of the terminal modifying the constants ROWS and COLS in `server/src/Servidorsocket.php` but you have to do in `server/index.html` too. Must be the same size in both files or the web terminal will draw the information in a bad way.

## License

SSH2 Web Client is under MIT license, more info at https://opensource.org/licenses/mit-license.php
