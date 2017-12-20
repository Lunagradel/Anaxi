<?php
/**
 * Created by PhpStorm.
 * User: Johannes
 * Date: 19/12/2017
 * Time: 14.10
 */

namespace App\Http\Controllers;

use App\Http\Controllers\LoginController as LoginController;
use App\Http\Controllers\ExperienceController as ExperienceController;
use Illuminate\Http\Request;
use Trip\Trip as Trip;

class TripController {

	public $LoginController;

	public function __construct() {
		$this->LoginController = new LoginController();
	}

	public function CreateTrip(Request $request){
		$UserIsLoggedIn = $this->LoginController->validateLoginState();
		if (!$UserIsLoggedIn){
			return false;
		}

		$ExperienceController = new ExperienceController();
		$NewExperienceId = $ExperienceController->CreateExperience($request);
		// Create experience returns the whole update document from MongoDB.
		// Below variable takes the last item in the experiences array and returns the ID

//		$NewExperienceId = end($Experience->experiences)->_id;

		$UserId = $_SESSION["user_id"];
		$Geolocation = $request->input('trip');

		$Trip = new Trip();
		$Response = $Trip->CreateTrip($UserId, $Geolocation, $NewExperienceId );
		return $Response;
	}
	public function GetUserTrips(Request $request){
		$UserIsLoggedIn = $this->LoginController->validateLoginState();
		if (!$UserIsLoggedIn){
			return false;
		}
		$UserId = $request->input('userId');

		$Trip = new Trip();

		$Response = $Trip->GetTripsByUserId($UserId);
		return $Response;
	}
	public function AddToExistingTrip(Request $request){

	}
}