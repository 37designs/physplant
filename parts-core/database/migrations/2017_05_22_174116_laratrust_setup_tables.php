<?php

use App\Permission\Permissions;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class LaratrustSetupTables extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return  void
	 */
	public function up()
	{
		// Create table for storing roles
		Schema::create('roles', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->string('display_name')->nullable();
			$table->string('description')->nullable();
			$table->timestamps();
		});

		// Create table for associating roles to users (Many-to-Many)
		Schema::create('role_user', function (Blueprint $table) {
			$table->integer('user_id')->unsigned();
			$table->integer('role_id')->unsigned();
			$table->string('user_type');

			$table->foreign('user_id')->references('id')->on('users')
					->onUpdate('cascade')->onDelete('cascade');
			$table->foreign('role_id')->references('id')->on('roles')
					->onUpdate('cascade')->onDelete('cascade');

			$table->primary(['user_id', 'role_id']);
		});

		// Create table for storing permissions
		Schema::create('permissions', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name')->unique();
			$table->string('display_name')->nullable();
			$table->string('description')->nullable();
			$table->timestamps();
		});

		// Create table for associating permissions to roles (Many-to-Many)
		Schema::create('permission_role', function (Blueprint $table) {
			$table->integer('permission_id')->unsigned();
			$table->integer('role_id')->unsigned();

			$table->foreign('permission_id')->references('id')->on('permissions')
					->onUpdate('cascade')->onDelete('cascade');
			$table->foreign('role_id')->references('id')->on('roles')
					->onUpdate('cascade')->onDelete('cascade');

			$table->primary(['permission_id', 'role_id']);
		});

		// Create table for associating permissions to users (Many-to-Many)
		Schema::create('permission_user', function (Blueprint $table) {
			$table->integer('permission_id')->unsigned();
			$table->integer('user_id')->unsigned();
			$table->string('user_type');

			$table->foreign('permission_id')->references('id')->on('permissions')
					->onUpdate('cascade')->onDelete('cascade');
			$table->foreign('user_id')->references('id')->on('users')
					->onUpdate('cascade')->onDelete('cascade');

			$table->primary(['permission_id', 'user_id']);
		});

		Permissions::GeneratePermissions();
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return  void
	 */
	public function down()
	{
		Schema::dropIfExists('permission_user');
		Schema::dropIfExists('permission_role');
		Schema::dropIfExists('permissions');
		Schema::dropIfExists('role_user');
		Schema::dropIfExists('roles');
	}
}
