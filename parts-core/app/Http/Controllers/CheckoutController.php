<?php

namespace App\Http\Controllers;


use App\Http\Requests\CheckoutAjaxIDRequest;
use App\Http\Requests\CheckoutAjaxRequest;
use App\Http\Requests\CheckoutPostRequest;
use App\Http\Requests\NoLastingLoginRequest;
use App\Part;
use App\Request;
use App\User;
use EMUPhysPlant\LDAP\Authenticator;

class CheckoutController extends Controller
{
	public function __construct()
	{
		$this->middleware('guest')->only('create');
	}

	public function index()
	{
		return view('checkout.index');
	}

	public function noLastingLogin(NoLastingLoginRequest $request)
	{
		$username = cleanUsername($request->eid);
		$password = $request->password;

		$ldap = new Authenticator();
		if (!$ldap->authenticate($username, $password))
			return redirect('/checkout')->withErrors(['message' => "The Emich Username/Password credentials you entered are invalid. Please try the first time setup process again."]);

		// Get EID and name from LDAP
		$userInfo = $ldap->getAttributes(['eid', 'fullname']);

		/** @var \App\User $user */
		$user = User::where('username', $username)->first();

		($user === null)
				? User::create($username, $userInfo['fullname'], $userInfo['eid'])
				: $user->updateInfo($userInfo['fullname'], $userInfo['eid']);

		if ($user === null)
			return redirect('/checkout')->with("notification", "success|First time setup completed successfully!");
		else
			return redirect('/checkout')->with("notification", "warning|You already did the first time setup process!");
	}


	public function post(CheckoutPostRequest $request)
	{
		$eid = $request->eid;
		$reqnum = $request->partnum;
		$partkey = $request->partkey;

		$req = Request::all()->find($reqnum);

		if ($req === null)
			return redirect('/checkout')->withErrors(['message' => "Invalid request number."]);

		if ($partkey === null)
			return redirect('/checkout')->withErrors(['message' => "You need the key."]);

		/** @var \App\User $user */
		$user = User::where('eid', "E0" . $eid)->first();

		$sigcount = 0;

		/** @var \App\Part $parts */
		foreach ($req->parts as $parts)
		{
			if ($parts->received_key === null || $parts->received_key != $partkey)
				continue;

			$parts->user_signature = $user->id;
			$parts->received_status_id = 7;
			$parts->save();
			$sigcount++;
		}

		if ($sigcount < 1)
			return redirect('/checkout')->withErrors(['message' => "Invalid key. No parts have that key."]);

		$req->save();
		return redirect('checkout')->with("notification", "success|Processed! You are ready to go!");
	}

	public function packageInfo(CheckoutAjaxRequest $request)
	{
		$reqnum = request()->partnum;
		$partkey = request()->partkey;

		/** @var \App\Request $req */
		$parts = Part::where('request_id', $reqnum)->where('received_key', $partkey);

		if ($parts === null)
		{
			return response()->json(['err' => 'No parts by that detail']);
		}

		return response()->json($parts->get());
	}

	public function eidInfo(CheckoutAjaxIDRequest $request)
	{
		$eid = $request->eid;

		$eid = "E0" . $eid;

		$test = User::where('eid', $eid);

		if ($test === null)
		{
			return response()->json(['err' => 'No eid']);
		}

		return response()->json($test->get());
	}
}
