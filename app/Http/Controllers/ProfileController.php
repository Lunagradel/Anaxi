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
		// Validate login
		$UserIsLoggedIn = $this->LoginController->validateLoginState();
		if (!$UserIsLoggedIn){
			return response()->json(['responseMessage'=>'You\'re not logged in'], 400);
		}
		// Get user experience
		$ExperienceModel = new Experience();
		$User = $ExperienceModel->GetExperiencesByUser($UserId);
		if (empty($User[0]->experiences)){
			return response()->json(['responseMessage' => 'This user has not created any experiences yet.'], 200);
		}
		$UserExperiences = $User[0]->experiences;
		// Get users trip
		$TripModel = new Trip();
		$UserTrips = $TripModel->GetTripsByUserId($UserId);

		// Turn experience BSON into array so it can be filtered.
		$this->UserExperiences = iterator_to_array($UserExperiences);

		// Check if user has trips
		if (empty($UserTrips[0]->trips )){
			$Feed [] = ['trips' => [] ];
			$Feed [] = ['experiences' => $this->UserExperiences];
			return response()->json(['responseMessage' => 'Here comes the experiences, no trips tho.', 'feed' => $Feed], 200);
		}
		// For each trip,
		foreach ($UserTrips[0]->trips as $trip) {
			// Extract experience Ids and turn BSON into array.
			$tripExperiences = iterator_to_array($trip->experiences);
			// Get the latests added experience and extract timestamp from Obj Id.
			$lastUpdated = end($tripExperiences)->getTimestamp();
			// Pass the experiences to the map function. Swaps real experiences with experience IDs in experience array
			$filtered = array_map(array($this, "SwapExperience"), $tripExperiences);
			// Add swapped experiences to said trip
			$trip->experiences = $filtered;
			// Add finished trip to array of trips along with timestamp of latest addition to trip.
			$Feed [] = ['type' => 'trip', 'content' => $trip, 'timeStamp' => $lastUpdated];
		}

		foreach ($this->UserExperiences as $Experience){
			$timeStamp = $Experience->_id->getTimestamp();
			$Feed[] = [ 'type' => 'experience', 'content' => $Experience, 'timeStamp' => $timeStamp];
		}
		usort($Feed, [$this, 'SortByTimeStamp']);
		// Define the custom sort function
//		var_dump($Feed);
//		dd();
		return response()->json(['responseMessage' => 'Here comes everything.', 'feed' => $Feed], 200);
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

	public function SortByTimeStamp($a,$b) {
		return $a['timeStamp']>$b['timeStamp'];
	}

}