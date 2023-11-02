<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Technician
 *
 * @property int $id
 * @property int $shop_id
 * @property string $name
 * @property string $email
 * @property string $phone_number
 * @property bool $active
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Comment[] $comments
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Request[] $request
 * @property-read \App\Shop $shop
 * @method static \Illuminate\Database\Query\Builder|\App\Technician whereActive($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Technician whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Technician whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Technician whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Technician whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Technician wherePhoneNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Technician whereShopId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Technician whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Technician extends Model
{
	protected $fillable = array('name', 'email', 'shop_id', 'active');

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function shop()
	{
		return $this->belongsTo('App\Shop');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function request()
	{
		return $this->hasMany('App\Request');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\MorphMany
	 */
	public function comments()
	{
		return $this->morphMany('App\Comment', 'commentable');
	}
}
