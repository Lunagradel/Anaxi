<?php
/**
 * Created by PhpStorm.
 * User: Johannes
 * Date: 14/12/2017
 * Time: 13.30
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use AnaxiUser;

class LoginController extends controller{

	public function LoginUser( Request $request ) {

		$Email = $request->input('email');
		$Password = $request->input('password');

		if (session_status() == PHP_SESSION_NONE) {
			session_start();
		}

		if (self::validateLoginState()){
			return response()->json(['responseMessage'=>'You\'re already logged in'], 200);
		}

		$user = new AnaxiUser\User();
		$LoginSuccessful = $user->LoginUser($Email, $Password);;
		if ($LoginSuccessful){
			$_SESSION["logged_in"] = true;
			$_SESSION["user_id"] = $LoginSuccessful->_id;
			return response()->json(['responseMessage'=>'Logged in'], 200);
		}else{
			return response()->json(['responseMessage'=>'Password and email does not match'], 400);
		}
	}

	public function LogoutUser(){
		if (session_status() == PHP_SESSION_NONE) {
			session_start();
		}
		if (self::validateLoginState()){
			session_destroy();
		}
		$loggedIn = false;
		return view('welcome', compact('loggedIn'));
	}

	public static function validateLoginState() {
		if (session_status() == PHP_SESSION_NONE) {
			session_start();
		}
		if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == true) {
//			session_regenerate_id(true);
			return true;
		} else {
			return false;
		}
	}



}