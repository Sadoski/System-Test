<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies_types', function (Blueprint $table) {
            $table->id('id_company_type')->comment('Index da tabela tipo da empresa');
            $table->STRING('company_type')->comment('Descrição do tipo da empresa');
            $table->timestamp('created_at')->useCurrent()->comment('Data e hora da criação do registro');
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable()->comment('Data e hora da atualização do registro');
            $table->bigInteger('user_created_companies_types_id')->unsigned()->nullable()->comment('Index do usuário que criou o registro');
        });

        Schema::table('companies_types', function ($table) {
            $table->foreign('user_created_companies_types_id')->references('id_user')->on('users')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies_types');
    }
}
