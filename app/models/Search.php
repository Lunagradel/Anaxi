<?php

namespace Search;
use DatabaseConnection;
use MongoDB;
class Search {

	public $SearchValue;
	// DB
	public $Collection;

	public function __construct() {
		$Database = new DatabaseConnection\DatabaseConnection();
		$this->Collection = $Database->GetMongoInstance();
	}

    public function getSearchResult( $SearchValue )
    {
        $this->SearchValue = $SearchValue;

        // $SearchResult = $this->Collection->find([
        //     ['$text' => ['$search' => $SearchValue]],
        //     ['score' => ['$meta' => 'textScore']]
        // ])->sort(['score' => ['$meta' => 'textScore']]);

        $SearchResult = $this->Collection->find([
            '$text' => ['$search' => $SearchValue]
        ],[
            '$score' => ['$meta' => 'textScore']
        ],
        [
            'sort' => ['score' => ['$meta' => 'textScore']]
        ]
        )->toArray();

        return $SearchResult;
    }

    public function addComment( $UserId, $CommentText, $PostId, $UserName ) {

        $this->CommentText = $CommentText;

        $InsertResult = $this->Collection->findOneAndUpdate([
			'experiences._id' => new MongoDB\BSON\ObjectID($PostId)
		],[
			'$push' => [
				'experiences.$.comments' => [
					'_id' => new MongoDB\BSON\ObjectID(),
					'comment' => $CommentText,
                    'user' => $UserId,
                    'userName' => $UserName
				]
			]
		]);

        return $InsertResult;

    }



}
