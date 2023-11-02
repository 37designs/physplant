<?php

namespace Tests\Feature;

use Tests\TestCase;

class NotAuthRedirectTest extends TestCase
{
	/** @test
	 * Test if the root route of a non-logged in user redirects to login
	 */
	public function testRootRouteRedirect()
	{
		$this->get("/")
				->assertRedirect("/login");
	}

	/** @test
	 * Test if a non route of a non-logged in user redirects to login
	 */
	public function testNoneRouteRedirect()
	{
		$this->get("/dsfgvdfwar23rf")
				->assertRedirect("/login");
	}

	/** @test
	 * Test if the home route of a non-logged in user redirects to login
	 */
	public function testHomeRouteRedirect()
	{
		$this->get("/home")
				->assertRedirect("/login");
	}
}
