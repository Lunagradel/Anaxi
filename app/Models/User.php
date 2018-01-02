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
	public $ProfileImage;
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
			'projection' => ['firstName' => 1, 'lastName' => 1, 'image' => 1]
		];
		$result = $this->Collection->find($Query,$Options)->toArray();
		return $result;
	}

	public function CreateUser($FirstName, $LastName, $Email, $Password) {
		// Below regexes are from stackoverflow and checked on https://regexr.com/
		$Email = strtolower($Email);

		if (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
			return response()->json(['responseMessage'=>'Bad email format. Please try again'], 406);
		}
		$this->EmailAddressLookup = $this->GetEmailHash($Email);

		if ( !empty($this->FindUserByEmail($Email)) ){
			return response()->json(['responseMessage'=>'This email has already been taken'], 406);
		}
		if(!preg_match("/^[a-zA-Z-]+$/",$FirstName)) {
			return response()->json(['responseMessage'=>'Bad first name. No special characters'], 406);
		}
		if(!preg_match("/^[a-zA-Z-]+$/",$LastName)) {
			return response()->json(['responseMessage'=>'Bad last name'], 406);
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

		$newUserId = $InsertResult->getInsertedId();
		return response()->json(['responseMessage'=>'User created, thank you', 'newUserId' => $newUserId], 200);
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

		if (empty($LookupResult)){
			return false;
		}
		return $LookupResult;
	}

	private function GetEmailHash($Email){
		//TODO Store keys and hashes
		$EmailAddressLookupKey = $_ENV['EMAIL_LOOK_UP_KEY'];;
//		$EmailAddressLookupKey = "EmailKey";
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

	public function editUser($UserId, $Description, $ProfileImage)
	{
		$this->Description = $Description;
		$this->ProfileImage = $ProfileImage;

		$UpdateResult = $this->Collection->FindOneAndUpdate([
			'_id' => new MongoDB\BSON\ObjectID($UserId)
			],[
				'$set' => [
					'description' => $Description,
					'image' => $ProfileImage
				]
			],[
				'returnOriginal' => false
			]
		);

		return $UpdateResult;
	}
}
