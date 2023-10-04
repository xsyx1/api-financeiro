<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFiliaisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('core.filiais', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome_conta')->unique();
			$table->integer('pessoa_id')->unsigned()->nullable()->index();
			$table->foreign('pessoa_id')->references('id')->on('core.pessoas')->onDelete('cascade');
			/*valido apenas para parametos do saude*/
			$table->double('valor_repasse')->default(0)->nullable();
			$table->double('dia_reapasse')->nullable();
			$table->double('dia_recebimento_cartao')->default(0)->nullable();
			$table->boolean('cobra_convenio')->default(true)->nullable();
			$table->boolean('cobra_particular')->default(true)->nullable();
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
        Schema::dropIfExists('core.filiais');
    }
}
