<?php

namespace App\Classes\eBayAPI;

use Illuminate\Support\Facades\Session;
use App\Classes\eBayAPI\eBaySession;
use Facades\App\Models\Config;

class FetchToken extends eBayAPI
{

    private $config;
    private $sessionID;

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->config = Config::getFirst();
        $this->sessionID = $this->config->temp_session_id;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $requestXmlBody = "<?xml version='1.0' encoding='utf-8' ?>";
        $requestXmlBody .= "<FetchTokenRequest xmlns='urn:ebay:apis:eBLBaseComponents'>";
        $requestXmlBody .= "<!-- Call-specific Input Fields -->";
        $requestXmlBody .= "<SessionID>$this->sessionID</SessionID>";

        $requestXmlBody .= "<!-- Standard Input Fields -->";
        $requestXmlBody .= "<ErrorLanguage>$this->ErrorLanguage</ErrorLanguage>";
        $requestXmlBody .= "<MessageID>$this->MessageID</MessageID>";
        $requestXmlBody .= "<Version>$this->Version</Version>";
        $requestXmlBody .= "<WarningLevel>$this->WarningLevel</WarningLevel>";
        $requestXmlBody .= "</FetchTokenRequest >";

        $session = new eBaySession(null, env('EBAY_DEV_ID'), env('EBAY_CLIENT_ID'), env('EBAY_SECRET'), env('EBAY_XML_DOMAIN'), 1085, 0, 'FetchToken');
        $responseXml = $session->sendHttpRequest($requestXmlBody);

        $responseDoc = new \DomDocument();
        $responseDoc->loadXML($responseXml);

        //get any error nodes
        $errors = $responseDoc->getElementsByTagName('Errors');
        $this->displayErrors($errors);

        $eBayAuthToken = $responseDoc->getElementsByTagName('eBayAuthToken')->item(0)->nodeValue;
        $HardExpirationTime = $responseDoc->getElementsByTagName('HardExpirationTime')->item(0)->nodeValue;

        return ['user_token' => $eBayAuthToken, 'user_token_expires_at' => $HardExpirationTime];
    }
}
