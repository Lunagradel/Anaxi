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

	public function __construct() {
		$this->LoginController = new LoginController();
	}

	public function GetProfileFeed(){
		$UserId = '5a3b6f16dde68439667e4a39';

		// Validate login
		$UserIsLoggedIn = $this->LoginController->validateLoginState();
		if (!$UserIsLoggedIn){
			return false;
		}
		// Create experiences array
		$ExperienceModel = new Experience();
		$Response = $ExperienceModel->GetExperiencesByUser($UserId);
		$ExperiencesIds = array();
		foreach ($Response[0]->experiences as $whatever){
			$ExperiencesIds[] = $whatever->_id;
		}
		// Create tripexperiences array
		$TripModel = new Trip();
		$TripResponse = $TripModel->GetTripsByUserId($UserId);
		$ExperiencesIdsInTrips = array();
		foreach ($TripResponse[0]->trips as $trips){
			foreach ($trips->experiences as $experience) {
				$ExperiencesIdsInTrips[] = $experience;
			}
		}
		// Sort out experiences that Exists in trip feed
		$LoneExperiences = array_diff($ExperiencesIds, $ExperiencesIdsInTrips);

		dd($LoneExperiences);
		Return $Response;
    }

}