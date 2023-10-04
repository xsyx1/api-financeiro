<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEnderecosTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('localidade.enderecos', function(Blueprint $table) {
            $table->increments('id');
			$table->string('logradouro', 200);
            $table->string('cep', 20);
            $table->string('numero', 10)->nullable();
            $table->string('complemento', 200)->nullable();
            $table->integer('tipo_endereco')->nullable()->default(0);
			$table->integer('cidade_id')->unsigned();
			$table->foreign('cidade_id')->references('id')->on('localidade.cidades');
			$table->integer('bairro_id')->unsigned()->nullable();
			$table->foreign('bairro_id')->references('id')->on('localidade.bairros');
			$table->integer('enderecotable_id')->nullable();
			$table->string('enderecotable_type')->nullable();
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
		Schema::drop('localidade.enderecos');
	}

}
