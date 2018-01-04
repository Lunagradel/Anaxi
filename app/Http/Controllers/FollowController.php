<?php

namespace App\Http\Controllers;

// use Faker\Provider\DateTime;
use Illuminate\Http\Request;
// use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
// use Illuminate\Foundation\Validation\ValidatesRequests;
// use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use App\Http\Controllers\LoginController as LoginController;
// use Experience\Experience as Experience;
use Follow\Follow as Follow;

class FollowController extends BaseController
{
    public $LoginController;

    public function __construct() {
    	$this->LoginController = new LoginController();
    }

    public function FollowUser( Request $request )
    {
        $UserIsLoggedIn = $this->LoginController->validateLoginState();
	    if (!$UserIsLoggedIn){
		    return false;
	    }

        $UserId = $_SESSION["user_id"];
        $UserToFollowId = $request->input('followId');
        $UserToFollowName = $request->input('userFullName');
        $LoggedInName = $request->input('loggedInFullName');

        $Follow = new Follow();
        $Response = $Follow->FollowUser($UserId, $UserToFollowId, $UserToFollowName, $LoggedInName);

        return $Response;

    }

    public function UnfollowUser( Request $request)
    {

        $UserIsLoggedIn = $this->LoginController->validateLoginState();
		    if (!$UserIsLoggedIn){
			    return response()->json(['responseMessage'=>'You\'re not logged in'], 400);
		    }

        $UserId = $_SESSION["user_id"];
        $UserToUnfollow = $request->input('unFollowId');
        $UserToUnfollowName = $request->input('userFullName');
        $LoggedInName = $request->input('loggedInFullName');

        $Follow = new Follow();
        $Response = $Follow->UnfollowUser($UserId, $UserToUnfollow, $UserToUnfollowName, $LoggedInName);

        return $Response;
    }
}
