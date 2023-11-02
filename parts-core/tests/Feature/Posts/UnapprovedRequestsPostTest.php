<?php

namespace Tests\Feature;

use App\Shop;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\UserTestCase;

class UnapprovedRequestsPostTest extends UserTestCase
{
	use DatabaseMigrations;
	use CreateModels;

	/** TEST */
	public function testNewUser()
	{
		$this->userNew->shop_id = Shop::all()->first()->id;
		$this->userNew->save();

		$this->userTech->shop_id = Shop::all()->first()->id;
		$this->userTech->save();

		$parts = array(
				factory('App\Part')->create([
						'received_status_id' => 1,
						'approval_status_id' => 1,
						'completed_date' => null,]),
				factory('App\Part')->create([
						'received_status_id' => 1,
						'approval_status_id' => 1,
						'completed_date' => null,]),
		);

		/** @var \App\Request $partRequest */
		$partRequest = $this->CreateNewPartRequest($this->userTech, $parts);

		$this->actingAs($this->userNew)
				->post("/requests", [
						'req' =>
								[
										$partRequest->id => [
												'approve' => '1',
												'expedite' => '1',
												'requestid' => $partRequest->id,
										],
								],
				])->assertStatus(403);

		$this->assertDatabaseMissing('parts', [
				'user_id' => $this->userNew->id,
				'approval_status_id' => 2,
				'expedite' => 1,
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
		$this->userForeperson->shop_id = Shop::all()->first()->id;
		$this->userForeperson->save();

		$this->userTech->shop_id = Shop::all()->first()->id;
		$this->userTech->save();

		$parts = array(
				factory('App\Part')->create([
						'received_status_id' => 1,
						'approval_status_id' => 1,
						'completed_date' => null,]),
				factory('App\Part')->create([
						'received_status_id' => 1,
						'approval_status_id' => 1,
						'completed_date' => null,]),
		);

		/** @var \App\Request $partRequest */
		$partRequest = $this->CreateNewPartRequest($this->userTech, $parts);

		$this->actingAs($this->userForeperson)
				->post("/requests", [
						'req' =>
								[
										$partRequest->id => [
												'approve' => '1',
												'expedite' => '1',
												'requestid' => $partRequest->id,
										],
								],
				])->assertStatus(302);

		$this->assertDatabaseHas('parts', [
				'user_id' => $this->userForeperson->id,
				'approval_status_id' => 2,
				'expedite' => 1,
		]);
	}

	/** TEST */
	public function testMaterials()
	{
		$this->userMaterials->shop_id = Shop::all()->first()->id;
		$this->userMaterials->save();

		$this->userTech->shop_id = Shop::all()->first()->id;
		$this->userTech->save();

		$parts = array(
				factory('App\Part')->create([
						'received_status_id' => 1,
						'approval_status_id' => 1,
						'completed_date' => null,]),
				factory('App\Part')->create([
						'received_status_id' => 1,
						'approval_status_id' => 1,
						'completed_date' => null,]),
		);

		/** @var \App\Request $partRequest */
		$partRequest = $this->CreateNewPartRequest($this->userTech, $parts);

		$this->actingAs($this->userMaterials)
				->post("/requests", [
						'req' =>
								[
										$partRequest->id => [
												'approve' => '1',
												'expedite' => '1',
												'requestid' => $partRequest->id,
										],
								],
				])->assertStatus(403);

		$this->assertDatabaseMissing('parts', [
				'user_id' => $this->userMaterials->id,
				'approval_status_id' => 2,
				'expedite' => 1,
		]);
	}

	/** TEST */
	public function testAdmin()
	{
		$this->userAdmin->shop_id = Shop::all()->first()->id;
		$this->userAdmin->save();

		$this->userTech->shop_id = Shop::all()->first()->id;
		$this->userTech->save();

		$parts = array(
				factory('App\Part')->create([
						'received_status_id' => 1,
						'approval_status_id' => 1,
						'completed_date' => null,]),
				factory('App\Part')->create([
						'received_status_id' => 1,
						'approval_status_id' => 1,
						'completed_date' => null,]),
		);

		/** @var \App\Request $partRequest */
		$partRequest = $this->CreateNewPartRequest($this->userTech, $parts);

		$this->actingAs($this->userAdmin)
				->post("/requests", [
						'req' =>
								[
										$partRequest->id => [
												'approve' => '1',
												'expedite' => '1',
												'requestid' => $partRequest->id,
										],
								],
				])->assertStatus(302);

		$this->assertDatabaseHas('parts', [
				'user_id' => $this->userAdmin->id,
				'approval_status_id' => 2,
				'expedite' => 1,
		]);
	}
}
