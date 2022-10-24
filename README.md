# php-mail-interface-client

A client that connects to https://github.com/auftraggeber/php-mail-interface.

Sends all mail data via post (with cURL) to the interface.

mail.php implements the mail object.
mailSettings.php defines the static settings interface.
jsonMailSettings.php is an implemenetation of this interface.

Call Mail->send() to send the mail.