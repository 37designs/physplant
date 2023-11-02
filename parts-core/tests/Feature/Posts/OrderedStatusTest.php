<?php

namespace Tests\Feature;

use App\Shop;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\UserTestCase;

class OrderedStatusTest extends UserTestCase
{
	use DatabaseMigrations;
	use CreateModels;

	protected $parts;

	function setUp()
	{
		parent::setUp();

		$this->userTech->shop_id = Shop::all()->first()->id;
		$this->userTech->save();

		$this->userForeperson->shop_id = Shop::all()->first()->id;
		$this->userForeperson->save();

		for ($i = 1; $i < 8; $i++)
		{
			$this->parts[] = factory('App\Part')->create([
					'id' => $i,
					'received_status_id' => 1,
					'approval_status_id' => 1,
					'completed_date' => null,
					'user_id' => null,
					'ordered_date' => null,
					'returned_date' => null,
					'received_date' => null,
					'part_number' => 'partnum1'
			]);
		}
	}

	function testNewUser()
	{
		$this->userNew->shop_id = Shop::all()->first()->id;
		$this->userNew->save();

		$partRequest = $this->CreateNewApprovedPartRequest($this->userForeperson, $this->userTech, $this->parts);

		$this->actingAs($this->userNew)
				->patch("/materials/" . $partRequest->id, [
						'part' => [
								[
										'part_num' => '1',
										'status' => '1',
										'eta' => '11-01-2050',
								], [
										'part_num' => '2',
										'status' => '2',
										'eta' => '11-01-2050',
								], [
										'part_num' => '3',
										'status' => '3',
										'eta' => '11-01-2050',
								], [
										'part_num' => '4',
										'status' => '4',
										'eta' => '11-01-2050',
								], [
										'part_num' => '5',
										'status' => '5',
										'eta' => '11-01-2050',
								], [
										'part_num' => '6',
										'status' => '6',
										'eta' => '11-01-2050',
								], [
										'part_num' => '7',
										'status' => '7',
										'eta' => '11-01-2050',
								],
						],
				])->assertStatus(403);

		$this->assertDatabaseMissing('parts', [
				'received_status_id' => 1,
				'received_status_id' => 2,
				'received_status_id' => 3,
				'received_status_id' => 4,
				'received_status_id' => 5,
				'received_status_id' => 6,
				'received_status_id' => 7,
		]);
	}

	public function testTech()
	{
		$this->assertTrue(true);
	}

	public function testForeperson()
	{
		$partRequest = $this->CreateNewApprovedPartRequest($this->userForeperson, $this->userTech, $this->parts);

		$this->actingAs($this->userForeperson)
				->patch("/materials/" . $partRequest->id, [
						'part' => [
								[
										'part_num' => '1',
										'status' => '1',
										'eta' => '11-01-2050',
								], [
										'part_num' => '2',
										'status' => '2',
										'eta' => '11-01-2050',
								], [
										'part_num' => '3',
										'status' => '3',
										'eta' => '11-01-2050',
								], [
										'part_num' => '4',
										'status' => '4',
										'eta' => '11-01-2050',
								], [
										'part_num' => '5',
										'status' => '5',
										'eta' => '11-01-2050',
								], [
										'part_num' => '6',
										'status' => '6',
										'eta' => '11-01-2050',
								], [
										'part_num' => '7',
										'status' => '7',
										'eta' => '11-01-2050',
								],
						],
				])->assertStatus(403);

		$this->assertDatabaseMissing('parts', [
				'received_status_id' => 1,
				'received_status_id' => 2,
				'received_status_id' => 3,
				'received_status_id' => 4,
				'received_status_id' => 5,
				'received_status_id' => 6,
				'received_status_id' => 7,
		]);
	}

	public function testMaterials()
	{
		$this->userMaterials->shop_id = Shop::all()->first()->id;
		$this->userMaterials->save();

		$partRequest = $this->CreateNewApprovedPartRequest($this->userForeperson, $this->userTech, $this->parts);

		$this->actingAs($this->userMaterials)
				->patch("/materials/" . $partRequest->id, [
						'part' => [
								[
										'part_num' => '1',
										'status' => '1',
										'eta' => '11-01-2050',
								], [
										'part_num' => '2',
										'status' => '2',
										'eta' => '11-01-2050',
								], [
										'part_num' => '3',
										'status' => '3',
										'eta' => '11-01-2050',
								], [
										'part_num' => '4',
										'status' => '4',
										'eta' => '11-01-2050',
								], [
										'part_num' => '5',
										'status' => '5',
										'eta' => '11-01-2050',
								], [
										'part_num' => '6',
										'status' => '6',
										'eta' => '11-01-2050',
								], [
										'part_num' => '7',
										'status' => '7',
										'eta' => '11-01-2050',
								],
						],
				])->assertStatus(302);

		$this->assertDatabaseHas('parts', [
				'received_status_id' => 1,
				'received_status_id' => 2,
				'received_status_id' => 3,
				'received_status_id' => 4,
				'received_status_id' => 5,
				'received_status_id' => 6,
				'received_status_id' => 7,
		]);
	}

	public function testAdmin()
	{
		$this->userAdmin->shop_id = Shop::all()->first()->id;
		$this->userAdmin->save();

		$partRequest = $this->CreateNewApprovedPartRequest($this->userForeperson, $this->userTech, $this->parts);

		$this->actingAs($this->userAdmin)
				->patch("/materials/" . $partRequest->id, [
						'part' => [
								[
										'part_num' => '1',
										'status' => '1',
										'eta' => '11-01-2050',
								], [
										'part_num' => '2',
										'status' => '2',
										'eta' => '11-01-2050',
								], [
										'part_num' => '3',
										'status' => '3',
										'eta' => '11-01-2050',
								], [
										'part_num' => '4',
										'status' => '4',
										'eta' => '11-01-2050',
								], [
										'part_num' => '5',
										'status' => '5',
										'eta' => '11-01-2050',
								], [
										'part_num' => '6',
										'status' => '6',
										'eta' => '11-01-2050',
								], [
										'part_num' => '7',
										'status' => '7',
										'eta' => '11-01-2050',
								],
						],
				])->assertStatus(302);

		$this->assertDatabaseHas('parts', [
				'received_status_id' => 1,
				'received_status_id' => 2,
				'received_status_id' => 3,
				'received_status_id' => 4,
				'received_status_id' => 5,
				'received_status_id' => 6,
				'received_status_id' => 7,
		]);
	}
}
