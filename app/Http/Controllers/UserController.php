<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use DatabaseConnection;
use AnaxiUser\User as User;
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

    public function CreateUser( Request $request ) {
	    $FirstName = $request->input('firstName');
	    $LastName = $request->input('lastName');
	    $Email = $request->input('email');
	    $Password = $request->input('password');

	    $user = new User();
	    $response = $user->CreateUser($FirstName, $LastName, $Email, $Password);;
	    return $response;
    }
}
