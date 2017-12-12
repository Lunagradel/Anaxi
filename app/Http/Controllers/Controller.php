<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use DatabaseConnection;
use AnaxiUser;
use MongoDB\Client as MongoClient;
use MongoDB\Collection as Collection;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function GetUsers(){
	    $Database = new DatabaseConnection\DatabaseConnection();
	    $Collection = $Database->GetMongoInstance();
	    return $Collection->find()->toArray();
    }

    public function CreateUser( $request ) {
	    $user = new AnaxiUser\User();
	    $user->CreateUser($request);
    }

}
