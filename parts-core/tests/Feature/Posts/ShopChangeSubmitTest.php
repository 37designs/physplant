<?php

namespace Tests\Feature;

use App\Shop;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Helpers\LoginUser;
use Tests\TestCase;

class ShopChangeSubmitTest extends TestCase
{
	use DatabaseMigrations;

	/** TEST */
	public function testNewShopChangeSubmitPost()
	{
		$shop = Shop::all()->first();

		$this->actingAs(LoginUser::GetNewUser())->post('/settings', [
				'shop' => "1",
		])->assertStatus(403);
	}

	/** TEST */
	public function testForepersonShopChangeSubmitPost()
	{
		$shop = Shop::all()->first();

		$this->actingAs(LoginUser::GetForepersonUser())->post('/settings', [
				'shop' => "1",
		])->assertRedirect("settings");

		// Check if request was created
		$this->assertDatabaseHas('users', [
				'shop_id' => $shop->id,
		]);
	}

	/** TEST */
	public function testMaterialsShopChangeSubmitPost()
	{
		$shop = Shop::all()->first();

		$this->actingAs(LoginUser::GetMaterialsUser())->post('/settings', [
				'shop' => "1",
		])->assertRedirect("settings");

		// Check if request was created
		$this->assertDatabaseHas('users', [
				'shop_id' => $shop->id,
		]);
	}

	/** TEST */
	public function testAdminShopChangeSubmitPost()
	{
		$shop = Shop::all()->first();

		$this->actingAs(LoginUser::GetAdminUser())->post('/settings', [
				'shop' => "1",
		])->assertRedirect("settings");

		// Check if request was created
		$this->assertDatabaseHas('users', [
				'shop_id' => $shop->id,
		]);
	}
}
