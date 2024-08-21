<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateStagesTable extends Migration {

	public function up()
	{
		Schema::create('Stages', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name');
			$table->integer('grade_id')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('Stages');
	}
}