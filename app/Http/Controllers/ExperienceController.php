<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Validator;
use Image;

use App\Http\Controllers\LoginController as LoginController;
use Experience\Experience as Experience;

class ExperienceController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $LoginController;

    public function __construct() {
    	$this->LoginController = new LoginController();
    }

		public function CreateExperience( Request $request )
    {
	    $UserIsLoggedIn = $this->LoginController->validateLoginState();
	    if (!$UserIsLoggedIn){
		    return false;
	    }

	    // If the request comes from the TripController, adjust to different structure
	    $hasTripParameter = $request->input('trip');
	    if (isset($hasTripParameter)){
		    $Rating = $request->input('experience.recommended');
		    $Geolocation = $request->input('experience.geolocation');
		    $Description = $request->input('experience.description');
		    $Image = $request->input('experience.image');
	    }else{
		    $Rating = $request->input('recommended');
		    $Geolocation = $request->input('geolocation');
		    $Description = $request->input('description');
		    $Image = $request->input('image');
	    }

//	    $Image = $request->input('password');
	    $UserId = $_SESSION["user_id"];

        //Image validation
        if(!$Image){
            $Experience = new Experience();
    	    $Response = $Experience->createExperience($UserId, $Rating, $Geolocation, $Description);
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
                $img->fit(480, 234, function($constraint){
                    $constraint->upsize();
                });
                $img->save(public_path('img/').$fullFileName);

                $Experience = new Experience();
        	    $Response = $Experience->createExperience($UserId, $Rating, $Geolocation, $Description, $fullFileName);
            }
        }

	    return $Response;

    }
    public function GetExperiencesByUser( Request $request ) {
	    $UserIsLoggedIn = $this->LoginController->validateLoginState();
	    if (!$UserIsLoggedIn){
	    	return false;
	    }
	    $UserId = $request->input('userId');
	    $Experience = new Experience();
	    $Response = $Experience->GetExperiencesByUser($UserId);
	    return $Response;
    }

}
