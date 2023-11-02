<?php


namespace App\Http\Controllers;

use App\Permission\Permissions;
use App\Request;
use Carbon\Carbon;
use Log;
use Yajra\DataTables\Facades\DataTables;

class AllRequestController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
		$this->middleware('permission:' . Permissions::P_Access_All_Requests);
	}

	public function index()
	{
		return view('requests.all');
	}

	public function show($id)
	{
		$request = Request::all()->find($id);

		if ($request === null)
		{
			return view('requests.show', ['noRequest' => 'true', 'partNum' => $id]);
		}

		return view('requests.allshow', [
				'partNum' => $id,
				'partrequest' => $request,
				'comments' => $request->comments()->latest()->get()
		]);
	}

	public function allRequestData()
	{

		$request = Request::with([
				'parts' => function ($query) {
					$query->select('id', 'request_id', 'vendor_id', 'received_status_id'); /* 'vendor_id', */
				},
				'parts.receivedStatus' => function ($query) {
					$query->select('id', 'name');
				},
				'parts.vendor' => function ($query) {
					$query->select( 'id','name');	 
				},

				'technician' => function ($query) {
					$query->select('id', 'name', 'shop_id');
				},
				'technician.shop' => function ($query) {
					$query->select('id', 'name');
				}]);

		/** @var \App\Request $request */
		try
		{
			return Datatables::eloquent($request)
					->editColumn('id', function ($req) {
						return '<a href="' . \URL::route('allrequests') . '/' . $req->id . '">' . $req->id . '</a>';
					})
					->editColumn('created_at', function ($req) {
						return $req->created_at ? with(new Carbon($req->created_at))->format('m/d/Y') : '';
					})
					->addColumn('status', function ($req) {
						return $req->getRequestStatus();
					})
					->addColumn('status_color', function ($req) {
						return $req->getRequestColorStatus();
					})
					->filterColumn('requests.created_at', function ($query, $keyword) {
						$query->whereRaw("DATE_FORMAT(created_at,'%m/%d/%Y') like ?", ["%$keyword%"]);
					})
					->rawColumns(['id', 'confirmed'])
					->make(true);
		} catch (\Exception $e)
		{
			log::error($e);
			var_dump($e);
		}

	}
	
}