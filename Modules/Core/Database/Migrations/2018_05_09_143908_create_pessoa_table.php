<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePessoaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('core.pessoas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
			$table->string('email')->nullable();
			$table->string('cpf_cnpj')->nullable()->unique();
			$table->integer('estado_civil')->nullable();
			$table->integer('regime_uniao')->nullable();
			$table->timestamp('data_nascimento')->nullable();
			$table->integer('sexo')->nullable();
			$table->string('filiacao_mae')->nullable();
			$table->string('razao_social')->nullable();
			$table->string('inscricao_municipal')->nullable();
			$table->string('inscricao_estadual')->nullable();
			$table->timestamp('data_fundacao')->nullable();
			$table->string('descricao')->nullable();			
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
        Schema::dropIfExists('core.pessoas');
    }
}
