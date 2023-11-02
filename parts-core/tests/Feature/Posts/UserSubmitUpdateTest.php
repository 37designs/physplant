<?php

namespace Tests\Feature\Posts;

use App\Role;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Feature\CreateModels;
use Tests\UserTestCase;


class UserSubmitUpdateTest extends UserTestCase
{
	use DatabaseMigrations;
	use CreateModels;

	/** TEST */
	function testNewUser()
	{
		$user = factory(User::class)->create();

		$this->actingAs($this->userNew)->post('/users/create', [
				'username' => $user->username,
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
		$user = factory(User::class)->create();

		$this->actingAs($this->userForeperson)->post('/users/create', [
				'username' => $user->username,
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
		$user = factory(User::class)->create();

		$this->actingAs($this->userMaterials)->post('/users/create', [
				'username' => $user->username,
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
		$user = factory(User::class)->create();

		$this->actingAs($this->userAdmin)->post('/users/create', [
				'username' => $user->username,
				'role' => Role::all()->get(1)->name,
		])->assertStatus(302)->assertRedirect("/users");

		$this->assertDatabaseHas("role_user", [
				'user_id' => $user->id,
				'role_id' => Role::all()->get(1)->id,
		]);
	}
}
