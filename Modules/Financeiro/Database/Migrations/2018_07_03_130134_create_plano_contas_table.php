<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlanoContasTable extends Migration
{
	use \Modules\Core\Traits\FiliaisMigrationTrait;
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('financeiro.plano_contas', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('parent_id')->unsigned()->nullable()->index();
			$table->foreign('parent_id')->references('id')->on('financeiro.plano_contas');
			$table->string('nome');
			$table->boolean('status')->deafult(true);
			$table->string('tipo')->description('0 - crédito / 1 - débito');
			$table->string('codigo')->description('codigo utilizado pela contabilidade');
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
        Schema::dropIfExists('financeiro.plano_contas');
    }
}
