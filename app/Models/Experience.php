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

	// Get Experiences based on several users
	public function GetExperiencesByUserFormatted($UserId){
		$Query = [
			'_id' => new MongoDB\BSON\ObjectID($UserId)
		];
		$Projection = [
			'projection' => ['password' => 0]
		];

		$Result = $this->Collection->find($Query, $Projection);
		$Result  = $Result->toArray();
		// Check if result
		if (isset($Result[0]) && array_key_exists('experiences', $Result[0]))
		{
			// Turn experience BSON into array so it can be filtered.
			$Experiences = iterator_to_array($Result[0]->experiences);
			$Image = array_key_exists('image', $Result[0]) ? $Result[0]->image : 'default.jpg';
			$Owner = ["firstName" => $Result[0]->firstName, "lastName" => $Result[0]->lastName, "id" => $Result[0]->_id, "image" => $Image];
			$Response = ['owner' => $Owner, 'experiences' => $Experiences];
			return $Response;
		} else {
			// If user has nothing.
			return false;
		}

	}

}
