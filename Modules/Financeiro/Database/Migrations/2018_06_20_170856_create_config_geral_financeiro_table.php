<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateConfigGeralFinanceiroTable extends Migration
{
	use \Modules\Core\Traits\FiliaisMigrationTrait;
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		DB::statement('CREATE SCHEMA financeiro AUTHORIZATION '.env('DB_USERNAME').' ;');
        Schema::create('financeiro.config_geral_financeiros', function (Blueprint $table) {
            $table->increments('id');
			$table->string('data_base');
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
        Schema::dropIfExists('financeiro.config_geral_financeiros');
        DB::statement('DROP SCHEMA financeiro;');
    }
}
