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

        $InsertResult = $this->Collection->findOneAndUpdate([
			'experiences' => [
                '_id' => new MongoDB\BSON\ObjectID($PostId)
                ]
		],[
			'$push' => [
				'comments' => [
					'_id' => new MongoDB\BSON\ObjectID(),
					'comment' => $CommentText,
                    'user' => $UserId
				]
			]
		]);

        return $InsertResult;

    }

}
