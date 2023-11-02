<?php

namespace Tests\Feature;

use App\Shop;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\UserTestCase;

class TechSubmitStoreTest extends UserTestCase
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
		$this->actingAs($this->userNew)->post('/techs/create', [
				'name' => 'test',
				'shop' => Shop::all()->first()->name,
				'email' => 'test@test.test',
		])->assertStatus(403);

		$this->assertDatabaseMissing("technicians", [
				'name' => 'test',
				'shop_id' => Shop::all()->first()->id,
				'email' => 'test@test.test',
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
		$this->actingAs($this->userForeperson)->post('/techs/create', [
				'name' => 'test',
				'shop' => Shop::all()->first()->name,
				'email' => 'test@test.test',
		])->assertStatus(302)->assertRedirect("/techs");

		$this->assertDatabaseHas("technicians", [
				'name' => 'test',
				'shop_id' => Shop::all()->first()->id,
				'email' => 'test@test.test',
		]);
	}

	/** TEST */
	public function testMaterials()
	{
		$this->actingAs($this->userMaterials)->post('/techs/create', [
				'name' => 'test',
				'shop' => Shop::all()->first()->name,
				'email' => 'test@test.test',
		])->assertStatus(403);

		$this->assertDatabaseMissing("technicians", [
				'name' => 'test',
				'shop_id' => Shop::all()->first()->id,
				'email' => 'test@test.test',
		]);
	}

	/** TEST */
	public function testAdmin()
	{
		$this->actingAs($this->userAdmin)->post('/techs/create', [
				'name' => 'test',
				'shop' => Shop::all()->first()->name,
				'email' => 'test@test.test',
		])->assertStatus(302)->assertRedirect("/techs");

		$this->assertDatabaseHas("technicians", [
				'name' => 'test',
				'shop_id' => Shop::all()->first()->id,
				'email' => 'test@test.test',
		]);
	}
}
