<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocalidadesTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('localidades', function(Blueprint $table) {
            $table->increments('id');
            $table->string('cep');
            $table->integer('estado_id')->unsigned()->nullable()->index();
            $table->foreign('estado_id')->references('id')->on('estados');
            $table->integer('cidade_id')->unsigned()->nullable()->index();
            $table->foreign('cidade_id')->references('id')->on('cidades');
            $table->string('logradouro');
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
		Schema::drop('localidades');
	}

}
