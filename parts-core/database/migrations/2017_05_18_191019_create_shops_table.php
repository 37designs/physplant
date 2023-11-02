<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('shops', function (Blueprint $table)
		{
			$table->increments('id');

			$table->string('name');
		});

		DB::table('shops')->insert([
				['name' => 'HVAC-Plumbing'],
				['name' => 'Heating Plant'],
				['name' => 'Heating'],
				['name' => 'Electrical'],
				['name' => 'Carpentry'],
		]);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('shops');
	}
}
