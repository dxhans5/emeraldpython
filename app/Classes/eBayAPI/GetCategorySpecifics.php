<?php

namespace App\Classes\eBayAPI;

use Illuminate\Http\Request;
use App\Classes\eBayAPI\eBaySession;

class GetCategorySpecifics extends eBayAPI
{

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function handle($request, $suggestions) {
        $suggestion_keys = array_keys($suggestions);
        $last_suggestion_key = end($suggestion_keys);

        $user_token = $request->session()->get('user_token');

        $requestXmlBody = "<?xml version='1.0' encoding='utf-8' ?>";
        $requestXmlBody .= "<GetCategorySpecificsRequest xmlns='urn:ebay:apis:eBLBaseComponents'>";
        $requestXmlBody .= "<!-- Call-specific Input Fields -->";
        $requestXmlBody .= "<CategoryID>$last_suggestion_key</CategoryID>";

        $requestXmlBody .= "<!-- Authentication -->";
        $requestXmlBody .= "<RequesterCredentials>";
        $requestXmlBody .= "<eBayAuthToken>$user_token</eBayAuthToken>";
        $requestXmlBody .= "</RequesterCredentials>";

        $requestXmlBody .= "<!-- Standard Input Fields -->";
        $requestXmlBody .= "<ErrorLanguage>$this->ErrorLanguage</ErrorLanguage>";
        $requestXmlBody .= "<MessageID>$this->MessageID</MessageID>";
        $requestXmlBody .= "<Version>$this->Version</Version>";
        $requestXmlBody .= "<WarningLevel>$this->WarningLevel</WarningLevel>";
        $requestXmlBody .= "</GetCategorySpecificsRequest>";

        $session = new eBaySession($user_token, env('EBAY_DEV_ID'), env('EBAY_CLIENT_ID'), env('EBAY_SECRET'), env('EBAY_XML_DOMAIN'), 1085, 0, 'GetCategorySpecifics');
        $responseXml = $session->sendHttpRequest($requestXmlBody);

        $xml = \simplexml_load_string($responseXml);
        $raw_recommendations = $xml->Recommendations->children()->NameRecommendation;
        $recommendations = [];

        foreach($raw_recommendations as $recommendation) {
            $valueRecommendations = $recommendation->ValueRecommendation;
            $values = [];
            foreach($valueRecommendations as $value) {
                $values[] = $value->Value->__toString();
            }

            if(sizeof($values) > 1) {
                $name = $recommendation->Name->__toString();
                $recommendations[$name] = $values;
            }
        }

        return $recommendations;
    }

}
