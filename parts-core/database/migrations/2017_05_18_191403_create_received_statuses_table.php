<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceivedStatusesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('received_statuses', function (Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->text('description');
		});

		DB::table('received_statuses')->insert([
				['name' => 'Not Ordered', 'description' => 'Part not ordered.'],
				['name' => 'Ordered', 'description' => 'Part has been ordered.'],
				['name' => 'Received', 'description' => 'Part received.'],
				['name' => 'Partial', 'description' => 'Part partially received.'],
				['name' => 'Returned', 'description' => 'Part was returned.'],
				['name' => 'Rejected', 'description' => 'Part was Rejected.'],
				['name' => 'Completed', 'description' => 'Part was given to the technician.']
		]);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('received_statuses');
	}
}
