<?php

namespace Tests\Helpers;

use App\Permission\Permissions;
use App\Technician;
use App\User;

class LoginUser
{
	/**
	 * @return User
	 */
	public static function GetNewUser()
	{
		$user = factory(User::class)->create();

		$user->attachRole(Permissions::R_New);
		$user->save();

		return $user;
	}

	/**
	 * @return Technician
	 */
	public static function GetTechnician()
	{
		$user = factory(Technician::class)->create();
		$user->save();

		return $user;
	}

	/**
	 * @return User
	 */
	public static function GetForepersonUser()
	{
		$user = factory(User::class)->create();

		$user->attachRole(Permissions::R_Foreperson);
		$user->save();

		return $user;
	}

	/**
	 * @return User
	 */
	public static function GetMaterialsUser()
	{
		$user = factory(User::class)->create();

		$user->attachRole(Permissions::R_Material);
		$user->save();

		return $user;
	}

	/**
	 * @return User
	 */
	public static function GetAdminUser()
	{
		$user = factory(User::class)->create();

		$user->attachRole(Permissions::R_Admin);
		$user->save();

		return $user;
	}

	/**
	 * @return array
	 */
	public static function GetAllUserTypes()
	{
		return array(self::GetNewUser(), self::GetForepersonUser(), self::GetMaterialsUser(), self::GetAdminUser());
	}
}