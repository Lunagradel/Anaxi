<?php
/**
 * Created by PhpStorm.
 * User: Johannes
 * Date: 19/12/2017
 * Time: 14.10
 */

namespace App\Http\Controllers;

use App\Http\Controllers\LoginController as LoginController;
use Illuminate\Http\Request;

class TripController {

	public $LoginController;

	public function __construct() {
		$this->LoginController = new LoginController();
	}

	public function CreateTrip(Request $request){
		$UserIsLoggedIn = $this->LoginController->validateLoginState();
		if (!$UserIsLoggedIn){
			return false;
		}

		
		dd($request);
	}
}