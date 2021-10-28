<?php

namespace Xanax\Classes\XMPP;

use Xanax\Classes\HTML\Handler as HTMLHandler;

class Bosh 
{
    private $user = "";

    private $password = "";

    private $domain;

    private $rid;
    
    private $sid;
    
    public function __construct($user, $password, $domain)
    {
        $this->user = $user;
        $this->password = $password;
        $this->domain = $domain;
    }

    public function getPlainHash()
    {
        $hash_value = sprintf("%s@%s\0%s\0%s", $this->user, $this->domain, $this->user, $this->password);
        $hash = base64_encode($hash_value) . "\n";

        return $hash;
    }

    public function getSASLAuth($hash, $mechanism = 'PLAIN')
    {
        $auth_attributes = [
            "xmlns" => "'urn:ietf:params:xml:ns:xmpp-sasl'",
            "mechanism" => "'$mechanism'"
        ];

        $iq_element = HTMLHandler::generateElement("iq", $hash, $auth_attributes, false);

        $attributes = [
            "rid" => "'$this->rid'",
            "xmlns" => "'http://jabber.org/protocol/httpbind'",
            "sid" => "'$this->sid'"
        ];

        return HTMLHandler::generateElement("body", $iq_element, $attributes, true);
    }

    public function getSessionAuth2()
    {
        $session_attributes = [
            "xmlns" => "'urn:ietf:params:xml:ns:xmpp-session'"
        ];

        $session_element = HTMLHandler::generateElement("bind", "", $session_attributes, true);

        $iq_attributes = [
            "type" => "'set'",
            "id" => "'_session_auth_2'",
            "xmlns" => "'jabber:client'",

        ];

        $iq_element = HTMLHandler::generateElement("iq", $session_element, $iq_attributes, false);

        $attributes = [
            "rid" => "'$this->rid'",
            "xmlns" => "'http://jabber.org/protocol/httpbind'",
            "sid" => "'$this->sid'"
        ];

        return HTMLHandler::generateElement("body", $iq_element, $attributes, true);
    }

    public function getBindAuth2()
    {
        $bind_attributes = [
            "xmlns" => "'urn:ietf:params:xml:ns:xmpp-bind'"
        ];

        $bind_element = HTMLHandler::generateElement("bind", "", $bind_attributes, true);

        $iq_attributes = [
            "type" => "'set'",
            "id" => "'_bind_auth_2'",
            "xmlns" => "'jabber:client'",

        ];

        $iq_element = HTMLHandler::generateElement("iq", $bind_element, $iq_attributes, false);

        $attributes = [
            "rid" => "'$this->rid'",
            "xmlns" => "'http://jabber.org/protocol/httpbind'",
            "sid" => "'$this->sid'"
        ];

        return HTMLHandler::generateElement("body", $iq_element, $attributes, true);
    }

    public function getRestartBody($to)
    {
        $attributes = [
            "rid" => "'$this->rid'",
            "xmlns" => "'http://jabber.org/protocol/httpbind'",
            "sid" => "'$this->sid'",
            "to" => "'$to'",
            "xml:lang" => "'en'",
            "xmpp:restart" => "'true'",
            "xmlns:xmpp" => "'urn:xmpp:xbosh'"
        ];

        return HTMLHandler::generateElement("body", "", $attributes, true);
    }
    
}