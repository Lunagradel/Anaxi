<?php

namespace App\Http\Controllers;

use Faker\Provider\DateTime;
use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use DatabaseConnection;
Use App\Http\Controllers\UserController as UserController;
use AnaxiUser\User as User;
use MongoDB\Client as MongoClient;
use MongoDB\Collection as Collection;
use Experience\Experience as Experience;

class ExperienceController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function CreateExperience( Request $request )
    {
	    if (session_status() == PHP_SESSION_NONE) {
		    session_start();
	    }
	    $Rating = $request->input('recommended');
	    $Geolocation = $request->input('geolocation');
	    $Description = $request->input('description');
//	    $Image = $request->input('password');
	    $UserId = $_SESSION["user_id"];

	    $Experience = new Experience();
	    $Response = $Experience->createExperience($UserId, $Rating, $Geolocation, $Description);

	    return $Response;

    }
    public function GetExperiencesByUser( Request $request ) {
	    if (session_status() == PHP_SESSION_NONE) {
		    session_start();
	    }
	    $UserId = $_SESSION["user_id"];
	    $Experience = new Experience();
	    $Response = $Experience->GetExperiencesByUser($UserId);
	    return $Response;
    }
    public function UpdateExperience( Request $request ) {}
    public function DeleteExperience( Request $request ) {}
}
