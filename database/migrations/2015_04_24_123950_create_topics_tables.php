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
			$table->text('description')->nullable();
			$table->integer('parent_id')->unsigned()->nullable();
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
			['name' => "Nova", 'slug' => "nova-general", 'color' => "#259b24", 'description' => ""],
			['name' => "Anodyne Lounge", 'slug' => "", 'color' => "#607d8b", 'description' => ""],
			['name' => "AnodyneXtras", 'slug' => "xtras", 'color' => "#d81b60", 'description' => ""],
			['name' => "Help Center", 'slug' => "", 'color' => "#0288d1", 'description' => ""],
			
			['name' => "Article Discussions", 'slug' => "help-center-articles", 'color' => "#0288d1", 'description' => "", 'parent_id' => 4],
			['name' => "Announcements", 'slug' => "", 'color' => "#607d8b", 'description' => "", 'parent_id' => 2],
			['name' => "Help", 'slug' => "nova-help", 'color' => "#259b24", 'description' => "", 'parent_id' => 1],
			['name' => "Skinning", 'slug' => "nova-skinning", 'color' => "#259b24", 'description' => "", 'parent_id' => 1],
		];

		foreach ($data as $d)
		{
			Topic::create($d);
		}
	}

}
