<?php
/**
 * Created by PhpStorm.
 * User: Johannes
 * Date: 15/12/2017
 * Time: 12.47
 */

namespace Experience;
use DatabaseConnection;
//use MongoId;
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
		if (!empty($Description)){
			$this->Description = $Description;
		}
		// Get User inserting
		// Validate Session
		// Insert experience
		//db.users.update({ _id: ObjectId("5a34f1b9eefa847b3f3b1f12")},{$push:{Experiences:{"gelocation":"theworld", "description":"Yolo", "imageId":123, "recommends":false}}})
		$InsertResult = $this->Collection->findOneAndUpdate([
			'_id' => new MongoDB\BSON\ObjectID($UserId)
		],[
			'$push' => [
				'Experiences' => [
					'geolocation' => [
						'lat' => 123,
						'lng' => 123,
						'location' => "A place",
					],
					'description' => 'I wuz here!',
					'imageId' => 2,
					'recommended' => true,
				]
			]
		]);
		dd($InsertResult);

		return $InsertResult;
	}


	// Get experiences based on One user
	// Get Experiences based on several users
	// Get Experience based on experience ID

}