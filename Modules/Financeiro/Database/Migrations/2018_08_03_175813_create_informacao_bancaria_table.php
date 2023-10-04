<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInformacaoBancariaTable extends Migration
{
	use \Modules\Core\Traits\FiliaisMigrationTrait;
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('financeiro.informacao_bancarias', function (Blueprint $table) {
            $table->increments('id');
			$table->string('variacao')->nullable();
			$table->string('nome_gerente')->nullable();
			$table->string('telefone_contato')->nullable();
			$table->string('descricao')->nullable();
			$table->integer('banco')->nullable();
			$table->string('agencia')->nullable();
			$table->string('conta')->nullable();
			$table->string('numero_cartao')->nullable();
			$table->integer('conta_financeiro_id')->unsigned()->nullable()->index();
			$table->foreign('conta_financeiro_id')->references('id')->on('financeiro.conta_financeiros');
			self::insertFilialForeng($table);
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
        Schema::dropIfExists('financeiro.informacao_bancarias');
    }
}
