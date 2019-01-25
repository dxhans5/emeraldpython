<?php

namespace App\Classes\eBayAPI;

class eBayAPI {

    protected $ErrorLanguage;
    protected $MessageID;
    protected $Version;
    protected $WarningLevel;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->ErrorLanguage = 'en_US';
        $this->MessageID = 'PUGeBay_GetSessionID';
        $this->Version = '1085';
        $this->WarningLevel = 'High';
    }

    protected function displayErrors($errors) {
        //if there are error nodes
        if($errors->length > 0)
        {
            echo '<P><B>eBay returned the following error(s):</B>';
            //display each error
            //Get error code, ShortMesaage and LongMessage
            $code = $errors->item(0)->getElementsByTagName('ErrorCode');
            $shortMsg = $errors->item(0)->getElementsByTagName('ShortMessage');
            $longMsg = $errors->item(0)->getElementsByTagName('LongMessage');
            //Display code and shortmessage
            echo '<P>', $code->item(0)->nodeValue, ' : ', str_replace(">", "&gt;", str_replace("<", "&lt;", $shortMsg->item(0)->nodeValue));
            //if there is a long message (ie ErrorLevel=1), display it
            if(count($longMsg) > 0)
                echo '<BR>', str_replace(">", "&gt;", str_replace("<", "&lt;", $longMsg->item(0)->nodeValue));
            die();

        }
    }
}
