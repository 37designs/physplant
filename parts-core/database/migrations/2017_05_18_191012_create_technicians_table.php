<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTechniciansTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('technicians', function (Blueprint $table) {
			$table->increments('id');

			// Has
			$table->integer('shop_id')->unsigned();

			$table->string('name');
			$table->string('email');
			$table->boolean('active');
			$table->timestamps();
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('technicians');
	}
}
