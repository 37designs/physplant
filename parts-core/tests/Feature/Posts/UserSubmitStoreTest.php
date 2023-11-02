<?php

namespace Tests\Feature;

use App\Role;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Helpers\LoginUser;
use Tests\UserTestCase;

class UserSubmitStoreTest extends UserTestCase
{
	use DatabaseMigrations;
	use CreateModels;

	public function setUp()
	{
		parent::setUp();
	}

	/** TEST */
	function testNewUser()
	{
		$user = LoginUser::GetForepersonUser();

		$this->actingAs($this->userNew)->patch('/users/' . $user->id, [
				'role' => Role::all()->get(1)->name,
		])->assertStatus(403);

		$this->assertDatabaseMissing("role_user", [
				'user_id' => $user->id,
				'role_id' => Role::all()->get(1)->id,
		]);
	}

	/** TEST */
	public function testTech()
	{
		$this->assertTrue(true);
	}

	/** TEST */
	public function testForeperson()
	{
		$user = LoginUser::GetForepersonUser();

		$this->actingAs($this->userForeperson)->patch('/users/' . $user->id, [
				'role' => Role::all()->get(1)->name,
		])->assertStatus(403);

		$this->assertDatabaseMissing("role_user", [
				'user_id' => $user->id,
				'role_id' => Role::all()->get(1)->id,
		]);
	}

	/** TEST */
	public function testMaterials()
	{
		$user = LoginUser::GetForepersonUser();

		$this->actingAs($this->userMaterials)->patch('/users/' . $user->id, [
				'role' => Role::all()->get(1)->name,
		])->assertStatus(403);

		$this->assertDatabaseMissing("role_user", [
				'user_id' => $user->id,
				'role_id' => Role::all()->get(1)->id,
		]);
	}

	/** TEST */
	public function testAdmin()
	{
		$user = LoginUser::GetForepersonUser();

		$this->actingAs($this->userAdmin)->patch('/users/' . $user->id, [
				'role' => Role::all()->get(1)->name,
		])->assertStatus(302)->assertRedirect("/users");

		$this->assertDatabaseHas("role_user", [
				'user_id' => $user->id,
				'role_id' => Role::all()->get(1)->id,
		]);
	}
}
