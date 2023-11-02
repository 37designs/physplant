<?php

namespace Tests\Feature;

use App\Shop;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Helpers\LoginUser;
use Tests\TestCase;

class NewAccessPageTest extends TestCase
{
	use DatabaseMigrations;

	/** TEST */
	public function testNewAccessPartsRequestPage()
	{
		$user = LoginUser::GetNewUser();

		$this->actingAs($user)
				->withSession(['foo' => 'bar'])
				->get("/partsrequest")
				->assertSee("Request Parts");
	}

	/** TEST */
	public function testNewAccessShopRequestsPage()
	{
		$user = LoginUser::GetNewUser();
		$user->shop_id = Shop::all()->first()->id;
		$user->save();

		$this->actingAs($user)
				->withSession(['foo' => 'bar'])
				->get("/requests")
				->assertStatus(403);
	}

	/** TEST */
	public function testNewAccessMaterialsRequestPage()
	{
		$user = LoginUser::GetNewUser();

		$this->actingAs($user)
				->withSession(['foo' => 'bar'])
				->get("/materials")
				->assertStatus(403);
	}


	/** TEST */
	public function testNewAccessUserControlsPage()
	{
		$user = LoginUser::GetNewUser();

		$this->actingAs($user)
				->withSession(['foo' => 'bar'])
				->get("/users")
				->assertStatus(403);
	}


	/** TEST */
	public function testNewAccessSettingsPage()
	{
		$user = LoginUser::GetNewUser();

		$this->actingAs($user)
				->withSession(['foo' => 'bar'])
				->get("/settings")
				->assertSee("Settings");
	}

	/** TEST */
	public function testNewAccessHomePage()
	{
		$user = LoginUser::GetNewUser();

		$this->actingAs($user)
				->withSession(['foo' => 'bar'])
				->get("/home")
				->assertSee("Dashboard");
	}

	/** TEST */
	public function testNewAccessTechPage()
	{
		$user = LoginUser::GetNewUser();

		$this->actingAs($user)
				->withSession(['foo' => 'bar'])
				->get("/techs")
				->assertStatus(403);
	}

	/** TEST */
	public function testNewAccessAllRequestPage()
	{
		$user = LoginUser::GetNewUser();

		$this->actingAs($user)
				->get("/allrequests")
				->assertStatus(403);
	}
}
