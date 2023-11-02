<?php

namespace App\Http\Controllers;


use App\Http\Requests\MaterialRequest;
use App\Mail\MaterialsUpdate;
use App\Part;
use App\Permission\Permissions;
use App\Request;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;

class MaterialController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
		$this->middleware('permission:' . Permissions::P_Material_Request);
	}

	public function index()
	{
		return view('materials.index');
	}

	public function show($id)
	{
		$request = Request::all()->find($id);

		if ($request === null)
		{
			return view('requests.show', ['noRequest' => 'true', 'partNum' => $id]);
		}

		return view('materials.show', [
				'partNum' => $id,
				'partrequest' => $request,
				'comments' => $request->comments()->latest()->get()
		]);
	}

	public function patch($id, MaterialRequest $request)
	{
		$req = Request::find($id);

		if ($req === null)
		{
			return redirect('materials');
		}

		$oldPartStatus = $req->getPartsOrderStatus();

		foreach ($request->get('part') as $inputPart)
		{
			$part = Part::find($inputPart['part_num']);

			if ($part === null)
			{
				return redirect('material');
			}

			switch ($inputPart['status'])
			{
				case 1:
					// Not ordered
					$part->received_status_id = 1;
					break;
				case 2:
					// Ordered
					$part->received_status_id = 2;
					$part->ordered_date = Carbon::now();

					$time = strtotime($inputPart['eta']);
					$newformat = date('Y-m-d', $time);

					$part->eta = $newformat;
					break;
				case 3:
					// Received
					$part->received_status_id = 3;
					$part->received_date = Carbon::now();
					break;
				case 4:
					// Partially received
					$part->received_status_id = 4;
					$part->ordered_date = Carbon::now();
					break;
				case 5:
					// Returned
					$part->received_status_id = 5;
					$part->returned_date = Carbon::now();
					break;
				case 6:
					// Rejected
					$part->received_status_id = 6;
					$part->completed_date = Carbon::now();
					break;
				case 7:
					// Completed
					$part->received_status_id = 7;
					$part->completed_date = Carbon::now();
					break;
				default:
					return redirect('materials');
					break;
			}

			$part->save();
		}
		$req->save();

		$newPartStatus = $req->getPartsOrderStatus();

		if ($this->hasOrderStatusChange($oldPartStatus, $newPartStatus))
		{
			$this->emailStatusUpdate($req);
		}

		return redirect('materials');
	}

	private function hasOrderStatusChange($oldstatus, $newstatus)
	{
		return $oldstatus !== $newstatus;
	}

	private function emailStatusUpdate(Request $req)
	{
		\Mail::to($req->technician->email)->send(new MaterialsUpdate($req->parts));
	}

	public function materialsData()
	{
		$request = Request::whereIn('id', function ($query) {
			$query->select('request_id')
					->from(with(new Part())->getTable())
					->where('approval_status_id', '!=', 0)
					->where('approval_status_id', '!=', 1)
					->where('received_status_id', '!=', 7)
					->where('received_status_id', '!=', 6);
		});
		
		return Datatables::eloquent($request)
				->editColumn('id', function ($req) {
					return '<a href="' . \URL::route('materials') . '/' . $req->id . '">' . $req->id . '</a>';
				})
				->editColumn('date', function ($req) {
					return (new Carbon($req->created_at))->setTimezone('America/Detroit')->format('m/d/Y g:ia');
				})
				->addColumn('tech_name', function ($req) {
					return $req->technician->name;
				})
				->addColumn('tech_trade', function ($req) {
					return $req->scopeShop()->name;
				})
				->addColumn('vendors', function ($req) {
					$parts = $req->parts;

					if ($parts === null)
						return "";

					$vendorList = array();
  
					foreach ($parts as $part)
					{
						$vendorName = $part->vendor->name;

						if (!in_array($vendorName, $vendorList))
							$vendorList[] = $vendorName;
					}

					return implode(', ', $vendorList);
				})
                                ->addColumn('status', function ($req) {
					return $req->getRequestStatus();
				})
				->addColumn('status_color', function ($req) {
					return $req->getRequestColorStatus();
				})
				->rawColumns(['id'])
				->toJson();
	}
}
