<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use App\Http\Controllers\LoginController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    // AuthorizesRequests is used when using the Auth. Not in use
    // DispatchesJobs is used for queueing requests. Defer consuming tasks to after requests.
		// ValidatesRequests is used for easy request validation. Making sure required fields are filled in.

    public function GetFrontpage( ) {
	    $loggedIn = LoginController::validateLoginState();;

	    return view('welcome', compact('loggedIn'));
    }

}
