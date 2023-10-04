<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTelefonesTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('telefones', function(Blueprint $table) {
            $table->increments('id');
            $table->string('ddd');
            $table->string('numero');
            $table->boolean('principal')->default(true);
            $table->integer('telefonetable_id');
            $table->string('telefonetable_type');
            $table->enum('tipo', ['fixo', 'celular', 'fax']);
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
		Schema::drop('telefones');
	}

}
