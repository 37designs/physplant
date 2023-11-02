<?php

namespace App\Http\Controllers;

use App\Http\Requests\PatchRequestRequest;
use App\Http\Requests\PostRequestRequest;
use App\Mail\RequestAcceptedMaterials;
use App\Mail\RequestAcceptedTech;
use App\Part;
use App\Permission\Permissions;
use App\Request;
use App\Technician;
use App\User;
use App\Vendor;
use Auth;
use Carbon\Carbon;

class RequestController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
		$this->middleware('permission:' . Permissions::P_Shop_Request);
	}

	public function index()
	{
		$shop = Auth::user()->shop;

		if ($shop === null)
		{
			return redirect('settings')->with("notification", "danger|You need to set your shop before you can see any requests.");
		}

		$allShopTechIDs = Technician::all()->where('shop_id', $shop->id)->pluck('id');

		$unapprovedShopRequests = array();

		if ($allShopTechIDs !== null)
		{
			$unapprovedShopRequests = Request::whereIn('technician_id', $allShopTechIDs)->whereIn('id', function ($query) {
				$query->select('request_id')
						->from(with(new Part())->getTable())
						->where('approval_status_id', 1)
						->where('received_status_id', 1);
			})->get();
		}

		return view('requests.index', [
				'shopname' => $shop->name,
				'unapprovedShopRequests' => $unapprovedShopRequests
		]);
	}

	public function show($id)
	{
		$request = Request::all()->find($id);

		if ($request === null)
		{
			return view('requests.show', ['noRequest' => 'true', 'partNum' => $id]);
		}

		return view('requests.show', [
				'partNum' => $id,
				'partrequest' => $request,
				'comments' => $request->comments()->latest()->get()
		]);
	}

	public function patch($id, PatchRequestRequest $request)
	{
		$req = Request::all()->find($id)->first();
		$reqfirst = Request::all()->find($id);

		if ($req === null)
		{
			return redirect('requests');
		}
		
		foreach ($reqfirst->parts as $inputPart)
		{	
			
			
			//$part = Part::all()->find($inputPart->part_number);
			echo $inputPart;
			$part=$inputPart;
			if ($part === null)
			{
				return redirect('requests');
			}

			if (isset($inputPart->expedite))
			{
				$part->expedite = 1;
			}
			
			$part->final_quantity = $inputPart->final_quantity;
			
			$part->vendor()->associate(Vendor::getVendorByName($inputPart->vendor_id));
			$part->observer()->associate(Auth::user());
			$part->approval_date = Carbon::now();
			$part->approval_date;
			$inputPart->approval_status_id;
			if ($inputPart->approval_status_id != 1)
			{
				$part->approval_status_id = 3;
			} else
			{
				$part->approval_status_id = 2;
			}


			$part->save();
		}

		$req->save();
		

		$this->emailStatusUpdate($req);

		return redirect('requests');
	}

	public function post(PostRequestRequest $request)
	{
		if ($request->get('req') === null)
		{
			return redirect('requests');
		}

		foreach ($request->get('req') as $req)
		{
			if (!isset($req['approve']))
			{
				continue;
			}

			if (!isset($req['requestid']))
			{
				continue;
			}

			$partrequest = Request::all()->find($req['requestid']);

			foreach ($partrequest->parts as $part)
			{
				if (isset($req['expedite']))
				{
					$part->expedite = 1;
				}

				$part->final_quantity = $part->request_quantity;
				$part->observer()->associate(Auth::user());
				$part->approval_status_id = 2;
				$part->approval_date = Carbon::now();
				$part->save();
			}
		}

		$partrequest->save();

		$this->emailStatusUpdate($partrequest);

		return redirect('requests');
	}

	private function emailStatusUpdate(Request $req)
	{
		echo "email test";
		if ($req->isAllPartsApproved())
		{
			$forepersons = User::whereRoleIs('material')->get();

			foreach ($forepersons as $foreperson)
			{
				\Mail::to($foreperson->email())->send(new RequestAcceptedMaterials($req));
			}

			\Mail::to($req->technician->email)->send(new RequestAcceptedTech($req->parts));
		}
	}
}