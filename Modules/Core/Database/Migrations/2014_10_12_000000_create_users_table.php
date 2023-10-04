<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		\DB::statement('CREATE SCHEMA core AUTHORIZATION '.env('DB_USERNAME').' ;');

        Schema::create('core.users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username')->unique();
            $table->string('email');
			$table->string('password');
			$table->string('nome');
			$table->string('cpf')->nullable();
			$table->string('status')->default(1);
			$table->boolean('is_admin')->default(false);
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('core.users');
        \DB::statement('DROP SCHEMA core;');
    }
}
