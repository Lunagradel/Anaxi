<?php

namespace Follow;
use DatabaseConnection;
use MongoDB;
class Follow {

	public $UserToFollow;
	public $UserToFollowName;
	public $LoggedInName;
    public $UserToUnfollow;
    public $UserToUnfollowName;
	public $LoggedInUser;
	// DB
	public $Collection;

	public function __construct() {
		$Database = new DatabaseConnection\DatabaseConnection();
		$this->Collection = $Database->GetMongoInstance();
	}

    public function FollowUser($LoggedInUser, $UserToFollow, $UserToFollowName, $LoggedInName)
    {
        $this->UserToFollow = $UserToFollow;
        $this->$LoggedInUser = $LoggedInUser;
        $this->$UserToFollowName = $UserToFollowName;
        $this->$LoggedInName = $LoggedInName;

        $this->Collection->findOneAndUpdate([
			'_id' => new MongoDB\BSON\ObjectID($LoggedInUser)
		],[
			'$push' => [
				'following' => [
					'_id' => $UserToFollow,
					'name' => $UserToFollowName
				]
			]
		]
		);

        $this->Collection->findOneAndUpdate([
			'_id' => new MongoDB\BSON\ObjectID($UserToFollow)
		],[
			'$push' => [
				'followers' => [
					'_id' => $LoggedInUser,
					'name' => $LoggedInName
					]
			]
		]
		);

        return "true";

    }

    public function UnfollowUser($LoggedInUser, $UserToUnfollow, $UserToUnfollowName, $LoggedInName)
    {
        $this->$UserToUnfollow = $UserToUnfollow;
        $this->$LoggedInUser = $LoggedInUser;
		$this->$UserToUnfollowName = $UserToUnfollowName;
		$this->$LoggedInName = $LoggedInName;

        // $this->Collection->findOneAndUpdate([
		// 	'_id' => new MongoDB\BSON\ObjectID($LoggedInUser)
		// ],[
		// 	'$pull' => [
		// 		'following' => [
		// 			'_id' => $UserToUnFollow
		// 		]
		// 	]
		// ]
		// );
        //
        // $this->Collection->findOneAndUpdate([
		// 	'_id' => new MongoDB\BSON\ObjectID($UserToUnfollow)
		// ],[
		// 	'$pull' => [
		// 		'followers' => [
		// 			'_id' => $LoggedInUser
		// 			]
		// 	]
		// ]
		// );

        return "true";
    }



}
