<?php

namespace Comment;
use DatabaseConnection;
use MongoDB;
class Comment {

	public $CommentText;
	// DB
	public $Collection;

	public function __construct() {
		$Database = new DatabaseConnection\DatabaseConnection();
		$this->Collection = $Database->GetMongoInstance();
	}

    public function addComment( $UserId, $CommentText, $PostId ) {

        $this->CommentText = $CommentText;
        $Query = [
	        'experiences' => [
		        '_id' => new MongoDB\BSON\ObjectID($PostId)
	        ]
        ];
        $Comment = [
	        '$push' => [
		        'comments' => [
			        '_id' => new MongoDB\BSON\ObjectID(),
			        'comment' => $CommentText,
			        'user' => $UserId
		        ]
	        ]
        ];

        $InsertResult = $this->Collection->findOneAndUpdate($Query,$Comment);

        return $InsertResult;

    }

}
