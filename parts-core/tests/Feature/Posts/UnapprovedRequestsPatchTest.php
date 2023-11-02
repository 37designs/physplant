<?php

namespace Tests\Feature;

use App\Shop;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\UserTestCase;

class UnapprovedRequestsPatchTest extends UserTestCase
{
	use DatabaseMigrations;
	use CreateModels;

	protected $parts;

	function setUp()
	{
		parent::setUp();

		$this->userTech->shop_id = Shop::all()->first()->id;
		$this->userTech->save();

		$this->parts = array(
				factory('App\Part')->create([
						'id' => 1,
						'received_status_id' => 1,
						'approval_status_id' => 1,
						'completed_date' => null,
						'user_id' => null,
						'ordered_date' => null,
						'returned_date' => null,
						'received_date' => null,
						'part_number' => 'partnum1'
				]),
				factory('App\Part')->create([
						'id' => 2,
						'received_status_id' => 1,
						'approval_status_id' => 1,
						'completed_date' => null,
						'user_id' => null,
						'ordered_date' => null,
						'returned_date' => null,
						'received_date' => null,
						'part_number' => 'partnum2'
				]),
				factory('App\Part')->create([
						'id' => 3,
						'received_status_id' => 1,
						'approval_status_id' => 1,
						'completed_date' => null,
						'user_id' => null,
						'ordered_date' => null,
						'returned_date' => null,
						'received_date' => null,
						'part_number' => 'partnum3'
				]),
		);
	}

	function testNewUser()
	{
		$this->userNew->shop_id = Shop::all()->first()->id;
		$this->userNew->save();

		$partRequest = $this->CreateNewPartRequest($this->userTech, $this->parts);

		$this->actingAs($this->userNew)
				->patch("/requests/" . $partRequest->id, [
						'part' => [
								[
										'part_num' => '1',
										'expedite' => '1',
										'quantity' => '10',
										'vendor' => 'Vendor1',
										'approved' => '1',
								], [
										'part_num' => '2',
										'expedite' => '1',
										'quantity' => '3',
										'vendor' => 'Vendor2',
										'approved' => '0',
								], [
										'part_num' => '3',
										'quantity' => '5',
										'vendor' => 'Vendor2',
										'approved' => '1',
								],
						],
				])->assertStatus(403);

		$this->assertDatabaseMissing('parts', [
				'user_id' => $this->userNew->id,
				'approval_status_id' => 2,
				'expedite' => 1,
		]);
	}

	public function testTech()
	{
		$this->assertTrue(true);
	}

	public function testForeperson()
	{
		$this->userForeperson->shop_id = Shop::all()->first()->id;
		$this->userForeperson->save();

		$partRequest = $this->CreateNewPartRequest($this->userTech, $this->parts);

		$this->actingAs($this->userForeperson)
				->patch("/requests/" . $partRequest->id, [
						'part' => [
								[
										'part_num' => '1',
										'expedite' => '1',
										'quantity' => '10',
										'vendor' => 'Vendor1',
										'approved' => '1',
								], [
										'part_num' => '2',
										'expedite' => '1',
										'quantity' => '3',
										'vendor' => 'Vendor2',
										'approved' => '0',
								], [
										'part_num' => '3',
										'quantity' => '5',
										'vendor' => 'Vendor2',
										'approved' => '1',
								],
						],
				])->assertStatus(302);

		$this->assertDatabaseHas('parts', [
				'user_id' => $this->userForeperson->id,
				'approval_status_id' => 2,
				'expedite' => 1,
		]);
	}

	public function testMaterials()
	{
		$this->userMaterials->shop_id = Shop::all()->first()->id;
		$this->userMaterials->save();

		$partRequest = $this->CreateNewPartRequest($this->userTech, $this->parts);

		$this->actingAs($this->userMaterials)
				->patch("/requests/" . $partRequest->id, [
						'part' => [
								[
										'part_num' => '1',
										'expedite' => '1',
										'quantity' => '10',
										'vendor' => 'Vendor1',
										'approved' => '1',
								], [
										'part_num' => '2',
										'expedite' => '1',
										'quantity' => '3',
										'vendor' => 'Vendor2',
										'approved' => '0',
								], [
										'part_num' => '3',
										'quantity' => '5',
										'vendor' => 'Vendor2',
										'approved' => '1',
								],
						],
				])->assertStatus(403);

		$this->assertDatabaseMissing('parts', [
				'user_id' => $this->userMaterials->id,
				'approval_status_id' => 2,
				'expedite' => 1,
		]);
	}

	public function testAdmin()
	{
		$this->userAdmin->shop_id = Shop::all()->first()->id;
		$this->userAdmin->save();

		$partRequest = $this->CreateNewPartRequest($this->userTech, $this->parts);

		$this->actingAs($this->userAdmin)
				->patch("/requests/" . $partRequest->id, [
						'part' => [
								[
										'part_num' => '1',
										'expedite' => '1',
										'quantity' => '10',
										'vendor' => 'Vendor1',
										'approved' => '1',
								], [
										'part_num' => '2',
										'expedite' => '1',
										'quantity' => '3',
										'vendor' => 'Vendor2',
										'approved' => '0',
								], [
										'part_num' => '3',
										'quantity' => '5',
										'vendor' => 'Vendor2',
										'approved' => '1',
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
