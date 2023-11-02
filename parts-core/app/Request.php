<?php

namespace App;

use DateTime;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Request
 *
 * @property int                                                          $id
 * @property int                                                          $technician_id
 * @property string                                                       $work_order
 * @property \Carbon\Carbon                                               $created_at
 * @property \Carbon\Carbon                                               $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Comment[] $comments
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Part[]    $parts
 * @property-read \App\Technician                                         $technician
 * @method static \Illuminate\Database\Query\Builder|\App\Request shop()
 * @method static \Illuminate\Database\Query\Builder|\App\Request whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Request whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Request whereTechnicianId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Request whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Request whereWorkOrder($value)
 * @mixin \Eloquent
 */
class Request extends Model
{

	/**
	 * @return Shop
	 */
	public function scopeShop()
	{
		return $this->technician->shop;
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function technician()
	{
		return $this->belongsTo('App\Technician');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function comments()
	{
		return $this->hasMany('App\Comment');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function parts()
	{
		return $this->hasMany('App\Part');
	}

	/**
	 * @return array|null
	 */
	public function getPartsOrderStatus()
	{
		return $this->parts()->pluck('received_status_id')->toArray();
	}

	/**
	 * @return bool
	 */
	public function isAllPartsApproved()
	{
		foreach ($this->parts as $part)
		{
			if ($part->approvalStatus->id != 2)
			{
				return false;
			}
		}
		return true;
	}

	/**
	 * @return bool
	 */
	public function isAllPartsRejected()
	{
		foreach ($this->parts as $part)
		{
			if ($part->approvalStatus->id == 2)
			{
				return true;
			}
		}
		return false;
	}

	/**
	 * @return bool
	 */
	public function hasAllPartsContainApproverDecision()
	{
		/** @var \App\Part $part */
		foreach ($this->parts as $part)
		{
			if (!isset($this->parts) || !isset($part->approvalStatus))
				continue;

			// Check if part approval status is awaiting
			if ($part->approvalStatus->id == 1)
			{
				return false;
			}
		}
		return true;
	}

	/**
	 * @return string
	 */
	public function getRequestStatus()
	{ 
		$sortedPartsStatus = array_unique($this->getPartsOrderStatus());

		// Check if sorted is rejected or completed
		if (count($sortedPartsStatus) == 1 && ($sortedPartsStatus[0] == 7 || $sortedPartsStatus[0] == 6))
			return "Closed";

		// Check if mix of rejected or completed
		// if (count($sortedPartsStatus) == 2 && ($sortedPartsStatus[0] == 7 || $sortedPartsStatus[0] == 6) && ($sortedPartsStatus[1] == 7 || $sortedPartsStatus[1] == 6))
		if (count($sortedPartsStatus) == 2 && (in_array([7,6], $sortedPartsStatus)))
			return "Closed";

		// Check if the parts order status is greater than not ordered
		if (count($sortedPartsStatus) >= 1 && $sortedPartsStatus[0] > 1)
			return "Shipping";

		if ($this->hasAllPartsContainApproverDecision())
			return "Not Ordered";
		else
			return "Awaiting Decision";

	}

	/**
	 * @return string
	 */
	public function getRequestColorStatus()
	{
		$sortedPartsStatus = array_unique($this->getPartsOrderStatus());

		// Check if the parts order status is greater than not ordered
		if (count($sortedPartsStatus) >= 1 && $sortedPartsStatus[0] > 1)
		{
			foreach ($this->parts as $part)
			{
				if (isset($part->eta) && $part->eta < new DateTime())
					return "danger";
			}

			return "warning";
		}

		return "info";
	}
}
