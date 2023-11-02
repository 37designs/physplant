<?php

namespace Tests\Unit;

use App\Permission\Permissions;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Helpers\LoginUser;
use Tests\TestCase;

class GetLoginUserIDTest extends TestCase
{
	use DatabaseMigrations;

	/** TEST */
	public function testGetNewUser()
	{
		$user = LoginUser::GetNewUser();
		$this->assertTrue($user->hasRole(Permissions::R_New));
	}

	/** TEST */
	public function testGetAdminUser()
	{
		$user = LoginUser::GetAdminUser();
		$this->assertTrue($user->hasRole(Permissions::R_Admin));
	}

	/** TEST */
	public function testGetMaterialsUser()
	{
		$user = LoginUser::GetMaterialsUser();
		$this->assertTrue($user->hasRole(Permissions::R_Material));
	}

	/** TEST */
	public function testGetForepersonUser()
	{
		$user = LoginUser::GetForepersonUser();
		$this->assertTrue($user->hasRole(Permissions::R_Foreperson));
	}
}
