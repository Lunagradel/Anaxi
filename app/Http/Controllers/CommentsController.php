<?php

namespace App\Http\Controllers;

// use Faker\Provider\DateTime;
use Illuminate\Http\Request;
// use Illuminate\Foundation\Bus\DispatchesJobs;
// use Illuminate\Foundation\Validation\ValidatesRequests;
// use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use App\Http\Controllers\LoginController as LoginController;
// use Experience\Experience as Experience;
use Comment\Comment as Comment;

class CommentsController
{
    public $LoginController;

    public function __construct() {
    	$this->LoginController = new LoginController();
    }

    public function AddComment( Request $request )
    {
        $UserIsLoggedIn = $this->LoginController->validateLoginState();
	    if (!$UserIsLoggedIn){
		    return false;
	    }

        $UserId = $_SESSION["user_id"];
        $CommentInput = $request->input('comment');
        $PostId = $request->input('postId');
        $UserName = $request->input('userName');

        $Comment = new Comment();
        $Response = $Comment->addComment($UserId, $CommentInput, $PostId, $UserName);

        return $Response;

    }

    public function getComments( Request $request )
    {
        $PostId = $request->input('postId');

        $Comment = new Comment();
        $Response = $Comment->getComments($PostId);

        dd($Response );

        return $Response;
    }
}
