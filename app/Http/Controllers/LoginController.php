<?php
/**
 * Created by PhpStorm.
 * User: Johannes
 * Date: 14/12/2017
 * Time: 13.30
 */

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class LoginController extends controller{

	public function authenticate()
	{
		if (Auth::attempt(['email' => $email, 'password' => $password])) {
			// Authentication passed...
			return redirect()->intended('dashboard');
		}
	}
}