<?php

namespace Tests\Unit;

use App\Part;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Feature\CreateModels;
use Tests\Helpers\LoginUser;
use Tests\TestCase;

class CreateModelTest extends TestCase
{
	use DatabaseMigrations;
	use CreateModels;

	/** TEST */
	public function testCreateNewPartRequest()
	{
		/** @var \App\Technician $tech */
		$tech = LoginUser::GetTechnician();

		$this->CreateNewPartRequest($tech);

		$this->assertDatabaseHas('requests', [
				'technician_id' => $tech->id,
		]);

		$this->assertDatabaseHas('comments', [
				'commentable_id' => $tech->id,
				'commentable_type' => 'App\Technician',
		]);

		$this->assertDatabaseHas('parts', [
				'id' => 1,
		]);

		$this->assertTrue(Part::all()->count() == 1, "There are " . Part::all()->count() . " parts when there is only suppose to be 1.");
	}

	/** TEST */
	public function testCreateNewPartRequestWithPart()
	{
		/** @var \App\Technician $tech */
		$tech = LoginUser::GetTechnician();

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

		$this->CreateNewPartRequest($tech, $parts);

		$this->assertDatabaseHas('requests', [
				'technician_id' => $tech->id,
		]);

		$this->assertDatabaseHas('comments', [
				'commentable_id' => $tech->id,
				'commentable_type' => 'App\Technician',
		]);

		$this->assertDatabaseHas('parts', [
				'id' => 1,
				'id' => 2,
		]);

		$this->assertTrue(Part::all()->count() == 2, "There are " . Part::all()->count() . " parts when there is only suppose to be 2.");
	}

	/** TEST */
	public function testCreateApprovedPartRequestWithPart()
	{
		/** @var \App\Technician $tech */
		$tech = LoginUser::GetTechnician();
		$foreperson = LoginUser::GetForepersonUser();

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

		$this->CreateNewApprovedPartRequest($foreperson, $tech, $parts);

		$this->assertDatabaseHas('requests', [
				'technician_id' => $tech->id,
		]);

		$this->assertDatabaseHas('comments', [
				'commentable_id' => $tech->id,
				'commentable_type' => 'App\Technician',
		]);

		$this->assertDatabaseHas('parts', [
				'id' => 1,
				'id' => 2,
				'approval_status_id' => 2,
				'approval_status_id' => 2,
		]);

		$this->assertTrue(Part::all()->count() == 2, "There are " . Part::all()->count() . " parts when there is only suppose to be 2.");
	}
}
