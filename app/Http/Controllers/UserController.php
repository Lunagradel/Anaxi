<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Validator;
use Image;

use DatabaseConnection;
use AnaxiUser\User as User;
use MongoDB\Client as MongoClient;
use MongoDB\Collection as Collection;
use App\Http\Controllers\LoginController as LoginController;

class UserController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $LoginController;

    public function __construct() {
    	$this->LoginController = new LoginController();
    }

    public function GetUsers(){
	    $Database = new DatabaseConnection\DatabaseConnection();
	    $Collection = $Database->GetMongoInstance();
	    return $Collection->find()->toArray();
    }

    public function CreateUser( Request $request ) {
	    $FirstName = $request->input('firstName');
	    $LastName = $request->input('lastName');
	    $Email = $request->input('email');
	    $Password = $request->input('password');

	    $user = new User();
	    $response = $user->CreateUser($FirstName, $LastName, $Email, $Password);;
	    return $response;
    }

    public function GetUserById(Request $request){
	    $UserId = $request->input('userID');

	    $User = new User();
	    $result = $User->GetUserById($UserId);
	    return $result;
    }

    public function EditUser( Request $request )
    {
    	$UserIsLoggedIn = $this->LoginController->validateLoginState();
    	if (!$UserIsLoggedIn){
    		return false;
    	}
    	$UserId = $_SESSION["user_id"];
        $Description = $request->input('description');
        $Image = $request->input('image');
        $SameImage = $request->input('sameImage');

        if ($SameImage) {
            //lavet fordi der skal være mulighed for ikke at uploade billede.
            $User = new User();
            $Response = $User->editUser($UserId, $Description, $Image);
        } else {
            $validator = Validator::make($request->all(), [
                'image' => 'required|image64:jpeg,jpg,png'
            ]);
            if ($validator->fails()) {
                return response()->json(['errors'=>$validator->errors()]);
            } else {
                $fileName = md5($UserId . time());
                $extension = explode('/', explode(':', substr($Image, 0, strpos($Image, ';')))[1])[1];
                $fullFileName = $fileName . '.' . $extension;

                $img = Image::make($Image);
                $img->fit(191, 240, function($constraint){
                    $constraint->upsize();
                });
                $img->save(public_path('img/').$fullFileName);

                $User = new User();
                $Response = $User->editUser($UserId, $Description, $fullFileName);
                return $fullFileName;

            }
        }

        // $User = new User();
        // $Response = $User->editUser($UserId, $FirstName, $LastName, $Description);

        // return "true";
    }
}
