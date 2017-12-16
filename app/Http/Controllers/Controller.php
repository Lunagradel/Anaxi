<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use DatabaseConnection;
use AnaxiUser\User as User;
use App\Http\Controllers\LoginController;
use MongoDB\Client as MongoClient;
use MongoDB\Collection as Collection;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function GetFrontpage( ) {
	    $loggedIn = LoginController::validateLoginState();;
	    return view('welcome', compact('loggedIn'));
    }

}
