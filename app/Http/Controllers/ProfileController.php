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
	public $UserTripExperiences = [];
	public $UserTrips = [];
	public $Trip = [];
	public $Feed = [];
	public $User = [];

	public function __construct() {
		$this->LoginController = new LoginController();
	}

	public function GetProfileFeed(Request $request){
		$UserId = $request->input('userId');
		// Validate login
		$UserIsLoggedIn = $this->LoginController->validateLoginState();
		if (!$UserIsLoggedIn){
			return response()->json(['responseMessage'=>'You\'re not logged in'], 400);
		}

		// Get user experience
		$ExperienceModel = new Experience();
		$Result = $ExperienceModel->GetExperiencesByUserFormatted($UserId);

		$this->UserExperiences = $Result['experiences'];
		$this->User = $Result['owner'];
		// Check if result
		if (!$this->UserExperiences)
		{
			return response()->json(['responseMessage' => 'This user has not created any experiences yet.'], 200);
		}

		// Get users trip
		$TripModel = new Trip();
		$this->UserTrips = $TripModel->GetTripsByUserFormatted($UserId);
		// If none found
		if (!$this->UserTrips)
		{
			$this->CreateFeed();
			return response()->json(['responseMessage' => 'Experiences, no trips found.', 'feed' => $this->Feed], 200);
		}
		// For each trip,
		foreach ($this->UserTrips as $trip) {
			// Extract experience Ids and turn BSON into array.
			$TripExperiences = iterator_to_array($trip->experiences);
			// Get the latests added experience and extract timestamp from Obj Id.
			$lastUpdated = end($TripExperiences)->getTimestamp();
			// Pass the experiences to the map function. Swaps real experiences with experience IDs in experience array
			$filtered = array_map([$this, "ExtractExperience" ], $TripExperiences);
			// Add swapped experiences to said trip
			$trip->experiences = $filtered;
			// Add finished trip to array of trips along with timestamp of latest addition to trip.
			$this->Feed [] = ['type' => 'trip', 'content' => $trip, 'timeStamp' => $lastUpdated, 'owner' => $this->User];
		}
		$this->CreateFeed();
		return response()->json(['responseMessage' => 'Here comes everything.', 'feed' => $this->Feed], 200);
	}

	public function CreateFeed(){
		// Assign timestamps
		foreach ($this->UserExperiences as $Experience){
			$timeStamp = $Experience->_id->getTimestamp();
			$this->Feed [] = [ 'type' => 'experience', 'content' => $Experience, 'timeStamp' => $timeStamp, 'owner' => $this->User];
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
		$UsersFollowing = $request->input('following');
		// Remove possible duplicates (Response to unknown error that inputs duplicate following=
		$UsersFollowing = array_unique($UsersFollowing);
		$TripModel = New Trip();
		$UsersFollowing = $TripModel->GetFollowingFeed($UsersFollowing);
		foreach ($UsersFollowing as $User){
			$Image = array_key_exists('image', $User) ? $User->image : 'default.jpg';
			$this->User = ["firstName" => $User->firstName, "lastName" => $User->lastName, "id" => $User->_id, 'image' => $Image];
			$this->FilterUserToFeed($User);
		}

		usort($this->Feed, [$this, 'SortByTimeStamp']);
		return response()->json(['responseMessage' => 'Here comes everything.', 'feed' => $this->Feed], 200);
	}

	public function FilterUserToFeed($User){
		// Check if experiences exist
		if (array_key_exists ( 'experiences', $User )){
			$this->UserExperiences = $User->experiences;
		}else{
			$this->UserExperiences = [];
		}
		// Check if trips exist
		// Then Filter them
		if (array_key_exists ( 'trips', $User )){
			$this->UserTrips = $User->trips;
			foreach ($this->UserTrips as $Trip){
				$this->Trip = $Trip;
				$TripExperiences = iterator_to_array($Trip->experiences);
				$TripExperiences = array_map([$this, "CreateTripExperiences" ], $TripExperiences);
			}
		}else{
			$this->UserTrips = [];
		}

		foreach ($this->UserExperiences as $Experience){
			$timeStamp = $Experience->_id->getTimestamp();
			$this->Feed [] = [ 'type' => 'experience', 'content' => $Experience, 'timeStamp' => $timeStamp, 'owner' => $this->User];
		}
		// Sort by date
	}

	public function CreateTripExperiences($TripExperience) {
		foreach ($this->UserExperiences as $key => $Experience){
			if ($TripExperience == $Experience->_id){
				$timeStamp = $Experience->_id->getTimestamp();
				$Experience ['parentTrip'] = ['tripId' => $this->Trip->_id, 'tripName' => $this->Trip->geolocation->name];
				$this->Feed [] = [ 'type' => 'tripExperience', 'content' => $Experience, 'timeStamp' => $timeStamp, 'owner' => $this->User];
				unset($this->UserExperiences[$key]);
				break;
			}
		}
		return ($TripExperience);
	}

}