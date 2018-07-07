<!doctype html>
  <html>
    <head>
      <link rel="stylesheet" href="node_modules/xterm/dist/xterm.css" />
      <script src="node_modules/xterm/dist/xterm.js"></script>
      <script src="node_modules/xterm/dist/addons/attach/attach.js"></script>
      <script src="node_modules/xterm/dist/addons/fit/fit.js"></script>
      <style>
      body {font-family: Arial, Helvetica, sans-serif;}

      input[type=text], input[type=password], input[type=number] {
          width: 100%;
          padding: 12px 20px;
          margin: 8px 0;
          display: inline-block;
          border: 1px solid #ccc;
          box-sizing: border-box;
      }

      button {
          background-color: #4CAF50;
          color: white;
          padding: 14px 20px;
          margin: 8px 0;
          border: none;
          cursor: pointer;
          width: 100%;
      }

      button:hover {
          opacity: 0.8;
      }

      .serverbox {
          padding: 16px;
          border: 3px solid #f1f1f1;
          width: 25%;
          position: absolute;
          top: 15%;
          left: 37%;
      }
      </style>
    </head>
    <body>
      <div id="serverbox" class="serverbox">
        <label for="psw"><b>Server</b></label><br>
        <input type="text" id="server" name="server" title="server" placeholder="server" /><br>
        <label for="psw"><b>Port</b></label><br>
        <input type="number" min="1" id="port" name="port" title="port" placeholder="port" /><br>
        <label for="psw"><b>User</b></label><br>
        <input type="text" id="user" name="user" title="user" placeholder="user" /><br>
        <label for="psw"><b>Password</b></label><br>
        <input type="password" id="password" name="password" title="password" placeholder="password" /><br>
        <button type="button" onclick="ConnectServer()">Connect</button><br>
      </div>
      <div id="terminal" style="width:100%; height:90vh;visibility:hidden"></div>
      <script>
        var resizeInterval;
        var wSocket = new WebSocket("ws:desarrolloweb.cetery.com:8080");
        Terminal.applyAddon(attach);  // Apply the `attach` addon
        Terminal.applyAddon(fit);  //Apply the `fit` addon
        var term = new Terminal({
				  cols: 80,
				  rows: 24
        });
        term.open(document.getElementById('terminal'));


        function ConnectServer(){
          document.getElementById("serverbox").style.visibility="hidden";
          document.getElementById("terminal").style.visibility="visible";
          var dataSend = {"auth":
                            {
                            "server":document.getElementById("server").value,
                            "port":document.getElementById("port").value,
                            "user":document.getElementById("user").value,
                            "password":document.getElementById("password").value
                            }
                          };
          wSocket.send(JSON.stringify(dataSend));

          term.fit();
          term.focus();
        }       

        wSocket.onopen = function (event) {
          console.log("Socket Open");
          term.attach(wSocket,false,false);
          window.setInterval(function(){
            wSocket.send(JSON.stringify({"refresh":""}));
          }, 700);
        };

        wSocket.onerror = function (event){
          term.detach(wSocket);
          alert("Connection Closed");
        }        
        
        term.on('data', function (data) {
          var dataSend = {"data":{"data":data}};
          wSocket.send(JSON.stringify(dataSend));
          //Xtermjs with attach dont print zero, so i force. Need to fix it :(
          if (data=="0"){
            term.write(data);
          }
        })
        
        //Execute resize with a timeout
        window.onresize = function() {
          clearTimeout(resizeInterval);
          resizeInterval = setTimeout(resize, 400);
        }
        // Recalculates the terminal Columns / Rows and sends new size to SSH server + xtermjs
        function resize() {
          if (term) {
            term.fit()
          }
        }
      </script>
    </body>
  </html>
