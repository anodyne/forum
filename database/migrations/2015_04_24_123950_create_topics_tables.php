<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTopicsTables extends Migration {

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
			$table->string('name');
			$table->string('slug');
			$table->string('color');
			$table->string('icon');
			$table->text('description')->nullable();
			$table->timestamps();
			$table->softDeletes();
		});

		$this->populateData();
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('topics');
	}

	protected function populateData()
	{
		$data = [
			['name' => "General", 'slug' => "", 'color' => "#607d8b", 'icon' => ""],
			['name' => "Nova", 'slug' => "", 'color' => "#259b24", 'icon' => ""],
			['name' => "Announcements", 'slug' => "", 'color' => "#0288d1", 'icon' => ""],
		];

		foreach ($data as $d)
		{
			Topic::create($d);
		}
	}

}
