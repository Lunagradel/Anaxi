<?php
namespace AnaxiUser;
use DatabaseConnection;
use MongoDB;
class User {
	public $ID;
	public $FirstName;
	public $LastName;
	public $Description;
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

	public function GetUserById($ID){
		$this->ID = $ID;

		$Query = [
			'_id' => new MongoDB\BSON\ObjectID($this->ID)
		];
		$Options =  [
			'limit' => 1,
			'projection' => ['firstName' => 1, 'lastName' => 1]
		];
		$result = $this->Collection->find($Query,$Options)->toArray();
		return $result;
	}

	public function CreateUser($FirstName, $LastName, $Email, $Password) {
		// Below regexes are from stackoverflow and checked on https://regexr.com/
		$Email = strtolower($Email);

		if (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
			return "Bad email format";
		}
		$this->EmailAddressLookup = $this->GetEmailHash($Email);

		if ( !empty($this->FindUserByEmail($Email)) ){
			return "This email has already been taken";
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

	private function FindUserByEmail($Email){
		$Email = strtolower($Email);
		$EmailAddressLookup = $this->GetEmailHash($Email);
		// find() with limit is faster than findOne()
		$LookupResult = $this->Collection->find(
			['emailLookup' => $EmailAddressLookup],
			[
				'limit' => 1
			]
		)->toArray();

//		dd($LookupResult, $Email);

		if (empty($LookupResult)){
			return false;
		}
		return $LookupResult;
	}

	private function GetEmailHash($Email){
		//TODO Store keys and hashes
		//$EmailAddressLookupKey = self::$config["keys"]["email_address_lookup_key"];
		$EmailAddressLookupKey = "EmailKey";
		return $EmailAddressLookup = hash_hmac("sha256", $Email, $EmailAddressLookupKey);
	}

	public function LoginUser($Email, $Password){

		$UserFromCollection = $this->FindUserByEmail($Email);
		if (!$UserFromCollection){
			return false;
		}
		$UsersHashedPassword = $UserFromCollection[0]->password;
		if (!password_verify($Password, $UsersHashedPassword)){
			return false;
		}
		// On success,
		return $UserFromCollection[0];

	}

	public function editUser($UserId, $FirstName, $LastName, $Description)
	{

		$this->FirstName = $FirstName;
		$this->LastName = $LastName;
		$this->Description = $Description;

		$UpdateResult = $this->Collection->FindOneAndUpdate([
			'_id' => new MongoDB\BSON\ObjectID($UserId)
			],[
				'$set' => [
					'firstName' => $FirstName,
					'lastName' => $LastName,
					'description' => $Description
				]
			],[
				'returnOriginal' => false
			]
		);

		return $UpdateResult;

	}
}
