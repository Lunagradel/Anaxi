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
	public $Feed = [];

	public function __construct() {
		$this->LoginController = new LoginController();
		// Validate login
		$UserIsLoggedIn = $this->LoginController->validateLoginState();
		if (!$UserIsLoggedIn){
			return response()->json(['responseMessage'=>'You\'re not logged in'], 400);
		}
	}

	public function getFeed() {
		return $this->Feed;
	}

	public function GetProfileFeed(Request $request){
		$UserId = $request->input('userId');

		// Get user experience
		$ExperienceModel = new Experience();
		$StoredExperiences = $ExperienceModel->GetExperiencesByUser($UserId);
		// Check if result
		if (isset($StoredExperiences) && array_key_exists('experiences', $StoredExperiences[0]))
		{
			// Turn experience BSON into array so it can be filtered.
			$StoredExperiences = iterator_to_array($StoredExperiences[0]->experiences);
			$this->UserExperiences = $StoredExperiences;
		} else {
			// If user has nothing.
			return response()->json(['responseMessage' => 'This user has not created any experiences yet.'], 200);
		}

		// Get users trip
		$TripModel = new Trip();
		$StoredTrips = $TripModel->GetTripsByUserId($UserId);
		if (isset($StoredTrips) && array_key_exists('trips', $StoredTrips[0]))
		{
			$StoredTrips = $StoredTrips[0]->trips;
		} else {
			$this->CreateFeed();
			return response()->json(['responseMessage' => 'Here comes the experiences, no trips tho.', 'feed' => $this->Feed], 200);
		}
		// For each trip,
		foreach ($StoredTrips as $trip) {
			// Extract experience Ids and turn BSON into array.
			$TripExperiences = iterator_to_array($trip->experiences);
			// Get the latests added experience and extract timestamp from Obj Id.
			$lastUpdated = end($TripExperiences)->getTimestamp();
			// Pass the experiences to the map function. Swaps real experiences with experience IDs in experience array
			$filtered = array_map([$this, "ExtractExperience" ], $TripExperiences);
			// Add swapped experiences to said trip
			$trip->experiences = $filtered;
			// Add finished trip to array of trips along with timestamp of latest addition to trip.
			$this->Feed [] = ['type' => 'trip', 'content' => $trip, 'timeStamp' => $lastUpdated];
		}
		$this->CreateFeed();
		return response()->json(['responseMessage' => 'Here comes everything.', 'feed' => $this->Feed], 200);
	}

	public function CreateFeed(){
		// Assign timestamps
		foreach ($this->UserExperiences as $Experience){
			$timeStamp = $Experience->_id->getTimestamp();
			$this->Feed [] = [ 'type' => 'experience', 'content' => $Experience, 'timeStamp' => $timeStamp];
		}
		// Sort by date
		usort($this->Feed, [$this, 'SortByTimeStamp']);
	}

	public function ExtractExperience($tripExperience){
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
		return $a['timeStamp']<$b['timeStamp'];
	}

	public function GetFollowingFeed(Request $request){
		$Following = $request->input('following');
		// Remove possible duplicates (Response to unknown error that inputs duplicate following=
		$Following = array_unique($Following);
		print_r($Following);
	}

}