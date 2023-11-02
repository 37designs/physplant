<?php
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App{
/**
 * App\ApprovalStatus
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Part[] $parts
 */
	class ApprovalStatus extends \Eloquent {}
}

namespace App{
/**
 * App\Comment
 *
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $commentable
 * @property-read \App\Request $request
 * @property-read \App\User $user
 */
	class Comment extends \Eloquent {}
}

namespace App{
/**
 * App\Part
 *
 * @property-read \App\ApprovalStatus $approvalStatus
 * @property-read \App\User $observer
 * @property-read \App\ReceivedStatus $receivedStatus
 * @property-read \App\Request $request
 * @property-read \App\Vendor $vendor
 */
	class Part extends \Eloquent {}
}

namespace App{
/**
 * App\Permission
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Role[] $roles
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $users
 */
	class Permission extends \Eloquent {}
}

namespace App{
/**
 * App\ReceivedStatus
 *
 */
	class ReceivedStatus extends \Eloquent {}
}

namespace App{
/**
 * App\Request
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Comment[] $comments
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Part[] $parts
 * @property-read \App\Technician $technician
 */
	class Request extends \Eloquent {}
}

namespace App{
/**
 * App\Role
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Permission[] $permissions
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $users
 */
	class Role extends \Eloquent {}
}

namespace App{
/**
 * App\Shop
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Technician[] $technician
 */
	class Shop extends \Eloquent {}
}

namespace App{
/**
 * App\Technician
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Comment[] $comments
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Request[] $request
 * @property-read \App\Shop $shop
 */
	class Technician extends \Eloquent {}
}

namespace App{
/**
 * App\User
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Comment[] $comments
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Part[] $parts
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Permission[] $permissions
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Role[] $roles
 * @property-read \App\Shop $shop
 * @method static \Illuminate\Database\Query\Builder|\App\User whereRoleIs($role = '')
 */
	class User extends \Eloquent {}
}

namespace App{
/**
 * App\Vendor
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Part[] $parts
 */
	class Vendor extends \Eloquent {}
}

