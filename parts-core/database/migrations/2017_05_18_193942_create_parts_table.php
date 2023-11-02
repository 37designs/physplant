<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('parts', function (Blueprint $table) {
			$table->increments('id');

			// Has
			$table->integer('vendor_id')->unsigned();
			$table->integer('received_status_id')->unsigned();
			$table->integer('approval_status_id')->unsigned();

			// Belongs
			$table->integer('user_id')->unsigned()->nullable(); // Approver
			$table->integer('request_id')->unsigned();

			$table->integer('request_quantity');
			$table->integer('final_quantity')->default(0);
			$table->timestamp('approval_date')->nullable();
			$table->string('part_number');
			$table->boolean('expedite')->default(false);
			$table->boolean('asked_for_expedite');
			$table->text('description');
			$table->integer('received_key')->unsigned()->nullable(); // Part Key
			$table->integer('user_signature')->unsigned()->nullable(); // Signature

			$table->timestamp('ordered_date')->nullable();
			$table->timestamp('returned_date')->nullable();
			$table->timestamp('received_date')->nullable();
			$table->timestamp('completed_date')->nullable();
			$table->timestamp('eta')->nullable();

			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('parts');
	}
}
