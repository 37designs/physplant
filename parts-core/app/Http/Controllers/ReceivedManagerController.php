<?php

namespace App\Http\Controllers;


use App\Http\Requests\ReceivedManagerRequest;
use App\Part;
use App\Permission\Permissions;
use App\Request;

class ReceivedManagerController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
		$this->middleware('permission:' . Permissions::P_Access_Received_Manager);
	}

	public function index()
	{
		$inStockRequests = Request::whereIn('id', function ($query) {
			$query->select('request_id')
					->from(with(new Part())->getTable())
					->where('approval_status_id', '!=', 1)
					->where('received_status_id', '!=', 1)
					->where('received_status_id', '!=', 2)
					->where('received_status_id', '!=', 5)
					->where('received_status_id', '!=', 6)
					->where('received_status_id', '!=', 7);
		})->get();

		return view('receivedManager.index', [
				'inStockRequests' => $inStockRequests
		]);
	}

	public function show($id)
	{
		$request = Request::find($id);

		if ($request === null)
		{
			return view('requests.show', ['noRequest' => 'true', 'partNum' => $id]);
		}

		return view('receivedManager.show', [
				'partNum' => $id,
				'partrequest' => $request,
				'comments' => $request->comments()->latest()->get()
		]);
	}

	public function patch($id, ReceivedManagerRequest $request)
	{
		$req = Request::find($id);

		if ($req === null)
		{
			return redirect('receivedmanager');
		}

		foreach ($request->get('part') as $inputPart)
		{
			$part = Part::find($inputPart['partid']);

			if ($part === null)
			{
				return redirect('receivedmanager');
			}

			if (array_key_exists('selected', $inputPart))
			{
				$part->received_key = $inputPart['key'];
			} else
				continue;


			$part->save();
		}

		$req->save();

		return redirect('receivedmanager');
	}
}
