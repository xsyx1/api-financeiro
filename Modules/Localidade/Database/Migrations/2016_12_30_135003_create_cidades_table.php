<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCidadesTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('localidade.cidades', function(Blueprint $table) {
            $table->increments('id');
			$table->integer('estado_id')->unsigned();
			$table->foreign('estado_id')->references('id')->on('localidade.estados');
            $table->string('nome');
            $table->integer('cod_ibje')->nullable();
            $table->boolean('capital')->nullable();
            $table->softDeletes();
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
		Schema::drop('cidades');
	}

}
