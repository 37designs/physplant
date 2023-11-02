<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserSettingsRequest;
use App\Permission\Permissions;
use App\Shop;
use Auth;

class UserSettingsController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
		$this->middleware('permission:' . Permissions::P_Settings_Page);
	}

	public function index()
	{
		return view('settings.index', ['shops' => Shop::all(), 'currentShop' => Auth::user()->shop_id]);
	}

	public function store(UserSettingsRequest $request)
	{
		Auth::user()->hasPermission(Permissions::P_Change_Shop);
		$shopID = $request->get('shop');

		if (Shop::find($shopID) === null)
		{
			return redirect('settings')->with("notification", "danger|That shop is invalid.");
		}

		$user = Auth::user();
		$user->shop_id = $shopID;
		$user->save();

		return redirect('settings')->with("notification", "success|Your shop was updated to '" . $user->shop->name . "'");
	}
}
