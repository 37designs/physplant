<?php

namespace Tests\Feature;

use App;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class AuthRedirectTest extends TestCase
{
	use DatabaseMigrations;

	/** @test
	 * Test if the root route of a logged in user redirects to home
	 */
	public function testRootRouteRedirect()
	{
		$user = factory(App\User::class)->create();

		$this->actingAs($user)
				->withSession(['foo' => 'bar'])
				->get("/")
				->assertRedirect("/home");
	}

	/** @test
	 * Test if a none route redirects to login
	 */
	public function testNoneRouteRedirect()
	{
		$user = factory(App\User::class)->create();

		$this->actingAs($user)
				->withSession(['foo' => 'bar'])
				->get("/asgagagasdg")
				->assertRedirect("/login");
	}

	/** @test
	 * Test if a login route of a logged in user redirects to home
	 */
	public function testLoginRouteRedirect()
	{
		$user = factory(App\User::class)->create();

		$this->actingAs($user)
				->withSession(['foo' => 'bar'])
				->get("/login")
				->assertRedirect("/home");
	}
}
