<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Query\Expression;

class CreateForums extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('topics', function(Blueprint $table)
		{
			$table->increments('id');
			$table->unsignedBigInteger('user_id');
			$table->string('title');
			$table->string('slug');
			$table->text('description')->nullable();
			$table->timestamps();
			$table->softDeletes();
		});

		Schema::create('conversations', function(Blueprint $table)
		{
			$table->bigIncrements('id');
			$table->unsignedInteger('topic_id');
			$table->unsignedBigInteger('user_id');
			$table->string('title');
			$table->string('slug');
			$table->integer('replies')->unsigned()->default(0);
			$table->timestamps();
			$table->softDeletes();

			$table->foreign('topic_id')->references('id')->on('topics');
		});

		Schema::create('conversation_states', function(Blueprint $table)
		{
			$table->bigIncrements('id');
			$table->unsignedBigInteger('conversation_id');
			$table->unsignedBigInteger('user_id');
			$table->datetime('last_visited_at');

			$table->foreign('conversation_id')->references('id')->on('conversations');
		});

		Schema::create('replies', function(Blueprint $table)
		{
			$table->bigIncrements('id');
			$table->unsignedBigInteger('conversation_id');
			$table->unsignedBigInteger('user_id');
			$table->text('content');
			$table->boolean('accepted_answer')->default((int) false);
			$table->timestamps();
			$table->softDeletes();

			$table->foreign('conversation_id')->references('id')->on('conversations');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('conversations', function(Blueprint $table)
		{
			$table->dropForeign('conversations_topic_id_foreign');
		});

		Schema::table('conversation_states', function(Blueprint $table)
		{
			$table->dropForeign('conversation_states_conversation_id_foreign');
		});

		Schema::table('replies', function(Blueprint $table)
		{
			$table->dropForeign('replies_conversation_id_foreign');
		});

		Schema::dropIfExists('topics');
		Schema::dropIfExists('conversations');
		Schema::dropIfExists('conversation_states');
		Schema::dropIfExists('replies');
	}

}
