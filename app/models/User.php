<?php
namespace AnaxiUser;
use DatabaseConnection;
class User {
	public $ID;
	public $FirstName;
	public $LastName;
	public $Email;
	public $EmailAddressLookup;
	public $Password;
	public $Experiences = array();
	public $Travels = array();
	public $Following = array();
	public $Followers = array();
	public $Collection;

	public function __construct() {
		$Database = new DatabaseConnection\DatabaseConnection();
		$this->Collection = $Database->GetMongoInstance();
	}

	public function GetUsers($ID){

	}

	public function CreateUser($FirstName, $LastName, $Email, $Password) {
		// Below regexes are from stackoverflow and checked on https://regexr.com/
		if (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
			return "Bad email format";
		}
		$this->EmailAddressLookup = $this->CheckEmailAvailability($Email);
		if (!$this->EmailAddressLookup ){
			return "This email has already been taken ".$this->EmailAddressLookup;
		}
		if(!preg_match("/^[a-zA-Z-]+$/",$FirstName)) {
			return "Bad first name";
		}
		if(!preg_match("/^[a-zA-Z-]+$/",$LastName)) {
			return "Bad last name";
		}
		// TODO: Uncomment this one on before deployment
//		if(!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,12}$/', $Password)) {
//			return "Bad password";
//		}
		$this->Email = $Email;
		$this->FirstName = $FirstName;
		$this->LastName = $LastName;
		$this->Password = password_hash($Password, PASSWORD_DEFAULT);;

		$InsertResult = $this->Collection->insertOne([
			'firstName' => $this->FirstName ,
			'lastName' => $this->LastName,
			'email' => $this->Email,
			'emailLookup' => $this->EmailAddressLookup,
			'password' => $this->Password
		]);

		return $InsertResult->getInsertedId();
	}

	private function CheckEmailAvailability($Email){
		$EmailAddressLookup = $this->GetEmailHash($Email);
		// Find with limit is faster than findOne
		$LookupResult = $this->Collection->find(
			['emailLookup' => $EmailAddressLookup],
			[
				'limit' => 1
			]
		);

		if (!empty($LookupResult->toArray())) {
			return false;
		}
		return $EmailAddressLookup;
	}
	public function LoginUser($Email, $Password){

		$HashedPassword = password_hash($Password, PASSWORD_DEFAULT);;

		$LookupResult = $this->Collection->find(
			['emailLookup' => $this->GetEmailHash($Email)],
			[
				'limit' => 1
			],
			[
				'password' => 1
			]
		);

	}

	private function GetEmailHash($Email){
		//TODO Store keys and hashes
		//$EmailAddressLookupKey = self::$config["keys"]["email_address_lookup_key"];
		$EmailAddressLookupKey = "EmailKey";
		return $EmailAddressLookup = hash_hmac("sha256", $Email, $EmailAddressLookupKey);
	}
}