<?php

namespace Follow;
use DatabaseConnection;
use MongoDB;
class Follow {

	public $UserToFollow;
    public $UserToUnfollow;
	public $LoggedInUser;
	// DB
	public $Collection;

	public function __construct() {
		$Database = new DatabaseConnection\DatabaseConnection();
		$this->Collection = $Database->GetMongoInstance();
	}

    public function FollowUser($LoggedInUser, $UserToFollow)
    {
        $this->UserToFollow = $UserToFollow;
        $this->$LoggedInUser = $LoggedInUser;

        $this->Collection->findOneAndUpdate([
			'_id' => new MongoDB\BSON\ObjectID($LoggedInUser)
		],[
			'$push' => [
				'following' => new MongoDB\BSON\ObjectID($UserToFollow)
			]
		]
		);

        $this->Collection->findOneAndUpdate([
			'_id' => new MongoDB\BSON\ObjectID($UserToFollow)
		],[
			'$push' => [
				'followers' => new MongoDB\BSON\ObjectID($LoggedInUser)
			]
		]
		);

        return "true";

    }

    public function UnfollowUser($LoggedInUser, $UserToUnfollow)
    {
        $this->$UserToUnfollow = $UserToUnfollow;
        $this->$LoggedInUser = $LoggedInUser;

        $this->Collection->findOneAndUpdate([
			'_id' => new MongoDB\BSON\ObjectID($LoggedInUser)
		],[
			'$pull' => [
				'following' => new MongoDB\BSON\ObjectID($UserToUnfollow)
			]
		]
		);

        $this->Collection->findOneAndUpdate([
			'_id' => new MongoDB\BSON\ObjectID($UserToUnfollow)
		],[
			'$pull' => [
				'followers' => new MongoDB\BSON\ObjectID($LoggedInUser)
			]
		]
		);

        return "true";
    }



}
