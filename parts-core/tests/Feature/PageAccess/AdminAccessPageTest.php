<?php

namespace Tests\Feature;

use App\Shop;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Helpers\LoginUser;
use Tests\TestCase;

class AdminAccessPageTest extends TestCase
{
	use DatabaseMigrations;

	/** TEST */
	public function testAdminAccessPartsRequestPage()
	{
		$user = LoginUser::GetAdminUser();

		$this->actingAs($user)
				->get("/partsrequest")
				->assertSee("Request Parts");
	}

	/** TEST */
	public function testAdminAccessShopRequestsPage()
	{
		$user = LoginUser::GetAdminUser();
		$user->shop_id = Shop::all()->first()->id;
		$user->save();

		$this->actingAs($user)
				->get("/requests")
				->assertSee("All Requests For " . $user->shop->name);
	}

	/** TEST */
	public function testAdminAccessMaterialsRequestPage()
	{
		$user = LoginUser::GetAdminUser();

		$this->actingAs($user)
				->get("/materials")
				->assertSee("All Materials Requests");
	}


	/** TEST */
	public function testAdminAccessUserControlsPage()
	{
		$user = LoginUser::GetAdminUser();

		$this->actingAs($user)
				->get("/users")
				->assertSee("User List");
	}


	/** TEST */
	public function testAdminAccessSettingsPage()
	{
		$user = LoginUser::GetAdminUser();

		$this->actingAs($user)
				->get("/settings")
				->assertSee("Settings");
	}

	/** TEST */
	public function testAdminAccessHomePage()
	{
		$user = LoginUser::GetAdminUser();

		$this->actingAs($user)
				->get("/home")
				->assertSee("Dashboard");
	}

	/** TEST */
	public function testAdminAccessTechPage()
	{
		$user = LoginUser::GetAdminUser();

		$this->actingAs($user)
				->get("/techs")
				->assertSee("Tech List");
	}

	/** TEST */
	public function testAdminAccessAllRequestPage()
	{
		$user = LoginUser::GetAdminUser();

		$this->actingAs($user)
				->get("/allrequests")
				->assertSee("All Requests");
	}

}
