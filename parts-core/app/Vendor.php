<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Vendor
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Part[] $parts
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property string $website
 * @property string $email
 * @property string $phone_number
 * @method static \Illuminate\Database\Query\Builder|\App\Vendor whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Vendor whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Vendor whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Vendor wherePhoneNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Vendor whereWebsite($value)
 */
class Vendor extends Model
{
	public $timestamps = false;

	/**
	 *  Gets a vendor by name
	 *
	 * @param $name
	 * @return Vendor|mixed
	 */
	public static function getVendorByName($name)
	{
		$vendor = Vendor::where('name', 'like', $name)->first(); /*removed ,'like' */
		var_dump($vendor);

		if ($vendor === null)
		{
			$vendor = new Vendor();
			$vendor->name = strtolower($name);
			$vendor->save();
		}
		
		return $vendor;
		
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function parts()
	{
		return $this->belongsToMany('App\Part');
	}
}
