<?php

namespace App\Classes\eBayAPI;

use Illuminate\Http\Request;
use App\Classes\eBayAPI\eBayAPI;
use App\Classes\eBayAPI\eBaySession;
use Facades\App\Models\Config;

class GetSessionID extends eBayAPI
{
    private $RuName;
    private $config;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->RuName = env("EBAY_RUNAME");

        $this->config = Config::getFirst();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(Request $request)
    {
        $requestXmlBody = "<?xml version='1.0' encoding='utf-8' ?>";
        $requestXmlBody .= "<GetSessionIDRequest  xmlns='urn:ebay:apis:eBLBaseComponents'>";
        $requestXmlBody .= "<!-- Call-specific Input Fields -->";
        $requestXmlBody .= "<RuName>$this->RuName</RuName>";
        $requestXmlBody .= "<!-- Standard Input Fields -->";
        $requestXmlBody .= "<ErrorLanguage>$this->ErrorLanguage</ErrorLanguage>";
        $requestXmlBody .= "<MessageID>$this->MessageID</MessageID>";
        $requestXmlBody .= "<Version>$this->Version</Version>";
        $requestXmlBody .= "<WarningLevel>$this->WarningLevel</WarningLevel>";
        $requestXmlBody .= "</GetSessionIDRequest >";

        $session = new eBaySession(null, env('EBAY_DEV_ID'), env('EBAY_CLIENT_ID'), env('EBAY_SECRET'), env('EBAY_XML_DOMAIN'), 1085, 0, 'GetSessionID');
        $responseXml = $session->sendHttpRequest($requestXmlBody);

        $responseDoc = new \DomDocument();
        $responseDoc->loadXML($responseXml);

        //get any error nodes
        $errors = $responseDoc->getElementsByTagName('Errors');
        $this->displayErrors($errors);

        $sessionID = $responseDoc->getElementsByTagName('SessionID')->item(0)->nodeValue;

        // Store the id to be retrieved during the token fetch
        $this->config->temp_session_id = $sessionID;
        $this->config->save();

        return $sessionID;
    }
}
