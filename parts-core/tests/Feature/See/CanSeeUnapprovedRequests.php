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
	public function testCanViewUnapprovedRequest()
	{
		/** @var \App\User $user */
		$user = LoginUser::GetForepersonUser();
		$user->shop_id = Shop::all()->first()->id;
		$user->save();

		/** @var \App\Technician $tech */
		$tech = LoginUser::GetTechnician();
		$tech->shop_id = Shop::all()->first()->id;
		$tech->save();

		$parts = array(
				factory('App\Part')->create([
						'received_status_id' => 1,
						'approval_status_id' => 1,
						'request_id' => 99999,
						'completed_date' => null,]),
				factory('App\Part')->create([
						'received_status_id' => 1,
						'approval_status_id' => 1,
						'request_id' => 99999,
						'completed_date' => null,])
		);

		/** @var \App\Request $partRequest */
		$partRequest = $this->CreateNewPartRequest($tech, $parts);

		$this->actingAs($user)
				->get("/requests")
				->assertDontSee("No currently open part requests.")
				->assertSee("All Requests For " . $user->shop->name)
				->assertSee($partRequest->work_order)
				->assertSee($partRequest->technician->name);
	}

	/** TEST */
	public function testSeeNoUnapprovedRequest()
	{
		/** @var \App\User $user */
		$user = LoginUser::GetForepersonUser();
		$user->shop_id = Shop::all()->first()->id;
		$user->save();

		$this->actingAs($user)
				->get("/requests")
				->assertSee("No currently open part requests.");
	}
}
