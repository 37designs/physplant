<?php

namespace Tests\Feature;

use App\Shop;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Helpers\LoginUser;
use Tests\TestCase;

class ForepersonAccessPageTest extends TestCase
{
	use DatabaseMigrations;

	/** TEST */
	public function testForepersonAccessPartsRequestPage()
	{
		$user = LoginUser::GetForepersonUser();

		$this->actingAs($user)
				->get("/partsrequest")
				->assertSee("Request Parts");
	}

	/** TEST */
	public function testForepersonAccessShopRequestsPage()
	{
		$user = LoginUser::GetForepersonUser();
		$user->shop_id = Shop::all()->first()->id;
		$user->save();

		$this->actingAs($user)
				->get("/requests")
				->assertSee("All Requests For " . $user->shop->name);
	}

	/** TEST */
	public function testForepersonAccessMaterialsRequestPage()
	{
		$user = LoginUser::GetForepersonUser();

		$this->actingAs($user)
				->get("/materials")
				->assertStatus(403);
	}


	/** TEST */
	public function testForepersonAccessUserControlsPage()
	{
		$user = LoginUser::GetForepersonUser();

		$this->actingAs($user)
				->get("/users")
				->assertStatus(403);
	}


	/** TEST */
	public function testForepersonAccessSettingsPage()
	{
		$user = LoginUser::GetForepersonUser();

		$this->actingAs($user)
				->get("/settings")
				->assertSee("Settings");
	}

	/** TEST */
	public function testForepersonAccessHomePage()
	{
		$user = LoginUser::GetForepersonUser();

		$this->actingAs($user)
				->get("/home")
				->assertSee("Dashboard");
	}

	/** TEST */
	public function testForepersonAccessTechPage()
	{
		$user = LoginUser::GetForepersonUser();

		$this->actingAs($user)
				->get("/techs")
				->assertSee("Tech List");
	}


	/** TEST */
	public function testForepersonAccessAllRequestPage()
	{
		$user = LoginUser::GetForepersonUser();

		$this->actingAs($user)
				->get("/allrequests")
				->assertSee("All Requests");
	}
}
