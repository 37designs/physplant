<?php

namespace Tests\Feature;

use App\Request;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\UserTestCase;

class CommentSubmitTest extends UserTestCase
{
	use DatabaseMigrations;
	use CreateModels;

	/** @var Request */
	private $request;

	public function setUp()
	{
		parent::setUp();

		$this->request = $this->CreateNewPartRequest($this->userTech);
	}

	/** TEST */
	public function testNewUser()
	{
		$this->actingAs($this->userNew)->post('/comment/' . $this->request->id, [
				'comment' => "Test Comment",
		])->assertStatus(302);

		$this->assertDatabaseHas('comments', [
				'request_id' => $this->request->id,
				'commentable_id' => $this->userNew->id,
				'commentable_type' => 'App\User',
				'comment' => 'Test Comment',
		]);
	}

	/** TEST */
	public function testTech()
	{
		$this->assertTrue(true);
	}

	/** TEST */
	public function testForeperson()
	{
		$this->actingAs($this->userForeperson)->post('/comment/' . $this->request->id, [
				'comment' => "Test Comment",
		])->assertStatus(302);

		$this->assertDatabaseHas('comments', [
				'request_id' => $this->request->id,
				'commentable_id' => $this->userForeperson->id,
				'commentable_type' => 'App\User',
				'comment' => 'Test Comment',
		]);
	}

	/** TEST */
	public function testMaterials()
	{
		$this->actingAs($this->userMaterials)->post('/comment/' . $this->request->id, [
				'comment' => "Test Comment",
		])->assertStatus(302);

		$this->assertDatabaseHas('comments', [
				'request_id' => $this->request->id,
				'commentable_id' => $this->userMaterials->id,
				'commentable_type' => 'App\User',
				'comment' => 'Test Comment',
		]);
	}

	/** TEST */
	public function testAdmin()
	{
		$this->actingAs($this->userAdmin)->post('/comment/' . $this->request->id, [
				'comment' => "Test Comment",
		])->assertStatus(302);

		$this->assertDatabaseHas('comments', [
				'request_id' => $this->request->id,
				'commentable_id' => $this->userAdmin->id,
				'commentable_type' => 'App\User',
				'comment' => 'Test Comment',
		]);
	}
}
