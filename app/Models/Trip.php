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

		$InsertResult = $this->Collection->findOneAndUpdate([
			'_id' => new MongoDB\BSON\ObjectID($UserId)
		],[
			'$push' => [
				'trips' => [
					'_id' => new MongoDB\BSON\ObjectID(),
					'geolocation' => $this->Geolocation,
					'experiences' => [ new MongoDB\BSON\ObjectID($ExperienceId) ]
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
			'trips.$.experiences' =>  new MongoDB\BSON\ObjectID($ExperienceId)
			]
		];

		$InsertResult = $this->Collection->findOneAndUpdate($Query,$Update);
		return $InsertResult;

	}

	public function GetTripsByUserFormatted($UserId){
		$Query = [
			'_id' => new MongoDB\BSON\ObjectID($UserId)
		];
		$Projection = [
			'projection' => ['trips' => 1]
		];
		$QueryResult = $this->Collection->find($Query, $Projection);
		$QueryResult = $QueryResult->toArray();
		if (isset($QueryResult) && array_key_exists('trips', $QueryResult[0])){
			return $QueryResult[0]->trips;
		}
		return false;
	}

	public function GetFollowingFeed(Array $UserIds){
		if (empty($UserIds)) { return false; }

		$Following = [];
		foreach ($UserIds as $id){
			$Following [] = new MongoDB\BSON\ObjectID($id);
		}

		$Query = [
			'_id' => ['$in' => $Following]
		];
		$Projection = [
			'projection' => [
				'trips' => 1,
				'experiences' => 1,
				'firstName' => 1,
				'lastName' => 1,
				'_id' => 1,
				'image' => 1
			]
		];

		$QueryResult = $this->Collection->find($Query, $Projection);
		$QueryResult = $QueryResult->toArray();
		if (isset($QueryResult)){
			return $QueryResult;
		}
		return false;
	}

}