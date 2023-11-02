<?php

namespace Tests\Feature;

use App\Shop;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Helpers\LoginUser;
use Tests\TestCase;

class MaterialsAccessPageTest extends TestCase
{
	use DatabaseMigrations;

	/** TEST */
	public function testMaterialsAccessPartsRequestPage()
	{
		$user = LoginUser::GetMaterialsUser();

		$this->actingAs($user)
				->get("/partsrequest")
				->assertSee("Request Parts");
	}

	/** TEST */
	public function testMaterialsAccessShopRequestsPage()
	{
		$user = LoginUser::GetMaterialsUser();
		$user->shop_id = Shop::all()->first()->id;
		$user->save();

		$this->actingAs($user)
				->get("/requests")
				->assertStatus(403);
	}

	/** TEST */
	public function testMaterialsAccessMaterialsRequestPage()
	{
		$user = LoginUser::GetMaterialsUser();

		$this->actingAs($user)
				->get("/materials")
				->assertSee("All Materials Requests");
	}


	/** TEST */
	public function testMaterialsAccessUserControlsPage()
	{
		$user = LoginUser::GetMaterialsUser();

		$this->actingAs($user)
				->get("/users")
				->assertStatus(403);
	}


	/** TEST */
	public function testMaterialsAccessSettingsPage()
	{
		$user = LoginUser::GetMaterialsUser();

		$this->actingAs($user)
				->get("/settings")
				->assertSee("Settings");
	}

	/** TEST */
	public function testMaterialsAccessHomePage()
	{
		$user = LoginUser::GetMaterialsUser();

		$this->actingAs($user)
				->get("/home")
				->assertSee("Dashboard");
	}

	/** TEST */
	public function testMaterialsAccessTechPage()
	{
		$user = LoginUser::GetMaterialsUser();

		$this->actingAs($user)
				->get("/techs")
				->assertStatus(403);
	}

	/** TEST */
	public function testMaterialsAccessAllRequestPage()
	{
		$user = LoginUser::GetMaterialsUser();

		$this->actingAs($user)
				->get("/allrequests")
				->assertSee("All Requests");
	}
}
