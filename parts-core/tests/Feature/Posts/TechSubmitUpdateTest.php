<?php

namespace Tests\Feature;

use App\Shop;
use App\Technician;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\UserTestCase;

class TechSubmitUpdateTest extends UserTestCase
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
		$tech = factory(Technician::class)->create(['email' => 'test@test.com', 'name' => 'bob', 'shop_id' => 99, 'active' => 1]);

		$this->actingAs($this->userNew)->patch('/techs/' . $tech->id, [
				'shop' => Shop::all()->first()->name,
		])->assertStatus(403);

		$this->assertDatabaseMissing("technicians", [
				'name' => $tech->name,
				'shop_id' => Shop::all()->first()->id,
				'email' => $tech->email,
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
		$tech = factory(Technician::class)->create(['email' => 'test@test.com', 'name' => 'bob', 'shop_id' => 99, 'active' => 1]);

		$this->actingAs($this->userForeperson)->patch('/techs/' . $tech->id, [
				'shop' => Shop::all()->first()->name,
		])->assertStatus(302)->assertRedirect("/techs");

		$this->assertDatabaseHas("technicians", [
				'name' => $tech->name,
				'shop_id' => Shop::all()->first()->id,
				'email' => $tech->email,
		]);
	}

	/** TEST */
	public function testMaterials()
	{
		$tech = factory(Technician::class)->create(['email' => 'test@test.com', 'name' => 'bob', 'shop_id' => 99, 'active' => 1]);

		$this->actingAs($this->userMaterials)->patch('/techs/' . $tech->id, [
				'shop' => Shop::all()->first()->name,
		])->assertStatus(403);

		$this->assertDatabaseMissing("technicians", [
				'name' => $tech->name,
				'shop_id' => Shop::all()->first()->id,
				'email' => $tech->email,
		]);
	}

	/** TEST */
	public function testAdmin()
	{
		$tech = factory(Technician::class)->create(['email' => 'test@test.com', 'name' => 'bob', 'shop_id' => 99, 'active' => 1]);

		$this->actingAs($this->userAdmin)->patch('/techs/' . $tech->id, [
				'shop' => Shop::all()->first()->name,
		])->assertStatus(302)->assertRedirect("/techs");

		$this->assertDatabaseHas("technicians", [
				'name' => $tech->name,
				'shop_id' => Shop::all()->first()->id,
				'email' => $tech->email,
		]);
	}
}
