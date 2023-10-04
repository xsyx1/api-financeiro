<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		\DB::statement('CREATE SCHEMA localidade AUTHORIZATION '.env('DB_USERNAME').' ;');
		Schema::create('localidade.estados', function(Blueprint $table) {
			$table->increments('id');
			$table->string('nome');
			$table->string('uf');
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
        Schema::dropIfExists('localidade.estados');
        \DB::statement('DROP SCHEMA localidade;');
    }
}
