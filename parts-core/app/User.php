<?php

namespace App;

use App\Permission\Permissions;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\LaratrustUserTrait;

/**
 * App\User
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Comment[]                                                   $comments
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Part[]                                                      $parts
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Permission[]                                                $permissions
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Role[]                                                      $roles
 * @property-read \App\Shop                                                                                                 $shop
 * @method static \Illuminate\Database\Query\Builder|\App\User whereRoleIs($role = '')
 * @mixin \Eloquent
 * @property int                                                                                                            $id
 * @property int                                                                                                            $shop_id
 * @property string                                                                                                         $username
 * @property string                                                                                                         $name
 * @property string                                                                                                         $eid
 * @property string                                                                                                         $remember_token
 * @property \Carbon\Carbon                                                                                                 $created_at
 * @property \Carbon\Carbon                                                                                                 $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereEid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereShopId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereUsername($value)
 */
class User extends Authenticatable
{
	use LaratrustUserTrait;
	use Notifiable;

	/**
	 * The attributes that are not mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = [
			'id',
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
			'remember_token',
	];

	/**
	 * Create a new user
	 *
	 * @param string $username
	 * @param string $name
	 * @param string $eid
	 * @param string $role Constant from Permissions class
	 *
	 * @return User
	 */
	public static function create($username, $name = null, $eid = null, $role = Permissions::R_New)
	{
		$user = new self();
		$user->username = $username;
		$user->name = $name ?: random_int(0, 9999999);
		$user->eid = $eid ?: random_int(0, 9999999);
		$user->save();
		$user->attachRole($role);

		return $user;
	}


	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function shop()
	{
		return $this->belongsTo('App\Shop');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\MorphMany
	 */
	public function comments()
	{
		return $this->morphMany('App\Comment', 'commentable');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function parts()
	{
		return $this->hasMany('App\Part');
	}

	/**
	 * Get the email of the user
	 *
	 * @return string
	 */
	public function email()
	{
		return $this->username . '@emich.edu';
	}

	/**
	 * Update a user's name and EID.
	 *
	 * @param $name
	 * @param $eid
	 *
	 * @return User
	 */
	public function updateInfo($name, $eid)
	{

		if ($this->eid != $eid || $this->name != $name)
		{
			$this->name = $name;
			$this->eid = $eid;
			$this->save();
		}

		return $this;
	}


}
