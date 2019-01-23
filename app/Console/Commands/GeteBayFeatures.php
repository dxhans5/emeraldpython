<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Config;

class GeteBayFeatures extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ebay:getFeatures';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Retrieves standard meta data for the features of the eBay API';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $config = Config::first();
        $url = env('EBAY_SOAP_DOMAIN');
        $data = '<?xml version="1.0" encoding="utf-8"?>
        <soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/"
                       xmlns:xs="http://www.w3.org/2001/XMLSchema"
                       xmlns:ebl="urn:ebay:apis:eBLBaseComponents">
            <soap:Header>
                <ebl:RequesterCredentials soap:mustUnderstand="0">
                    <eBayAuthToken>' .
                    $config->client_token
                 . '</eBayAuthToken>
                </ebl:RequesterCredentials>
            </soap:Header>
            <soap:Body>
                <GeteBayDetailsRequest xmlns="urn:ebay:apis:eBLBaseComponents">
                    <DetailName>ShippingServiceDetails</DetailName>
                    <ErrorLanguage>en_US</ErrorLanguage>
                    <MessageID>ShippingServiceDetails_PugVenturesLLC</MessageID>
                    <Version>1085</Version>
                    <WarningLevel>High</WarningLevel>
                </GeteBayDetailsRequest>
            </soap:Body>
        </soap:Envelope>';

        $result = $this->makesoaprequest($url, $data);
        print_r($result); die();
    }

    private function makesoaprequest($url, $soapdata){
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/soap+xml', 'Authorization: Basic', 'SOAPAction: null'));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "$soapdata");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //Begin SSL
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        //End SSL
        $response = curl_exec($ch);
        return $response;
        curl_close($ch);
    }
}
