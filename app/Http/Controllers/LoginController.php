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

	public $response =
		[
			'loggedIn' => false,
			'response' => ''
		];

	public function LoginUser( Request $request ) {

		$Email = $request->input('email');
		$Password = $request->input('password');

		if (session_status() == PHP_SESSION_NONE) {
			session_start();
		}

		if (self::validateLoginState()){
			$this->response['loggedIn'] = true;
			$this->response['response'] = "You're already logged in";
			return $this->response;
		}

		$user = new AnaxiUser\User();
		$LoginSuccessful = $user->LoginUser($Email, $Password);;
		if ($LoginSuccessful){
			$_SESSION["logged_in"] = true;
			$_SESSION["user_id"] = $LoginSuccessful->_id;
			$this->response['loggedIn'] = true;
			$this->response['response'] = "Logged in";
		}else{
			$this->response['loggedIn'] = false;
			$this->response['response'] = "No luck";
		}
		return $this->response;
	}

	public function LogoutUser(){
		if (session_status() == PHP_SESSION_NONE) {
			session_start();
		}
		if (self::validateLoginState()){
			session_destroy();
			$this->response['loggedIn'] = false;
			$this->response['response'] = "You've been logged out";
		}else{
			$this->response['loggedIn'] = true;
			$this->response['response'] = "You are already logged out";
		}
		return $this->response;
	}

	public static function validateLoginState() {
		if (session_status() == PHP_SESSION_NONE) {
			session_start();
		}
		if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == true) {
			session_regenerate_id(true);
			// User is logged in
			return true;
		} else {
			// User is not logged in
			return false;
		}
	}



}