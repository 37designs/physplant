<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Http\Requests\PartsSubmitRequest;
use App\Mail\PartRequestSubmit;
use App\Mail\TechAssureSubmit;
use App\Part;
use App\Request;
use App\Request as orderReq;
use App\Technician;
use App\User;
use App\Vendor;
use URL;

class PartsRequestController extends Controller
{
	public function index()
	{
		return view('partsRequest.index', ['vendors' => Vendor::all(), 'technicians' => Technician::all()]);
	}

	public function store(PartsSubmitRequest $request)
	{
		$order = new orderReq();

		$tech = Technician::all()->where("id", $request->get('tech'))->first();

		$order->technician()->associate($tech);
		$order->work_order = $request->get('wo');

		$com = new Comment();
		$com->comment = $request->get('comments') ? $request->get('comments') : "*Didn't comment*";
		$com->commentable()->associate($tech);
		$order->save();

		$order->comments()->save($com);

		foreach ($request->get('parts') as $p)
		{
			$part = new Part();

			$part->vendor()->associate(Vendor::getVendorByName($p['vendor']));
			$part->received_status_id = 1;
			$part->approval_status_id = 1;

			$part->request_quantity = $p['quantity'];
			$part->part_number = $p['part_num'] ? $p['part_num'] : "N/A";
			$part->asked_for_expedite = $p['expedite'];
			$part->description = $p['description'] ? $p['description'] : "N/A";

			$order->parts()->save($part);
		}

		$order->save();

		$this->alertForepersons($tech, $order->id);
		$this->alertTech($order);

		return redirect('partsrequest')->with("notification", "success|Request submitted!");
	}


	private function alertForepersons($tech, $requestID)
	{
		$forepersons = User::whereRoleIs('material')->whereShopId($tech->shop->id)->get();

		$requestURL = URL::route('requests') . "/" . $requestID;

		foreach ($forepersons as $foreperson)
		{
			\Mail::to($foreperson->email())->send(new PartRequestSubmit($tech->name, $requestURL));
		}
	}

	private function alertTech(Request $request)
	{
		\Mail::to($request->technician->email)->send(new TechAssureSubmit($request));
	}
}