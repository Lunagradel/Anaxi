<?php
namespace AnaxiUser;
/**
 * Created by PhpStorm.
 * User: Johannes
 * Date: 12/12/2017
 * Time: 09.20
 */
use DatabaseConnection;

class User {
	public $ID;
	public $FirstName;
	public $LastName;
	public $Email;
	public $Password;
	public $Experiences = array();
	public $Travels = array();
	public $Following = array();
	public $Followers = array();

//	public function __construct() {
//
//	}

	public function GetUsers(){
	}

	public function CreateUser($FirstName, $LastName, $Email, $Password) {

		if (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
			die ("Invalid email");
		}
		if(!preg_match("/^[a-zA-Z-]+$/",$FirstName)) {
			die ("Invalid first name");
		}
		if(!preg_match("/^[a-zA-Z-]+$/",$LastName)) {
			die ("Invalid last name");
		}
		if(!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,12}$/', $Password)) {
			die ("Invalid Password");
		}

		$this->Email = $Email;
		$this->FirstName = $FirstName;
		$this->LastName = $LastName;
		$this->Password = $Password;

		// Above regexes are from stackoverflow and checked on https://regexr.com/
		$Database = new DatabaseConnection\DatabaseConnection();
		$Collection = $Database->GetMongoInstance();

		$Collection->insertOne([
			'firstName' => $this->FirstName ,
			'lastName' => $this->LastName,
			'email' => $this->Email ,
			'password' => $this->Password
		]);
	}
}