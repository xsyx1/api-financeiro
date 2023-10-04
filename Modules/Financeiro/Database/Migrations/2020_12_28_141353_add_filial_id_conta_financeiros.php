<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFilialIdContaFinanceiros extends Migration
{

    use \Modules\Core\Traits\FiliaisMigrationTrait;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('financeiro.conta_financeiros', function (Blueprint $table) {
            self::insertFilialForeng($table);
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
            $table->dropColumn('filial_id');
        });
    }
}
