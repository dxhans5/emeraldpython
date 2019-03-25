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
}
