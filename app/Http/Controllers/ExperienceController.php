<?php

namespace App\Http\Controllers;

use Faker\Provider\DateTime;
use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use DatabaseConnection;
Use App\Http\Controllers\UserController as UserController;
use AnaxiUser\User as User;
use MongoDB\Client as MongoClient;
use MongoDB\Collection as Collection;

class ExperienceController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function CreateExperience( Request $request )
    {

	    $Rating = $request->input('firstName');
	    $Geolocation = $request->input('lastName');
	    $Description = $request->input('email');
	    $Image = $request->input('password');

    }
    public function GetExperiences( Request $request ) {}
    public function UpdateExperience( Request $request ) {}
    public function DeleteExperience( Request $request ) {}
}
