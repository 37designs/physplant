<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Shop
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Technician[] $technician
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @method static \Illuminate\Database\Query\Builder|\App\Shop whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Shop whereName($value)
 */
class Shop extends Model
{
	public $timestamps = false;

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function technician()
	{
		return $this->hasMany('App\Technician');
	}
}
