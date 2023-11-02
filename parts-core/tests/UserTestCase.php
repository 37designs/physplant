<?php

namespace Tests;

use Tests\Helpers\LoginUser;

abstract class UserTestCase extends TestCase
{
	/** @var \App\User $userNew */
	protected $userNew;
	/** @var \App\Technician $userTech */
	protected $userTech;
	/** @var \App\User $userForeperson */
	protected $userForeperson;
	/** @var \App\User $userMaterials */
	protected $userMaterials;
	/** @var \App\User $userAdmin */
	protected $userAdmin;

	protected function setUp()
	{
		parent::setUp();

		$this->userNew = LoginUser::GetNewUser();
		$this->userTech = LoginUser::GetTechnician();
		$this->userForeperson = LoginUser::GetForepersonUser();
		$this->userMaterials = LoginUser::GetMaterialsUser();
		$this->userAdmin = LoginUser::GetAdminUser();
	}

	abstract function testNewUser();

	public abstract function testTech();

	public abstract function testForeperson();

	public abstract function testMaterials();

	public abstract function testAdmin();
}
