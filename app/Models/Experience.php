<?php
/**
 * Created by PhpStorm.
 * User: Johannes
 * Date: 15/12/2017
 * Time: 12.47
 */

namespace Experience;
use DatabaseConnection;
use MongoDB;
class Experience {

	public $Rating;
	public $Geolocation = [];
	public $Description;
	public $Image;
	public $Comments = [];
	public $DatePosted;
	// DB
	public $Collection;

	public function __construct() {
		$Database = new DatabaseConnection\DatabaseConnection();
		$this->Collection = $Database->GetMongoInstance();
	}
	public function createExperience( $UserId, $Rating, $Geolocation, $Description = '', $Image = false ) {
		// Assign variables to class
		$this->Rating = $Rating;
		$this->Geolocation = $Geolocation;
		$this->Description = $Description;
		$this->$Image = $Image;

		$experienceID = new MongoDB\BSON\ObjectID();

		$InsertResult = $this->Collection->findOneAndUpdate([
			'_id' => new MongoDB\BSON\ObjectID($UserId)
		],[
			'$push' => [
				'experiences' => [
					'_id' => $experienceID,
					'geolocation' => $Geolocation,
					'description' => $Description,
					'image' => $Image,
					'recommended' => $Rating,
				]
			]
		],[
			'returnNewDocument' => true
			]
			);

		return $experienceID;
		//					"created" => new MongoDB\BSON\UTCDateTime()
	}

	public function GetExperiencesByUser($UserId){
		$Query = [
			'_id' => new MongoDB\BSON\ObjectID($UserId)
		];
		$Projection = [
			'projection' => ['password' => 0]
		];
		$Experiences = $this->Collection->find($Query, $Projection);

		return $Experiences->toArray();
	}
	public function GetExperiencesById($ExperienceId){
		$Query = [
			'experiences' => [
				'_id' => new MongoDB\BSON\ObjectID($ExperienceId)
			]
		];
		$Experience = $this->Collection->findOne($Query);
		return $Experience->toArray();
	}
	public function GetExperiencesByMultipleUsers(Array $UserIds){}

	// Get experiences based on One user
	// Get Experiences based on several users
	// Get Experience based on experience ID

}
