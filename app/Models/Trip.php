<?php
/**
 * Created by PhpStorm.
 * User: Johannes
 * Date: 19/12/2017
 * Time: 15.33
 */

namespace Trip;

use DatabaseConnection;
use MongoDB;

class Trip {

	public $Geolocation = [];
	public $Experiences = [];
	public $DatePosted;
	// DB
	public $Collection;

	public function __construct() {
		$Database = new DatabaseConnection\DatabaseConnection();
		$this->Collection = $Database->GetMongoInstance();
	}
	public function CreateTrip($UserId, $Geolocation, $ExperienceId){

		$this->Geolocation = $Geolocation;
		$this->Experiences[] = $ExperienceId;

		$InsertResult = $this->Collection->findOneAndUpdate([
			'_id' => new MongoDB\BSON\ObjectID($UserId)
		],[
			'$push' => [
				'trips' => [
					'_id' => new MongoDB\BSON\ObjectID(),
					'geolocation' => $this->Geolocation,
					'experiences' => $this->Experiences,
				]
			]
		],[
				'returnNewDocument' => true
			]
		);
		return $InsertResult;
	}

	public function GetTripsByUserId($UserId){
		$Query = [
			'_id' => new MongoDB\BSON\ObjectID($UserId)
		];
		$Projection = [
			'projection' => ['trips' => 1]
		];
		$QueryResult = $this->Collection->find($Query, $Projection);
		return $QueryResult->toArray();
	}

	public function AddExperienceToTrip($TripId, $ExperienceId){

		$Query = [
			'trips._id' => new MongoDB\BSON\ObjectID($TripId)
		];
		$Update = [
			'$push' => [
			'trips.$.experiences' => [
				'_id' => new MongoDB\BSON\ObjectID($ExperienceId)
			]
			]
		];

		$InsertResult = $this->Collection->findOneAndUpdate($Query,$Update);
		return $InsertResult;

	}

}