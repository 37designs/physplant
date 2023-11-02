<?php

namespace App\Http\Controllers;

use App\Http\Requests\TechStoreRequest;
use App\Mail\ShopChange;
use App\Permission\Permissions;
use App\Shop;
use App\Technician;

class TechController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
		$this->middleware('permission:' . Permissions::P_Access_Techs);
	}

	public function index()
	{
		$techs = Technician::all();
		$shops = Shop::all();

		return view('techs.index', compact('techs', 'shops'));
	}

	public function store(TechStoreRequest $request)
	{
		$name = $request->name;
		$shop = Shop::where('name', $request->shop)->first();

		if (($tech = Technician::where('name', $name)->first()) === null)
		{
			$tech = Technician::create(['name' => $name, 'shop_id' => $shop->id, 'email' => $request->email, 'active' => 1]);
		}

		$tech->shop_id = $shop->id;
		$tech->save();

		\Mail::to($tech->email)->send(new ShopChange($shop->name));

		return redirect('/techs')
				->with("notification",
						"success|Tech $name has been assigned to $shop->name");
	}

	public function update(Technician $tech)
	{
		if (!empty(request('shop')))
		{
			$shop = Shop::where('name', request('shop'))->first();

			\Mail::to($tech->email)->send(new ShopChange($shop->name));
			$tech->shop_id = $shop->id;
			$tech->save();
		}

		return redirect('/techs')->with("notification", "success|Shop updated for " . $tech->name);
	}
}
