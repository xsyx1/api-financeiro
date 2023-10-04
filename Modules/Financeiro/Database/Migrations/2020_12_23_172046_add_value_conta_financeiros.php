<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddValueContaFinanceiros extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('financeiro.conta_financeiros', function (Blueprint $table) {
            $table->text('descricao')->nullable();
            $table->string('telefone_contato')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('financeiro.conta_financeiros', function (Blueprint $table) {
            $table->dropColumn('permitir_lanc_data_superior');
            $table->dropColumn('permitir_lanc_data_anterior');
            $table->dropColumn('telefone_contato');
            $table->dropColumn('descricao');
        });
    }
}
