<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id('id_company')->comment('Index do registro da empresa');
            $table->bigInteger('company_type_id')->unsigned()->comment('Index do registro do tipo da empresa');
            $table->bigInteger('parent_company_id')->unsigned()->nullable()->comment('Index do registro da empresa matriz');
            $table->string('name', 150)->comment('Nome da empresa');
            $table->string('trading_name', 150)->comment('Nome fantasia da empresa');
            $table->string('cnpj', 20)->unique()->comment('Número do CNPJ');
            $table->string('address', 45)->comment('Endereço da empresa');
            $table->string('city', 45)->comment('Cidade da empresa');
            $table->string('state', 45)->comment('Estado da cidade');
            $table->string('email', 45)->nullable()->comment('Endereço de e-mail');
            $table->double('latitude', 10, 8)->nullable()->comment('Dados da latitude da localização da empresa');
            $table->double('longitude', 11, 8)->nullable()->comment('Dados da longitude da localização da empresa');
            $table->timestamp('created_at')->useCurrent()->comment('Data e hora da criação do registro');
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable()->comment('Data e hora da atualização do registro');
            $table->bigInteger('user_created_company_id')->unsigned()->nullable()->comment('Index do usuário que criou o registro');
        });

        Schema::table('companies', function ($table) {
            $table->foreign('company_type_id')->references('id_company_type')->on('companies_types')->onDelete('RESTRICT');
            $table->foreign('parent_company_id')->references('id_company')->on('companies')->onDelete('RESTRICT');
            $table->foreign('user_created_company_id')->references('id_user')->on('users')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies');
    }
}
