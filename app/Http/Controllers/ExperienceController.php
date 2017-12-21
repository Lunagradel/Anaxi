<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use App\Http\Controllers\LoginController as LoginController;
use Experience\Experience as Experience;

class ExperienceController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $LoginController;

    public function __construct() {
    	$this->LoginController = new LoginController();
    }

		public function CreateExperience( Request $request )
    {
	    $UserIsLoggedIn = $this->LoginController->validateLoginState();
	    if (!$UserIsLoggedIn){
		    return false;
	    }

	    // If the request comes from the TripController, adjust to different structure
	    $hasTripParameter = $request->input('trip');
	    if (isset($hasTripParameter)){
		    $Rating = $request->input('experience.recommended');
		    $Geolocation = $request->input('experience.geolocation');
		    $Description = $request->input('experience.description');
	    }else{
		    $Rating = $request->input('recommended');
		    $Geolocation = $request->input('geolocation');
		    $Description = $request->input('description');
	    }

//	    $Image = $request->input('password');
	    $UserId = $_SESSION["user_id"];

	    $Experience = new Experience();
	    $Response = $Experience->createExperience($UserId, $Rating, $Geolocation, $Description);

	    return $Response;

    }
    public function GetExperiencesByUser( Request $request ) {
	    $UserIsLoggedIn = $this->LoginController->validateLoginState();
	    if (!$UserIsLoggedIn){
	    	return false;
	    }
	    $UserId = $request->input('userId');
	    $Experience = new Experience();
	    $Response = $Experience->GetExperiencesByUser($UserId);
	    return $Response;
    }

}
