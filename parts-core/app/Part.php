<?php

namespace App;

use DateTime;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Part
 *
 * @property-read \App\ApprovalStatus $approvalStatus
 * @property-read \App\User           $observer
 * @property-read \App\ReceivedStatus $receivedStatus
 * @property-read \App\Request        $request
 * @property-read \App\Vendor         $vendor
 * @mixin \Eloquent
 * @property int                      $id
 * @property int                      $vendor_id
 * @property int                      $received_status_id
 * @property int                      $approval_status_id
 * @property int                      $user_id
 * @property int                      $request_id
 * @property int                      $request_quantity
 * @property int                      $final_quantity
 * @property string                   $approval_date
 * @property string                   $part_number
 * @property bool                     $expedite
 * @property bool                     $asked_for_expedite
 * @property string                   $description
 * @property \Carbon\Carbon           $created_at
 * @property \Carbon\Carbon           $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Part whereApprovalDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Part whereApprovalStatusId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Part whereAskedForExpedite($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Part whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Part whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Part whereExpedite($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Part whereFinalQuantity($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Part whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Part wherePartNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Part whereReceivedStatusId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Part whereRequestId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Part whereRequestQuantity($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Part whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Part whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Part whereVendorId($value)
 * @property string                   $ordered_date
 * @property string                   $returned_date
 * @property string                   $received_date
 * @property string                   $completed_date
 * @property string                   $eta
 * @method static \Illuminate\Database\Query\Builder|\App\Part whereCompletedDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Part whereEta($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Part whereOrderedDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Part whereReceivedDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Part whereReturnedDate($value)
 * @property int|null                 $key
 * @property int|null                 $user_signature
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Part whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Part whereUserSignature($value)
 */
class Part extends Model
{
	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function request()
	{
		return $this->belongsTo('App\Request');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function observer()
	{
		return $this->belongsTo('App\User', 'user_id');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function vendor()
	{
		return $this->belongsTo('App\Vendor');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function receivedStatus()
	{
		return $this->belongsTo('App\ReceivedStatus');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function approvalStatus()
	{
		return $this->belongsTo('App\ApprovalStatus');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function signature()
	{
		return $this->belongsTo('App\User', 'user_signature');
	}

	/**
	 * @return string
	 */
	public function getETAColorStatus()
	{
		if (isset($this->eta))
			if ($this->eta < new DateTime())
				return "danger";
			else
				return "warning";
		return "info";
	}
}
