<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /*
     *      sanitize
     *      Sanitizes user input
     */
    protected function sanitize($input) {
        return \htmlspecialchars(filter_var(htmlentities(trim($input)), FILTER_SANITIZE_STRING));
    }

    protected function processEbayAPIErrors($response) {
        $errors = [];
            if(is_array($response->Errors)) {
                foreach($response->Errors as $error) {
                    $msg = isset($error->ShortMessage) ? $error->ShortMessage : $error->LongMessage;
                    $errors[] = "Ebay: " . $msg;
                }
            } else {
                $msg = isset($response->Errors->ShortMessage) ? $response->Errors->ShortMessage : $response->Errors->LongMessage;
                $errors[] = "Ebay: " . $msg;
            }

            session()->forget('errors'); // just in case there are errors left over from something (edge case)
            session()->flash('errors', $errors);
            return back();
    }
}
