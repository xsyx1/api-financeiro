<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddValueInformacaoBancarias extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('financeiro.informacao_bancarias', function (Blueprint $table) {
            $table->string('digito_agencia');
            $table->string('digito_conta');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('financeiro.informacao_bancarias', function (Blueprint $table) {
            $table->dropColumn('digito_agencia');
            $table->dropColumn('digito_conta');
        });
    }
}
