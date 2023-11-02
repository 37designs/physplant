<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApprovalStatusesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('approval_statuses', function (Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->text('description');
		});

		DB::table('approval_statuses')->insert([
				['name' => 'Awaiting', 'description' => 'Part is waiting to be approved or denied.'],
				['name' => 'Approved', 'description' => 'Part is approved.'],
				['name' => 'Denied', 'description' => 'Part is denied.']
		]);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('approval_statuses');
	}
}
