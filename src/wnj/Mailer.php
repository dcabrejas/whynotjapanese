<?php

namespace Wnj;

use PHPMailer\PHPMailer\PHPMailer;

/**
 * @author Diego Cabrejas <dcabrejas@icloud.com>
 */
class Mailer extends PHPMailer
{
    public function __construct($host, $username, $password, $securityProtocol, $port, $exceptions = null)
    {
        parent::__construct($exceptions);

        $this->SMTPDebug = 2; // Enable verbose debug output todo remove for production?
        $this->CharSet = 'UTF-8';
        $this->isSMTP();
        $this->Host = $host;
        $this->SMTPAuth = true;
        $this->Username = $username;
        $this->Password = $password;
        $this->SMTPSecure = $securityProtocol;
        $this->Port = $port;
    }
}
