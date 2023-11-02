<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\ReceivedStatus
 *
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property string $description
 * @method static \Illuminate\Database\Query\Builder|\App\ReceivedStatus whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ReceivedStatus whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ReceivedStatus whereName($value)
 */
class ReceivedStatus extends Model
{
	public $timestamps = false;
}
