<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConversationsTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('conversations', function(Blueprint $table)
		{
			$table->bigIncrements('id');
			$table->integer('topic_id')->unsigned();
			$table->integer('user_id')->unsigned();
			$table->string('title');
			$table->string('slug');
			$table->bigInteger('answer_id')->unsigned();
			$table->timestamps();
			$table->softDeletes();
		});

		Schema::create('conversations_states', function(Blueprint $table)
		{
			$table->bigIncrements('id');
			$table->bigInteger('conversation_id')->unsigned();
			$table->integer('user_id')->unsigned();
			$table->datetime('last_visited');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('conversations');
		Schema::dropIfExists('conversations_states');
	}

}
