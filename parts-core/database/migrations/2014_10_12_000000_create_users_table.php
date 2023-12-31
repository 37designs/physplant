<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function (Blueprint $table)
		{
			$table->increments('id');

			$table->integer('shop_id')->unsigned()->nullable();

			$table->string('username')->unique();
			$table->string('name');
			$table->string('eid')->unique();
			$table->unsignedBigInteger('tech_id')
			$table->rememberToken();
			$table->timestamps();

		});

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('users');
	}
}
