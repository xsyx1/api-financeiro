<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContaFinanceirosTable extends Migration
{
	use \Modules\Core\Traits\FiliaisMigrationTrait;
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('financeiro.conta_financeiros', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tipo_conta');
            $table->string('status');
            $table->string('nome');
            $table->double('saldo')->default(0);
            $table->double('limite')->default(false);
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
        Schema::dropIfExists('financeiro.conta_financeiros');
    }
}
