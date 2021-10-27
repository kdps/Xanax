<?php

namespace Xanax\Classes\XMPP;

use Xanax\Classes\HTML\Handler as HTMLHandler;

class Bosh {

    public function getRestartBody($rid, $sid, $to)
    {
        $attributes = [
            "rid" => "'$rid'",
            "xmlns" => "'http://jabber.org/protocol/httpbind'",
            "sid" => "'$sid'",
            "to" => "'$to'",
            "xml:lang" => "'en'",
            "xmpp:restart" => "'true'",
            "xmlns:xmpp" => "'urn:xmpp:xbosh'"
        ];

        return HTMLHandler::generateElement("body", "", $attributes, true);
    }
    
}