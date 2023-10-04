<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAtributesPlanoConta extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('financeiro.plano_contas', function (Blueprint $table) {
            $table->boolean('contabil')->nullable();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('financeiro.plano_contas', function (Blueprint $table) {
            $table->removeColumn('contabil');
        });

    }

}
