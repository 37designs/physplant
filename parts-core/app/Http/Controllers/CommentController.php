<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Http\Requests\CommentRequest;
use App\Request;
use Auth;

class CommentController extends Controller
{
	public function store($id, CommentRequest $request)
	{
		if (isset($id))
		{
			if (Request::all()->find($id) !== null)
			{
				$com = new Comment();
				$com->comment = $request->get('comment');
				$com->commentable()->associate(Auth::user());

				Request::all()->find($id)->comments()->save($com);
			}
		}
		return redirect()->back();
	}
}
