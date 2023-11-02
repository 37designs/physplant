<?php

namespace Tests\Feature;


use App\Technician;

trait CreateModels
{
	/**
	 * Create a fully new part request
	 *
	 * @param \App\Technician $tech
	 * @return \App\Request
	 */
	public function CreateNewPartRequest(Technician $tech, array $parts = null)
	{
		/** @var \App\Request $partrequest */
		$partrequest = factory('App\Request')->create(['technician_id' => $tech->id]);
		$partrequest->technician()->associate($tech);

		$com = factory('App\Comment')->create([
				'commentable_id' => $tech->id,
				'commentable_type' => 'App\Technician'
		]);

		$partrequest->save();
		$partrequest->comments()->save($com);


		if (!isset($parts))
		{
			$part = factory('App\Part')->create([
					'received_status_id' => 1,
					'approval_status_id' => 1,
					'request_id' => $partrequest->id,
					'completed_date' => null,
			]);
			$partrequest->parts()->save($part);
		} else
		{
			foreach ($parts as $part)
			{
				$part->request_id = $partrequest->id;
				$partrequest->parts()->save($part);
			}
		}

		$partrequest->save();

		return $partrequest;
	}

	/**
	 * @param User       $foreperson
	 * @param Technician $tech
	 * @param array|null $parts
	 * @return \App\Request
	 */
	public function CreateNewApprovedPartRequest(\App\User $foreperson, Technician $tech, array $parts = null)
	{
		/** @var \App\Request $approvedReq */
		$approvedReq = $this->CreateNewPartRequest($tech, $parts);

		/** @var \App\Part $part */
		foreach ($approvedReq->parts->all() as $part)
		{
			$part->approval_status_id = 2;
			$part->expedite = $part->asked_for_expedite;
			$part->user_id = $foreperson->id;
			$part->final_quantity = $part->request_quantity;
			$part->save();
		}

		return $approvedReq;
	}
}