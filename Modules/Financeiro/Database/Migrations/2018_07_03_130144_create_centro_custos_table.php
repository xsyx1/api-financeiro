<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCentroCustosTable extends Migration
{
	use \Modules\Core\Traits\FiliaisMigrationTrait;
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('financeiro.centro_custos', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('parent_id')->unsigned()->nullable()->index();
			$table->foreign('parent_id')->references('id')->on('financeiro.centro_custos');
            $table->string('nome');
			$table->boolean('status')->deafult(true);
			$table->string('tipo')->nullable()->description('0 - crédito / 1 - débito');
			$table->string('codigo')->nullable()->description('codigo utilizado pela contabilidade');
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
        Schema::dropIfExists('financeiro.centro_custos');
    }
}
