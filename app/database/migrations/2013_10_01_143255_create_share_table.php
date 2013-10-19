<?php

use Illuminate\Database\Migrations\Migration;

class CreateShareTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('shares', function($t)
		{
			$t->increments('id');
			$t->unsignedInteger('user_id');
			$t->foreign('user_id')->references('id')->on('users')->on_delete('cascade');
			$t->string('share_id')->unique();
			$t->text('path');
			$t->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('shares');
	}

}