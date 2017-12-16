<?php
/**
 * Created by PhpStorm.
 * User: Johannes
 * Date: 15/12/2017
 * Time: 12.47
 */

namespace Experience;
use DatabaseConnection;

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
	public function createExperience( $UserId, $Rating, $Geolocation, $Description, $Image ) {
		// Assign variables to class
		// Get User inserting
		// Validate Session
		// Insert experience
	}

	// Get experiences based on One user
	// Get Experiences based on several users

}