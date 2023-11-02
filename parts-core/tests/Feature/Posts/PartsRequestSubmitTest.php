<?php

namespace Tests\Feature;

use App\Shop;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Helpers\LoginUser;
use Tests\TestCase;

class PartsRequestSubmitTest extends TestCase
{
	use DatabaseMigrations;

	/** TEST */
	public function testPartsRequestSubmitPost()
	{
		$tech = LoginUser::GetTechnician();
		$tech->shop_id = Shop::all()->first()->id;
		$tech->save();

		$this->post('/partsrequest', [
				'tech' => $tech->id,
				'wo' => "x-11111111",
				'comments' => "test comment",
				'parts' => [
						[
								'quantity' => '12',
								'vendor' => 'ven1',
								'part_num' => 'part1',
								'description' => 'desc1',
								'expedite' => 0,
						],
						[
								'quantity' => '23',
								'vendor' => 'ven2',
								'part_num' => 'part2',
								'description' => 'desc2',
								'expedite' => 1,
						],
				],
		])->assertRedirect("partsrequest");

		// Check if request was created
		$this->assertDatabaseHas('requests', [
				'technician_id' => $tech->id,
				'work_order' => 'x-11111111',
		]);

		// Check if comment was created
		$this->assertDatabaseHas('comments', [
				'comment' => 'test comment',
		]);

		// Check for part 1
		$this->assertDatabaseHas('parts', [
				'request_quantity' => '12',
				'part_number' => 'part1',
				'description' => 'desc1',
				'asked_for_expedite' => 0,
		]);

		// Check for part 2
		$this->assertDatabaseHas('parts', [
				'request_quantity' => '23',
				'part_number' => 'part2',
				'description' => 'desc2',
				'asked_for_expedite' => 1,
		]);

		// Check if vendor was created
		$this->assertDatabaseHas('vendors', [
				'name' => 'ven1',
				'name' => 'ven2',
		]);
	}
}
