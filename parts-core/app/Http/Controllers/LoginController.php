<?php

namespace App\Http\Controllers;

error_reporting(E_ALL);
ini_set('display_errors', 1);

use App\User;
use EMUPhysPlant\LDAP\Authenticator;

class LoginController extends Controller
{

	public function __construct()
	{
		$this->middleware('guest')->only('create');
	}

	public function create()
	{
		return view('auth.login');
	}

	/**
	 * Handle an authentication attempt.
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function authenticate()
	{
		$username = cleanUsername(request()->username);
		$password = request()->password;

		$ldap = new Authenticator();
		if (!$ldap->authenticate($username, $password))
		{
			return redirect('/login')->withErrors(['message' => "The credentials you entered are invalid. Please try again."]);
		}

		// Get EID and name from LDAP
		$userInfo = $ldap->getAttributes(['eid', 'fullname']);

		/** @var \App\User $user */
		$user = User::where('username', $username)->first();

		$user = ($user === null)
				? User::create($username, $userInfo['fullname'], $userInfo['eid'])
				: $user->updateInfo($userInfo['fullname'], $userInfo['eid']);

		auth()->login($user, request()->has('remember'));

		return redirect()->home();
	}

	/**
	 * Logout the currently authenticated user and redirect to login
	 *
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function logout()
	{
		auth()->logout();

		return redirect('/login');
	}
}
