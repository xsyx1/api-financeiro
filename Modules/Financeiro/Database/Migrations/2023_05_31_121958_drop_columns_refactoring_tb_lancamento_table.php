<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('financeiro.lancamento_financeiros', function (Blueprint $table) {
            $table->dropColumn(['bloqueado']);
            $table->dropColumn(['agrupados']);
            $table->dropForeign(['centro_custo_id']);
            $table->dropColumn(['centro_custo_id']);
            $table->dropForeign(['fornecedor_id']);
            $table->dropColumn(['fornecedor_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
