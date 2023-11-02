<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\ApprovalStatus
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Part[] $parts
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property string $description
 * @method static \Illuminate\Database\Query\Builder|\App\ApprovalStatus whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ApprovalStatus whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ApprovalStatus whereName($value)
 */
class ApprovalStatus extends Model
{
	public $timestamps = false;

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function parts()
	{
		return $this->hasMany('App\Part');
	}
}
