<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterNumeroToEnderecosTable extends Migration
{

    public function up()
    {
        Schema::table('localidade.enderecos', function (Blueprint $table) {
            $table->string('numero',255)->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('localidade.enderecos', function (Blueprint $table) {
            $table->string('numero',10)->nullable()->change();
        });
    }

}
