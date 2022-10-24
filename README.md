# php-mail-interface-client

A client that connects to https://github.com/auftraggeber/php-mail-interface.

Sends all mail data via post (with cURL) to the interface.

mail.php implements the mail object.
mailSettings.php defines the static settings interface.
jsonMailSettings.php is an implemenetation of this interface.

Call Mail->send() to send the mail.

## jsonMailsettings.php

Reads a json file (mailSettings.json).
This file must have a key "apiUrl" wich leads to an instance of https://github.com/auftraggeber/php-mail-interface and a key "postParameters" with all default params to send.
Note the instance of the external api can also define some default params. But the ones that are sended have a higher priority.