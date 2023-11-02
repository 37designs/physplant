<?php

namespace App\Http\Controllers;

use App\Exceptions\AccessDeniedException;
use App\Mail\PermissionChange;
use App\Permission\Permissions;
use App\Role;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
		$this->middleware('permission:' . Permissions::P_Access_User_Permissions);
	}

	public function index()
	{
		$users = User::all();
		$roles = Role::all();

		return view('users.index', compact('users', 'roles'));
	}

	public function store(Request $request)
	{
		$username = $request->username;
		$role = Role::where('name', $request->role)->first();

		if (($user = User::where('username', $username)->first()) === null)
		{
			$user = User::create($username);
		}

		\Mail::to($user->email())->send(new PermissionChange($role->display_name));

		$user->attachRole($role);

		return redirect('/users')
				->with("notification",
						"success|User $username has been assigned $role->display_name ($role->description)");
	}

	public function update(User $user)
	{
		// Remove all permissions and roles to clean up
		$user->detachPermissions($user->permissions);
		$user->detachRoles($user->roles);

		// Attach new role and save
		if (!empty(request('role')))
		{
			$role = Role::where('name', request('role'))->first();

			\Mail::to($user->email())->send(new PermissionChange($role->display_name));
			$user->attachRole($role);
			$user->save();
		}

		return redirect('/users')->with("notification", "success|Permissions updated for " . $user->name);
	}
}
