<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableCentroCustoTipoForString extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('financeiro.centro_custos', function (Blueprint $table) {
            $table->string('tipo')->description('0 - crédito / 1 - débito')->change();    
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
