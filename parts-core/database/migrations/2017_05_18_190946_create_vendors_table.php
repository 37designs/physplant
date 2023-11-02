<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('vendors', function (Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('website')->nullable();
			$table->string('email')->nullable();
			$table->string('phone_number')->nullable();
		});

		DB::table('vendors')->insert([
				['name' => 'Grainger'],
				['name' => 'Trane'],
				['name' => 'ABC Co.'],
				['name' => 'Home Depot'],
				['name' => 'Office Max'],
		]);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('vendors');
	}
}
