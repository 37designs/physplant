<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
	static $password;

	return [
			'username' => $faker->userName,
			'name' => $faker->name,
			'eid' => $faker->numberBetween(10000, 999999),
			'remember_token' => str_random(10),
	];
});

$factory->define(App\Request::class, function (Faker\Generator $faker) {
	return [
			'technician_id' => function () {
				return factory(App\Technician::class)->create()->id;
			},

			'work_order' => $faker->text(9),
	];
});

$factory->define(App\Comment::class, function (Faker\Generator $faker) {
	return [
			'request_id' => function () {
				return factory(App\Request::class)->create()->id;
			},
			'commentable_id' => function () {
				return factory(App\User::class)->create()->id;
			},
			'commentable_type' => 'App\User',

			'comment' => $faker->text(),
	];
});

$factory->define(App\Vendor::class, function (Faker\Generator $faker) {
	return [
			'name' => $faker->company,
			'website' => $faker->domainName,
			'email' => $faker->companyEmail,
			'phone_number' => $faker->phoneNumber,
	];
});

$factory->define(App\Technician::class, function (Faker\Generator $faker) {
	return [
			'shop_id' => function () {
				return factory(App\Shop::class)->create()->id;
			},

			'name' => $faker->name,
			'email' => $faker->email,
			'active' => $faker->boolean(),
	];
});

$factory->define(App\Shop::class, function (Faker\Generator $faker) {
	return [
			'name' => $faker->company,
	];
});

$factory->define(App\ReceivedStatus::class, function (Faker\Generator $faker) {
	return [
			'name' => $faker->name,
			'description' => $faker->text(),
	];
});

$factory->define(App\ApprovalStatus::class, function (Faker\Generator $faker) {
	return [
			'name' => $faker->name,
			'description' => $faker->text(),
	];
});

$factory->define(App\Part::class, function (Faker\Generator $faker) {
	return [
			'vendor_id' => function () {
				return factory(App\Vendor::class)->create()->id;
			},
			'received_status_id' => function () {
				return factory(App\ReceivedStatus::class)->create()->id;
			},
			'approval_status_id' => function () {
				return factory(App\ApprovalStatus::class)->create()->id;
			},
			'user_id' => function () {
				return factory(App\User::class)->create()->id;
			},
			'request_id' => function () {
				return factory(App\Request::class)->create()->id;
			},

			'request_quantity' => $faker->numberBetween(0, 20),
			'final_quantity' => $faker->numberBetween(0, 20),
			'approval_date' => $faker->time(),
			'part_number' => $faker->numberBetween(10000, 999999),
			'expedite' => $faker->boolean(),
			'asked_for_expedite' => $faker->boolean(),
			'description' => $faker->text(),
			'ordered_date' => $faker->time(),
			'returned_date' => $faker->time(),
			'received_date' => $faker->time(),
			'completed_date' => $faker->time(),
			'eta' => $faker->time(),
	];
});