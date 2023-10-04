<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAtributesCentroCusto extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('financeiro.centro_custos', function (Blueprint $table) {
            $table->removeColumn('parent_id');
            $table->removeColumn('tipo');
            $table->removeColumn('recebe_lancamento');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('financeiro.centro_custos', function (Blueprint $table) {
        });
    }
}
