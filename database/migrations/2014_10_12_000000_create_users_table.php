<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id("id_user")->comment('Index do registro do usuário');
            $table->string('name')->comment('Nome do usuário');
            $table->string('email')->unique()->comment('Endereço de e-mail');
            $table->timestamp('email_verified_at')->nullable()->comment('Data e hora da verificação de e-mail');
            $table->string('password')->comment('Senha de autebnticação');
            $table->enum('status',['ATIVO','INATIVO'])->comment('Status do usuário');
            $table->enum('profile',['ADMINISTRADOR','USUARIO'])->comment('Permissão do usuário');
            $table->rememberToken()->comment('Token para relembrar');
            $table->timestamp('created_at')->useCurrent()->comment('Data e hora da criação do registro');
            $table->timestamp('updated_at')->useCurrentOnUpdate()->comment('Data e hora da atualizção do registro');
            $table->bigInteger('user_created_user_id')->unsigned()->nullable()->comment('Index do usuário que criou o registro');
        });

        Schema::table('users', function ($table) {
            $table->foreign('user_created_user_id')->references('id_user')->on('users')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
