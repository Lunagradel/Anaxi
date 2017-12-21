<?php
/**
 * Created by PhpStorm.
 * User: Johannes
 * Date: 20/12/2017
 * Time: 15.21
 */

namespace App\Http\Controllers;

use App\Http\Controllers\LoginController as LoginController;
use Experience\Experience as Experience;
use Trip\Trip as Trip;
use Illuminate\Http\Request;

class ProfileController {

	public $LoginController;
	public $UserExperiences = [];
	public $UserTrips = [];

	public function __construct() {
		$this->LoginController = new LoginController();
	}

	public function GetProfileFeed(Request $request){
		$Feed = [];
		$UserId = $request->input('userId');
		$UserId = '5a3b6f16dde68439667e4a39';
		// Validate login
		$UserIsLoggedIn = $this->LoginController->validateLoginState();
		if (!$UserIsLoggedIn){
			return false;
		}
		// Get user experience
		$ExperienceModel = new Experience();
		$User = $ExperienceModel->GetExperiencesByUser($UserId);
		$UserExperiences = $User[0]->experiences;
		// Get users trip
		$TripModel = new Trip();
		$UserTrips = $TripModel->GetTripsByUserId($UserId);

		// Turn experience BSON into array so it can be filtered.
		$this->UserExperiences = iterator_to_array($UserExperiences);

		// For each trip,
		foreach ($UserTrips[0]->trips as $trip){
			// Extract experience Ids and turn BSON into array.
			$tripExperiences = iterator_to_array($trip->experiences);
			// Pass the experiences
			$filtered = array_map(array($this, "SwapExperience"), $tripExperiences);
			$trip->experiences = $filtered;
			$this->UserTrips [] = $trip;
		}
		$Feed [] = ['trips' => $this->UserTrips ];
		$Feed [] = ['experiences' => $this->UserExperiences];

		Return $Feed;
    }

	public function SwapExperience($tripExperience){
		foreach ($this->UserExperiences as $key => $experience){
			if ($tripExperience == $experience->_id){
				$tripExperience = $experience;
				unset($this->UserExperiences[$key]);
				break;
			}
		}
		return ($tripExperience);
	}

}